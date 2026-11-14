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
 * Service packages with starting prices (PHP peso). Set to an empty array to hide.
 * Mark one package 'featured' => true to highlight it.
 */
function codexbloc_service_prices() {
	return array(
		array(
			'name'     => __( 'Starter', 'codexbloc' ),
			'price'    => '₱10,000',
			'note'     => __( 'For small businesses getting online.', 'codexbloc' ),
			'features' => array(
				__( 'Up to 5 pages', 'codexbloc' ),
				__( 'Mobile-ready design', 'codexbloc' ),
				__( 'Basic SEO setup', 'codexbloc' ),
				__( 'Contact form', 'codexbloc' ),
			),
		),
		array(
			'name'     => __( 'Business', 'codexbloc' ),
			'price'    => '₱18,000',
			'note'     => __( 'For growing brands that need to be found.', 'codexbloc' ),
			'featured' => true,
			'features' => array(
				__( 'Up to 10 pages', 'codexbloc' ),
				__( 'Full SEO optimization', 'codexbloc' ),
				__( 'Social media integration', 'codexbloc' ),
				__( 'Everything in Starter', 'codexbloc' ),
			),
		),
		array(
			'name'     => __( 'E-Commerce', 'codexbloc' ),
			'price'    => '₱25,000',
			'note'     => __( 'For selling products online.', 'codexbloc' ),
			'features' => array(
				__( 'Online store, up to 15 products', 'codexbloc' ),
				__( 'Payment gateway setup', 'codexbloc' ),
				__( 'Inventory management', 'codexbloc' ),
				__( 'Everything in Business', 'codexbloc' ),
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

/**
 * About page: "At a glance" facts shown beside the intro.
 */
function codexbloc_about_facts() {
	return array(
		array(
			'icon'  => 'puzzle',
			'label' => __( 'What we build', 'codexbloc' ),
			'value' => __( 'Plugins, themes and websites', 'codexbloc' ),
		),
		array(
			'icon'  => 'code',
			'label' => __( 'Platforms', 'codexbloc' ),
			'value' => __( 'WordPress & WooCommerce, PrestaShop soon', 'codexbloc' ),
		),
		array(
			'icon'  => 'download',
			'label' => __( 'How to start', 'codexbloc' ),
			'value' => __( 'Free version first, upgrade when ready', 'codexbloc' ),
		),
		array(
			'icon'  => 'chat',
			'label' => __( 'Support', 'codexbloc' ),
			'value' => __( 'Straight from the people who build it', 'codexbloc' ),
		),
	);
}

/**
 * About page: story paragraphs. Typing content in the page editor replaces these.
 */
function codexbloc_about_story() {
	return array(
		__( 'Most online stores do not need more features. They need the right ones, built well. Too many plugins slow a site down, crowd the dashboard and take hours to set up.', 'codexbloc' ),
		__( 'So we build focused tools for WordPress and WooCommerce that do one job properly. Each one is lightweight, tested against current releases, and comes with a free version you can try on your own store first.', 'codexbloc' ),
		__( 'When a business needs more than a plugin, we design, build and look after the whole website with the same focus on speed and simplicity.', 'codexbloc' ),
	);
}

/**
 * About page: promises listed under the story.
 */
function codexbloc_about_promises() {
	return array(
		__( 'A free version of every plugin on WordPress.org', 'codexbloc' ),
		__( 'No lock-in: premium plugins keep working if you do not renew', 'codexbloc' ),
		__( 'Support from the people who write the code', 'codexbloc' ),
	);
}

/**
 * About page FAQ.
 */
function codexbloc_about_faqs() {
	return array(
		array(
			'q' => __( 'Who is Codexbloc for?', 'codexbloc' ),
			'a' => __( 'Store owners, small businesses and agencies who use WordPress and WooCommerce and want tools that are fast, simple and dependable.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Can I try a product before I buy?', 'codexbloc' ),
			'a' => __( 'Yes. Every premium plugin has a free version on WordPress.org, so you can test it on your own store first. Themes come with sample sites you can preview.', 'codexbloc' ),
		),
		array(
			'q' => __( 'What happens if I do not renew a premium license?', 'codexbloc' ),
			'a' => __( 'The plugin keeps working on your site with all its premium features. You just stop receiving updates and support until you renew.', 'codexbloc' ),
		),
		array(
			'q' => __( 'Do you build custom websites?', 'codexbloc' ),
			'a' => __( 'Yes. We design, build and maintain WordPress websites and WooCommerce stores. Tell us about your project and we will reply with a free, no-obligation quote.', 'codexbloc' ),
		),
		array(
			'q' => __( 'How do I get support?', 'codexbloc' ),
			'a' => __( 'Free plugins are supported in the WordPress.org forums. Premium customers get priority email support. For anything else, use our contact page.', 'codexbloc' ),
		),
	);
}
