<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

							// Widgets area inside page content
							scientia_create_widgets_area( 'widgets_below_content' );
							?>
						</div><!-- </.content> -->
					<?php

					// Show main sidebar
					get_sidebar();

					$scientia_body_style = scientia_get_theme_option( 'body_style' );
					?>
					</div><!-- </.content_wrap> -->
					<?php

					// Widgets area below page content and related posts below page content
					$scientia_widgets_name = scientia_get_theme_option( 'widgets_below_page' );
					$scientia_show_widgets = ! scientia_is_off( $scientia_widgets_name ) && is_active_sidebar( $scientia_widgets_name );
					$scientia_show_related = is_single() && scientia_get_theme_option( 'related_position' ) == 'below_page';
					if ( $scientia_show_widgets || $scientia_show_related ) {
						if ( 'fullscreen' != $scientia_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $scientia_show_related ) {
							do_action( 'scientia_action_related_posts' );
						}

						// Widgets area below page content
						if ( $scientia_show_widgets ) {
							scientia_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $scientia_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				scientia_show_post_banner('footer');
			}
			
			// Skip link anchor to fast access to the footer from keyboard
			?>
			<a id="footer_skip_link_anchor" class="scientia_skip_link_anchor" href="#"></a>
			<?php
			
			// Footer
			$scientia_footer_type = scientia_get_theme_option( 'footer_type' );
			if ( 'custom' == $scientia_footer_type && ! scientia_is_layouts_available() ) {
				$scientia_footer_type = 'default';
			}
			get_template_part( apply_filters( 'scientia_filter_get_template_part', "templates/footer-{$scientia_footer_type}" ) );
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>