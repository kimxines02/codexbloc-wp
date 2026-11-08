<?php
/**
 * Customizer settings and accent colour helper.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert #rrggbb to "r g b" for use in rgb(var(--x) / alpha).
 *
 * @param string $hex Hex colour.
 */
function codexbloc_hex_to_rgb_string( $hex ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( 6 !== strlen( $hex ) || ! ctype_xdigit( $hex ) ) {
		return '79 70 229';
	}
	return hexdec( substr( $hex, 0, 2 ) ) . ' ' . hexdec( substr( $hex, 2, 2 ) ) . ' ' . hexdec( substr( $hex, 4, 2 ) );
}

/**
 * Mix a colour with black (negative) or white (positive) by a ratio 0-1.
 *
 * @param string $rgb   "r g b".
 * @param float  $ratio Amount to mix.
 * @param bool   $white Mix with white when true, black otherwise.
 */
function codexbloc_mix( $rgb, $ratio, $white = true ) {
	$parts  = array_map( 'intval', explode( ' ', $rgb ) );
	$target = $white ? 255 : 0;
	$out    = array();
	foreach ( $parts as $p ) {
		$out[] = (int) round( $p + ( $target - $p ) * $ratio );
	}
	return implode( ' ', $out );
}

/**
 * CSS variables for the accent colour.
 */
function codexbloc_accent_css() {
	$rgb = codexbloc_hex_to_rgb_string( codexbloc_mod( 'accent' ) );
	return sprintf(
		':root{--cb-accent:%1$s;--cb-accent-dark:%2$s;--cb-accent-soft:%3$s}',
		$rgb,
		codexbloc_mix( $rgb, 0.18, false ),
		codexbloc_mix( $rgb, 0.92, true )
	);
}

/**
 * Register Customizer controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function codexbloc_customize_register( $wp_customize ) {
	$d = codexbloc_defaults();

	$wp_customize->add_section(
		'codexbloc_section',
		array(
			'title'    => __( 'Codexbloc', 'codexbloc' ),
			'priority' => 30,
		)
	);

	$text_fields = array(
		'hero_eyebrow'    => array( __( 'Hero: small label', 'codexbloc' ), 'text' ),
		'hero_title'      => array( __( 'Hero: headline', 'codexbloc' ), 'text' ),
		'hero_text'       => array( __( 'Hero: description', 'codexbloc' ), 'textarea' ),
		'hero_cta_label'  => array( __( 'Hero: main button text', 'codexbloc' ), 'text' ),
		'hero_cta_url'    => array( __( 'Hero: main button link (blank = shop page)', 'codexbloc' ), 'url' ),
		'hero_cta2_label' => array( __( 'Hero: second button text', 'codexbloc' ), 'text' ),
		'hero_cta2_url'   => array( __( 'Hero: second button link', 'codexbloc' ), 'text' ),
		'contact_url'     => array( __( 'Contact page link', 'codexbloc' ), 'text' ),
		'contact_email'   => array( __( 'Contact email (footer)', 'codexbloc' ), 'text' ),
		'footer_text'     => array( __( 'Footer description', 'codexbloc' ), 'textarea' ),
		'facebook_url'    => array( __( 'Facebook URL', 'codexbloc' ), 'url' ),
		'x_url'           => array( __( 'X (Twitter) URL', 'codexbloc' ), 'url' ),
		'linkedin_url'    => array( __( 'LinkedIn URL', 'codexbloc' ), 'url' ),
		'terms_url'       => array( __( 'Terms of Service URL', 'codexbloc' ), 'url' ),
		'wporg_url'       => array( __( 'Your WordPress.org profile URL', 'codexbloc' ), 'url' ),
		'newsletter_title'  => array( __( 'Newsletter: heading', 'codexbloc' ), 'text' ),
		'newsletter_text'   => array( __( 'Newsletter: description', 'codexbloc' ), 'textarea' ),
		'newsletter_button' => array( __( 'Newsletter: button text', 'codexbloc' ), 'text' ),
		'newsletter_action' => array( __( 'Newsletter: form action URL from your email provider (blank = built-in signup)', 'codexbloc' ), 'url' ),
		'newsletter_field'  => array( __( 'Newsletter: email field name used by your provider (e.g. EMAIL for Mailchimp)', 'codexbloc' ), 'text' ),
		'all_access_url'    => array( __( 'All-access: checkout link (blank = shown as "coming soon")', 'codexbloc' ), 'url' ),
		'addons_url'        => array( __( 'PrestaShop Addons seller page URL', 'codexbloc' ), 'url' ),
	);

	foreach ( $text_fields as $key => $field ) {
		$sanitize = 'url' === $field[1] ? 'esc_url_raw' : ( 'textarea' === $field[1] ? 'sanitize_textarea_field' : 'sanitize_text_field' );
		$wp_customize->add_setting(
			'codexbloc_' . $key,
			array(
				'default'           => isset( $d[ $key ] ) ? $d[ $key ] : '',
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'codexbloc_' . $key,
			array(
				'label'   => $field[0],
				'section' => 'codexbloc_section',
				'type'    => 'url' === $field[1] ? 'text' : $field[1],
			)
		);
	}

	$wp_customize->add_setting(
		'codexbloc_newsletter_show',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'codexbloc_newsletter_show',
		array(
			'label'    => __( 'Show newsletter signup above the footer', 'codexbloc' ),
			'section'  => 'codexbloc_section',
			'type'     => 'checkbox',
			'priority' => 2,
		)
	);

	$wp_customize->add_setting(
		'codexbloc_accent',
		array(
			'default'           => $d['accent'],
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'codexbloc_accent',
			array(
				'label'    => __( 'Accent colour', 'codexbloc' ),
				'section'  => 'codexbloc_section',
				'priority' => 1,
			)
		)
	);
}
add_action( 'customize_register', 'codexbloc_customize_register' );
