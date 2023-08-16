<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_mailchimp_theme_setup9', 9 );
	function scientia_mailchimp_theme_setup9() {
		if ( scientia_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'scientia_mailchimp_frontend_scripts', 1100 );
			add_filter( 'scientia_filter_merge_styles', 'scientia_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_mailchimp_tgmpa_required_plugins' ) ) {
	
	function scientia_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( scientia_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && scientia_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => scientia_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'scientia_exists_mailchimp' ) ) {
	function scientia_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'scientia_mailchimp_frontend_scripts' ) ) {
	
	function scientia_mailchimp_frontend_scripts() {
		if ( scientia_is_on( scientia_get_theme_option( 'debug_mode' ) ) ) {
			$scientia_url = scientia_get_file_url( 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' );
			if ( '' != $scientia_url ) {
				wp_enqueue_style( 'scientia-mailchimp', $scientia_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'scientia_mailchimp_merge_styles' ) ) {
	
	function scientia_mailchimp_merge_styles( $list ) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( scientia_exists_mailchimp() ) {
	require_once SCIENTIA_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp-styles.php'; }

