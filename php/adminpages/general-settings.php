<?php
/**
 * Plugin settings
 *
 * @package featured-image-extended
 */

// Global.
global $wp_query, $wp;

// Get the registered post type.
$registered_post_types = get_post_types( '', 'objects' );
?>

<div class="wrap">
	<h1><?php esc_html_e( 'Featured Image Extended settings', 'featured-image-extended' ); ?></h1>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="postbox-container-2" class="postbox-container">

<form method="post" action="options.php">

<?php settings_fields( $params['prefix'] . 'general-settings' ); ?>
<?php do_settings_sections( $params['prefix'] . 'general-settings' ); ?>

	<h2 class="nav-tab-wrapper wp-clearfix featured-image-extended">
		<a class="nav-tab featured-image-extended nav-tab-active"><?php esc_html_e( 'Featured image', 'featured-image-extended' ); ?></a>
		<a class="nav-tab featured-image-extended"><?php esc_html_e( 'Options', 'featured-image-extended' ); ?></a>
	</h2>

	<section class="featured-image-extended">
		<table class="form-table">
			<tr>
				<th scope="row"><?php esc_html_e( 'Post Types', 'featured-image-extended' ); ?></th>
				<td>
					<fieldset>
<?php
if ( ! empty( $registered_post_types ) ) {
	foreach ( (array) $registered_post_types as $post_type ) {

		// Skip post types without 'thumbnail' support.
		if ( ! post_type_supports( $post_type->name, 'thumbnail' ) ) {
			continue;
		}
?>
							<label for="<?php echo esc_attr( $params['prefix'] . $post_type->name ); ?>">
								<input class="featured-image-extended" id="<?php echo esc_attr( $params['prefix'] . $post_type->name ); ?>" type="checkbox" name="<?php echo esc_attr( $params['prefix'] ); ?>general_settings[show][post_types][]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( 1, ! empty( $params['settings']['show']['post_types'] ) && in_array( $post_type->name, $params['settings']['show']['post_types'], true ), true ); ?> />
								<?php echo esc_html( $post_type->labels->name ); ?>
							</label>
							<br>
<?php
	}
}
?>
					</fieldset>
					<p class="description"><?php esc_html_e( 'Select post types where to apply featured extended images.', 'featured-image-extended' ); ?></p>
				</td>
			<tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Theme context', 'featured-image-extended' ); ?></th>
				<td>
					<?php esc_html_e( 'Apply to:', 'featured-image-extended' ); ?>
						<fieldset>
							<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[show][context_home]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_show_context_home' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['show']['context_home'] ) ? 0 : 1, true ); ?>>
							<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_show_context_home' ); ?>"><?php esc_html_e( 'Homepage', 'featured-image-extended' ); ?></label>
							<br>
							<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[show][context_single]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_show_context_single' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['show']['context_single'] ) ? 0 : 1, true ); ?>>
							<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_show_context_single' ); ?>"><?php esc_html_e( 'Single (posts, pages and CPT)', 'featured-image-extended' ); ?></label>
							<br>
							<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[show][context_archive]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_show_context_archive' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['show']['context_archive'] ) ? 0 : 1, true ); ?>>
							<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_show_context_archive' ); ?>"><?php esc_html_e( 'Archive (archive, category, search)', 'featured-image-extended' ); ?></label>
						</fieldset>
					<p class="description"><?php esc_html_e( 'Select contexts where to apply featured extended images.', 'featured-image-extended' ); ?></p>
				</td>
			<tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Administration', 'featured-image-extended' ); ?></th>
				<td>
					<fieldset>
						<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[admin][add_column]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_admin_add_column' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['admin']['add_column'] ) ? 0 : 1, true ); ?>>
						<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_admin_add_column' ); ?>"><?php esc_html_e( 'Show featured image on posts list.', 'featured-image-extended' ); ?></label>
						<br>
						<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[admin][quickedit]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_admin_quickedit' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['admin']['quickedit'] ) ? 0 : 1, true ); ?>>
						<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[admin][quickedit]' ); ?>" type="hidden" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_admin_quickedit_h' ); ?>" value="<?php echo empty( $params['settings']['admin']['quickedit'] ) ? 0 : 1; ?>">
						<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_admin_quickedit' ); ?>"><?php esc_html_e( 'Allows quick editing.', 'featured-image-extended' ); ?></label>
					</fieldset>
				</td>
			<tr>
		</table>
	</section>

	<section class="featured-image-extended">
		<table class="form-table">
			<tr>
				<th scope="row"><?php esc_html_e( 'Plugin settings', 'featured-image-extended' ); ?></th>
				<td>
					<p>
						<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[options][remove_plugin_settings]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_options_remove_plugin_settings' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['options']['remove_plugin_settings'] ) ? 0 : 1, true ); ?>>
						<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_options_remove_plugin_settings' ); ?>"><?php esc_html_e( 'Completely remove options on plugin removal.', 'featured-image-extended' ); ?></label>
					</p>
				</td>
			<tr>
		</table>
	</section>

<?php submit_button(); ?>
</form>
			</div>
<?php \Plugin_Utils::includeTemplate( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEDIR . '/php/adminpages/credits.php', array( 'prefix' => $params['prefix'] ) ); ?>
		</div><!-- /#post-body -->
	</div><!-- /#poststuff -->
</div><!--/.wrap-->
