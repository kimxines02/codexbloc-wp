<?php
/**
 * Blog post card.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-md' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="block aspect-[16/10] overflow-hidden bg-slate-50" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'codexbloc-card', array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="flex grow flex-col p-5">
		<p class="text-xs font-medium uppercase tracking-wide text-accent">
			<?php
			$cats = get_the_category();
			echo $cats ? esc_html( $cats[0]->name ) : esc_html( get_the_date() );
			?>
		</p>
		<h2 class="mt-1.5 text-lg font-semibold leading-snug text-ink"><a class="hover:text-accent" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="mt-2 text-sm leading-relaxed text-slate-600"><?php the_excerpt(); ?></div>
		<p class="mt-auto pt-4 text-xs text-slate-500"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
	</div>
</article>
