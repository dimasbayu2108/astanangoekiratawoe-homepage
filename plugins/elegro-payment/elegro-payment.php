<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'scientia_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'scientia_elegro_payment_theme_setup9', 9 );
	function scientia_elegro_payment_theme_setup9() {
		if ( scientia_exists_elegro_payment() ) {
            add_action( 'wp_enqueue_scripts', 'scientia_elegro_payment_frontend_scripts', 1100 );
			add_filter( 'scientia_filter_merge_styles', 'scientia_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'scientia_filter_tgmpa_required_plugins', 'scientia_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'scientia_elegro_payment_tgmpa_required_plugins' ) ) {
	function scientia_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( scientia_storage_isset( 'required_plugins', 'woocommerce' ) && scientia_storage_isset( 'required_plugins', 'elegro-payment' ) && scientia_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => scientia_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'scientia_exists_elegro_payment' ) ) {
	function scientia_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}

// Merge custom styles
if ( ! function_exists( 'scientia_elegro_payment_merge_styles' ) ) {
	function scientia_elegro_payment_merge_styles( $list ) {
		$list[] = 'plugins/elegro-payment/elegro-payment.scss';
		return $list;
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'scientia_elegro_payment_frontend_scripts' ) ) {

    function scientia_elegro_payment_frontend_scripts() {
        if ( scientia_is_on( scientia_get_theme_option( 'debug_mode' ) ) ) {
            $scientia_url = scientia_get_file_url( 'plugins/elegro-payment/elegro-payment.css' );
            if ( '' != $scientia_url ) {
                wp_enqueue_style( 'scientia-elegro-payment', $scientia_url, array(), null );
            }
        }
    }
}
