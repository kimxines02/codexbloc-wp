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

<main id="main">
	<?php
	ob_start();
	?>
	<div class="mx-auto mt-6 max-w-sm"><?php get_search_form(); ?></div>
	<div class="mt-6 flex justify-center gap-3">
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'codexbloc' ); ?></a>
		<a class="btn border border-slate-900/10 bg-white/60 text-ink backdrop-blur hover:border-slate-900/20 hover:bg-white hover:text-ink" href="<?php echo esc_url( codexbloc_shop_url() ); ?>"><?php esc_html_e( 'Products', 'codexbloc' ); ?></a>
	</div>
	<?php
	codexbloc_banner(
		array(
			'eyebrow' => '404',
			'title'   => __( 'We could not find that page', 'codexbloc' ),
			'text'    => __( 'It may have moved or no longer exists. Try a search, or head back to the products.', 'codexbloc' ),
			'extra'   => ob_get_clean(),
		)
	);
	?>
	<div class="h-16 sm:h-24" aria-hidden="true"></div>
</main>

<?php
get_footer();
