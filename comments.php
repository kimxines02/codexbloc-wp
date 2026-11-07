<?php
/**
 * Comments template.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="mx-auto mt-14 max-w-3xl">
	<?php if ( have_comments() ) : ?>
		<h2 class="text-xl font-semibold text-ink">
			<?php
			/* translators: %s: number of comments */
			printf( esc_html( _n( '%s comment', '%s comments', get_comments_number(), 'codexbloc' ) ), esc_html( number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>
		<ol class="cb-comments mt-6 space-y-6">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 40,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit' => 'btn btn-primary',
			'title_reply_before' => '<h2 id="reply-title" class="mt-10 text-xl font-semibold text-ink">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>
</section>
