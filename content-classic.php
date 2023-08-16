<?php
/**
 * The Classic template to display the content
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
$scientia_expanded   = ! scientia_sidebar_present() && scientia_is_on( scientia_get_theme_option( 'expand_content' ) );
$scientia_components = scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) );

$scientia_post_format = get_post_format();
$scientia_post_format = empty( $scientia_post_format ) ? 'standard' : str_replace( 'post-format-', '', $scientia_post_format );

?><div class="
<?php
if ( ! empty( $scientia_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( 'classic' == $scientia_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $scientia_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $scientia_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $scientia_columns )
				. ' post_layout_' . esc_attr( $scientia_blog_style[0] )
				. ' post_layout_' . esc_attr( $scientia_blog_style[0] ) . '_' . esc_attr( $scientia_columns )
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

	// Featured image
	$scientia_hover = ! empty( $scientia_template_args['hover'] ) && ! scientia_is_inherit( $scientia_template_args['hover'] )
						? $scientia_template_args['hover']
						: scientia_get_theme_option( 'image_hover' );
	scientia_show_post_featured(
		array(
			'thumb_size' => scientia_get_thumb_size(
				'classic' == $scientia_blog_style[0]
						? ( strpos( scientia_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $scientia_columns > 2 ? 'big' : 'huge' )
								: ( $scientia_columns > 2
									? ( $scientia_expanded ? 'med' : 'small' )
									: ( $scientia_expanded ? 'big' : 'med' )
									)
							)
						: ( strpos( scientia_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $scientia_columns > 2 ? 'masonry-big' : 'full' )
								: ( $scientia_columns <= 2 && $scientia_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $scientia_hover,
			'no_links'   => ! empty( $scientia_template_args['no_links'] ),
		)
	);

	if ( ! in_array( $scientia_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			do_action( 'scientia_action_before_post_title' );

			// Post title
			if ( empty( $scientia_template_args['no_links'] ) ) {
				the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			} else {
				the_title( '<h4 class="post_title entry-title">', '</h4>' );
			}

			do_action( 'scientia_action_before_post_meta' );

			// Post meta
			if ( ! empty( $scientia_components ) && ! in_array( $scientia_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
				scientia_show_post_meta(
					apply_filters(
						'scientia_filter_post_meta_args', array(
							'components' => $scientia_components,
							'seo'        => false,
						), $scientia_blog_style[0], $scientia_columns
					)
				);
			}

			do_action( 'scientia_action_after_post_meta' );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>

	<div class="post_content entry-content">
		<?php
		if ( empty( $scientia_template_args['hide_excerpt'] ) && scientia_get_theme_option( 'excerpt_length' ) > 0 ) {
			// Post content area
			scientia_show_post_content( $scientia_template_args, '<div class="post_content_inner">', '</div>' );
		}
		
		// Post meta
		if ( in_array( $scientia_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			if ( ! empty( $scientia_components ) ) {
				scientia_show_post_meta(
					apply_filters(
						'scientia_filter_post_meta_args', array(
							'components' => $scientia_components,
						), $scientia_blog_style[0], $scientia_columns
					)
				);
			}
		}
		
		// More button
		if ( empty( $scientia_template_args['no_links'] ) && ! empty( $scientia_template_args['more_text'] ) && ! in_array( $scientia_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			scientia_show_post_more_link( $scientia_template_args, '<p>', '</p>' );
		}
		?>
	</div><!-- .entry-content -->

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
