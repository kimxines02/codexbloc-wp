/**
 * Codexbloc theme script (vanilla JS, no dependencies).
 * - Mobile menu toggle
 * - Header search dropdown closes on outside click / Escape
 * - Turns WooCommerce variation dropdowns (e.g. Monthly / Yearly) into pill buttons
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
})();
