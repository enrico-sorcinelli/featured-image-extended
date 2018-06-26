<?php
/**
 * Plugin credit template part.
 *
 * @package featured-image-extended
 */

?>
			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox" id="featured-image-extended-credits">
					<h3 class="hndle">Featured Image Extended <?php echo esc_html( FEATURED_IMAGE_EXTENDED_PLUGIN_VERSION ); ?></h3>
					<div class="inside">
						<h4><?php esc_html_e( 'Changelog', 'featured-image-extended' ); ?></h4>
						<p><?php esc_html_e( 'What\'s new in', 'featured-image-extended' ); ?>
							<a href="https://github.com/enrico-sorcinelli/featured-image-extended/releases"><?php /* translators: */ echo esc_html( sprintf( __( 'version %s', 'featured-image-extended' ), FEATURED_IMAGE_EXTENDED_PLUGIN_VERSION ) ); ?></a>.
						<h4><?php esc_html_e( 'Support', 'featured-image-extended' ); ?></h4>
						<p><span class="dashicons dashicons-email-alt"></span>
							<a href="https://github.com/enrico-sorcinelli/tfeatured-image-extended/issues"><?php esc_html_e( 'Feel free to ask for help', 'featured-image-extended' ); ?></a>.</p>
						<div class="author">
							<i><span><?php esc_html_e( 'Featured Image Extended', 'featured-image-extended' ); ?> <?php esc_html_e( 'by', 'featured-image-extended' ); ?> Enrico Sorcinelli</span><br>
							&copy; <?php echo esc_html( date( 'Y' ) ); ?></i>
						</div>
					</div>
				</div>
			</div>
