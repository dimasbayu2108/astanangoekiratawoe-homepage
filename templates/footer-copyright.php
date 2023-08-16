<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$scientia_copyright_scheme = scientia_get_theme_option( 'copyright_scheme' );
if ( ! empty( $scientia_copyright_scheme ) && ! scientia_is_inherit( $scientia_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $scientia_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$scientia_copyright = scientia_get_theme_option( 'copyright' );
			if ( ! empty( $scientia_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$scientia_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $scientia_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$scientia_copyright = scientia_prepare_macros( $scientia_copyright );
				// Display copyright
				echo wp_kses( nl2br( $scientia_copyright ), 'scientia_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
