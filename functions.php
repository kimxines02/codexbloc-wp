<?php
/**
 * Codexbloc theme functions.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CODEXBLOC_VERSION', '1.0.0' );
define( 'CODEXBLOC_DIR', get_template_directory() );
define( 'CODEXBLOC_URI', get_template_directory_uri() );

require_once CODEXBLOC_DIR . '/inc/defaults.php';
require_once CODEXBLOC_DIR . '/inc/template-tags.php';
require_once CODEXBLOC_DIR . '/inc/customizer.php';
require_once CODEXBLOC_DIR . '/inc/contact.php';
require_once CODEXBLOC_DIR . '/inc/newsletter.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once CODEXBLOC_DIR . '/inc/woocommerce.php';
	require_once CODEXBLOC_DIR . '/inc/product-fields.php';
}

/**
 * Theme setup.
 */
function codexbloc_setup() {
	load_theme_textdomain( 'codexbloc', CODEXBLOC_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu (header)', 'codexbloc' ),
			'footer'  => __( 'Footer menu', 'codexbloc' ),
		)
	);

	add_image_size( 'codexbloc-card', 720, 450, true );
}
add_action( 'after_setup_theme', 'codexbloc_setup' );

/**
 * Content width for embeds.
 */
function codexbloc_content_width() {
	$GLOBALS['content_width'] = 768;
}
add_action( 'after_setup_theme', 'codexbloc_content_width', 0 );

/**
 * Styles and scripts. One small stylesheet, one deferred script, system fonts.
 */
function codexbloc_assets() {
	$css_path = CODEXBLOC_DIR . '/assets/css/main.css';
	$js_path  = CODEXBLOC_DIR . '/assets/js/theme.js';

	wp_enqueue_style(
		'codexbloc',
		CODEXBLOC_URI . '/assets/css/main.css',
		array(),
		file_exists( $css_path ) ? filemtime( $css_path ) : CODEXBLOC_VERSION
	);
	wp_add_inline_style( 'codexbloc', codexbloc_accent_css() );

	wp_enqueue_script(
		'codexbloc',
		CODEXBLOC_URI . '/assets/js/theme.js',
		array(),
		file_exists( $js_path ) ? filemtime( $js_path ) : CODEXBLOC_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Pages built by this theme contain no blocks, so skip the block CSS there.
	$skip_block_css = is_front_page() && ! is_home();
	if ( function_exists( 'is_shop' ) ) {
		$skip_block_css = $skip_block_css || is_shop() || is_product_taxonomy();
	}
	if ( $skip_block_css ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wc-blocks-style' );
	}
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'codexbloc_assets', 20 );

/**
 * Trim default WordPress head output that a lean storefront does not need.
 */
function codexbloc_cleanup_head() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}
add_action( 'init', 'codexbloc_cleanup_head' );

/**
 * Excerpt tweaks.
 */
add_filter(
	'excerpt_length',
	function () {
		return 24;
	}
);
add_filter(
	'excerpt_more',
	function () {
		return '&hellip;';
	}
);

/**
 * Body classes.
 */
function codexbloc_body_classes( $classes ) {
	$classes[] = 'bg-white text-slate-700 antialiased';
	return $classes;
}
add_filter( 'body_class', 'codexbloc_body_classes' );

/**
 * On activation: create the three product categories used by the header menu
 * (only when WooCommerce is active and they do not exist yet).
 */
function codexbloc_on_activate() {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return;
	}
	$cats = array(
		'wordpress-plugins' => __( 'WordPress Plugins', 'codexbloc' ),
		'wordpress-themes'  => __( 'WordPress Themes', 'codexbloc' ),
		'prestashop-modules' => __( 'PrestaShop Modules', 'codexbloc' ),
	);
	foreach ( $cats as $slug => $name ) {
		if ( ! term_exists( $slug, 'product_cat' ) ) {
			wp_insert_term( $name, 'product_cat', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'after_switch_theme', 'codexbloc_on_activate' );
