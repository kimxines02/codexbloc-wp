<?php
/**
 * Showcase page (/showcase/) — theme override for the Codexbloc Showcase plugin.
 *
 * The plugin loads this file instead of its own templates/archive.php.
 * The bottom of the page is one closing panel: "Want a site like these?"
 * with the newsletter signup built in (the separate footer newsletter box is
 * hidden on this page so the two never stack).
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$cb_current    = is_tax( 'cb_showcase_type' ) ? get_queried_object() : null;
$cb_contact    = cbsc_link( cbsc_setting( 'cta_url' ) );
$cb_shop       = codexbloc_shop_url();
$cb_newsletter = codexbloc_newsletter_enabled();
?>

<main id="main">

	<!-- Intro -->
	<section class="border-b border-slate-100 bg-gradient-to-b from-accent-soft/60 to-white">
		<div class="cb-container py-14 sm:py-20">
			<div class="mx-auto max-w-2xl text-center">
				<p class="inline-flex items-center rounded-full border border-accent/20 bg-white px-3 py-1 text-xs font-medium text-accent"><?php esc_html_e( 'Showcase', 'codexbloc' ); ?></p>
				<h1 class="mt-5 text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl">
					<?php
					if ( $cb_current ) {
						/* translators: %s: site type, e.g. Author Website */
						printf( esc_html__( '%s samples', 'codexbloc' ), esc_html( $cb_current->name ) );
					} else {
						echo esc_html( cbsc_setting( 'title' ) );
					}
					?>
				</h1>
				<p class="mt-5 text-lg leading-relaxed tracking-tight text-slate-600"><?php echo esc_html( ( $cb_current && $cb_current->description ) ? $cb_current->description : cbsc_setting( 'intro' ) ); ?></p>
			</div>
		</div>
	</section>

	<!-- Samples -->
	<section class="cb-container py-12 sm:py-16">
		<?php
		global $wp_query;
		cbsc_render_grid( $wp_query, array( 'current' => $cb_current ) );
		?>
	</section>

	<!-- Closing panel: call to action + newsletter -->
	<section class="cb-container"<?php echo $cb_newsletter ? ' id="newsletter"' : ''; ?> aria-labelledby="cb-sc-cta-title">
		<div class="relative isolate overflow-hidden rounded-3xl bg-ink text-slate-300 shadow-xl shadow-slate-900/10">
			<div class="pointer-events-none absolute -right-24 -top-32 -z-10 h-80 w-80 rounded-full bg-accent/40 blur-3xl" aria-hidden="true"></div>
			<div class="pointer-events-none absolute -bottom-40 -left-24 -z-10 h-72 w-72 rounded-full bg-accent/20 blur-3xl" aria-hidden="true"></div>

			<div class="grid grid-cols-1 items-center gap-8 px-6 py-12 sm:px-10 md:grid-cols-[1fr_auto] md:gap-12 md:px-14 md:py-16">
				<div>
					<p class="inline-flex items-center rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-slate-200"><?php esc_html_e( 'Start your site', 'codexbloc' ); ?></p>
					<h2 id="cb-sc-cta-title" class="mt-4 text-3xl font-semibold tracking-tight text-white sm:text-4xl"><?php echo esc_html( cbsc_setting( 'cta_title' ) ); ?></h2>
					<p class="mt-3 max-w-xl text-lg leading-relaxed text-slate-300"><?php echo esc_html( cbsc_setting( 'cta_text' ) ); ?></p>
				</div>
				<div class="flex flex-col gap-3 sm:flex-row md:min-w-56 md:flex-col">
					<a class="btn bg-white text-ink hover:bg-slate-100 hover:text-ink" href="<?php echo esc_url( $cb_shop ); ?>"><?php esc_html_e( 'Browse themes', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
					<?php if ( $cb_contact ) : ?>
						<a class="btn border border-white/25 bg-white/5 text-white hover:border-white/50 hover:bg-white/10 hover:text-white" href="<?php echo esc_url( $cb_contact ); ?>"><?php echo esc_html( cbsc_setting( 'cta_label' ) ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $cb_newsletter ) : ?>
				<div class="border-t border-white/10 bg-white/[0.03] px-6 py-8 sm:px-10 md:px-14">
					<div class="grid grid-cols-1 items-center gap-6 md:grid-cols-2 md:gap-12">
						<div class="flex items-start gap-4">
							<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/10 text-white">
								<?php echo codexbloc_icon( 'mail', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</span>
							<div>
								<h3 class="text-base font-semibold text-white"><?php echo esc_html( codexbloc_mod( 'newsletter_title' ) ); ?></h3>
								<p class="mt-1 text-sm leading-relaxed text-slate-400"><?php echo esc_html( codexbloc_mod( 'newsletter_text' ) ); ?></p>
							</div>
						</div>
						<div>
							<?php get_template_part( 'template-parts/newsletter-form', null, array( 'dark' => true ) ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
// The newsletter is already inside the closing panel; skip the footer copy on this page.
add_filter( 'codexbloc_newsletter_enabled', '__return_false' );
get_footer();
