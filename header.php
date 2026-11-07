<?php
/**
 * Site header.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:shadow-lg" href="#main"><?php esc_html_e( 'Skip to content', 'codexbloc' ); ?></a>

<header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
	<div class="cb-container flex h-16 items-center justify-between gap-4">

		<div class="flex shrink-0 items-center">
			<?php codexbloc_logo(); ?>
		</div>

		<nav class="hidden lg:block" aria-label="<?php esc_attr_e( 'Primary', 'codexbloc' ); ?>">
			<?php codexbloc_primary_menu( 'desktop' ); ?>
		</nav>

		<div class="flex items-center gap-1">
			<details class="cb-search relative">
				<summary class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-full text-slate-600 transition hover:bg-slate-100 hover:text-ink [&::-webkit-details-marker]:hidden" aria-label="<?php esc_attr_e( 'Search', 'codexbloc' ); ?>">
					<?php echo codexbloc_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</summary>
				<div class="absolute right-0 top-12 z-40 w-[min(20rem,calc(100vw-2rem))] rounded-xl border border-slate-200 bg-white p-3 shadow-lg">
					<?php get_search_form(); ?>
				</div>
			</details>

			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a class="hidden h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-slate-100 hover:text-ink sm:inline-flex" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'My account', 'codexbloc' ); ?>">
					<?php echo codexbloc_icon( 'user' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</a>
				<?php codexbloc_cart_link(); ?>
			<?php endif; ?>

			<button type="button" class="cb-menu-toggle inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-700 transition hover:bg-slate-100 lg:hidden" aria-expanded="false" aria-controls="cb-mobile-menu" aria-label="<?php esc_attr_e( 'Menu', 'codexbloc' ); ?>">
				<span class="cb-icon-open"><?php echo codexbloc_icon( 'menu', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				<span class="cb-icon-close hidden"><?php echo codexbloc_icon( 'close', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			</button>
		</div>
	</div>

	<div id="cb-mobile-menu" class="hidden border-t border-slate-200 bg-white lg:hidden">
		<nav class="cb-container max-h-[calc(100vh-4rem)] overflow-y-auto py-3" aria-label="<?php esc_attr_e( 'Mobile', 'codexbloc' ); ?>">
			<?php codexbloc_primary_menu( 'mobile' ); ?>
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a class="mt-1 block rounded-lg px-3 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-accent sm:hidden" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My account', 'codexbloc' ); ?></a>
			<?php endif; ?>
		</nav>
	</div>
</header>
