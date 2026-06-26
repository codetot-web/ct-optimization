# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.3.0 (2026-06-26)

### Added

- Official PHP 8.0–8.4 support, bumped `Requires PHP` to 8.0
- `.wordpress-org/` directory for WordPress.org plugin assets (icons, banners)
- Standard WordPress.org SVN deploy workflow using `10up/action-wordpress-plugin-deploy`

### Fixed

- Undefined `$attributes` variable warning in admin options page under PHP 8.0
- `Requires at least` bumped to WordPress 6.0

## 1.2.0

- PHP 8.2-8.4 compatibility: fix missing property declaration in Gravity Forms class
- Fix manifest option key mismatch (`disable_manifest` → `disable_wlw_manifest`)
- Bump minimum PHP requirement to 7.4
- Tested up to WordPress 6.8

## 1.1.1

- Fix PHP 8.1+ deprecation warnings for null/false passed to `strip_tags()` and `strtotime()`
- Fix `parse_url()` return value not checked in `get_domain_from_url()`
- Fix widget existence check in `check_comment_style()` for PHP 8.x

## 1.1.0

- Fix compatible with PHP 8

## 1.0.16

- Add option to remove duotone and extra CSS style in WP 5.9

## 1.0.15

- Fix save key for Gravity Forms settings
- Remove Compress HTML feature

## 1.0.14

- Fix load Gravity form assets if disable option.

## 1.0.13

- Disable more Gravity form assets.
- Remove HTML Compress feature.

## 1.0.12

- Add option to disable Gutenberg widget admin UI.

## 1.0.11

- Disable more Gutenberg feature.

## 1.0.10

- Fix warning PHP when calling function inline

## 1.0.9

- Add option to enable/disable lazysizes script.

## 1.0.8

- Update plugin translation.

## 1.0.7

- Add Gravity Form tweak settings, including disable default styles, hide some menus and load Gravity forms script in footer.

## 1.0.6

- Update config key to match process.

## 1.0.5

- Fix iconv convert character.
- Update Vietnamese translation.

## 1.0.4

- Fix enable cdn domain option key.

## 1.0.3

- Fix option keys to match
- Remove option in database if deactivate plugin.
- Add comment for html compress to easy debug.
- Translate update for Vietnamese
- Add more FAQ
- Add notice in case PHP version is lower 7.0

## 1.0.2

- Fix HTML compress class name.

## 1.0.1

- Add HTML compress feature.

## 1.0.0

- First release
