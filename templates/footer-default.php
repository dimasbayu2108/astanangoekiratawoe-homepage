<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$scientia_footer_scheme = scientia_get_theme_option( 'footer_scheme' );
if ( ! empty( $scientia_footer_scheme ) && ! scientia_is_inherit( $scientia_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $scientia_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/footer-socials' ) );

	// Menu
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/footer-menu' ) );

	// Copyright area
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
