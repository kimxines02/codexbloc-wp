<?php
/**
 * Template Name: About
 *
 * Used automatically for the page with the slug "about", or pick
 * "About" under Page Attributes > Template for any other page.
 * Anything typed in the page editor replaces the default "Our story" text.
 * Default copy lives in inc/defaults.php (codexbloc_about_*).
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

$offers = array(
	array(
		'icon'   => 'puzzle',
		'title'  => __( 'WordPress plugins', 'codexbloc' ),
		'text'   => __( 'Focused tools for WooCommerce stores that do one job well and keep your site fast.', 'codexbloc' ),
		'points' => array(
			__( 'Free on WordPress.org', 'codexbloc' ),
			__( 'Lightweight and easy to set up', 'codexbloc' ),
			__( 'Tested with current releases', 'codexbloc' ),
		),
		'label'  => __( 'Browse plugins', 'codexbloc' ),
		'url'    => codexbloc_cat_url( 'wordpress-plugins' ),
	),
	array(
		'icon'   => 'code',
		'title'  => __( 'WordPress themes', 'codexbloc' ),
		'text'   => __( 'Clean, mobile-friendly themes for authors, businesses and online shops.', 'codexbloc' ),
		'points' => array(
			__( 'Fast on phones and desktops', 'codexbloc' ),
			__( 'Sample sites to preview', 'codexbloc' ),
			__( 'Easy to make your own', 'codexbloc' ),
		),
		'label'  => $showcase ? __( 'See sample sites', 'codexbloc' ) : __( 'Browse themes', 'codexbloc' ),
		'url'    => $showcase ? $showcase : codexbloc_cat_url( 'wordpress-themes' ),
	),
	array(
		'icon'   => 'bag',
		'title'  => __( 'Web design & development', 'codexbloc' ),
		'text'   => __( 'Need it done for you? We design, build and maintain websites and online stores.', 'codexbloc' ),
		'points' => array(
			__( 'Business websites and WooCommerce stores', 'codexbloc' ),
			__( 'Free, no-obligation quote', 'codexbloc' ),
			__( 'Ongoing care and maintenance', 'codexbloc' ),
		),
		'label'  => __( 'Talk to us', 'codexbloc' ),
		'url'    => $quote,
	),
);

$sections = array(
	'story'      => __( 'Our story', 'codexbloc' ),
	'what-we-do' => __( 'What we do', 'codexbloc' ),
	'values'     => __( 'Our values', 'codexbloc' ),
	'process'    => __( 'How we work', 'codexbloc' ),
	'faq'        => __( 'FAQ', 'codexbloc' ),
);

// Page editor content (if any) replaces the default story text.
$editor_content = '';
while ( have_posts() ) {
	the_post();
	if ( trim( get_the_content() ) ) {
		$editor_content = apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
		$editor_content = str_replace( ']]>', ']]&gt;', $editor_content );
	}
}
?>

<main id="main">

	<!-- Intro -->
	<section class="relative overflow-hidden bg-gradient-to-b from-accent-soft/60 to-white">
		<div class="cb-container grid grid-cols-1 items-center gap-12 py-12 sm:py-16 lg:grid-cols-[1.15fr_1fr] lg:gap-16 lg:py-24">
			<div>
				<nav aria-label="<?php esc_attr_e( 'Breadcrumb', 'codexbloc' ); ?>">
					<ol class="flex flex-wrap items-center gap-1.5 text-sm text-slate-500" role="list">
						<li><a class="hover:text-ink" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'codexbloc' ); ?></a></li>
						<li aria-hidden="true" class="text-slate-300">/</li>
						<li class="text-slate-700" aria-current="page"><?php the_title(); ?></li>
					</ol>
				</nav>
				<h1 class="mt-6 text-4xl font-semibold leading-[1.08] tracking-tight text-ink sm:text-5xl lg:text-[3.5rem]"><?php esc_html_e( 'We help online stores run faster and sell more.', 'codexbloc' ); ?></h1>
				<p class="mt-6 max-w-xl text-lg leading-relaxed tracking-tight text-slate-600"><?php esc_html_e( 'Codexbloc builds lightweight plugins, themes and websites for WordPress and WooCommerce. We keep our work simple, fast and easy to use, so you spend less time fixing your site and more time running your business.', 'codexbloc' ); ?></p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a class="btn btn-primary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<a class="btn btn-outline" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Work with us', 'codexbloc' ); ?></a>
				</div>
			</div>

			<!-- At a glance -->
			<div class="w-full max-w-lg lg:max-w-none">
				<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-8">
					<p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500"><?php esc_html_e( 'At a glance', 'codexbloc' ); ?></p>
					<dl class="mt-5 divide-y divide-slate-100">
						<?php foreach ( codexbloc_about_facts() as $fact ) : ?>
							<div class="flex items-center gap-4 py-4 first:pt-0 last:pb-0">
								<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $fact['icon'], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
								<div class="min-w-0">
									<dt class="text-sm text-slate-500"><?php echo esc_html( $fact['label'] ); ?></dt>
									<dd class="font-semibold leading-snug text-ink"><?php echo esc_html( $fact['value'] ); ?></dd>
								</div>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		</div>
	</section>

	<!-- Section navigation -->
	<nav class="cb-subnav sticky top-16 z-30 border-y border-slate-200/80 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80" aria-label="<?php esc_attr_e( 'On this page', 'codexbloc' ); ?>">
		<div class="cb-container">
			<ul class="relative -mx-4 flex gap-1 overflow-x-auto px-4 py-2.5 [scrollbar-width:none] sm:mx-0 sm:justify-center sm:px-0 [&::-webkit-scrollbar]:hidden" role="list">
				<?php foreach ( $sections as $id => $label ) : ?>
					<li class="shrink-0"><a class="block whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-ink" href="#<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</nav>

	<!-- Our story -->
	<section id="story" class="cb-container scroll-mt-32 py-16 sm:py-24" aria-labelledby="cb-about-story">
		<div class="grid grid-cols-1 gap-10 lg:grid-cols-[2fr_3fr] lg:gap-20">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'Our story', 'codexbloc' ); ?></p>
				<h2 id="cb-about-story" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Small tools, done properly.', 'codexbloc' ); ?></h2>
			</div>
			<div>
				<?php if ( $editor_content ) : ?>
					<div class="cb-prose"><?php echo $editor_content; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<?php else : ?>
					<div class="space-y-5 text-lg leading-relaxed text-slate-600">
						<?php foreach ( codexbloc_about_story() as $paragraph ) : ?>
							<p><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<ul class="mt-8 grid grid-cols-1 gap-3 border-t border-slate-200 pt-8" role="list">
					<?php foreach ( codexbloc_about_promises() as $promise ) : ?>
						<li class="flex items-start gap-3 text-slate-700">
							<span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent text-white"><?php echo codexbloc_icon( 'check', 'h-3 w-3' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span><?php echo esc_html( $promise ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<!-- What we do -->
	<section id="what-we-do" class="scroll-mt-32 border-y border-slate-200 bg-slate-50 py-16 sm:py-24" aria-labelledby="cb-about-do">
		<div class="cb-container">
			<div class="mx-auto max-w-2xl text-center">
				<p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'What we do', 'codexbloc' ); ?></p>
				<h2 id="cb-about-do" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Do it yourself, or let us do it for you', 'codexbloc' ); ?></h2>
				<p class="mt-4 text-lg leading-relaxed text-slate-600"><?php esc_html_e( 'Ready-made tools when you want to build it yourself, and a team when you want it done for you.', 'codexbloc' ); ?></p>
			</div>

			<div class="mt-12 grid grid-cols-1 gap-5 lg:grid-cols-3">
				<?php foreach ( $offers as $offer ) : ?>
					<article class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-7 transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_32px_-12px_rgba(0,0,0,0.12)] sm:p-8">
						<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $offer['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<h3 class="mt-5 text-lg font-semibold tracking-tight text-ink"><?php echo esc_html( $offer['title'] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $offer['text'] ); ?></p>
						<ul class="mt-6 space-y-2.5 border-t border-slate-100 pt-6" role="list">
							<?php foreach ( $offer['points'] as $point ) : ?>
								<li class="flex items-start gap-2.5 text-sm text-slate-700"><?php echo codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 flex-none text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $point ); ?></span></li>
							<?php endforeach; ?>
						</ul>
						<a class="mt-auto inline-flex items-center gap-1.5 pt-7 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $offer['url'] ); ?>"><?php echo esc_html( $offer['label'] ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4 transition group-hover:translate-x-0.5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="mt-5 flex flex-col items-start gap-3 rounded-2xl border border-dashed border-slate-300 px-6 py-5 sm:flex-row sm:items-center">
				<span class="inline-flex shrink-0 rounded-full bg-slate-200/70 px-2.5 py-1 text-xs font-medium text-slate-700"><?php esc_html_e( 'Coming soon', 'codexbloc' ); ?></span>
				<p class="text-sm text-slate-600"><strong class="font-semibold text-ink"><?php esc_html_e( 'PrestaShop modules.', 'codexbloc' ); ?></strong> <?php esc_html_e( 'The same lightweight approach, for stores outside WordPress.', 'codexbloc' ); ?></p>
			</div>
		</div>
	</section>

	<!-- Values -->
	<section id="values" class="cb-container scroll-mt-32 py-16 sm:py-24" aria-labelledby="cb-about-values">
		<div class="grid grid-cols-1 gap-10 lg:grid-cols-[2fr_3fr] lg:gap-20">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'Our values', 'codexbloc' ); ?></p>
				<h2 id="cb-about-values" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'What you can expect from us', 'codexbloc' ); ?></h2>
				<p class="mt-4 text-lg leading-relaxed text-slate-600"><?php esc_html_e( 'A few simple principles guide every product we release and every site we deliver.', 'codexbloc' ); ?></p>
			</div>
			<div class="grid grid-cols-1 gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 sm:grid-cols-2">
				<?php foreach ( codexbloc_pillars() as $pillar ) : ?>
					<div class="bg-white p-6 sm:p-7">
						<span class="flex h-10 w-10 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $pillar['icon'], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<h3 class="mt-4 font-semibold text-ink"><?php echo esc_html( $pillar['title'] ); ?></h3>
						<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $pillar['text'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- How we work -->
	<section id="process" class="scroll-mt-32 border-y border-slate-200 bg-slate-50 py-16 sm:py-24" aria-labelledby="cb-about-process">
		<div class="cb-container">
			<div class="mx-auto max-w-2xl text-center">
				<p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'How we work', 'codexbloc' ); ?></p>
				<h2 id="cb-about-process" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'A clear process, start to finish', 'codexbloc' ); ?></h2>
				<p class="mt-4 text-lg leading-relaxed text-slate-600"><?php esc_html_e( 'For website projects, you always know what happens next and what we need from you.', 'codexbloc' ); ?></p>
			</div>

			<ol class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4" role="list">
				<?php foreach ( codexbloc_service_steps() as $i => $step ) : ?>
					<li class="relative rounded-2xl border border-slate-200 bg-white p-6">
						<span class="flex h-9 w-9 items-center justify-center rounded-full bg-ink text-sm font-semibold tabular-nums text-white"><?php echo esc_html( $i + 1 ); ?></span>
						<p class="mt-4 font-semibold text-ink"><?php echo esc_html( $step['title'] ); ?></p>
						<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $step['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>

			<p class="mt-8 text-center">
				<a class="inline-flex items-center gap-1.5 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $quote ); ?>"><?php esc_html_e( 'Get a free quote', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			</p>
		</div>
	</section>

	<!-- FAQ -->
	<section id="faq" class="cb-container scroll-mt-32 py-16 sm:py-24" aria-labelledby="cb-about-faq">
		<div class="grid grid-cols-1 gap-10 lg:grid-cols-[2fr_3fr] lg:gap-20">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'FAQ', 'codexbloc' ); ?></p>
				<h2 id="cb-about-faq" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Common questions', 'codexbloc' ); ?></h2>
				<p class="mt-4 text-lg leading-relaxed text-slate-600"><?php esc_html_e( 'Cannot find what you are looking for?', 'codexbloc' ); ?> <a class="font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Ask us directly.', 'codexbloc' ); ?></a></p>
			</div>
			<div class="divide-y divide-slate-200 border-y border-slate-200">
				<?php foreach ( codexbloc_about_faqs() as $faq ) : ?>
					<details class="group">
						<summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-5 text-left font-semibold text-ink hover:text-accent">
							<?php echo esc_html( $faq['q'] ); ?>
							<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition group-open:rotate-45 group-open:border-accent group-open:text-accent" aria-hidden="true">
								<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg>
							</span>
						</summary>
						<p class="-mt-1 max-w-2xl pb-5 pr-12 leading-relaxed text-slate-600"><?php echo esc_html( $faq['a'] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Work together -->
	<section class="cb-container" aria-labelledby="cb-about-cta">
		<div class="relative overflow-hidden rounded-3xl bg-ink px-6 py-12 text-center sm:px-12 sm:py-16">
			<div class="cb-dots pointer-events-none absolute inset-0" aria-hidden="true"></div>
			<div class="relative mx-auto max-w-2xl">
				<h2 id="cb-about-cta" class="text-3xl font-semibold tracking-tight text-white sm:text-4xl"><?php esc_html_e( "Let's work together", 'codexbloc' ); ?></h2>
				<p class="mt-4 text-lg leading-relaxed text-slate-400"><?php esc_html_e( 'Whether you need a single plugin or a complete website, we would love to help. Tell us what you need and we will reply with clear next steps.', 'codexbloc' ); ?></p>
				<div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
					<a class="btn btn-primary" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<a class="btn border border-white/20 text-white hover:border-white/40 hover:bg-white/5 hover:text-white" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?></a>
				</div>
			</div>
		</div>
	</section>

</main>

<script>
(function () {
	var nav = document.querySelector('.cb-subnav');
	if (!nav || !('IntersectionObserver' in window)) return;
	var list = nav.querySelector('ul');
	var links = nav.querySelectorAll('a[href^="#"]');
	var map = {};
	links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
	var setActive = function (id) {
		links.forEach(function (a) { a.classList.remove('is-active'); a.removeAttribute('aria-current'); });
		var a = map[id];
		if (!a) return;
		a.classList.add('is-active');
		a.setAttribute('aria-current', 'location');
		// Keep the active pill visible on narrow screens without scrolling the page.
		if (list.scrollWidth > list.clientWidth) {
			list.scrollTo({ left: a.offsetLeft - (list.clientWidth - a.offsetWidth) / 2, behavior: 'smooth' });
		}
	};
	var obs = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) { if (e.isIntersecting) setActive(e.target.id); });
	}, { rootMargin: '-130px 0px -60% 0px' });
	Object.keys(map).forEach(function (id) {
		var el = document.getElementById(id);
		if (el) obs.observe(el);
	});
})();
</script>

<?php
get_footer();
