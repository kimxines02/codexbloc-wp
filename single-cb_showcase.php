<?php
/**
 * Single sample site (/showcase/{sample}/).
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
		$cb_id        = get_the_ID();
		$cb_demo      = codexbloc_showcase_field( $cb_id, 'demo_url' );
		$cb_theme     = codexbloc_showcase_field( $cb_id, 'theme_name' );
		$cb_theme_url = codexbloc_showcase_field( $cb_id, 'theme_url' );
		$cb_features  = codexbloc_showcase_lines( codexbloc_showcase_field( $cb_id, 'features' ) );
		$cb_terms     = get_the_terms( $cb_id, 'cb_showcase_type' );
		$cb_terms     = ( $cb_terms && ! is_wp_error( $cb_terms ) ) ? $cb_terms : array();
		?>
		<nav class="mb-6 text-sm text-slate-500" aria-label="<?php esc_attr_e( 'Breadcrumb', 'codexbloc' ); ?>">
			<a class="hover:text-ink" href="<?php echo esc_url( codexbloc_showcase_url() ); ?>"><?php esc_html_e( 'Showcase', 'codexbloc' ); ?></a>
			<?php if ( $cb_terms ) : ?>
				<span aria-hidden="true">/</span>
				<a class="hover:text-ink" href="<?php echo esc_url( get_term_link( $cb_terms[0] ) ); ?>"><?php echo esc_html( $cb_terms[0]->name ); ?></a>
			<?php endif; ?>
		</nav>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
				<div class="max-w-2xl">
					<h1 class="text-3xl font-semibold leading-tight tracking-tight text-ink sm:text-4xl"><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?>
						<p class="mt-3 text-lg leading-relaxed text-slate-600"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>
				<div class="flex flex-wrap gap-3">
					<?php if ( $cb_demo ) : ?>
						<a class="btn btn-primary" href="<?php echo esc_url( $cb_demo ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open live demo', 'codexbloc' ); ?><?php echo codexbloc_icon( 'external', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<?php endif; ?>
					<?php if ( $cb_theme_url ) : ?>
						<a class="btn btn-outline" href="<?php echo esc_url( $cb_theme_url ); ?>"><?php esc_html_e( 'Get this theme', 'codexbloc' ); ?></a>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
					<div class="flex items-center gap-1.5 border-b border-slate-200 bg-slate-100 px-4 py-2.5">
						<span class="h-3 w-3 rounded-full bg-[#ff5f57]"></span>
						<span class="h-3 w-3 rounded-full bg-[#febc2e]"></span>
						<span class="h-3 w-3 rounded-full bg-[#28c840]"></span>
						<span class="mx-auto w-full max-w-sm truncate rounded-md bg-white px-3 py-1 text-center text-xs text-slate-500"><?php echo esc_html( $cb_demo ? codexbloc_showcase_host( $cb_demo ) : get_the_title() ); ?></span>
					</div>
					<div class="max-h-[75vh] overflow-y-auto overscroll-contain bg-slate-50" tabindex="0" aria-label="<?php esc_attr_e( 'Scrollable page preview', 'codexbloc' ); ?>">
						<?php the_post_thumbnail( 'codexbloc-showcase-lg', array( 'class' => 'block h-auto w-full' ) ); ?>
					</div>
				</figure>
				<p class="mt-2 text-center text-xs text-slate-500"><?php esc_html_e( 'Scroll inside the window to see the full page.', 'codexbloc' ); ?></p>
			<?php endif; ?>

			<div class="mt-12 grid grid-cols-1 gap-10 lg:grid-cols-3">
				<div class="cb-prose lg:col-span-2">
					<?php the_content(); ?>
				</div>

				<aside class="space-y-6">
					<div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
						<dl class="space-y-4 text-sm">
							<?php if ( $cb_terms ) : ?>
								<div>
									<dt class="text-slate-500"><?php esc_html_e( 'Site type', 'codexbloc' ); ?></dt>
									<dd class="mt-0.5 font-medium text-ink">
										<?php
										$cb_links = array();
										foreach ( $cb_terms as $cb_term ) {
											$cb_links[] = '<a class="hover:text-accent" href="' . esc_url( get_term_link( $cb_term ) ) . '">' . esc_html( $cb_term->name ) . '</a>';
										}
										echo implode( ', ', $cb_links ); // phpcs:ignore WordPress.Security.EscapeOutput
										?>
									</dd>
								</div>
							<?php endif; ?>
							<?php if ( $cb_theme ) : ?>
								<div>
									<dt class="text-slate-500"><?php esc_html_e( 'Theme', 'codexbloc' ); ?></dt>
									<dd class="mt-0.5 font-medium text-ink">
										<?php if ( $cb_theme_url ) : ?>
											<a class="hover:text-accent" href="<?php echo esc_url( $cb_theme_url ); ?>"><?php echo esc_html( $cb_theme ); ?></a>
										<?php else : ?>
											<?php echo esc_html( $cb_theme ); ?>
										<?php endif; ?>
									</dd>
								</div>
							<?php endif; ?>
							<?php if ( $cb_demo ) : ?>
								<div>
									<dt class="text-slate-500"><?php esc_html_e( 'Live demo', 'codexbloc' ); ?></dt>
									<dd class="mt-0.5"><a class="inline-flex items-center gap-1 font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $cb_demo ); ?>" target="_blank" rel="noopener"><?php echo esc_html( codexbloc_showcase_host( $cb_demo ) ); ?><?php echo codexbloc_icon( 'external', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></dd>
								</div>
							<?php endif; ?>
						</dl>
						<?php if ( $cb_features ) : ?>
							<h2 class="mt-6 border-t border-slate-200 pt-5 text-sm font-semibold text-ink"><?php esc_html_e( 'Highlights', 'codexbloc' ); ?></h2>
							<ul class="cb-checklist">
								<?php foreach ( $cb_features as $cb_feature ) : ?>
									<li><?php echo codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 shrink-0 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $cb_feature ); ?></span></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</aside>
			</div>
		</article>

		<?php
		// More samples, same site type first.
		$cb_more_args = array(
			'post_type'           => 'cb_showcase',
			'posts_per_page'      => 3,
			'post__not_in'        => array( $cb_id ),
			'ignore_sticky_posts' => true,
			'orderby'             => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		);
		if ( $cb_terms ) {
			$cb_more_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'taxonomy' => 'cb_showcase_type',
					'terms'    => wp_list_pluck( $cb_terms, 'term_id' ),
				),
			);
		}
		$cb_more = new WP_Query( $cb_more_args );
		if ( ! $cb_more->have_posts() && $cb_terms ) {
			unset( $cb_more_args['tax_query'] );
			$cb_more = new WP_Query( $cb_more_args );
		}
		if ( $cb_more->have_posts() ) :
			?>
			<section class="mt-16 border-t border-slate-200 pt-12 sm:mt-24">
				<div class="flex items-end justify-between gap-4">
					<h2 class="text-2xl font-semibold tracking-tight text-ink"><?php esc_html_e( 'More samples', 'codexbloc' ); ?></h2>
					<a class="inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( codexbloc_showcase_url() ); ?>"><?php esc_html_e( 'View all', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				</div>
				<div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
					<?php
					while ( $cb_more->have_posts() ) {
						$cb_more->the_post();
						get_template_part( 'template-parts/showcase-card' );
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>
	<?php endwhile; ?>
</main>

<?php
get_footer();
