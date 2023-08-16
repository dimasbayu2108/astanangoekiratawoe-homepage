<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */

if ( ! defined( 'SCIENTIA_THEME_DIR' ) ) {
	define( 'SCIENTIA_THEME_DIR', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'SCIENTIA_THEME_URL' ) ) {
	define( 'SCIENTIA_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}
if ( ! defined( 'SCIENTIA_CHILD_DIR' ) ) {
	define( 'SCIENTIA_CHILD_DIR', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'SCIENTIA_CHILD_URL' ) ) {
	define( 'SCIENTIA_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

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

if ( ! function_exists( 'scientia_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'scientia_theme_setup1', 1 );
	function scientia_theme_setup1() {
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		// Attention! Translations must be loaded before first call any translation functions!
		load_theme_textdomain( 'scientia', SCIENTIA_THEME_DIR . 'languages' );
	}
}

if ( ! function_exists( 'scientia_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'scientia_theme_setup' );
	function scientia_theme_setup() {

		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'scientia_filter_content_width', scientia_get_theme_option( 'page_width' ) );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Custom header setup
		add_theme_support( 'custom-header',
			array(
				'header-text' => false,
				'video'       => true,
			)
		);

		// Custom logo
		add_theme_support( 'custom-logo',
			array(
				'width'       => 250,
				'height'      => 60,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		// Custom backgrounds setup
		add_theme_support( 'custom-background', array() );

		// Partial refresh support in the Customize
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Supported posts formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat' ) );

		// Autogenerate title tag
		add_theme_support( 'title-tag' );

		// Add theme menus
		add_theme_support( 'nav-menus' );

		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Register navigation menu
		register_nav_menus(
			array(
				'menu_main'   => esc_html__( 'Main Menu', 'scientia' ),
				'menu_mobile' => esc_html__( 'Mobile Menu', 'scientia' ),
			)
		);

		// Register theme-specific thumb sizes
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 370, 0, false );
		$thumb_sizes = scientia_storage_get( 'theme_thumbs' );
		$mult        = scientia_get_theme_option( 'retina_ready', 1 );
		if ( $mult > 1 ) {
			$GLOBALS['content_width'] = apply_filters( 'scientia_filter_content_width', 1170 * $mult );
		}
		foreach ( $thumb_sizes as $k => $v ) {
			add_image_size( $k, $v['size'][0], $v['size'][1], $v['size'][2] );
			if ( $mult > 1 ) {
				add_image_size( $k . '-@retina', $v['size'][0] * $mult, $v['size'][1] * $mult, $v['size'][2] );
			}
		}
		// Add new thumb names
		add_filter( 'image_size_names_choose', 'scientia_theme_thumbs_sizes' );

        // Override 'theme activated' status if theme in Elements
        add_filter( 'trx_addons_filter_is_theme_activated', '__return_true', 100 );

		// Excerpt filters
		add_filter( 'excerpt_length', 'scientia_excerpt_length' );
		add_filter( 'excerpt_more', 'scientia_excerpt_more' );

		// Comment form
		add_filter( 'comment_form_fields', 'scientia_comment_form_fields' );
		add_filter( 'comment_form_fields', 'scientia_comment_form_agree', 11 );

		// Add required meta tags in the head
		add_action( 'wp_head', 'scientia_wp_head', 0 );

		// Load current page/post customization (if present)
		add_action( 'wp_footer', 'scientia_wp_footer' );
		add_action( 'admin_footer', 'scientia_wp_footer' );

		// Enqueue scripts and styles for the frontend
		add_action( 'wp_enqueue_scripts', 'scientia_wp_styles', 1000 );              // priority 1000 - load main theme styles
		add_action( 'wp_enqueue_scripts', 'scientia_wp_styles_plugins', 1100 );      // priority 1100 - load styles of the supported plugins
		add_action( 'wp_enqueue_scripts', 'scientia_wp_styles_custom', 1200 );       // priority 1200 - load styles with custom fonts and colors
		add_action( 'wp_enqueue_scripts', 'scientia_wp_styles_child', 1500 );        // priority 1500 - load styles of the child theme
		add_action( 'wp_enqueue_scripts', 'scientia_wp_styles_responsive', 2000 );   // priority 2000 - load responsive styles after all other styles

		// Enqueue scripts for the frontend
		add_action( 'wp_enqueue_scripts', 'scientia_wp_scripts', 1000 );             // priority 1000 - load main theme scripts
		add_action( 'wp_footer', 'scientia_localize_scripts' );

		// Add body classes
		add_filter( 'body_class', 'scientia_add_body_classes' );

		// Register sidebars
		add_action( 'widgets_init', 'scientia_register_sidebars' );
	}
}


//-------------------------------------------------------
//-- Theme styles
//-------------------------------------------------------

// Load frontend styles
if ( ! function_exists( 'scientia_wp_styles' ) ) {
	
	function scientia_wp_styles() {

		// Links to selected fonts
		$links = scientia_theme_fonts_links();
		if ( count( $links ) > 0 ) {
			foreach ( $links as $slug => $link ) {
				wp_enqueue_style( sprintf( 'scientia-font-%s', $slug ), $link, array(), null );
			}
		}

		// Font icons styles must be loaded before main stylesheet
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'scientia-icons', scientia_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );

		// Load main stylesheet
		$main_stylesheet = SCIENTIA_THEME_URL . 'style.css';
		wp_enqueue_style( 'scientia-main', $main_stylesheet, array(), null );

		// Add custom bg image
		$bg_image = scientia_remove_protocol_from_url( scientia_get_theme_option( 'front_page_bg_image' ), false );
		if ( is_front_page() && ! empty( $bg_image ) && scientia_is_on( scientia_get_theme_option( 'front_page_enabled' ) ) ) {
			// Add custom bg image for the Front page
			wp_add_inline_style( 'scientia-main', 'body.frontpage, body.home-page { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
		} else {
			// Add custom bg image for the body_style == 'boxed'
			$bg_image = scientia_get_theme_option( 'boxed_bg_image' );
			if ( scientia_get_theme_option( 'body_style' ) == 'boxed' && ! empty( $bg_image ) ) {
				wp_add_inline_style( 'scientia-main', '.body_style_boxed { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
			}
		}

		// Add post nav background
		scientia_add_bg_in_post_nav();
	}
}

// Load styles of the supported plugins
if ( ! function_exists( 'scientia_wp_styles_plugins' ) ) {
	
	function scientia_wp_styles_plugins() {
		if ( scientia_is_off( scientia_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'scientia-plugins', scientia_get_file_url( 'css/__plugins.css' ), array(), null );
		}
	}
}

// Load styles with custom fonts and colors
if ( ! function_exists( 'scientia_wp_styles_custom' ) ) {
	
	function scientia_wp_styles_custom() {
		if ( ! is_customize_preview() && ! isset( $_GET['color_scheme'] ) && scientia_is_off( scientia_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'scientia-custom', scientia_get_file_url( 'css/__custom.css' ), array(), null );
			if ( scientia_get_theme_setting( 'separate_schemes' ) ) {
				$schemes = scientia_get_sorted_schemes();
				if ( is_array( $schemes ) ) {
					foreach ( $schemes as $scheme => $data ) {
						wp_enqueue_style( "scientia-color-{$scheme}", scientia_get_file_url( "css/__colors-{$scheme}.css" ), array(), null );
					}
				}
			}
		} else {
			wp_enqueue_style( 'scientia-custom', scientia_get_file_url( 'css/__custom-inline.css' ), array(), null );
			wp_add_inline_style( 'scientia-custom', scientia_customizer_get_css() );
		}
	}
}

// Load child-theme stylesheet (if different) after all theme styles
if ( ! function_exists( 'scientia_wp_styles_child' ) ) {
	
	function scientia_wp_styles_child() {
		$main_stylesheet  = SCIENTIA_THEME_URL . 'style.css';
		$child_stylesheet = SCIENTIA_CHILD_URL . 'style.css';
		if ( $child_stylesheet != $main_stylesheet ) {
			wp_enqueue_style( 'scientia-child', $child_stylesheet, array( 'scientia-main' ), null );
		}
	}
}

// Load responsive styles (priority 2000 - load it after main styles and plugins custom styles)
if ( ! function_exists( 'scientia_wp_styles_responsive' ) ) {
	
	function scientia_wp_styles_responsive() {
		if ( scientia_is_off( scientia_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'scientia-responsive', scientia_get_file_url( 'css/__responsive.css' ), array(), null );
		} else {
			wp_enqueue_style( 'scientia-responsive', scientia_get_file_url( 'css/responsive.css' ), array(), null );
		}
	}
}


//-------------------------------------------------------
//-- Theme scripts
//-------------------------------------------------------

// Load frontend scripts
if ( ! function_exists( 'scientia_wp_scripts' ) ) {
	
	function scientia_wp_scripts() {

		$blog_archive = scientia_storage_get( 'blog_archive' ) === true || is_home();
		$blog_style   = scientia_get_theme_option( 'blog_style' );
		if ( strpos( $blog_style, 'blog-custom-' ) === 0 ) {
			$blog_id   = scientia_get_custom_blog_id( $blog_style );
			$blog_meta = scientia_get_custom_layout_meta( $blog_id );
			if ( ! empty( $blog_meta['scripts_required'] ) && ! scientia_is_off( $blog_meta['scripts_required'] ) ) {
				$blog_style = $blog_meta['scripts_required'];
			}
		}
		$need_masonry = ( $blog_archive 
							&& in_array( substr( $blog_style, 0, 7 ), array( 'gallery', 'portfol', 'masonry' ) ) )
						|| ( is_single()
							&& str_replace( 'post-format-', '', get_post_format() ) == 'gallery' );

		// Modernizr will load in head before other scripts and styles
		if ( $need_masonry ) {
			wp_enqueue_script( 'modernizr', scientia_get_file_url( 'js/theme-gallery/modernizr.min.js' ), array(), null, false );
		}

		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', scientia_get_file_url( 'js/superfish/superfish.min.js' ), array( 'jquery' ), null, true );

		// Merged scripts
		if ( scientia_is_off( scientia_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_script( 'scientia-init', scientia_get_file_url( 'js/__scripts.js' ), array( 'jquery' ), null, true );
		} else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', scientia_get_file_url( 'js/skip-link-focus-fix.js' ), null, true );
			// Background video
			$header_video = scientia_get_header_video();
			if ( ! empty( $header_video ) && ! scientia_is_inherit( $header_video ) ) {
				if ( scientia_is_youtube_url( $header_video ) ) {
					wp_enqueue_script( 'tubular', scientia_get_file_url( 'js/jquery.tubular.js' ), array( 'jquery' ), null, true );
				} else {
					wp_enqueue_script( 'bideo', scientia_get_file_url( 'js/bideo.js' ), array(), null, true );
				}
			}
			// Theme scripts
			wp_enqueue_script( 'scientia-utils', scientia_get_file_url( 'js/theme-utils.js' ), array( 'jquery' ), null, true );
			wp_enqueue_script( 'scientia-init', scientia_get_file_url( 'js/theme-init.js' ), array( 'jquery' ), null, true );
		}
		// Load scripts for 'Masonry' layout
		if ( $need_masonry ) {
			scientia_load_masonry_scripts();
		}
		// Load scripts for 'Portfolio' layout
		if ( $blog_archive
				&& in_array( substr( $blog_style, 0, 7 ), array( 'gallery', 'portfol' ) )
				&& ! is_customize_preview() ) {
			wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
		}

		// Comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library
		if ( scientia_get_theme_setting( 'use_mediaelements' ) ) {
			wp_enqueue_style( 'mediaelement' );
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}


// Add variables to the scripts in the frontend
if ( ! function_exists( 'scientia_localize_scripts' ) ) {
	
	function scientia_localize_scripts() {

		$video = scientia_get_header_video();

		wp_localize_script(
			'scientia-init', 'SCIENTIA_STORAGE', apply_filters(
				'scientia_filter_localize_script', array(
					// AJAX parameters
					'ajax_url'            => esc_url( admin_url( 'admin-ajax.php' ) ),
					'ajax_nonce'          => esc_attr( wp_create_nonce( admin_url( 'admin-ajax.php' ) ) ),

					// Site base url
					'site_url'            => get_home_url(),
					'theme_url'           => SCIENTIA_THEME_URL,

					// Site color scheme
					'site_scheme'         => sprintf( 'scheme_%s', scientia_get_theme_option( 'color_scheme' ) ),

					// User logged in
					'user_logged_in'      => is_user_logged_in() ? true : false,

					// Window width to switch the site header to the mobile layout
					'mobile_layout_width' => 767,
					'mobile_device'       => wp_is_mobile(),

					// Sidemenu options
					'menu_side_stretch'   => scientia_get_theme_option( 'menu_side_stretch' ) > 0,
					'menu_side_icons'     => scientia_get_theme_option( 'menu_side_icons' ) > 0,

					// Video background
					'background_video'    => scientia_is_from_uploads( $video ) ? $video : '',

					// Video and Audio tag wrapper
					'use_mediaelements'   => scientia_get_theme_setting( 'use_mediaelements' ) ? true : false,

					// Allow open full post in the blog
					'open_full_post'      => scientia_get_theme_option( 'open_full_post_in_blog' ) > 0,

					// Current mode
					'admin_mode'          => false,

					// Strings for translation
					'msg_ajax_error'      => esc_html__( 'Invalid server answer!', 'scientia' ),
				)
			)
		);
	}
}

// Enqueue masonry, portfolio and gallery-specific scripts
if ( ! function_exists( 'scientia_load_masonry_scripts' ) ) {
	function scientia_load_masonry_scripts() {
		wp_enqueue_script( 'modernizr', scientia_get_file_url( 'js/theme-gallery/modernizr.min.js' ), array(), null, false );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'classie', scientia_get_file_url( 'js/theme-gallery/classie.min.js' ), array(), null, true );
		wp_enqueue_script( 'scientia-gallery-script', scientia_get_file_url( 'js/theme-gallery/theme-gallery.js' ), array(), null, true );
	}
}


//-------------------------------------------------------
//-- Head, body and footer
//-------------------------------------------------------

//  Add meta tags in the header for frontend
if ( ! function_exists( 'scientia_wp_head' ) ) {
	
	function scientia_wp_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
}

// Add theme specified classes to the body
if ( ! function_exists( 'scientia_add_body_classes' ) ) {
	
	function scientia_add_body_classes( $classes ) {
		$classes[] = 'body_tag';    // Need for the .scheme_self
		$classes[] = 'scheme_' . esc_attr( scientia_get_theme_option( 'color_scheme' ) );

		$blog_mode = scientia_storage_get( 'blog_mode' );
		$classes[] = 'blog_mode_' . esc_attr( $blog_mode );
		$classes[] = 'body_style_' . esc_attr( scientia_get_theme_option( 'body_style' ) );

		if ( in_array( $blog_mode, array( 'post', 'page' ) ) ) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_' . esc_attr( scientia_get_theme_option( 'blog_style' ) );
			if ( scientia_storage_get( 'blog_template' ) > 0 ) {
				$classes[] = 'blog_template';
			}
		}

		if ( scientia_sidebar_present() ) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr( scientia_get_theme_option( 'sidebar_position' ) );
			$classes[] = 'sidebar_small_screen_' . esc_attr( scientia_get_theme_option( 'sidebar_position_ss' ) );
		} else {
			$classes[] = 'sidebar_hide';
			if ( scientia_is_on( scientia_get_theme_option( 'expand_content' ) ) ) {
				$classes[] = 'expand_content';
			}
		}

		if ( scientia_is_on( scientia_get_theme_option( 'remove_margins' ) ) ) {
			$classes[] = 'remove_margins';
		}

		$bg_image = scientia_get_theme_option( 'front_page_bg_image' );
		if ( is_front_page() && scientia_is_on( scientia_get_theme_option( 'front_page_enabled' ) ) && ! empty( $bg_image ) ) {
			$classes[] = 'with_bg_image';
		}

		$classes[] = 'trx_addons_' . esc_attr( scientia_exists_trx_addons() ? 'present' : 'absent' );

		$classes[] = 'header_type_' . esc_attr( scientia_get_theme_option( 'header_type' ) );
		$classes[] = 'header_style_' . esc_attr( 'default' == scientia_get_theme_option( 'header_type' ) ? 'header-default' : scientia_get_theme_option( 'header_style' ) );
		$classes[] = 'header_position_' . esc_attr( scientia_get_theme_option( 'header_position' ) );

		$menu_style = scientia_get_theme_option( 'menu_style' );
		$classes[]  = 'menu_style_' . esc_attr( $menu_style ) . ( in_array( $menu_style, array( 'left', 'right' ) ) ? ' menu_style_side' : '' );
		$classes[]  = 'no_layout';

		if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
			$classes[]  = 'thumbnail_type_' . esc_attr(scientia_get_theme_option( 'post_thumbnail_type' )) . ' post_header_position_' . esc_attr(scientia_get_theme_option( 'post_header_position' ));
		}

		return $classes;
	}
}

// Load current page/post customization (if present)
if ( ! function_exists( 'scientia_wp_footer' ) ) {
	
	//and add_action('admin_footer', 'scientia_wp_footer');
	function scientia_wp_footer() {
		// Add header zoom
		$header_zoom = max( 0.2, min( 2, (float) scientia_get_theme_option( 'header_zoom' ) ) );
		if ( 1 != $header_zoom ) {
			scientia_add_inline_css( ".sc_layouts_title_title{font-size:{$header_zoom}em}" );
		}
		// Add logo zoom
		$logo_zoom = max( 0.2, min( 2, (float) scientia_get_theme_option( 'logo_zoom' ) ) );
		if ( 1 != $logo_zoom ) {
			scientia_add_inline_css( ".custom-logo-link,.sc_layouts_logo{font-size:{$logo_zoom}em}" );
		}
		// Put inline styles to the output
		$css = scientia_get_inline_css();
		if ( ! empty( $css ) ) {
			wp_enqueue_style( 'scientia-inline-styles', scientia_get_file_url( 'css/__inline.css' ), array(), null );
			wp_add_inline_style( 'scientia-inline-styles', $css );
		}
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

// Register widgetized areas
if ( ! function_exists( 'scientia_register_sidebars' ) ) {
	
	function scientia_register_sidebars() {
		$sidebars = scientia_get_sidebars();
		if ( is_array( $sidebars ) && count( $sidebars ) > 0 ) {
			$cnt = 0;
			foreach ( $sidebars as $id => $sb ) {
				$cnt++;
				register_sidebar(
					apply_filters( 'scientia_filter_register_sidebar',
						array(
							'name'          => $sb['name'],
							'description'   => $sb['description'],
							// Translators: Add the sidebar number to the id
							'id'            => ! empty( $id ) ? $id : sprintf( 'theme_sidebar_%d', $cnt),
							'before_widget' => '<aside id="%1$s" class="widget %2$s">',
							'after_widget'  => '</aside>',
							'before_title'  => '<h5 class="widget_title">',
							'after_title'   => '</h5>',
						)
					)
				);
			}
		}
	}
}

// Return theme specific widgetized areas
if ( ! function_exists( 'scientia_get_sidebars' ) ) {
	function scientia_get_sidebars() {
		$list = apply_filters(
			'scientia_filter_list_sidebars', array(
				'sidebar_widgets'       => array(
					'name'        => esc_html__( 'Sidebar Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown on the main sidebar', 'scientia' ),
				),
				'header_widgets'        => array(
					'name'        => esc_html__( 'Header Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown at the top of the page (in the page header area)', 'scientia' ),
				),
				'above_page_widgets'    => array(
					'name'        => esc_html__( 'Top Page Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown below the header, but above the content and sidebar', 'scientia' ),
				),
				'above_content_widgets' => array(
					'name'        => esc_html__( 'Above Content Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown above the content, near the sidebar', 'scientia' ),
				),
				'below_content_widgets' => array(
					'name'        => esc_html__( 'Below Content Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown below the content, near the sidebar', 'scientia' ),
				),
				'below_page_widgets'    => array(
					'name'        => esc_html__( 'Bottom Page Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown below the content and sidebar, but above the footer', 'scientia' ),
				),
				'footer_widgets'        => array(
					'name'        => esc_html__( 'Footer Widgets', 'scientia' ),
					'description' => esc_html__( 'Widgets to be shown at the bottom of the page (in the page footer area)', 'scientia' ),
				),
			)
		);
		return $list;
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

// Return links for all theme fonts
if ( ! function_exists( 'scientia_theme_fonts_links' ) ) {
	function scientia_theme_fonts_links() {
		$links = array();

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Google fonts: on or off', 'scientia' ) );
		$custom_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Custom fonts (included in the theme): on or off', 'scientia' ) );

		if ( ( $google_fonts_enabled || $custom_fonts_enabled ) && ! scientia_storage_empty( 'load_fonts' ) ) {
			$load_fonts = scientia_storage_get( 'load_fonts' );
			if ( count( $load_fonts ) > 0 ) {
				$google_fonts = '';
				foreach ( $load_fonts as $font ) {
					$url = '';
					if ( $custom_fonts_enabled && empty( $font['styles'] ) ) {
						$slug = scientia_get_load_fonts_slug( $font['name'] );
						$url  = scientia_get_file_url( "css/font-face/{$slug}/stylesheet.css" );
						if ( ! empty( $url ) ) {
							$links[ $slug ] = $url;
						}
					}
					if ( $google_fonts_enabled && empty( $url ) ) {
						// Attention! Using '%7C' instead '|' damage loading second+ fonts
						$google_fonts .= ( $google_fonts ? '%7C' : '' )
										. str_replace( ' ', '+', $font['name'] )
										. ':'
										. ( empty( $font['styles'] ) ? '400,400italic,700,700italic' : $font['styles'] );
					}
				}
				if ( $google_fonts_enabled && ! empty( $google_fonts ) ) {
					$google_fonts_subset = scientia_get_theme_option( 'load_fonts_subset' );
					$links['google_fonts'] = esc_url( scientia_get_protocol()."://fonts.googleapis.com/css?family={$google_fonts}&subset={$google_fonts_subset}" );
				}
			}
		}
		return $links;
	}
}

// Return links for WP Editor
if ( ! function_exists( 'scientia_theme_fonts_for_editor' ) ) {
	function scientia_theme_fonts_for_editor() {
		$links = array_values( scientia_theme_fonts_links() );
		if ( is_array( $links ) && count( $links ) > 0 ) {
			for ( $i = 0; $i < count( $links ); $i++ ) {
				$links[ $i ] = str_replace( ',', '%2C', $links[ $i ] );
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------
if ( ! function_exists( 'scientia_excerpt_length' ) ) {
	
	function scientia_excerpt_length( $length ) {
		$blog_style = explode( '_', scientia_get_theme_option( 'blog_style' ) );
		return max( 0, round( scientia_get_theme_option( 'excerpt_length' ) / ( in_array( $blog_style[0], array( 'classic', 'masonry', 'portfolio' ) ) ? 2 : 1 ) ) );
	}
}

if ( ! function_exists( 'scientia_excerpt_more' ) ) {
	
	function scientia_excerpt_more( $more ) {
		return '&hellip;';
	}
}


//-------------------------------------------------------
//-- Comments
//-------------------------------------------------------

// Comment form fields order
if ( ! function_exists( 'scientia_comment_form_fields' ) ) {
	
	function scientia_comment_form_fields( $comment_fields ) {
		if ( scientia_get_theme_setting( 'comment_after_name' ) ) {
			$keys = array_keys( $comment_fields );
			if ( 'comment' == $keys[0] ) {
				$comment_fields['comment'] = array_shift( $comment_fields );
			}
		}
		return $comment_fields;
	}
}

// Add checkbox with "I agree ..."
if ( ! function_exists( 'scientia_comment_form_agree' ) ) {
	
	function scientia_comment_form_agree( $comment_fields ) {
		$privacy_text = scientia_get_privacy_text();
		if ( ! empty( $privacy_text )
			&& ( ! function_exists( 'scientia_exists_gdpr_framework' ) || ! scientia_exists_gdpr_framework() )
			&& ( ! function_exists( 'scientia_exists_wp_gdpr_compliance' ) || ! scientia_exists_wp_gdpr_compliance() )
		) {
			$comment_fields['i_agree_privacy_policy'] = scientia_single_comments_field(
				array(
					'form_style'        => 'default',
					'field_type'        => 'checkbox',
					'field_req'         => '',
					'field_icon'        => '',
					'field_value'       => '1',
					'field_name'        => 'i_agree_privacy_policy',
					'field_title'       => $privacy_text,
				)
			);
		}
		return $comment_fields;
	}
}



//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------
if ( ! function_exists( 'scientia_theme_thumbs_sizes' ) ) {
	
	function scientia_theme_thumbs_sizes( $sizes ) {
		$thumb_sizes = scientia_storage_get( 'theme_thumbs' );
		$mult        = scientia_get_theme_option( 'retina_ready', 1 );
		foreach ( $thumb_sizes as $k => $v ) {
			$sizes[ $k ] = $v['title'];
			if ( $mult > 1 ) {
				$sizes[ $k . '-@retina' ] = $v['title'] . ' ' . esc_html__( '@2x', 'scientia' );
			}
		}
		return $sizes;
	}
}



//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

require_once SCIENTIA_THEME_DIR . 'includes/utils.php';
require_once SCIENTIA_THEME_DIR . 'includes/storage.php';

require_once SCIENTIA_THEME_DIR . 'includes/lists.php';
require_once SCIENTIA_THEME_DIR . 'includes/wp.php';

if ( is_admin() ) {
	require_once SCIENTIA_THEME_DIR . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once SCIENTIA_THEME_DIR . 'includes/admin.php';
}

require_once SCIENTIA_THEME_DIR . 'theme-options/theme-customizer.php';

require_once SCIENTIA_THEME_DIR . 'front-page/front-page-options.php';

require_once SCIENTIA_THEME_DIR . 'theme-specific/theme-tags.php';
require_once SCIENTIA_THEME_DIR . 'theme-specific/theme-hovers/theme-hovers.php';
require_once SCIENTIA_THEME_DIR . 'theme-specific/theme-about/theme-about.php';

// Free themes support
if ( SCIENTIA_THEME_FREE ) {
	require_once SCIENTIA_THEME_DIR . 'theme-specific/theme-about/theme-upgrade.php';
}

// Plugins support
$scientia_required_plugins = scientia_storage_get( 'required_plugins' );
if ( is_array( $scientia_required_plugins ) ) {
	foreach ( $scientia_required_plugins as $plugin_slug => $plugin_data ) {
		$plugin_slug = scientia_esc( $plugin_slug );
		$plugin_path = SCIENTIA_THEME_DIR . sprintf( 'plugins/%1$s/%1$s.php', $plugin_slug );
		if ( file_exists( $plugin_path ) ) {
			require_once $plugin_path;
		}
	}
}

// Theme skins support
if ( defined( 'SCIENTIA_ALLOW_SKINS' ) && SCIENTIA_ALLOW_SKINS && file_exists( SCIENTIA_THEME_DIR . 'skins/skins.php' ) ) {
	require_once SCIENTIA_THEME_DIR . 'skins/skins.php';
}


/* wp_kses handlers
----------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'scientia_kses_allowed_html' ) ) {
    add_filter( 'wp_kses_allowed_html', 'scientia_kses_allowed_html', 10, 2);
    function scientia_kses_allowed_html($tags, $context) {
        if ( in_array( $context, array( 'scientia_kses_content', 'trx_addons_kses_content' ) ) ) {
            $tags = array(
                'h1'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h2'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h3'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h4'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h5'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'h6'     => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'p'      => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'span'   => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'div'    => array( 'id' => array(), 'class' => array(), 'title' => array(), 'align' => array() ),
                'a'      => array( 'id' => array(), 'class' => array(), 'title' => array(), 'href' => array(), 'target' => array() ),
                'b'      => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'i'      => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'em'     => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'strong' => array( 'id' => array(), 'class' => array(), 'title' => array() ),
                'img'    => array( 'id' => array(), 'class' => array(), 'src' => array(), 'width' => array(), 'height' => array(), 'alt' => array() ),
                'br'     => array( 'clear' => array() ),
            );
        }
        return $tags;
    }
}


/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }
}
