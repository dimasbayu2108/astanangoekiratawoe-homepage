<div class="front_page_section front_page_section_googlemap<?php
	$scientia_scheme = scientia_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $scientia_scheme ) && ! scientia_is_inherit( $scientia_scheme ) ) {
		echo ' scheme_' . esc_attr( $scientia_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( scientia_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( scientia_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$scientia_css      = '';
		$scientia_bg_image = scientia_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$scientia_anchor_icon = scientia_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$scientia_anchor_text = scientia_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $scientia_anchor_icon ) || ! empty( $scientia_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $scientia_anchor_icon ) ? ' icon="' . esc_attr( $scientia_anchor_icon ) . '"' : '' )
									. ( ! empty( $scientia_anchor_text ) ? ' title="' . esc_attr( $scientia_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$scientia_layout = scientia_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $scientia_layout );
		if ( scientia_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' scientia-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$scientia_css      = '';
			$scientia_bg_mask  = scientia_get_theme_option( 'front_page_googlemap_bg_mask' );
			$scientia_bg_color_type = scientia_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $scientia_bg_color_type ) {
				$scientia_bg_color = scientia_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $scientia_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$scientia_caption     = scientia_get_theme_option( 'front_page_googlemap_caption' );
			$scientia_description = scientia_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $scientia_caption ) || ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $scientia_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $scientia_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $scientia_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $scientia_caption, 'scientia_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $scientia_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $scientia_description ), 'scientia_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $scientia_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$scientia_content = scientia_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $scientia_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $scientia_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $scientia_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $scientia_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $scientia_content, 'scientia_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $scientia_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $scientia_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
			<?php
			if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
				dynamic_sidebar( 'front_page_googlemap_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! scientia_exists_trx_addons() ) {
					scientia_customizer_need_trx_addons_message();
				} else {
					scientia_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
				}
			}
			?>
			</div>
			<?php

			if ( 'columns' == $scientia_layout && ( ! empty( $scientia_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
