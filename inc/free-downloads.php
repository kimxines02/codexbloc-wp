<?php
/**
 * Free downloads (account required).
 *
 * A product is free when it is a simple product priced 0 (or with no price
 * and a WordPress.org link / downloadable file). Free products show "Free" and
 * a "Free download" button instead of add to cart.
 *
 * Flow:
 * 1. Logged-out visitors are sent to My Account to log in or register, then
 *    brought straight back to their download.
 * 2. Logged-in customers get the product's WooCommerce download file. The
 *    first time, a ₱0 completed order is created so the file is served through
 *    WooCommerce's protected download link and listed under My Account >
 *    Downloads. Later clicks reuse it.
 * 3. Products without a file but with a WordPress.org URL send logged-in
 *    customers to WordPress.org.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * True when the product is given away for free.
 *
 * @param WC_Product|false|null $product Product.
 */
function codexbloc_is_free_product( $product ) {
	if ( ! $product instanceof WC_Product || ! $product->is_type( 'simple' ) ) {
		return false;
	}
	$price = $product->get_price( 'edit' );
	if ( '' === $price ) {
		// No price set: only free if there is something to download.
		return '' !== codexbloc_product_field( $product->get_id(), 'wporg_url' ) || ( $product->is_downloadable() && $product->get_downloads() );
	}
	return 0.0 === (float) $price;
}

/**
 * URL of the "Free download" button.
 *
 * @param WC_Product $product Product.
 */
function codexbloc_free_download_url( $product ) {
	return add_query_arg( 'cb_download', $product->get_id(), home_url( '/' ) );
}

/**
 * Where a customer who already owns the free product should go:
 * the protected file link (one file) or My Account > Downloads (several).
 * Empty string when they do not have it yet.
 *
 * @param int        $user_id User ID.
 * @param WC_Product $product Product.
 */
function codexbloc_free_download_owned_url( $user_id, $product ) {
	$mine = array();
	foreach ( wc_get_customer_available_downloads( $user_id ) as $download ) {
		if ( (int) $download['product_id'] === $product->get_id() ) {
			$mine[] = $download;
		}
	}
	if ( ! $mine ) {
		return '';
	}
	return 1 === count( $mine ) ? $mine[0]['download_url'] : wc_get_account_endpoint_url( 'downloads' );
}

/**
 * Record a ₱0 completed order so WooCommerce grants download access.
 *
 * @param WP_User    $user    Customer.
 * @param WC_Product $product Product.
 * @return bool
 */
function codexbloc_grant_free_download( $user, $product ) {
	$order = wc_create_order(
		array(
			'customer_id' => $user->ID,
			'created_via' => 'codexbloc_free_download',
		)
	);
	if ( is_wp_error( $order ) ) {
		return false;
	}
	$order->add_product(
		$product,
		1,
		array(
			'subtotal' => 0,
			'total'    => 0,
		)
	);
	$order->set_billing_email( $user->user_email );
	$order->set_billing_first_name( $user->first_name );
	$order->set_billing_last_name( $user->last_name );
	$order->set_payment_method_title( __( 'Free download', 'codexbloc' ) );
	$order->calculate_totals( false );
	$order->save();
	$order->update_status( 'completed', __( 'Free download from the product page.', 'codexbloc' ) );
	wc_downloadable_product_permissions( $order->get_id() ); // No-op if the status change already granted it.
	return true;
}

/**
 * Handle clicks on "Free download" (?cb_download=ID).
 */
function codexbloc_handle_free_download() {
	if ( empty( $_GET['cb_download'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$product = wc_get_product( absint( $_GET['cb_download'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
	if ( ! codexbloc_is_free_product( $product ) || 'publish' !== $product->get_status() ) {
		wp_safe_redirect( codexbloc_shop_url() );
		exit;
	}
	nocache_headers();

	// 1. Account required.
	if ( ! is_user_logged_in() ) {
		wp_safe_redirect( add_query_arg( 'cb_free', $product->get_id(), wc_get_page_permalink( 'myaccount' ) ) );
		exit;
	}

	$user = wp_get_current_user();

	// 2. A file attached in WooCommerce.
	if ( $product->is_downloadable() && $product->get_downloads() ) {
		$url = codexbloc_free_download_owned_url( $user->ID, $product );
		if ( ! $url && codexbloc_grant_free_download( $user, $product ) ) {
			$url = codexbloc_free_download_owned_url( $user->ID, $product );
		}
		if ( $url ) {
			wp_safe_redirect( $url );
			exit;
		}
		wc_add_notice( __( 'Sorry, we could not prepare your download. Please contact us and we will send it to you.', 'codexbloc' ), 'error' );
		wp_safe_redirect( $product->get_permalink() );
		exit;
	}

	// 3. Hosted on WordPress.org.
	$wporg = codexbloc_product_field( $product->get_id(), 'wporg_url' );
	if ( $wporg ) {
		wp_redirect( esc_url_raw( $wporg ) ); // phpcs:ignore WordPress.Security.SafeRedirect -- link set by the shop owner.
		exit;
	}

	wc_add_notice( __( 'This download is not available yet. Please check back soon or contact us.', 'codexbloc' ), 'notice' );
	wp_safe_redirect( $product->get_permalink() );
	exit;
}
add_action( 'template_redirect', 'codexbloc_handle_free_download' );

/**
 * Free product requested from the My Account login/register page (?cb_free=ID), if any.
 *
 * @return WC_Product|null
 */
function codexbloc_requested_free_product() {
	// phpcs:disable WordPress.Security.NonceVerification
	$id = 0;
	if ( ! empty( $_POST['cb_free'] ) ) {
		$id = absint( $_POST['cb_free'] );
	} elseif ( ! empty( $_GET['cb_free'] ) ) {
		$id = absint( $_GET['cb_free'] );
	}
	// phpcs:enable
	$product = $id ? wc_get_product( $id ) : null;
	return codexbloc_is_free_product( $product ) ? $product : null;
}

// Explain why the login form is shown, and carry the product through the forms.
add_action(
	'woocommerce_before_customer_login_form',
	function () {
		$product = codexbloc_requested_free_product();
		if ( ! $product ) {
			return;
		}
		?>
		<div class="mb-8 flex items-start gap-3 rounded-2xl border border-accent/30 bg-accent-soft p-5 text-sm text-slate-700">
			<?php echo codexbloc_icon( 'download', 'mt-0.5 h-5 w-5 shrink-0 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<p class="m-0">
				<?php
				printf(
					/* translators: %s: product name. */
					esc_html__( 'Log in or create a free account to download %s. You will be taken straight to your download.', 'codexbloc' ),
					'<strong class="text-ink">' . esc_html( $product->get_name() ) . '</strong>'
				);
				?>
			</p>
		</div>
		<?php
	}
);

foreach ( array( 'woocommerce_login_form_end', 'woocommerce_register_form_end' ) as $codexbloc_hook ) {
	add_action(
		$codexbloc_hook,
		function () {
			$product = codexbloc_requested_free_product();
			if ( $product ) {
				echo '<input type="hidden" name="cb_free" value="' . esc_attr( $product->get_id() ) . '" />';
			}
		}
	);
}

// After logging in or registering, go straight to the download.
foreach ( array( 'woocommerce_login_redirect', 'woocommerce_registration_redirect' ) as $codexbloc_hook ) {
	add_filter(
		$codexbloc_hook,
		function ( $redirect ) {
			$product = codexbloc_requested_free_product();
			return $product ? codexbloc_free_download_url( $product ) : $redirect;
		},
		20
	);
}

// Download links only work for logged-in customers.
add_filter(
	'pre_option_woocommerce_downloads_require_login',
	function () {
		return 'yes';
	}
);

/*
 * Storefront: "Free" instead of a price, no add to cart, "Free download" buttons.
 */
add_filter(
	'woocommerce_is_purchasable',
	function ( $purchasable, $product ) {
		return ( ! is_admin() && codexbloc_is_free_product( $product ) ) ? false : $purchasable;
	},
	10,
	2
);

add_filter(
	'woocommerce_get_price_html',
	function ( $price, $product ) {
		if ( codexbloc_is_free_product( $product ) ) {
			return '<span class="woocommerce-Price-amount amount">' . esc_html__( 'Free', 'codexbloc' ) . '</span>';
		}
		return $price;
	},
	20,
	2
);

add_filter(
	'woocommerce_loop_add_to_cart_link',
	function ( $html, $product ) {
		if ( ! codexbloc_is_free_product( $product ) ) {
			return $html;
		}
		return sprintf(
			'<a href="%s" class="button" rel="nofollow">%s%s</a>',
			esc_url( codexbloc_free_download_url( $product ) ),
			codexbloc_icon( 'download', 'h-4 w-4' ), // phpcs:ignore WordPress.Security.EscapeOutput
			esc_html__( 'Free download', 'codexbloc' )
		);
	},
	10,
	2
);

/**
 * Single product: the download button and a short note about the account.
 */
function codexbloc_single_free_cta() {
	global $product;
	if ( ! codexbloc_is_free_product( $product ) ) {
		return;
	}
	$logged_in = is_user_logged_in();
	$owned     = $logged_in && $product->is_downloadable() && codexbloc_free_download_owned_url( get_current_user_id(), $product );

	if ( ! $logged_in ) {
		$note = __( 'Free account required. Log in, or sign up with just your email.', 'codexbloc' );
	} elseif ( $product->is_downloadable() && $product->get_downloads() ) {
		$note = __( 'Your free downloads are also saved in My account > Downloads.', 'codexbloc' );
	} else {
		$note = '';
	}
	?>
	<div class="my-6">
		<a class="btn btn-primary" href="<?php echo esc_url( codexbloc_free_download_url( $product ) ); ?>" rel="nofollow">
			<?php echo codexbloc_icon( 'download', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo $owned ? esc_html__( 'Download again', 'codexbloc' ) : esc_html__( 'Free download', 'codexbloc' ); ?>
		</a>
		<?php if ( $note ) : ?>
			<p class="mt-3 flex items-center gap-1.5 text-sm text-slate-500"><?php echo codexbloc_icon( 'user', 'h-4 w-4 shrink-0' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'codexbloc_single_free_cta', 30 );
