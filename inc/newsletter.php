<?php
/**
 * Newsletter signup shown above the footer (template-parts/newsletter.php).
 *
 * Two modes:
 * - If "Newsletter: form action URL" is set in the Customizer (e.g. a Mailchimp,
 *   MailerLite or Kit embed form URL), the form posts straight to that provider.
 * - Otherwise the theme handles the signup itself: it stores the address in the
 *   `codexbloc_subscribers` option, emails the contact recipient, and fires the
 *   `codexbloc_newsletter_subscribed` action so a plugin can sync it elsewhere.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the newsletter section should be displayed.
 */
function codexbloc_newsletter_enabled() {
	return (bool) apply_filters( 'codexbloc_newsletter_enabled', (bool) get_theme_mod( 'codexbloc_newsletter_show', true ) );
}

/**
 * Status of the last signup, read from the redirect query string.
 *
 * @return string '', 'ok', 'invalid', 'limit' or 'error'.
 */
function codexbloc_newsletter_status() {
	$status = isset( $_GET['cb_newsletter'] ) ? sanitize_key( wp_unslash( $_GET['cb_newsletter'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	return in_array( $status, array( 'ok', 'invalid', 'limit', 'error' ), true ) ? $status : '';
}

/**
 * Redirect back to the page the form was submitted from.
 *
 * @param string $status Result code.
 */
function codexbloc_newsletter_redirect( $status ) {
	$back = wp_get_referer();
	if ( ! $back ) {
		$back = home_url( '/' );
	}
	$back = remove_query_arg( 'cb_newsletter', $back );
	wp_safe_redirect( add_query_arg( 'cb_newsletter', $status, $back ) . '#newsletter' );
	exit;
}

/**
 * Handle a built-in newsletter signup (admin-post.php?action=codexbloc_newsletter).
 */
function codexbloc_newsletter_handle() {
	$nonce_ok = isset( $_POST['_cb_newsletter_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_cb_newsletter_nonce'] ) ), 'codexbloc_newsletter' );
	if ( ! $nonce_ok ) {
		codexbloc_newsletter_redirect( 'error' );
	}

	// Spam checks: hidden field must stay empty, and humans take more than 2 seconds.
	$honeypot = isset( $_POST['cb_nl_website'] ) ? trim( (string) wp_unslash( $_POST['cb_nl_website'] ) ) : '';
	$started  = isset( $_POST['cb_nl_started'] ) ? absint( $_POST['cb_nl_started'] ) : 0;
	if ( '' !== $honeypot || ( $started && time() - $started < 2 ) ) {
		codexbloc_newsletter_redirect( 'ok' );
	}

	$email = isset( $_POST['cb_nl_email'] ) ? sanitize_email( wp_unslash( $_POST['cb_nl_email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		codexbloc_newsletter_redirect( 'invalid' );
	}

	// Rate limit: 5 signups per hour per IP.
	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rate_key = 'cb_newsletter_' . md5( $ip );
	$count    = (int) get_transient( $rate_key );
	if ( $count >= 5 ) {
		codexbloc_newsletter_redirect( 'limit' );
	}
	set_transient( $rate_key, $count + 1, HOUR_IN_SECONDS );

	$email       = strtolower( $email );
	$subscribers = get_option( 'codexbloc_subscribers', array() );
	if ( ! is_array( $subscribers ) ) {
		$subscribers = array();
	}

	// Already subscribed: report success without notifying again.
	if ( isset( $subscribers[ $email ] ) ) {
		codexbloc_newsletter_redirect( 'ok' );
	}

	$subscribers[ $email ] = time();
	update_option( 'codexbloc_subscribers', $subscribers, false );

	wp_mail(
		codexbloc_contact_recipient(),
		sprintf( '[%s] New newsletter subscriber', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) ),
		sprintf( "New subscriber: %s\nSigned up on %s", $email, wp_date( 'Y-m-d H:i T' ) ),
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);

	do_action( 'codexbloc_newsletter_subscribed', $email );

	codexbloc_newsletter_redirect( 'ok' );
}
add_action( 'admin_post_codexbloc_newsletter', 'codexbloc_newsletter_handle' );
add_action( 'admin_post_nopriv_codexbloc_newsletter', 'codexbloc_newsletter_handle' );
