<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( scientia_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

    <?php wp_body_open(); ?>

	<?php do_action( 'scientia_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">
			
			<?php
			// Short links to fast access to the content, sidebar and footer from the keyboard
			?>
			<a class="scientia_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to content", 'scientia' ); ?></a>
			<?php if ( scientia_sidebar_present() ) { ?>
			<a class="scientia_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to sidebar", 'scientia' ); ?></a>
			<?php } ?>
			<a class="scientia_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to footer", 'scientia' ); ?></a>
			
			<?php
			// Desktop header
			$scientia_header_type = scientia_get_theme_option( 'header_type' );
			if ( 'custom' == $scientia_header_type && ! scientia_is_layouts_available() ) {
				$scientia_header_type = 'default';
			}
			get_template_part( apply_filters( 'scientia_filter_get_template_part', "templates/header-{$scientia_header_type}" ) );

			// Side menu
			if ( in_array( scientia_get_theme_option( 'menu_style' ), array( 'left', 'right' ) ) ) {
				get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-navi-side' ) );
			}

			// Mobile menu
			get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/header-navi-mobile' ) );
			
			// Single posts banner after header
			scientia_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {

					scientia_show_post_banner( 'background' );

					$scientia_post_thumbnail_type  = scientia_get_theme_option( 'post_thumbnail_type' );
					$scientia_post_header_position = scientia_get_theme_option( 'post_header_position' );
					$scientia_post_header_align    = scientia_get_theme_option( 'post_header_align' );

					// Boxed post thumbnail
					if ( in_array( $scientia_post_thumbnail_type, array( 'boxed', 'fullwidth') ) ) {
						ob_start();
						?>
						<div class="header_content_wrap header_align_<?php echo esc_attr( $scientia_post_header_align ); ?>">
							<?php
							if ( 'boxed' === $scientia_post_thumbnail_type ) {
								?>
								<div class="content_wrap">
								<?php
							}

							// Post title and meta
							if ( 'above' === $scientia_post_header_position ) {
								scientia_show_post_title_and_meta();
							}

							// Featured image
							scientia_show_post_featured_image();

							// Post title and meta
							if ( in_array( $scientia_post_header_position, array( 'under', 'on_thumb' ) ) ) {
								scientia_show_post_title_and_meta();
							}

							if ( 'boxed' === $scientia_post_thumbnail_type ) {
								?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
						$scientia_post_header = ob_get_contents();
						ob_end_clean();
						if ( strpos( $scientia_post_header, 'post_featured' ) !== false
							|| strpos( $scientia_post_header, 'post_title' ) !== false
							|| strpos( $scientia_post_header, 'post_meta' ) !== false
						) {
							scientia_show_layout( $scientia_post_header );
						}
					}
				}

				// Widgets area above page content
				$scientia_body_style   = scientia_get_theme_option( 'body_style' );
				$scientia_widgets_name = scientia_get_theme_option( 'widgets_above_page' );
				$scientia_show_widgets = ! scientia_is_off( $scientia_widgets_name ) && is_active_sidebar( $scientia_widgets_name );
				if ( $scientia_show_widgets ) {
					if ( 'fullscreen' != $scientia_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					scientia_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $scientia_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}
				}

				// Content area
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $scientia_body_style ? '_fullscreen' : ''; ?>">

					<div class="content">
						<?php
						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="scientia_skip_link_anchor" href="#"></a>
						<?php
						// Widgets area inside page content
						scientia_create_widgets_area( 'widgets_above_content' );
