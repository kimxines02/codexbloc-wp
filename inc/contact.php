<?php
/**
 * Contact form handling for the Contact page (page-contact.php).
 *
 * Validates the submission, blocks simple spam (honeypot, minimum fill time,
 * per-IP rate limit) and sends the message with wp_mail().
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Address that receives contact form messages.
 */
function codexbloc_contact_recipient() {
	return apply_filters( 'codexbloc_contact_recipient', 'support@codexbloc.com' );
}

/**
 * Topics shown in the "What can we help with?" dropdown.
 */
function codexbloc_contact_topics() {
	return array(
		'support'  => __( 'Product support', 'codexbloc' ),
		'presales' => __( 'Pre-sales question', 'codexbloc' ),
		'billing'  => __( 'Billing & licenses', 'codexbloc' ),
		'project'  => __( 'Custom project / services', 'codexbloc' ),
		'other'    => __( 'Something else', 'codexbloc' ),
	);
}

/**
 * Form state shared between the handler and the template.
 *
 * @param array|null $set Values to store.
 * @return array
 */
function codexbloc_contact_state( $set = null ) {
	static $state = array(
		'errors' => array(),
		'values' => array(
			'name'    => '',
			'email'   => '',
			'topic'   => '',
			'subject' => '',
			'message' => '',
		),
	);
	if ( null !== $set ) {
		$state = array_merge( $state, $set );
	}
	return $state;
}

/**
 * Process a submitted contact form before the page renders.
 */
function codexbloc_contact_handle() {
	if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : '' ) || empty( $_POST['codexbloc_contact'] ) || ! is_page() ) {
		return;
	}

	$values = array(
		'name'    => isset( $_POST['cb_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cb_name'] ) ) : '',
		'email'   => isset( $_POST['cb_email'] ) ? sanitize_email( wp_unslash( $_POST['cb_email'] ) ) : '',
		'topic'   => isset( $_POST['cb_topic'] ) ? sanitize_key( wp_unslash( $_POST['cb_topic'] ) ) : '',
		'subject' => isset( $_POST['cb_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['cb_subject'] ) ) : '',
		'message' => isset( $_POST['cb_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cb_message'] ) ) : '',
	);
	$errors = array();

	$nonce_ok = isset( $_POST['_cb_contact_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_cb_contact_nonce'] ) ), 'codexbloc_contact' );
	if ( ! $nonce_ok ) {
		$errors['form'] = __( 'Your session expired. Please submit the form again.', 'codexbloc' );
	}

	// Spam checks: hidden field must stay empty, and humans take more than 3 seconds.
	$honeypot = isset( $_POST['cb_website'] ) ? trim( (string) wp_unslash( $_POST['cb_website'] ) ) : '';
	$started  = isset( $_POST['cb_started'] ) ? absint( $_POST['cb_started'] ) : 0;
	if ( '' !== $honeypot || ( $started && time() - $started < 3 ) ) {
		// Pretend it worked so bots learn nothing.
		wp_safe_redirect( add_query_arg( 'sent', '1', get_permalink() ) . '#contact-form' );
		exit;
	}

	if ( '' === $values['name'] ) {
		$errors['name'] = __( 'Please enter your name.', 'codexbloc' );
	}
	if ( ! is_email( $values['email'] ) ) {
		$errors['email'] = __( 'Please enter a valid email address.', 'codexbloc' );
	}
	if ( ! array_key_exists( $values['topic'], codexbloc_contact_topics() ) ) {
		$errors['topic'] = __( 'Please choose a topic.', 'codexbloc' );
	}
	if ( mb_strlen( $values['message'] ) < 10 ) {
		$errors['message'] = __( 'Please write a message of at least 10 characters.', 'codexbloc' );
	} elseif ( mb_strlen( $values['message'] ) > 5000 ) {
		$errors['message'] = __( 'Please keep your message under 5,000 characters.', 'codexbloc' );
	}

	// Rate limit: 5 messages per hour per IP.
	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rate_key = 'cb_contact_' . md5( $ip );
	$count    = (int) get_transient( $rate_key );
	if ( ! $errors && $count >= 5 ) {
		$errors['form'] = __( 'You have sent several messages recently. Please wait a while, or email us directly.', 'codexbloc' );
	}

	if ( ! $errors ) {
		$topics  = codexbloc_contact_topics();
		$subject = sprintf(
			'[%1$s] %2$s: %3$s',
			wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
			$topics[ $values['topic'] ],
			'' !== $values['subject'] ? $values['subject'] : $values['name']
		);
		$body = implode(
			"\n",
			array(
				'Name:    ' . $values['name'],
				'Email:   ' . $values['email'],
				'Topic:   ' . $topics[ $values['topic'] ],
				'Subject: ' . ( '' !== $values['subject'] ? $values['subject'] : '-' ),
				'',
				$values['message'],
				'',
				'--',
				'Sent from ' . get_permalink() . ' on ' . wp_date( 'Y-m-d H:i T' ),
				'IP: ' . $ip,
			)
		);
		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			sprintf( 'Reply-To: %s <%s>', str_replace( array( '<', '>', '"', "\r", "\n" ), '', $values['name'] ), $values['email'] ),
		);

		if ( wp_mail( codexbloc_contact_recipient(), $subject, $body, $headers ) ) {
			set_transient( $rate_key, $count + 1, HOUR_IN_SECONDS );
			wp_safe_redirect( add_query_arg( 'sent', '1', get_permalink() ) . '#contact-form' );
			exit;
		}

		$errors['form'] = sprintf(
			/* translators: %s: support email address */
			__( 'Sorry, your message could not be sent right now. Please email us at %s.', 'codexbloc' ),
			codexbloc_contact_recipient()
		);
	}

	codexbloc_contact_state(
		array(
			'errors' => $errors,
			'values' => $values,
		)
	);
}
add_action( 'template_redirect', 'codexbloc_contact_handle' );

/**
 * Print the error message for a field, if any.
 *
 * @param string $field Field key.
 */
function codexbloc_contact_field_error( $field ) {
	$state = codexbloc_contact_state();
	if ( ! empty( $state['errors'][ $field ] ) ) {
		printf(
			'<p id="cb-%1$s-error" class="mt-1.5 text-sm text-red-600">%2$s</p>',
			esc_attr( $field ),
			esc_html( $state['errors'][ $field ] )
		);
	}
}

/**
 * aria attributes for a field that may have an error.
 *
 * @param string $field Field key.
 */
function codexbloc_contact_field_aria( $field ) {
	$state = codexbloc_contact_state();
	if ( ! empty( $state['errors'][ $field ] ) ) {
		printf( ' aria-invalid="true" aria-describedby="cb-%s-error"', esc_attr( $field ) );
	}
}
