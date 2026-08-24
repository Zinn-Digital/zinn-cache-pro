window.zinn_cache_pro_ui_events = window.zinn_cache_pro_ui_events || ['mouseover', 'click', 'keydown', 'wheel', 'touchmove', 'touchstart'];
var urlCreator = window.URL || window.webkitURL;

// const zinn_cache_pro_js_delay_timer = setTimeout( zinn_cache_pro_load_delayed_js, 70 );

zinn_cache_pro_ui_events.forEach(e => {
	window.addEventListener(e, zinn_cache_pro_load_delayed_js_force, { passive: true }); // Use passive to save GPU in interaction
});

function zinn_cache_pro_safe_src(url) {
	if (!url) return '';
	// Parse with the URL parser rather than a regex, and allow only navigable schemes.
	// A data- attribute is protocol-checked by NOBODY - kses only inspects attributes it
	// knows carry a protocol - so a scheme arriving there has been validated nowhere.
	// The parser is what makes this correct rather than approximate: it strips leading
	// whitespace and the tab/CR/LF that browsers ignore *inside* a URL, so the classic
	// `java&#9;script:` obfuscation resolves to javascript: here exactly as it would in
	// the address bar. A hand-rolled trim() does not.
	// The ORIGINAL string is returned, never the parser's normalised href, so an allowed
	// URL is assigned byte-for-byte as before and this is a pure gate.
	try {
		var scheme = new URL(url, document.baseURI).protocol;
		return scheme == 'http:' || scheme == 'https:' ? url : '';
	} catch (e) {
		return ''; // unparseable is not navigable
	}
}

function zinn_cache_pro_load_delayed_js_force() {
	console.log('[LiteSpeed] Start Load JS Delayed');
	// clearTimeout( zinn_cache_pro_js_delay_timer );
	zinn_cache_pro_ui_events.forEach(e => {
		window.removeEventListener(e, zinn_cache_pro_load_delayed_js_force, { passive: true });
	});

	document.querySelectorAll('iframe[data-zinn-cache-pro-src]').forEach(e => {
		var src = zinn_cache_pro_safe_src(e.getAttribute('data-zinn-cache-pro-src'));
		if (src) e.setAttribute('src', src);
		else console.warn('[LiteSpeed] Blocked unsafe delayed iframe src', e);
	});

	// Prevent early loading
	if (document.readyState == 'loading') {
		window.addEventListener('DOMContentLoaded', zinn_cache_pro_load_delayed_js);
	} else {
		zinn_cache_pro_load_delayed_js();
	}
}

async function zinn_cache_pro_load_delayed_js() {
	let js_list = [];
	// Prepare all JS
	document.querySelectorAll('script[type="zinn-cache-pro/javascript"]').forEach(e => {
		js_list.push(e);
	});

	// Load by sequence
	for (let script in js_list) {
		await new Promise(resolve => zinn_cache_pro_load_one(js_list[script], resolve));
	}

	// Simulate doc.loaded
	document.dispatchEvent(new Event('DOMContentLiteSpeedLoaded'));
	window.dispatchEvent(new Event('DOMContentLiteSpeedLoaded'));
}

/**
 * Load one JS synchronously
 */
function zinn_cache_pro_load_one(e, resolve) {
	console.log('[LiteSpeed] Load ', e);

	var e2 = document.createElement('script');

	e2.addEventListener('load', resolve);
	e2.addEventListener('error', resolve);

	var attrs = e.getAttributeNames();
	attrs.forEach(aname => {
		if (aname == 'type') return;
		if (aname == 'data-src') {
			var s = zinn_cache_pro_safe_src(e.getAttribute(aname));
			if (s) e2.setAttribute('src', s);
			else console.warn('[LiteSpeed] Blocked unsafe delayed script src', e);
		} else {
			e2.setAttribute(aname, e.getAttribute(aname));
		}
	});
	e2.type = 'text/javascript';

	let is_inline = false;
	// Inline script
	if (!e2.src && e.textContent) {
		e2.src = zinn_cache_pro_inline2src(e.textContent);
		// e2.textContent = e.textContent;
		is_inline = true;
	}

	// Deploy to dom
	e.after(e2);
	e.remove();
	// document.head.appendChild(e2);
	// e2 = e.cloneNode(true)
	// e2.setAttribute( 'type', 'text/javascript' );
	// e2.setAttribute( 'data-delayed', '1' );

	// Kick off resolve for inline
	if (is_inline) resolve();
}

/**
 * Prepare inline script
 */
function zinn_cache_pro_inline2src(data) {
	try {
		var src = urlCreator.createObjectURL(
			new Blob([data.replace(/^(?:<!--)?(.*?)(?:-->)?$/gm, '$1')], {
				type: 'text/javascript',
			}),
		);
	} catch (e) {
		var src = 'data:text/javascript;base64,' + btoa(data.replace(/^(?:<!--)?(.*?)(?:-->)?$/gm, '$1'));
	}

	return src;
}
