<?php
/**
 * My account.
 *
 * - Sidebar card: customer avatar, name and email above the navigation, with
 *   an icon per menu item (CSS masks built from the theme's icon set).
 * - Dashboard: welcome panel, quick stats, shortcut tiles and recent orders.
 * - Orders table: status shown as a coloured pill.
 *
 * Like inc/woocommerce.php, no WooCommerce template is overridden: everything
 * is done through hooks, so WooCommerce updates never flag outdated templates.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon for an account menu item. Plugin endpoints fall back to a generic icon.
 *
 * @param string $endpoint Menu item key.
 * @return string Icon name for codexbloc_icon().
 */
function codexbloc_account_icon( $endpoint ) {
	$map = array(
		'dashboard'       => 'grid',
		'orders'          => 'bag',
		'downloads'       => 'download',
		'edit-address'    => 'pin',
		'payment-methods' => 'card',
		'edit-account'    => 'user',
		'customer-logout' => 'logout',
	);
	if ( isset( $map[ $endpoint ] ) ) {
		return $map[ $endpoint ];
	}
	if ( false !== strpos( $endpoint, 'licen' ) || false !== strpos( $endpoint, 'key' ) ) {
		return 'key';
	}
	return 'cube';
}

/**
 * One-line description for the dashboard shortcut tiles.
 *
 * @param string $endpoint Menu item key.
 * @return string
 */
function codexbloc_account_description( $endpoint ) {
	$text = array(
		'orders'          => __( 'Order history, receipts and status.', 'codexbloc' ),
		'downloads'       => __( 'Get the latest files for your products.', 'codexbloc' ),
		'edit-address'    => __( 'Billing details used on your invoices.', 'codexbloc' ),
		'payment-methods' => __( 'Manage your saved payment methods.', 'codexbloc' ),
		'edit-account'    => __( 'Change your name, email and password.', 'codexbloc' ),
	);
	if ( isset( $text[ $endpoint ] ) ) {
		return $text[ $endpoint ];
	}
	if ( 'key' === codexbloc_account_icon( $endpoint ) ) {
		return __( 'View and manage your licence keys.', 'codexbloc' );
	}
	return '';
}

/**
 * SVG data URI for a CSS mask.
 *
 * @param string $name Icon name.
 * @return string
 */
function codexbloc_icon_data_uri( $name ) {
	$paths = codexbloc_icon_paths();
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	$svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='1.7' stroke-linecap='round' stroke-linejoin='round'><path d='" . $paths[ $name ] . "'/></svg>";
	return 'url("data:image/svg+xml,' . rawurlencode( $svg ) . '")';
}

/**
 * Menu icons and the password show/hide toggle, as CSS variables.
 * Generated from the same icon set the templates use, so any endpoint a
 * plugin adds (licences, subscriptions...) also gets an icon.
 */
function codexbloc_account_inline_css() {
	if ( ! function_exists( 'is_account_page' ) || ! ( is_account_page() || is_checkout() ) ) {
		return;
	}
	$css = '.show-password-input{--cb-icon:' . codexbloc_icon_data_uri( 'eye' ) . '}'
		. '.show-password-input.display-password{--cb-icon:' . codexbloc_icon_data_uri( 'eye-off' ) . '}';

	if ( is_user_logged_in() && is_account_page() ) {
		foreach ( array_keys( wc_get_account_menu_items() ) as $endpoint ) {
			$css .= '.woocommerce-MyAccount-navigation-link--' . sanitize_html_class( $endpoint )
				. '{--cb-icon:' . codexbloc_icon_data_uri( codexbloc_account_icon( $endpoint ) ) . '}';
		}
	}
	wp_add_inline_style( 'codexbloc', $css );
}
add_action( 'wp_enqueue_scripts', 'codexbloc_account_inline_css', 21 );

/**
 * Sidebar card: customer details above the navigation.
 */
add_action(
	'woocommerce_before_account_navigation',
	function () {
		$user = wp_get_current_user();
		echo '<aside class="cb-account-side">';
		if ( ! $user->exists() ) {
			return;
		}
		?>
		<div class="cb-account-user">
			<?php echo get_avatar( $user->ID, 88, '', '', array( 'class' => 'h-11 w-11 shrink-0 rounded-full bg-white ring-2 ring-white shadow-sm' ) ); ?>
			<div class="min-w-0">
				<p class="m-0 truncate text-[15px] font-semibold leading-tight text-ink"><?php echo esc_html( $user->display_name ); ?></p>
				<p class="m-0 mt-0.5 truncate text-[13px] text-slate-500"><?php echo esc_html( $user->user_email ); ?></p>
			</div>
		</div>
		<?php
	}
);
add_action(
	'woocommerce_after_account_navigation',
	function () {
		echo '</aside>';
	}
);

/**
 * Dashboard: replace the two plain paragraphs with a proper overview.
 * Endpoints (orders, downloads...) still go through WooCommerce as usual.
 */
add_action(
	'init',
	function () {
		remove_action( 'woocommerce_account_content', 'woocommerce_account_content', 10 );
		add_action( 'woocommerce_account_content', 'codexbloc_account_content', 10 );
	}
);

function codexbloc_account_content() {
	global $wp;
	foreach ( (array) $wp->query_vars as $key => $value ) {
		if ( 'pagename' !== $key && has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
			woocommerce_account_content();
			return;
		}
	}
	codexbloc_account_dashboard();
}

/**
 * Order status pill.
 *
 * @param WC_Order $order Order.
 * @return string
 */
function codexbloc_order_status_pill( $order ) {
	$status = $order->get_status();
	return sprintf(
		'<span class="cb-status cb-status--%s">%s</span>',
		esc_attr( sanitize_html_class( $status ) ),
		esc_html( wc_get_order_status_name( $status ) )
	);
}

add_action(
	'woocommerce_my_account_my_orders_column_order-status',
	function ( $order ) {
		echo codexbloc_order_status_pill( $order ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
);

/**
 * Dashboard markup.
 */
function codexbloc_account_dashboard() {
	$user  = wp_get_current_user();
	$items = wc_get_account_menu_items();
	$first = $user->first_name ? $user->first_name : $user->display_name;

	$orders = wc_get_orders(
		apply_filters(
			'woocommerce_my_account_my_orders_query',
			array(
				'customer' => $user->ID,
				'limit'    => 3,
				'page'     => 1,
				'paginate' => true,
			)
		)
	);
	$order_total    = is_object( $orders ) ? (int) $orders->total : 0;
	$recent         = is_object( $orders ) ? $orders->orders : array();
	$download_count = isset( $items['downloads'] ) && WC()->customer ? count( WC()->customer->get_downloadable_products() ) : null;
	$registered     = $user->user_registered ? date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ) : '';

	$stats = array();
	if ( isset( $items['orders'] ) ) {
		$stats[] = array( 'bag', __( 'Orders', 'codexbloc' ), number_format_i18n( $order_total ), wc_get_account_endpoint_url( 'orders' ) );
	}
	if ( null !== $download_count ) {
		$stats[] = array( 'download', __( 'Downloads', 'codexbloc' ), number_format_i18n( $download_count ), wc_get_account_endpoint_url( 'downloads' ) );
	}
	if ( $registered ) {
		$stats[] = array( 'calendar', __( 'Member since', 'codexbloc' ), $registered, '' );
	}

	$tiles = array_diff_key( $items, array_flip( array( 'dashboard', 'customer-logout' ) ) );
	?>
	<div class="space-y-8">

		<!-- Welcome -->
		<section class="cb-bento-visual relative overflow-hidden rounded-2xl border border-slate-200 p-6 sm:p-8">
			<div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
				<div>
					<p class="m-0 text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'Dashboard', 'codexbloc' ); ?></p>
					<h2 class="m-0 mt-2 text-2xl font-semibold tracking-tight text-ink sm:text-[28px]">
						<?php
						/* translators: %s: customer first name. */
						printf( esc_html__( 'Welcome back, %s', 'codexbloc' ), esc_html( $first ) );
						?>
					</h2>
					<p class="m-0 mt-2 max-w-lg text-[15px] leading-relaxed text-slate-600"><?php esc_html_e( 'Everything for your purchases in one place: orders, downloads, licence keys and account settings.', 'codexbloc' ); ?></p>
				</div>
				<div class="flex shrink-0 flex-wrap gap-2.5">
					<a class="btn btn-primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?></a>
					<a class="btn btn-outline" href="<?php echo esc_url( wc_logout_url() ); ?>"><?php esc_html_e( 'Log out', 'codexbloc' ); ?></a>
				</div>
			</div>
		</section>

		<?php if ( $stats ) : ?>
			<!-- Stats -->
			<dl class="m-0 grid gap-4 sm:grid-cols-3">
				<?php foreach ( $stats as $stat ) : ?>
					<div class="relative flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/[0.03]">
						<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $stat[0], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div class="min-w-0">
							<dt class="text-[13px] font-medium text-slate-500">
								<?php if ( $stat[3] ) : ?>
									<a class="text-inherit after:absolute after:inset-0 after:rounded-2xl hover:text-ink" href="<?php echo esc_url( $stat[3] ); ?>"><?php echo esc_html( $stat[1] ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $stat[1] ); ?>
								<?php endif; ?>
							</dt>
							<dd class="m-0 mt-0.5 truncate text-xl font-semibold tracking-tight text-ink"><?php echo esc_html( $stat[2] ); ?></dd>
						</div>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>

		<!-- Recent orders -->
		<?php if ( isset( $items['orders'] ) ) : ?>
			<section>
				<div class="mb-4 flex items-end justify-between gap-4">
					<h2 class="m-0 text-lg font-semibold text-ink"><?php esc_html_e( 'Recent orders', 'codexbloc' ); ?></h2>
					<?php if ( $order_total > count( $recent ) ) : ?>
						<a class="inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>"><?php esc_html_e( 'View all', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-3.5 w-3.5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<?php endif; ?>
				</div>

				<?php if ( $recent ) : ?>
					<ul class="m-0 list-none divide-y divide-slate-100 overflow-hidden rounded-2xl border border-slate-200 bg-white p-0 shadow-sm shadow-slate-900/[0.03]" role="list">
						<?php foreach ( $recent as $order ) : ?>
							<li class="relative m-0 flex flex-wrap items-center gap-x-6 gap-y-2 px-5 py-4 transition hover:bg-slate-50">
								<div class="min-w-0 flex-1">
									<a class="text-[15px] font-semibold text-ink after:absolute after:inset-0 hover:text-accent" href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
										<?php
										/* translators: %s: order number. */
										printf( esc_html__( 'Order #%s', 'codexbloc' ), esc_html( $order->get_order_number() ) );
										?>
									</a>
									<p class="m-0 mt-0.5 text-[13px] text-slate-500">
										<?php
										$count = $order->get_item_count();
										echo esc_html( $order->get_date_created() ? wc_format_datetime( $order->get_date_created() ) : '' );
										echo ' &middot; ';
										/* translators: %d: number of items. */
										echo esc_html( sprintf( _n( '%d item', '%d items', $count, 'codexbloc' ), $count ) );
										?>
									</p>
								</div>
								<?php echo codexbloc_order_status_pill( $order ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<span class="w-24 text-right text-[15px] font-semibold tabular-nums text-ink"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
								<?php echo codexbloc_icon( 'chevron', 'hidden h-4 w-4 text-slate-400 sm:block' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
						<span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm"><?php echo codexbloc_icon( 'bag', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<p class="m-0 mt-4 font-semibold text-ink"><?php esc_html_e( 'No orders yet', 'codexbloc' ); ?></p>
						<p class="m-0 mt-1 text-sm text-slate-500"><?php esc_html_e( 'When you buy or download a product, it will show up here.', 'codexbloc' ); ?></p>
						<a class="btn btn-primary mt-5" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?></a>
					</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<!-- Shortcuts -->
		<?php if ( $tiles ) : ?>
			<section>
				<h2 class="m-0 mb-4 text-lg font-semibold text-ink"><?php esc_html_e( 'Manage your account', 'codexbloc' ); ?></h2>
				<ul class="m-0 grid list-none gap-4 p-0 sm:grid-cols-2" role="list">
					<?php foreach ( $tiles as $endpoint => $label ) : ?>
						<li class="m-0 p-0">
							<a class="group flex h-full items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/[0.03] transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-900/[0.06] motion-reduce:hover:translate-y-0" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
								<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition group-hover:bg-accent-soft group-hover:text-accent"><?php echo codexbloc_icon( codexbloc_account_icon( $endpoint ), 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
								<span class="min-w-0 flex-1">
									<span class="block text-[15px] font-semibold text-ink"><?php echo esc_html( $label ); ?></span>
									<?php $desc = codexbloc_account_description( $endpoint ); ?>
									<?php if ( $desc ) : ?>
										<span class="mt-0.5 block text-[13px] leading-snug text-slate-500"><?php echo esc_html( $desc ); ?></span>
									<?php endif; ?>
								</span>
								<?php echo codexbloc_icon( 'chevron', 'mt-1 h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		// Same hooks as WooCommerce's dashboard template, so plugins keep working.
		do_action( 'woocommerce_account_dashboard' );
		do_action( 'woocommerce_before_my_account' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks
		do_action( 'woocommerce_after_my_account' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks
		?>
	</div>
	<?php
}
