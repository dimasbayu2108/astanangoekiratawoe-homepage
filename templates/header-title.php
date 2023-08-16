<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

// Page (category, tag, archive, author) title

if ( scientia_need_page_title() ) {
	scientia_sc_layouts_showed( 'title', true );
	scientia_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								scientia_show_post_meta(
									apply_filters(
										'scientia_filter_post_meta_args', array(
											'components' => scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) ),
											'counters'   => scientia_array_get_keys_by_value( scientia_get_theme_option( 'counters' ) ),
											'seo'        => scientia_is_on( scientia_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$scientia_blog_title           = scientia_get_blog_title();
							$scientia_blog_title_text      = '';
							$scientia_blog_title_class     = '';
							$scientia_blog_title_link      = '';
							$scientia_blog_title_link_text = '';
							if ( is_array( $scientia_blog_title ) ) {
								$scientia_blog_title_text      = $scientia_blog_title['text'];
								$scientia_blog_title_class     = ! empty( $scientia_blog_title['class'] ) ? ' ' . $scientia_blog_title['class'] : '';
								$scientia_blog_title_link      = ! empty( $scientia_blog_title['link'] ) ? $scientia_blog_title['link'] : '';
								$scientia_blog_title_link_text = ! empty( $scientia_blog_title['link_text'] ) ? $scientia_blog_title['link_text'] : '';
							} else {
								$scientia_blog_title_text = $scientia_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $scientia_blog_title_class ); ?>">
								<?php
								$scientia_top_icon = scientia_get_term_image_small();
								if ( ! empty( $scientia_top_icon ) ) {
									$scientia_attr = scientia_getimagesize( $scientia_top_icon );
									?>
									<img src="<?php echo esc_url( $scientia_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'scientia' ); ?>"
										<?php
										if ( ! empty( $scientia_attr[3] ) ) {
											scientia_show_layout( $scientia_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $scientia_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $scientia_blog_title_link ) && ! empty( $scientia_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $scientia_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $scientia_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						?>
						<div class="sc_layouts_title_breadcrumbs">
							<?php
							do_action( 'scientia_action_breadcrumbs' );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
