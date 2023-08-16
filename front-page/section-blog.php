<div class="front_page_section front_page_section_blog<?php
	$scientia_scheme = scientia_get_theme_option( 'front_page_blog_scheme' );
	if ( ! empty( $scientia_scheme ) && ! scientia_is_inherit( $scientia_scheme ) ) {
		echo ' scheme_' . esc_attr( $scientia_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( scientia_get_theme_option( 'front_page_blog_paddings' ) );
	if ( scientia_get_theme_option( 'front_page_blog_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$scientia_css      = '';
		$scientia_bg_image = scientia_get_theme_option( 'front_page_blog_bg_image' );
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
	$scientia_anchor_icon = scientia_get_theme_option( 'front_page_blog_anchor_icon' );
	$scientia_anchor_text = scientia_get_theme_option( 'front_page_blog_anchor_text' );
if ( ( ! empty( $scientia_anchor_icon ) || ! empty( $scientia_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_blog"'
									. ( ! empty( $scientia_anchor_icon ) ? ' icon="' . esc_attr( $scientia_anchor_icon ) . '"' : '' )
									. ( ! empty( $scientia_anchor_text ) ? ' title="' . esc_attr( $scientia_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_blog_inner
	<?php
	if ( scientia_get_theme_option( 'front_page_blog_fullheight' ) ) {
		echo ' scientia-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$scientia_css      = '';
			$scientia_bg_mask  = scientia_get_theme_option( 'front_page_blog_bg_mask' );
			$scientia_bg_color_type = scientia_get_theme_option( 'front_page_blog_bg_color_type' );
			if ( 'custom' == $scientia_bg_color_type ) {
				$scientia_bg_color = scientia_get_theme_option( 'front_page_blog_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$scientia_caption = scientia_get_theme_option( 'front_page_blog_caption' );
			if ( ! empty( $scientia_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo ! empty( $scientia_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $scientia_caption, 'scientia_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$scientia_description = scientia_get_theme_option( 'front_page_blog_description' );
			if ( ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo ! empty( $scientia_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $scientia_description ), 'scientia_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_blog_output">
			<?php
			if ( is_active_sidebar( 'front_page_blog_widgets' ) ) {
				dynamic_sidebar( 'front_page_blog_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! scientia_exists_trx_addons() ) {
					scientia_customizer_need_trx_addons_message();
				} else {
					scientia_customizer_need_widgets_message( 'front_page_blog_caption', 'ThemeREX Addons - Blogger' );
				}
			}
			?>
			</div>
		</div>
	</div>
</div>
