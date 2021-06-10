/**
 * Customizer order control.
 *
 * @package khutar\Customizer\Controls
 */
( function ( $ ) {
	'use strict';
	wp.khutarHeadingAccordion = {
		init: function () {
			this.handleToggle();
		},
		handleToggle: function () {
			$( '.customize-control-customizer-heading.accordion .khutar-customizer-heading' ).on( 'click', function () {
				var accordion = $( this ).closest( '.accordion' );
				$( accordion ).toggleClass( 'expanded' );
				return false;
			} );
		},
	};

	$( document ).ready(
		function () {
			wp.khutarHeadingAccordion.init();
		}
	);
} )( jQuery );
