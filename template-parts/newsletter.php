<?php
/**
 * Newsletter signup section, shown above the footer.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<section id="newsletter" class="cb-container mt-20 scroll-mt-24" aria-labelledby="cb-newsletter-title">
	<div class="rounded-3xl bg-accent-soft px-6 py-10 sm:px-10 md:py-12">
		<div class="grid grid-cols-1 items-center gap-8 md:grid-cols-2">

			<div>
				<span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-accent shadow-sm">
					<?php echo codexbloc_icon( 'mail', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</span>
				<h2 id="cb-newsletter-title" class="mt-4 text-2xl sm:text-3xl"><?php echo esc_html( codexbloc_mod( 'newsletter_title' ) ); ?></h2>
				<p class="mt-2 max-w-md text-slate-600"><?php echo esc_html( codexbloc_mod( 'newsletter_text' ) ); ?></p>
			</div>

			<div>
				<?php get_template_part( 'template-parts/newsletter-form' ); ?>
			</div>

		</div>
	</div>
</section>
