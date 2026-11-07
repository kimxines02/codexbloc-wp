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
$plans     = codexbloc_plans();
$prices    = codexbloc_service_prices();
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
					<li class="flex items-center gap-2"><?php echo codexbloc_icon( 'check', 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Monthly or yearly plans', 'codexbloc' ); ?></li>
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
							<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'bolt', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="min-w-0 grow"><span class="block font-semibold text-ink sm:truncate"><?php esc_html_e( 'Premium plugins', 'codexbloc' ); ?></span><span class="block text-sm text-slate-500"><?php esc_html_e( 'More features, priority support', 'codexbloc' ); ?></span></span>
							<span class="shrink-0 rounded-full bg-accent-soft px-2.5 py-1 text-xs font-medium text-accent"><?php esc_html_e( 'Monthly / Yearly', 'codexbloc' ); ?></span>
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

	<!-- Free vs premium -->
	<section id="premium" class="cb-container scroll-mt-24 pt-16 sm:pt-24" aria-labelledby="cb-plans-title">
		<div class="mx-auto max-w-2xl text-center">
			<h2 id="cb-plans-title" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Start free. Upgrade when you are ready.', 'codexbloc' ); ?></h2>
			<p class="mt-3 text-slate-600"><?php esc_html_e( 'Every plugin has a free version. Premium adds more features, and you pick monthly or yearly billing at checkout.', 'codexbloc' ); ?></p>
		</div>

		<div class="mx-auto mt-10 grid grid-cols-1 max-w-4xl gap-5 md:grid-cols-2">
			<?php foreach ( $plans as $key => $plan ) : ?>
				<?php $is_premium = 'premium' === $key; ?>
				<div class="flex flex-col rounded-2xl border p-6 sm:p-8 <?php echo $is_premium ? 'border-accent bg-accent-soft/40 ring-1 ring-accent/20' : 'border-slate-200 bg-white'; ?>">
					<h3 class="text-lg font-semibold text-ink"><?php echo esc_html( $plan['title'] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $plan['text'] ); ?></p>
					<ul class="mt-6 space-y-3 text-sm text-slate-700">
						<?php foreach ( $plan['items'] as $item ) : ?>
							<li class="flex gap-3"><?php echo codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 shrink-0 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $item ); ?></span></li>
						<?php endforeach; ?>
					</ul>
					<div class="mt-auto pt-8">
						<?php if ( $is_premium ) : ?>
							<a class="btn btn-primary w-full" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'See premium plugins', 'codexbloc' ); ?></a>
						<?php else : ?>
							<?php $wporg = codexbloc_mod( 'wporg_url' ); ?>
							<a class="btn btn-outline w-full" href="<?php echo esc_url( $wporg ? $wporg : $shop_url ); ?>"<?php echo $wporg ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo $wporg ? esc_html__( 'Find us on WordPress.org', 'codexbloc' ) : esc_html__( 'Browse free plugins', 'codexbloc' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
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
	<section class="cb-container pt-16 sm:pt-24" aria-labelledby="cb-services-title">
		<div class="rounded-3xl bg-slate-50 px-6 py-10 sm:px-10 sm:py-14">
			<div class="mx-auto max-w-2xl text-center">
				<h2 id="cb-services-title" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Need something custom?', 'codexbloc' ); ?></h2>
				<p class="mt-3 text-slate-600"><?php esc_html_e( 'We also design and build websites and online stores, and keep them running smoothly.', 'codexbloc' ); ?></p>
			</div>

			<div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3">
				<?php foreach ( codexbloc_services() as $service ) : ?>
					<div class="rounded-2xl border border-slate-200 bg-white p-6">
						<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $service['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<h3 class="mt-4 font-semibold text-ink"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $service['text'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $prices ) : ?>
				<dl class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-3">
					<?php foreach ( $prices as $price ) : ?>
						<div class="rounded-xl border border-slate-200 bg-white px-5 py-4">
							<dt class="font-semibold text-ink"><?php echo esc_html( $price['name'] ); ?></dt>
							<dd class="mt-1 text-xs leading-relaxed text-slate-500"><?php echo esc_html( $price['note'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>

			<div class="mt-8 text-center">
				<a class="btn btn-primary" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Tell us about your project', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
