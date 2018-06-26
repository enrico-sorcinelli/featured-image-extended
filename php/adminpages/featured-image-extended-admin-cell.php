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
the_post_thumbnail( array( 60, 60 ), array( 'class' => '' ) );

// Check for shiw settings.
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
