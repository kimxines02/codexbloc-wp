<?php
/**
 * Newsletter signup form (used by template-parts/newsletter.php and the
 * showcase page's closing panel).
 *
 * Args: 'dark' => true for use on a dark background.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$dark     = ! empty( $args['dark'] );
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
		class="cb-input sm:flex-1<?php echo $dark ? ' cb-input-dark' : ''; ?>"
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
	<button type="submit" class="btn shrink-0 <?php echo $dark ? 'bg-white text-ink hover:bg-slate-100 hover:text-ink' : 'btn-primary'; ?>"><?php echo esc_html( codexbloc_mod( 'newsletter_button' ) ); ?></button>
</form>

<?php if ( $status ) : ?>
	<p id="cb-nl-status" role="status" class="mt-3 text-sm font-medium <?php echo $is_error ? ( $dark ? 'text-red-300' : 'text-red-600' ) : ( $dark ? 'text-white' : 'text-accent' ); ?>">
		<?php echo esc_html( $messages[ $status ] ); ?>
	</p>
<?php else : ?>
	<p class="mt-3 text-xs <?php echo $dark ? 'text-slate-400' : 'text-slate-500'; ?>"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'codexbloc' ); ?></p>
<?php endif; ?>
