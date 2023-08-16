<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

$scientia_template_args = get_query_var( 'scientia_template_args' );
if ( is_array( $scientia_template_args ) ) {
	$scientia_columns    = empty( $scientia_template_args['columns'] ) ? 2 : max( 1, $scientia_template_args['columns'] );
	$scientia_blog_style = array( $scientia_template_args['type'], $scientia_columns );
} else {
	$scientia_blog_style = explode( '_', scientia_get_theme_option( 'blog_style' ) );
	$scientia_columns    = empty( $scientia_blog_style[1] ) ? 2 : max( 1, $scientia_blog_style[1] );
}
$scientia_post_format = get_post_format();
$scientia_post_format = empty( $scientia_post_format ) ? 'standard' : str_replace( 'post-format-', '', $scientia_post_format );

?><div class="
<?php
if ( ! empty( $scientia_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $scientia_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $scientia_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $scientia_columns )
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
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

	$scientia_image_hover = ! empty( $scientia_template_args['hover'] ) && ! scientia_is_inherit( $scientia_template_args['hover'] )
								? $scientia_template_args['hover']
								: scientia_get_theme_option( 'image_hover' );
	// Featured image
	$f_args = array(
			'hover'         => $scientia_image_hover,
			'no_links'      => ! empty( $scientia_template_args['no_links'] ),
			'thumb_size'    => scientia_get_thumb_size(
				strpos( scientia_get_theme_option( 'body_style' ), 'full' ) !== false || $scientia_columns < 3
								? 'masonry-big'
				: 'masonry'
			),
			'show_no_image' => true,
			'class'         => 'dots' == $scientia_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $scientia_image_hover ? '<div class="post_info">' . esc_html( get_the_title() ) . '</div>' : '',
	);

	// Hiding thumbnail on galleries slider
	if( get_post_format() == 'gallery' && has_shortcode( get_the_content(), 'gallery' ) )
		$f_args['show_no_image'] = false;

	scientia_show_post_featured($f_args);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!