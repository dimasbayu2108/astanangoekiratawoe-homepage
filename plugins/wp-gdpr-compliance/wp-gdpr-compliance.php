<?php
/* Cookie Information support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_wp_gdpr_compliance_feed_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_wp_gdpr_compliance_theme_setup9', 9 );
	function scientia_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	
	function scientia_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( scientia_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) && scientia_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'install' ) !== false ) {
			$list[] = array(
				'name'     => scientia_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'title' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'scientia_exists_wp_gdpr_compliance' ) ) {
	function scientia_exists_wp_gdpr_compliance() {
		return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}
