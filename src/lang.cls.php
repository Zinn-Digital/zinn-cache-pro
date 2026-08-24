<?php
/**
 * The language class.
 *
 * @package ZinnCachePro
 * @since 3.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit();

/**
 * Class Lang
 *
 * Provides translations and human-readable labels/status for UI.
 */
class Lang extends Base {

	/**
	 * Get image status per status bit.
	 *
	 * @since 3.0
	 *
	 * @param int|null $status Image status constant or null to return the full map.
	 * @return array<string,string>|string Array map when $status is null, otherwise a single status label or 'N/A'.
	 */
	public static function img_status( $status = null ) {
		$list = [
			Img_Optm::STATUS_NEW       => __( 'Images not requested', 'zinn-cache-pro' ),
			Img_Optm::STATUS_RAW       => __( 'Images ready to request', 'zinn-cache-pro' ),
			Img_Optm::STATUS_REQUESTED => __( 'Images requested', 'zinn-cache-pro' ),
			Img_Optm::STATUS_NOTIFIED  => __( 'Images notified to pull', 'zinn-cache-pro' ),
			Img_Optm::STATUS_PULLED    => __( 'Images optimized and pulled', 'zinn-cache-pro' ),
		];

		if ( null !== $status ) {
			return ! empty( $list[ $status ] ) ? $list[ $status ] : 'N/A';
		}

		return $list;
	}

	/**
	 * Try translating a string.
	 *
	 * Optionally supports sprintf-style substitutions when $raw_string
	 * contains a '::' separator (e.g. 'key::arg1::arg2').
	 *
	 * @since 4.7
	 *
	 * @param string $raw_string Raw translation key or key with ::-separated args.
	 * @return string Translated string or original raw string if not found.
	 */
	public static function maybe_translate( $raw_string ) {
		$map = [
			'auto_alias_failed_cdn' =>
				__(
					'Unable to automatically add %1$s as a Domain Alias for main %2$s domain, due to potential CDN conflict.',
					'zinn-cache-pro'
				) .
				' ' .
				Doc::learn_more( 'https://quic.cloud/docs/cdn/dns/how-to-setup-domain-alias/', false, false, false, true ),

			'auto_alias_failed_uid' =>
				__(
					'Unable to automatically add %1$s as a Domain Alias for main %2$s domain.',
					'zinn-cache-pro'
				) .
				' ' .
				__( 'Alias is in use by another QUIC.cloud account.', 'zinn-cache-pro' ) .
				' ' .
				Doc::learn_more( 'https://quic.cloud/docs/cdn/dns/how-to-setup-domain-alias/', false, false, false, true ),
		];

		// Maybe has placeholder.
		if ( strpos( $raw_string, '::' ) ) {
			$replacements = explode( '::', $raw_string );
			if ( empty( $map[ $replacements[0] ] ) ) {
				return $raw_string;
			}
			$tpl = $map[ $replacements[0] ];
			unset( $replacements[0] );
			return vsprintf( $tpl, array_values( $replacements ) );
		}

		// Direct translation only.
		if ( empty( $map[ $raw_string ] ) ) {
			return $raw_string;
		}

		return $map[ $raw_string ];
	}

	/**
	 * Get the title/label for an option ID.
	 *
	 * @since 3.0
	 * @access public
	 *
	 * @param string|int $id Option identifier constant.
	 * @return string Human-readable title or 'N/A' if not found.
	 */
	public static function title( $id ) {
		$_lang_list = [
			self::O_SERVER_IP => __( 'Server IP', 'zinn-cache-pro' ),

			self::O_CACHE                 => __( 'Enable Cache', 'zinn-cache-pro' ),
			self::O_CACHE_BROWSER         => __( 'Browser Cache', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_PUB         => __( 'Default Public Cache TTL', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_PRIV        => __( 'Default Private Cache TTL', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_FRONTPAGE   => __( 'Default Front Page TTL', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_FEED        => __( 'Default Feed TTL', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_REST        => __( 'Default REST TTL', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_STATUS      => __( 'Default HTTP Status Code Page TTL', 'zinn-cache-pro' ),
			self::O_CACHE_TTL_BROWSER     => __( 'Browser Cache TTL', 'zinn-cache-pro' ),
			self::O_CACHE_AJAX_TTL        => __( 'AJAX Cache TTL', 'zinn-cache-pro' ),
			self::O_AUTO_UPGRADE          => __( 'Automatically Upgrade', 'zinn-cache-pro' ),
			self::O_GUEST                 => __( 'Guest Mode', 'zinn-cache-pro' ),
			self::O_GUEST_OPTM            => __( 'Guest Optimization', 'zinn-cache-pro' ),
			self::O_NEWS                  => __( 'Notifications', 'zinn-cache-pro' ),
			self::O_CACHE_PRIV            => __( 'Cache Logged-in Users', 'zinn-cache-pro' ),
			self::O_CACHE_COMMENTER       => __( 'Cache Commenters', 'zinn-cache-pro' ),
			self::O_CACHE_REST            => __( 'Cache REST API', 'zinn-cache-pro' ),
			self::O_CACHE_PAGE_LOGIN      => __( 'Cache Login Page', 'zinn-cache-pro' ),
			self::O_CACHE_MOBILE          => __( 'Cache Mobile', 'zinn-cache-pro' ),
			self::O_CACHE_MOBILE_RULES    => __( 'List of Mobile User Agents', 'zinn-cache-pro' ),
			self::O_CACHE_PRIV_URI        => __( 'Private Cached URIs', 'zinn-cache-pro' ),
			self::O_CACHE_DROP_QS         => __( 'Drop Query String', 'zinn-cache-pro' ),

			self::O_OBJECT                      => __( 'Object Cache', 'zinn-cache-pro' ),
			self::O_OBJECT_KIND                 => __( 'Method', 'zinn-cache-pro' ),
			self::O_OBJECT_HOST                 => __( 'Host', 'zinn-cache-pro' ),
			self::O_OBJECT_PORT                 => __( 'Port', 'zinn-cache-pro' ),
			self::O_OBJECT_LIFE                 => __( 'Default Object Lifetime', 'zinn-cache-pro' ),
			self::O_OBJECT_USER                 => __( 'Username', 'zinn-cache-pro' ),
			self::O_OBJECT_PSWD                 => __( 'Password', 'zinn-cache-pro' ),
			self::O_OBJECT_DB_ID                => __( 'Redis Database ID', 'zinn-cache-pro' ),
			self::O_OBJECT_GLOBAL_GROUPS        => __( 'Global Groups', 'zinn-cache-pro' ),
			self::O_OBJECT_NON_PERSISTENT_GROUPS => __( 'Do Not Cache Groups', 'zinn-cache-pro' ),
			self::O_OBJECT_PERSISTENT           => __( 'Persistent Connection', 'zinn-cache-pro' ),
			self::O_OBJECT_ADMIN                => __( 'Cache WP-Admin', 'zinn-cache-pro' ),

			self::O_PURGE_ON_UPGRADE    => __( 'Purge All On Upgrade', 'zinn-cache-pro' ),
			self::O_PURGE_STALE         => __( 'Serve Stale', 'zinn-cache-pro' ),
			self::O_PURGE_TIMED_URLS    => __( 'Scheduled Purge URLs', 'zinn-cache-pro' ),
			self::O_PURGE_TIMED_URLS_TIME => __( 'Scheduled Purge Time', 'zinn-cache-pro' ),
			self::O_CACHE_FORCE_URI     => __( 'Force Cache URIs', 'zinn-cache-pro' ),
			self::O_CACHE_FORCE_PUB_URI => __( 'Force Public Cache URIs', 'zinn-cache-pro' ),
			self::O_CACHE_EXC           => __( 'Do Not Cache URIs', 'zinn-cache-pro' ),
			self::O_CACHE_EXC_QS        => __( 'Do Not Cache Query Strings', 'zinn-cache-pro' ),
			self::O_CACHE_EXC_CAT       => __( 'Do Not Cache Categories', 'zinn-cache-pro' ),
			self::O_CACHE_EXC_TAG       => __( 'Do Not Cache Tags', 'zinn-cache-pro' ),
			self::O_CACHE_EXC_ROLES     => __( 'Do Not Cache Roles', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_MIN        => __( 'CSS Minify', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_COMB       => __( 'CSS Combine', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_COMB_EXT_INL => __( 'CSS Combine External and Inline', 'zinn-cache-pro' ),
			self::O_OPTM_UCSS           => __( 'Generate UCSS', 'zinn-cache-pro' ),
			self::O_OPTM_UCSS_INLINE    => __( 'UCSS Inline', 'zinn-cache-pro' ),
			self::O_OPTM_UCSS_SELECTOR_WHITELIST => __( 'UCSS Selector Allowlist', 'zinn-cache-pro' ),
			self::O_OPTM_UCSS_FILE_EXC_INLINE    => __( 'UCSS Inline Excluded Files', 'zinn-cache-pro' ),
			self::O_OPTM_UCSS_EXC       => __( 'UCSS URI Excludes', 'zinn-cache-pro' ),
			self::O_OPTM_JS_MIN         => __( 'JS Minify', 'zinn-cache-pro' ),
			self::O_OPTM_JS_COMB        => __( 'JS Combine', 'zinn-cache-pro' ),
			self::O_OPTM_JS_COMB_EXT_INL => __( 'JS Combine External and Inline', 'zinn-cache-pro' ),
			self::O_OPTM_HTML_MIN       => __( 'HTML Minify', 'zinn-cache-pro' ),
			self::O_OPTM_HTML_LAZY      => __( 'HTML Lazy Load Selectors', 'zinn-cache-pro' ),
			self::O_OPTM_HTML_SKIP_COMMENTS => __( 'HTML Keep Comments', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_ASYNC      => __( 'Load CSS Asynchronously', 'zinn-cache-pro' ),
			self::O_OPTM_CCSS_PER_URL   => __( 'CCSS Per URL', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_ASYNC_INLINE => __( 'Inline CSS Async Lib', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_FONT_DISPLAY => __( 'Font Display Optimization', 'zinn-cache-pro' ),
			self::O_OPTM_JS_DEFER       => __( 'Load JS Deferred', 'zinn-cache-pro' ),
			self::O_OPTM_LOCALIZE       => __( 'Localize Resources', 'zinn-cache-pro' ),
			self::O_OPTM_LOCALIZE_DOMAINS => __( 'Localization Files', 'zinn-cache-pro' ),
			self::O_OPTM_DNS_PREFETCH   => __( 'DNS Prefetch', 'zinn-cache-pro' ),
			self::O_OPTM_DNS_PREFETCH_CTRL => __( 'DNS Prefetch Control', 'zinn-cache-pro' ),
			self::O_OPTM_DNS_PRECONNECT => __( 'DNS Preconnect', 'zinn-cache-pro' ),
			self::O_OPTM_CSS_EXC        => __( 'CSS Excludes', 'zinn-cache-pro' ),
			self::O_OPTM_JS_DELAY_INC   => __( 'JS Delayed Includes', 'zinn-cache-pro' ),
			self::O_OPTM_JS_EXC         => __( 'JS Excludes', 'zinn-cache-pro' ),
			self::O_OPTM_QS_RM          => __( 'Remove Query Strings', 'zinn-cache-pro' ),
			self::O_OPTM_GGFONTS_ASYNC  => __( 'Load Google Fonts Asynchronously', 'zinn-cache-pro' ),
			self::O_OPTM_GGFONTS_RM     => __( 'Remove Google Fonts', 'zinn-cache-pro' ),
			self::O_OPTM_CCSS_CON       => __( 'Critical CSS Rules', 'zinn-cache-pro' ),
			self::O_OPTM_CCSS_SEP_POSTTYPE => __( 'Separate CCSS Cache Post Types', 'zinn-cache-pro' ),
			self::O_OPTM_CCSS_SEP_URI   => __( 'Separate CCSS Cache URIs', 'zinn-cache-pro' ),
			self::O_OPTM_CCSS_SELECTOR_WHITELIST => __( 'CCSS Selector Allowlist', 'zinn-cache-pro' ),
			self::O_OPTM_JS_DEFER_EXC   => __( 'JS Deferred / Delayed Excludes', 'zinn-cache-pro' ),
			self::O_OPTM_GM_JS_EXC      => __( 'Guest Mode JS Excludes', 'zinn-cache-pro' ),
			self::O_OPTM_EMOJI_RM       => __( 'Remove WordPress Emoji', 'zinn-cache-pro' ),
			self::O_OPTM_NOSCRIPT_RM    => __( 'Remove Noscript Tags', 'zinn-cache-pro' ),
			self::O_OPTM_EXC            => __( 'URI Excludes', 'zinn-cache-pro' ),
			self::O_OPTM_GUEST_ONLY     => __( 'Optimize for Guests Only', 'zinn-cache-pro' ),
			self::O_OPTM_EXC_ROLES      => __( 'Role Excludes', 'zinn-cache-pro' ),

			self::O_DISCUSS_AVATAR_CACHE      => __( 'Gravatar Cache', 'zinn-cache-pro' ),
			self::O_DISCUSS_AVATAR_CRON       => __( 'Gravatar Cache Cron', 'zinn-cache-pro' ),
			self::O_DISCUSS_AVATAR_CACHE_TTL  => __( 'Gravatar Cache TTL', 'zinn-cache-pro' ),

			self::O_MEDIA_LAZY                    => __( 'Lazy Load Images', 'zinn-cache-pro' ),
			self::O_MEDIA_LAZY_EXC                => __( 'Lazy Load Image Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_LAZY_CLS_EXC            => __( 'Lazy Load Image Class Name Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_LAZY_PARENT_CLS_EXC     => __( 'Lazy Load Image Parent Class Name Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_IFRAME_LAZY_CLS_EXC     => __( 'Lazy Load Iframe Class Name Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_IFRAME_LAZY_PARENT_CLS_EXC => __( 'Lazy Load Iframe Parent Class Name Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_LAZY_URI_EXC            => __( 'Lazy Load URI Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_LQIP_EXC                => __( 'LQIP Excludes', 'zinn-cache-pro' ),
			self::O_MEDIA_LAZY_PLACEHOLDER        => __( 'Basic Image Placeholder', 'zinn-cache-pro' ),
			self::O_MEDIA_PLACEHOLDER_RESP        => __( 'Responsive Placeholder', 'zinn-cache-pro' ),
			self::O_MEDIA_PLACEHOLDER_RESP_COLOR  => __( 'Responsive Placeholder Color', 'zinn-cache-pro' ),
			self::O_MEDIA_PLACEHOLDER_RESP_SVG    => __( 'Responsive Placeholder SVG', 'zinn-cache-pro' ),
			self::O_MEDIA_LQIP                    => __( 'LQIP Cloud Generator', 'zinn-cache-pro' ),
			self::O_MEDIA_LQIP_QUAL               => __( 'LQIP Quality', 'zinn-cache-pro' ),
			self::O_MEDIA_LQIP_MIN_W              => __( 'LQIP Minimum Dimensions', 'zinn-cache-pro' ),
			self::O_MEDIA_PLACEHOLDER_RESP_ASYNC  => __( 'Generate LQIP In Background', 'zinn-cache-pro' ),
			self::O_MEDIA_IFRAME_LAZY             => __( 'Lazy Load Iframes', 'zinn-cache-pro' ),
			self::O_MEDIA_ADD_MISSING_SIZES       => __( 'Add Missing Sizes', 'zinn-cache-pro' ),
			self::O_MEDIA_VPI                     => __( 'Viewport Images', 'zinn-cache-pro' ),
			self::O_MEDIA_VPI_CRON                => __( 'Viewport Images Cron', 'zinn-cache-pro' ),
			self::O_MEDIA_AUTO_RESCALE_ORI        => __( 'Auto Rescale Original Images', 'zinn-cache-pro' ),

			self::O_IMG_OPTM_AUTO            => __( 'Auto Request Cron', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_ORI             => __( 'Optimize Original Images', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_RM_BKUP         => __( 'Remove Original Backups', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_WEBP            => __( 'Next-Gen Image Format', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_LOSSLESS        => __( 'Optimize Losslessly', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_SIZES_SKIPPED   => __( 'Optimize Image Sizes', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_EXIF            => __( 'Preserve EXIF/XMP data', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_WEBP_ATTR       => __( 'WebP/AVIF Attribute To Replace', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_WEBP_REPLACE_SRCSET => __( 'WebP/AVIF For Extra srcset', 'zinn-cache-pro' ),
			self::O_IMG_OPTM_JPG_QUALITY     => __( 'WordPress Image Quality Control', 'zinn-cache-pro' ),
			self::O_ESI                      => __( 'Enable ESI', 'zinn-cache-pro' ),
			self::O_ESI_CACHE_ADMBAR         => __( 'Cache Admin Bar', 'zinn-cache-pro' ),
			self::O_ESI_CACHE_COMMFORM       => __( 'Cache Comment Form', 'zinn-cache-pro' ),
			self::O_ESI_NONCE                => __( 'ESI Nonces', 'zinn-cache-pro' ),
			self::O_CACHE_VARY_GROUP         => __( 'Vary Group', 'zinn-cache-pro' ),
			self::O_PURGE_HOOK_ALL           => __( 'Purge All Hooks', 'zinn-cache-pro' ),
			self::O_UTIL_NO_HTTPS_VARY       => __( 'Improve HTTP/HTTPS Compatibility', 'zinn-cache-pro' ),
			self::O_UTIL_INSTANT_CLICK       => __( 'Instant Click', 'zinn-cache-pro' ),
			self::O_CACHE_EXC_COOKIES        => __( 'Do Not Cache Cookies', 'zinn-cache-pro' ),
			self::O_CACHE_EXC_USERAGENTS     => __( 'Do Not Cache User Agents', 'zinn-cache-pro' ),
			self::O_CACHE_LOGIN_COOKIE       => __( 'Login Cookie', 'zinn-cache-pro' ),
			self::O_CACHE_VARY_COOKIES       => __( 'Vary Cookies', 'zinn-cache-pro' ),

			self::O_MISC_HEARTBEAT_FRONT      => __( 'Frontend Heartbeat Control', 'zinn-cache-pro' ),
			self::O_MISC_HEARTBEAT_FRONT_TTL  => __( 'Frontend Heartbeat TTL', 'zinn-cache-pro' ),
			self::O_MISC_HEARTBEAT_BACK       => __( 'Backend Heartbeat Control', 'zinn-cache-pro' ),
			self::O_MISC_HEARTBEAT_BACK_TTL   => __( 'Backend Heartbeat TTL', 'zinn-cache-pro' ),
			self::O_MISC_HEARTBEAT_EDITOR     => __( 'Editor Heartbeat', 'zinn-cache-pro' ),
			self::O_MISC_HEARTBEAT_EDITOR_TTL => __( 'Editor Heartbeat TTL', 'zinn-cache-pro' ),

			self::O_CDN                   => __( 'Use CDN Mapping', 'zinn-cache-pro' ),
			self::CDN_MAPPING_URL         => __( 'CDN URL', 'zinn-cache-pro' ),
			self::CDN_MAPPING_INC_IMG     => __( 'Include Images', 'zinn-cache-pro' ),
			self::CDN_MAPPING_INC_CSS     => __( 'Include CSS', 'zinn-cache-pro' ),
			self::CDN_MAPPING_INC_JS      => __( 'Include JS', 'zinn-cache-pro' ),
			self::CDN_MAPPING_FILETYPE    => __( 'Include File Types', 'zinn-cache-pro' ),
			self::O_CDN_ATTR              => __( 'HTML Attribute To Replace', 'zinn-cache-pro' ),
			self::O_CDN_ORI               => __( 'Original URLs', 'zinn-cache-pro' ),
			self::O_CDN_ORI_DIR           => __( 'Included Directories', 'zinn-cache-pro' ),
			self::O_CDN_EXC               => __( 'Exclude Path', 'zinn-cache-pro' ),
			self::O_CDN_CLOUDFLARE        => __( 'Cloudflare API', 'zinn-cache-pro' ),
			self::O_CDN_CLOUDFLARE_CLEAR  => __( 'Clear Cloudflare cache', 'zinn-cache-pro' ),

			self::O_CRAWLER               => __( 'Crawler', 'zinn-cache-pro' ),
			self::O_CRAWLER_CRAWL_INTERVAL => __( 'Crawl Interval', 'zinn-cache-pro' ),
			self::O_CRAWLER_LOAD_LIMIT    => __( 'Server Load Limit', 'zinn-cache-pro' ),
			self::O_CRAWLER_ROLES         => __( 'Role Simulation', 'zinn-cache-pro' ),
			self::O_CRAWLER_COOKIES       => __( 'Cookie Simulation', 'zinn-cache-pro' ),
			self::O_CRAWLER_SITEMAP       => __( 'Custom Sitemap', 'zinn-cache-pro' ),

			self::O_DEBUG_DISABLE_ALL     => __( 'Disable All Features', 'zinn-cache-pro' ),
			self::O_DEBUG                 => __( 'Debug Log', 'zinn-cache-pro' ),
			self::O_DEBUG_IPS             => __( 'Admin IPs', 'zinn-cache-pro' ),
			self::O_DEBUG_LEVEL           => __( 'Debug Level', 'zinn-cache-pro' ),
			self::O_DEBUG_FILESIZE        => __( 'Log File Size Limit', 'zinn-cache-pro' ),
			self::O_DEBUG_COLLAPSE_QS     => __( 'Collapse Query Strings', 'zinn-cache-pro' ),
			self::O_DEBUG_INC             => __( 'Debug URI Includes', 'zinn-cache-pro' ),
			self::O_DEBUG_EXC             => __( 'Debug URI Excludes', 'zinn-cache-pro' ),
			self::O_DEBUG_EXC_STRINGS     => __( 'Debug String Excludes', 'zinn-cache-pro' ),

			self::O_DB_OPTM_REVISIONS_MAX => __( 'Revisions Max Number', 'zinn-cache-pro' ),
			self::O_DB_OPTM_REVISIONS_AGE => __( 'Revisions Max Age', 'zinn-cache-pro' ),

			self::O_OPTIMAX               => __( 'OptimaX', 'zinn-cache-pro' ),
		];

		if ( array_key_exists( $id, $_lang_list ) ) {
			return $_lang_list[ $id ];
		}

		return 'N/A';
	}
}
