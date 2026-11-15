<?php
/**
 * WooCommerce integration.
 *
 * WooCommerce's own stylesheets are switched off (the theme styles every
 * WooCommerce screen in assets/css/main.css), which saves three requests and
 * keeps the cascade predictable. Template files are NOT overridden, so
 * WooCommerce updates never show "outdated template" warnings.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme support. WooCommerce's zoom and PhotoSwipe lightbox are left off on
 * purpose (they load extra scripts); the light slider is kept for products with
 * several images, and theme.js adds its own small lightbox.
 */
function codexbloc_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 480,
			'single_image_width'    => 720,
			'product_grid'          => array(
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'codexbloc_woocommerce_setup' );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Page wrappers.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action(
	'woocommerce_before_main_content',
	function () {
		if ( codexbloc_has_shop_sidebar() ) {
			// Listings: the breadcrumb, title and description move into the gradient band.
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			echo '<main id="main">';
			codexbloc_shop_hero();
			echo '<div class="cb-container py-10 sm:py-14">';
			return;
		}
		echo '<main id="main" class="cb-container py-8 sm:py-12">';
	},
	10
);
add_action(
	'woocommerce_after_main_content',
	function () {
		echo codexbloc_has_shop_sidebar() ? '</div></main>' : '</main>';
	},
	10
);

/**
 * Listing title band: breadcrumb, title, description and reassurances on the
 * same animated gradient as the header. WooCommerce's own title block is
 * hidden on listings (see .cb-shop-main > .woocommerce-products-header).
 */
function codexbloc_shop_hero() {
	$description = is_product_taxonomy() ? wp_strip_all_tags( term_description() ) : '';
	if ( ! $description ) {
		$description = is_product_taxonomy()
			? ''
			: __( 'Lightweight plugins, themes and modules for WooCommerce and PrestaShop. Tested on current releases and supported by the developers who built them.', 'codexbloc' );
	}
	$assurances = array(
		array( 'download', __( 'Instant download', 'codexbloc' ) ),
		array( 'shield', __( 'Secure checkout', 'codexbloc' ) ),
		array( 'chat', __( 'Support from the developers', 'codexbloc' ) ),
	);
	?>
	<section class="cb-pastel-bg relative overflow-hidden border-b border-slate-900/5" aria-labelledby="cb-shop-title">
		<div class="cb-container py-10 sm:py-14">
			<?php
			woocommerce_breadcrumb(
				array(
					'wrap_before' => '<nav class="woocommerce-breadcrumb cb-shop-crumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'codexbloc' ) . '">',
					'delimiter'   => '<span class="mx-2 text-slate-400" aria-hidden="true">/</span>',
				)
			);
			?>
			<h1 id="cb-shop-title" class="m-0 text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl"><?php woocommerce_page_title(); ?></h1>
			<?php if ( $description ) : ?>
				<p class="mt-4 max-w-2xl text-lg leading-relaxed text-slate-600"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
			<ul class="mt-7 flex flex-wrap gap-2.5" role="list">
				<?php foreach ( $assurances as $item ) : ?>
					<li class="inline-flex items-center gap-2 rounded-full border border-white/80 bg-white/60 px-3.5 py-1.5 text-sm font-medium text-slate-700 backdrop-blur">
						<?php echo codexbloc_icon( $item[0], 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<?php echo esc_html( $item[1] ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php
}

/**
 * Grid: 3 columns on the shop, 12 per page, 3 related products.
 */
add_filter(
	'loop_shop_columns',
	function () {
		return 3;
	}
);
add_filter(
	'loop_shop_per_page',
	function () {
		return 12;
	}
);
add_filter(
	'woocommerce_output_related_products_args',
	function ( $args ) {
		$args['posts_per_page'] = 3;
		$args['columns']        = 3;
		return $args;
	}
);

/**
 * Is this a product listing that gets the filter sidebar?
 */
function codexbloc_has_shop_sidebar() {
	return function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) && ! is_search();
}

/**
 * Price ranges offered in the sidebar: key => [ min, max, label ].
 * A null bound means "no limit".
 */
function codexbloc_price_ranges() {
	$money = function ( $amount ) {
		return html_entity_decode( wp_strip_all_tags( wc_price( $amount, array( 'decimals' => 0 ) ) ), ENT_QUOTES, 'UTF-8' );
	};
	return array(
		'free'   => array( null, 0, __( 'Free', 'codexbloc' ) ),
		'0-25'   => array( 0.01, 25, sprintf( /* translators: %s: price */ __( 'Under %s', 'codexbloc' ), $money( 25 ) ) ),
		'25-50'  => array( 25, 50, $money( 25 ) . ' – ' . $money( 50 ) ),
		'50-100' => array( 50, 100, $money( 50 ) . ' – ' . $money( 100 ) ),
		'100+'   => array( 100, null, sprintf( /* translators: %s: price */ __( 'Over %s', 'codexbloc' ), $money( 100 ) ) ),
	);
}

/**
 * Current listing URL without page number, keeping the sort order.
 */
function codexbloc_shop_base_url() {
	$url = is_product_taxonomy() ? get_term_link( get_queried_object() ) : wc_get_page_permalink( 'shop' );
	if ( is_wp_error( $url ) ) {
		$url = wc_get_page_permalink( 'shop' );
	}
	if ( isset( $_GET['orderby'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$url = add_query_arg( 'orderby', sanitize_key( wp_unslash( $_GET['orderby'] ) ), $url ); // phpcs:ignore WordPress.Security.NonceVerification
	}
	return $url;
}

/**
 * Price filter currently in the URL, as [ min|null, max|null ].
 */
function codexbloc_current_price() {
	// phpcs:disable WordPress.Security.NonceVerification
	$min = isset( $_GET['min_price'] ) && '' !== $_GET['min_price'] ? (float) wp_unslash( $_GET['min_price'] ) : null;
	$max = isset( $_GET['max_price'] ) && '' !== $_GET['max_price'] ? (float) wp_unslash( $_GET['max_price'] ) : null;
	// phpcs:enable
	return array( $min, $max );
}

/**
 * Category list items (recursive) for the sidebar.
 *
 * @param int   $parent    Parent term id.
 * @param array $price_args Price query args to keep on category links.
 * @param array $active    Ids of the current term and its ancestors.
 */
function codexbloc_sidebar_cats( $parent, $price_args, $active ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'parent'     => $parent,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
			'orderby'    => 'menu_order',
		)
	);
	if ( is_wp_error( $terms ) || ! $terms ) {
		return;
	}
	echo '<ul class="' . ( $parent ? 'mt-1 space-y-0.5 border-l border-slate-200 pl-3 ml-3' : 'space-y-0.5' ) . '" role="list">';
	foreach ( $terms as $term ) {
		$is_current = is_product_category() && (int) get_queried_object_id() === (int) $term->term_id;
		$is_open    = in_array( (int) $term->term_id, $active, true );
		$link       = add_query_arg( $price_args, get_term_link( $term ) );
		printf(
			'<li><a class="%s" href="%s"%s><span>%s</span><span class="%s">%d</span></a>',
			esc_attr( 'flex items-center justify-between gap-2 rounded-lg px-3 py-2 text-sm transition ' . ( $is_current ? 'bg-accent-soft font-semibold text-accent' : 'text-slate-600 hover:bg-slate-100 hover:text-ink' ) ),
			esc_url( $link ),
			$is_current ? ' aria-current="page"' : '',
			esc_html( $term->name ),
			esc_attr( 'text-xs ' . ( $is_current ? 'text-accent' : 'text-slate-400' ) ),
			(int) $term->count
		);
		if ( $is_open || 0 === $parent ) {
			codexbloc_sidebar_cats( (int) $term->term_id, $price_args, $active );
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Filter sidebar: categories and price.
 */
function codexbloc_shop_sidebar() {
	list( $cur_min, $cur_max ) = codexbloc_current_price();
	$price_on   = null !== $cur_min || null !== $cur_max;
	$price_args = array_filter(
		array(
			'min_price' => null !== $cur_min ? $cur_min : null,
			'max_price' => null !== $cur_max ? $cur_max : null,
		),
		function ( $v ) {
			return null !== $v;
		}
	);

	$active = array();
	if ( is_product_category() ) {
		$id     = (int) get_queried_object_id();
		$active = array_merge( array( $id ), array_map( 'intval', get_ancestors( $id, 'product_cat', 'taxonomy' ) ) );
	}
	$shop_url  = add_query_arg( $price_args, wc_get_page_permalink( 'shop' ) );
	$base      = remove_query_arg( array( 'min_price', 'max_price' ), codexbloc_shop_base_url() );
	$heading   = 'mb-2 px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500';
	$item      = 'flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition ';
	$item_on   = 'bg-accent-soft font-semibold text-accent';
	$item_off  = 'text-slate-600 hover:bg-slate-100 hover:text-ink';
	$filtering = $price_on || is_product_taxonomy();
	?>
	<aside class="cb-shop-sidebar mb-8 lg:mb-0" aria-label="<?php esc_attr_e( 'Product filters', 'codexbloc' ); ?>">
		<details class="cb-filters group rounded-2xl border border-slate-200 bg-white lg:sticky lg:top-24 lg:shadow-sm lg:shadow-slate-900/[0.03]" data-cb-filters>
			<summary class="flex cursor-pointer list-none items-center justify-between px-4 py-3 text-sm font-semibold text-ink lg:hidden">
				<span><?php esc_html_e( 'Filters', 'codexbloc' ); ?></span>
				<svg class="h-4 w-4 text-slate-500 transition group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
			</summary>
			<div class="space-y-8 border-t border-slate-100 p-3 lg:border-0 lg:py-5">
				<div>
					<p class="<?php echo esc_attr( $heading ); ?>"><?php esc_html_e( 'Categories', 'codexbloc' ); ?></p>
					<a class="<?php echo esc_attr( 'flex items-center justify-between rounded-lg px-3 py-2 text-sm transition ' . ( is_product_taxonomy() ? $item_off : $item_on ) ); ?>" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'All products', 'codexbloc' ); ?></a>
					<?php codexbloc_sidebar_cats( 0, $price_args, $active ); ?>
				</div>

				<div>
					<p class="<?php echo esc_attr( $heading ); ?>"><?php esc_html_e( 'Price', 'codexbloc' ); ?></p>
					<ul class="space-y-0.5" role="list">
						<li><a class="<?php echo esc_attr( $item . ( $price_on ? $item_off : $item_on ) ); ?>" href="<?php echo esc_url( $base ); ?>"><span class="<?php echo esc_attr( 'h-3.5 w-3.5 shrink-0 rounded-full border ' . ( $price_on ? 'border-slate-300' : 'border-[4px] border-accent' ) ); ?>" aria-hidden="true"></span><?php esc_html_e( 'Any price', 'codexbloc' ); ?></a></li>
						<?php
						foreach ( codexbloc_price_ranges() as $range ) :
							list( $min, $max, $label ) = $range;
							$on   = $price_on
								&& ( null === $min ? null === $cur_min : (float) $min === $cur_min )
								&& ( null === $max ? null === $cur_max : (float) $max === $cur_max );
							$args = array_filter(
								array(
									'min_price' => $min,
									'max_price' => $max,
								),
								function ( $v ) {
									return null !== $v;
								}
							);
							?>
							<li><a class="<?php echo esc_attr( $item . ( $on ? $item_on : $item_off ) ); ?>" href="<?php echo esc_url( add_query_arg( $args, $base ) ); ?>" rel="nofollow"<?php echo $on ? ' aria-current="true"' : ''; ?>><span class="<?php echo esc_attr( 'h-3.5 w-3.5 shrink-0 rounded-full border ' . ( $on ? 'border-[4px] border-accent' : 'border-slate-300' ) ); ?>" aria-hidden="true"></span><?php echo esc_html( $label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<?php if ( $filtering ) : ?>
					<a class="mx-3 inline-flex text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Clear all filters', 'codexbloc' ); ?></a>
				<?php endif; ?>
			</div>
		</details>
	</aside>
	<?php
}

/**
 * Two-column layout on listings: filters on the left, products on the right.
 */
add_action(
	'woocommerce_before_main_content',
	function () {
		if ( ! codexbloc_has_shop_sidebar() ) {
			return;
		}
		echo '<div class="lg:grid lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-10">';
		codexbloc_shop_sidebar();
		echo '<div class="cb-shop-main min-w-0">';
	},
	30
);
add_action(
	'woocommerce_after_main_content',
	function () {
		if ( codexbloc_has_shop_sidebar() ) {
			echo '</div></div>';
		}
	},
	5
);

add_action(
	'woocommerce_before_shop_loop',
	function () {
		echo '<div class="cb-shop-toolbar">';
	},
	19
);
add_action(
	'woocommerce_before_shop_loop',
	function () {
		echo '</div>';
	},
	31
);

/**
 * Category label on product cards.
 */
function codexbloc_loop_category() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}
	$default = (int) get_option( 'default_product_cat' );
	foreach ( $terms as $term ) {
		if ( (int) $term->term_id !== $default ) {
			echo '<span class="cb-cat">' . esc_html( $term->name ) . '</span>';
			return;
		}
	}
}
add_action( 'woocommerce_shop_loop_item_title', 'codexbloc_loop_category', 5 );

/**
 * Product cards: featured badge, short summary, and a footer row with the
 * price on the left and the button on the right.
 */
add_action(
	'woocommerce_before_shop_loop_item_title',
	function () {
		global $product;
		if ( $product && $product->is_featured() ) {
			echo '<span class="cb-badge-featured">' . esc_html__( 'Featured', 'codexbloc' ) . '</span>';
		}
	},
	9
);

add_action(
	'woocommerce_after_shop_loop_item_title',
	function () {
		global $product;
		if ( ! $product ) {
			return;
		}
		$summary = wp_strip_all_tags( $product->get_short_description() );
		if ( $summary ) {
			echo '<p class="cb-card-summary">' . esc_html( wp_trim_words( $summary, 20 ) ) . '</p>';
		}
	},
	7
);

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action(
	'woocommerce_after_shop_loop_item',
	function () {
		global $product;
		$free = function_exists( 'codexbloc_is_free_product' ) && codexbloc_is_free_product( $product );
		echo '<div class="cb-card-foot' . ( $free ? ' is-free' : '' ) . '">';
		woocommerce_template_loop_price();
	},
	7
);
add_action(
	'woocommerce_after_shop_loop_item',
	function () {
		echo '</div>';
	},
	20
);

/**
 * Header cart count updates without a page reload.
 */
add_filter(
	'woocommerce_add_to_cart_fragments',
	function ( $fragments ) {
		ob_start();
		codexbloc_cart_link();
		$fragments['a.cb-cart-link'] = ob_get_clean();
		return $fragments;
	}
);

/**
 * Single product: features, links and details (free download button: inc/free-downloads.php).
 */
function codexbloc_single_features() {
	global $product;
	$lines = codexbloc_lines( codexbloc_product_field( $product->get_id(), 'features' ) );
	if ( ! $lines ) {
		return;
	}
	echo '<ul class="cb-checklist">';
	foreach ( $lines as $line ) {
		echo '<li>' . codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 shrink-0 text-accent' ) . '<span>' . esc_html( $line ) . '</span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</ul>';
}
add_action( 'woocommerce_single_product_summary', 'codexbloc_single_features', 25 );

function codexbloc_single_links() {
	global $product;
	$id    = $product->get_id();
	$links = array();

	if ( codexbloc_product_field( $id, 'demo_url' ) ) {
		$links[] = array( __( 'Live demo', 'codexbloc' ), codexbloc_product_field( $id, 'demo_url' ) );
	}
	if ( codexbloc_product_field( $id, 'docs_url' ) ) {
		$links[] = array( __( 'Documentation', 'codexbloc' ), codexbloc_product_field( $id, 'docs_url' ) );
	}
	if ( codexbloc_product_field( $id, 'wporg_url' ) && ! codexbloc_is_free_product( $product ) ) {
		$links[] = array( __( 'Free version on WordPress.org', 'codexbloc' ), codexbloc_product_field( $id, 'wporg_url' ) );
	}

	if ( $product->is_purchasable() && ! codexbloc_is_free_product( $product ) ) {
		$assurances = array(
			array( 'shield', __( 'Secure checkout', 'codexbloc' ) ),
			array( 'download', __( 'Instant download', 'codexbloc' ) ),
			array( 'chat', __( 'Support from the developers', 'codexbloc' ) ),
		);
		echo '<ul class="mt-4 flex max-w-md flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">';
		foreach ( $assurances as $item ) {
			echo '<li class="inline-flex items-center gap-1.5">' . codexbloc_icon( $item[0], 'h-4 w-4 text-slate-400' ) . esc_html( $item[1] ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</ul>';
	}

	if ( $links ) {
		echo '<div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 border-t border-slate-200 pt-5">';
		foreach ( $links as $link ) {
			printf(
				'<a class="inline-flex items-center gap-1.5 text-sm font-medium text-accent no-underline hover:text-accent-dark" href="%s" target="_blank" rel="noopener">%s%s</a>',
				esc_url( $link[1] ),
				esc_html( $link[0] ),
				codexbloc_icon( 'external', 'h-3.5 w-3.5' ) // phpcs:ignore WordPress.Security.EscapeOutput
			);
		}
		echo '</div>';
	}

	$details = array(
		__( 'Version', 'codexbloc' )  => codexbloc_product_field( $id, 'version' ),
		__( 'Requires', 'codexbloc' ) => codexbloc_product_field( $id, 'requires' ),
	);
	$details = array_filter( $details );
	if ( $details ) {
		echo '<dl class="mt-5 grid grid-cols-[auto_1fr] gap-x-4 gap-y-1 text-sm">';
		foreach ( $details as $label => $value ) {
			echo '<dt class="text-slate-500">' . esc_html( $label ) . '</dt><dd class="text-slate-700">' . esc_html( $value ) . '</dd>';
		}
		echo '</dl>';
	}
}
add_action( 'woocommerce_single_product_summary', 'codexbloc_single_links', 35 );


/**
 * Wrap the add-to-cart form and whatever plugins print right after it
 * (PayPal / Stripe express buttons) so they can sit side by side.
 * Variable and grouped products keep the stacked layout: their forms
 * hold option pickers that need the full width.
 */
function codexbloc_buy_box_open() {
	global $product;
	if ( $product instanceof WC_Product && ! $product->is_type( array( 'variable', 'grouped' ) ) ) {
		$GLOBALS['codexbloc_buy_box'] = true;
		echo '<div class="cb-buy">';
	}
}
add_action( 'woocommerce_before_add_to_cart_form', 'codexbloc_buy_box_open', 1 );

function codexbloc_buy_box_close() {
	if ( ! empty( $GLOBALS['codexbloc_buy_box'] ) ) {
		$GLOBALS['codexbloc_buy_box'] = false;
		echo '</div>';
	}
}
add_action( 'woocommerce_after_add_to_cart_form', 'codexbloc_buy_box_close', 999 );

/**
 * Description tab: wrap the product description in the theme's article styles.
 */
function codexbloc_description_tab() {
	echo '<div class="cb-prose">';
	the_content();
	echo '</div>';
}
add_filter(
	'woocommerce_product_tabs',
	function ( $tabs ) {
		if ( isset( $tabs['description'] ) ) {
			$tabs['description']['callback'] = 'codexbloc_description_tab';
		}
		return $tabs;
	},
	20
);
