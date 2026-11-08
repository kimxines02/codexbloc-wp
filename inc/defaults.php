<?php
/**
 * Default copy and content for the homepage and footer.
 * Edit the text here, or override the most common items in Appearance > Customize > Codexbloc.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default customizer values.
 */
function codexbloc_defaults() {
	return array(
		'accent'          => '#0071e3',
		'hero_eyebrow'    => __( 'Plugins & themes for WordPress and WooCommerce', 'codexbloc' ),
		'hero_title'      => __( 'Lightweight tools that help your online store sell more.', 'codexbloc' ),
		'hero_text'       => __( 'Simple, fast plugins and themes for WooCommerce. Start with a free version, upgrade to premium when you need more. PrestaShop modules are coming soon.', 'codexbloc' ),
		'hero_cta_label'  => __( 'Browse products', 'codexbloc' ),
		'hero_cta_url'    => '',
		'hero_cta2_label' => __( 'See premium plans', 'codexbloc' ),
		'hero_cta2_url'   => '#premium',
		'contact_url'     => '/contact/',
		'contact_email'   => '',
		'footer_text'     => __( 'Plugins, themes and web services for WordPress and WooCommerce stores. PrestaShop modules coming soon.', 'codexbloc' ),
		'facebook_url'    => '',
		'x_url'           => '',
		'linkedin_url'    => '',
		'terms_url'       => '',
		'wporg_url'       => '',
		'newsletter_title'  => __( 'Get product updates in your inbox', 'codexbloc' ),
		'newsletter_text'   => __( 'New plugins, feature releases and WooCommerce tips. One short email a month.', 'codexbloc' ),
		'newsletter_button' => __( 'Subscribe', 'codexbloc' ),
		'newsletter_action' => '',
		'newsletter_field'  => 'EMAIL',
	);
}

/**
 * Get a customizer value with fallback to the default.
 *
 * @param string $key Setting key.
 */
function codexbloc_mod( $key ) {
	$defaults = codexbloc_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	$value    = get_theme_mod( 'codexbloc_' . $key, $default );
	return ( '' === $value || null === $value ) ? $default : $value;
}

/**
 * "Why Codexbloc" points.
 */
function codexbloc_pillars() {
	return array(
		array(
			'icon'  => 'bolt',
			'title' => __( 'Fast by design', 'codexbloc' ),
			'text'  => __( 'Lean code that keeps your store quick on every device.', 'codexbloc' ),
		),
		array(
			'icon'  => 'puzzle',
			'title' => __( 'Simple to use', 'codexbloc' ),
			'text'  => __( 'Sensible defaults and clear settings. No steep learning curve.', 'codexbloc' ),
		),
		array(
			'icon'  => 'shield',
			'title' => __( 'Built with care', 'codexbloc' ),
			'text'  => __( 'Tested with current WordPress and WooCommerce releases.', 'codexbloc' ),
		),
		array(
			'icon'  => 'chat',
			'title' => __( 'Real support', 'codexbloc' ),
			'text'  => __( 'Talk to the people who build the products.', 'codexbloc' ),
		),
	);
}

/**
 * Services shown as a secondary section on the homepage.
 */
function codexbloc_services() {
	return array(
		array(
			'icon'  => 'code',
			'title' => __( 'Web design & development', 'codexbloc' ),
			'text'  => __( 'Clean, mobile-friendly websites built around your brand.', 'codexbloc' ),
		),
		array(
			'icon'  => 'bag',
			'title' => __( 'E-commerce solutions', 'codexbloc' ),
			'text'  => __( 'Secure, scalable online stores designed to turn visitors into customers.', 'codexbloc' ),
		),
		array(
			'icon'  => 'shield',
			'title' => __( 'Maintenance & optimization', 'codexbloc' ),
			'text'  => __( 'Updates, speed tuning and security so your site stays healthy.', 'codexbloc' ),
		),
	);
}

/**
 * Service starting prices (PHP peso). Set to an empty array to hide.
 */
function codexbloc_service_prices() {
	return array(
		array(
			'name'  => __( 'Starter', 'codexbloc' ),
			'price' => '₱10,000+',
			'note'  => __( '5 pages, mobile-ready, basic SEO, contact form', 'codexbloc' ),
		),
		array(
			'name'  => __( 'Business', 'codexbloc' ),
			'price' => '₱18,000+',
			'note'  => __( '10 pages, SEO-optimized, social integration', 'codexbloc' ),
		),
		array(
			'name'  => __( 'E-Commerce', 'codexbloc' ),
			'price' => '₱25,000+',
			'note'  => __( 'Online store, 15 products, payment gateway, inventory', 'codexbloc' ),
		),
	);
}

/**
 * Free vs premium comparison on the homepage.
 */
function codexbloc_plans() {
	return array(
		'free'    => array(
			'title' => __( 'Free plugins', 'codexbloc' ),
			'text'  => __( 'Solid core features you can install in one click from WordPress.org.', 'codexbloc' ),
			'items' => array(
				__( 'Core features included', 'codexbloc' ),
				__( 'Automatic updates from WordPress.org', 'codexbloc' ),
				__( 'Community support forum', 'codexbloc' ),
			),
		),
		'premium' => array(
			'title' => __( 'Premium plans', 'codexbloc' ),
			'text'  => __( 'Extra features, faster support and regular updates. Billed monthly or yearly.', 'codexbloc' ),
			'items' => array(
				__( 'Advanced features on top of the free version', 'codexbloc' ),
				__( 'Priority email support', 'codexbloc' ),
				__( 'Updates for as long as you subscribe', 'codexbloc' ),
			),
		),
	);
}
