<?php
/**
 * The template file to display taxonomies archive
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.57
 */

// Redirect to the template page (if exists) for output current taxonomy
if ( is_category() || is_tag() || is_tax() ) {
	$scientia_term = get_queried_object();
	global $wp_query;
	if ( ! empty( $scientia_term->taxonomy ) && ! empty( $wp_query->posts[0]->post_type ) ) {
		$scientia_taxonomy  = scientia_get_post_type_taxonomy( $wp_query->posts[0]->post_type );
		if ( $scientia_taxonomy == $scientia_term->taxonomy ) {
			$scientia_template_page_id = scientia_get_template_page_id( array(
				'post_type'  => $wp_query->posts[0]->post_type,
				'parent_cat' => $scientia_term->term_id
			) );
			if ( 0 < $scientia_template_page_id ) {
				wp_safe_redirect( get_permalink( $scientia_template_page_id ) );
				exit;
			}
		}
	}
}
// If template page is not exists - display default blog archive template
get_template_part( apply_filters( 'scientia_filter_get_template_part', scientia_blog_archive_get_template() ) );
