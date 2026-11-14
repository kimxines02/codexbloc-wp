<?php
/**
 * Floating section index.
 *
 * Desktop (xl+): a slim dot rail on the right edge; labels appear on hover/focus.
 * Phones/tablets: a "Sections" button bottom-right that opens the list.
 * The current section is highlighted while scrolling.
 *
 * Usage: get_template_part( 'template-parts/section-index', null, array( 'sections' => array( 'id' => 'Label' ) ) );
 *
 * @package Codexbloc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cb_sections = isset( $args['sections'] ) && is_array( $args['sections'] ) ? $args['sections'] : array();
if ( count( $cb_sections ) < 2 ) {
	return;
}
$cb_first = reset( $cb_sections );
?>

<!-- Desktop rail -->
<nav class="cb-index group/index fixed right-5 top-1/2 z-30 hidden -translate-y-1/2 xl:block" aria-label="<?php esc_attr_e( 'Page sections', 'codexbloc' ); ?>">
	<ol class="flex flex-col items-end gap-1 rounded-full border border-slate-200/80 bg-white/90 px-2 py-3 shadow-lg shadow-slate-900/5 backdrop-blur" role="list">
		<?php foreach ( $cb_sections as $cb_id => $cb_label ) : ?>
			<li>
				<a class="cb-index-link group/link relative flex h-6 w-6 items-center justify-center" href="#<?php echo esc_attr( $cb_id ); ?>" data-section="<?php echo esc_attr( $cb_id ); ?>">
					<span class="cb-index-label pointer-events-none absolute right-9 whitespace-nowrap rounded-full bg-ink px-3 py-1 text-xs font-medium text-white opacity-0 shadow-md transition duration-200 group-hover/index:translate-x-0 group-hover/index:opacity-100 group-focus-visible/link:opacity-100 translate-x-1"><?php echo esc_html( $cb_label ); ?></span>
					<span class="cb-index-dot block h-2 w-2 rounded-full bg-slate-300 transition-all duration-200 group-hover/link:bg-slate-500" aria-hidden="true"></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>

<!-- Phone / tablet button -->
<div class="cb-index-mobile pointer-events-none fixed bottom-5 right-4 z-30 translate-y-3 opacity-0 transition duration-300 xl:hidden">
	<div id="cb-index-menu" class="absolute bottom-full right-0 mb-3 hidden w-60 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10">
		<p class="px-3 pb-1 pt-2 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500"><?php esc_html_e( 'On this page', 'codexbloc' ); ?></p>
		<ol role="list">
			<?php foreach ( $cb_sections as $cb_id => $cb_label ) : ?>
				<li><a class="cb-index-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-ink" href="#<?php echo esc_attr( $cb_id ); ?>" data-section="<?php echo esc_attr( $cb_id ); ?>"><span class="cb-index-dot h-1.5 w-1.5 shrink-0 rounded-full bg-slate-300" aria-hidden="true"></span><?php echo esc_html( $cb_label ); ?></a></li>
			<?php endforeach; ?>
		</ol>
	</div>
	<button type="button" class="flex items-center gap-2 rounded-full border border-slate-200 bg-white/95 py-2.5 pl-3.5 pr-4 text-sm font-medium text-ink shadow-lg shadow-slate-900/10 backdrop-blur" aria-expanded="false" aria-controls="cb-index-menu">
		<?php echo codexbloc_icon( 'menu', 'h-4 w-4 text-accent' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		<span class="sr-only"><?php esc_html_e( 'Jump to section:', 'codexbloc' ); ?></span>
		<span class="cb-index-current"><?php echo esc_html( $cb_first ); ?></span>
	</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var links = document.querySelectorAll('.cb-index-link');
	var ids = [];
	links.forEach(function (a) {
		var id = a.getAttribute('data-section');
		if (!document.getElementById(id)) { a.parentNode.remove(); return; }
		if (ids.indexOf(id) < 0) ids.push(id);
	});
	if (ids.length < 2) return;

	var mobile = document.querySelector('.cb-index-mobile');
	var btn = mobile.querySelector('button');
	var menu = document.getElementById('cb-index-menu');
	var current = mobile.querySelector('.cb-index-current');
	var active = null;

	function setActive(id) {
		if (id === active) return;
		active = id;
		document.querySelectorAll('.cb-index-link').forEach(function (a) {
			var on = a.getAttribute('data-section') === id;
			a.classList.toggle('is-active', on);
			if (on) { a.setAttribute('aria-current', 'location'); } else { a.removeAttribute('aria-current'); }
			if (on && a.closest('#cb-index-menu')) current.textContent = a.textContent.trim();
		});
	}

	function update() {
		var line = window.innerHeight * 0.4, id = ids[0];
		ids.forEach(function (sid) {
			var el = document.getElementById(sid);
			if (el && el.getBoundingClientRect().top <= line) id = sid;
		});
		// At the very bottom, highlight the last section.
		if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 4) id = ids[ids.length - 1];
		setActive(id);
		var show = window.scrollY > 320;
		mobile.classList.toggle('opacity-0', !show);
		mobile.classList.toggle('translate-y-3', !show);
		mobile.classList.toggle('pointer-events-none', !show);
		if (!show) close();
	}

	function open() { menu.classList.remove('hidden'); btn.setAttribute('aria-expanded', 'true'); }
	function close() { menu.classList.add('hidden'); btn.setAttribute('aria-expanded', 'false'); }

	btn.addEventListener('click', function () { menu.classList.contains('hidden') ? open() : close(); });
	menu.addEventListener('click', function (e) { if (e.target.closest('a')) close(); });
	document.addEventListener('click', function (e) { if (!mobile.contains(e.target)) close(); });
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !menu.classList.contains('hidden')) { close(); btn.focus(); } });

	var ticking = false;
	window.addEventListener('scroll', function () {
		if (ticking) return;
		ticking = true;
		requestAnimationFrame(function () { update(); ticking = false; });
	}, { passive: true });
	window.addEventListener('resize', update);
	update();
});
</script>
