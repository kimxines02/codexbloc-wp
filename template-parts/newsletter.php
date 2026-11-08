<?php
/**
 * Newsletter signup section, shown above the footer.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$action   = codexbloc_mod( 'newsletter_action' );
$field    = codexbloc_mod( 'newsletter_field' );
$external = '' !== $action;
$status   = $external ? '' : codexbloc_newsletter_status();

$messages = array(
	'ok'      => __( 'Thanks for subscribing! We will be in touch.', 'codexbloc' ),
	'invalid' => __( 'Please enter a valid email address.', 'codexbloc' ),
	'limit'   => __( 'Too many attempts. Please try again later.', 'codexbloc' ),
	'error'   => __( 'Your session expired. Please try again.', 'codexbloc' ),
);
$is_error = $status && 'ok' !== $status;
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
				<form
					class="flex flex-col gap-3 sm:flex-row"
					method="post"
					action="<?php echo esc_url( $external ? $action : admin_url( 'admin-post.php' ) ); ?>"
					<?php echo $external ? 'target="_blank" rel="noopener"' : ''; ?>
				>
					<label for="cb-nl-email" class="sr-only"><?php esc_html_e( 'Email address', 'codexbloc' ); ?></label>
					<input
						type="email"
						id="cb-nl-email"
						name="<?php echo esc_attr( $external ? $field : 'cb_nl_email' ); ?>"
						class="cb-input sm:flex-1"
						placeholder="<?php esc_attr_e( 'you@example.com', 'codexbloc' ); ?>"
						autocomplete="email"
						required
						<?php if ( $status ) : ?>
							aria-describedby="cb-nl-status"<?php echo $is_error ? ' aria-invalid="true"' : ''; ?>
						<?php endif; ?>
					>
					<?php if ( ! $external ) : ?>
						<input type="hidden" name="action" value="codexbloc_newsletter">
						<input type="hidden" name="cb_nl_started" value="<?php echo esc_attr( time() ); ?>">
						<?php wp_nonce_field( 'codexbloc_newsletter', '_cb_newsletter_nonce' ); ?>
						<div class="hidden" aria-hidden="true">
							<label for="cb-nl-website"><?php esc_html_e( 'Leave this field empty', 'codexbloc' ); ?></label>
							<input type="text" id="cb-nl-website" name="cb_nl_website" value="" tabindex="-1" autocomplete="off">
						</div>
					<?php endif; ?>
					<button type="submit" class="btn btn-primary shrink-0"><?php echo esc_html( codexbloc_mod( 'newsletter_button' ) ); ?></button>
				</form>

				<?php if ( $status ) : ?>
					<p id="cb-nl-status" role="status" class="mt-3 text-sm font-medium <?php echo $is_error ? 'text-red-600' : 'text-accent'; ?>">
						<?php echo esc_html( $messages[ $status ] ); ?>
					</p>
				<?php else : ?>
					<p class="mt-3 text-xs text-slate-500"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'codexbloc' ); ?></p>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
