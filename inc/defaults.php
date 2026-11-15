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
		'hero_eyebrow'    => __( 'Plugins, themes & modules for WooCommerce and PrestaShop', 'codexbloc' ),
		'hero_title'      => __( 'Lightweight tools that help your online store sell more.', 'codexbloc' ),
		'hero_text'       => __( 'Simple, fast plugins and themes for WooCommerce, modules for PrestaShop, plus websites and online stores built for you.', 'codexbloc' ),
		'hero_cta_label'  => __( 'Browse products', 'codexbloc' ),
		'hero_cta_url'    => '',
		'hero_cta2_label' => __( 'Our services', 'codexbloc' ),
		'hero_cta2_url'   => '#services',
		'contact_url'     => '/contact/',
		'contact_email'   => '',
		'footer_text'     => __( 'Plugins, themes, modules and web services for WooCommerce and PrestaShop stores.', 'codexbloc' ),
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
			'text'  => __( 'Tested with current WooCommerce and PrestaShop releases.', 'codexbloc' ),
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
 * Each service lists the concrete deliverables included.
 */
function codexbloc_services() {
	return array(
		array(
			'icon'  => 'code',
			'title' => __( 'Web design & development', 'codexbloc' ),
			'text'  => __( 'Custom WordPress websites designed around your brand and built to convert.', 'codexbloc' ),
			'items' => array(
				__( 'Custom design, no generic templates', 'codexbloc' ),
				__( 'Responsive on phones, tablets and desktops', 'codexbloc' ),
				__( 'On-page SEO and fast load times', 'codexbloc' ),
				__( 'Easy-to-edit pages you control', 'codexbloc' ),
			),
		),
		array(
			'icon'  => 'bag',
			'title' => __( 'E-commerce solutions', 'codexbloc' ),
			'text'  => __( 'WooCommerce stores that are secure, easy to manage and ready to sell.', 'codexbloc' ),
			'items' => array(
				__( 'Product catalog and inventory setup', 'codexbloc' ),
				__( 'Payment gateways (GCash, Maya, cards)', 'codexbloc' ),
				__( 'Shipping, taxes and order emails', 'codexbloc' ),
				__( 'Checkout tuned for conversions', 'codexbloc' ),
			),
		),
		array(
			'icon'  => 'shield',
			'title' => __( 'Maintenance & optimization', 'codexbloc' ),
			'text'  => __( 'Ongoing care so your site stays fast, secure and up to date.', 'codexbloc' ),
			'items' => array(
				__( 'WordPress, theme and plugin updates', 'codexbloc' ),
				__( 'Daily backups and security monitoring', 'codexbloc' ),
				__( 'Speed and Core Web Vitals tuning', 'codexbloc' ),
				__( 'Content edits and bug fixes', 'codexbloc' ),
			),
		),
	);
}

/**
 * Service process steps shown on the homepage.
 */
function codexbloc_service_steps() {
	return array(
		array(
			'title' => __( 'Discover', 'codexbloc' ),
			'text'  => __( 'We learn your goals, audience and budget.', 'codexbloc' ),
		),
		array(
			'title' => __( 'Design', 'codexbloc' ),
			'text'  => __( 'You review a layout before we build.', 'codexbloc' ),
		),
		array(
			'title' => __( 'Build', 'codexbloc' ),
			'text'  => __( 'We develop, test and refine every page.', 'codexbloc' ),
		),
		array(
			'title' => __( 'Launch & support', 'codexbloc' ),
			'text'  => __( 'We go live and stay on hand after launch.', 'codexbloc' ),
		),
	);
}

/**
 * About page: story paragraphs. Typing content in the page editor replaces these.
 */
function codexbloc_about_story() {
	return array(
		__( 'Most online stores do not need more features. They need the right ones, built well. Too many plugins slow a site down, crowd the dashboard and take hours to set up.', 'codexbloc' ),
		__( 'So we build focused tools for WooCommerce and PrestaShop that do one job properly. Each one is lightweight, tested against current releases and easy to set up.', 'codexbloc' ),
		__( 'When a business needs more than a plugin, we design, build and look after the whole website with the same focus on speed and simplicity.', 'codexbloc' ),
	);
}

/**
 * About page: numbered principles.
 */
function codexbloc_about_principles() {
	return array(
		array(
			'title' => __( 'One job, done well', 'codexbloc' ),
			'text'  => __( 'Every product solves one clear problem. No bloated settings pages, no features you will never use.', 'codexbloc' ),
		),
		array(
			'title' => __( 'Speed is a feature', 'codexbloc' ),
			'text'  => __( 'Lean code and no extra scripts. If it slows your store down, it does not ship.', 'codexbloc' ),
		),
		array(
			'title' => __( 'Plain language', 'codexbloc' ),
			'text'  => __( 'Clear settings, clear docs and clear answers. You should never need a developer to set up our tools.', 'codexbloc' ),
		),
		array(
			'title' => __( 'We stand behind it', 'codexbloc' ),
			'text'  => __( 'We test on current releases, fix what breaks and answer your questions ourselves.', 'codexbloc' ),
		),
	);
}

/**
 * About page FAQ.
 */
function codexbloc_about_faqs() {
	return array(
		array(
			'q' => __( 'Who is Codexbloc for?', 'codexbloc' ),
			'a' => __( 'Store owners, small businesses and agencies who use WooCommerce or PrestaShop and want tools that are fast, simple and dependable.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Where can I get your plugins?', 'codexbloc' ),
			'a' => __( 'Our plugins are free on WordPress.org, so you can install them in one click from your WordPress dashboard. Themes come with sample sites you can preview before you choose, and PrestaShop modules are available in our shop.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Do you build custom websites?', 'codexbloc' ),
			'a' => __( 'Yes. We design, build and maintain WordPress websites and WooCommerce stores. Tell us about your project and we will reply with a free, no-obligation quote.', 'codexbloc' ),
		),
		array(
			'q' => __( 'How do I get support?', 'codexbloc' ),
			'a' => __( 'Plugin questions are answered in the WordPress.org support forums. For themes, PrestaShop modules, websites or anything else, send us a message through our contact page.', 'codexbloc' ),
		),
	);
}
