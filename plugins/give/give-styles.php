<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'scientia_give_get_css' ) ) {
	add_filter( 'scientia_filter_get_css', 'scientia_give_get_css', 10, 2 );
	function scientia_give_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS
form[id*="give-form"] .give-donation-amount .give-currency-symbol,
form[id*="give-form"] .give-donation-amount .give-currency-symbol.give-currency-position-before,
form[id*="give-form"] .give-donation-amount .give-currency-symbol.give-currency-position-after,
form[id*="give-form"] #give-final-total-wrap .give-donation-total-label,
#give-recurring-form .form-row input[type="email"],
#give-recurring-form .form-row input[type="password"],
#give-recurring-form .form-row input[type="tel"],
#give-recurring-form .form-row input[type="text"],
#give-recurring-form .form-row input[type="url"],
#give-recurring-form .form-row select,
#give-recurring-form .form-row textarea,
form.give-form .form-row input[type="email"],
form.give-form .form-row input[type="password"],
form.give-form .form-row input[type="tel"],
form.give-form .form-row input[type="text"],
form.give-form .form-row input[type="url"],
form.give-form .form-row select,
form.give-form .form-row textarea,
form[id*="give-form"] .form-row input[type="email"],
form[id*="give-form"] .form-row input[type="password"],
form[id*="give-form"] .form-row input[type="tel"],
form[id*="give-form"] .form-row input[type="text"],
form[id*="give-form"] .form-row input[type="url"],
form[id*="give-form"] .form-row select,
form[id*="give-form"] .form-row textarea,
form[id*="give-form"] .give-donation-amount #give-amount,
form[id*="give-form"] .give-donation-amount #give-amount-text,
form[id*="give-form"] #give-final-total-wrap .give-final-total-amount {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_line-height']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

.give-progress-bar > span {
	background-color: {$colors['text_link']} !important;
}

form[id*="give-form"] .give-donation-amount .give-currency-symbol,
form[id*="give-form"] .give-donation-amount .give-currency-symbol.give-currency-position-before,
form[id*="give-form"] .give-donation-amount .give-currency-symbol.give-currency-position-after,
form[id*="give-form"] #give-final-total-wrap .give-donation-total-label {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['input_bd_color']};
	color: {$colors['input_dark']};
}
#give-recurring-form .form-row input[type="email"],
#give-recurring-form .form-row input[type="password"],
#give-recurring-form .form-row input[type="tel"],
#give-recurring-form .form-row input[type="text"],
#give-recurring-form .form-row input[type="url"],
#give-recurring-form .form-row select,
#give-recurring-form .form-row textarea,
form.give-form .form-row input[type="email"],
form.give-form .form-row input[type="password"],
form.give-form .form-row input[type="tel"],
form.give-form .form-row input[type="text"],
form.give-form .form-row input[type="url"],
form.give-form .form-row select,
form.give-form .form-row textarea,
form[id*="give-form"] .form-row input[type="email"],
form[id*="give-form"] .form-row input[type="password"],
form[id*="give-form"] .form-row input[type="tel"],
form[id*="give-form"] .form-row input[type="text"],
form[id*="give-form"] .form-row input[type="url"],
form[id*="give-form"] .form-row select,
form[id*="give-form"] .form-row textarea,
form[id*="give-form"] .give-donation-amount #give-amount,
form[id*="give-form"] .give-donation-amount #give-amount-text,
form[id*="give-form"] #give-final-total-wrap .give-final-total-amount {
	background: {$colors['input_bg_color']};
	border-color: {$colors['input_bd_color']};
	color: {$colors['input_text']};	
}
#give-recurring-form .form-row input[type="email"]:focus,
#give-recurring-form .form-row input[type="password"]:focus,
#give-recurring-form .form-row input[type="tel"]:focus,
#give-recurring-form .form-row input[type="text"]:focus,
#give-recurring-form .form-row input[type="url"]:focus,
#give-recurring-form .form-row select:focus,
#give-recurring-form .form-row textarea:focus,
form.give-form .form-row input[type="email"]:focus,
form.give-form .form-row input[type="password"]:focus,
form.give-form .form-row input[type="tel"]:focus,
form.give-form .form-row input[type="text"]:focus,
form.give-form .form-row input[type="url"]:focus,
form.give-form .form-row select:focus,
form.give-form .form-row textarea:focus,
form[id*="give-form"] .form-row input[type="email"]:focus,
form[id*="give-form"] .form-row input[type="password"]:focus,
form[id*="give-form"] .form-row input[type="tel"]:focus,
form[id*="give-form"] .form-row input[type="text"]:focus,
form[id*="give-form"] .form-row input[type="url"]:focus,
form[id*="give-form"] .form-row select:focus,
form[id*="give-form"] .form-row textarea:focus,
form[id*="give-form"] .give-donation-amount #give-amount:focus,
form[id*="give-form"] .give-donation-amount #give-amount-text:focus {
	background: {$colors['input_bg_hover']};
	border-color: {$colors['input_bd_hover']};
	color: {$colors['input_dark']};	
}


CSS;
		}

		return $css;
	}
}

