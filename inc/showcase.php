<?php
/**
 * Showcase: sample websites built with our themes.
 *
 * Adds a "Showcase" menu in wp-admin. Each entry is one sample site:
 * - Title, description (editor) and a short excerpt for the card.
 * - Featured image = the screenshot. Upload a FULL-PAGE (tall) screenshot,
 *   e.g. 1440px wide; cards scroll through it on hover.
 * - "Site type" categories (e.g. Author Website, Portfolio) become filters.
 * - Extra details (demo link, theme used, features) in the "Sample site details" box.
 *
 * Public pages: /showcase/ (all samples) and /showcase/{sample}/.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the post type and taxonomy.
 */
function codexbloc_register_showcase() {
	register_post_type(
		'cb_showcase',
		array(
			'labels'        => array(
				'name'               => __( 'Showcase', 'codexbloc' ),
				'singular_name'      => __( 'Sample site', 'codexbloc' ),
				'menu_name'          => __( 'Showcase', 'codexbloc' ),
				'all_items'          => __( 'All sample sites', 'codexbloc' ),
				'add_new'            => __( 'Add sample site', 'codexbloc' ),
				'add_new_item'       => __( 'Add new sample site', 'codexbloc' ),
				'edit_item'          => __( 'Edit sample site', 'codexbloc' ),
				'new_item'           => __( 'New sample site', 'codexbloc' ),
				'view_item'          => __( 'View sample site', 'codexbloc' ),
				'search_items'       => __( 'Search sample sites', 'codexbloc' ),
				'not_found'          => __( 'No sample sites found.', 'codexbloc' ),
				'not_found_in_trash' => __( 'No sample sites in Trash.', 'codexbloc' ),
				'featured_image'     => __( 'Screenshot (full page)', 'codexbloc' ),
				'set_featured_image' => __( 'Set screenshot', 'codexbloc' ),
				'remove_featured_image' => __( 'Remove screenshot', 'codexbloc' ),
				'use_featured_image' => __( 'Use as screenshot', 'codexbloc' ),
			),
			'public'        => true,
			'has_archive'   => 'showcase',
			'rewrite'       => array(
				'slug'       => 'showcase',
				'with_front' => false,
			),
			'menu_icon'     => 'dashicons-desktop',
			'menu_position' => 21,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'cb_showcase_type',
		'cb_showcase',
		array(
			'labels'            => array(
				'name'          => __( 'Site types', 'codexbloc' ),
				'singular_name' => __( 'Site type', 'codexbloc' ),
				'menu_name'     => __( 'Site types', 'codexbloc' ),
				'all_items'     => __( 'All site types', 'codexbloc' ),
				'edit_item'     => __( 'Edit site type', 'codexbloc' ),
				'add_new_item'  => __( 'Add new site type', 'codexbloc' ),
				'search_items'  => __( 'Search site types', 'codexbloc' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'showcase/type',
				'with_front' => false,
			),
		)
	);

	// Full-width screenshot sizes with no height crop, so tall page captures stay intact.
	add_image_size( 'codexbloc-showcase', 900, 9999, false );
	add_image_size( 'codexbloc-showcase-lg', 1600, 99999, false );
}
add_action( 'init', 'codexbloc_register_showcase' );

/**
 * Flush rewrite rules once after this feature is added (and on theme switch),
 * and create a starter "Author Website" site type.
 */
function codexbloc_showcase_maybe_flush() {
	$version = '1';
	if ( get_option( 'codexbloc_showcase_version' ) === $version ) {
		return;
	}
	if ( ! term_exists( 'author-website', 'cb_showcase_type' ) ) {
		wp_insert_term( __( 'Author Website', 'codexbloc' ), 'cb_showcase_type', array( 'slug' => 'author-website' ) );
	}
	flush_rewrite_rules( false );
	update_option( 'codexbloc_showcase_version', $version );
}
add_action( 'init', 'codexbloc_showcase_maybe_flush', 20 );
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

/**
 * Show samples in menu order first (drag order via "Order"), then newest; 24 per page.
 *
 * @param WP_Query $query Query.
 */
function codexbloc_showcase_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'cb_showcase' ) || $query->is_tax( 'cb_showcase_type' ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
		$query->set( 'posts_per_page', 24 );
	}
}
add_action( 'pre_get_posts', 'codexbloc_showcase_query' );

/**
 * Field definitions for the details box.
 */
function codexbloc_showcase_field_defs() {
	return array(
		'demo_url'   => array(
			'label' => __( 'Live demo URL', 'codexbloc' ),
			'type'  => 'url',
			'help'  => __( 'Where visitors can open the sample site, e.g. https://demo.example.com/author/', 'codexbloc' ),
		),
		'theme_name' => array(
			'label' => __( 'Theme used', 'codexbloc' ),
			'type'  => 'text',
			'help'  => __( 'e.g. Inkwell Author Theme', 'codexbloc' ),
		),
		'theme_url'  => array(
			'label' => __( 'Theme link', 'codexbloc' ),
			'type'  => 'url',
			'help'  => __( 'Product page for the theme, so visitors can buy or download it.', 'codexbloc' ),
		),
		'features'   => array(
			'label' => __( 'Highlights', 'codexbloc' ),
			'type'  => 'textarea',
			'help'  => __( 'One per line, e.g. "Book pages with buy links". Shown as a checklist.', 'codexbloc' ),
		),
	);
}

/**
 * Read a showcase field.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Field key.
 */
function codexbloc_showcase_field( $post_id, $key ) {
	return (string) get_post_meta( $post_id, '_cb_sc_' . $key, true );
}

/**
 * Split text into non-empty lines.
 *
 * @param string $text Text.
 */
function codexbloc_showcase_lines( $text ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	return array_values( array_filter( array_map( 'trim', $lines ) ) );
}

/**
 * Details meta box.
 */
function codexbloc_showcase_add_meta_box() {
	add_meta_box(
		'codexbloc_showcase_details',
		__( 'Sample site details', 'codexbloc' ),
		'codexbloc_showcase_render_meta_box',
		'cb_showcase',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'codexbloc_showcase_add_meta_box' );

/**
 * Render the details box.
 *
 * @param WP_Post $post Post.
 */
function codexbloc_showcase_render_meta_box( $post ) {
	wp_nonce_field( 'codexbloc_showcase_details', 'codexbloc_showcase_nonce' );
	echo '<style>.cb-mb-row{margin:0 0 14px}.cb-mb-row label{display:block;font-weight:600;margin-bottom:4px}.cb-mb-row input,.cb-mb-row textarea{width:100%}.cb-mb-row .description{display:block;margin-top:3px}</style>';
	echo '<p>' . esc_html__( 'Tip: set the Featured image to a full-page screenshot (about 1440px wide). Write the excerpt as a one-line summary for the card.', 'codexbloc' ) . '</p>';
	foreach ( codexbloc_showcase_field_defs() as $key => $def ) {
		$id    = 'cb_sc_' . $key;
		$value = codexbloc_showcase_field( $post->ID, $key );
		echo '<div class="cb-mb-row">';
		printf( '<label for="%s">%s</label>', esc_attr( $id ), esc_html( $def['label'] ) );
		if ( 'textarea' === $def['type'] ) {
			printf( '<textarea id="%1$s" name="%1$s" rows="4">%2$s</textarea>', esc_attr( $id ), esc_textarea( $value ) );
		} else {
			printf( '<input type="%1$s" id="%2$s" name="%2$s" value="%3$s">', esc_attr( $def['type'] ), esc_attr( $id ), esc_attr( $value ) );
		}
		if ( $def['help'] ) {
			printf( '<span class="description">%s</span>', esc_html( $def['help'] ) );
		}
		echo '</div>';
	}
}

/**
 * Save the details box.
 *
 * @param int $post_id Post ID.
 */
function codexbloc_showcase_save_meta( $post_id ) {
	if ( ! isset( $_POST['codexbloc_showcase_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['codexbloc_showcase_nonce'] ), 'codexbloc_showcase_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( codexbloc_showcase_field_defs() as $key => $def ) {
		$field = 'cb_sc_' . $key;
		if ( ! isset( $_POST[ $field ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $field ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( 'url' === $def['type'] ) {
			$value = esc_url_raw( trim( $raw ) );
		} elseif ( 'textarea' === $def['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_cb_sc_' . $key );
		} else {
			update_post_meta( $post_id, '_cb_sc_' . $key, $value );
		}
	}
}
add_action( 'save_post_cb_showcase', 'codexbloc_showcase_save_meta' );

/**
 * Admin list: small screenshot column.
 *
 * @param array $columns Columns.
 */
function codexbloc_showcase_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		if ( 'title' === $key ) {
			$new['cb_thumb'] = __( 'Screenshot', 'codexbloc' );
		}
		$new[ $key ] = $label;
	}
	return $new;
}
add_filter( 'manage_cb_showcase_posts_columns', 'codexbloc_showcase_admin_columns' );

/**
 * Admin list: render the screenshot column.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function codexbloc_showcase_admin_column( $column, $post_id ) {
	if ( 'cb_thumb' === $column && has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, array( 80, 50 ), array( 'style' => 'width:80px;height:50px;object-fit:cover;object-position:top;border-radius:4px' ) );
	}
}
add_action( 'manage_cb_showcase_posts_custom_column', 'codexbloc_showcase_admin_column', 10, 2 );

/**
 * Host name of a URL for display ("demo.example.com").
 *
 * @param string $url URL.
 */
function codexbloc_showcase_host( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	return $host ? preg_replace( '/^www\./', '', $host ) : '';
}

/**
 * URL of the showcase archive.
 */
function codexbloc_showcase_url() {
	return (string) get_post_type_archive_link( 'cb_showcase' );
}
