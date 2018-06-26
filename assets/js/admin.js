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
		})

	});

})( jQuery );
