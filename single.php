<?php
/**
 * Single blog post.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="cb-container py-10 sm:py-14">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'mx-auto max-w-3xl' ); ?>>
			<header class="mb-8">
				<?php $cats = get_the_category(); ?>
				<?php if ( $cats ) : ?>
					<p class="text-xs font-medium uppercase tracking-wide text-accent"><a href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a></p>
				<?php endif; ?>
				<h1 class="mt-2 text-3xl font-semibold leading-tight tracking-tight text-ink sm:text-4xl"><?php the_title(); ?></h1>
				<p class="mt-3 text-sm text-slate-500">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span aria-hidden="true">&middot;</span>
					<?php the_author(); ?>
				</p>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-8 overflow-hidden rounded-2xl bg-slate-50">
					<?php the_post_thumbnail( 'large', array( 'class' => 'h-auto w-full' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="cb-prose">
				<?php the_content(); ?>
			</div>

			<?php the_tags( '<p class="mt-8 flex flex-wrap gap-2 text-xs">', '', '</p>' ); ?>
		</article>

		<nav class="mx-auto mt-12 grid grid-cols-1 max-w-3xl gap-4 border-t border-slate-200 pt-6 text-sm sm:grid-cols-2" aria-label="<?php esc_attr_e( 'Post navigation', 'codexbloc' ); ?>">
			<div><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
			<div class="sm:text-right"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
		</nav>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>

<?php
get_footer();
