<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.10
 */

$scientia_footer_id = scientia_get_custom_footer_id();
$scientia_footer_meta = get_post_meta( $scientia_footer_id, 'trx_addons_options', true );
if ( ! empty( $scientia_footer_meta['margin'] ) ) {
	scientia_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( scientia_prepare_css_value( $scientia_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $scientia_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $scientia_footer_id ) ) ); ?>
						<?php
						$scientia_footer_scheme = scientia_get_theme_option( 'footer_scheme' );
						if ( ! empty( $scientia_footer_scheme ) && ! scientia_is_inherit( $scientia_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $scientia_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'scientia_action_show_layout', $scientia_footer_id );
	?>
</footer><!-- /.footer_wrap -->
