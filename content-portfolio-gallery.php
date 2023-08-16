<?php
/**
 * The Gallery template to display posts
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
$scientia_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

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
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $scientia_columns )
	);
	scientia_add_blog_animation( $scientia_template_args );
	?>
	data-size="
		<?php
		if ( ! empty( $scientia_image[1] ) && ! empty( $scientia_image[2] ) ) {
			echo intval( $scientia_image[1] ) . 'x' . intval( $scientia_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $scientia_image[0] ) ) {
			echo esc_url( $scientia_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$scientia_image_hover = 'icon';
if ( in_array( $scientia_image_hover, array( 'icons', 'zoom' ) ) ) {
	$scientia_image_hover = 'dots';
}
$scientia_components = scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) );
scientia_show_post_featured(
	array(
		'hover'         => $scientia_image_hover,
		'no_links'      => ! empty( $scientia_template_args['no_links'] ),
		'thumb_size'    => scientia_get_thumb_size( strpos( scientia_get_theme_option( 'body_style' ), 'full' ) !== false || $scientia_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $scientia_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $scientia_components )
								? scientia_show_post_meta(
									apply_filters(
										'scientia_filter_post_meta_args', array(
											'components' => $scientia_components,
											'seo'      => false,
											'echo'     => false,
										), $scientia_blog_style[0], $scientia_columns
									)
								)
								: ''
								)
							. ( empty( $scientia_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $scientia_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'scientia' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
