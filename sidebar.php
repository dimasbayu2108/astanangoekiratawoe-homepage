<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

if ( scientia_sidebar_present() ) {
	ob_start();
	$scientia_sidebar_name = scientia_get_theme_option( 'sidebar_widgets' );
	scientia_storage_set( 'current_sidebar', 'sidebar' );
	if ( is_active_sidebar( $scientia_sidebar_name ) ) {
		dynamic_sidebar( $scientia_sidebar_name );
	}
	$scientia_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $scientia_out ) ) {
		$scientia_sidebar_position    = scientia_get_theme_option( 'sidebar_position' );
		$scientia_sidebar_position_ss = scientia_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $scientia_sidebar_position );
			echo ' sidebar_' . esc_attr( $scientia_sidebar_position_ss );

			if ( 'float' == $scientia_sidebar_position_ss ) {
				echo ' sidebar_float';
			}
			$scientia_sidebar_scheme = scientia_get_theme_option( 'sidebar_scheme' );
			if ( ! empty( $scientia_sidebar_scheme ) && ! scientia_is_inherit( $scientia_sidebar_scheme ) ) {
				echo ' scheme_' . esc_attr( $scientia_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php
			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="scientia_skip_link_anchor" href="#"></a>
			<?php
			// Single posts banner before sidebar
			scientia_show_post_banner( 'sidebar' );
			// Button to show/hide sidebar on mobile
			if ( in_array( $scientia_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$scientia_title = apply_filters( 'scientia_filter_sidebar_control_title', 'float' == $scientia_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'scientia' ) : '' );
				$scientia_text  = apply_filters( 'scientia_filter_sidebar_control_text', 'above' == $scientia_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'scientia' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $scientia_title ); ?>"><?php echo esc_html( $scientia_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'scientia_action_before_sidebar' );
				scientia_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $scientia_out ) );
				do_action( 'scientia_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
