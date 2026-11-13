(function () {
	'use strict';

	var root = document.documentElement;
	var body = document.body;

	function storeTheme(value) {
		try { localStorage.setItem('gs-admin-theme', value); } catch (e) {}
	}

	var themeBtns = Array.prototype.slice.call(document.querySelectorAll('.gs-theme-toggle'));
	themeBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			var dark = !root.classList.contains('dark');
			root.classList.toggle('dark', dark);
			storeTheme(dark ? 'dark' : 'light');
			themeBtns.forEach(function (b) { b.setAttribute('aria-pressed', dark ? 'true' : 'false'); });
		});
		btn.setAttribute('aria-pressed', root.classList.contains('dark') ? 'true' : 'false');
	});

	var layoutBtns = Array.prototype.slice.call(document.querySelectorAll('.gs-layout-toggle'));
	layoutBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			var top = !root.classList.contains('gs-layout-top');
			root.classList.toggle('gs-layout-top', top);
			try { localStorage.setItem('gs-admin-layout', top ? 'top' : 'rail'); } catch (e) {}
			layoutBtns.forEach(function (b) { b.setAttribute('aria-pressed', top ? 'true' : 'false'); });
		});
		btn.setAttribute('aria-pressed', root.classList.contains('gs-layout-top') ? 'true' : 'false');
	});

	function closeNav() {
		body.classList.remove('gs-nav-open');
		var t = document.getElementById('gs-nav-toggle');
		if (t) { t.setAttribute('aria-expanded', 'false'); }
	}

	function openNav() {
		body.classList.add('gs-nav-open');
		var t = document.getElementById('gs-nav-toggle');
		if (t) { t.setAttribute('aria-expanded', 'true'); }
	}

	var navBtn = document.getElementById('gs-nav-toggle');
	if (navBtn) {
		navBtn.addEventListener('click', function () {
			if (body.classList.contains('gs-nav-open')) { closeNav(); } else { openNav(); }
		});
	}

	var closeBtn = document.getElementById('gs-nav-close');
	if (closeBtn) { closeBtn.addEventListener('click', closeNav); }

	var overlay = document.getElementById('gs-nav-overlay');
	if (overlay) { overlay.addEventListener('click', closeNav); }

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') { closeNav(); }
	});

	// Close the rail after tapping a link on mobile.
	var nav = document.getElementById('gs-mainnav');
	if (nav) {
		nav.addEventListener('click', function (event) {
			if (event.target && event.target.closest && event.target.closest('a') && window.innerWidth < 1024) {
				closeNav();
			}
		});

		// Fallback active state for plugin pages and query-string links.
		var current = window.location.pathname.split('/').pop() + window.location.search;
		Array.prototype.forEach.call(nav.querySelectorAll('a'), function (a) {
			var href = a.getAttribute('href');
			if (!href) { return; }
			var url = href.split('#')[0];
			if (url === current || url === current.split('?')[0]) {
				a.classList.add('is-active');
			}
		});
	}

	// Keep theme changes in sync across tabs.
	window.addEventListener('storage', function (event) {
		if (event.key === 'gs-admin-theme') {
			root.classList.toggle('dark', event.newValue === 'dark');
		}
	});
})();
