<div class="front_page_section front_page_section_contacts<?php
	$scientia_scheme = scientia_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $scientia_scheme ) && ! scientia_is_inherit( $scientia_scheme ) ) {
		echo ' scheme_' . esc_attr( $scientia_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( scientia_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( scientia_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$scientia_css      = '';
		$scientia_bg_image = scientia_get_theme_option( 'front_page_contacts_bg_image' );
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
	$scientia_anchor_icon = scientia_get_theme_option( 'front_page_contacts_anchor_icon' );
	$scientia_anchor_text = scientia_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $scientia_anchor_icon ) || ! empty( $scientia_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $scientia_anchor_icon ) ? ' icon="' . esc_attr( $scientia_anchor_icon ) . '"' : '' )
									. ( ! empty( $scientia_anchor_text ) ? ' title="' . esc_attr( $scientia_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( scientia_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' scientia-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$scientia_css      = '';
			$scientia_bg_mask  = scientia_get_theme_option( 'front_page_contacts_bg_mask' );
			$scientia_bg_color_type = scientia_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $scientia_bg_color_type ) {
				$scientia_bg_color = scientia_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$scientia_caption     = scientia_get_theme_option( 'front_page_contacts_caption' );
			$scientia_description = scientia_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $scientia_caption ) || ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $scientia_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $scientia_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $scientia_caption, 'scientia_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $scientia_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $scientia_description ), 'scientia_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$scientia_content = scientia_get_theme_option( 'front_page_contacts_content' );
			$scientia_layout  = scientia_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $scientia_layout && ( ! empty( $scientia_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $scientia_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $scientia_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $scientia_content, 'scientia_kses_content' );
				?>
				</div>
				<?php
			}

			if ( 'columns' == $scientia_layout && ( ! empty( $scientia_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$scientia_sc = scientia_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $scientia_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $scientia_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					scientia_show_layout( do_shortcode( $scientia_sc ) );
				?>
				</div>
				<?php
			}

			if ( 'columns' == $scientia_layout && ( ! empty( $scientia_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
