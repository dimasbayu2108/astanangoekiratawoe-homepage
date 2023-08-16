<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

scientia_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	scientia_blog_archive_start();

	$scientia_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$scientia_sticky_out = scientia_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $scientia_stickies ) && count( $scientia_stickies ) > 0 && get_query_var( 'paged' ) < 1;

	// Show filters
	$scientia_cat          = scientia_get_theme_option( 'parent_cat' );
	$scientia_post_type    = scientia_get_theme_option( 'post_type' );
	$scientia_taxonomy     = scientia_get_post_type_taxonomy( $scientia_post_type );
	$scientia_show_filters = scientia_get_theme_option( 'show_filters' );
	$scientia_tabs         = array();
	if ( ! scientia_is_off( $scientia_show_filters ) ) {
		$scientia_args           = array(
			'type'         => $scientia_post_type,
			'child_of'     => $scientia_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $scientia_taxonomy,
			'pad_counts'   => false,
		);
		$scientia_portfolio_list = get_terms( $scientia_args );
		if ( is_array( $scientia_portfolio_list ) && count( $scientia_portfolio_list ) > 0 ) {
			$scientia_tabs[ $scientia_cat ] = esc_html__( 'All', 'scientia' );
			foreach ( $scientia_portfolio_list as $scientia_term ) {
				if ( isset( $scientia_term->term_id ) ) {
					$scientia_tabs[ $scientia_term->term_id ] = $scientia_term->name;
				}
			}
		}
	}
	if ( count( $scientia_tabs ) > 0 ) {
		$scientia_portfolio_filters_ajax   = true;
		$scientia_portfolio_filters_active = $scientia_cat;
		$scientia_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters scientia_tabs scientia_tabs_ajax">
			<ul class="portfolio_titles scientia_tabs_titles">
				<?php
				foreach ( $scientia_tabs as $scientia_id => $scientia_title ) {
					?>
					<li><a href="<?php echo esc_url( scientia_get_hash_link( sprintf( '#%s_%s_content', $scientia_portfolio_filters_id, $scientia_id ) ) ); ?>" data-tab="<?php echo esc_attr( $scientia_id ); ?>"><?php echo esc_html( $scientia_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$scientia_ppp = scientia_get_theme_option( 'posts_per_page' );
			if ( scientia_is_inherit( $scientia_ppp ) ) {
				$scientia_ppp = '';
			}
			foreach ( $scientia_tabs as $scientia_id => $scientia_title ) {
				$scientia_portfolio_need_content = $scientia_id == $scientia_portfolio_filters_active || ! $scientia_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $scientia_portfolio_filters_id, $scientia_id ) ); ?>"
					class="portfolio_content scientia_tabs_content"
					data-blog-template="<?php echo esc_attr( scientia_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( scientia_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $scientia_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $scientia_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $scientia_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $scientia_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $scientia_cat ); ?>"
					data-need-content="<?php echo ( false === $scientia_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $scientia_portfolio_need_content ) {
						scientia_show_portfolio_posts(
							array(
								'cat'        => $scientia_id,
								'parent_cat' => $scientia_cat,
								'taxonomy'   => $scientia_taxonomy,
								'post_type'  => $scientia_post_type,
								'page'       => 1,
								'sticky'     => $scientia_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		scientia_show_portfolio_posts(
			array(
				'cat'        => $scientia_cat,
				'parent_cat' => $scientia_cat,
				'taxonomy'   => $scientia_taxonomy,
				'post_type'  => $scientia_post_type,
				'page'       => 1,
				'sticky'     => $scientia_sticky_out,
			)
		);
	}

	scientia_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
