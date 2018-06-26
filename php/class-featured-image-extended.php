<?php
/**
 * Plugin administration class.
 *
 * @package taxonomies-sortable
 * @author Enrico Sorcinelli
 */

// Check running WordPress instance.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit();
}

/**
 *  Admin interface class.
 */
class Featured_Image_Extended {

	/**
	 * Prefix used for options and postmeta fields, DOM IDs and DB tables.
	 *
	 * @var string
	 */
	private static $prefix = 'featured_image_extended_';

	/**
	 * Plugin settings.
	 *
	 * @var array   $settings
	 */
	private $settings = array();

	/**
	 * Plugin options.
	 *
	 * @var array
	 */
	private $plugin_options;

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Plugin class constructor.
	 *
	 * @param array $args {
	 *     Array of arguments for constructor.
	 *
	 *     @type boolean $debug Default `false`.
	 * }
	 *
	 * @return object
	 */
	public function __construct( $args = array() ) {

		$this->settings = wp_parse_args( $args, array(
			'debug' => false,
		), $args );

		// Load plugin text domain.
		load_plugin_textdomain( 'featured-image-extended', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );

		// Get plugin settings.
		$this->plugin_options = $this->getPluginOptions();

		// Check and load needed compoments.
		$this->requireComponents();

		if ( is_admin() ) {
			// Create plugin admin objects.
			$this->_admin = new \Featured_Image_Extended\Admin( array(
				'prefix'         => self::$prefix,
				'debug'          => $this->settings['debug'],
				'plugin_options' => $this->plugin_options,
			) );
		}

		add_filter( 'post_thumbnail_html', array( $this, 'postThumbnailHtml' ), 10, 5 );
	}

	/**
	 * Get the singleton instance of this class.
	 *
	 * @param array $args Constructor arguments.
	 *
	 * @return object
	 */
	public static function get_instance( $args = array() ) {
		if ( ! ( self::$instance instanceof self ) ) {
			self::$instance = new self( $args );
		}
		return self::$instance;
	}

	/**
	 * This function will include core files before the theme's functions.php
	 * file has been executed.
	 *
	 *  @return      void
	 */
	public function requireComponents() {

		// Plugin classes.
		if ( ! class_exists( 'Plugin_Utils' ) ) {
			require_once( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/class-plugin-utils.php' );
		}

		// Admin interface.
		if ( is_admin() ) {
			require_once( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/class-featured-image-extended-admin.php' );
		}
	}

	/**
	 * Render post thumbnail HTML for themes.
	 *
	 * @param string  $html              HTML for post thumbnail.
	 * @param integer $post_id           Post ID.
	 * @param integer $post_thumbnail_id Post thumbnail ID.
	 * @param string  $size              Image size.
	 * @param array   $attr              Tag attributes.
	 *
	 * @return string
	 */
	public function postThumbnailHtml( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

		global $post;

		if (
			! is_admin() &&
			// Check enabled contexts.
			(
				( is_single() && ! empty( $this->plugin_options['show']['context_single'] ) )
				|| ( is_archive() && ! empty( $this->plugin_options['show']['context_archive'] ) )
				|| ( ( is_home() || is_front_page() ) && ! empty( $this->plugin_options['show']['context_home'] ) )
			)
			// Check enabled post types.
			&& in_array( $post->post_type, $this->plugin_options['show']['post_types'], true )
		) {
			$featured_image_extended_options = \Featured_Image_Extended::getFeaturedImageExtendedSettings( $post_id );

			// Raises HTML.
			if ( empty( $featured_image_extended_options['show'] ) ) {
				return '';
			}

			// Check for additional link.
			if ( is_single() && ! empty( $featured_image_extended_options['url'] ) ) {
				$html = sprintf( '<a href="%s" title="%s" target="%s">%s</a>',
					esc_attr( $featured_image_extended_options['url'] ),
					esc_attr( $featured_image_extended_options['title'] ),
					esc_attr( $featured_image_extended_options['target'] ),
					$html
				);
			}
		}

		return $html;
	}

	/**
	 * Get plugin options settings.
	 *
	 * @return array
	 */
	private function getPluginOptions() {
		$settings = wp_parse_args(
			get_option( self::$prefix . 'general_settings', array() ),
			array(
				'show'    => array(
					'post_types'      => array(),
					'context_single'  => true,
					'context_archive' => true,
				),
				'options' => array(
					'remove_plugin_settings' => false,
				),
			)
		);

		/**
		 * Filter plugin settings.
		 *
		 * @param array $post_types Post types.
		 *
		 * @return array
		 */
		$settings = apply_filters( self::$prefix . 'settings', $settings );

		return $settings;
	}

	/**
	 * Get post featured image extended setting.
	 *
	 * @param null $post_id Post ID. Default to global `$post->ID`.
	 *
	 * @return array
	 */
	public static function getFeaturedImageExtendedSettings( $post_id = null ) {

		global $post;

		if ( empty( $post_id ) && $post instanceof \WP_Post ) {
			$post_id = $post->ID;
		}

		$featured_image_settings = array();

		if ( ! empty( $post_id ) ) {

			// Get settings or default for featured options.
			$featured_image_settings = get_post_meta( $post_id, self::$prefix . 'options', true );
			$featured_image_settings = array_merge(
				array(
					'show'   => 1,
					'url'    => '',
					'target' => '',
					'title'  => '',
				),
				is_array( $featured_image_settings ) ? $featured_image_settings : array()
			);
		}

		return $featured_image_settings;
	}

	/**
	 * Plugin uninstall hook.
	 *
	 * @return void
	 */
	public static function pluginUninstall() {
		$options = get_option( self::$prefix . 'general_settings', true );
		if ( isset( $options['options'] ) && ! empty( $options['options']['remove_plugin_settings'] ) ) {
			delete_option( self::$prefix . 'general_settings' );
		}
	}
}
