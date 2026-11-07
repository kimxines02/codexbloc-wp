<?php
/**
 * Static pages (also used for the WooCommerce cart, checkout and account pages).
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_shop_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
?>

<main id="main" class="cb-container py-10 sm:py-14">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( $is_shop_page ? '' : 'mx-auto max-w-3xl' ); ?>>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php the_title(); ?></h1>
			</header>
			<div class="<?php echo $is_shop_page ? 'cb-woo-page' : 'cb-prose'; ?>">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>

<?php
get_footer();
