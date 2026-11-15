<?php
/**
 * Template Name: About
 *
 * Used automatically for the page with the slug "about", or pick
 * "About" under Page Attributes > Template for any other page.
 * Anything typed in the page editor replaces the default story text.
 * Default copy lives in inc/defaults.php (codexbloc_about_*).
 *
 * Layout: compact gradient hero, mission, bento grid of what we make,
 * numbered principles, flat FAQ, closing call to action.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$shop_url = codexbloc_shop_url();
$contact  = codexbloc_link( codexbloc_mod( 'contact_url' ) );
$quote    = add_query_arg( 'topic', 'project', $contact ); // Services: no prices, ask for a quote.
$showcase = post_type_exists( 'cb_showcase' ) ? get_post_type_archive_link( 'cb_showcase' ) : '';

// Page editor content (if any) replaces the default story text.
$editor_content = '';
while ( have_posts() ) {
	the_post();
	if ( trim( get_the_content() ) ) {
		$editor_content = apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
		$editor_content = str_replace( ']]>', ']]&gt;', $editor_content );
	}
}

$tile       = 'group relative flex flex-col overflow-hidden rounded-3xl border p-7 transition duration-300 hover:-translate-y-0.5 sm:p-8';
$tile_light = $tile . ' border-slate-200 bg-white hover:border-slate-300 hover:shadow-[0_12px_32px_-12px_rgba(0,0,0,0.12)]';
$tile_link  = 'mt-auto inline-flex items-center gap-1.5 pt-8 text-sm font-medium';
$label      = 'font-mono text-sm text-accent';
$arrow      = codexbloc_icon( 'arrow', 'h-4 w-4 transition group-hover:translate-x-0.5' );
?>

<main id="main">

	<!-- Hero -->
	<section class="cb-pastel-bg cb-under-header relative isolate overflow-hidden" aria-labelledby="cb-about-title">
		<div class="cb-container pb-12 pt-10 text-center sm:pb-16 sm:pt-14">
			<p class="inline-flex items-center gap-2 rounded-full border border-white/80 bg-white/60 px-3 py-1 font-mono text-xs text-slate-600 backdrop-blur">
				<span class="text-emerald-600">~/codexbloc</span><span class="text-slate-400">$</span> cat about.md
			</p>
			<h1 id="cb-about-title" class="mx-auto mt-5 max-w-3xl text-4xl font-semibold leading-[1.05] tracking-tight text-ink sm:text-5xl lg:text-6xl">
				<?php esc_html_e( 'Small tools.', 'codexbloc' ); ?>
				<span class="cb-gradient-text"><?php esc_html_e( 'Built properly.', 'codexbloc' ); ?></span>
			</h1>
			<p class="mx-auto mt-4 max-w-xl text-lg leading-relaxed text-slate-600"><?php esc_html_e( 'Lightweight plugins, themes and modules for online stores, plus websites built right.', 'codexbloc' ); ?></p>
			<div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
				<a class="btn btn-primary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Explore products', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				<a class="btn border border-slate-900/10 bg-white/60 text-ink backdrop-blur hover:border-slate-900/20 hover:bg-white hover:text-ink" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Work with us', 'codexbloc' ); ?></a>
			</div>
		</div>
	</section>

	<!-- Mission -->
	<section class="cb-container py-20 sm:py-28" aria-labelledby="cb-about-mission">
		<div class="grid grid-cols-1 gap-6 lg:grid-cols-[12rem_minmax(0,1fr)] lg:gap-16">
			<h2 id="cb-about-mission" class="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( '// Why we exist', 'codexbloc' ); ?></h2>
			<div class="max-w-3xl">
				<p class="text-2xl font-semibold leading-snug tracking-tight text-slate-400 sm:text-3xl lg:text-4xl">
					<span class="text-ink"><?php esc_html_e( 'Most stores don’t need more features.', 'codexbloc' ); ?></span>
					<?php esc_html_e( 'They need the right ones, built well, fast to load and easy to set up.', 'codexbloc' ); ?>
				</p>
				<?php if ( $editor_content ) : ?>
					<div class="cb-prose mt-8"><?php echo $editor_content; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<?php else : ?>
					<div class="mt-8 grid grid-cols-1 gap-6 text-slate-600 sm:grid-cols-2">
						<?php foreach ( array_slice( codexbloc_about_story(), 1 ) as $paragraph ) : ?>
							<p class="leading-relaxed"><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- What we make (bento) -->
	<section class="border-y border-slate-200 bg-slate-50 py-20 sm:py-28" aria-labelledby="cb-about-make">
		<div class="cb-container">
			<div class="grid grid-cols-1 gap-6 lg:grid-cols-[12rem_minmax(0,1fr)] lg:gap-16">
				<p class="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( '// What we make', 'codexbloc' ); ?></p>
				<h2 id="cb-about-make" class="max-w-2xl text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Build it yourself, or let us build it for you.', 'codexbloc' ); ?></h2>
			</div>

			<div class="mt-12 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
				<!-- Plugins: wide, dark -->
				<a class="<?php echo esc_attr( $tile . ' border-white/10 bg-[#0b0f17] text-white md:col-span-2' ); ?>" href="<?php echo esc_url( codexbloc_cat_url( 'wordpress-plugins' ) ); ?>">
					<div class="cb-dots pointer-events-none absolute inset-0" aria-hidden="true"></div>
					<div class="relative flex items-start justify-between gap-4">
						<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-white"><?php echo codexbloc_icon( 'puzzle', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="rounded-full bg-emerald-400/10 px-2.5 py-1 text-xs font-medium text-emerald-300"><?php esc_html_e( 'Free on WordPress.org', 'codexbloc' ); ?></span>
					</div>
					<h3 class="relative mt-6 text-2xl font-semibold tracking-tight text-white"><?php esc_html_e( 'WooCommerce plugins', 'codexbloc' ); ?></h3>
					<p class="relative mt-2 max-w-md text-slate-400"><?php esc_html_e( 'Focused tools that each do one job well and keep your store fast.', 'codexbloc' ); ?></p>
					<span class="<?php echo esc_attr( $tile_link . ' relative text-white' ); ?>"><?php esc_html_e( 'Browse plugins', 'codexbloc' ); ?><?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</a>

				<!-- PrestaShop -->
				<a class="<?php echo esc_attr( $tile_light ); ?>" href="<?php echo esc_url( codexbloc_cat_url( codexbloc_prestashop_slugs() ) ); ?>">
					<div class="flex items-start justify-between gap-4">
						<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'cube', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700"><?php esc_html_e( 'New', 'codexbloc' ); ?></span>
					</div>
					<h3 class="mt-6 text-xl font-semibold tracking-tight text-ink"><?php esc_html_e( 'PrestaShop modules', 'codexbloc' ); ?></h3>
					<p class="mt-2 text-slate-600"><?php esc_html_e( 'The same lightweight approach for PrestaShop 8 and 9.', 'codexbloc' ); ?></p>
					<span class="<?php echo esc_attr( $tile_link . ' text-accent' ); ?>"><?php esc_html_e( 'Browse modules', 'codexbloc' ); ?><?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</a>

				<!-- Themes -->
				<a class="<?php echo esc_attr( $tile_light ); ?>" href="<?php echo esc_url( $showcase ? $showcase : codexbloc_cat_url( 'wordpress-themes' ) ); ?>">
					<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'code', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="mt-6 text-xl font-semibold tracking-tight text-ink"><?php esc_html_e( 'WordPress themes', 'codexbloc' ); ?></h3>
					<p class="mt-2 text-slate-600"><?php esc_html_e( 'Clean, mobile-friendly designs you can preview first.', 'codexbloc' ); ?></p>
					<span class="<?php echo esc_attr( $tile_link . ' text-accent' ); ?>"><?php echo $showcase ? esc_html__( 'See sample sites', 'codexbloc' ) : esc_html__( 'Browse themes', 'codexbloc' ); ?><?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</a>

				<!-- Websites: wide, accent -->
				<a class="<?php echo esc_attr( $tile . ' border-accent bg-accent text-white md:col-span-2' ); ?>" href="<?php echo esc_url( $quote ); ?>">
					<div class="pointer-events-none absolute -bottom-24 -right-24 h-64 w-64 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>
					<div class="relative flex items-start justify-between gap-4">
						<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 text-white"><?php echo codexbloc_icon( 'bag', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="rounded-full bg-white/15 px-2.5 py-1 text-xs font-medium text-white"><?php esc_html_e( 'Free quote', 'codexbloc' ); ?></span>
					</div>
					<h3 class="relative mt-6 text-2xl font-semibold tracking-tight text-white"><?php esc_html_e( 'Websites built for you', 'codexbloc' ); ?></h3>
					<p class="relative mt-2 max-w-md text-white/80"><?php esc_html_e( 'Business sites and online stores, designed, built and looked after by us.', 'codexbloc' ); ?></p>
					<span class="<?php echo esc_attr( $tile_link . ' relative text-white' ); ?>"><?php esc_html_e( 'Tell us about your project', 'codexbloc' ); ?><?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				</a>
			</div>
		</div>
	</section>

	<!-- Principles -->
	<section class="cb-container py-20 sm:py-28" aria-labelledby="cb-about-principles">
		<div class="grid grid-cols-1 gap-6 lg:grid-cols-[12rem_minmax(0,1fr)] lg:gap-16">
			<p class="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( '// How we think', 'codexbloc' ); ?></p>
			<div>
				<h2 id="cb-about-principles" class="max-w-2xl text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Four rules we don’t break.', 'codexbloc' ); ?></h2>
				<ol class="mt-10 border-t border-slate-200" role="list">
					<?php foreach ( codexbloc_about_principles() as $i => $rule ) : ?>
						<li class="group grid grid-cols-[3rem_minmax(0,1fr)] gap-x-4 gap-y-1 border-b border-slate-200 py-6 sm:grid-cols-[4rem_14rem_minmax(0,1fr)] sm:items-baseline sm:gap-x-8">
							<span class="font-mono text-sm tabular-nums text-slate-400 transition group-hover:text-accent"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<h3 class="text-lg font-semibold tracking-tight text-ink"><?php echo esc_html( $rule['title'] ); ?></h3>
							<p class="col-start-2 leading-relaxed text-slate-600 sm:col-start-3"><?php echo esc_html( $rule['text'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<!-- FAQ -->
	<section class="border-t border-slate-200 bg-slate-50 py-20 sm:py-28" aria-labelledby="cb-about-faq">
		<div class="cb-container">
			<div class="grid grid-cols-1 gap-6 lg:grid-cols-[12rem_minmax(0,1fr)] lg:gap-16">
				<p class="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( '// FAQ', 'codexbloc' ); ?></p>
				<div>
					<h2 id="cb-about-faq" class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Quick answers', 'codexbloc' ); ?></h2>
					<dl class="mt-10 grid grid-cols-1 gap-x-12 gap-y-10 md:grid-cols-2">
						<?php foreach ( codexbloc_about_faqs() as $faq ) : ?>
							<div>
								<dt class="font-semibold text-ink"><?php echo esc_html( $faq['q'] ); ?></dt>
								<dd class="mt-2 leading-relaxed text-slate-600"><?php echo esc_html( $faq['a'] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		</div>
	</section>

	<!-- Call to action -->
	<section class="relative isolate overflow-hidden bg-[#0b0f17]" aria-labelledby="cb-about-cta">
		<div class="cb-grid-lines pointer-events-none absolute inset-0 -z-10" aria-hidden="true"></div>
		<div class="pointer-events-none absolute bottom-0 left-1/2 -z-10 h-[24rem] w-[48rem] max-w-[200%] -translate-x-1/2 translate-y-1/2 rounded-full bg-accent/30 blur-[120px]" aria-hidden="true"></div>
		<div class="cb-container py-20 text-center sm:py-28">
			<h2 id="cb-about-cta" class="mx-auto max-w-2xl text-4xl font-semibold tracking-tight text-white sm:text-5xl"><?php esc_html_e( 'Let’s build something', 'codexbloc' ); ?> <span class="cb-gradient-text"><?php esc_html_e( 'that lasts.', 'codexbloc' ); ?></span></h2>
			<p class="mx-auto mt-5 max-w-xl text-lg text-slate-400"><?php esc_html_e( 'Tell us what you need. We reply with clear next steps.', 'codexbloc' ); ?></p>
			<div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
				<a class="btn btn-primary" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				<a class="btn border border-white/15 bg-white/5 text-white hover:border-white/30 hover:bg-white/10 hover:text-white" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?></a>
			</div>
		</div>
	</section>

</main>

<?php
// About page ends on its own call to action: no newsletter band, footer sits flush.
add_filter( 'codexbloc_newsletter_enabled', '__return_false' );
add_filter( 'codexbloc_footer_flush', '__return_true' );
get_footer();
