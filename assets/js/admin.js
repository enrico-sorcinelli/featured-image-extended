/**
 * @file This file contains Featured Image Extended JavaScript
 * @author Enrico Sorcinelli
 * @version 0.0.1
 * @title Featured Image Extended
 */

// Make all in a closure.
;(function ($) {

	$( document ).ready( function() {

		// Tab managements.
		$( document ).ready( function() {
			$( '.nav-tab-wrapper.featured-image-extended a' ).on( 'click', function () {
				$( '.nav-tab.featured-image-extended' ).removeClass( 'nav-tab-active' );
				$( this ).addClass( 'nav-tab-active' );
				$( 'section.featured-image-extended' ).hide();
				$( 'section.featured-image-extended' ).eq( $( this ).index() ).show();
				return false;
			});
		});

		// Quickedit option.
		$( '#featured_image_extended_general_settings_admin_quickedit' ).prop( 'disabled', ! $( '#featured_image_extended_general_settings_admin_add_column' ).prop( 'checked' ) );
		$( '#featured_image_extended_general_settings_admin_add_column' ).on( 'click', function() {
			$( '#featured_image_extended_general_settings_admin_quickedit' ).prop( 'disabled', ! $( this ).prop( 'checked' ) );
		} );
		$( '#featured_image_extended_general_settings_admin_quickedit' ).on( 'click', function() {
			$( '#featured_image_extended_general_settings_admin_quickedit_h' ).val( $( this ).prop( 'checked' ) ? 1 : 0 );
		} );

		// Quickedit.
		if ( 'object' === typeof( inlineEditPost ) ) {

			// Copy of the WP inline edit post function.
			var $wp_inline_edit = inlineEditPost.edit;

			// Overwrite the function with our own code.
			inlineEditPost.edit = function( id ) {

				// "call" the original WP edit function we don't want to leave WordPress hanging.
				$wp_inline_edit.apply( this, arguments );

				// Get the post ID.
				var post_id = 0;
				if ( 'object' === typeof( id ) ) {
					post_id = parseInt( this.getId( id ) );
				}

				if ( post_id > 0 ) {

					// Define the edit row.
					var $edit_row = $( '#edit-' + post_id );
					var $post_row = $( '#post-' + post_id );

					// Get the data.
					var featured_image_extended = $( '.column-featured_image_extended .wp-post-image', $post_row ).data('featured');

					// Populate the data.
					$( ':input[name="featured_image_extended_options[show]"]', $edit_row ).prop( 'checked', featured_image_extended['show'] );
					$( ':input[name="featured_image_extended_options[url]"]', $edit_row ).val( featured_image_extended['url'] );
					$( ':input[name="featured_image_extended_options[title]"]', $edit_row ).val( featured_image_extended['title'] )
					$( ':input[name="featured_image_extended_options[target]"]', $edit_row ).prop( 'checked', featured_image_extended['target'] ? true : false );
				}
			};
		}

	});

})( jQuery );
