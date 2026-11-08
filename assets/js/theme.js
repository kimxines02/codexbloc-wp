/**
 * Codexbloc theme script (vanilla JS, no dependencies).
 * - Mobile menu toggle
 * - Header search dropdown closes on outside click / Escape
 * - Turns WooCommerce variation dropdowns (e.g. Monthly / Yearly) into pill buttons
 * - Product gallery thumbnails as a slider (vertical beside the image on sm+)
 */
(function () {
	'use strict';

	/* Mobile menu ---------------------------------------------------------- */
	var toggle = document.querySelector('.cb-menu-toggle');
	var menu = document.getElementById('cb-mobile-menu');

	function setMenu(open) {
		if (!toggle || !menu) { return; }
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		menu.classList.toggle('hidden', !open);
		var o = toggle.querySelector('.cb-icon-open');
		var c = toggle.querySelector('.cb-icon-close');
		if (o && c) {
			o.classList.toggle('hidden', open);
			c.classList.toggle('hidden', !open);
		}
	}

	if (toggle && menu) {
		toggle.addEventListener('click', function () {
			setMenu(toggle.getAttribute('aria-expanded') !== 'true');
		});
		if (window.matchMedia) {
			var mq = window.matchMedia('(min-width: 1024px)');
			var onChange = function (e) { if (e.matches) { setMenu(false); } };
			if (mq.addEventListener) { mq.addEventListener('change', onChange); }
		}
	}

	/* Search dropdown + Escape --------------------------------------------- */
	document.addEventListener('click', function (e) {
		var d = document.querySelector('.cb-search[open]');
		if (d && !d.contains(e.target)) { d.removeAttribute('open'); }
	});
	document.addEventListener('keydown', function (e) {
		if (e.key !== 'Escape') { return; }
		setMenu(false);
		var d = document.querySelector('.cb-search[open]');
		if (d) { d.removeAttribute('open'); }
	});
	document.addEventListener('toggle', function (e) {
		if (e.target && e.target.classList && e.target.classList.contains('cb-search') && e.target.open) {
			var input = e.target.querySelector('input[type="search"]');
			if (input) { input.focus(); }
		}
	}, true);

	/* Variation pills (WooCommerce) ---------------------------------------- */
	function initPills(form) {
		var selects = form.querySelectorAll('.variations select');
		Array.prototype.forEach.call(selects, function (select) {
			var cell = select.closest('td') || select.parentNode;
			if (cell.querySelector('.cb-pills')) { return; }

			var wrap = document.createElement('div');
			wrap.className = 'cb-pills';
			wrap.setAttribute('role', 'radiogroup');
			var label = form.querySelector('label[for="' + select.id + '"]');
			if (label) { wrap.setAttribute('aria-label', label.textContent); }

			function sync() {
				Array.prototype.forEach.call(wrap.children, function (b) {
					b.setAttribute('aria-checked', b.getAttribute('data-value') === select.value ? 'true' : 'false');
				});
			}

			function build() {
				wrap.innerHTML = '';
				Array.prototype.forEach.call(select.options, function (opt) {
					if (!opt.value) { return; }
					var b = document.createElement('button');
					b.type = 'button';
					b.setAttribute('role', 'radio');
					b.setAttribute('data-value', opt.value);
					b.textContent = opt.textContent;
					b.disabled = opt.disabled;
					wrap.appendChild(b);
				});
				sync();
			}

			wrap.addEventListener('click', function (e) {
				var b = e.target.closest ? e.target.closest('button') : null;
				if (!b || b.disabled || select.value === b.getAttribute('data-value')) { return; }
				select.value = b.getAttribute('data-value');
				select.dispatchEvent(new Event('change', { bubbles: true }));
				sync();
			});

			build();
			select.setAttribute('tabindex', '-1');
			cell.classList.add('has-pills');
			cell.insertBefore(wrap, cell.firstChild);

			// WooCommerce rewrites the options when other attributes change or on reset.
			if (window.MutationObserver) {
				new MutationObserver(build).observe(select, { childList: true });
			}
			if (window.jQuery) {
				window.jQuery(select).on('change', sync);
				window.jQuery(form).on('reset_data', function () { setTimeout(sync, 0); });
			} else {
				select.addEventListener('change', sync);
			}
		});
	}

	function initAllPills() {
		var forms = document.querySelectorAll('form.variations_form');
		Array.prototype.forEach.call(forms, initPills);
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAllPills);
	} else {
		initAllPills();
	}

	/* Product gallery thumbnail slider -------------------------------------- */
	var chevron = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>';
	var sideBySide = window.matchMedia ? window.matchMedia('(min-width: 640px)') : null;

	function isVertical() { return !!(sideBySide && sideBySide.matches); }

	function initThumbs(gallery) {
		var list = gallery.querySelector('.flex-control-thumbs');
		if (!list || list.closest('.cb-thumbs')) { return; }

		var wrap = document.createElement('div');
		wrap.className = 'cb-thumbs';
		list.parentNode.insertBefore(wrap, list);
		wrap.appendChild(list);

		function makeBtn(cls, label) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'cb-thumbs-btn ' + cls;
			b.setAttribute('aria-label', label);
			b.innerHTML = chevron;
			wrap.appendChild(b);
			return b;
		}
		var prev = makeBtn('cb-thumbs-prev', 'Previous images');
		var next = makeBtn('cb-thumbs-next', 'Next images');
		next.firstChild.style.transform = 'scaleX(-1)';

		function update() {
			var v = isVertical();
			var pos = v ? list.scrollTop : list.scrollLeft;
			var max = v ? list.scrollHeight - list.clientHeight : list.scrollWidth - list.clientWidth;
			prev.disabled = pos <= 1;
			next.disabled = pos >= max - 1;
		}

		function page(dir) {
			var v = isVertical();
			var amount = (v ? list.clientHeight : list.clientWidth) * 0.8 * dir;
			list.scrollBy(v ? { top: amount, behavior: 'smooth' } : { left: amount, behavior: 'smooth' });
		}

		// Keep the active thumbnail in view when the main image changes.
		function revealActive() {
			var img = list.querySelector('img.flex-active');
			var li = img ? img.closest('li') : null;
			if (!li) { return; }
			var v = isVertical();
			var start = v ? li.offsetTop : li.offsetLeft;
			var size = v ? li.offsetHeight : li.offsetWidth;
			var view = v ? list.clientHeight : list.clientWidth;
			var pos = v ? list.scrollTop : list.scrollLeft;
			var target = null;
			if (start < pos) { target = start; } else if (start + size > pos + view) { target = start + size - view; }
			if (target !== null) {
				list.scrollTo(v ? { top: target, behavior: 'smooth' } : { left: target, behavior: 'smooth' });
			}
		}

		prev.addEventListener('click', function () { page(-1); });
		next.addEventListener('click', function () { page(1); });
		list.addEventListener('scroll', update, { passive: true });
		window.addEventListener('resize', update);
		if (sideBySide && sideBySide.addEventListener) { sideBySide.addEventListener('change', update); }
		if (window.MutationObserver) {
			new MutationObserver(revealActive).observe(list, { subtree: true, attributes: true, attributeFilter: ['class'] });
		}
		Array.prototype.forEach.call(list.querySelectorAll('img'), function (img) {
			if (!img.complete) { img.addEventListener('load', update); }
		});
		update();
	}

	function watchGalleries() {
		var galleries = document.querySelectorAll('.woocommerce-product-gallery');
		Array.prototype.forEach.call(galleries, function (gallery) {
			initThumbs(gallery);
			// FlexSlider builds the thumbnail list after load; wait for it.
			if (window.MutationObserver && !gallery.querySelector('.cb-thumbs')) {
				var obs = new MutationObserver(function () {
					if (gallery.querySelector('.flex-control-thumbs')) {
						obs.disconnect();
						initThumbs(gallery);
					}
				});
				obs.observe(gallery, { childList: true });
			}
		});
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', watchGalleries);
	} else {
		watchGalleries();
	}
})();
