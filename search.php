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

<main id="main" class="cb-container py-10 sm:py-14">
	<header class="mb-8 max-w-2xl">
		<h1 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">
			<?php
			/* translators: %s: search query */
			printf( esc_html__( 'Search results for "%s"', 'codexbloc' ), esc_html( get_search_query() ) );
			?>
		</h1>
		<div class="mt-5 max-w-md"><?php get_search_form(); ?></div>
	</header>

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
</main>

<?php
get_footer();
