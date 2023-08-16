<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.1
 */

$scientia_theme_obj = wp_get_theme();
?>
<div class="scientia_admin_notice scientia_welcome_notice update-nag">
	<?php
	// Theme image
	$scientia_theme_img = scientia_get_file_url( 'screenshot.jpg' );
	if ( '' != $scientia_theme_img ) {
		?>
		<div class="scientia_notice_image"><img src="<?php echo esc_url( $scientia_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'scientia' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="scientia_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				esc_html__( 'Welcome to %1$s v.%2$s', 'scientia' ),
				$scientia_theme_obj->name . ( SCIENTIA_THEME_FREE ? ' ' . esc_html__( 'Free', 'scientia' ) : '' ),
				$scientia_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="scientia_notice_text">
		<p class="scientia_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $scientia_theme_obj->description ) );
			?>
		</p>
		<p class="scientia_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'scientia' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="scientia_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=scientia_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'scientia' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" class="scientia_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="scientia_hide_notice_text"><?php esc_html_e( 'Dismiss', 'scientia' ); ?></span></a>
	</div>
</div>
