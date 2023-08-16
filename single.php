<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

get_header();

while ( have_posts() ) {
	the_post();

	// Prepare theme-specific vars:

	// Full post loading
	$full_post_loading        = scientia_get_value_gp( 'action' ) == 'full_post_loading';

	// Prev post loading
	$prev_post_loading        = scientia_get_value_gp( 'action' ) == 'prev_post_loading';

	// Position of the related posts
	$scientia_related_position = scientia_get_theme_option( 'related_position' );

	// Type of the prev/next posts navigation
	$scientia_posts_navigation = scientia_get_theme_option( 'posts_navigation' );
	$scientia_prev_post        = false;

	if ( 'scroll' == $scientia_posts_navigation ) {
		$scientia_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $scientia_prev_post ) {
			$scientia_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $scientia_prev_post ) {
				$scientia_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $scientia_prev_post ) ) {
		scientia_storage_set_array( 'options_meta', 'post_thumbnail_type', 'default' );
		if ( scientia_get_theme_option( 'post_header_position' ) != 'below' ) {
			scientia_storage_set_array( 'options_meta', 'post_header_position', 'above' );
		}
		scientia_sc_layouts_showed( 'featured', false );
		scientia_sc_layouts_showed( 'title', false );
		scientia_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $scientia_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', get_post_format() ), get_post_format() );

	// If related posts should be inside the content
	if ( strpos( $scientia_related_position, 'inside' ) === 0 ) {
		$scientia_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'scientia_action_related_posts' );
		$scientia_related_content = ob_get_contents();
		ob_end_clean();

		$scientia_related_position_inside = max( 0, min( 9, scientia_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $scientia_related_position_inside ) {
			$scientia_related_position_inside = mt_rand( 1, 9 );
		}
		
		$scientia_p_number = 0;
		$scientia_related_inserted = false;
		for ( $i = 0; $i < strlen( $scientia_content ) - 3; $i++ ) {
			if ( $scientia_content[ $i ] == '<' && $scientia_content[ $i + 1 ] == 'p' && in_array( $scientia_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$scientia_p_number++;
				if ( $scientia_related_position_inside == $scientia_p_number ) {
					$scientia_related_inserted = true;
					$scientia_content = ( $i > 0 ? substr( $scientia_content, 0, $i ) : '' )
										. $scientia_related_content
										. substr( $scientia_content, $i );
				}
			}
		}
		if ( ! $scientia_related_inserted ) {
			$scientia_content .= $scientia_related_content;
		}

		scientia_show_layout( $scientia_content );
	}

	// Author bio
	if ( scientia_get_theme_option( 'show_author_info' ) == 1
		&& ! is_attachment()
		&& get_the_author_meta( 'description' )
		&& ( 'scroll' != $scientia_posts_navigation || scientia_get_theme_option( 'posts_navigation_scroll_hide_author' ) == 0 )
		&& ( ! $full_post_loading || scientia_get_theme_option( 'open_full_post_hide_author' ) == 0 )
	) {
		do_action( 'scientia_action_before_post_author' );
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'scientia_action_after_post_author' );
	}

	// Previous/next post navigation.
	if ( 'links' == $scientia_posts_navigation && ! $full_post_loading ) {
		do_action( 'scientia_action_before_post_navigation' );
		?>
		<div class="nav-links-single<?php
			if ( ! scientia_is_off( scientia_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation(
				array(
					'next_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'scientia' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'scientia' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
				)
			);
			?>
		</div>
		<?php
		do_action( 'scientia_action_after_post_navigation' );
	}

	// Related posts
	if ( 'below_content' == $scientia_related_position
		&& ( 'scroll' != $scientia_posts_navigation || scientia_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || scientia_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'scientia_action_related_posts' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	$scientia_comments_number = get_comments_number();
	if ( comments_open() || $scientia_comments_number > 0 ) {
		if ( scientia_get_value_gp( 'show_comments' ) == 1 || ( ! $full_post_loading && ( 'scroll' != $scientia_posts_navigation || scientia_get_theme_option( 'posts_navigation_scroll_hide_comments' ) == 0 || scientia_check_url( '#comment' ) ) ) ) {
			do_action( 'scientia_action_before_comments' );
			comments_template();
			do_action( 'scientia_action_after_comments' );
		} else {
			?>
			<div class="show_comments_single">
				<a href="<?php echo esc_url( add_query_arg( array( 'show_comments' => 1 ), get_comments_link() ) ); ?>" class="theme_button show_comments_button">
					<?php
					if ( $scientia_comments_number > 0 ) {
						echo esc_html( sprintf( ( ($scientia_comments_number === 1) ? esc_html__('Show comment', 'scientia') :  esc_html__('Show comments ( %d )', 'scientia') ), $scientia_comments_number ) );
					} else {
						esc_html_e( 'Leave a Reply', 'scientia' );
					}
					?>
				</a>
			</div>
			<?php
		}
	}

	if ( 'scroll' == $scientia_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $scientia_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $scientia_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $scientia_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
