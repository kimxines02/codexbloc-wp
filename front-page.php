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
?>

<main id="main">

	<!-- Hero -->
	<section class="relative overflow-hidden border-b border-slate-100 bg-gradient-to-b from-accent-soft/60 to-white">
		<div class="cb-container grid grid-cols-1 items-center gap-12 py-14 sm:py-20 lg:grid-cols-2 lg:py-24">
			<div>
				<p class="inline-flex items-center rounded-full border border-accent/20 bg-white px-3 py-1 text-xs font-medium text-accent"><?php echo esc_html( codexbloc_mod( 'hero_eyebrow' ) ); ?></p>
				<h1 class="mt-5 text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl lg:text-6xl"><?php echo esc_html( codexbloc_mod( 'hero_title' ) ); ?></h1>
				<p class="mt-5 max-w-xl text-lg leading-relaxed tracking-tight text-slate-600"><?php echo esc_html( codexbloc_mod( 'hero_text' ) ); ?></p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a class="btn btn-primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( codexbloc_mod( 'hero_cta_label' ) ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<a class="btn btn-outline" href="<?php echo esc_url( $cta2_url ); ?>"><?php echo esc_html( codexbloc_mod( 'hero_cta2_label' ) ); ?></a>
				</div>
				<ul class="mt-8 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-600">
					<li class="flex items-center gap-2"><?php echo codexbloc_icon( 'check', 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Free on WordPress.org', 'codexbloc' ); ?></li>
					<li class="flex items-center gap-2"><?php echo codexbloc_icon( 'check', 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Built lean and fast', 'codexbloc' ); ?></li>
					<li class="flex items-center gap-2"><?php echo codexbloc_icon( 'check', 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Support from the developers', 'codexbloc' ); ?></li>
				</ul>
			</div>

			<!-- Catalog preview card -->
			<div class="relative mx-auto w-full max-w-md lg:max-w-none">
				<div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-200/60">
					<div class="flex items-center gap-1.5 px-3 py-2.5" aria-hidden="true">
						<span class="h-2.5 w-2.5 rounded-full bg-slate-200"></span><span class="h-2.5 w-2.5 rounded-full bg-slate-200"></span><span class="h-2.5 w-2.5 rounded-full bg-slate-200"></span>
					</div>
					<ul class="divide-y divide-slate-100 rounded-xl border border-slate-100">
						<li class="flex items-center gap-4 p-4">
							<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'puzzle', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="min-w-0 grow"><span class="block font-semibold text-ink sm:truncate">CB Quantity Breaks for WooCommerce</span><span class="block text-sm text-slate-500"><?php esc_html_e( 'Tiered pricing tables for product pages', 'codexbloc' ); ?></span></span>
							<span class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700"><?php esc_html_e( 'Free', 'codexbloc' ); ?></span>
						</li>
						<li class="flex items-center gap-4 p-4">
							<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'bag', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="min-w-0 grow"><span class="block font-semibold text-ink sm:truncate"><?php esc_html_e( 'Websites & online stores', 'codexbloc' ); ?></span><span class="block text-sm text-slate-500"><?php esc_html_e( 'Designed and built for you', 'codexbloc' ); ?></span></span>
							<span class="shrink-0 rounded-full bg-accent-soft px-2.5 py-1 text-xs font-medium text-accent"><?php esc_html_e( 'Services', 'codexbloc' ); ?></span>
						</li>
						<li class="flex items-center gap-4 p-4">
							<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500"><?php echo codexbloc_icon( 'code', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="min-w-0 grow"><span class="block font-semibold text-ink sm:truncate"><?php esc_html_e( 'PrestaShop modules', 'codexbloc' ); ?></span><span class="block text-sm text-slate-500"><?php esc_html_e( 'Same quality, new platform', 'codexbloc' ); ?></span></span>
							<span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600"><?php esc_html_e( 'Coming soon', 'codexbloc' ); ?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- Featured products -->
	<section class="cb-container pt-16 sm:pt-20" aria-labelledby="cb-products-title">
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
	<section class="cb-container pt-16 sm:pt-24" aria-labelledby="cb-why-title">
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
			<div class="mt-16">
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
				<a class="btn btn-primary flex-none" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Tell us about your project', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			</div>

		</div>
	</section>

</main>

<?php
get_footer();
