=== CodeTot Optimization ===
Contributors: khoipro, codetot
Donate link: https://codetot.com
Tags: optimization, compress, settings
Requires at least: 5.4
Tested up to: 5.7
Stable tag: 5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides settings for enable/disable WordPress core features and some tweaks for ACF, Gravity Forms, such like Enable CDN, Lazyload assets.

== Description ==

The optimization toolkit for optimizing WordPress sites, from hide, remove some WordPress cores to compress HTML and support CDN domain.
This is a small plugin with no dependencies, however we official provide support with those plugins:

- Advanced Custom Fields (Pro Version)
- Gravity Forms (Tweak bundle to lazyload in footer)
- Redis Object Cache
- reSmush.it Image Optimizer

You can enable/disable load below external scripts:

- [lazysizes.min.js](https://github.com/aFarkas/lazysizes)

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
