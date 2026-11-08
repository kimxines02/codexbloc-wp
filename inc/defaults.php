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
		'all_access_url'    => '',
		'addons_url'        => '',
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
			'text'  => __( 'Extra features, priority support and a year of updates. Licensed per site, billed yearly.', 'codexbloc' ),
			'items' => array(
				__( 'Advanced features on top of the free version', 'codexbloc' ),
				__( 'Priority email support', 'codexbloc' ),
				__( 'Keeps working even if you do not renew', 'codexbloc' ),
			),
		),
	);
}

/**
 * Per-product license tiers shown on the Pricing page.
 * Prices are typical starting prices; each product page shows its exact price.
 */
function codexbloc_license_tiers() {
	return array(
		array(
			'name'     => __( 'Single site', 'codexbloc' ),
			'price'    => '€39',
			'period'   => __( '/ year', 'codexbloc' ),
			'note'     => __( 'For one store.', 'codexbloc' ),
			'sites'    => __( '1 site', 'codexbloc' ),
			'featured' => false,
		),
		array(
			'name'     => __( 'Business', 'codexbloc' ),
			'price'    => '€79',
			'period'   => __( '/ year', 'codexbloc' ),
			'note'     => __( 'For a few stores or staging + live.', 'codexbloc' ),
			'sites'    => __( 'Up to 5 sites', 'codexbloc' ),
			'featured' => true,
		),
		array(
			'name'     => __( 'Agency', 'codexbloc' ),
			'price'    => '€149',
			'period'   => __( '/ year', 'codexbloc' ),
			'note'     => __( 'For agencies and client work.', 'codexbloc' ),
			'sites'    => __( 'Unlimited sites', 'codexbloc' ),
			'featured' => false,
		),
	);
}

/**
 * What every premium license includes.
 */
function codexbloc_license_includes() {
	return array(
		__( 'All premium features of the plugin', 'codexbloc' ),
		__( '12 months of updates', 'codexbloc' ),
		__( '12 months of priority email support', 'codexbloc' ),
		__( 'License key for one-click updates in your dashboard', 'codexbloc' ),
		__( 'Plugin keeps working if you do not renew', 'codexbloc' ),
	);
}

/**
 * All-access bundle (WordPress products only). Shown as "coming soon" until
 * "All-access: checkout link" is set in the Customizer.
 */
function codexbloc_all_access() {
	return array(
		'title'   => __( 'WP All-Access', 'codexbloc' ),
		'text'    => __( 'Every premium WordPress plugin and theme we make, current and future, on unlimited sites.', 'codexbloc' ),
		'price'   => '€179',
		'period'  => __( '/ year', 'codexbloc' ),
		'monthly' => __( 'or €19 / month', 'codexbloc' ),
		'items'   => array(
			__( 'All premium WordPress plugins and themes', 'codexbloc' ),
			__( 'New products added automatically', 'codexbloc' ),
			__( 'Unlimited sites', 'codexbloc' ),
			__( 'Priority support for everything', 'codexbloc' ),
		),
	);
}

/**
 * Pricing FAQ. Review these against your checkout provider's terms.
 */
function codexbloc_pricing_faqs() {
	return array(
		array(
			'q' => __( 'What happens if I do not renew?', 'codexbloc' ),
			'a' => __( 'The plugin keeps working on your site with all its premium features. You just stop receiving updates and support until you renew.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Can I try it before buying?', 'codexbloc' ),
			'a' => __( 'Yes. Every premium plugin has a free version on WordPress.org, so you can test the core features on your store first.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Can I move to a bigger plan later?', 'codexbloc' ),
			'a' => __( 'Yes. Contact us and we will upgrade your license. You only pay the difference.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Do staging and local sites count?', 'codexbloc' ),
			'a' => __( 'No. Development, staging and localhost sites do not count toward your site limit.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Are taxes included?', 'codexbloc' ),
			'a' => __( 'Prices are shown in euros without VAT. Any VAT or sales tax for your country is calculated at checkout.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Where can I buy PrestaShop modules?', 'codexbloc' ),
			'a' => __( 'Our PrestaShop modules are sold through PrestaShop Addons, the official marketplace. They are not part of the WordPress plans on this page.', 'codexbloc' ),
		),
	);
}
