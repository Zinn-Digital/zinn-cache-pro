var zinn_cache_pro_docref = sessionStorage.getItem('zinn_cache_pro_docref');
if (zinn_cache_pro_docref) {
	Object.defineProperty(document, 'referrer', {
		get: function () {
			return zinn_cache_pro_docref;
		},
	});
	sessionStorage.removeItem('zinn_cache_pro_docref');
}
