var zinn_cache_pro_vary = document.cookie.replace(/(?:(?:^|.*;\s*)_lscache_vary\s*\=\s*([^;]*).*$)|^.*$/, '$1');
if (!zinn_cache_pro_vary) {
	// Guard against infinite reload loop when response is served from an external cache (e.g. Archive.org)
	if (sessionStorage.getItem('zinn_cache_pro_reloaded')) {
		console.log('LiteSpeed: skipping guest vary reload (already reloaded this session)');
	} else {
		// Note: as the vary may be changed in Login Cookie option, even the visitor doesn't have this cookie, it doesn't mean the visitor doesn't have the vary, so still need PHP side to decide if need to set vary or not.
		fetch('zinn_cache_pro_url', {
			method: 'POST',
			cache: 'no-cache',
			redirect: 'follow',
		})
			.then(response => response.json())
			.then(data => {
				console.log(data);
				if (data.hasOwnProperty('reload') && data.reload == 'yes') {
					// Save doc.ref for organic traffic usage
					sessionStorage.setItem('zinn_cache_pro_docref', document.referrer);
					sessionStorage.setItem('zinn_cache_pro_reloaded', '1');

					window.location.reload(true);
				}
			});
	}
}
