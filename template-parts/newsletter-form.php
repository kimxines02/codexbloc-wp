<?php
/**
 * Newsletter signup form for dark backgrounds: one rounded field with the
 * Subscribe button inside it. Used by template-parts/newsletter.php and the
 * showcase page's closing panel.
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
<form
	class="flex items-center gap-2 rounded-full bg-white/10 p-1.5 ring-1 ring-white/15 backdrop-blur transition focus-within:bg-white/[0.14] focus-within:ring-white/40"
	method="post"
	action="<?php echo esc_url( $external ? $action : admin_url( 'admin-post.php' ) ); ?>"
	<?php echo $external ? 'target="_blank" rel="noopener"' : ''; ?>
>
	<label for="cb-nl-email" class="sr-only"><?php esc_html_e( 'Email address', 'codexbloc' ); ?></label>
	<input
		type="email"
		id="cb-nl-email"
		name="<?php echo esc_attr( $external ? $field : 'cb_nl_email' ); ?>"
		class="cb-input-bare min-w-0 flex-1"
		placeholder="<?php esc_attr_e( 'Enter your email', 'codexbloc' ); ?>"
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
	<button type="submit" class="btn shrink-0 bg-white px-5 py-2.5 text-ink shadow-sm hover:bg-slate-100 hover:text-ink sm:px-6"><?php echo esc_html( codexbloc_mod( 'newsletter_button' ) ); ?></button>
</form>

<?php if ( $status ) : ?>
	<p id="cb-nl-status" role="status" class="mt-3 pl-5 text-sm font-medium <?php echo $is_error ? 'text-red-300' : 'text-white'; ?>">
		<?php echo esc_html( $messages[ $status ] ); ?>
	</p>
<?php else : ?>
	<p class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 pl-5 text-xs text-slate-400">
		<span class="inline-flex items-center gap-1.5"><?php echo codexbloc_icon( 'check', 'h-3.5 w-3.5 text-slate-300' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'No spam', 'codexbloc' ); ?></span>
		<span class="inline-flex items-center gap-1.5"><?php echo codexbloc_icon( 'check', 'h-3.5 w-3.5 text-slate-300' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Unsubscribe any time', 'codexbloc' ); ?></span>
	</p>
<?php endif; ?>
