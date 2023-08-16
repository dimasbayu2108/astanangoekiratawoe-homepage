<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.10
 */

// Logo
if ( scientia_is_on( scientia_get_theme_option( 'logo_in_footer' ) ) ) {
	$scientia_logo_image = scientia_get_logo_image( 'footer' );
	$scientia_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $scientia_logo_image['logo'] ) || ! empty( $scientia_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $scientia_logo_image['logo'] ) ) {
					$scientia_attr = scientia_getimagesize( $scientia_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $scientia_logo_image['logo'] ) . '"'
								. ( ! empty( $scientia_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $scientia_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'scientia' ) . '"'
								. ( ! empty( $scientia_attr[3] ) ? ' ' . wp_kses_data( $scientia_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $scientia_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $scientia_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
