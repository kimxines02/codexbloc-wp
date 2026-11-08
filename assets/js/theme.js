/**
 * Codexbloc theme script (vanilla JS, no dependencies).
 * - Mobile menu toggle
 * - Header search dropdown closes on outside click / Escape
 * - Turns WooCommerce variation dropdowns (e.g. Monthly / Yearly) into pill buttons
 * - Product gallery thumbnails as a slider (vertical beside the image on sm+)
 * - Product image lightbox with a thumbnail column on the right
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

	/* Product image lightbox ------------------------------------------------ */
	var icons = {
		close: 'M6 18 18 6M6 6l12 12',
		left: 'M15.75 19.5 8.25 12l7.5-7.5',
		right: 'm8.25 4.5 7.5 7.5-7.5 7.5',
		expand: 'M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15'
	};
	function svg(name, cls) {
		return '<svg class="' + (cls || 'h-5 w-5') + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="' + icons[name] + '"/></svg>';
	}

	function initLightbox(gallery) {
		if (gallery.getAttribute('data-cb-lightbox') || typeof HTMLDialogElement === 'undefined') { return; }
		var slides = gallery.querySelectorAll('.woocommerce-product-gallery__image:not(.clone)');
		if (!slides.length) { return; }
		gallery.setAttribute('data-cb-lightbox', '1');

		var items = Array.prototype.map.call(slides, function (slide) {
			var a = slide.querySelector('a');
			var img = slide.querySelector('img');
			return {
				el: slide,
				full: (img && img.getAttribute('data-large_image')) || (a && a.href) || (img && img.src) || '',
				thumb: slide.getAttribute('data-thumb') || (img && img.src) || '',
				alt: (img && img.alt) || ''
			};
		});
		var index = 0;
		var opener = null;

		var dialog = document.createElement('dialog');
		dialog.className = 'cb-lightbox';
		dialog.setAttribute('aria-label', 'Product images');
		dialog.innerHTML =
			'<div class="cb-lb-inner">' +
				'<div class="cb-lb-stage">' +
					'<img class="cb-lb-img" src="" alt="">' +
					'<button type="button" class="cb-lb-nav cb-lb-prev" aria-label="Previous image">' + svg('left', 'h-6 w-6') + '</button>' +
					'<button type="button" class="cb-lb-nav cb-lb-next" aria-label="Next image">' + svg('right', 'h-6 w-6') + '</button>' +
					'<p class="cb-lb-count" aria-live="polite"></p>' +
				'</div>' +
				'<div class="cb-lb-side"><ol class="cb-lb-thumbs"></ol></div>' +
				'<button type="button" class="cb-lb-close" aria-label="Close">' + svg('close', 'h-6 w-6') + '</button>' +
			'</div>';
		document.body.appendChild(dialog);

		var stage = dialog.querySelector('.cb-lb-stage');
		var big = dialog.querySelector('.cb-lb-img');
		var prevBtn = dialog.querySelector('.cb-lb-prev');
		var nextBtn = dialog.querySelector('.cb-lb-next');
		var count = dialog.querySelector('.cb-lb-count');
		var thumbs = dialog.querySelector('.cb-lb-thumbs');

		items.forEach(function (item, i) {
			var li = document.createElement('li');
			var b = document.createElement('button');
			b.type = 'button';
			b.setAttribute('aria-label', 'Image ' + (i + 1) + ' of ' + items.length);
			var t = document.createElement('img');
			t.src = item.thumb;
			t.alt = '';
			t.loading = 'lazy';
			b.appendChild(t);
			b.addEventListener('click', function () { show(i); });
			li.appendChild(b);
			thumbs.appendChild(li);
		});
		var thumbBtns = thumbs.querySelectorAll('button');

		if (items.length < 2) {
			dialog.querySelector('.cb-lb-side').style.display = 'none';
			prevBtn.style.display = nextBtn.style.display = count.style.display = 'none';
		}

		function preload(i) {
			if (items[i]) { (new Image()).src = items[i].full; }
		}

		function show(i) {
			index = Math.max(0, Math.min(items.length - 1, i));
			big.src = items[index].full;
			big.alt = items[index].alt;
			count.textContent = (index + 1) + ' / ' + items.length;
			prevBtn.disabled = index === 0;
			nextBtn.disabled = index === items.length - 1;
			Array.prototype.forEach.call(thumbBtns, function (b, n) {
				b.setAttribute('aria-current', n === index ? 'true' : 'false');
			});
			var active = thumbBtns[index];
			if (active && active.scrollIntoView) { active.scrollIntoView({ block: 'nearest', inline: 'nearest' }); }
			preload(index + 1);
			preload(index - 1);
		}

		function open(i) {
			opener = document.activeElement;
			document.documentElement.style.overflow = 'hidden';
			dialog.showModal();
			show(i);
			dialog.querySelector('.cb-lb-close').focus();
		}

		dialog.addEventListener('close', function () {
			document.documentElement.style.overflow = '';
			// Leave the page slider on the image the visitor ended on.
			var fs = window.jQuery ? window.jQuery(gallery).data('flexslider') : null;
			if (fs && fs.currentSlide !== index && fs.flexAnimate) { fs.flexAnimate(index, true); }
			if (opener && opener.focus) { opener.focus(); }
		});

		prevBtn.addEventListener('click', function () { show(index - 1); });
		nextBtn.addEventListener('click', function () { show(index + 1); });
		dialog.querySelector('.cb-lb-close').addEventListener('click', function () { dialog.close(); });
		// Click on the dark area around the image closes it.
		dialog.addEventListener('click', function (e) {
			if (e.target === stage || e.target === dialog) { dialog.close(); }
		});
		dialog.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') { e.preventDefault(); show(index - 1); }
			if (e.key === 'ArrowRight' || e.key === 'ArrowDown') { e.preventDefault(); show(index + 1); }
		});

		// Swipe on touch screens.
		var startX = null;
		stage.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
		stage.addEventListener('touchend', function (e) {
			if (startX === null) { return; }
			var dx = e.changedTouches[0].clientX - startX;
			if (Math.abs(dx) > 50) { show(index + (dx < 0 ? 1 : -1)); }
			startX = null;
		});

		// Open from the main image, or from the expand button.
		gallery.addEventListener('click', function (e) {
			var link = e.target.closest ? e.target.closest('.woocommerce-product-gallery__image a') : null;
			if (!link) { return; }
			e.preventDefault();
			var slide = link.closest('.woocommerce-product-gallery__image');
			var i = 0;
			items.forEach(function (item, n) { if (item.el === slide) { i = n; } });
			open(i);
		});

		var zoom = document.createElement('button');
		zoom.type = 'button';
		zoom.className = 'cb-zoom-btn';
		zoom.setAttribute('aria-label', 'View full-size images');
		zoom.innerHTML = svg('expand', 'h-5 w-5');
		zoom.addEventListener('click', function () {
			var fs = window.jQuery ? window.jQuery(gallery).data('flexslider') : null;
			open(fs ? fs.currentSlide : 0);
		});
		gallery.appendChild(zoom);
	}

	function initLightboxes() {
		Array.prototype.forEach.call(document.querySelectorAll('.woocommerce-product-gallery'), initLightbox);
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initLightboxes);
	} else {
		initLightboxes();
	}
})();
