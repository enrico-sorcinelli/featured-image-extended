<?php
/**
 * Plugin featured image extended template part.
 *
 * @package featured-image-extended
 */

?>
<div id="featured-image-extended-options">
	<p>
		<label><input type="checkbox" value="1" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[show]" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-show"'
			<?php checked( 1, $params['featured_image_extended_options']['show'], true ); ?>><?php esc_html_e( 'Show in the post or listing', 'featured-image-extended' ); ?></label>
	</p>
	<h4><?php esc_html_e( 'Link', 'featured-image-extended' ); ?></h4>
	<div>
		<label>
			<span><?php esc_html_e( 'URL', 'featured-image-extended' ); ?></span>
			<input type="text" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-url" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[url]" value="<?php echo esc_attr( $params['featured_image_extended_options']['url'] ); ?>">
		</label>
	</div>
	<div>
		<label>
			<span><?php esc_html_e( 'Title', 'featured-image-extended' ); ?></span>
			<input type="text" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-title" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[title]" value="<?php esc_attr( $params['featured_image_extended_options']['title'] ); ?>" >
		</label>
	</div>
	<div>
		<label>
			<span></span>
			<input type="checkbox" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-target" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[target]" value="_blank" <?php checked( '_blank', $params['featured_image_extended_options']['target'], true ); ?>>
			<?php esc_html_e( 'Open link in a new tab', 'featured-image-extended' ); ?>
		</label>
	</div>
</div>
