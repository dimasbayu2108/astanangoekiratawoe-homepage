<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

// Header sidebar
$scientia_header_name    = scientia_get_theme_option( 'header_widgets' );
$scientia_header_present = ! scientia_is_off( $scientia_header_name ) && is_active_sidebar( $scientia_header_name );
if ( $scientia_header_present ) {
	scientia_storage_set( 'current_sidebar', 'header' );
	$scientia_header_wide = scientia_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $scientia_header_name ) ) {
		dynamic_sidebar( $scientia_header_name );
	}
	$scientia_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $scientia_widgets_output ) ) {
		$scientia_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $scientia_widgets_output );
		$scientia_need_columns   = strpos( $scientia_widgets_output, 'columns_wrap' ) === false;
		if ( $scientia_need_columns ) {
			$scientia_columns = max( 0, (int) scientia_get_theme_option( 'header_columns' ) );
			if ( 0 == $scientia_columns ) {
				$scientia_columns = min( 6, max( 1, scientia_tags_count( $scientia_widgets_output, 'aside' ) ) );
			}
			if ( $scientia_columns > 1 ) {
				$scientia_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $scientia_columns ) . ' widget', $scientia_widgets_output );
			} else {
				$scientia_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $scientia_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $scientia_header_wide ) {
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
				scientia_show_layout( $scientia_widgets_output );
				do_action( 'scientia_action_after_sidebar' );
				if ( $scientia_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $scientia_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
