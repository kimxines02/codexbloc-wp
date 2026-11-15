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

// Hero: the ways we help, so visitors can pick a path at a glance.
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
		'icon'        => 'cube',
		'title'       => __( 'PrestaShop modules', 'codexbloc' ),
		'text'        => __( 'The same lightweight tools for PrestaShop stores', 'codexbloc' ),
		'badge'       => __( 'New', 'codexbloc' ),
		'badge_class' => 'bg-amber-50 text-amber-700',
		'url'         => codexbloc_cat_url( codexbloc_prestashop_slugs() ),
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
	<section id="overview" class="cb-pastel-bg cb-under-header relative isolate scroll-mt-16 overflow-hidden" aria-labelledby="cb-hero-title">
		<div class="cb-grid-lines pointer-events-none absolute inset-0 -z-10" aria-hidden="true"></div>
		<div class="cb-container grid grid-cols-1 items-center gap-12 py-14 sm:py-20 lg:grid-cols-[1.05fr_1fr] lg:gap-16 lg:py-24">
			<div>
				<p class="inline-flex items-center gap-2 rounded-full border border-white/70 bg-white/60 px-3 py-1 text-xs font-medium text-accent backdrop-blur">
					<span class="h-1.5 w-1.5 rounded-full bg-accent" aria-hidden="true"></span>
					<?php echo esc_html( codexbloc_mod( 'hero_eyebrow' ) ); ?>
				</p>
				<h1 id="cb-hero-title" class="mt-5 text-4xl font-semibold leading-[1.08] tracking-tight text-ink sm:text-5xl lg:text-[3.5rem]"><?php echo esc_html( codexbloc_mod( 'hero_title' ) ); ?></h1>
				<p class="mt-5 max-w-xl text-lg leading-relaxed tracking-tight text-slate-600"><?php echo esc_html( codexbloc_mod( 'hero_text' ) ); ?></p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a class="btn btn-primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( codexbloc_mod( 'hero_cta_label' ) ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<a class="btn border border-slate-900/10 bg-white/60 text-ink backdrop-blur hover:border-slate-900/20 hover:bg-white hover:text-ink" href="<?php echo esc_url( $cta2_url ); ?>"><?php echo esc_html( codexbloc_mod( 'hero_cta2_label' ) ); ?></a>
				</div>
				<ul class="mt-10 grid max-w-xl grid-cols-1 gap-4 border-t border-slate-900/10 pt-6 text-sm sm:grid-cols-3" role="list">
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
				<div class="rounded-3xl border border-white/80 bg-white p-2 shadow-2xl shadow-indigo-900/10 ring-1 ring-slate-900/5 sm:p-3">
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
				</div>
			</div>
		</div>
	</section>

	<!-- Featured products -->
	<section id="products" class="cb-container scroll-mt-16 pt-16 sm:pt-20" aria-labelledby="cb-products-title">
		<div class="mb-8 flex items-end justify-between gap-4">
			<div>
				<h2 id="cb-products-title" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'Our products', 'codexbloc' ); ?></h2>
				<p class="mt-2 text-slate-600"><?php esc_html_e( 'Plugins, themes and PrestaShop modules you can use today.', 'codexbloc' ); ?></p>
			</div>
			<a class="hidden shrink-0 items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark sm:inline-flex" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'View all', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
		</div>

		<?php
		$products_shown = false;
		if ( $has_wc ) {
			// Featured products first, then the newest ones to fill the row.
			$limit       = 4;
			$visible_tax = array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'exclude-from-catalog' ),
					'operator' => 'NOT IN',
				),
			);
			$featured_ids = array_slice( array_map( 'intval', wc_get_featured_product_ids() ), 0, $limit );
			$latest_ids   = get_posts(
				array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => $limit,
					'orderby'        => 'date',
					'order'          => 'DESC',
					'fields'         => 'ids',
					'tax_query'      => $visible_tax, // phpcs:ignore WordPress.DB.SlowDBQuery
				)
			);
			$product_ids = array_slice( array_values( array_unique( array_merge( $featured_ids, $latest_ids ) ) ), 0, $limit );

			$loop = new WP_Query(
				array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'post__in'            => $product_ids ? $product_ids : array( 0 ),
					'orderby'             => 'post__in',
					'posts_per_page'      => $limit,
					'ignore_sticky_posts' => true,
					'tax_query'           => $visible_tax, // phpcs:ignore WordPress.DB.SlowDBQuery
				)
			);
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

	<!-- Why Codexbloc (bento) -->
	<?php
	$pillars = array();
	foreach ( codexbloc_pillars() as $pillar ) {
		$pillars[ $pillar['icon'] ] = $pillar;
	}
	$bento_card = 'group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white p-2 shadow-sm shadow-slate-900/[0.03] transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-900/[0.07] motion-reduce:hover:translate-y-0';
	$bento_vis  = 'cb-bento-visual relative flex h-44 items-center justify-center overflow-hidden rounded-[1.25rem] border border-slate-100 px-6';
	$bento_body = 'px-5 pb-5 pt-5 sm:px-6 sm:pb-6';
	$bento_icon = 'mb-3 inline-flex h-9 w-9 items-center justify-center rounded-lg bg-accent-soft text-accent';
	$bento_head = 'm-0 text-lg font-semibold tracking-tight text-ink';
	$bento_text = 'mt-1.5 max-w-md text-[15px] leading-relaxed text-slate-600';
	$pillar_txt = function ( $key, $field ) use ( $pillars ) {
		return isset( $pillars[ $key ][ $field ] ) ? $pillars[ $key ][ $field ] : '';
	};
	?>
	<section id="why" class="cb-container scroll-mt-16 pt-20 sm:pt-28" aria-labelledby="cb-why-title">
		<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
			<div class="max-w-2xl">
				<p class="inline-flex items-center gap-2 rounded-full border border-accent/15 bg-accent-soft px-3 py-1 text-xs font-medium text-accent">
					<span class="h-1.5 w-1.5 rounded-full bg-accent" aria-hidden="true"></span><?php esc_html_e( 'Why Codexbloc', 'codexbloc' ); ?>
				</p>
				<h2 id="cb-why-title" class="mt-4 text-3xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-4xl lg:text-[2.75rem]">
					<?php esc_html_e( 'Built for real stores.', 'codexbloc' ); ?>
					<span class="text-slate-400"><?php esc_html_e( 'Backed by real people.', 'codexbloc' ); ?></span>
				</h2>
				<p class="mt-4 text-lg leading-relaxed text-slate-600"><?php esc_html_e( 'Practical products for real stores, built and supported by people who work with WooCommerce and PrestaShop every day.', 'codexbloc' ); ?></p>
			</div>
			<a class="group inline-flex shrink-0 items-center gap-1.5 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4 transition group-hover:translate-x-0.5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
		</div>

		<div class="mt-12 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

			<!-- Fast: a page that loads in a blink -->
			<div class="<?php echo esc_attr( $bento_card . ' lg:col-span-2' ); ?>">
				<div class="<?php echo esc_attr( $bento_vis ); ?>" aria-hidden="true">
					<div class="w-full max-w-md rounded-xl border border-slate-200 bg-white shadow-lg shadow-slate-900/5">
						<div class="flex items-center gap-1.5 border-b border-slate-100 px-3 py-2">
							<span class="h-2 w-2 rounded-full bg-slate-200"></span><span class="h-2 w-2 rounded-full bg-slate-200"></span><span class="h-2 w-2 rounded-full bg-slate-200"></span>
							<span class="ml-2 h-4 flex-1 rounded-full bg-slate-100"></span>
						</div>
						<div class="relative h-0.5 overflow-hidden bg-slate-100"><span class="cb-load-bar absolute inset-y-0 left-0 bg-gradient-to-r from-accent to-violet-400"></span></div>
						<div class="grid grid-cols-[4.5rem_1fr] gap-3 p-3">
							<span class="h-16 rounded-lg bg-gradient-to-br from-indigo-100 to-cyan-100"></span>
							<span class="space-y-2 pt-1">
								<span class="block h-2.5 w-3/4 rounded-full bg-slate-200"></span>
								<span class="block h-2 w-full rounded-full bg-slate-100"></span>
								<span class="block h-2 w-2/3 rounded-full bg-slate-100"></span>
								<span class="mt-1 block h-5 w-20 rounded-full bg-accent/90"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="<?php echo esc_attr( $bento_body ); ?>">
					<span class="<?php echo esc_attr( $bento_icon ); ?>"><?php echo codexbloc_icon( 'bolt', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="<?php echo esc_attr( $bento_head ); ?>"><?php echo esc_html( $pillar_txt( 'bolt', 'title' ) ); ?></h3>
					<p class="<?php echo esc_attr( $bento_text ); ?>"><?php echo esc_html( $pillar_txt( 'bolt', 'text' ) ); ?></p>
				</div>
			</div>

			<!-- Simple: a settings panel with a few clear switches -->
			<div class="<?php echo esc_attr( $bento_card ); ?>">
				<div class="<?php echo esc_attr( $bento_vis ); ?>" aria-hidden="true">
					<div class="w-full max-w-[15rem] space-y-2.5 rounded-xl border border-slate-200 bg-white p-3.5 shadow-lg shadow-slate-900/5">
						<?php foreach ( array( true, true, false ) as $i => $on ) : ?>
							<span class="flex items-center justify-between gap-3">
								<span class="<?php echo esc_attr( 'block h-2 rounded-full bg-slate-200 ' . ( 0 === $i ? 'w-20' : ( 1 === $i ? 'w-28' : 'w-16' ) ) ); ?>"></span>
								<span class="<?php echo esc_attr( 'relative h-5 w-9 shrink-0 rounded-full transition ' . ( $on ? 'bg-accent' : 'bg-slate-200' ) ); ?>"><span class="<?php echo esc_attr( 'absolute top-0.5 h-4 w-4 rounded-full bg-white shadow-sm ' . ( $on ? 'right-0.5' : 'left-0.5' ) ); ?>"></span></span>
							</span>
						<?php endforeach; ?>
						<span class="!mt-3.5 block h-7 rounded-lg bg-ink/90"></span>
					</div>
				</div>
				<div class="<?php echo esc_attr( $bento_body ); ?>">
					<span class="<?php echo esc_attr( $bento_icon ); ?>"><?php echo codexbloc_icon( 'puzzle', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="<?php echo esc_attr( $bento_head ); ?>"><?php echo esc_html( $pillar_txt( 'puzzle', 'title' ) ); ?></h3>
					<p class="<?php echo esc_attr( $bento_text ); ?>"><?php echo esc_html( $pillar_txt( 'puzzle', 'text' ) ); ?></p>
				</div>
			</div>

			<!-- Built with care: tested on the platforms we support -->
			<div class="<?php echo esc_attr( $bento_card ); ?>">
				<div class="<?php echo esc_attr( $bento_vis ); ?>" aria-hidden="true">
					<ul class="w-full max-w-[14rem] space-y-2" role="list">
						<?php foreach ( array( 'WordPress', 'WooCommerce', 'PrestaShop' ) as $platform ) : ?>
							<li class="flex items-center justify-between rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-700 shadow-sm">
								<?php echo esc_html( $platform ); ?>
								<span class="flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-white"><?php echo codexbloc_icon( 'check', 'h-3 w-3' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="<?php echo esc_attr( $bento_body ); ?>">
					<span class="<?php echo esc_attr( $bento_icon ); ?>"><?php echo codexbloc_icon( 'shield', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="<?php echo esc_attr( $bento_head ); ?>"><?php echo esc_html( $pillar_txt( 'shield', 'title' ) ); ?></h3>
					<p class="<?php echo esc_attr( $bento_text ); ?>"><?php echo esc_html( $pillar_txt( 'shield', 'text' ) ); ?></p>
				</div>
			</div>

			<!-- Real support: a short conversation with the developers -->
			<div class="<?php echo esc_attr( $bento_card . ' lg:col-span-2' ); ?>">
				<div class="<?php echo esc_attr( $bento_vis ); ?>" aria-hidden="true">
					<div class="flex w-full max-w-md flex-col gap-2.5 text-sm">
						<span class="max-w-[80%] self-start rounded-2xl rounded-bl-md border border-slate-200 bg-white px-3.5 py-2 text-slate-700 shadow-sm"><?php esc_html_e( 'Could you help me set this up on my store?', 'codexbloc' ); ?></span>
						<span class="flex max-w-[85%] items-end gap-2 self-end">
							<span class="rounded-2xl rounded-br-md bg-accent px-3.5 py-2 text-white shadow-sm"><?php esc_html_e( 'Of course! Here is exactly what to do.', 'codexbloc' ); ?></span>
							<span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-ink text-white"><?php echo codexbloc_icon( 'code', 'h-3.5 w-3.5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						</span>
						<span class="mr-9 self-end text-xs text-slate-400"><?php esc_html_e( 'The Codexbloc developers', 'codexbloc' ); ?></span>
					</div>
				</div>
				<div class="<?php echo esc_attr( $bento_body . ' flex flex-wrap items-end justify-between gap-4' ); ?>">
					<div>
						<span class="<?php echo esc_attr( $bento_icon ); ?>"><?php echo codexbloc_icon( 'chat', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<h3 class="<?php echo esc_attr( $bento_head ); ?>"><?php echo esc_html( $pillar_txt( 'chat', 'title' ) ); ?></h3>
						<p class="<?php echo esc_attr( $bento_text ); ?>"><?php echo esc_html( $pillar_txt( 'chat', 'text' ) ); ?></p>
					</div>
					<?php if ( $contact ) : ?>
						<a class="btn btn-outline px-5 py-2.5 text-sm" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
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
