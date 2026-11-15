<?php
/**
 * Search results.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main">
	<?php
	ob_start();
	get_search_form();
	$search_form = '<div class="mt-6 max-w-md">' . ob_get_clean() . '</div>';
	codexbloc_banner(
		array(
			'align' => 'left',
			/* translators: %s: search query */
			'title' => sprintf( __( 'Search results for "%s"', 'codexbloc' ), get_search_query( false ) ),
			'extra' => $search_form,
		)
	);
	?>

	<div class="cb-container py-12 sm:py-16">

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
			<?php
			while ( have_posts() ) {
				the_post();
				if ( 'product' === get_post_type() && function_exists( 'wc_get_product' ) ) {
					echo '<ul class="products !contents">';
					wc_get_template_part( 'content', 'product' );
					echo '</ul>';
				} else {
					get_template_part( 'template-parts/card' );
				}
			}
			?>
		</div>
		<div class="mt-10"><?php codexbloc_pagination(); ?></div>
	<?php else : ?>
		<p class="text-slate-600"><?php esc_html_e( 'No results. Try a different word.', 'codexbloc' ); ?></p>
	<?php endif; ?>
	</div>
</main>

<?php
get_footer();
