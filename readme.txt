=== Featured Image Extended ===
Contributors: enrico.sorcinelli
Tags: post, category, featured image, thumbnail, theme, admin
Requires at least: 4.4
Requires PHP: 5.2.4
Tested up to: 4.9.6
Stable tag: 1.0.2
License: GPLv2 or later

Feature Image Extended extends featured image builtin functionality.

== Description ==

Feature Image Extended extends featured image functionality allowing:

* Hiding featured image in your themes for all post types.
* Adding link to the featured image.
* Adding thumbnail featured image in administration screens listing.
* Featured image quick-editing.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/featured-image-extended` directory, or install the plugin through the WordPress _Plugins_ screen directly.
1. Activate the plugin through the _Plugins_ screen in WordPress.

== Usage ==

Once the plugin is installed you can control settings in the following ways:

* Programmatically by using `featured_image_extended_settings` filter (see below).
* Using the *Settings->Featured Image Extended* administration screen.

If your theme uses a different call other than `the_post_thumbnail()`/`get_the_post_thumbnail()` in order to get the featured image, this plugin might not work.
So, in order to get extended featured image settings and apply to your pages, you should use `featured_image_extended()` (see below).

== API ==

**`featured_image_extended( integer $post_id = null )`**

It returns an array containing featured image extended information of `$post_id` post (or current post if you don't supply an argument) like following:

`
array(
	'show'   => true,
	'url'    => 'https://myurl.com',
	'target' => '_blank',
	'title'  => 'Image title',
)
`
= Hooks =

**`featured_image_extended_settings`**

Filter plugin settings values.

`apply_filters( 'featured_image_extended_settings', array $settings )`

**`featured_image_extended_admin_settings`**

Filter allowing to display or not the plugin settings page in the administration.

`apply_filters( 'featured_image_extended_admin_settings', boolean $display )`

== Frequently Asked Questions ==

= Does it work with Gutenberg? =

Not completely. For setting visibility of featured image, this plugin uses `admin_post_thumbnail_html` filter and currently there are no Gutenberg equivalents.

== Screenshots ==

1. The Featured image metabox drag&drop in action.
2. The administration post list with featured image.
3. The plugin settings page.

== Changelog ==

For Featured Image Extended changelog, please see [the Releases page on GitHub](https://github.com/enrico-sorcinelli/featured-image-extended/releases).
