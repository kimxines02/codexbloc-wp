<?php
/**
 * Template Name: Contact
 *
 * Used automatically for the page with the slug "contact", or pick
 * "Contact" under Page Attributes > Template for any other page.
 * Messages are sent to support@codexbloc.com (see inc/contact.php).
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$state     = codexbloc_contact_state();
$values    = $state['values'];
$errors    = $state['errors'];
$sent      = isset( $_GET['sent'] ) && ! $errors; // phpcs:ignore WordPress.Security.NonceVerification
$recipient = codexbloc_contact_recipient();
$topics    = codexbloc_contact_topics();
$shop_url  = codexbloc_shop_url();
?>

<main id="main">

	<!-- Intro -->
	<section class="border-b border-slate-100 bg-gradient-to-b from-accent-soft/60 to-white">
		<div class="cb-container py-14 sm:py-20">
			<div class="mx-auto max-w-2xl text-center">
				<p class="inline-flex items-center rounded-full border border-accent/20 bg-white px-3 py-1 text-xs font-medium text-accent"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?></p>
				<?php while ( have_posts() ) : the_post(); ?>
					<h1 class="mt-5 text-4xl font-semibold leading-[1.1] tracking-tight text-ink sm:text-5xl"><?php esc_html_e( 'How can we help?', 'codexbloc' ); ?></h1>
					<p class="mt-5 text-lg leading-relaxed tracking-tight text-slate-600"><?php esc_html_e( 'Questions about a plugin, your license, or a custom project? Send us a message and the people who build our products will get back to you.', 'codexbloc' ); ?></p>
				<?php endwhile; ?>
			</div>
		</div>
	</section>

	<section class="cb-container py-14 sm:py-20">
		<div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-12">

			<!-- Contact details -->
			<aside class="space-y-5 lg:col-span-4">
				<div class="rounded-2xl border border-slate-200 bg-white p-6">
					<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'mail', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h2 class="mt-4 font-semibold text-ink"><?php esc_html_e( 'Email us', 'codexbloc' ); ?></h2>
					<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'Prefer your own email app? Write to us directly.', 'codexbloc' ); ?></p>
					<a class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( 'mailto:' . antispambot( $recipient ) ); ?>"><?php echo esc_html( antispambot( $recipient ) ); ?></a>
				</div>

				<div class="rounded-2xl border border-slate-200 bg-white p-6">
					<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'clock', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h2 class="mt-4 font-semibold text-ink"><?php esc_html_e( 'Response time', 'codexbloc' ); ?></h2>
					<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'We reply within one business day, Monday to Friday. Premium customers get priority.', 'codexbloc' ); ?></p>
				</div>

				<div class="rounded-2xl border border-slate-200 bg-white p-6">
					<span class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-soft text-accent"><?php echo codexbloc_icon( 'puzzle', 'h-6 w-6' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h2 class="mt-4 font-semibold text-ink"><?php esc_html_e( 'Product support', 'codexbloc' ); ?></h2>
					<p class="mt-1.5 text-sm leading-relaxed text-slate-600"><?php esc_html_e( 'Include the plugin name, your WordPress and WooCommerce versions, and the steps to reproduce the issue. It helps us fix things faster.', 'codexbloc' ); ?></p>
					<a class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-accent hover:text-accent-dark" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse products', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				</div>
			</aside>

			<!-- Form -->
			<div id="contact-form" class="scroll-mt-24 lg:col-span-8">
				<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-10">

					<?php if ( $sent ) : ?>
						<div class="py-10 text-center" role="status">
							<span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"><?php echo codexbloc_icon( 'check', 'h-7 w-7' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<h2 class="mt-5 text-2xl font-semibold tracking-tight text-ink"><?php esc_html_e( 'Thanks, your message is on its way.', 'codexbloc' ); ?></h2>
							<p class="mx-auto mt-3 max-w-md text-slate-600"><?php esc_html_e( 'We will reply to the email address you gave us, usually within one business day.', 'codexbloc' ); ?></p>
							<div class="mt-8 flex flex-wrap justify-center gap-3">
								<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'codexbloc' ); ?></a>
								<a class="btn btn-outline" href="<?php echo esc_url( get_permalink() . '#contact-form' ); ?>"><?php esc_html_e( 'Send another message', 'codexbloc' ); ?></a>
							</div>
						</div>
					<?php else : ?>
						<h2 class="text-2xl font-semibold tracking-tight text-ink"><?php esc_html_e( 'Send us a message', 'codexbloc' ); ?></h2>
						<p class="mt-2 text-sm text-slate-600"><?php esc_html_e( 'Fields marked * are required.', 'codexbloc' ); ?></p>

						<?php if ( ! empty( $errors['form'] ) ) : ?>
							<div class="mt-6 flex gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
								<?php echo codexbloc_icon( 'alert', 'mt-0.5 h-5 w-5 shrink-0' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<span><?php echo esc_html( $errors['form'] ); ?></span>
							</div>
						<?php elseif ( $errors ) : ?>
							<div class="mt-6 flex gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
								<?php echo codexbloc_icon( 'alert', 'mt-0.5 h-5 w-5 shrink-0' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<span><?php esc_html_e( 'Please fix the highlighted fields and try again.', 'codexbloc' ); ?></span>
							</div>
						<?php endif; ?>

						<form class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2" method="post" action="<?php echo esc_url( get_permalink() . '#contact-form' ); ?>">
							<input type="hidden" name="codexbloc_contact" value="1">
							<input type="hidden" name="cb_started" value="<?php echo esc_attr( time() ); ?>">
							<?php wp_nonce_field( 'codexbloc_contact', '_cb_contact_nonce' ); ?>

							<div class="hidden" aria-hidden="true">
								<label for="cb-website"><?php esc_html_e( 'Leave this field empty', 'codexbloc' ); ?></label>
								<input type="text" id="cb-website" name="cb_website" value="" tabindex="-1" autocomplete="off">
							</div>

							<div>
								<label for="cb-name" class="mb-1.5 block text-sm font-medium text-ink"><?php esc_html_e( 'Your name', 'codexbloc' ); ?> <span class="text-red-600">*</span></label>
								<input type="text" id="cb-name" name="cb_name" value="<?php echo esc_attr( $values['name'] ); ?>" required maxlength="100" autocomplete="name"<?php codexbloc_contact_field_aria( 'name' ); ?> class="<?php echo isset( $errors['name'] ) ? '!border-red-400' : ''; ?>">
								<?php codexbloc_contact_field_error( 'name' ); ?>
							</div>

							<div>
								<label for="cb-email" class="mb-1.5 block text-sm font-medium text-ink"><?php esc_html_e( 'Email address', 'codexbloc' ); ?> <span class="text-red-600">*</span></label>
								<input type="email" id="cb-email" name="cb_email" value="<?php echo esc_attr( $values['email'] ); ?>" required maxlength="150" autocomplete="email"<?php codexbloc_contact_field_aria( 'email' ); ?> class="<?php echo isset( $errors['email'] ) ? '!border-red-400' : ''; ?>">
								<?php codexbloc_contact_field_error( 'email' ); ?>
							</div>

							<div>
								<label for="cb-topic" class="mb-1.5 block text-sm font-medium text-ink"><?php esc_html_e( 'What can we help with?', 'codexbloc' ); ?> <span class="text-red-600">*</span></label>
								<select id="cb-topic" name="cb_topic" required<?php codexbloc_contact_field_aria( 'topic' ); ?> class="<?php echo isset( $errors['topic'] ) ? '!border-red-400' : ''; ?>">
									<option value=""><?php esc_html_e( 'Choose a topic', 'codexbloc' ); ?></option>
									<?php foreach ( $topics as $key => $label ) : ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $values['topic'], $key ); ?>><?php echo esc_html( $label ); ?></option>
									<?php endforeach; ?>
								</select>
								<?php codexbloc_contact_field_error( 'topic' ); ?>
							</div>

							<div>
								<label for="cb-subject" class="mb-1.5 block text-sm font-medium text-ink"><?php esc_html_e( 'Subject', 'codexbloc' ); ?></label>
								<input type="text" id="cb-subject" name="cb_subject" value="<?php echo esc_attr( $values['subject'] ); ?>" maxlength="150">
							</div>

							<div class="sm:col-span-2">
								<label for="cb-message" class="mb-1.5 block text-sm font-medium text-ink"><?php esc_html_e( 'Message', 'codexbloc' ); ?> <span class="text-red-600">*</span></label>
								<textarea id="cb-message" name="cb_message" rows="7" required minlength="10" maxlength="5000"<?php codexbloc_contact_field_aria( 'message' ); ?> class="<?php echo isset( $errors['message'] ) ? '!border-red-400' : ''; ?>"><?php echo esc_textarea( $values['message'] ); ?></textarea>
								<?php codexbloc_contact_field_error( 'message' ); ?>
							</div>

							<div class="flex flex-col-reverse gap-4 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between">
								<p class="text-xs leading-relaxed text-slate-500"><?php esc_html_e( 'We only use your details to reply to this message.', 'codexbloc' ); ?></p>
								<button type="submit" class="btn btn-primary w-full sm:w-auto"><?php esc_html_e( 'Send message', 'codexbloc' ); ?><?php echo codexbloc_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
							</div>
						</form>
					<?php endif; ?>

				</div>
			</div>

		</div>
	</section>

</main>

<?php
get_footer();
