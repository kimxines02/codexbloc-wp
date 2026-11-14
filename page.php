<?php
/**
 * Static pages (also used for the WooCommerce cart, checkout and account pages).
 *
 * Regular pages get a header band, and long pages (3+ H2 sections) get a
 * sticky "On this page" table of contents beside the content.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_shop_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
$contact      = codexbloc_link( codexbloc_mod( 'contact_url' ) );
?>

<main id="main">
	<?php
	while ( have_posts() ) :
		the_post();

		$rendered = apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
		$rendered = str_replace( ']]>', ']]&gt;', $rendered );
		$toc      = array();

		if ( ! $is_shop_page ) {
			$parsed   = codexbloc_content_toc( $rendered );
			$rendered = $parsed['content'];
			$toc      = $parsed['toc'];
		}
		$has_toc = count( $toc ) >= 3;
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- Page header -->
			<header class="border-b border-slate-200 bg-slate-50">
				<div class="cb-container py-12 sm:py-16">
					<div class="<?php echo $has_toc || $is_shop_page ? '' : 'mx-auto max-w-3xl'; ?>">
						<nav aria-label="<?php esc_attr_e( 'Breadcrumb', 'codexbloc' ); ?>">
							<ol class="flex flex-wrap items-center gap-1.5 text-sm text-slate-500" role="list">
								<li><a class="transition hover:text-ink" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'codexbloc' ); ?></a></li>
								<?php foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) : ?>
									<li aria-hidden="true" class="text-slate-300">/</li>
									<li><a class="transition hover:text-ink" href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>"><?php echo esc_html( get_the_title( $ancestor ) ); ?></a></li>
								<?php endforeach; ?>
								<li aria-hidden="true" class="text-slate-300">/</li>
								<li class="text-slate-700" aria-current="page"><?php the_title(); ?></li>
							</ol>
						</nav>

						<h1 class="mt-4 text-3xl font-semibold tracking-tight text-ink sm:text-5xl"><?php the_title(); ?></h1>

						<?php if ( has_excerpt() ) : ?>
							<p class="mt-4 max-w-2xl text-lg leading-relaxed text-slate-600"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>

						<?php if ( ! $is_shop_page ) : ?>
							<p class="mt-5 inline-flex items-center gap-2 text-sm text-slate-500">
								<?php echo codexbloc_icon( 'clock', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<?php
								printf(
									/* translators: %s: last modified date. */
									esc_html__( 'Last updated %s', 'codexbloc' ),
									'<time datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date() ) . '</time>'
								);
								?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</header>

			<!-- Page body -->
			<div class="cb-container py-12 sm:py-16">
				<?php if ( $is_shop_page ) : ?>
					<div class="cb-woo-page"><?php echo $rendered; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>

				<?php elseif ( $has_toc ) : ?>
					<div class="grid grid-cols-1 gap-10 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-16">
						<aside class="lg:order-none">
							<div class="lg:sticky lg:top-28">
								<details class="group rounded-2xl border border-slate-200 bg-white lg:border-0 lg:bg-transparent" open>
									<summary class="flex cursor-pointer list-none items-center justify-between px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500 lg:pointer-events-none lg:px-0 lg:py-0 [&::-webkit-details-marker]:hidden">
										<?php esc_html_e( 'On this page', 'codexbloc' ); ?>
										<svg class="h-4 w-4 transition group-open:rotate-180 lg:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
									</summary>
									<nav aria-label="<?php esc_attr_e( 'On this page', 'codexbloc' ); ?>" class="px-5 pb-4 lg:mt-4 lg:px-0 lg:pb-0">
										<ol class="cb-toc space-y-1 border-l border-slate-200" role="list">
											<?php foreach ( $toc as $item ) : ?>
												<li><a class="-ml-px block border-l border-transparent py-1 pl-4 text-sm leading-snug text-slate-500 transition hover:border-slate-400 hover:text-ink" href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a></li>
											<?php endforeach; ?>
										</ol>
									</nav>
								</details>

								<?php if ( $contact ) : ?>
									<div class="mt-8 hidden rounded-2xl border border-slate-200 bg-slate-50 p-5 lg:block">
										<p class="text-sm font-semibold text-ink"><?php esc_html_e( 'Have a question?', 'codexbloc' ); ?></p>
										<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'We are happy to help with anything on this page.', 'codexbloc' ); ?></p>
										<a class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-3.5 w-3.5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
									</div>
								<?php endif; ?>
							</div>
						</aside>

						<div class="cb-prose cb-prose-sections max-w-3xl"><?php echo $rendered; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
					</div>

				<?php else : ?>
					<div class="cb-prose mx-auto max-w-3xl"><?php echo $rendered; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<?php endif; ?>

				<?php if ( ! $is_shop_page && ( comments_open() || get_comments_number() ) ) : ?>
					<div class="mx-auto mt-16 max-w-3xl"><?php comments_template(); ?></div>
				<?php endif; ?>
			</div>

		</article>
	<?php endwhile; ?>
</main>

<?php if ( $has_toc ) : ?>
<script>
(function () {
	var links = document.querySelectorAll('.cb-toc a');
	if (!links.length || !('IntersectionObserver' in window)) return;
	var map = {};
	links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
	var setActive = function (id) {
		links.forEach(function (a) { a.classList.remove('is-active'); });
		if (map[id]) map[id].classList.add('is-active');
	};
	var obs = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) { if (e.isIntersecting) setActive(e.target.id); });
	}, { rootMargin: '-110px 0px -65% 0px' });
	Object.keys(map).forEach(function (id) {
		var el = document.getElementById(id);
		if (el) obs.observe(el);
	});
})();
</script>
<?php endif; ?>

<?php
get_footer();
