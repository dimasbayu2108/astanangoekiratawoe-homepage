<?php
/* Maplic support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_mapplic_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_mapplic_theme_setup9', 9 );
	function scientia_mapplic_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_mapplic_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_mapplic_tgmpa_required_plugins' ) ) {
	
	function scientia_mapplic_tgmpa_required_plugins( $list = array() ) {
		$path = scientia_get_plugin_source_path( 'plugins/mapplic/mapplic.zip' );
		if ( scientia_storage_isset( 'required_plugins', 'mapplic' ) && scientia_storage_get_array( 'required_plugins', 'mapplic', 'install' ) !== false ) {
			$list[] = array(
				'name'     => scientia_storage_get_array( 'required_plugins', 'mapplic', 'title' ),
				'slug'     => 'mapplic',
				'source'   => ! empty( $path ) ? $path : 'upload://mapplic.zip',
				'version'  => '7.1.2',
				'required' => false,
			);
		}
		return $list;
	}
}
