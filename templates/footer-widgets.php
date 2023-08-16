<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.10
 */

// Footer sidebar
$scientia_footer_name    = scientia_get_theme_option( 'footer_widgets' );
$scientia_footer_present = ! scientia_is_off( $scientia_footer_name ) && is_active_sidebar( $scientia_footer_name );
if ( $scientia_footer_present ) {
	scientia_storage_set( 'current_sidebar', 'footer' );
	$scientia_footer_wide = scientia_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $scientia_footer_name ) ) {
		dynamic_sidebar( $scientia_footer_name );
	}
	$scientia_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $scientia_out ) ) {
		$scientia_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $scientia_out );
		$scientia_need_columns = true;   //or check: strpos($scientia_out, 'columns_wrap')===false;
		if ( $scientia_need_columns ) {
			$scientia_columns = max( 0, (int) scientia_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $scientia_columns ) {
				$scientia_columns = min( 4, max( 1, scientia_tags_count( $scientia_out, 'aside' ) ) );
			}
			if ( $scientia_columns > 1 ) {
				$scientia_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $scientia_columns ) . ' widget', $scientia_out );
			} else {
				$scientia_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $scientia_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $scientia_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $scientia_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'scientia_action_before_sidebar' );
				scientia_show_layout( $scientia_out );
				do_action( 'scientia_action_after_sidebar' );
				if ( $scientia_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $scientia_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
