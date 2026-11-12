<?php
/**
 * Template Name: About
 *
 * Used automatically for the page with the slug "about", or pick
 * "About" under Page Attributes > Template for any other page.
 * Anything typed in the page editor is shown under the intro.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$shop_url = codexbloc_shop_url();
$contact  = codexbloc_link( codexbloc_mod( 'contact_url' ) );

/**
 * Category link with a shop fallback.
 *
 * @param string $slug Product category slug.
 */
$cat_link = function ( $slug ) use ( $shop_url ) {
	if ( taxonomy_exists( 'product_cat' ) ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			return get_term_link( $term );
		}
	}
	return $shop_url;
};

$showcase = post_type_exists( 'cb_showcase' ) ? get_post_type_archive_link( 'cb_showcase' ) : '';

$offers = array(
	array(
		'icon'  => 'puzzle',
		'title' => __( 'WordPress plugins', 'codexbloc' ),
		'text'  => __( 'Focused tools for WooCommerce stores. Every premium plugin starts as a free version on WordPress.org, so you can try it on your own store before you upgrade.', 'codexbloc' ),
		'label' => __( 'Browse plugins', 'codexbloc' ),
		'url'   => $cat_link( 'wordpress-plugins' ),
	),
	array(
		'icon'  => 'code',
		'title' => __( 'WordPress themes', 'codexbloc' ),
		'text'  => __( 'Clean, mobile-friendly themes for authors, businesses and online shops. Preview real sample sites before you choose one.', 'codexbloc' ),
		'label' => $showcase ? __( 'See sample sites', 'codexbloc' ) : __( 'Browse themes', 'codexbloc' ),
		'url'   => $showcase ? $showcase : $cat_link( 'wordpress-themes' ),
	),
	array(
		'icon'  => 'bag',
		'title' => __( 'Web design & development', 'codexbloc' ),
		'text'  => __( 'Need it done for you? We design, build and maintain websites and online stores, from a simple business site to a full e-commerce setup.', 'codexbloc' ),
		'label' => __( 'Talk to us', 'codexbloc' ),
		'url'   => $contact,
	),
);
?>

<main id="main">

	<!-- Intro -->
	<section class="border-b border-slate-100 bg-gradient-to-b from-accent-soft/60 to-white">
		<div class="cb-container py-14 sm:py-20">
			<div class="mx-auto max-w-3xl text-center">
				<p class="inline-flex items-center rounded-full border border-accent/20 bg-white px-3 py-1 text-xs font-medium text-accent"><?php esc_html_e( 'About us', 'codexbloc' ); ?></p>
				<h1 class="mt-5 text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl"><?php esc_html_e( 'We help online stores run faster and sell more.', 'codexbloc' ); ?></h1>
				<p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed tracking-tight text-slate-600"><?php esc_html_e( 'Codexbloc builds lightweight plugins, themes and websites for WordPress and WooCommerce. We keep our work simple, fast and easy to use, so you spend less time fixing your site and more time running your business.', 'codexbloc' ); ?></p>
				<?php
				while ( have_posts() ) :
					the_post();
					if ( get_the_content() ) :
						?>
						<div class="cb-prose mx-auto mt-8 text-left"><?php the_content(); ?></div>
						<?php
					endif;
				endwhile;
				?>
			</div>
		</div>
	</section>

	<!-- What we do -->
	<section class="cb-container pt-16 sm:pt-24" aria-labelledby="cb-about-do">
		<div class="mx-auto max-w-2xl text-center">
			<h2 id="cb-about-do" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'What we do', 'codexbloc' ); ?></h2>
			<p class="mt-3 text-slate-600"><?php esc_html_e( 'Ready-made tools when you want to do it yourself, and a team when you want it done for you.', 'codexbloc' ); ?></p>
		</div>

		<div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3">
			<?php foreach ( $offers as $offer ) : ?>
				<div class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 transition hover:border-slate-300 hover:shadow-md sm:p-8">
					<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( $offer['icon'], 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="mt-5 text-lg font-semibold text-ink"><?php echo esc_html( $offer['title'] ); ?></h3>
					<p class="mt-2 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $offer['text'] ); ?></p>
					<a class="mt-auto inline-flex items-center gap-1 pt-6 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $offer['url'] ); ?>"><?php echo esc_html( $offer['label'] ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="mt-6 text-center text-sm text-slate-500">
			<span class="mr-1.5 inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600"><?php esc_html_e( 'Coming soon', 'codexbloc' ); ?></span>
			<?php esc_html_e( 'PrestaShop modules for stores outside WordPress.', 'codexbloc' ); ?>
		</p>
	</section>

	<!-- How we work -->
	<section class="cb-container pt-16 sm:pt-24" aria-labelledby="cb-about-how">
		<div class="grid grid-cols-1 gap-10 lg:grid-cols-[1fr_2fr] lg:gap-16">
			<div>
				<h2 id="cb-about-how" class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( 'How we work', 'codexbloc' ); ?></h2>
				<p class="mt-3 leading-relaxed text-slate-600"><?php esc_html_e( 'A few simple principles guide everything we build and every site we deliver.', 'codexbloc' ); ?></p>
			</div>
			<div class="grid grid-cols-1 gap-x-10 gap-y-8 sm:grid-cols-2">
				<?php foreach ( codexbloc_pillars() as $pillar ) : ?>
					<div class="flex gap-4">
						<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-ink"><?php echo codexbloc_icon( $pillar['icon'], 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div>
							<h3 class="font-semibold text-ink"><?php echo esc_html( $pillar['title'] ); ?></h3>
							<p class="mt-1 text-sm leading-relaxed text-slate-600"><?php echo esc_html( $pillar['text'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Work together -->
	<section class="cb-container pt-16 sm:pt-24">
		<div class="flex flex-col items-start justify-between gap-6 rounded-3xl border border-accent/15 bg-accent-soft/60 px-6 py-10 sm:px-10 md:flex-row md:items-center md:py-12">
			<div>
				<h2 class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl"><?php esc_html_e( "Let's work together", 'codexbloc' ); ?></h2>
				<p class="mt-2 max-w-xl text-slate-600"><?php esc_html_e( 'Whether you need a single plugin or a complete website, we would love to help.', 'codexbloc' ); ?></p>
			</div>
			<div class="flex flex-wrap gap-3">
				<a class="btn btn-primary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?></a>
				<a class="btn btn-outline" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?></a>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
