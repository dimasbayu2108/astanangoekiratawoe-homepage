<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_booked_theme_setup9', 9 );
	function scientia_booked_theme_setup9() {
		if ( scientia_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'scientia_booked_frontend_scripts', 1100 );
			add_filter( 'scientia_filter_merge_styles', 'scientia_booked_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_booked_tgmpa_required_plugins' );
			add_filter( 'scientia_filter_theme_plugins', 'scientia_booked_theme_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_booked_tgmpa_required_plugins' ) ) {
	
	function scientia_booked_tgmpa_required_plugins( $list = array() ) {
		if ( scientia_storage_isset( 'required_plugins', 'booked' ) && scientia_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && scientia_is_theme_activated() ) {
			$path = scientia_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || scientia_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => scientia_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.3.5',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'scientia_booked_theme_plugins' ) ) {
	
	function scientia_booked_theme_plugins( $list = array() ) {
		if ( ! empty( $list['booked']['group'] ) ) {
			foreach ( $list as $k => $v ) {
				if ( substr( $k, 0, 6 ) == 'booked' ) {
					if ( empty( $v['group'] ) ) {
						$list[ $k ]['group'] = $list['booked']['group'];
					}
					if ( ! empty( $list['booked']['logo'] ) ) {
						$list[ $k ]['logo'] = strpos( $list['booked']['logo'], '//' ) !== false
												? $list['booked']['logo']
												: scientia_get_file_url( "plugins/booked/{$list['booked']['logo']}" );
					}
				}
			}
		}
		return $list;
	}
}



// Check if plugin installed and activated
if ( ! function_exists( 'scientia_exists_booked' ) ) {
	function scientia_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'scientia_booked_frontend_scripts' ) ) {
	
	function scientia_booked_frontend_scripts() {
		if ( scientia_is_on( scientia_get_theme_option( 'debug_mode' ) ) ) {
			$scientia_url = scientia_get_file_url( 'plugins/booked/booked.css' );
			if ( '' != $scientia_url ) {
				wp_enqueue_style( 'scientia-booked', $scientia_url, array(), null );
			}
		}
	}
}


// Merge custom styles
if ( ! function_exists( 'scientia_booked_merge_styles' ) ) {
	
	function scientia_booked_merge_styles( $list ) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( scientia_exists_booked() ) {
	require_once SCIENTIA_THEME_DIR . 'plugins/booked/booked-styles.php';
}
