<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.14
 */
$scientia_header_video = scientia_get_header_video();
$scientia_embed_video  = '';
if ( ! empty( $scientia_header_video ) && ! scientia_is_from_uploads( $scientia_header_video ) ) {
	if ( scientia_is_youtube_url( $scientia_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $scientia_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php scientia_show_layout( scientia_get_embed_video( $scientia_header_video ) ); ?></div>
		<?php
	}
}
