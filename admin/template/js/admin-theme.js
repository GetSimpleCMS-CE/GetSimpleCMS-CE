(function () {
	'use strict';

	var root = document.documentElement;

	function storeTheme(value) {
		try { localStorage.setItem('gs-admin-theme', value); } catch (e) {}
	}

	var themeBtn = document.getElementById('gs-theme-toggle');
	if (themeBtn) {
		themeBtn.addEventListener('click', function () {
			var dark = !root.classList.contains('dark');
			root.classList.toggle('dark', dark);
			storeTheme(dark ? 'dark' : 'light');
			themeBtn.setAttribute('aria-pressed', dark ? 'true' : 'false');
		});
		themeBtn.setAttribute('aria-pressed', root.classList.contains('dark') ? 'true' : 'false');
	}

	var navBtn = document.getElementById('gs-nav-toggle');
	var nav = document.getElementById('gs-mainnav');
	if (navBtn && nav) {
		navBtn.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			navBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		nav.addEventListener('click', function (event) {
			if (event.target && event.target.tagName === 'A' && window.innerWidth < 1024) {
				nav.classList.remove('is-open');
				navBtn.setAttribute('aria-expanded', 'false');
			}
		});
	}

	// Sync across tabs when the preference changes elsewhere.
	window.addEventListener('storage', function (event) {
		if (event.key === 'gs-admin-theme') {
			root.classList.toggle('dark', event.newValue === 'dark');
		}
	});
})();
