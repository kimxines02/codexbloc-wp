<?php
/**
 * Showcase archive (/showcase/) and site-type pages (/showcase/type/{type}/).
 *
 * Add samples in wp-admin > Showcase. Site types become the filter pills.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$cb_all_url = codexbloc_showcase_url();
$cb_current = is_tax( 'cb_showcase_type' ) ? get_queried_object() : null;
$cb_types   = get_terms(
	array(
		'taxonomy'   => 'cb_showcase_type',
		'hide_empty' => true,
	)
);
$cb_types   = is_wp_error( $cb_types ) ? array() : $cb_types;
$cb_contact = codexbloc_link( codexbloc_mod( 'contact_url' ) );
?>

<main id="main">

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
						esc_html_e( 'See what you can build', 'codexbloc' );
					}
					?>
				</h1>
				<p class="mt-5 text-lg leading-relaxed tracking-tight text-slate-600">
					<?php
					if ( $cb_current && $cb_current->description ) {
						echo esc_html( $cb_current->description );
					} else {
						esc_html_e( 'Sample websites made with our themes. Browse by type, hover to scroll through a page, and open a live demo to try it.', 'codexbloc' );
					}
					?>
				</p>
			</div>
		</div>
	</section>

	<section class="cb-container py-10 sm:py-14">
		<?php if ( count( $cb_types ) > 1 || $cb_current ) : ?>
			<nav class="cb-sc-filter mb-10 flex flex-wrap justify-center gap-2" aria-label="<?php esc_attr_e( 'Filter by site type', 'codexbloc' ); ?>">
				<a class="cb-sc-pill" href="<?php echo esc_url( $cb_all_url ); ?>" data-type=""<?php echo $cb_current ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All', 'codexbloc' ); ?></a>
				<?php foreach ( $cb_types as $cb_type ) : ?>
					<a class="cb-sc-pill" href="<?php echo esc_url( get_term_link( $cb_type ) ); ?>" data-type="<?php echo esc_attr( $cb_type->slug ); ?>"<?php echo ( $cb_current && $cb_current->term_id === $cb_type->term_id ) ? ' aria-current="page"' : ''; ?>>
						<?php echo esc_html( $cb_type->name ); ?>
						<span class="text-slate-400"><?php echo esc_html( number_format_i18n( $cb_type->count ) ); ?></span>
					</a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="cb-sc-grid grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/showcase-card' );
				}
				?>
			</div>
			<div class="mt-12"><?php codexbloc_pagination(); ?></div>
		<?php else : ?>
			<div class="mx-auto max-w-xl rounded-2xl border border-dashed border-slate-300 p-10 text-center">
				<p class="font-medium text-ink"><?php esc_html_e( 'No sample sites yet.', 'codexbloc' ); ?></p>
				<?php if ( current_user_can( 'edit_posts' ) ) : ?>
					<a class="btn btn-primary mt-5" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cb_showcase' ) ); ?>"><?php esc_html_e( 'Add your first sample site', 'codexbloc' ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</section>

	<section class="cb-container pb-16 sm:pb-24">
		<div class="mx-auto max-w-5xl rounded-3xl bg-ink px-6 py-10 text-center text-slate-300 sm:px-10 sm:py-12">
			<h2 class="text-2xl font-semibold tracking-tight text-white sm:text-3xl"><?php esc_html_e( 'Want a site like these?', 'codexbloc' ); ?></h2>
			<p class="mx-auto mt-3 max-w-xl leading-relaxed"><?php esc_html_e( 'Get the theme and set it up yourself, or ask us to build and launch it for you.', 'codexbloc' ); ?></p>
			<div class="mt-6 flex flex-wrap justify-center gap-3">
				<a class="btn btn-primary" href="<?php echo esc_url( codexbloc_shop_url() ); ?>"><?php esc_html_e( 'Browse themes', 'codexbloc' ); ?></a>
				<a class="btn bg-white text-ink hover:bg-slate-100 hover:text-ink" href="<?php echo esc_url( $cb_contact ); ?>"><?php esc_html_e( 'Contact us', 'codexbloc' ); ?></a>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
