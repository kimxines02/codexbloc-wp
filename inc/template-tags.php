<?php
/**
 * Template helpers: icons, logo, menus, cart link.
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inline SVG icon (outline, 24px grid).
 *
 * @param string $name  Icon name.
 * @param string $class CSS classes.
 * @return string
 */
function codexbloc_icon( $name, $class = 'h-5 w-5' ) {
	$paths = array(
		'arrow'    => 'M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3',
		'check'    => 'm4.5 12.75 6 6 9-13.5',
		'menu'     => 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5',
		'close'    => 'M6 18 18 6M6 6l12 12',
		'search'   => 'm21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z',
		'user'     => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
		'bag'      => 'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z',
		'bolt'     => 'm3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z',
		'puzzle'   => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z',
		'shield'   => 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z',
		'chat'     => 'M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM12 20.25c4.97 0 9-3.694 9-8.25S16.97 3.75 12 3.75 3 7.444 3 12c0 1.6.5 3.09 1.36 4.35L3.75 20.25l4.2-.8A9.9 9.9 0 0 0 12 20.25Z',
		'code'     => 'M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5',
		'download' => 'M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3',
		'external' => 'M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25',
		'mail'     => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
		'clock'    => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
		'alert'    => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z',
	);

	$filled = array(
		'facebook' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073Z',
		'x'        => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117Z',
		'linkedin' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286ZM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065Zm1.782 13.019H3.555V9h3.564v11.452Z',
	);

	if ( isset( $filled[ $name ] ) ) {
		return sprintf(
			'<svg class="%s" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="%s"/></svg>',
			esc_attr( $class ),
			esc_attr( $filled[ $name ] )
		);
	}
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return sprintf(
		'<svg class="%s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="%s"/></svg>',
		esc_attr( $class ),
		esc_attr( $paths[ $name ] )
	);
}

/**
 * Site logo. Order: Customizer logo > assets/img/logo.png > assets/img/logo.svg.
 *
 * @param string $img_class Classes for the fallback image.
 */
function codexbloc_logo( $img_class = 'h-8 w-auto' ) {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	$dir = CODEXBLOC_DIR . '/assets/img/';
	$uri = CODEXBLOC_URI . '/assets/img/';
	$file = file_exists( $dir . 'logo.png' ) ? 'logo.png' : 'logo.svg';

	printf(
		'<a href="%1$s" class="custom-logo-link inline-flex items-center" rel="home" aria-label="%2$s"><img src="%3$s" alt="%2$s" class="%4$s" width="160" height="32" decoding="async"></a>',
		esc_url( home_url( '/' ) ),
		esc_attr( get_bloginfo( 'name' ) ),
		esc_url( $uri . $file ),
		esc_attr( $img_class )
	);
}

/**
 * Cart link with item count. Refreshed through WooCommerce cart fragments.
 */
function codexbloc_cart_link() {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<a class="cb-cart-link relative inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-slate-100 hover:text-ink" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: item count */ _n( 'Cart, %d item', 'Cart, %d items', $count, 'codexbloc' ), $count ) ); ?>">
		<?php echo codexbloc_icon( 'bag', 'h-5 w-5' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<?php if ( $count > 0 ) : ?>
			<span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-accent px-1 text-[10px] font-semibold leading-none text-white"><?php echo esc_html( $count ); ?></span>
		<?php endif; ?>
	</a>
	<?php
}

/**
 * Shop page URL (or blog index when WooCommerce is off).
 */
function codexbloc_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'shop' );
	}
	return home_url( '/' );
}

/**
 * Menu link/list classes. Two variants are printed: desktop and mobile.
 */
function codexbloc_menu_link_class( $variant ) {
	return 'mobile' === $variant
		? 'block rounded-lg px-3 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-accent'
		: 'block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-ink';
}

/**
 * Add classes to menu items and links for our Tailwind styling.
 */
function codexbloc_nav_link_atts( $atts, $item, $args, $depth ) {
	if ( empty( $args->cb_variant ) ) {
		return $atts;
	}
	$class = codexbloc_menu_link_class( $args->cb_variant );
	if ( 'desktop' === $args->cb_variant && $depth > 0 ) {
		$class = 'block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-accent';
	}
	if ( 'footer' === $args->cb_variant ) {
		$class = 'text-sm text-slate-600 hover:text-accent';
	}
	if ( in_array( 'current-menu-item', (array) $item->classes, true ) || in_array( 'current-menu-ancestor', (array) $item->classes, true ) ) {
		$class .= ' !text-accent';
		$atts['aria-current'] = 'page';
	}
	$atts['class'] = trim( ( isset( $atts['class'] ) ? $atts['class'] . ' ' : '' ) . $class );
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'codexbloc_nav_link_atts', 10, 4 );

function codexbloc_nav_item_class( $classes, $item, $args, $depth ) {
	if ( ! empty( $args->cb_variant ) && 'desktop' === $args->cb_variant && 0 === $depth && in_array( 'menu-item-has-children', $classes, true ) ) {
		$classes[] = 'relative group';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'codexbloc_nav_item_class', 10, 4 );

function codexbloc_nav_submenu_class( $classes, $args, $depth ) {
	if ( empty( $args->cb_variant ) ) {
		return $classes;
	}
	if ( 'desktop' === $args->cb_variant ) {
		$classes[] = 'invisible absolute left-0 top-full z-40 min-w-[13rem] translate-y-1 rounded-xl border border-slate-200 bg-white p-2 opacity-0 shadow-lg transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100';
	} else {
		$classes[] = 'ml-3 border-l border-slate-200 pl-2';
	}
	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'codexbloc_nav_submenu_class', 10, 3 );

/**
 * Fallback menu used until a menu is assigned in Appearance > Menus.
 * Lists Shop, the three product categories (if present), a few common pages and Blog.
 *
 * @param array $args wp_nav_menu args.
 */
function codexbloc_menu_fallback( $args ) {
	$variant = isset( $args['cb_variant'] ) ? $args['cb_variant'] : 'desktop';
	$items   = array();

	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$cats = array(
			'wordpress-plugins'  => __( 'Plugins', 'codexbloc' ),
			'wordpress-themes'   => __( 'Themes', 'codexbloc' ),
			'prestashop-modules' => __( 'PrestaShop', 'codexbloc' ),
		);
		$found = false;
		foreach ( $cats as $slug => $label ) {
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( $term && ! is_wp_error( $term ) ) {
				$items[] = array( $label, get_term_link( $term ) );
				$found   = true;
			}
		}
		if ( ! $found ) {
			$items[] = array( __( 'Shop', 'codexbloc' ), wc_get_page_permalink( 'shop' ) );
		}
	}

	$pages = array(
		'services' => __( 'Services', 'codexbloc' ),
		'pricing'  => __( 'Pricing', 'codexbloc' ),
		'docs'     => __( 'Docs', 'codexbloc' ),
		'about'    => __( 'About', 'codexbloc' ),
		'contact'  => __( 'Contact', 'codexbloc' ),
	);
	foreach ( $pages as $slug => $label ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			$items[] = array( $label, get_permalink( $page ) );
		}
	}
	$blog = (int) get_option( 'page_for_posts' );
	if ( $blog ) {
		$items[] = array( __( 'Blog', 'codexbloc' ), get_permalink( $blog ) );
	}

	$ul_class = 'mobile' === $variant ? 'flex flex-col gap-1' : 'flex items-center gap-1';
	echo '<ul class="' . esc_attr( $ul_class ) . '">';
	foreach ( $items as $item ) {
		printf(
			'<li><a class="%s" href="%s">%s</a></li>',
			esc_attr( codexbloc_menu_link_class( $variant ) ),
			esc_url( $item[1] ),
			esc_html( $item[0] )
		);
	}
	echo '</ul>';
}

/**
 * Render the primary menu.
 *
 * @param string $variant desktop|mobile.
 */
function codexbloc_primary_menu( $variant = 'desktop' ) {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'mobile' === $variant ? 'flex flex-col gap-1' : 'flex items-center gap-1',
			'fallback_cb'    => 'codexbloc_menu_fallback',
			'cb_variant'     => $variant,
			'depth'          => 2,
		)
	);
}

/**
 * Social links from the Customizer.
 */
function codexbloc_social_links() {
	$networks = array(
		'facebook' => array( 'facebook_url', 'Facebook' ),
		'x'        => array( 'x_url', 'X' ),
		'linkedin' => array( 'linkedin_url', 'LinkedIn' ),
	);
	$out = '';
	foreach ( $networks as $icon => $net ) {
		$url = codexbloc_mod( $net[0] );
		if ( $url ) {
			$out .= sprintf(
				'<a class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-accent" href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a>',
				esc_url( $url ),
				esc_attr( $net[1] ),
				codexbloc_icon( $icon, 'h-4 w-4' )
			);
		}
	}
	return $out;
}

/**
 * Posts pagination with our classes.
 */
function codexbloc_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => __( 'Previous', 'codexbloc' ),
			'next_text' => __( 'Next', 'codexbloc' ),
		)
	);
}

/**
 * Resolve a link that may be a relative path or an anchor.
 *
 * @param string $url URL.
 */
function codexbloc_link( $url ) {
	$url = (string) $url;
	if ( '' === $url ) {
		return '';
	}
	if ( 0 === strpos( $url, '#' ) ) {
		return $url;
	}
	if ( 0 === strpos( $url, '/' ) ) {
		return home_url( $url );
	}
	return $url;
}

/**
 * URL of the Pricing page (slug "pricing"), or the homepage plans section.
 */
function codexbloc_pricing_url() {
	$page = get_page_by_path( 'pricing' );
	return $page ? get_permalink( $page ) : home_url( '/#premium' );
}
