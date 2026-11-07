<?php
/**
 * 404 page.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="cb-container py-20 text-center sm:py-28">
	<p class="text-sm font-semibold text-accent">404</p>
	<h1 class="mt-2 text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php esc_html_e( 'We could not find that page', 'codexbloc' ); ?></h1>
	<p class="mx-auto mt-3 max-w-md text-slate-600"><?php esc_html_e( 'It may have moved or no longer exists. Try a search, or head back to the products.', 'codexbloc' ); ?></p>
	<div class="mx-auto mt-6 max-w-sm"><?php get_search_form(); ?></div>
	<div class="mt-6 flex justify-center gap-3">
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'codexbloc' ); ?></a>
		<a class="btn btn-outline" href="<?php echo esc_url( codexbloc_shop_url() ); ?>"><?php esc_html_e( 'Products', 'codexbloc' ); ?></a>
	</div>
</main>

<?php
get_footer();
