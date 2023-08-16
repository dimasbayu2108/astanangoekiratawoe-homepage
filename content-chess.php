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
	$scientia_columns    = empty( $scientia_template_args['columns'] ) ? 1 : max( 1, min( 3, $scientia_template_args['columns'] ) );
	$scientia_blog_style = array( $scientia_template_args['type'], $scientia_columns );
} else {
	$scientia_blog_style = explode( '_', scientia_get_theme_option( 'blog_style' ) );
	$scientia_columns    = empty( $scientia_blog_style[1] ) ? 1 : max( 1, min( 3, $scientia_blog_style[1] ) );
}
$scientia_expanded    = ! scientia_sidebar_present() && scientia_is_on( scientia_get_theme_option( 'expand_content' ) );
$scientia_post_format = get_post_format();
$scientia_post_format = empty( $scientia_post_format ) ? 'standard' : str_replace( 'post-format-', '', $scientia_post_format );

?><article id="post-<?php the_ID(); ?>"	data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item'
		. ' post_layout_chess'
		. ' post_layout_chess_' . esc_attr( $scientia_columns )
		. ' post_format_' . esc_attr( $scientia_post_format )
		. ( ! empty( $scientia_template_args['slider'] ) ? ' slider-slide swiper-slide' : '' )
	);
	scientia_add_blog_animation( $scientia_template_args );
	?>
>

	<?php
	// Add anchor

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
			'class'         => 1 == $scientia_columns && ! is_array( $scientia_template_args ) ? 'scientia-full-height' : '',
			'hover'         => $scientia_hover,
			'no_links'      => ! empty( $scientia_template_args['no_links'] ),
			'show_no_image' => true,
			'thumb_ratio'   => '1:1',
			'thumb_bg'      => true,
			'thumb_size'    => scientia_get_thumb_size(
				strpos( scientia_get_theme_option( 'body_style' ), 'full' ) !== false
										? ( 1 < $scientia_columns ? 'huge' : 'original' )
										: ( 2 < $scientia_columns ? 'big' : 'huge' )
			),
		)
	);

	?>
	<div class="post_inner"><div class="post_inner_content"><div class="post_header entry-header">
		<?php
			do_action( 'scientia_action_before_post_title' );

			// Post title
			if ( empty( $scientia_template_args['no_links'] ) ) {
				the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			} else {
				the_title( '<h3 class="post_title entry-title">', '</h3>' );
			}

			do_action( 'scientia_action_before_post_meta' );

			// Post meta
			$scientia_components = scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) );
			$scientia_post_meta  = empty( $scientia_components ) || in_array( $scientia_hover, array( 'border', 'pull', 'slide', 'fade' ) )
										? ''
										: scientia_show_post_meta(
											apply_filters(
												'scientia_filter_post_meta_args', array(
													'components' => $scientia_components,
													'seo'  => false,
													'echo' => false,
												), $scientia_blog_style[0], $scientia_columns
											)
										);
			scientia_show_layout( $scientia_post_meta );
			?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
			<?php
			// Post content area
			if ( empty( $scientia_template_args['hide_excerpt'] ) && scientia_get_theme_option( 'excerpt_length' ) > 0 ) {
				scientia_show_post_content( $scientia_template_args, '<div class="post_content_inner">', '</div>' );
			}
			// Post meta
			if ( in_array( $scientia_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				scientia_show_layout( $scientia_post_meta );
			}
			// More button
			if ( empty( $scientia_template_args['no_links'] ) && ! in_array( $scientia_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				scientia_show_post_more_link( $scientia_template_args, '<p>', '</p>' );
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
