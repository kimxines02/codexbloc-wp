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
		echo '<main id="main" class="cb-container py-8 sm:py-12">';
	},
	10
);
add_action(
	'woocommerce_after_main_content',
	function () {
		echo '</main>';
	},
	10
);

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
 * Category pills above the shop loop. Easy navigation between
 * Plugins / Themes / PrestaShop modules.
 */
function codexbloc_shop_filters() {
	if ( ! ( is_shop() || is_product_taxonomy() ) ) {
		return;
	}
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'parent'     => 0,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
		)
	);
	if ( is_wp_error( $terms ) || count( $terms ) < 1 ) {
		return;
	}
	$current = is_product_category() ? get_queried_object_id() : 0;
	$pill    = 'inline-flex items-center rounded-full border px-4 py-1.5 text-sm font-medium transition ';
	$on      = 'border-accent bg-accent text-white';
	$off     = 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:text-ink';

	echo '<nav class="mb-6 flex flex-wrap gap-2" aria-label="' . esc_attr__( 'Product categories', 'codexbloc' ) . '">';
	printf(
		'<a class="%s" href="%s">%s</a>',
		esc_attr( $pill . ( $current ? $off : $on ) ),
		esc_url( wc_get_page_permalink( 'shop' ) ),
		esc_html__( 'All', 'codexbloc' )
	);
	foreach ( $terms as $term ) {
		printf(
			'<a class="%s" href="%s">%s</a>',
			esc_attr( $pill . ( (int) $term->term_id === (int) $current ? $on : $off ) ),
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}
	echo '</nav>';
}
add_action( 'woocommerce_before_shop_loop', 'codexbloc_shop_filters', 5 );

add_action(
	'woocommerce_before_shop_loop',
	function () {
		echo '<div class="mb-6 flex flex-wrap items-center justify-between gap-3">';
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
 * Free products that live on WordPress.org: no cart, just a download button.
 * A product counts as "free on WordPress.org" when it has a WordPress.org URL
 * in the Codexbloc details box and its price is empty or zero.
 */
add_filter(
	'woocommerce_is_purchasable',
	function ( $purchasable, $product ) {
		if ( ! is_admin() && codexbloc_is_wporg_free( $product ) ) {
			return false;
		}
		return $purchasable;
	},
	10,
	2
);

add_filter(
	'woocommerce_loop_add_to_cart_link',
	function ( $html, $product ) {
		if ( codexbloc_is_wporg_free( $product ) ) {
			return sprintf(
				'<a href="%s" class="button" target="_blank" rel="noopener">%s</a>',
				esc_url( codexbloc_product_field( $product->get_id(), 'wporg_url' ) ),
				esc_html__( 'Download free', 'codexbloc' )
			);
		}
		return $html;
	},
	10,
	2
);

add_filter(
	'woocommerce_get_price_html',
	function ( $price, $product ) {
		if ( codexbloc_is_wporg_free( $product ) ) {
			return '<span class="woocommerce-Price-amount amount">' . esc_html__( 'Free', 'codexbloc' ) . '</span>';
		}
		return $price;
	},
	20,
	2
);

/**
 * Single product: features, buttons and details.
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

function codexbloc_single_free_cta() {
	global $product;
	if ( ! codexbloc_is_wporg_free( $product ) ) {
		return;
	}
	printf(
		'<div class="my-6"><a class="btn btn-primary" href="%s" target="_blank" rel="noopener">%s%s</a></div>',
		esc_url( codexbloc_product_field( $product->get_id(), 'wporg_url' ) ),
		esc_html__( 'Download free on WordPress.org', 'codexbloc' ),
		codexbloc_icon( 'external', 'h-4 w-4' ) // phpcs:ignore WordPress.Security.EscapeOutput
	);
}
add_action( 'woocommerce_single_product_summary', 'codexbloc_single_free_cta', 30 );

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
	if ( codexbloc_product_field( $id, 'wporg_url' ) && ! codexbloc_is_wporg_free( $product ) ) {
		$links[] = array( __( 'Free version on WordPress.org', 'codexbloc' ), codexbloc_product_field( $id, 'wporg_url' ) );
	}

	if ( $product->is_purchasable() && ! codexbloc_is_wporg_free( $product ) ) {
		$assurances = array(
			array( 'shield', __( 'Secure checkout', 'codexbloc' ) ),
			array( 'download', __( 'Instant download', 'codexbloc' ) ),
			array( 'clock', __( '1 year of updates & support', 'codexbloc' ) ),
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
