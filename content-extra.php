<?php
/**
 * The extra template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

$scientia_template_args = get_query_var( 'scientia_template_args' );
if ( is_array( $scientia_template_args ) ) {
	$scientia_columns    = empty( $scientia_template_args['columns'] ) ? 1 : max( 1, $scientia_template_args['columns'] );
	$scientia_blog_style = array( $scientia_template_args['type'], $scientia_columns );
	if ( ! empty( $scientia_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $scientia_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $scientia_columns ); ?>">
		<?php
	}
}
$scientia_expanded    = ! scientia_sidebar_present() && scientia_is_on( scientia_get_theme_option( 'expand_content' ) );
$scientia_post_format = get_post_format();
$scientia_post_format = empty( $scientia_post_format ) ? 'standard' : str_replace( 'post-format-', '', $scientia_post_format );
$st = '';
if ( is_sticky() ) $st = ' sticky';
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_layout_extra post_format_' . esc_attr( $scientia_post_format ) . $st );
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
	$f_args = array(
			'no_links'   => ! empty( $scientia_template_args['no_links'] ),
			'hover'      => $scientia_hover,
			'thumb_size' => scientia_get_thumb_size( strpos( scientia_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $scientia_expanded ? 'huge' : 'big' ) ),
		);
	if ( !get_post_format() ) $f_args['thumb_bg'] = true;
	scientia_show_post_featured( $f_args );

	// Outputing quoite as featured element
	if ( get_post_format() == 'quote' ) scientia_show_post_content( $scientia_template_args, '<div class="post_layout_extra_quote">', '</div>' );

	// Title and post meta
	?> <div class="post_texts"> <?php
	$scientia_show_title = get_the_title() != '';
	$scientia_components = scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) );
	$scientia_show_meta  = ! empty( $scientia_components ) && ! in_array( $scientia_hover, array( 'border', 'pull', 'slide', 'fade' ) );
	if ( $scientia_show_title || $scientia_show_meta ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post meta
			if ( $scientia_show_meta ) {
				do_action( 'scientia_action_before_post_meta' );
				scientia_show_post_meta(
					apply_filters(
						'scientia_filter_post_meta_args', array(
							'components' => $scientia_components,
							'seo'        => false,
						), 'excerpt', 1
					)
				);
			}
			
			// Post title
			if ( $scientia_show_title ) {
				do_action( 'scientia_action_before_post_title' );
				if ( empty( $scientia_template_args['no_links'] ) ) {
					the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="post_title entry-title">', '</h2>' );
				}
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( empty( $scientia_template_args['hide_excerpt'] ) && scientia_get_theme_option( 'excerpt_length' ) > 0 ) {
		?>
		<div class="post_content entry-content">
			<?php
			if ( scientia_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'scientia_action_before_full_post_content' );
					the_content( '' );
					do_action( 'scientia_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'scientia' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'scientia' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				scientia_show_post_content( $scientia_template_args, '<div class="post_content_inner">', '</div>', 'quote' );
			}
			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
	</div>
</article>
<?php

if ( is_array( $scientia_template_args ) ) {
	if ( ! empty( $scientia_template_args['slider'] ) || $scientia_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
