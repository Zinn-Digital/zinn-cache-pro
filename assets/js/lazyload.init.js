/**
 * Lazyload init js
 *
 * @author LiteSpeed
 * @since 1.4
 *
 */

(function (window, document) {
	'use strict';

	var instance;
	var update_lazyload;

	var zinn_cache_pro_finish_callback = function () {
		document.body.classList.add('zinn_cache_pro_lazyloaded');
	};

	var init = function () {
		console.log('[LiteSpeed] Start Lazy Load');
		instance = new LazyLoad(
			Object.assign(
				{},
				window.lazyLoadOptions || {},
				{
					elements_selector: '[data-lazyloaded]',
					callback_finish: zinn_cache_pro_finish_callback,
				},
			)
		);

		update_lazyload = function () {
			instance.update();
		};

		if (window.MutationObserver) {
			new MutationObserver(update_lazyload).observe(document.documentElement, { childList: true, subtree: true, attributes: true });
		}
	};

	window.addEventListener ? window.addEventListener('load', init, false) : window.attachEvent('onload', init);
})(window, document);
