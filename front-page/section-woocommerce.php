<div class="front_page_section front_page_section_woocommerce<?php
	$scientia_scheme = scientia_get_theme_option( 'front_page_woocommerce_scheme' );
	if ( ! empty( $scientia_scheme ) && ! scientia_is_inherit( $scientia_scheme ) ) {
		echo ' scheme_' . esc_attr( $scientia_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( scientia_get_theme_option( 'front_page_woocommerce_paddings' ) );
	if ( scientia_get_theme_option( 'front_page_woocommerce_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$scientia_css      = '';
		$scientia_bg_image = scientia_get_theme_option( 'front_page_woocommerce_bg_image' );
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
	$scientia_anchor_icon = scientia_get_theme_option( 'front_page_woocommerce_anchor_icon' );
	$scientia_anchor_text = scientia_get_theme_option( 'front_page_woocommerce_anchor_text' );
if ( ( ! empty( $scientia_anchor_icon ) || ! empty( $scientia_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_woocommerce"'
									. ( ! empty( $scientia_anchor_icon ) ? ' icon="' . esc_attr( $scientia_anchor_icon ) . '"' : '' )
									. ( ! empty( $scientia_anchor_text ) ? ' title="' . esc_attr( $scientia_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner
	<?php
	if ( scientia_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
		echo ' scientia-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$scientia_css      = '';
			$scientia_bg_mask  = scientia_get_theme_option( 'front_page_woocommerce_bg_mask' );
			$scientia_bg_color_type = scientia_get_theme_option( 'front_page_woocommerce_bg_color_type' );
			if ( 'custom' == $scientia_bg_color_type ) {
				$scientia_bg_color = scientia_get_theme_option( 'front_page_woocommerce_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$scientia_caption     = scientia_get_theme_option( 'front_page_woocommerce_caption' );
			$scientia_description = scientia_get_theme_option( 'front_page_woocommerce_description' );
			if ( ! empty( $scientia_caption ) || ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $scientia_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $scientia_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $scientia_caption, 'scientia_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description (text)
				if ( ! empty( $scientia_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $scientia_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $scientia_description ), 'scientia_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
			<?php
				$scientia_woocommerce_sc = scientia_get_theme_option( 'front_page_woocommerce_products' );
			if ( 'products' == $scientia_woocommerce_sc ) {
				$scientia_woocommerce_sc_ids      = scientia_get_theme_option( 'front_page_woocommerce_products_per_page' );
				$scientia_woocommerce_sc_per_page = count( explode( ',', $scientia_woocommerce_sc_ids ) );
			} else {
				$scientia_woocommerce_sc_per_page = max( 1, (int) scientia_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
			}
				$scientia_woocommerce_sc_columns = max( 1, min( $scientia_woocommerce_sc_per_page, (int) scientia_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
				echo do_shortcode(
					"[{$scientia_woocommerce_sc}"
									. ( 'products' == $scientia_woocommerce_sc
											? ' ids="' . esc_attr( $scientia_woocommerce_sc_ids ) . '"'
											: '' )
									. ( 'product_category' == $scientia_woocommerce_sc
											? ' category="' . esc_attr( scientia_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
											: '' )
									. ( 'best_selling_products' != $scientia_woocommerce_sc
											? ' orderby="' . esc_attr( scientia_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
												. ' order="' . esc_attr( scientia_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
											: '' )
									. ' per_page="' . esc_attr( $scientia_woocommerce_sc_per_page ) . '"'
									. ' columns="' . esc_attr( $scientia_woocommerce_sc_columns ) . '"'
					. ']'
				);
				?>
			</div>
		</div>
	</div>
</div>
