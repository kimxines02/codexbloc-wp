<?php
/**
 * Search form.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$uid = wp_unique_id( 'cb-search-' );
?>
<form role="search" method="get" class="flex gap-2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Search', 'codexbloc' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $uid ); ?>" class="cb-input grow" placeholder="<?php esc_attr_e( 'Search products and articles', 'codexbloc' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
		<input type="hidden" name="post_type[]" value="post">
		<input type="hidden" name="post_type[]" value="product">
		<input type="hidden" name="post_type[]" value="page">
	<?php endif; ?>
	<button type="submit" class="btn btn-primary !px-4"><?php esc_html_e( 'Search', 'codexbloc' ); ?></button>
</form>
