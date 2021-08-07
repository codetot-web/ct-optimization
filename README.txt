=== CodeTot Optimization ===
Contributors: khoipro, codetot
Donate link: https://codetot.com
Tags: optimization, compress, settings
Requires at least: 5.0
Tested up to: 5.8
Stable tag: 1.0.12
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides settings for enable/disable WordPress core features and some tweaks for ACF, Gravity Forms, such like Enable CDN, Lazyload assets.

== Description ==

The optimization toolkit for optimizing WordPress sites, from hide, remove some WordPress cores to compress HTML and support CDN domain.

Main Features:

Disable some core WordPress features:

1. Disable Gutenberg Block Editor
2. Disable Gutenberg widgets
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

Advanced Settings:

1. Compress HTML
2. Enable CDN Domain (works with ACF fields)

Extra Plugin Settings:

1. Disable Gravity Forms Default Styles
2. Hide Gravity Forms Menus
3. Load Gravity Forms in Footer
4. Load [Lazysizes](https://github.com/aFarkas/lazysizes) scripts

== Installation ==

1. Upload `codetot-optimization.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Manage your settings via menu 'CT Optimization'

== Frequently Asked Questions ==

= What makes this plugin different from other optimization plugins? =

We just bring some helper functions from our core theme and release it under a single plugin. There is big advantage when using it with our core theme, but it should be better in most other themes.

= Do I need any specific theme to work with? =

It depends your choices. Our suggestion is trying with a theme which has no page builder, because we provide a setting to disable Gutenberg. Right now this plugin has been integrated with all our themes as well.

= Should I use it this plugin instead of caching plugin? =

No, if you are using other themes.
Yes, if you are using our themes.

== Screenshots ==

1. screenshot-1.png

== Changelog ==

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
