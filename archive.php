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

<main id="main">
	<?php
	codexbloc_banner(
		array(
			'align' => 'left',
			'title' => wp_strip_all_tags( get_the_archive_title() ),
			'text'  => wp_strip_all_tags( get_the_archive_description() ),
		)
	);
	?>

	<div class="cb-container py-12 sm:py-16">

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
	</div>
</main>

<?php
get_footer();
