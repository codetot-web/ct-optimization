=== CT Optimization ===
Contributors: khoipro, codetot
Donate link: https://codetot.com
Tags: optimization, compress, settings, codetot
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 1.6.1
Requires PHP: 8.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides settings for enable/disable WordPress core features and some tweaks for ACF, Gravity Forms, such like Enable CDN, Lazyload assets.

== Description ==

The optimization toolkit for optimizing WordPress sites, from hide, remove some WordPress cores to compress HTML and support CDN domain.

Main Features:

Disable some core WordPress features:

1. Disable Gutenberg Block Editor
2. Disable Gutenberg Widgets
3. Disable Emoji
4. Hide WordPress version
5. Disable oEmbed
6. Disable XMLRPC
7. Disable Heartbeat
8. Disable Comments
9. Disable Ping
10. Disable Feed
11. Disable Shortlink
12. Disable WLW Manifest
13. Disable Inline Comment styles

Assets Optimization:

1. Remove Global Styles (Duotone and Extra CSS Style from WP 5.9)

Advanced Settings:

1. Enable CDN Domain (works with ACF fields)

Extra Plugin Settings:

1. Disable Gravity Forms Default Styles
2. Hide Gravity Forms Menus
3. Load Gravity Forms in Footer
4. Load [Lazysizes](https://github.com/aFarkas/lazysizes) scripts

To see more free plugins, visit our [GitHub](https://github.com/codetot-web).
If you need extra support, please use a contact form at [our website](https://codetot.com).

== Installation ==

1. Upload `codetot-optimization.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Manage your settings via menu 'CT Optimization'

== Frequently Asked Questions ==

= What makes this plugin different from other optimization plugins? =

We just bring some helper functions from our core theme and release it under a single plugin. There is big advantage when using it with our core theme, but it should be better in most other themes.

= Should it work with my current theme? =

Certainly. We just use filters/actions hooks.

= Should I use it this plugin instead of caching plugin? =

No, if you are using other themes.
Yes, if you are using our themes.

== Screenshots ==

1. screenshot-1.png

== Changelog ==

= 1.6.1 =
* **[Fix]** WP 6.7+ deprecation: translation domain loaded too early — moved `load_plugin_textdomain()` from `plugins_loaded` hook to direct call in constructor
* **[Fix]** Tested on PHP 8.1, 8.2, 8.3 across multiple production sites — no errors
* **[Dev]** Verified compatibility with WordPress 6.8

= 1.6.0 =
* **[Cleanup]** Removed dead `admin/partials/display.php` file (not used anywhere)
* **[Cleanup]** Removed empty boilerplate `admin/js/codetot-optimization-admin.js` and `admin/css/codetot-optimization-admin.css`
* **[Security]** Added `esc_html()` to `$GLOBALS['title']` output in admin options page
* **[Security]** Code style consistency for `$_GET`/`$_POST` access in Gravity Forms class

= 1.5.0 =
* **[New]** Remove query strings (`?ver=`) from static assets for improved cache hit rate
* **[New]** Disable self pingbacks to reduce server load
* **[New]** Disable REST API for non-authenticated users (returns 401)
* **[New]** Remove default dashboard widgets (Quick Draft, WP News, etc.)
* **[New]** Disable attachment pages (301 redirect to parent post or home)
* **[New]** Remove jQuery Migrate script from front-end
* **[New]** Disable native WordPress XML sitemaps (WP 5.5+)
* **[New]** Remove dashicons styles on front-end when not used by theme

= 1.4.0 =
* **[Fix]** `use_block_editor_for_post` filter was incorrectly registered as `add_action` → now uses proper `add_filter`
* **[Fix]** Plugin deactivation never cleaned up options — `delete_option()` was wrapped in `add_action('init', ...)` that never runs during deactivation
* **[Fix]** `update_option()` calls for default comment/ping statuses moved from per-request admin to activation hook (runs once)
* **[Fix]** `uninstall.php` now cleans up plugin options from database
* **[Perf]** Centralized option loading — `Codetot_Optimization::get_options()` with static cache; 1 DB call per request instead of 3

= 1.3.0 =
* Official PHP 8.0-8.4 support, bumped Requires PHP to 8.0
* Fix undefined variable warning in admin options page under PHP 8.0
* Bump Requires at least to WordPress 6.0
* Integrate standard WordPress.org SVN deploy workflow
* Move WP.org assets to .wordpress-org/ directory

= 1.2.0 =
* PHP 8.2-8.4 compatibility: fix missing property declaration in Gravity Forms class
* Fix manifest option key mismatch (disable_manifest → disable_wlw_manifest)
* Bump minimum PHP requirement to 7.4
* Tested up to WordPress 6.8

= 1.1.1 =
* Fix PHP 8.1+ deprecation warnings for null/false passed to strip_tags() and strtotime()
* Fix parse_url() return value not checked in get_domain_from_url()
* Fix widget existence check in check_comment_style() for PHP 8.x

= 1.1.0 =
* Fix compatible with PHP 8

= 1.0.16 =

* Add option to remove duotone and extra CSS style in WP 5.9

= 1.0.15 =

* Fix save key for Gravity Forms settings
* Remove Compress HTML feature

= 1.0.14 =

* Fix load Gravity form assets if disable option.

= 1.0.13 =

* Disable more Gravity form assets.
* Remove HTML Compress feature.

= 1.0.12 =

* Add option to disable Gutenberg widget admin UI.

= 1.0.11 =

* Disable more Gutenberg feature.

= 1.0.10 =

* Fix warning PHP when calling function inline

= 1.0.9 =

* Add option to enable/disable lazysizes script.

= 1.0.8 =

* Update plugin translation.

= 1.0.7 =

* Add Gravity Form tweak settings, including disable default styles, hide some menus and load Gravity forms script in footer.

= 1.0.6 =

* Update config key to match process.

= 1.0.5 =

* Fix iconv convert character.
* Update Vietnamese translation.

= 1.0.4 =

* Fix enable cdn domain option key.

= 1.0.3 =

* Fix option keys to match
* Remove option in database if deactivate plugin.
* Add comment for html compress to easy debug.
* Translate update for Vietnamese
* Add more FAQ
* Add notice in case PHP version is lower 7.0

= 1.0.2 =

* Fix HTML compress class name.

= 1.0.1 =

* Add HTML compress feature.

= 1.0.0 =

* First release
