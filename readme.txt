=== Featured Image Extended ===
Contributors: enrico.sorcinelli
Tags: post, category, featured image, thumbnail, theme, admin
Requires at least: 4.4
Requires PHP: 5.2.4
Tested up to: 4.9.6
Stable tag: 1.0.0
License: GPLv2 or later

Feature Image Extended extends featured image builtin functionality.

== Description ==

Feature Image Extended extend featured image functionality allowing:

* Display or not featured image in your themes for all post types.
* Add link to the featured image.
* Add thumbnail featured image in administration screens listing.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/featured-image-extended` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.

== Usage ==

Once the plugin is installed you can control settings in the following ways:

* Programmatically by using `featured_image_extended_settings` filter below.
* Using the *Settings->Featured Image Extended* administration screen.

== Hooks ==

**`featured_image_extended_settings`**

Filter plugin settings values.

`apply_filters( 'featured_image_extended_settings', array $settings )`

== Frequently Asked Questions ==

= Does it work with Gutenberg? =

Not completely. For setting visibility of featured image, this plugin uses `admin_post_thumbnail_html` filter and currently there are no Gutenberg equivalents.

== Screenshots ==

1. The Featured image metabox drag&drop in action.
2. The administration post list with featured image.
3. The plugin settings page.

== Changelog ==

For Featured Image Extended changelog, please see [the Releases page on GitHub](https://github.com/enrico-sorcinelli/featured-image-extended/releases).
