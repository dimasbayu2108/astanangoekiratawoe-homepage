<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

scientia_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	scientia_blog_archive_start();

	?><div class="posts_container">
		<?php

		$scientia_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
		$scientia_sticky_out = scientia_get_theme_option( 'sticky_style' ) == 'columns'
								&& is_array( $scientia_stickies ) && count( $scientia_stickies ) > 0 && get_query_var( 'paged' ) < 1;
		if ( $scientia_sticky_out ) {
			?>
			<div class="sticky_wrap columns_wrap">
			<?php
		}
		while ( have_posts() ) {
			the_post();
			if ( $scientia_sticky_out && ! is_sticky() ) {
				$scientia_sticky_out = false;
				?>
				</div>
				<?php
			}
			$scientia_part = $scientia_sticky_out && is_sticky() ? 'sticky' : 'excerpt';
			get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', $scientia_part ), $scientia_part );
		}
		if ( $scientia_sticky_out ) {
			$scientia_sticky_out = false;
			?>
			</div>
			<?php
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
