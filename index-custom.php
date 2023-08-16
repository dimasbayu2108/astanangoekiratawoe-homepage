<?php
/**
 * The template for homepage posts with custom style
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.50
 */

scientia_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	$scientia_blog_style = scientia_get_theme_option( 'blog_style' );
	$scientia_parts      = explode( '_', $scientia_blog_style );
	$scientia_columns    = ! empty( $scientia_parts[1] ) ? max( 1, min( 6, (int) $scientia_parts[1] ) ) : 1;
	$scientia_blog_id    = scientia_get_custom_blog_id( $scientia_blog_style );
	$scientia_blog_meta  = scientia_get_custom_layout_meta( $scientia_blog_id );
	if ( ! empty( $scientia_blog_meta['margin'] ) ) {
		scientia_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( scientia_prepare_css_value( $scientia_blog_meta['margin'] ) ) ) );
	}
	$scientia_custom_style = ! empty( $scientia_blog_meta['scripts_required'] ) ? $scientia_blog_meta['scripts_required'] : 'none';

	scientia_blog_archive_start();

	$scientia_classes    = 'posts_container blog_custom_wrap' 
							. ( ! scientia_is_off( $scientia_custom_style )
								? sprintf( ' %s_wrap', $scientia_custom_style )
								: ( $scientia_columns > 1 
									? ' columns_wrap columns_padding_bottom' 
									: ''
									)
								);
	$scientia_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$scientia_sticky_out = scientia_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $scientia_stickies ) && count( $scientia_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $scientia_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $scientia_sticky_out ) {
		if ( scientia_get_theme_option( 'first_post_large' ) && ! is_paged() && ! in_array( scientia_get_theme_option( 'body_style' ), array( 'fullwide', 'fullscreen' ) ) ) {
			the_post();
			get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', 'excerpt' ), 'excerpt' );
		}
		?>
		<div class="<?php echo esc_attr( $scientia_classes ); ?>">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $scientia_sticky_out && ! is_sticky() ) {
			$scientia_sticky_out = false;
			?>
			</div><div class="<?php echo esc_attr( $scientia_classes ); ?>">
			<?php
		}
		$scientia_part = $scientia_sticky_out && is_sticky() ? 'sticky' : 'custom';
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', $scientia_part ), $scientia_part );
	}
	?>
	</div>
	<?php

	scientia_show_pagination();

	scientia_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
