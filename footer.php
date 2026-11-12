<?php
/**
 * Site footer.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email    = codexbloc_mod( 'contact_email' );
$privacy  = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
$terms    = codexbloc_mod( 'terms_url' );
$socials  = codexbloc_social_links();

$show_newsletter = codexbloc_newsletter_enabled();
if ( $show_newsletter ) {
	get_template_part( 'template-parts/newsletter' );
}
?>

<footer class="<?php echo $show_newsletter ? '' : 'mt-20 border-t border-slate-200 '; ?>bg-slate-50">
	<div class="cb-container py-12">
		<div class="grid grid-cols-1 gap-10 md:grid-cols-12">

			<div class="md:col-span-5">
				<?php codexbloc_logo(); ?>
				<p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-600"><?php echo esc_html( codexbloc_mod( 'footer_text' ) ); ?></p>
				<?php if ( $socials ) : ?>
					<div class="mt-4 flex items-center gap-1"><?php echo $socials; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<?php endif; ?>
			</div>

			<div class="md:col-span-3">
				<h2 class="text-sm font-semibold text-ink"><?php esc_html_e( 'Explore', 'codexbloc' ); ?></h2>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'mt-4 flex flex-col gap-2',
							'depth'          => 1,
							'cb_variant'     => 'footer',
						)
					);
				} else {
					?>
					<ul class="mt-4 flex flex-col gap-2 text-sm">
						<li><a class="text-slate-600 hover:text-accent" href="<?php echo esc_url( codexbloc_shop_url() ); ?>"><?php esc_html_e( 'All products', 'codexbloc' ); ?></a></li>
						<?php if ( (int) get_option( 'page_for_posts' ) ) : ?>
							<li><a class="text-slate-600 hover:text-accent" href="<?php echo esc_url( get_permalink( (int) get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Blog', 'codexbloc' ); ?></a></li>
						<?php endif; ?>
						<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
							<li><a class="text-slate-600 hover:text-accent" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My account', 'codexbloc' ); ?></a></li>
						<?php endif; ?>
						<li><a class="text-slate-600 hover:text-accent" href="<?php echo esc_url( codexbloc_link( codexbloc_mod( 'contact_url' ) ) ); ?>"><?php esc_html_e( 'Contact', 'codexbloc' ); ?></a></li>
					</ul>
					<?php
				}
				?>
			</div>

			<div class="md:col-span-4">
				<h2 class="text-sm font-semibold text-ink"><?php esc_html_e( 'Questions?', 'codexbloc' ); ?></h2>
				<p class="mt-4 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'Need help with a plugin or a custom project? We are happy to help.', 'codexbloc' ); ?></p>
				<a class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo $email ? esc_url( 'mailto:' . antispambot( $email ) ) : esc_url( codexbloc_link( codexbloc_mod( 'contact_url' ) ) ); ?>">
					<?php echo $email ? esc_html( antispambot( $email ) ) : esc_html__( 'Contact us', 'codexbloc' ); ?>
					<?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</a>
			</div>
		</div>

		<div class="mt-10 flex flex-col gap-3 border-t border-slate-200 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'codexbloc' ); ?></p>
			<p class="flex gap-4">
				<?php if ( $terms ) : ?>
					<a class="hover:text-accent" href="<?php echo esc_url( $terms ); ?>"><?php esc_html_e( 'Terms of Service', 'codexbloc' ); ?></a>
				<?php endif; ?>
				<?php if ( $privacy ) : ?>
					<a class="hover:text-accent" href="<?php echo esc_url( $privacy ); ?>"><?php esc_html_e( 'Privacy Policy', 'codexbloc' ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
