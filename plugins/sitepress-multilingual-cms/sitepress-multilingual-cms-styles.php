<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'scientia_wpml_get_css' ) ) {
	add_filter( 'scientia_filter_get_css', 'scientia_wpml_get_css', 10, 2 );
	function scientia_wpml_get_css( $css, $args ) {
		return $css;
	}
}

