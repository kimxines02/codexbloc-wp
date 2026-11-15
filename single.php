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

<main id="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			$cats   = get_the_category();
			$crumbs = array( array( __( 'Home', 'codexbloc' ), home_url( '/' ) ) );
			if ( $cats ) {
				$crumbs[] = array( $cats[0]->name, get_category_link( $cats[0] ) );
			}
			codexbloc_banner(
				array(
					'tag'    => 'header',
					'align'  => 'left',
					'width'  => 'mx-auto max-w-3xl',
					'crumbs' => $crumbs,
					'title'  => get_the_title(),
					'extra'  => '<p class="mt-4 text-sm text-slate-500"><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time> <span aria-hidden="true">&middot;</span> ' . esc_html( get_the_author() ) . '</p>',
				)
			);
			?>

			<div class="cb-container py-12 sm:py-16"><div class="mx-auto max-w-3xl">

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-8 overflow-hidden rounded-2xl bg-slate-50">
					<?php the_post_thumbnail( 'large', array( 'class' => 'h-auto w-full' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="cb-prose">
				<?php the_content(); ?>
			</div>

			<?php the_tags( '<p class="mt-8 flex flex-wrap gap-2 text-xs">', '', '</p>' ); ?>
			</div></div>
		</article>

		<div class="cb-container pb-16"><nav class="mx-auto grid grid-cols-1 max-w-3xl gap-4 border-t border-slate-200 pt-6 text-sm sm:grid-cols-2" aria-label="<?php esc_attr_e( 'Post navigation', 'codexbloc' ); ?>">
			<div><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
			<div class="sm:text-right"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
		</nav>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		echo '</div>';
	endwhile;
	?>
</main>

<?php
get_footer();
