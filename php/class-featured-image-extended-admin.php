<?php
/**
 * Plugin administration class.
 *
 * @package featured-image-extended
 * @author Enrico Sorcinelli
 */

namespace Featured_Image_Extended;

// Check running WordPress instance.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit();
}
/**
 * Admin interface class.
 */
class Admin {

	/**
	 * Prefix.
	 *
	 * @var string  $prefix
	 */
	private $prefix;

	/**
	 * Plugin options.
	 *
	 * @var array
	 */
	private $plugin_options;

	/**
	 * Admin pages screen name.
	 *
	 * @var array
	 */
	private $admin_pages = array();

	/**
	 * Construct the plugin.
	 *
	 * @param array $args {
	 *     Array of arguments for constructor.
	 *
	 *     @type string  $prefix
	 *     @type boolean $debug  Default `false`.
	 * }
	 *
	 * @return object
	 */
	public function __construct( $args = array() ) {

		// Set object property.
		$this->debug = isset( $args['debug'] ) ? $args['debug'] : false;
		foreach ( array( 'prefix', 'plugin_options' ) as $property ) {
			$this->$property = $args[ $property ];
		}

		// This plugin only runs in the admin, but we need it initialized on init.
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin: setup menu, settings, add filters, actions,
	 * scripts, styles and so on.
	 *
	 * @return void
	 */
	public function init() {

		if ( ! is_admin() ) {
			return;
		}
		// Menu settings.
		add_action( 'admin_menu', array( $this, 'setupMenu' ), '10.1' );

		// Forms settings.
		add_action( 'admin_init', array( $this, 'setupSettings' ), '10.1' );
	}

	/**
	 * Setup admin menu.
	 *
	 * @return void
	 */
	public function setupMenu() {

		$admin_menu_capability = is_super_admin() ? 'manage_options' : 'featured_image_extended_manage_options';

		/**
		 * Filter to allow display plugin settings page.
		 *
		 * @param boolean $display_setting_page Default `true`.
		 *
		 * @return boolean
		 */
		if ( apply_filters( 'featured_image_extended_admin_settings', true ) ) {
			$this->admin_pages['general_settings'] = add_options_page( __( 'Featured Image Extended settings', 'featured-image-extended' ), __( 'Featured Image Extended', 'featured-image-extended' ), $admin_menu_capability, $this->prefix . 'general_settings', array( $this, 'pageGeneralSettings' ) );
		}
	}

	/**
	 * Setup admin (register settings, enque JavaScript, CSS, add filters &
	 * actions, ...).
	 *
	 * @return void
	 */
	public function setupSettings() {
		global $wp_version;

		// Enqueue JS/CSS only for non AJAX requests.
		if ( ! \Plugin_Utils::isAjaxRequest() ) {

			// Screens where to enqueue assets.
			$admin_pages = array_merge( array( 'post.php', 'post-new.php', 'edit.php' ), array_values( $this->admin_pages ) );

			// Add CSS to post pages.
			foreach ( $admin_pages as $page ) {
				add_action( 'admin_print_styles-' . $page, array( $this, 'loadCSS' ), 10, 0 );
				add_action( 'admin_print_scripts-' . $page, array( $this, 'loadJavaScript' ), 10, 0 );
			}
		}

		// General settings.
		register_setting( $this->prefix . 'general-settings', $this->prefix . 'general_settings', array( $this, 'checkGeneralSettings' ) );

		// Add filter for post thumbnail metabox HTML.
		add_filter( 'admin_post_thumbnail_html', array( $this, 'addFaturedImageOptions' ), 10, 3 );

		// Add action for save post.
		add_action( 'save_post', array( $this, 'savePost' ), 10, 3 );

		// Add thumbnail columns to the posts table header.
		add_filter( 'manage_posts_columns', array( $this, 'addFeaturedImageColumnHeader' ), 15, 1 );
		add_filter( 'manage_pages_columns', array( $this, 'addFeaturedImageColumnHeader' ), 15, 1 );

		/** This filter is documented in php/class-featured-image-extended-admin.php */
		if ( apply_filters( 'featured_image_extended_admin_settings', true ) ) {
			add_filter( 'plugin_action_links_featured-image-extended/featured-image-extended.php', array( $this, 'pluginActions' ), 10, 4 );
		}
	}

	/**
	 * Add link to settng page in plugins list.
	 *
	 * @param array  $actions     Actions.
	 * @param string $plugin_file Plugin filename.
	 * @param array  $plugin_data Plugin data.
	 * @param string $context     Context.
	 *
	 * @return array
	 */
	public function pluginActions( $actions, $plugin_file, $plugin_data, $context ) {
		array_unshift( $actions, '<a href="' . menu_page_url( $this->prefix . 'general_settings', false ) . '">' . esc_html__( 'Settings', 'featured-image-extended' ) . '</a>' );
		return $actions;
	}

	/**
	 * Filter for adding HTML to post featured image metabox.
	 *
	 * @param string  $content      Admin post thumbnail HTML markup.
	 * @param integer $post_id      Post ID.
	 * @param integer $thumbnail_id Thumbnail ID.
	 *
	 * @return string
	 */
	public function addFaturedImageOptions( $content, $post_id, $thumbnail_id = null ) {

		// Get post_type.
		$post = get_post( $post_id );

		if ( in_array( $post->post_type, $this->plugin_options['show']['post_types'], true ) ) {

			$featured_image_extended_options = \Featured_Image_Extended::getFeaturedImageExtendedSettings( $post_id );

			$content .= \Plugin_Utils::sincludeTemplate( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/adminpages/featured-image-extended.php',
				array(
					'prefix'                          => $this->prefix,
					'featured_image_extended_options' => $featured_image_extended_options,
				)
			);
		}

		return $content;
	}

	/**
	 * The quick_edit_custom_box callback. Renders the QuickEdit box.
	 * Renders with blank values here since QuickEdit boxes cannot access to the WP post_id.
	 * The values will be populated with JavaScript.
	 *
	 * @param string $column_name The column name.
	 * @param string $post_type   The post type to show the column.
	 * @param array  $values      The current values.
	 */
	public function addQuickeditBox( $column_name, $post_type, $values = array() ) {
		if ( 'featured_image_extended' !== $column_name ) {
			return;
		}
		\Plugin_Utils::includeTemplate( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/adminpages/featured-image-extended-quickedit.php',
			array(
				'prefix'      => $this->prefix,
				'column_name' => $column_name,
			)
		);
	}

	/**
	 * `save_post` action hook when a post is saved.
	 *
	 * @param int     $post_id The post ID.
	 * @param WP_Post $post    The post object.
	 * @param bool    $update  Whether this is an existing post being updated
	 *                         or not.
	 */
	public function savePost( $post_id, $post, $update ) {

		// Skip quickedit.
		if (
			isset( $_POST['action'] ) && 'inline-save' === $_POST['action'] // WPCS: input var okay. CSRF okay.
			&& ( empty( $this->plugin_options['admin']['add_column'] ) || empty( $this->plugin_options['admin']['quickedit'] ) )
		) {
			return;
		}

		// Skip Gutenberg.
		if ( ( isset( $_POST['classic-editor'] ) && '1' === $_POST['classic-editor'] ) || isset( $_POST['gutenberg_meta_boxes'] ) ) { // WPCS: input var okay. CSRF okay.
			return;
		}

		// Update featured image additional settings.
		if ( in_array( $post->post_type, $this->plugin_options['show']['post_types'], true ) && $update ) {

			// Force to 0 for 'show' option (old posts legacy).
			$_POST[ $this->prefix . 'options' ]['show'] = empty( $_POST[ $this->prefix . 'options' ]['show'] ) ? 0 : 1; // WPCS: input var okay. CSRF okay.
			update_post_meta( $post_id, $this->prefix . 'options', $_POST[ $this->prefix . 'options' ] ); // WPCS: input var okay. CSRF okay. XSS okay.
		}
	}

	/**
	 * Add custom columns to the posts table header.
	 *
	 * @param array $columns Table column names.
	 *
	 * @return array
	 */
	public function addFeaturedImageColumnHeader( $columns = array() ) {

		global $post_type, $post;

		$current_post_type = empty( $post_type ) ? $post->post_type : $post_type;

		// Add thumbnail column on a settings basis.
		if ( post_type_supports( $current_post_type, 'thumbnail' )
			&& ! empty( $this->plugin_options['admin']['add_column'] )
		) {

			$columns = \Plugin_Utils::array_insert_before( array(
				'key'       => 'title',
				'array'     => $columns,
				'new_array' => array( 'featured_image_extended' => __( 'Featured', 'featured-image-extended' ) ),
			));

			// Return content for a this column.
			add_action( 'manage_posts_custom_column', array( $this, 'addFeaturedImageColumnContent' ), 15, 2 );
			add_action( 'manage_pages_custom_column', array( $this, 'addFeaturedImageColumnContent' ), 15, 2 );

			// Add quickedit.
			if (
				! empty( $this->plugin_options['admin']['quickedit'] )
				&& in_array( $current_post_type, $this->plugin_options['show']['post_types'], true )
			) {
				add_action( 'quick_edit_custom_box', array( $this, 'addQuickeditBox' ), 10, 2 );
			}
		}

		return $columns;
	}

	/**
	 * Return content for a geatured image column cell.
	 *
	 * @param string  $column_name Table column name.
	 * @param integer $post_id     Post ID.
	 *
	 * @return void
	 */
	public function addFeaturedImageColumnContent( $column_name = '', $post_id = '' ) {
		switch ( $column_name ) {
			case 'featured_image_extended':
				\Plugin_Utils::includeTemplate( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/adminpages/featured-image-extended-admin-cell.php', array(
					'prefix'            => $this->prefix,
					'featured_settings' => \Featured_Image_Extended::getFeaturedImageExtendedSettings( $post_id ),
					'quickedit'         => $this->plugin_options['admin']['quickedit'],
					'post_id'           => $post_id,
				) );
				break;
		}
	}

	/**
	 * Check general settings.
	 *
	 * @param mixed $settings Settings values.
	 *
	 * @return array
	 */
	public function checkGeneralSettings( $settings ) {
		return $settings;
	}

	/**
	 * Load CSS files.
	 *
	 * @return void
	 */
	public function loadCSS() {
		global $post_type;

		wp_enqueue_style(
			$this->prefix . 'css',
			FEATURED_IMAGE_EXTENDED_PLUGIN_BASEURL . '/assets/css/admin.css',
			array(),
			FEATURED_IMAGE_EXTENDED_PLUGIN_VERSION
		);
	}

	/**
	 * Load JavaScript files.
	 *
	 * @return void
	 */
	public function loadJavaScript() {
		global $post_type;

		wp_enqueue_script(
			$this->prefix . 'js',
			FEATURED_IMAGE_EXTENDED_PLUGIN_BASEURL . '/assets/js/admin.js',
			array(),
			FEATURED_IMAGE_EXTENDED_PLUGIN_VERSION,
			false
		);

		// Localization.
		wp_localize_script( $this->prefix . 'js', $this->prefix . 'i18n', array(
			'_nonces'     => array(),
			'_plugin_url' => FEATURED_IMAGE_EXTENDED_PLUGIN_BASEURL,
			'msgs'        => array(),
		) );
	}

	/**
	 * General settings admin page callback.
	 *
	 * @return void
	 */
	public function pageGeneralSettings() {
		\Plugin_Utils::includeTemplate( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/adminpages/general-settings.php', array(
			'prefix'   => $this->prefix,
			'settings' => $this->plugin_options,
		) );
	}
}
