<?php
/**
 * Homepage.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_wc    = function_exists( 'wc_get_page_permalink' );
$shop_url  = codexbloc_shop_url();
$cta_url   = codexbloc_mod( 'hero_cta_url' ) ? codexbloc_link( codexbloc_mod( 'hero_cta_url' ) ) : $shop_url;
$cta2_url  = codexbloc_link( codexbloc_mod( 'hero_cta2_url' ) );
$contact   = codexbloc_link( codexbloc_mod( 'contact_url' ) );
$quote_url = add_query_arg( 'topic', 'project', $contact ); // Services: no prices, ask for a quote.
$showcase  = post_type_exists( 'cb_showcase' ) ? get_post_type_archive_link( 'cb_showcase' ) : '';

// Hero: the three ways we help, so visitors can pick a path at a glance.
$hero_paths = array(
	array(
		'icon'        => 'puzzle',
		'title'       => __( 'Plugins for WooCommerce', 'codexbloc' ),
		'text'        => __( 'Add useful features to your store in minutes', 'codexbloc' ),
		'badge'       => __( 'Free', 'codexbloc' ),
		'badge_class' => 'bg-emerald-50 text-emerald-700',
		'url'         => codexbloc_cat_url( 'wordpress-plugins' ),
	),
	array(
		'icon'        => 'code',
		'title'       => __( 'WordPress themes', 'codexbloc' ),
		'text'        => __( 'Clean, fast designs you can preview first', 'codexbloc' ),
		'badge'       => $showcase ? __( 'Live demos', 'codexbloc' ) : '',
		'badge_class' => 'bg-slate-100 text-slate-600',
		'url'         => $showcase ? $showcase : codexbloc_cat_url( 'wordpress-themes' ),
	),
	array(
		'icon'        => 'bag',
		'title'       => __( 'A website built for you', 'codexbloc' ),
		'text'        => __( 'We design, build and look after your site', 'codexbloc' ),
		'badge'       => __( 'Free quote', 'codexbloc' ),
		'badge_class' => 'bg-accent-soft text-accent',
		'url'         => '#services',
	),
);

$hero_facts = array(
	array(
		'icon'  => 'bolt',
		'title' => __( 'Lightweight', 'codexbloc' ),
		'text'  => __( 'Fast on every device', 'codexbloc' ),
	),
	array(
		'icon'  => 'shield',
		'title' => __( 'Tested', 'codexbloc' ),
		'text'  => __( 'On current releases', 'codexbloc' ),
	),
	array(
		'icon'  => 'chat',
		'title' => __( 'Real support', 'codexbloc' ),
		'text'  => __( 'From the developers', 'codexbloc' ),
	),
);

// Floating section index.
$page_sections = array(
	'overview' => __( 'Overview', 'codexbloc' ),
	'products' => __( 'Products', 'codexbloc' ),
	'why'      => __( 'Why Codexbloc', 'codexbloc' ),
	'services' => __( 'Services', 'codexbloc' ),
	'process'  => __( 'How we work', 'codexbloc' ),
);
if ( codexbloc_newsletter_enabled() ) {
	$page_sections['newsletter'] = __( 'Newsletter', 'codexbloc' );
}
?>

<main id="main">

	<!-- Hero -->
	<section id="overview" class="relative isolate scroll-mt-16 overflow-hidden border-b border-slate-100 bg-gradient-to-b from-accent-soft/60 to-white" aria-labelledby="cb-hero-title">
		<div class="pointer-events-none absolute -right-40 -top-40 -z-10 h-[32rem] w-[32rem] rounded-full bg-accent/10 blur-3xl" aria-hidden="true"></div>
		<div class="cb-container grid grid-cols-1 items-center gap-12 py-14 sm:py-20 lg:grid-cols-[1.05fr_1fr] lg:gap-16 lg:py-24">
			<div>
				<p class="inline-flex items-center gap-2 rounded-full border border-accent/20 bg-white px-3 py-1 text-xs font-medium text-accent">
					<span class="h-1.5 w-1.5 rounded-full bg-accent" aria-hidden="true"></span>
					<?php echo esc_html( codexbloc_mod( 'hero_eyebrow' ) ); ?>
				</p>
				<h1 id="cb-hero-title" class="mt-5 text-4xl font-semibold leading-[1.08] tracking-tight text-ink sm:text-5xl lg:text-[3.5rem]"><?php echo esc_html( codexbloc_mod( 'hero_title' ) ); ?></h1>
				<p class="mt-5 max-w-xl text-lg leading-relaxed tracking-tight text-slate-600"><?php echo esc_html( codexbloc_mod( 'hero_text' ) ); ?></p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a class="btn btn-primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( codexbloc_mod( 'hero_cta_label' ) ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<a class="btn btn-outline" href="<?php echo esc_url( $cta2_url ); ?>"><?php echo esc_html( codexbloc_mod( 'hero_cta2_label' ) ); ?></a>
				</div>
				<ul class="mt-10 grid max-w-xl grid-cols-1 gap-4 border-t border-slate-200/80 pt-6 text-sm sm:grid-cols-3" role="list">
					<?php foreach ( $hero_facts as $fact ) : ?>
						<li class="flex items-start gap-2.5">
							<?php echo codexbloc_icon( $fact['icon'], 'mt-0.5 h-4 w-4 shrink-0 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<span><span class="block font-semibold text-ink"><?php echo esc_html( $fact['title'] ); ?></span><span class="block text-slate-500"><?php echo esc_html( $fact['text'] ); ?></span></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- What do you need? -->
			<div class="w-full">
				<div class="rounded-3xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-200/60 sm:p-3">
					<p class="px-3 pb-2 pt-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500 sm:px-4"><?php esc_html_e( 'What do you need?', 'codexbloc' ); ?></p>
					<ul class="space-y-1" role="list">
						<?php foreach ( $hero_paths as $path ) : ?>
							<li>
								<a class="group flex items-center gap-4 rounded-2xl p-3 transition hover:bg-slate-50 sm:p-4" href="<?php echo esc_url( $path['url'] ); ?>">
									<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent-soft text-accent transition group-hover:bg-accent group-hover:text-white"><?php echo codexbloc_icon( $path['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
									<span class="min-w-0 grow">
										<span class="flex flex-wrap items-center gap-x-2 gap-y-1">
											<span class="font-semibold text-ink"><?php echo esc_html( $path['title'] ); ?></span>
											<?php if ( $path['badge'] ) : ?>
												<span class="rounded-full px-2 py-0.5 text-xs font-medium <?php echo esc_attr( $path['badge_class'] ); ?>"><?php echo esc_html( $path['badge'] ); ?></span>
											<?php endif; ?>
										</span>
										<span class="mt-0.5 block text-sm text-slate-500"><?php echo esc_html( $path['text'] ); ?></span>
									</span>
									<?php echo codexbloc_icon( 'arrow', 'h-5 w-5 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
					<div class="mt-1 flex items-center gap-4 rounded-2xl border border-dashed border-slate-200 p-3 sm:p-4">
						<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400"><?php echo codexbloc_icon( 'code', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="min-w-0 grow">
							<span class="block font-semibold text-slate-700"><?php esc_html_e( 'PrestaShop modules', 'codexbloc' ); ?></span>
							<span class="mt-0.5 block text-sm text-slate-500"><?php esc_html_e( 'The same lightweight tools for PrestaShop stores', 'codexbloc' ); ?></span>
						</span>
						<span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600"><?php esc_html_e( 'Coming soon', 'codexbloc' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Featured products -->
	<section id="products" class="cb-container scroll-mt-16 pt-16 sm:pt-20" aria-labelledby="cb-products-title">
		<div class="mb-8 flex items-end justify-between gap-4">
			<div>
				<h2 id="cb-products-title" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Our products', 'codexbloc' ); ?></h2>
				<p class="mt-2 text-slate-600"><?php esc_html_e( 'Plugins and themes you can install today.', 'codexbloc' ); ?></p>
			</div>
			<a class="hidden shrink-0 items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark sm:inline-flex" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'View all', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
		</div>

		<?php
		$products_shown = false;
		if ( $has_wc ) {
			$query_args = array(
				'post_type'           => 'product',
				'posts_per_page'      => 4,
				'ignore_sticky_posts' => true,
				'tax_query'           => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
				),
			);
			$loop = new WP_Query( $query_args );
			if ( ! $loop->have_posts() ) {
				unset( $query_args['tax_query'] );
				$loop = new WP_Query( $query_args );
			}
			if ( $loop->have_posts() ) {
				$products_shown = true;
				echo '<ul class="products cb-grid-4">';
				while ( $loop->have_posts() ) {
					$loop->the_post();
					wc_get_template_part( 'content', 'product' );
				}
				echo '</ul>';
				wp_reset_postdata();
			}
		}

		if ( ! $products_shown ) :
			?>
			<ul class="products cb-grid-4">
				<li class="product">
					<a class="woocommerce-LoopProduct-link" href="https://wordpress.org/plugins/cb-quantity-breaks-for-woocommerce/" target="_blank" rel="noopener">
						<span class="flex aspect-[4/3] w-full items-center justify-center bg-slate-50 text-accent"><?php echo codexbloc_icon( 'puzzle', 'h-12 w-12' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="cb-cat"><?php esc_html_e( 'WordPress Plugin', 'codexbloc' ); ?></span>
						<h3 class="woocommerce-loop-product__title !pt-1">CB Quantity Breaks for WooCommerce</h3>
						<span class="price"><?php esc_html_e( 'Free', 'codexbloc' ); ?></span>
					</a>
					<a class="button" href="https://wordpress.org/plugins/cb-quantity-breaks-for-woocommerce/" target="_blank" rel="noopener"><?php esc_html_e( 'Download free', 'codexbloc' ); ?></a>
				</li>
			</ul>
			<p class="mt-4 text-sm text-slate-500"><?php esc_html_e( 'Add your products in WooCommerce and they will appear here automatically. Mark products as "featured" to choose which ones show first.', 'codexbloc' ); ?></p>
		<?php endif; ?>

		<a class="mt-6 inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark sm:hidden" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'View all products', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
	</section>

	<!-- Why Codexbloc -->
	<section id="why" class="cb-container scroll-mt-16 pt-16 sm:pt-24" aria-labelledby="cb-why-title">
		<div class="mx-auto max-w-2xl text-center">
			<h2 id="cb-why-title" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Why Codexbloc', 'codexbloc' ); ?></h2>
			<p class="mt-3 text-slate-600"><?php esc_html_e( 'Practical products for real stores, built and supported by people who work with WordPress and WooCommerce every day.', 'codexbloc' ); ?></p>
		</div>
		<div class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( codexbloc_pillars() as $pillar ) : ?>
				<div class="rounded-2xl border border-slate-200 bg-white p-6">
					<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $pillar['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="mt-4 font-semibold text-ink"><?php echo esc_html( $pillar['title'] ); ?></h3>
					<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $pillar['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- Services -->
	<section id="services" class="mt-16 scroll-mt-16 border-t border-slate-200 bg-slate-50 py-16 sm:mt-24 sm:py-24" aria-labelledby="cb-services-title">
		<div class="cb-container">

			<!-- Header -->
			<div class="mx-auto max-w-2xl text-center">
				<p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent"><?php esc_html_e( 'Services', 'codexbloc' ); ?></p>
				<h2 id="cb-services-title" class="mt-3 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'Websites and online stores, built for you', 'codexbloc' ); ?></h2>
				<p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg"><?php esc_html_e( 'Beyond our plugins, we design, build and maintain WordPress websites and WooCommerce stores for businesses of every size.', 'codexbloc' ); ?></p>
			</div>

			<!-- What we do -->
			<div class="mt-12 grid grid-cols-1 gap-5 lg:grid-cols-3">
				<?php foreach ( codexbloc_services() as $service ) : ?>
					<article class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-7 transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_32px_-12px_rgba(0,0,0,0.12)]">
						<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $service['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<h3 class="mt-5 text-lg font-semibold tracking-tight text-ink"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $service['text'] ); ?></p>
						<?php if ( ! empty( $service['items'] ) ) : ?>
							<ul class="mt-6 space-y-2.5 border-t border-slate-100 pt-6" role="list">
								<?php foreach ( $service['items'] as $item ) : ?>
									<li class="flex items-start gap-2.5 text-sm text-slate-700">
										<?php echo codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 flex-none text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
										<span><?php echo esc_html( $item ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>

			<!-- How we work -->
			<div id="process" class="mt-16 scroll-mt-24">
				<h3 class="text-center text-xs font-semibold uppercase tracking-[0.14em] text-slate-500"><?php esc_html_e( 'How we work', 'codexbloc' ); ?></h3>
				<ol class="mt-6 grid grid-cols-1 gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 sm:grid-cols-2 lg:grid-cols-4" role="list">
					<?php foreach ( codexbloc_service_steps() as $i => $step ) : ?>
						<li class="bg-white p-6">
							<span class="text-sm font-semibold tabular-nums text-accent"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<p class="mt-2 font-semibold text-ink"><?php echo esc_html( $step['title'] ); ?></p>
							<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $step['text'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

			<!-- CTA -->
			<div class="mt-16 flex flex-col items-center justify-between gap-6 rounded-2xl bg-ink px-7 py-8 text-center sm:px-10 md:flex-row md:text-left">
				<div>
					<p class="text-lg font-semibold text-white"><?php esc_html_e( 'Let\'s build something together', 'codexbloc' ); ?></p>
					<p class="mt-1 text-sm text-slate-400"><?php esc_html_e( 'Tell us about your project and we will get back to you with a free, no-obligation quote.', 'codexbloc' ); ?></p>
				</div>
				<a class="btn btn-primary flex-none" href="<?php echo esc_url( $quote_url ); ?>"><?php esc_html_e( 'Tell us about your project', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			</div>

		</div>
	</section>

</main>

<?php get_template_part( 'template-parts/section-index', null, array( 'sections' => $page_sections ) ); ?>

<?php
get_footer();
