<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

$scientia_link        = get_permalink();
$scientia_post_format = get_post_format();
$scientia_post_format = empty( $scientia_post_format ) ? 'standard' : str_replace( 'post-format-', '', $scientia_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $scientia_post_format ) ); ?>>
	<?php
	scientia_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'scientia_filter_related_thumb_size', scientia_get_thumb_size( (int) scientia_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( scientia_get_post_categories( ', ' ), 'scientia_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $scientia_link ) . '">' . wp_kses_data( get_the_title() ) . '</a></h6>'
									. ( in_array( get_post_type(), array( ) )
											? '<div class="post_meta"><a href="' . esc_url( $scientia_link ) . '" class="post_meta_item post_date">' . wp_kses_data( scientia_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
			'modern_mod'	=> true
		)
	);
	?>
</div>
