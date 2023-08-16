<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.50
 */

$scientia_template_args = get_query_var( 'scientia_template_args' );
if ( is_array( $scientia_template_args ) ) {
	$scientia_columns    = empty( $scientia_template_args['columns'] ) ? 2 : max( 1, $scientia_template_args['columns'] );
	$scientia_blog_style = array( $scientia_template_args['type'], $scientia_columns );
} else {
	$scientia_blog_style = explode( '_', scientia_get_theme_option( 'blog_style' ) );
	$scientia_columns    = empty( $scientia_blog_style[1] ) ? 2 : max( 1, $scientia_blog_style[1] );
}
$scientia_blog_id       = scientia_get_custom_blog_id( join( '_', $scientia_blog_style ) );
$scientia_blog_style[0] = str_replace( 'blog-custom-', '', $scientia_blog_style[0] );
$scientia_expanded      = ! scientia_sidebar_present() && scientia_is_on( scientia_get_theme_option( 'expand_content' ) );
$scientia_components    = scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) );

$scientia_post_format   = get_post_format();
$scientia_post_format   = empty( $scientia_post_format ) ? 'standard' : str_replace( 'post-format-', '', $scientia_post_format );

$scientia_blog_meta     = scientia_get_custom_layout_meta( $scientia_blog_id );
$scientia_custom_style  = ! empty( $scientia_blog_meta['scripts_required'] ) ? $scientia_blog_meta['scripts_required'] : 'none';

if ( ! empty( $scientia_template_args['slider'] ) || $scientia_columns > 1 || ! scientia_is_off( $scientia_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $scientia_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( scientia_is_off( $scientia_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $scientia_custom_style ) ) . "-1_{$scientia_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_format_' . esc_attr( $scientia_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $scientia_columns )
					. ' post_layout_' . esc_attr( $scientia_blog_style[0] )
					. ' post_layout_' . esc_attr( $scientia_blog_style[0] ) . '_' . esc_attr( $scientia_columns )
					. ( ! scientia_is_off( $scientia_custom_style )
						? ' post_layout_' . esc_attr( $scientia_custom_style )
							. ' post_layout_' . esc_attr( $scientia_custom_style ) . '_' . esc_attr( $scientia_columns )
						: ''
						)
		);
	scientia_add_blog_animation( $scientia_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'scientia_action_show_layout', $scientia_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $scientia_template_args['slider'] ) || $scientia_columns > 1 || ! scientia_is_off( $scientia_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
