<?php
/**
 * Category, tag, author and date archives.
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
		<?php the_archive_title( '<h1 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="mt-3 text-slate-600">', '</div>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/card' );
			}
			?>
		</div>
		<div class="mt-10"><?php codexbloc_pagination(); ?></div>
	<?php else : ?>
		<p class="text-slate-600"><?php esc_html_e( 'Nothing found here.', 'codexbloc' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
