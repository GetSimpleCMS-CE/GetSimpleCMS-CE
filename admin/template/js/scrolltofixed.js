(function() {
	function isScrollToFixed(el) {
		return !!el._ScrollToFixed;
	}

	function ScrollToFixed(el, options) {
		var base = this;

		base.el = el;
		el._ScrollToFixed = base;

		var isReset = false;
		var target = el;
		var position;
		var originalPosition;
		var originalOffset;
		var offsetTop = 0;
		var offsetLeft = 0;
		var originalOffsetLeft = -1;
		var lastOffsetLeft = -1;
		var spacer = null;

		function resetScroll() {
			triggerEvent(target, 'preUnfixed.ScrollToFixed');
			setUnfixed();
			triggerEvent(target, 'unfixed.ScrollToFixed');

			lastOffsetLeft = -1;

			var targetRect = target.getBoundingClientRect();
			offsetTop = targetRect.top + window.pageYOffset;
			offsetLeft = targetRect.left + window.pageXOffset;

			if (base.options.offsets) {
				var computedStyle = getComputedStyle(target);
				offsetLeft += parseFloat(computedStyle.marginLeft);
			}

			if (originalOffsetLeft === -1) {
				originalOffsetLeft = offsetLeft;
			}

			position = getComputedStyle(target).position;

			isReset = true;

			if (base.options.bottom !== -1) {
				triggerEvent(target, 'preFixed.ScrollToFixed');
				setFixed();
				triggerEvent(target, 'fixed.ScrollToFixed');
			}
		}

		function getLimit() {
			var limit = base.options.limit;
			if (!limit) return 0;
			if (typeof limit === 'function') {
				return limit.apply(target);
			}
			return limit;
		}

		function isFixed() {
			return position === 'fixed';
		}

		function isAbsolute() {
			return position === 'absolute';
		}

		function isUnfixed() {
			return !(isFixed() || isAbsolute());
		}

		function setFixed() {
			if (!isFixed()) {
				spacer.style.cssText = `
					display: ${getComputedStyle(target).display};
					width: ${target.offsetWidth}px;
					height: ${target.offsetHeight}px;
					float: ${getComputedStyle(target).float};
				`;
				spacer.style.display = '';

				var cssOptions = {
					position: 'fixed',
					top: base.options.bottom === -1 ? getMarginTop() + 'px' : '',
					bottom: base.options.bottom === -1 ? '' : base.options.bottom + 'px',
					marginLeft: '0px'
				};
				if (!base.options.dontSetWidth) {
					cssOptions.width = target.offsetWidth + 'px';
				}

				Object.assign(target.style, cssOptions);

				target.classList.add('scroll-to-fixed-fixed');
				target.classList.remove('scroll-to-fixed-abs');

				if (base.options.className) {
					target.classList.add(base.options.className);
				}

				position = 'fixed';
			}
		}

		function setAbsolute() {
			var top = getLimit();
			var left = offsetLeft;

			if (base.options.removeOffsets) {
				left = 0;
				top = top - offsetTop;
			}

			var cssOptions = {
				position: 'absolute',
				top: top + 'px',
				left: left + 'px',
				marginLeft: '0px',
				bottom: ''
			};
			if (!base.options.dontSetWidth) {
				cssOptions.width = target.offsetWidth + 'px';
			}

			Object.assign(target.style, cssOptions);

			position = 'absolute';

			target.classList.remove('scroll-to-fixed-fixed');
			target.classList.add('scroll-to-fixed-abs');
		}

		function setUnfixed() {
			if (!isUnfixed()) {
				lastOffsetLeft = -1;
				spacer.style.display = 'none';
				target.style.cssText = '';
				target.classList.remove('scroll-to-fixed-fixed');
				target.classList.remove('scroll-to-fixed-abs');
				if (base.options.className) {
					target.classList.remove(base.options.className);
				}
				position = null;
			}
		}

		function setLeft(x) {
			if (x !== lastOffsetLeft) {
				target.style.left = offsetLeft - x + 'px';
				lastOffsetLeft = x;
			}
		}

		function getMarginTop() {
			var marginTop = base.options.marginTop;
			if (!marginTop) return 0;
			if (typeof marginTop === 'function') {
				return marginTop.apply(target);
			}
			return marginTop;
		}

		function checkScroll() {
			if (!isScrollToFixed(target)) return;
			var wasReset = isReset;

			if (!isReset) {
				resetScroll();
			}

			var x = window.pageXOffset;
			var y = window.pageYOffset;
			var limit = getLimit();

			if (base.options.minWidth && window.innerWidth < base.options.minWidth) {
				if (!isUnfixed() || !wasReset) {
					postPosition();
					triggerEvent(target, 'preUnfixed.ScrollToFixed');
					setUnfixed();
					triggerEvent(target, 'unfixed.ScrollToFixed');
				}
			} else if (base.options.bottom === -1) {
				if (limit > 0 && y >= limit - getMarginTop()) {
					if (!isAbsolute() || !wasReset) {
						postPosition();
						triggerEvent(target, 'preAbsolute.ScrollToFixed');
						setAbsolute();
						triggerEvent(target, 'unfixed.ScrollToFixed');
					}
				} else if (y >= offsetTop - getMarginTop()) {
					if (!isFixed() || !wasReset) {
						postPosition();
						triggerEvent(target, 'preFixed.ScrollToFixed');
						setFixed();
						lastOffsetLeft = -1;
						triggerEvent(target, 'fixed.ScrollToFixed');
					}
					setLeft(x);
				} else {
					if (!isUnfixed() || !wasReset) {
						postPosition();
						triggerEvent(target, 'preUnfixed.ScrollToFixed');
						setUnfixed();
						triggerEvent(target, 'unfixed.ScrollToFixed');
					}
				}
			} else {
				if (limit > 0) {
					if (y + window.innerHeight - target.offsetHeight >= limit - (getMarginTop() || -getBottom())) {
						if (isFixed()) {
							postPosition();
							triggerEvent(target, 'preUnfixed.ScrollToFixed');
							if (originalPosition === 'absolute') {
								setAbsolute();
							} else {
								setUnfixed();
							}
							triggerEvent(target, 'unfixed.ScrollToFixed');
						}
					} else {
						if (!isFixed()) {
							postPosition();
							triggerEvent(target, 'preFixed.ScrollToFixed');
							setFixed();
						}
						setLeft(x);
						triggerEvent(target, 'fixed.ScrollToFixed');
					}
				} else {
					setLeft(x);
				}
			}
		}

		function getBottom() {
			if (!base.options.bottom) return 0;
			return base.options.bottom;
		}

		function postPosition() {
			var position = getComputedStyle(target).position;
			if (position === 'absolute') {
				triggerEvent(target, 'postAbsolute.ScrollToFixed');
			} else if (position === 'fixed') {
				triggerEvent(target, 'postFixed.ScrollToFixed');
			} else {
				triggerEvent(target, 'postUnfixed.ScrollToFixed');
			}
		}

		function windowResize(event) {
			if (target.offsetParent !== null) {
				isReset = false;
				checkScroll();
			}
		}

		function windowScroll(event) {
			checkScroll();
		}

		function triggerEvent(el, eventName) {
			var event;
			if (typeof(Event) === 'function') {
				event = new Event(eventName, { bubbles: true, cancelable: true });
			} else {
				event = document.createEvent('Event');
				event.initEvent(eventName, true, true);
			}
			el.dispatchEvent(event);
		}

		base.init = function() {
			base.options = Object.assign({}, ScrollToFixed.defaultOptions, options);
			el.style.zIndex = base.options.zIndex;

			spacer = document.createElement('div');
			position = getComputedStyle(target).position;
			originalPosition = getComputedStyle(target).position;
			originalOffset = target.getBoundingClientRect();

			if (isUnfixed()) el.parentNode.insertBefore(spacer, el.nextSibling);

			window.addEventListener('resize', windowResize);
			window.addEventListener('scroll', windowScroll);

			if (base.options.preFixed) {
				el.addEventListener('preFixed.ScrollToFixed', base.options.preFixed);
			}
			if (base.options.postFixed) {
				el.addEventListener('postFixed.ScrollToFixed', base.options.postFixed);
			}
			if (base.options.preUnfixed) {
				el.addEventListener('preUnfixed.ScrollToFixed', base.options.preUnfixed);
			}
			if (base.options.postUnfixed) {
				el.addEventListener('postUnfixed.ScrollToFixed', base.options.postUnfixed);
			}
			if (base.options.preAbsolute) {
				el.addEventListener('preAbsolute.ScrollToFixed', base.options.preAbsolute);
			}
			if (base.options.postAbsolute) {
				el.addEventListener('postAbsolute.ScrollToFixed', base.options.postAbsolute);
			}
			if (base.options.fixed) {
				el.addEventListener('fixed.ScrollToFixed', base.options.fixed);
			}
			if (base.options.unfixed) {
				el.addEventListener('unfixed.ScrollToFixed', base.options.unfixed);
			}

			if (base.options.spacerClass) {
				spacer.classList.add(base.options.spacerClass);
			}

			target._ScrollToFixed = base;

			if (base.options.bottom !== -1) {
				resetScroll();
			}
		};

		base.init();
	}

	ScrollToFixed.defaultOptions = {
		marginTop: 0,
		limit: 0,
		bottom: -1,
		zIndex: 1000,
		minWidth: 0,
		offsets: false,
		dontSetWidth: false,
		spacerClass: 'scroll-to-fixed-spacer'
	};

	window.ScrollToFixed = function(selector, options) {
		document.querySelectorAll(selector).forEach(function(el) {
			new ScrollToFixed(el, options);
		});
	};
})();