<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( scientia_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close theme_button_close"><span class="theme_button_close_icon"></span></a>
		<?php

		// Logo
		set_query_var( 'scientia_logo_args', array( 'type' => 'mobile' ) );
		get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'scientia_logo_args', array() );

		// Mobile menu
		$scientia_menu_mobile = scientia_get_nav_menu( 'menu_mobile' );
		if ( empty( $scientia_menu_mobile ) ) {
			$scientia_menu_mobile = apply_filters( 'scientia_filter_get_mobile_menu', '' );
			if ( empty( $scientia_menu_mobile ) ) {
				$scientia_menu_mobile = scientia_get_nav_menu( 'menu_main' );
				if ( empty( $scientia_menu_mobile ) ) {
					$scientia_menu_mobile = scientia_get_nav_menu();
				}
			}
		}
		if ( ! empty( $scientia_menu_mobile ) ) {
			$scientia_menu_mobile = str_replace(
				array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
				array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
				$scientia_menu_mobile
			);
			if ( strpos( $scientia_menu_mobile, '<nav ' ) === false ) {
				$scientia_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area">%s</nav>', $scientia_menu_mobile );
			}
			scientia_show_layout( apply_filters( 'scientia_filter_menu_mobile_layout', $scientia_menu_mobile ) );
		}

		// Search field
		do_action(
			'scientia_action_search',
			array(
				'style' => 'normal',
				'class' => 'search_mobile',
				'ajax'  => false
			)
		);

		// Social icons
		scientia_show_layout( scientia_get_socials_links(), '<div class="socials_mobile">', '</div>' );
		?>
	</div>
</div>
