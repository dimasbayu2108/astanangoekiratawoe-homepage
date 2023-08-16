<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.10
 */


// Socials
if ( scientia_is_on( scientia_get_theme_option( 'socials_in_footer' ) ) ) {
	$scientia_output = scientia_get_socials_links();
	if ( '' != $scientia_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php scientia_show_layout( $scientia_output ); ?>
			</div>
		</div>
		<?php
	}
}
