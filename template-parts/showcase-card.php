<?php
/**
 * Showcase card: browser-framed screenshot that scrolls on hover.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cb_id    = get_the_ID();
$cb_demo  = codexbloc_showcase_field( $cb_id, 'demo_url' );
$cb_theme = codexbloc_showcase_field( $cb_id, 'theme_name' );
$cb_terms = get_the_terms( $cb_id, 'cb_showcase_type' );
$cb_terms = ( $cb_terms && ! is_wp_error( $cb_terms ) ) ? $cb_terms : array();
$cb_slugs = implode( ' ', wp_list_pluck( $cb_terms, 'slug' ) );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cb-sc-card group flex flex-col' ); ?> data-types="<?php echo esc_attr( $cb_slugs ); ?>">
	<a class="block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition group-hover:border-slate-300 group-hover:shadow-lg" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<span class="flex items-center gap-1.5 border-b border-slate-200 bg-slate-100 px-3 py-2">
			<span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
			<span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
			<span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
			<?php if ( $cb_demo ) : ?>
				<span class="ml-2 truncate rounded-md bg-white px-2 py-0.5 text-[11px] text-slate-500"><?php echo esc_html( codexbloc_showcase_host( $cb_demo ) ); ?></span>
			<?php endif; ?>
		</span>
		<span class="cb-sc-shot block aspect-[16/10] bg-slate-50">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'codexbloc-showcase', array( 'loading' => 'lazy', 'alt' => '' ) );
			}
			?>
		</span>
	</a>
	<div class="mt-4 px-1">
		<?php if ( $cb_terms ) : ?>
			<p class="text-xs font-medium uppercase tracking-wide text-accent"><?php echo esc_html( $cb_terms[0]->name ); ?></p>
		<?php endif; ?>
		<h2 class="mt-1 text-lg font-semibold leading-snug text-ink"><a class="hover:text-accent" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( has_excerpt() ) : ?>
			<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
		<div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm">
			<a class="inline-flex items-center gap-1 font-medium text-accent hover:text-accent-dark" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View details', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			<?php if ( $cb_demo ) : ?>
				<a class="inline-flex items-center gap-1 text-slate-600 hover:text-ink" href="<?php echo esc_url( $cb_demo ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Live demo', 'codexbloc' ); ?><?php echo codexbloc_icon( 'external', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			<?php endif; ?>
			<?php if ( $cb_theme ) : ?>
				<span class="text-slate-500"><?php echo esc_html( $cb_theme ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</article>
