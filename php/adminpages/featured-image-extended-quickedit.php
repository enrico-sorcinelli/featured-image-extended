<?php
/**
 * Plugin featured image extended template part for quickedit.
 *
 * @package featured-image-extended
 */

?>
<fieldset class="inline-edit-col-left inline-edit-<?php echo esc_attr( $params['column_name'] ) ; ?>">
	<div class="inline-edit-col">
		<legend class="inline-edit-legend"><?php esc_html_e( 'Featured image', 'featured-image-extended' ); ?></legend>
		<label class="inline-edit-group">
			<input type="checkbox" value="1" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[show]" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-show">
			<span><?php esc_html_e( 'Show in the post or listing', 'featured-image-extended' ); ?></span>
		</label>
		<label>
			<span class="input"><?php esc_html_e( 'URL', 'featured-image-extended' ); ?></span>
			<span class="input-text-wrap"><input type="text" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[url]" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-url"></span>
		</label>
		<label>
			<span class="input"><?php esc_html_e( 'Title', 'featured-image-extended' ); ?></span>
			<span class="input-text-wrap"><input type="text" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[title]" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-title"></span>
		</label>
		<label>
			<input type="checkbox" value="_blank" id="<?php echo( esc_attr( $params['prefix'] ) ); ?>options-target" name="<?php echo( esc_attr( $params['prefix'] ) ); ?>options[target]">
			<span><?php esc_html_e( 'Open link in a new tab', 'featured-image-extended' ); ?></span>
		</label>
	</div>
</fieldset>
