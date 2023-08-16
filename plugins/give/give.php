<?php
/* Give (donation forms) support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_give_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_give_theme_setup9', 9 );
	function scientia_give_theme_setup9() {
		if ( scientia_exists_give() ) {
			add_action( 'wp_enqueue_scripts', 'scientia_give_frontend_scripts', 1100 );
			add_filter( 'scientia_filter_merge_styles', 'scientia_give_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_give_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_give_tgmpa_required_plugins' ) ) {
	
	function scientia_give_tgmpa_required_plugins( $list = array() ) {
		if ( scientia_storage_isset( 'required_plugins', 'give' ) && scientia_storage_get_array( 'required_plugins', 'give', 'install' ) !== false ) {
			$list[] = array(
				'name'     => scientia_storage_get_array( 'required_plugins', 'give', 'title' ),
				'slug'     => 'give',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'scientia_exists_give' ) ) {
	function scientia_exists_give() {
		return class_exists( 'Give' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'scientia_give_frontend_scripts' ) ) {
	
	function scientia_give_frontend_scripts() {
		if ( scientia_is_on( scientia_get_theme_option( 'debug_mode' ) ) ) {
			$scientia_url = scientia_get_file_url( 'plugins/give/give.css' );
			if ( '' != $scientia_url ) {
				wp_enqueue_style( 'scientia-give', $scientia_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'scientia_give_merge_styles' ) ) {
	
	function scientia_give_merge_styles( $list ) {
		$list[] = 'plugins/give/give.css';
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( scientia_exists_give() ) {
	require_once SCIENTIA_THEME_DIR . 'plugins/give/give-styles.php'; }

