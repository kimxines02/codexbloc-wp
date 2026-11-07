<?php
/**
 * Blog index (fallback template).
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
			<?php echo is_home() && ! is_front_page() ? esc_html( single_post_title( '', false ) ) : esc_html__( 'Latest articles', 'codexbloc' ); ?>
		</h1>
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
		<p class="text-slate-600"><?php esc_html_e( 'Nothing here yet.', 'codexbloc' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
