<?php
/**
 * Plugin Utils class.
 *
 * @package featured-image-extended
 * @author Enrico Sorcinelli
 */
class Plugin_Utils {

	/**
	 * Check for AJAX request.
	 *
	 * @return boolean
	 */
	public static function isAjaxRequest() {

		if (
			( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' )
			|| ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Call a template. Return also value returned from `include`.
	 *
	 * @param string|array $template Path of file to include (include_path),
	 *                               function or class method.
	 * @param array|null   $params   Associative array that you could use
	 *                               inside template. Use `$params{key}` in the
	 *                               template to refer to the specific `key`.
	 *
	 * @return mixed
	 */
	public static function includeTemplate( $template, $params = array() ) {

		// WP globals.
		global $wp_query, $wp_style, $wp_registered_sidebars, $sidebars_widgets, $wp_registered_widgets, $posts, $post, $wp_did_header, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		// Check for a callable template (function/class method).
		if ( is_callable( $template ) ) {
			return call_user_func( $template, $params );
		}

		// Consider template a file.
		return include( $template );
	}

	/**
	 * Call a template by buffering output (like `sprintf`).
	 *
	 * @param string $template Path of file to include (include_path).
	 * @param array  $params   Hash array that you could use inside template.
	 *                         Use `$params{key}` in access to refer to the
	 *                         specific `key`.
	 *
	 * @return mixed Return all standard output generated by template or the
	 *               value returned by template if it doesn't return a scalar
	 *               (i.e an object).
	 */
	public static function sincludeTemplate( $template, $params = array() ) {

		// WP globals.
		global $wp_query, $wp_style, $wp_registered_sidebars, $sidebars_widgets, $wp_registered_widgets, $posts, $post, $wp_did_header, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		ob_start();

		// Check for a callable template (function/class method).
		if ( is_callable( $template ) ) {
			$ret = call_user_func( $template, $params );
		}
		else {
			$ret = include( $template );
		}

		$stdout = ob_get_clean();

		// Include fails.
		if ( false === $ret ) {
			return $ret;
		}

		// Checks return type.
		return ( is_scalar( $ret ) || null === $ret ) ? $stdout : $ret;
	}

	/**
	 * Returns true if `$regex` is a valid regular expression pattern.
	 *
	 * @param mixed $regex Regex to be tested.
	 *
	 * @return boolean
	 */
	public static function isRegex( $regex = null ) {

		// Pattern is broken.
		if ( @preg_match( $regex, null ) === false ) {
			return false;
		}

		// Pattern is valid.
		return true;
	}

	/**
	 * Inserts a new key/value before s specific key in the array.
	 *
	 * @param array $args {
	 *     Array of arguments for constructor.
	 *
	 *     @type string  $key            Array key to insert before.
	 *     @type array   $array          Original array.
	 *     @type array   $new_array      Array to insert.
	 *     @type boolean $force_if_empty Add always even if the keys is empty.
	 * }
	 *
	 * @return array The new array if the key exists.
	 */
	public static function array_insert_before( $args = [] ) {

		// Check array.
		if ( ! is_array( $args['array'] ) || ! is_array( $args['new_array'] ) ) {
			return $args['array'];
		}

		if ( empty( $args['array'] ) && empty( $args['force_if_empty'] ) ) {
			return $args['array'];
		}

		if ( array_key_exists( $args['key'], $args['array'] ) ) {
			$ary = array();
			foreach ( $args['array'] as $key => $val ) {
				if ( $key === $args['key'] ) {
					foreach ( $args['new_array'] as $new_key => $new_val ) {
						$ary[ $new_key ] = $new_val;
					}
				}
				$ary[ $key ] = $val;
			}
			return $ary;
		}
		return $args['array'] + $args['new_array'];
	}
}
