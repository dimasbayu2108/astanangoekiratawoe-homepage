<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.06
 */

$scientia_header_css   = '';
$scientia_header_image = get_header_image();
$scientia_header_video = scientia_get_header_video();
if ( ! empty( $scientia_header_image ) && scientia_trx_addons_featured_image_override( is_singular() || scientia_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$scientia_header_image = scientia_get_current_mode_image( $scientia_header_image );
}

$scientia_header_id = scientia_get_custom_header_id();
$scientia_header_meta = get_post_meta( $scientia_header_id, 'trx_addons_options', true );
if ( ! empty( $scientia_header_meta['margin'] ) ) {
	scientia_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( scientia_prepare_css_value( $scientia_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $scientia_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $scientia_header_id ) ) ); ?>
				<?php
				echo ! empty( $scientia_header_image ) || ! empty( $scientia_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $scientia_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $scientia_header_image ) {
					echo ' ' . esc_attr( scientia_add_inline_css_class( 'background-image: url(' . esc_url( $scientia_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( scientia_is_on( scientia_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight scientia-full-height';
				}
				$scientia_header_scheme = scientia_get_theme_option( 'header_scheme' );
				if ( ! empty( $scientia_header_scheme ) && ! scientia_is_inherit( $scientia_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $scientia_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $scientia_header_video ) ) {
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'scientia_action_show_layout', $scientia_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
