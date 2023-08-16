<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( scientia_is_on( scientia_get_theme_option( 'front_page_enabled' ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$scientia_sections = scientia_array_get_keys_by_value( scientia_get_theme_option( 'front_page_sections' ), 1, false );
		if ( is_array( $scientia_sections ) ) {
			foreach ( $scientia_sections as $scientia_section ) {
				get_template_part( apply_filters( 'scientia_filter_get_template_part', 'front-page/section', $scientia_section ), $scientia_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'index' ) );
}

get_footer();
