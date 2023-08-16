<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_essential_grid_theme_setup9', 9 );
	function scientia_essential_grid_theme_setup9() {
		if ( scientia_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'scientia_essential_grid_frontend_scripts', 1100 );
			add_filter( 'scientia_filter_merge_styles', 'scientia_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_essential_grid_tgmpa_required_plugins' ) ) {
	
	function scientia_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( scientia_storage_isset( 'required_plugins', 'essential-grid' ) && scientia_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && scientia_is_theme_activated() ) {
			$path = scientia_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || scientia_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => scientia_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '3.0.16',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'scientia_exists_essential_grid' ) ) {
	function scientia_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH') || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'scientia_essential_grid_frontend_scripts' ) ) {
	
	function scientia_essential_grid_frontend_scripts() {
		if ( scientia_is_on( scientia_get_theme_option( 'debug_mode' ) ) ) {
			$scientia_url = scientia_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $scientia_url ) {
				wp_enqueue_style( 'scientia-essential-grid', $scientia_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'scientia_essential_grid_merge_styles' ) ) {
	
	function scientia_essential_grid_merge_styles( $list ) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}

