<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'SCIENTIA_THEME_FREE' ) ) {
	define( 'SCIENTIA_THEME_FREE', false );
}
if ( ! defined( 'SCIENTIA_THEME_FREE_WP' ) ) {
	define( 'SCIENTIA_THEME_FREE_WP', false );
}

// If this theme is a part of Envato Elements
if ( ! defined( 'SCIENTIA_THEME_IN_ENVATO_ELEMENTS' ) ) {
	define( 'SCIENTIA_THEME_IN_ENVATO_ELEMENTS', false );
}

// If this theme uses multiple skins
if ( ! defined( 'SCIENTIA_ALLOW_SKINS' ) ) {
	define( 'SCIENTIA_ALLOW_SKINS', false );
}
if ( ! defined( 'SCIENTIA_DEFAULT_SKIN' ) ) {
	define( 'SCIENTIA_DEFAULT_SKIN', 'default' );
}



// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
//-------------------------------------------------------------------------
$GLOBALS['SCIENTIA_STORAGE'] = array(

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'       => 'env-themerex',

	// Generate Personal token from Envato to automatic upgrade theme
	'upgrade_token_url'   => '//build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'      => '//scientia.themerex.net',
	'theme_doc_url'       => '//scientia.themerex.net/doc',

	'theme_upgrade_url'   => '//upgrade.themerex.net/',

	'theme_demofiles_url' => '//demofiles.themerex.net/scientia/', 
	
	'theme_rate_url'      => '//themeforest.net/download',

	'theme_custom_url' => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash',

	'theme_download_url'  => 'https://themeforest.net/item/scientia-public-library-wordpress-theme/24685526',        // ThemeREX

	'theme_support_url'   => '//themerex.net/support/',                    // ThemeREX

	'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // ThemeREX

	'theme_privacy_url'   => '//themerex.net/privacy-policy/',                   // ThemeREX

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'    => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'          => array(
		// By size
		'xxl'        => array( 'max' => 1679 ),
		'xl'         => array( 'max' => 1439 ),
		'lg'         => array( 'max' => 1279 ),
		'md_over'    => array( 'min' => 1024 ),
		'md'         => array( 'max' => 1023 ),
		'sm'         => array( 'max' => 767 ),
		'sm_wp'      => array( 'max' => 600 ),
		'xs'         => array( 'max' => 479 ),
		// By device
		'wide'       => array(
			'min' => 2160
		),
		'desktop'    => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook'   => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'     => array(
			'min' => 768,
			'max' => 1279,
		),
		'not_mobile' => array(
			'min' => 768
		),
		'mobile'     => array(
			'max' => 767
		),
	),
);


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'scientia_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'scientia_importer_set_options', 9 );
	function scientia_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url( scientia_get_protocol() . ':' . scientia_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( scientia_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'Scientia Demo', 'scientia' );
			$options['files']['default']['domain_dev']  = esc_url( scientia_get_protocol() . '://trex3.dev.themerex.dnw' );                     // Developers domain
			$options['files']['default']['domain_demo'] = esc_url( scientia_get_protocol() . ':' . scientia_storage_get( 'theme_demo_url' ) );   // Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			
			// The array with theme-specific banners, displayed during demo-content import.
			// If array with banners is empty - the banners are uploaded directly from demo-content server.
			$options['banners'] = array();
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'scientia_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'scientia_ocdi_set_options', 9 );
	function scientia_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( scientia_get_protocol() . ':' . scientia_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( scientia_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Scientia OCDI Demo', 'scientia' );
			$options['files']['ocdi']['domain_demo'] = esc_url( scientia_get_protocol() . ':' . scientia_storage_get( 'theme_demo_url' ) );
			// If theme need more demo - just copy 'default' and change required parameter
		}
		return $options;
	}
}



// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
// Section: "CORE" (required plugins)
$scientia_theme_required_plugins_group = esc_html__( 'Core', 'scientia' );
$scientia_theme_required_plugins = array(
    // DON'T COMMENT OR REMOVE NEXT LINES!
    'trx_addons'         => array(
        'title'       => esc_html__( 'ThemeREX Addons', 'scientia' ),
        'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'scientia' ),
        'required'    => true,
        'logo'        => 'logo.png',
        'group'       => $scientia_theme_required_plugins_group,
    )
);

// Section: "PAGE BUILDERS"
$scientia_theme_required_plugins_group = esc_html__( 'Page Builders', 'scientia' );
$scientia_theme_required_plugins['elementor'] = array(
	'title'       => esc_html__( 'Elementor', 'scientia' ),
	'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'scientia' ),
	'required'    => false,
	'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
	'logo'        => 'logo.png',
	'group'       => $scientia_theme_required_plugins_group,
);
$scientia_theme_required_plugins['gutenberg'] = array(
	'title'       => esc_html__( 'Gutenberg', 'scientia' ),
	'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'scientia' ),
	'required'    => false,
	'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
	'logo'        => 'logo.png',
	'group'       => $scientia_theme_required_plugins_group,
);
if ( ! SCIENTIA_THEME_FREE ) {
	$scientia_theme_required_plugins['js_composer']          = array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'scientia' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'scientia' ),
		'required'    => false,
		'logo'        => 'logo.jpg',
		'group'       => $scientia_theme_required_plugins_group,
	);
}

// Section: "SOCIALS & COMMUNITIES"
$scientia_theme_required_plugins_group = esc_html__( 'Socials and Communities', 'scientia' );
$scientia_theme_required_plugins['mailchimp-for-wp'] = array(
	'title'       => esc_html__( 'MailChimp for WP', 'scientia' ),
	'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'scientia' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $scientia_theme_required_plugins_group,
);

// Section: "E-COMMERCE"
$scientia_theme_required_plugins_group = esc_html__( 'E-Commerce', 'scientia' );
$scientia_theme_required_plugins['woocommerce']              = array(
	'title'       => esc_html__( 'WooCommerce', 'scientia' ),
	'description' => esc_html__( "Connect the store to your website and start selling now", 'scientia' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $scientia_theme_required_plugins_group,
);
$scientia_theme_required_plugins['elegro-payment']              = array(
	'title'       => esc_html__( 'Elegro Payment', 'scientia' ),
	'description' => esc_html__( "Elegro Gateway provides facilities for smooth, safe and instant cryptocurrency payments with automated exchange.", 'scientia' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $scientia_theme_required_plugins_group,
);

// Section: "EVENTS & TIMELINES"
$scientia_theme_required_plugins_group = esc_html__( 'Events and Appointments', 'scientia' );
if ( ! SCIENTIA_THEME_FREE ) {
	$scientia_theme_required_plugins['booked']                 = array(
		'title'       => esc_html__( 'Booked Appointments', 'scientia' ),
		'description' => 'Adds appointment booking capabilities to your website',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $scientia_theme_required_plugins_group,
	);
	$scientia_theme_required_plugins['the-events-calendar']    = array(
		'title'       => esc_html__( 'The Events Calendar', 'scientia' ),
		'description' => 'Allows to create an events calendar and manage it with ease',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $scientia_theme_required_plugins_group,
	);
}

// Section: "CONTENT"
$scientia_theme_required_plugins_group = esc_html__( 'Content', 'scientia' );
$scientia_theme_required_plugins['contact-form-7'] = array(
	'title'       => esc_html__( 'Contact Form 7', 'scientia' ),
	'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'scientia' ),
	'required'    => false,
	'logo'        => 'logo.jpg',
	'group'       => $scientia_theme_required_plugins_group,
);
if ( ! SCIENTIA_THEME_FREE ) {
	$scientia_theme_required_plugins['essential-grid']             = array(
		'title'       => esc_html__( 'Essential Grid', 'scientia' ),
		'description' => '#1 Grid Gallery Building Solution - Essential Grid WordPress Plugin',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $scientia_theme_required_plugins_group,
	);
	$scientia_theme_required_plugins['sitepress-multilingual-cms'] = array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'scientia' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'scientia' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.png',
		'group'       => $scientia_theme_required_plugins_group,
	);
}

// Section: "OTHER"
$scientia_theme_required_plugins_group = esc_html__( 'Other', 'scientia' );
$scientia_theme_required_plugins['trx_updater'] = array(
	'title'       => esc_html__( 'ThemeREX Updater', 'scientia' ),
	'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'scientia' ),
	'required'    => false,
	'logo'        => 'trx_updater.png',
	'group'       => $scientia_theme_required_plugins_group,
);
$scientia_theme_required_plugins['wp-gdpr-compliance'] = array(
	'title'       => esc_html__( 'Cookie Information', 'scientia' ),
	'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'scientia' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $scientia_theme_required_plugins_group,
);
$scientia_theme_required_plugins['mapplic'] = array(
    'title'       => esc_html__( 'Mapplic', 'scientia' ),
    'description' => esc_html__( "Mapplic is the #1 custom map WordPress plugin on the web. Turn simple images and vector graphics into high quality, responsive and fully interactive maps", 'scientia' ),
    'required'    => false,
    'logo'        => 'logo.png',
    'group'       => $scientia_theme_required_plugins_group,
);
if ( ! SCIENTIA_THEME_FREE ) {
	$scientia_theme_required_plugins['give']          = array(
		'title'       => esc_html__( 'Give Donations', 'scientia' ),
		'description' => 'Allows to accept donations on your website with flexibility and ease',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $scientia_theme_required_plugins_group,
	);
}

// Add plugins list to the global storage
$GLOBALS['SCIENTIA_STORAGE']['required_plugins'] = $scientia_theme_required_plugins;



// THEME-SPECIFIC BLOG LAYOUTS
//----------------------------------------------
$scientia_theme_blog_styles = array(
	'excerpt' => array(
		'title'   => esc_html__( 'Standard', 'scientia' ),
		'archive' => 'index-excerpt',
		'item'    => 'content-excerpt',
		'styles'  => 'excerpt',
	),
	'classic' => array(
		'title'   => esc_html__( 'Classic', 'scientia' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'classic',
	),
	'extra' => array(
		'title'   => esc_html__( 'Extra', 'scientia' ),
		'archive' => 'index-extra',
		'item'    => 'content-extra',
		'styles'  => 'extra',
	),
);
if ( ! SCIENTIA_THEME_FREE ) {
	$scientia_theme_blog_styles['masonry']   = array(
		'title'   => esc_html__( 'Masonry', 'scientia' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'masonry',
	);
	$scientia_theme_blog_styles['portfolio'] = array(
		'title'   => esc_html__( 'Portfolio', 'scientia' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio',
		'columns' => array( 2, 3, 4 ),
		'styles'  => 'portfolio',
	);
	$scientia_theme_blog_styles['gallery']   = array(
		'title'   => esc_html__( 'Gallery', 'scientia' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio-gallery',
		'columns' => array( 2, 3, 4 ),
		'styles'  => array( 'portfolio', 'gallery' ),
	);
	$scientia_theme_blog_styles['chess']     = array(
		'title'   => esc_html__( 'Chess', 'scientia' ),
		'archive' => 'index-chess',
		'item'    => 'content-chess',
		'columns' => array( 1, 2, 3 ),
		'styles'  => 'chess',
	);
}

// Add list of blog styles to the global storage
$GLOBALS['SCIENTIA_STORAGE']['blog_styles'] = $scientia_theme_blog_styles;


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'scientia_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'scientia_customizer_theme_setup1', 1 );
	function scientia_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		scientia_storage_set(
			'settings', array(

				'duplicate_options'      => 'child',                    // none  - use separate options for the main and the child-theme
																		// child - duplicate theme options from the main theme to the child-theme only
																		// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'      => 'auto',                     // Refresh method for preview area in the Appearance - Customize:
																		// auto - refresh preview area on change each field with Theme Options
																		// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'max_load_fonts'         => 5,                          // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'     => true,                       // Place 'comment' field after the 'name' and 'email'

				'show_author_avatar'     => false,                       // Display author's avatar in the post meta

				'icons_selector'         => 'internal',                 // Icons selector in the shortcodes:
																		// vc (default) - standard VC (very slow) or Elementor's icons selector (not support images and svg)
																		// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'             => 'icons',                    // Type of icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present icons
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'           => 'icons',                    // Type of socials icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present social networks
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'      => true,                       // Check if exists a .min version of .css and .js and return path to it
																		// instead the path to the original file
																		// (if debug_mode is on and modification time of the original file < time of the .min file)

				'autoselect_menu'        => false,                      // Show any menu if no menu selected in the location 'main_menu'
																		// (for example, the theme is just activated)

				'disable_jquery_ui'      => false,                      // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'      => true,                       // Load script "Media Elements" to play video and audio

				'tgmpa_upload'           => false,                      // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'         => false,                      // Allow to use theme-specific image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'       => true,                       // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'       => false,                      // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																		// In the Page Options this styles are present always
																		// (can be removed if filter 'scientia_filter_allow_fullscreen' return false)

				'attachments_navigation' => false,                      // Add arrows on the single attachment page to navigate to the prev/next attachment

				'gutenberg_safe_mode'    => array(),                    // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'gutenberg_add_context'  => false,                      // Add context to the Gutenberg editor styles with our method (if true - use if any problem with editor styles) or use native Gutenberg way via add_editor_style() (if false - used by default)

				'allow_gutenberg_blocks' => true,                       // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'   => true,                       // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx'        => 'replace',                  // Add our breakpoints to the Responsive section of each element
																		// 'add' - add our breakpoints after Elementor's
																		// 'replace' - add our breakpoints instead Elementor's
																		// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		scientia_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Roboto',
					'family' => 'sans-serif',
					'styles' => '300,300italic,400,400italic,700,700italic',     // Parameter 'style' used only for the Google fonts
				),
				// Google font
				array(
					'name'   => 'Roboto Slab',
					'family' => 'sans-serif',
					'styles' => '100,300,400,700',
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		scientia_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!

		scientia_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'scientia' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'scientia' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.143rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.6em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.3em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '5.143rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.23em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.5em',
					'margin-bottom'   => '.48em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '3.929rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.5em',
					'margin-bottom'   => '.5em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '2.571rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '2.4em',
					'margin-bottom'   => '.7em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '2.143rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.24em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '2.8em',
					'margin-bottom'   => '.7em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '1.714rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.35em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '3.6em',
					'margin-bottom'   => '.8em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '1.286rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.3em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '4.9em',
					'margin-bottom'   => '.7em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'scientia' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '1.8em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'scientia' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'capitalize',
					'letter-spacing'  => '0.01em',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'scientia' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'scientia' ),
					'font-family'     => 'inherit',
					'font-size'       => '1em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'scientia' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'scientia' ),
					'font-family'     => 'inherit',
					'font-size'       => '0.9286em',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'scientia' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '1.2rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => 'initial',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0em',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'scientia' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'scientia' ),
					'font-family'     => '"Roboto Slab",sans-serif',
					'font-size'       => '1em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => 'initial',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0em',
				),
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		scientia_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'scientia' ),
					'description' => esc_html__( 'Colors of the main content area', 'scientia' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'scientia' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'scientia' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'scientia' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'scientia' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'scientia' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'scientia' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'scientia' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'scientia' ),
				),
			)
		);
		scientia_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'scientia' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'scientia' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'scientia' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'scientia' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'scientia' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'scientia' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'scientia' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'scientia' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'scientia' ),
					'description' => esc_html__( 'Color of the plain text inside this block', 'scientia' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'scientia' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'scientia' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'scientia' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'scientia' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'scientia' ),
					'description' => esc_html__( 'Color of the links inside this block', 'scientia' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'scientia' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'scientia' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'scientia' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'scientia' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'scientia' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'scientia' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'scientia' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'scientia' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'scientia' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'scientia' ),
				),
			)
		);
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'scientia' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', // changed
					'bd_color'         => '#eae7e4', // changed

					// Text and links colors
					'text'             => '#5e5e5e', // changed
					'text_light'       => '#999999', // changed
					'text_dark'        => '#1b1b1b', // changed
					'text_link'        => '#f3701d', // changed
					'text_hover'       => '#e23826', // changed
					'text_link2'       => '#80d572',
					'text_hover2'      => '#8be77c',
					'text_link3'       => '#ddb837',
					'text_hover3'      => '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#f2f0ee', // changed
					'alter_bg_hover'   => '#eae7e4', // changed
					'alter_bd_color'   => '#eae7e4', // changed
					'alter_bd_hover'   => '#f2f0ee',
					'alter_text'       => '#5e5e5e', // changed
					'alter_light'      => '#999999', // changed
					'alter_dark'       => '#1b1b1b', // changed
					'alter_link'       => '#f3701d', // changed
					'alter_hover'      => '#e23826', // changed
					'alter_link2'      => '#8be77c',
					'alter_hover2'     => '#80d572',
					'alter_link3'      => '#eec432',
					'alter_hover3'     => '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1b1b1b', // changed
					'extra_bg_hover'   => '#28272e',
					'extra_bd_color'   => '#373737', // changed
					'extra_bd_hover'   => '#7C7C7C', // changed
					'extra_text'       => '#5e5e5e', // changed
					'extra_light'      => '#999999', // changed
					'extra_dark'       => '#999999', // changed
					'extra_link'       => '#ffffff', // changed
					'extra_hover'      => '#fe7259',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#f3701d', // changed
					'extra_hover3'     => '#1b1b1b', // changed

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#eae7e4', // changed
					'input_bg_hover'   => '#eae7e4', // changed
					'input_bd_color'   => '#e7eaed',
					'input_bd_hover'   => '#eae7e4', // changed
					'input_text'       => '#5e5e5e', // changed
					'input_light'      => '#a7a7a7',
					'input_dark'       => '#1b1b1b', // changed

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#ffffff', // changed
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#1b1b1b', // changed
					'inverse_link'     => '#ffffff', // changed
					'inverse_hover'    => '#ffffff', // changed
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'scientia' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#212121', // changed
					'bd_color'         => '#2d2b2b', // changed

					// Text and links colors
					'text'             => '#9F9F9F', // changed
					'text_light'       => '#7c7c7c', // changed
					'text_dark'        => '#ffffff', // changed
					'text_link'        => '#f3701d', // changed
					'text_hover'       => '#e23826', // changed
					'text_link2'       => '#80d572',
					'text_hover2'      => '#8be77c',
					'text_link3'       => '#ddb837',
					'text_hover3'      => '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#1b1b1b', // changed
					'alter_bg_hover'   => '#2d2c2c', // changed
					'alter_bd_color'   => '#373535', // changed
					'alter_bd_hover'   => '#ffffff',
					'alter_text'       => '#7c7c7c', // changed
					'alter_light'      => '#7c7c7c', // changed
					'alter_dark'       => '#ffffff', // changed
					'alter_link'       => '#f3701d', // changed
					'alter_hover'      => '#e23826', // changed
					'alter_link2'      => '#8be77c',
					'alter_hover2'     => '#80d572',
					'alter_link3'      => '#eec432',
					'alter_hover3'     => '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#ffffff', // changed
					'extra_bg_hover'   => '#f3f5f7', // changed
					'extra_bd_color'   => '#464646',
					'extra_bd_hover'   => '#5e5e5e', // changed
					'extra_text'       => '#1e2f3c', // changed
					'extra_light'      => '#7c7c7c', // changed
					'extra_dark'       => '#7c7c7c', // changed
					'extra_link'       => '#1e2f3c', // changed
					'extra_hover'      => '#fe7259',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ffffff', // changed
					'extra_hover3'     => '#ffffff', // changed

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#292929', // changed
					'input_bg_hover'   => '#292929', // changed
					'input_bd_color'   => '#312f2f', // changed
					'input_bd_hover'   => '#312f2f', // changed
					'input_text'       => '#7c7c7c', // changed
					'input_light'      => '#6f6f6f',
					'input_dark'       => '#ffffff', // changed

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#ffffff', // changed
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#1e2f3c', // changed
					'inverse_link'     => '#ffffff', // changed
					'inverse_hover'    => '#ffffff', // changed
				),
			),
		);
		scientia_storage_set( 'schemes', $schemes );
		scientia_storage_set( 'schemes_original', $schemes );
		
		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		scientia_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		scientia_storage_set(
			'scheme_colors_add', array(
				'extra_bd_color_01'        => array(
					'color' => 'extra_bd_color',
					'alpha' => 0.1,
				),
				'extra_bg_color_005'        => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.05,
				),
				'extra_bg_color_08'        => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.8,
				),
				'extra_bg_color_03'        => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.3,
				),
				'alter_dark_005'        => array(
					'color' => 'alter_dark',
					'alpha' => 0.05,
				),
				'extra_hover3_005'        => array(
					'color' => 'extra_hover3',
					'alpha' => 0.05,
				),
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'inverse_text_02'       => array(
					'color' => 'inverse_text',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'input_bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_hover_03'      => array(
					'color' => 'text_hover',
					'alpha' => 0.3,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Parameters to set order of schemes in the css
		scientia_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		scientia_storage_set(
			'theme_thumbs', apply_filters(
				'scientia_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'scientia-thumb-huge'        => array(
						'size'  => array( 1278, 719, true ),
						'title' => esc_html__( 'Huge image', 'scientia' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'scientia-thumb-big'         => array(
						'size'  => array( 842, 474, true ),
						'title' => esc_html__( 'Large image', 'scientia' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'scientia-thumb-med'         => array(
						'size'  => array( 406, 228, true ),
						'title' => esc_html__( 'Medium image', 'scientia' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'scientia-thumb-tiny'        => array(
						'size'  => array( 90, 90, true ),
						'title' => esc_html__( 'Small square avatar', 'scientia' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'scientia-thumb-masonry-big' => array(
						'size'  => array( 760, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'scientia' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'scientia-thumb-masonry'     => array(
						'size'  => array( 370, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'scientia' ),
						'subst' => 'trx_addons-thumb-masonry',
					),

					'scientia-thumb-teams-tile'     => array(
						'size'  => array( 298, 350, true ),     // Only downscale, not crop
						'title' => esc_html__( 'Teams Tile', 'scientia' ),
						'subst' => 'trx_addons-avatar',
					),
				)
			)
		);
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'scientia_create_theme_options' ) ) {

	function scientia_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'scientia' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( scientia_storage_get( 'schemes' ) ) < 2;

		scientia_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'scientia' ),
					'desc'     => '',
					'priority' => 10,
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'scientia' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'scientia' ) ),
					'class'    => 'scientia_column-1_2 scientia_new_row',
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'scientia' ) ),
					'class'    => 'scientia_column-1_2',
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_zoom'                     => array(
					'title'   => esc_html__( 'Logo zoom', 'scientia' ),
					'desc'    => wp_kses_post(
									__( 'Zoom the logo (set 1 to leave original size).', 'scientia' )
									. ' <br>'
									. __( 'Attention! For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header.', 'scientia' )
									. ' <br>'
									. __( 'In this case maximum size of logo depends on the actual size of the picture.', 'scientia' )
								),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'scientia' ) ),
					'class'      => 'scientia_column-1_2',
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'scientia' ) ),
					'class' => 'scientia_column-1_2 scientia_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'scientia' ) ),
					'class'      => 'scientia_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'scientia' ) ),
					'class' => 'scientia_column-1_2 scientia_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'scientia' ) ),
					'class'      => 'scientia_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'image',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'scientia' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'scientia' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'scientia' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => scientia_get_list_body_styles( false ),
					'type'     => 'select',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'scientia' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1278,
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page',               // SASS variable's name to preview changes 'on fly'
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'scientia' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => 60,
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'scientia' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'scientia' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Remove margins', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Remove margins above and below the content area', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'type'     => 'checkbox',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'scientia' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'scientia' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'scientia' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'scientia' ) ),
					'std'        => 367,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'scientia' ) ),
					'std'        => 70,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'scientia' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'scientia' ),
					'desc'  => '',
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'scientia' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => 'hidden',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'scientia' ),
					'desc'  => '',
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'scientia' ) ),
					'std'   => 0,
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'scientia'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'scientia') ),
					"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'scientia'), 'scientia_kses_content' ),
					"type"  => "text"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'scientia' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'std'      => 'default',
					'options'  => scientia_get_list_header_footer_types(),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'scientia' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'scientia' ), 'scientia_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill the whole screen. Used only if the header has a background image', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'std'      => 0,
					'type'     => 'hidden',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'scientia' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'scientia' ) ),
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'scientia' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'select',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'dependency' => array(
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => scientia_get_list_range( 0, 6 ),
					'type'       => 'select',
				),

				'menu_info'                     => array(
					'title' => esc_html__( 'Main menu', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select main menu style, position and other parameters', 'scientia' ) ),
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_style'                    => array(
					'title'    => esc_html__( 'Menu position', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position of the main menu', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'std'      => 'top',
					'options'  => array(
						'top'   => esc_html__( 'Top', 'scientia' ),
					),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'scientia' ) ),
					'std'   => 1,
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'scientia' ),
					'desc'  => '',
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'scientia' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'scientia' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'std'      => 0,
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'scientia' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'scientia' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'scientia' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'scientia' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'scientia' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'scientia' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => 'hidden',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'scientia' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'scientia' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => 'hidden',
				),



				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'scientia' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'scientia' ),
					),
					'std'      => 'default',
					'options'  => scientia_get_list_header_footer_types(),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'scientia' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'scientia' ), 'scientia_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'scientia' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'footer-custom-elementor-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'scientia' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'scientia' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => scientia_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'scientia' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'scientia' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'scientia' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'scientia' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'scientia' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! scientia_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'scientia' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'scientia' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'scientia' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => scientia_get_list_header_footer_types( true ),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'scientia' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'scientia' ), 'scientia_kses_content' ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'scientia' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Expand content', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden on mobile devices', 'scientia' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => scientia_get_list_header_footer_types( true ),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'scientia' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'scientia' ), 'scientia_kses_content' ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'scientia' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'scientia' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => scientia_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'scientia' ) ),
					'priority' => 70,
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'scientia' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'scientia' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'scientia' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'scientia' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'scientia' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'scientia' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'scientia' ),
						'fullpost' => esc_html__( 'Full post', 'scientia' ),
					),
					'type'       => 'switch',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'scientia' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 12,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'scientia' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'scientia' ) ),
					'std'     => 2,
					'options' => scientia_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'scientia' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'scientia' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => esc_html__( 'Page numbers', 'scientia' ),
						'links'    => esc_html__( 'Older/Newest', 'scientia' ),
						'more'     => esc_html__( 'Load more', 'scientia' ),
						'infinite' => esc_html__( 'Infinite scroll', 'scientia' ),
					),
					'type'       => 'select',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'std'        => 'none',
					'options'    => array(),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
						'blog_style'     => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'open_full_post_in_blog'        => array(
					'title'      => esc_html__( 'Open full post in blog', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the blog feed. Attention! Applies only to 1 column layouts!', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'std'        => 0,
					'type'       => 'hidden',
				),
				'open_full_post_hide_author'    => array(
					'title'      => esc_html__( 'Hide author bio', 'scientia' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when open the full version of the post directly in the blog feed.", 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'open_full_post_hide_related'   => array(
					'title'      => esc_html__( 'Hide related posts', 'scientia' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when open the full version of the post directly in the blog feed.", 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => scientia_get_list_header_footer_types( true ),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'scientia' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'scientia' ), 'scientia_kses_content' ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => 'hidden',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'scientia' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'scientia' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'scientia' ),
					'type'    => 'switch',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'scientia' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'scientia' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'scientia' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'scientia' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'scientia' ),
					'desc'  => '',
					'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'scientia' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'scientia' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'scientia' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'scientia' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'scientia' ),
					'desc'  => wp_kses_data( __( "Select or upload an image used as placeholder for posts without a featured image. Placeholder is used on the blog stream page only (no placeholder in single post), and only in those styles of it where non-using featured image doesn't seem appropriate.", 'scientia' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'scientia' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'scientia' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'scientia' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'scientia' ),
						'columns' => esc_html__( 'Mini-cards', 'scientia' ),
					),
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'scientia' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'scientia' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'.components-select-control:not(.post-author-selector) select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=0|views=0|likes=0|comments=0|author=0|share=0|edit=0',
					'options'    => scientia_get_list_meta_parts(),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checklist',
				),


				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'scientia' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => scientia_get_list_header_footer_types( true ),
					'type'     => SCIENTIA_THEME_FREE || ! scientia_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'scientia' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'scientia' ), 'scientia_kses_content' ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_single'      => array(
					'title'    => esc_html__( 'Header fullheight', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'scientia' ) ),
					'std'      => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => 'hidden',
				),
				'header_wide_single'            => array(
					'title'      => esc_html__( 'Header fullwidth', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'scientia' ) ),
					'dependency' => array(
						'header_type_single' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'scientia' ) ),
					'std'     => 'right',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'options' => array(),
					'type'    => 'switch',
				),
				'sidebar_position_ss_single'=> array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'scientia' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'           => array(
					'title'   => esc_html__( 'Expand content', 'scientia' ),
					'desc'    => wp_kses_data( __( 'Expand the content width on the single posts if the sidebar is hidden', 'scientia' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => scientia_get_list_checkbox_values( true ),
					'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_title_info'      => array(
					'title' => esc_html__( 'Featured image and title', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'hide_featured_on_single'       => array(
					'title'    => esc_html__( 'Hide featured image on the single post', 'scientia' ),
					'desc'     => wp_kses_data( __( "Hide featured image on the single post's pages", 'scientia' ) ),
					'override' => array(
						'mode'    => 'page,post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'post_thumbnail_type'      => array(
					'title'      => esc_html__( 'Type of post thumbnail', 'scientia' ),
					'desc'       => wp_kses_data( __( "Select type of post thumbnail on the single post's pages", 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 ),
					),
					'std'        => 'default',
					'options'    => array(
						'fullwidth'   => esc_html__( 'Fullwidth', 'scientia' ),
						'boxed'       => esc_html__( 'Boxed', 'scientia' ),
						'default'     => esc_html__( 'Default', 'scientia' ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_position'          => array(
					'title'      => esc_html__( 'Post header position', 'scientia' ),
					'desc'       => wp_kses_data( __( "Select post header position on the single post's pages", 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 )
					),
					'std'        => 'under',
					'options'    => array(
						'above'      => esc_html__( 'Above the post thumbnail', 'scientia' ),
						'under'      => esc_html__( 'Under the post thumbnail', 'scientia' ),
						'on_thumb'   => esc_html__( 'On the post thumbnail', 'scientia' ),
						'default'    => esc_html__( 'Default', 'scientia' ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_align'             => array(
					'title'      => esc_html__( 'Align of the post header', 'scientia' ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'post_header_position' => array( 'on_thumb' ),
					),
					'std'        => 'mc',
					'options'    => array(
						'ts' => esc_html__('Top Stick Out', 'scientia'),
						'tl' => esc_html__('Top Left', 'scientia'),
						'tc' => esc_html__('Top Center', 'scientia'),
						'tr' => esc_html__('Top Right', 'scientia'),
						'ml' => esc_html__('Middle Left', 'scientia'),
						'mc' => esc_html__('Middle Center', 'scientia'),
						'mr' => esc_html__('Middle Right', 'scientia'),
						'bl' => esc_html__('Bottom Left', 'scientia'),
						'bc' => esc_html__('Bottom Center', 'scientia'),
						'br' => esc_html__('Bottom Right', 'scientia'),
						'bs' => esc_html__('Bottom Stick Out', 'scientia'),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'scientia' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'scientia' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'scientia' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'scientia' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'scientia' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=1|author=1|views=0|likes=0|comments=0|share=0|edit=0',
					'options'    => scientia_get_list_meta_parts(),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'scientia' ) ),
					'std'   => 1,
					'type'  => ! scientia_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'scientia' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'scientia' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'scientia' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'std'      => 1,
					'type'     => 'checkbox',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'modern',
					'options'    => array(
						'modern'  => esc_html__( 'Modern', 'scientia' ),
						'classic' => esc_html__( 'Classic', 'scientia' ),
						'list'    => esc_html__( 'List', 'scientia' ),
						'short'   => esc_html__( 'Short', 'scientia' ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'scientia' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'scientia' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'scientia' ),
						'below_content' => esc_html__( 'After the content', 'scientia' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'scientia' ),
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => scientia_get_list_range( 0, 9 ),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'scientia' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'min'        => 1,
					'max'        => 9,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'scientia' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page?', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 2,
					'options'    => scientia_get_list_range( 1, 6 ),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'scientia'),
						'side'    => esc_html__('Side', 'scientia'),
						'outside' => esc_html__('Outside', 'scientia'),
						'top'     => esc_html__('Top', 'scientia'),
						'bottom'  => esc_html__('Bottom', 'scientia')
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'scientia'),
						'bottom'  => esc_html__('Bottom', 'scientia')
					),
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Space between slides', 'scientia' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'scientia' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'text',
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Posts navigation', 'scientia' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'posts_navigation'           => array(
					'title'   => esc_html__( 'Show posts navigation', 'scientia' ),
					'desc'    => wp_kses_data( __( "Show posts navigation on the single post's pages", 'scientia' ) ),
					'std'     => 'none',
					'options' => array(
						'none'   => esc_html__('None', 'scientia'),
						'links'  => esc_html__('Prev/Next links', 'scientia'),
						'scroll' => esc_html__('Infinite scroll', 'scientia')
					),
					'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_fixed'     => array(
					'title'      => esc_html__( 'Fixed posts navigation', 'scientia' ),
					'desc'       => wp_kses_data( __( "Make posts navigation fixed position. Display it when the content of the article is inside the window.", 'scientia' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'links' ),
					),
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_author'  => array(
					'title'      => esc_html__( 'Hide author bio', 'scientia' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when infinite scroll is used.", 'scientia' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_related'  => array(
					'title'      => esc_html__( 'Hide related posts', 'scientia' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when infinite scroll is used.", 'scientia' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_comments' => array(
					'title'      => esc_html__( 'Hide comments', 'scientia' ),
					'desc'       => wp_kses_data( __( "Hide comments after post content when infinite scroll is used.", 'scientia' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 1,
					'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_banners_info'      => array(
					'title' => esc_html__( 'Posts banners', 'scientia' ),
					'desc'  => '',
					'type'  => 'hidden',
				),
				'header_banner_link'     => array(
					'title' => esc_html__( 'Header banner link', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'header_banner_img'     => array(
					'title' => esc_html__( 'Header banner image', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'type'  => 'hidden',
				),
				'header_banner_height'  => array(
					'title' => esc_html__( 'Header banner height', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'type'  => 'hidden',
				),
				'header_banner_code'     => array(
					'title'      => esc_html__( 'Header banner code', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'  => 'hidden',
				),
				'footer_banner_link'     => array(
					'title' => esc_html__( 'Footer banner link', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'footer_banner_img'     => array(
					'title' => esc_html__( 'Footer banner image', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'type'  => 'hidden',
				),
				'footer_banner_height'  => array(
					'title' => esc_html__( 'Footer banner height', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'type'  => 'hidden',
				),
				'footer_banner_code'     => array(
					'title'      => esc_html__( 'Footer banner code', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'  => 'hidden',
				),
				'sidebar_banner_link'     => array(
					'title' => esc_html__( 'Sidebar banner link', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'sidebar_banner_img'     => array(
					'title' => esc_html__( 'Sidebar banner image', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'type'  => 'hidden',
				),
				'sidebar_banner_code'     => array(
					'title'      => esc_html__( 'Sidebar banner code', 'scientia' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'  => 'hidden',
				),
				'background_banner_link'     => array(
					'title' => esc_html__( "Post's background banner link", 'scientia' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'   => '',
					'type'  => 'hidden',
				),
				'background_banner_img'     => array(
					'title' => esc_html__( "Post's background banner image", 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'type'  => 'hidden',
				),
				'background_banner_code'     => array(
					'title'      => esc_html__( "Post's background banner code", 'scientia' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'scientia' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'scientia' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'  => 'hidden',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'scientia' ),
					'desc'     => '',
					'priority' => 300,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'scientia' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'scientia' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'scientia' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'scientia' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'scientia' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'scientia' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'scientia' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'scientia' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'scientia' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'scientia' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'scientia' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'scientia' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'scientia' ),
					'desc'        => '',
					'std'         => '$scientia_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Use huge priority to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);



		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'scientia' ),
				'desc'     => '',
				'priority' => 200,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'scientia' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'scientia' ) )
						. '<br>'
						. wp_kses_data( __( 'Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'scientia' ) ),
				'type'  => 'section',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'scientia' ) )
						. '<br>'
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'scientia' ) ),
				'class'   => 'scientia_column-1_3 scientia_new_row',
				'refresh' => false,
				'std'     => '$scientia_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= scientia_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( scientia_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'scientia' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'scientia' ),
				'desc'    => '',
				'class'   => 'scientia_column-1_3 scientia_new_row',
				'refresh' => false,
				'std'     => '$scientia_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'scientia' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'scientia' ) )
							: '',
				'class'   => 'scientia_column-1_3',
				'refresh' => false,
				'std'     => '$scientia_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'scientia' ),
					'serif'      => esc_html__( 'serif', 'scientia' ),
					'sans-serif' => esc_html__( 'sans-serif', 'scientia' ),
					'monospace'  => esc_html__( 'monospace', 'scientia' ),
					'cursive'    => esc_html__( 'cursive', 'scientia' ),
					'fantasy'    => esc_html__( 'fantasy', 'scientia' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'scientia' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'scientia' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'scientia' ) )
							: '',
				'class'   => 'scientia_column-1_3',
				'refresh' => false,
				'std'     => '$scientia_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = scientia_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'scientia' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf( __( 'Font settings of the "%s" tag.', 'scientia' ), $tag ) ),
				'type'  => 'section',
			);

			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'scientia' ),
						'100'     => esc_html__( '100 (Light)', 'scientia' ),
						'200'     => esc_html__( '200 (Light)', 'scientia' ),
						'300'     => esc_html__( '300 (Thin)', 'scientia' ),
						'400'     => esc_html__( '400 (Normal)', 'scientia' ),
						'500'     => esc_html__( '500 (Semibold)', 'scientia' ),
						'600'     => esc_html__( '600 (Semibold)', 'scientia' ),
						'700'     => esc_html__( '700 (Bold)', 'scientia' ),
						'800'     => esc_html__( '800 (Black)', 'scientia' ),
						'900'     => esc_html__( '900 (Black)', 'scientia' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'scientia' ),
						'normal'  => esc_html__( 'Normal', 'scientia' ),
						'italic'  => esc_html__( 'Italic', 'scientia' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'scientia' ),
						'none'         => esc_html__( 'None', 'scientia' ),
						'underline'    => esc_html__( 'Underline', 'scientia' ),
						'overline'     => esc_html__( 'Overline', 'scientia' ),
						'line-through' => esc_html__( 'Line-through', 'scientia' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'scientia' ),
						'none'       => esc_html__( 'None', 'scientia' ),
						'uppercase'  => esc_html__( 'Uppercase', 'scientia' ),
						'lowercase'  => esc_html__( 'Lowercase', 'scientia' ),
						'capitalize' => esc_html__( 'Capitalize', 'scientia' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'class'      => 'scientia_column-1_5',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$scientia_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		scientia_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			scientia_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'scientia' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'scientia' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! scientia_check_url( 'customize.php' ) ) {
			scientia_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'scientia' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'scientia' ) ),
					'class'    => 'scientia_column-1_2 scientia_new_row',
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'scientia' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'scientia_options_get_list_cpt_options' ) ) {
	function scientia_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'scientia' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'scientia' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'scientia' ) ),
				'std'      => 'inherit',
				'options'  => scientia_get_list_body_styles( true ),
				'type'     => 'select',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'scientia' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'scientia' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'scientia' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
				'std'     => 'inherit',
				'options' => scientia_get_list_header_footer_types( true ),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'scientia' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'scientia' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'scientia' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'scientia' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'scientia' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'scientia' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'scientia' ),
					1         => esc_html__( 'Yes', 'scientia' ),
					0         => esc_html__( 'No', 'scientia' ),
				),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_widgets_{$cpt}"         => array(
				'title'   => esc_html__( 'Header widgets', 'scientia' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'scientia' ), $title ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'select',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'scientia' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				'title'   => sprintf( __( 'Sidebar position on the %s list', 'scientia' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s list', 'scientia' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_{$cpt}"=> array(
				'title'    => sprintf( __( 'Sidebar position on the %s list on the small screen', 'scientia' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'scientia' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_{$cpt}"        => array(
				'title'      => sprintf( __( 'Sidebar widgets on the %s list', 'scientia' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s list', 'scientia' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => sprintf( __( 'Sidebar position on the single post', 'scientia' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the single posts of the %s', 'scientia' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_single_{$cpt}"=> array(
				'title'    => esc_html__( 'Sidebar position on the single post on the small screen', 'scientia' ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'scientia' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => sprintf( __( 'Sidebar widgets on the single post', 'scientia' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select widgets to show in the sidebar on the single posts of the %s', 'scientia' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'scientia' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => scientia_get_list_checkbox_values( true ),
				'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
			),
			"expand_content_single_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content on the single post', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Expand the content width on the single post if the sidebar is hidden', 'scientia' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => scientia_get_list_checkbox_values( true ),
				'type'     => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'scientia' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'scientia' ) ),
				'std'     => 'inherit',
				'options' => scientia_get_list_header_footer_types( true ),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'switch',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'scientia' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'scientia' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'scientia' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'scientia' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'scientia' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'scientia' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => scientia_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'scientia' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'scientia' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'checkbox',
			),

			"widgets_info_{$cpt}"           => array(
				'title' => esc_html__( 'Additional panels', 'scientia' ),
				'desc'  => '',
				'type'  => SCIENTIA_THEME_FREE ? 'hidden' : 'info',
			),
			"widgets_above_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the top of the page', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'scientia' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_above_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets above the content', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'scientia' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets below the content', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'scientia' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the bottom of the page', 'scientia' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'scientia' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => SCIENTIA_THEME_FREE ? 'hidden' : 'select',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'scientia_options_get_list_choises' ) ) {
	add_filter( 'scientia_filter_options_get_list_choises', 'scientia_options_get_list_choises', 10, 2 );
	function scientia_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = scientia_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = scientia_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = scientia_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = scientia_get_list_schemes( 'color_scheme' != $id );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = scientia_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = scientia_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = scientia_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = scientia_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = scientia_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = scientia_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = scientia_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = scientia_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = scientia_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = scientia_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = scientia_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = scientia_array_merge( array( 0 => esc_html__( '- Select category -', 'scientia' ) ), scientia_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = scientia_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = scientia_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = scientia_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}
