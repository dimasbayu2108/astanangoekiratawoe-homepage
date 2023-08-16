<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

$scientia_args = get_query_var( 'scientia_logo_args' );

// Site logo
$scientia_logo_type   = isset( $scientia_args['type'] ) ? $scientia_args['type'] : '';
$scientia_logo_image  = scientia_get_logo_image( $scientia_logo_type );
$scientia_logo_text   = scientia_is_on( scientia_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$scientia_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $scientia_logo_image['logo'] ) || ! empty( $scientia_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $scientia_logo_image['logo'] ) ) {
			if ( empty( $scientia_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric( $scientia_logo_image['logo'] ) && $scientia_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$scientia_attr = scientia_getimagesize( $scientia_logo_image['logo'] );
				echo '<img src="' . esc_url( $scientia_logo_image['logo'] ) . '"'
						. ( ! empty( $scientia_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $scientia_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $scientia_logo_text ) . '"'
						. ( ! empty( $scientia_attr[3] ) ? ' ' . wp_kses_data( $scientia_attr[3] ) : '' )
						. '>';
			}
		} else {
			scientia_show_layout( scientia_prepare_macros( $scientia_logo_text ), '<span class="logo_text">', '</span>' );
			scientia_show_layout( scientia_prepare_macros( $scientia_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
