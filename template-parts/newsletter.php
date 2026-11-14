<?php
/**
 * Newsletter signup: full-width band directly above the footer.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section id="newsletter" class="relative isolate <?php echo is_front_page() ? '' : 'mt-20 '; ?>scroll-mt-24 overflow-hidden bg-ink" aria-labelledby="cb-newsletter-title">
	<div class="cb-dots pointer-events-none absolute inset-0 -z-10" aria-hidden="true"></div>
	<div class="pointer-events-none absolute -top-40 right-[-10%] -z-10 h-96 w-96 rounded-full bg-accent/35 blur-3xl" aria-hidden="true"></div>
	<div class="pointer-events-none absolute -bottom-48 left-[-5%] -z-10 h-80 w-80 rounded-full bg-accent/15 blur-3xl" aria-hidden="true"></div>

	<div class="cb-container py-14 sm:py-16">
		<div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-[1.15fr_1fr] lg:gap-16">

			<div class="flex items-start gap-5">
				<span class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/15 sm:flex">
					<?php echo codexbloc_icon( 'mail', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</span>
				<div>
					<p class="text-xs font-medium uppercase tracking-[0.14em] text-slate-400"><?php esc_html_e( 'Newsletter', 'codexbloc' ); ?></p>
					<h2 id="cb-newsletter-title" class="mt-2 text-2xl font-semibold tracking-tight text-white sm:text-3xl"><?php echo esc_html( codexbloc_mod( 'newsletter_title' ) ); ?></h2>
					<p class="mt-2 max-w-lg leading-relaxed text-slate-400"><?php echo esc_html( codexbloc_mod( 'newsletter_text' ) ); ?></p>
				</div>
			</div>

			<div>
				<?php get_template_part( 'template-parts/newsletter-form' ); ?>
			</div>

		</div>
	</div>
</section>
