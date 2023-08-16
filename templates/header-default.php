<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

$scientia_header_css   = '';
$scientia_header_image = get_header_image();
$scientia_header_video = scientia_get_header_video();
if ( ! empty( $scientia_header_image ) && scientia_trx_addons_featured_image_override( is_singular() || scientia_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$scientia_header_image = scientia_get_current_mode_image( $scientia_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $scientia_header_image ) || ! empty( $scientia_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $scientia_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $scientia_header_image ) {
		echo ' ' . esc_attr( scientia_add_inline_css_class( 'background-image: url(' . esc_url( $scientia_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( scientia_is_on( scientia_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight scientia-full-height';
	}
	$scientia_header_scheme = scientia_get_theme_option( 'header_scheme' );
	if ( ! empty( $scientia_header_scheme ) && ! scientia_is_inherit( $scientia_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $scientia_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $scientia_header_video ) ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	if ( scientia_get_theme_option( 'menu_style' ) == 'top' ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-navi' ) );
	}

	// Mobile header
	if ( scientia_is_on( scientia_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-mobile' ) );
	}

	if ( !is_single() || ( scientia_get_theme_option( 'post_header_position' ) == 'default' && scientia_get_theme_option( 'post_thumbnail_type' ) == 'default' ) ) {
		// Page title and breadcrumbs area
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-title' ) );

		// Display featured image in the header on the single posts
		// Comment next line to prevent show featured image in the header area
		// and display it in the post's content
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-single' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
