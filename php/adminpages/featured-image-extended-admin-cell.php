<?php
/**
 * Plugin featured image extended template part for post list.
 *
 * @package featured-image-extended
 */

$prefix_class = rtrim( preg_replace( '/_/', '-', $params['prefix'] ), '-' );

?>
<div class="<?php echo esc_attr( $prefix_class ); ?>-edit">
<?php

// Check for additional link.
if ( ! empty( $params['featured_settings']['url'] ) ) {
	printf( '<a href="%s" title="%s" target="%s">',
		esc_attr( $params['featured_settings']['url'] ),
		esc_attr( $params['featured_settings']['title'] ),
		esc_attr( $params['featured_settings']['target'] )
	);
}

$data_featured = wp_json_encode( $params['featured_settings'] );

$img = get_the_post_thumbnail( $params['post_id'], array( 60, 60 ), array( 'class' => '', 'data-featured' => $data_featured ) );

// Empty image placeholder.
if ( empty( $img ) ) {
	echo sprintf( '<img src="%s" height="60" width="60" data-featured="%s" class=" wp-post-image">',
		esc_attr( FEATURED_IMAGE_EXTENDED_PLUGIN_BASEURL . '/assets/img/empty-img-placeholder.png' ),
		esc_attr( $data_featured )
	);
}
else {
	echo $img; // XSS okay.
};

// Check for display settings.
if ( empty( $params['featured_settings']['show'] ) ) {
?>
	<div class="not-shown"></div>
	<span class="dashicons dashicons-hidden"></span>
<?php
}
if ( ! empty( $params['featured_settings']['url'] ) ) {
	echo '</a>';
}
?>
</div>
