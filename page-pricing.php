<?php
/**
 * Template Name: Pricing
 *
 * Used automatically for the page with the slug "pricing", or pick
 * "Pricing" under Page Attributes > Template for any other page.
 * Edit tiers, bundle and FAQ in inc/defaults.php.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$shop_url   = codexbloc_shop_url();
$contact    = codexbloc_link( codexbloc_mod( 'contact_url' ) );
$tiers      = codexbloc_license_tiers();
$bundle     = codexbloc_all_access();
$bundle_url = codexbloc_mod( 'all_access_url' );
$addons_url = codexbloc_mod( 'addons_url' );
$wporg      = codexbloc_mod( 'wporg_url' );
?>

<main id="main">

	<!-- Intro -->
	<section class="border-b border-slate-100 bg-gradient-to-b from-accent-soft/60 to-white">
		<div class="cb-container py-14 sm:py-20">
			<div class="mx-auto max-w-2xl text-center">
				<p class="inline-flex items-center rounded-full border border-accent/20 bg-white px-3 py-1 text-xs font-medium text-accent"><?php esc_html_e( 'Pricing', 'codexbloc' ); ?></p>
				<?php while ( have_posts() ) : the_post(); ?>
					<h1 class="mt-5 text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl"><?php esc_html_e( 'Simple yearly licenses. No lock-in.', 'codexbloc' ); ?></h1>
					<p class="mt-5 text-lg leading-relaxed tracking-tight text-slate-600"><?php esc_html_e( 'Start with the free version. Buy a license for the plugin you need when you want more features, updates and support. If you stop renewing, the plugin keeps working.', 'codexbloc' ); ?></p>
					<?php if ( get_the_content() ) : ?>
						<div class="cb-prose mx-auto mt-6 text-left"><?php the_content(); ?></div>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
		</div>
	</section>

	<!-- License tiers -->
	<section class="cb-container pt-14 sm:pt-20" aria-labelledby="cb-tiers-title">
		<div class="mx-auto max-w-2xl text-center">
			<h2 id="cb-tiers-title" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Per-plugin licenses', 'codexbloc' ); ?></h2>
			<p class="mt-3 text-slate-600"><?php esc_html_e( 'Pick the number of sites. Prices shown are starting prices; each product page lists its exact price.', 'codexbloc' ); ?></p>
		</div>

		<div class="mx-auto mt-10 grid max-w-5xl grid-cols-1 gap-5 md:grid-cols-3">
			<?php foreach ( $tiers as $tier ) : ?>
				<div class="relative flex flex-col rounded-2xl border p-6 sm:p-8 <?php echo $tier['featured'] ? 'border-accent bg-accent-soft/40 ring-1 ring-accent/20' : 'border-slate-200 bg-white'; ?>">
					<?php if ( $tier['featured'] ) : ?>
						<span class="absolute -top-3 left-6 rounded-full bg-accent px-3 py-1 text-xs font-medium text-white"><?php esc_html_e( 'Most popular', 'codexbloc' ); ?></span>
					<?php endif; ?>
					<h3 class="text-lg font-semibold text-ink"><?php echo esc_html( $tier['name'] ); ?></h3>
					<p class="mt-1 text-sm text-slate-600"><?php echo esc_html( $tier['note'] ); ?></p>
					<p class="mt-6 flex items-baseline gap-1.5">
						<span class="text-sm text-slate-500"><?php esc_html_e( 'from', 'codexbloc' ); ?></span>
						<span class="text-4xl font-semibold tracking-tight text-ink"><?php echo esc_html( $tier['price'] ); ?></span>
						<span class="text-sm text-slate-500"><?php echo esc_html( $tier['period'] ); ?></span>
					</p>
					<p class="mt-2 inline-flex items-center gap-2 text-sm font-medium text-ink"><?php echo codexbloc_icon( 'check', 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $tier['sites'] ); ?></p>
					<div class="mt-auto pt-8">
						<a class="btn w-full <?php echo $tier['featured'] ? 'btn-primary' : 'btn-outline'; ?>" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Choose a plugin', 'codexbloc' ); ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Included in every license -->
		<div class="mx-auto mt-8 max-w-5xl rounded-2xl border border-slate-200 bg-slate-50 p-6 sm:p-8">
			<h3 class="font-semibold text-ink"><?php esc_html_e( 'Every license includes', 'codexbloc' ); ?></h3>
			<ul class="mt-4 grid grid-cols-1 gap-x-8 gap-y-3 text-sm text-slate-700 sm:grid-cols-2 lg:grid-cols-3">
				<?php foreach ( codexbloc_license_includes() as $item ) : ?>
					<li class="flex gap-3"><?php echo codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 shrink-0 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $item ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- All-access bundle -->
	<section id="all-access" class="cb-container scroll-mt-24 pt-16 sm:pt-24" aria-labelledby="cb-bundle-title">
		<div class="mx-auto max-w-5xl rounded-3xl bg-ink px-6 py-10 text-slate-300 sm:px-10 sm:py-12">
			<div class="grid grid-cols-1 items-center gap-10 md:grid-cols-2">
				<div>
					<p class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white">
						<?php echo $bundle_url ? esc_html__( 'Best value', 'codexbloc' ) : esc_html__( 'Coming soon', 'codexbloc' ); ?>
					</p>
					<h2 id="cb-bundle-title" class="mt-4 text-2xl font-semibold tracking-tight text-white sm:text-3xl"><?php echo esc_html( $bundle['title'] ); ?></h2>
					<p class="mt-3 leading-relaxed"><?php echo esc_html( $bundle['text'] ); ?></p>
					<ul class="mt-6 space-y-3 text-sm">
						<?php foreach ( $bundle['items'] as $item ) : ?>
							<li class="flex gap-3"><?php echo codexbloc_icon( 'check', 'mt-0.5 h-4 w-4 shrink-0 text-white' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( $item ); ?></span></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="rounded-2xl bg-white/5 p-6 ring-1 ring-white/10 sm:p-8">
					<?php if ( $bundle_url ) : ?>
						<p class="flex items-baseline gap-1.5">
							<span class="text-4xl font-semibold tracking-tight text-white"><?php echo esc_html( $bundle['price'] ); ?></span>
							<span class="text-sm"><?php echo esc_html( $bundle['period'] ); ?></span>
						</p>
						<p class="mt-1 text-sm"><?php echo esc_html( $bundle['monthly'] ); ?></p>
						<a class="btn btn-primary mt-6 w-full" href="<?php echo esc_url( codexbloc_link( $bundle_url ) ); ?>"><?php esc_html_e( 'Get all-access', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<?php else : ?>
						<p class="font-semibold text-white"><?php esc_html_e( 'Launching as our catalog grows', 'codexbloc' ); ?></p>
						<p class="mt-2 text-sm leading-relaxed"><?php esc_html_e( 'We will open the all-access pass once there are enough premium products to make it a great deal. Subscribe and we will let you know when it launches.', 'codexbloc' ); ?></p>
						<a class="btn mt-6 w-full bg-white text-ink hover:bg-slate-100 hover:text-ink" href="<?php echo esc_url( codexbloc_newsletter_enabled() ? '#newsletter' : $contact ); ?>"><?php esc_html_e( 'Notify me', 'codexbloc' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- Free + PrestaShop -->
	<section class="cb-container pt-16 sm:pt-24">
		<div class="mx-auto grid max-w-5xl grid-cols-1 gap-5 md:grid-cols-2">
			<div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8">
				<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><?php echo codexbloc_icon( 'download', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				<h2 class="mt-4 text-lg font-semibold text-ink"><?php esc_html_e( 'Free versions', 'codexbloc' ); ?></h2>
				<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'Every premium plugin starts as a free plugin on WordPress.org. Install it, try it on your store, and upgrade only if you need more.', 'codexbloc' ); ?></p>
				<a class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $wporg ? $wporg : $shop_url ); ?>"<?php echo $wporg ? ' target="_blank" rel="noopener"' : ''; ?>><?php esc_html_e( 'Browse free plugins', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			</div>
			<div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8">
				<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600"><?php echo codexbloc_icon( 'code', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				<h2 class="mt-4 text-lg font-semibold text-ink"><?php esc_html_e( 'PrestaShop modules', 'codexbloc' ); ?></h2>
				<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'Our PrestaShop modules are sold on PrestaShop Addons, the official marketplace, with its own pricing and licensing.', 'codexbloc' ); ?></p>
				<?php if ( $addons_url ) : ?>
					<a class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $addons_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View on PrestaShop Addons', 'codexbloc' ); ?><?php echo codexbloc_icon( 'external', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				<?php else : ?>
					<p class="mt-4 inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600"><?php esc_html_e( 'Coming soon', 'codexbloc' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- FAQ -->
	<section class="cb-container pt-16 sm:pt-24" aria-labelledby="cb-faq-title">
		<div class="mx-auto max-w-3xl">
			<h2 id="cb-faq-title" class="text-center text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Questions about pricing', 'codexbloc' ); ?></h2>
			<div class="mt-8 divide-y divide-slate-200 border-y border-slate-200">
				<?php foreach ( codexbloc_pricing_faqs() as $faq ) : ?>
					<details class="group py-5">
						<summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-medium text-ink">
							<?php echo esc_html( $faq['q'] ); ?>
							<span class="shrink-0 text-slate-400 transition group-open:rotate-45" aria-hidden="true">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
							</span>
						</summary>
						<p class="mt-3 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $faq['a'] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
			<p class="mt-8 text-center text-sm text-slate-600">
				<?php esc_html_e( 'Still have a question?', 'codexbloc' ); ?>
				<a class="font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?></a>
			</p>
		</div>
	</section>

</main>

<?php
get_footer();
