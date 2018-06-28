<?php
/**
 * Featured Image Extended plugin for WordPress
 *
 * @package featured-image-extended
 *
 * Plugin Name: Featured Image Extended
 * Plugin URI:  https://github.com/enrico-sorcinelli/featured-image-extended
 * Description: A WordPress Featured Image Extended plugin
 * Author:      Enrico Sorcinelli
 * Author URI:  https://github.com/enrico-sorcinelli/featured-image-extended/graphs/contributors
 * Text Domain: featured-image-extended
 * Domain Path: /languages/
 * Version:     1.0.2
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Check running WordPress instance.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit();
}

if ( ! class_exists( 'Featured_Image_Extended' ) ) {

	// Plugins constants.
	define( 'FEATURED_IMAGE_EXTENDED_PLUGIN_VERSION', '1.0.2' );
	define( 'FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR', dirname( __FILE__ ) );
	define( 'FEATURED_IMAGE_EXTENDED_PLUGIN_BASEURL', plugin_dir_url( __FILE__ ) );

	// Enable debug prints on error_log (only when WP_DEBUG is true).
	if ( ! defined( 'FEATURED_IMAGE_EXTENDED_PLUGIN_DEBUG' ) ) {
		define( 'FEATURED_IMAGE_EXTENDED_PLUGIN_DEBUG', false );
	}

	require_once FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/class-featured-image-extended.php';

	/**
	 * Init the plugin.
	 *
	 * Define FEATURED_IMAGE_EXTENDED_PLUGIN_DEBUG to false in your <i>wp-config.php</i> to disable.
	 *
	 * @return void
	 */
	function featured_image_extended_init() {

		if ( defined( 'FEATURED_IMAGE_EXTENDED_PLUGIN_AUTOENABLE' ) && FEATURED_IMAGE_EXTENDED_PLUGIN_AUTOENABLE === false ) {
			return;
		}

		// Instantiate our plugin class and add it to the set of globals.
		$GLOBALS['featured_image_extended'] = new Featured_Image_Extended( array( 'debug' => FEATURED_IMAGE_EXTENDED_PLUGIN_DEBUG && WP_DEBUG ) );
	}

	/**
	 * Get extended featured image settings.
	 *
	 * @param null $post_id Post ID. Default to global `$post`.
	 *
	 * @return array
	 */
	function featured_image_extended( $post_id = null ) {
		return \Featured_Image_Extended::getFeaturedImageExtendedSettings( $post_id );
	};

	// Activate the plugin once all plugin have been loaded.
	add_action( 'plugins_loaded', 'featured_image_extended_init' );

	// Activation/Deactivation/Uninstall hooks.
	register_uninstall_hook( __FILE__, array( 'Featured_Image_Extended', 'pluginUninstall' ) );
}
