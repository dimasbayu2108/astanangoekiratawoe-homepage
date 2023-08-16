<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

if ( get_query_var( 'scientia_header_image' ) == '' && scientia_trx_addons_featured_image_override( is_singular() && has_post_thumbnail() && in_array( get_post_type(), array( 'post', 'page' ) ) ) ) {
	$scientia_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if ( ! empty( $scientia_src[0] ) ) {
		scientia_sc_layouts_showed( 'featured', true );
		?>
		<div class="sc_layouts_featured with_image without_content <?php echo esc_attr( scientia_add_inline_css_class( 'background-image:url(' . esc_url( $scientia_src[0] ) . ');' ) ); ?>"></div>
		<?php
	}
}
