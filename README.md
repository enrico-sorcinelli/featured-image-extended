# Featured Image Extended

Feature Image Extended extends featured image functionality allowing:

* Display or not featured image in your themes for all post types and for all theme templates.
* Add link to the featured image.
* Add thumbnail featured image in administration screens listing.
* Allows featured image quick-editing.

# Installation

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/featured-image-extended` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the _Plugins_ screen in WordPress.

# Usage

Once the plugin is installed you can configure it in the following ways:

* Using the _Settings->Featured Image Extended_ administration screen.
* Programmatically, by using `featured_image_extended_settings` filter below.

If your theme uses a different call other than `the_post_thumbnail()`/`get_the_post_thumbnail()` in order to get the featured image, this plugin might not work.
So, in order to get extended featured image settings and apply to you pages, you should use `featured_image_extended()` (see below).

# API

### `featured_image_extended( integer $post_id = null )`

It returns an array containing featured image extended information of `$post_id` post (or current post if you don't supply an argument) like following:

```
array(
	'show'   => true,
	'url'    => 'https://myurl.com',
	'target' => '_blank',
	'title'  => 'Image title',
)
```

## Hooks

### `featured_image_extended_settings`

Filters plugin settings values.

```php
apply_filters( 'featured_image_extended_settings', array $settings )
```

## `featured_image_extended_admin_settings`

Filter allowing to display or not the plugin settings page in the administration.

```php
apply_filters( 'featured_image_extended_admin_settings', boolean $display )
```

# Frequently Asked Questions

## Does it work with Gutenberg?

Not completely. For setting visibility of featured image, this plugin uses `admin_post_thumbnail_html` filter and currently there are no Gutenberg equivalents.

# Screenshots 

### Admin Featured image metabox ###

![Admin metabox](https://raw.githubusercontent.com/enrico-sorcinelli/featured-image-extended/master/assets-wp/screenshot-1.png)

### Admin Post listing ###

![Plugin settings](https://raw.githubusercontent.com/enrico-sorcinelli/featured-image-extended/master/assets-wp/screenshot-2.png)

### Plugin settings ###

The plugin settings page.

![Plugin settings](https://raw.githubusercontent.com/enrico-sorcinelli/featured-image-extended/master/assets-wp/screenshot-3.png)

# License: GPLv2 #

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.