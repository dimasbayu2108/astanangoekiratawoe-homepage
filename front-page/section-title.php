<?php
$scientia_slider_sc = scientia_get_theme_option( 'front_page_title_shortcode' );
if ( ! empty( $scientia_slider_sc ) && strpos( $scientia_slider_sc, '[' ) !== false && strpos( $scientia_slider_sc, ']' ) !== false ) {

	?><div class="front_page_section front_page_section_title front_page_section_slider front_page_section_title_slider
		<?php
		if ( scientia_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
	">
	<?php
		// Add anchor
		$scientia_anchor_icon = scientia_get_theme_option( 'front_page_title_anchor_icon' );
		$scientia_anchor_text = scientia_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $scientia_anchor_icon ) || ! empty( $scientia_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $scientia_anchor_icon ) ? ' icon="' . esc_attr( $scientia_anchor_icon ) . '"' : '' )
									. ( ! empty( $scientia_anchor_text ) ? ' title="' . esc_attr( $scientia_anchor_text ) . '"' : '' )
									. ']'
		);
	}
		// Show slider (or any other content, generated by shortcode)
		echo do_shortcode( $scientia_slider_sc );
	?>
	</div>
	<?php

} else {

	?>
	<div class="front_page_section front_page_section_title
		<?php
		$scientia_scheme = scientia_get_theme_option( 'front_page_title_scheme' );
		if ( ! empty( $scientia_scheme ) && ! scientia_is_inherit( $scientia_scheme ) ) {
			echo ' scheme_' . esc_attr( $scientia_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( scientia_get_theme_option( 'front_page_title_paddings' ) );
		if ( scientia_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
		"
		<?php
		$scientia_css      = '';
		$scientia_bg_image = scientia_get_theme_option( 'front_page_title_bg_image' );
		if ( ! empty( $scientia_bg_image ) ) {
			$scientia_css .= 'background-image: url(' . esc_url( scientia_get_attachment_url( $scientia_bg_image ) ) . ');';
		}
		if ( ! empty( $scientia_css ) ) {
			echo ' style="' . esc_attr( $scientia_css ) . '"';
		}
		?>
	>
	<?php
		// Add anchor
		$scientia_anchor_icon = scientia_get_theme_option( 'front_page_title_anchor_icon' );
		$scientia_anchor_text = scientia_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $scientia_anchor_icon ) || ! empty( $scientia_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $scientia_anchor_icon ) ? ' icon="' . esc_attr( $scientia_anchor_icon ) . '"' : '' )
									. ( ! empty( $scientia_anchor_text ) ? ' title="' . esc_attr( $scientia_anchor_text ) . '"' : '' )
									. ']'
		);
	}
	?>
		<div class="front_page_section_inner front_page_section_title_inner
		<?php
		if ( scientia_get_theme_option( 'front_page_title_fullheight' ) ) {
			echo ' scientia-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
			"
			<?php
			$scientia_css      = '';
			$scientia_bg_mask  = scientia_get_theme_option( 'front_page_title_bg_mask' );
			$scientia_bg_color_type = scientia_get_theme_option( 'front_page_title_bg_color_type' );
			if ( 'custom' == $scientia_bg_color_type ) {
				$scientia_bg_color = scientia_get_theme_option( 'front_page_title_bg_color' );
			} elseif ( 'scheme_bg_color' == $scientia_bg_color_type ) {
				$scientia_bg_color = scientia_get_scheme_color( 'bg_color', $scientia_scheme );
			} else {
				$scientia_bg_color = '';
			}
			if ( ! empty( $scientia_bg_color ) && $scientia_bg_mask > 0 ) {
				$scientia_css .= 'background-color: ' . esc_attr(
					1 == $scientia_bg_mask ? $scientia_bg_color : scientia_hex2rgba( $scientia_bg_color, $scientia_bg_mask )
				) . ';';
			}
			if ( ! empty( $scientia_css ) ) {
				echo ' style="' . esc_attr( $scientia_css ) . '"';
			}
			?>
		>
			<div class="front_page_section_content_wrap front_page_section_title_content_wrap content_wrap">
				<?php
				// Caption
				$scientia_caption = scientia_get_theme_option( 'front_page_title_caption' );
				if ( ! empty( $scientia_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h1 class="front_page_section_caption front_page_section_title_caption front_page_block_<?php echo ! empty( $scientia_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $scientia_caption, 'scientia_kses_content' ); ?></h1>
					<?php
				}

				// Description (text)
				$scientia_description = scientia_get_theme_option( 'front_page_title_description' );
				if ( ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_title_description front_page_block_<?php echo ! empty( $scientia_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $scientia_description ), 'scientia_kses_content' ); ?></div>
					<?php
				}

				// Buttons
				if ( scientia_get_theme_option( 'front_page_title_button1_link' ) != '' || scientia_get_theme_option( 'front_page_title_button2_link' ) != '' ) {
					?>
					<div class="front_page_section_buttons front_page_section_title_buttons">
					<?php
						scientia_show_layout( scientia_customizer_partial_refresh_front_page_title_button1_link() );
						scientia_show_layout( scientia_customizer_partial_refresh_front_page_title_button2_link() );
					?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
