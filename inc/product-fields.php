<?php
/**
 * Extra fields on the WooCommerce product edit screen ("Codexbloc details").
 * Lets you describe plugins, themes and PrestaShop modules consistently.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field definitions: key => label, type, help text.
 */
function codexbloc_product_field_defs() {
	return array(
		'wporg_url'        => array(
			'label' => __( 'WordPress.org URL', 'codexbloc' ),
			'type'  => 'url',
			'help'  => __( 'Optional, e.g. https://wordpress.org/plugins/your-plugin/. Free products (price 0) without a downloadable file send logged-in customers here. On paid products it shows a "Free version on WordPress.org" link.', 'codexbloc' ),
		),
		'demo_url'         => array(
			'label' => __( 'Live demo URL', 'codexbloc' ),
			'type'  => 'url',
			'help'  => '',
		),
		'docs_url'         => array(
			'label' => __( 'Documentation URL', 'codexbloc' ),
			'type'  => 'url',
			'help'  => '',
		),
		'version'          => array(
			'label' => __( 'Current version', 'codexbloc' ),
			'type'  => 'text',
			'help'  => __( 'e.g. 1.4.0', 'codexbloc' ),
		),
		'requires'         => array(
			'label' => __( 'Requirements', 'codexbloc' ),
			'type'  => 'text',
			'help'  => __( 'e.g. WordPress 6.0+, WooCommerce 8.0+, PHP 7.4+ (or PrestaShop 8.x)', 'codexbloc' ),
		),
		'features'         => array(
			'label' => __( 'Key features', 'codexbloc' ),
			'type'  => 'textarea',
			'help'  => __( 'One feature per line. Shown as a checklist next to the price.', 'codexbloc' ),
		),
	);
}

/**
 * Read a field.
 *
 * @param int    $product_id Product ID.
 * @param string $key        Field key.
 */
function codexbloc_product_field( $product_id, $key ) {
	return (string) get_post_meta( $product_id, '_cb_' . $key, true );
}

/**
 * Split a textarea into non-empty lines.
 *
 * @param string $text Text.
 */
function codexbloc_lines( $text ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	return array_values( array_filter( array_map( 'trim', $lines ) ) );
}

/**
 * Meta box.
 */
function codexbloc_add_product_meta_box() {
	add_meta_box(
		'codexbloc_product_details',
		__( 'Codexbloc details', 'codexbloc' ),
		'codexbloc_render_product_meta_box',
		'product',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'codexbloc_add_product_meta_box' );

/**
 * Render the meta box.
 *
 * @param WP_Post $post Product post.
 */
function codexbloc_render_product_meta_box( $post ) {
	wp_nonce_field( 'codexbloc_product_details', 'codexbloc_product_nonce' );
	echo '<style>.cb-mb-row{margin:0 0 14px}.cb-mb-row label{display:block;font-weight:600;margin-bottom:4px}.cb-mb-row input[type=text],.cb-mb-row input[type=url],.cb-mb-row textarea{width:100%}.cb-mb-row .description{display:block;margin-top:3px}</style>';
	foreach ( codexbloc_product_field_defs() as $key => $def ) {
		$value = codexbloc_product_field( $post->ID, $key );
		$id    = 'cb_field_' . $key;
		echo '<div class="cb-mb-row"><label for="' . esc_attr( $id ) . '">' . esc_html( $def['label'] ) . '</label>';
		if ( 'textarea' === $def['type'] ) {
			echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" rows="4">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input type="' . ( 'url' === $def['type'] ? 'url' : 'text' ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '">';
		}
		if ( $def['help'] ) {
			echo '<span class="description">' . esc_html( $def['help'] ) . '</span>';
		}
		echo '</div>';
	}
}

/**
 * Save the fields.
 *
 * @param int $post_id Product ID.
 */
function codexbloc_save_product_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['codexbloc_product_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['codexbloc_product_nonce'] ) ), 'codexbloc_product_details' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( codexbloc_product_field_defs() as $key => $def ) {
		$name = 'cb_field_' . $key;
		$raw  = isset( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( 'url' === $def['type'] ) {
			$value = esc_url_raw( $raw );
		} elseif ( 'textarea' === $def['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}

		if ( '' === $value ) {
			delete_post_meta( $post_id, '_cb_' . $key );
		} else {
			update_post_meta( $post_id, '_cb_' . $key, $value );
		}
	}
}
add_action( 'save_post_product', 'codexbloc_save_product_meta_box' );
