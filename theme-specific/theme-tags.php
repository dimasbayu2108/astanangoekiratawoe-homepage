<?php
/**
 * Theme tags
 *
 * @package WordPress
 * @subpackage SCIENTIA
 * @since SCIENTIA 1.0
 */


//----------------------------------------------------------------------
//-- Common tags
//----------------------------------------------------------------------

// Return true if current page need title
if ( ! function_exists( 'scientia_need_page_title' ) ) {
	function scientia_need_page_title() {
		return ! is_front_page() && apply_filters( 'scientia_filter_need_page_title', true );
	}
}

// Output string with the html layout (if not empty)
// (put it between 'before' and 'after' tags)
// Attention! This string may contain layout formed in any plugin (widgets or shortcodes output) and not require escaping to prevent damage!
if ( ! function_exists( 'scientia_show_layout' ) ) {
	function scientia_show_layout( $str, $before = '', $after = '' ) {
		if ( trim( $str ) != '' ) {
			printf( '%s%s%s', $before, $str, $after );
		}
	}
}

// Return logo images (if set)
if ( ! function_exists( 'scientia_get_logo_image' ) ) {
	function scientia_get_logo_image( $type = '' ) {
		$logo_image  = '';
		if ( empty( $type ) && function_exists( 'the_custom_logo' ) ) {
			$logo_image = scientia_get_theme_option( 'custom_logo' );
			if ( empty( $logo_image ) ) {
				$logo_image = get_theme_mod( 'custom_logo' );
			}
			if ( is_numeric( $logo_image ) && (int) $logo_image > 0 ) {
				$image      = wp_get_attachment_image_src( $logo_image, 'full' );
				$logo_image = $image[0];
			}
		} else {
			$logo_image = scientia_get_theme_option( 'logo' . ( ! empty( $type ) ? '_' . trim( $type ) : '' ) );
		}
		$logo_retina = scientia_is_on( scientia_get_theme_option( 'logo_retina_enabled' ) )
						? scientia_get_theme_option( 'logo' . ( ! empty( $type ) ? '_' . trim( $type ) : '' ) . '_retina' )
						: '';
		return array(
					'logo'        => ! empty( $logo_image ) ? scientia_remove_protocol_from_url( $logo_image, false ) : '',
					'logo_retina' => ! empty( $logo_retina ) ? scientia_remove_protocol_from_url( $logo_retina, false ) : ''
				);
	}
}

// Return header video (if set)
if ( ! function_exists( 'scientia_get_header_video' ) ) {
	function scientia_get_header_video() {
		$video = '';
		if ( apply_filters( 'scientia_header_video_enable', ! wp_is_mobile() && is_front_page() ) ) {
			if ( scientia_check_theme_option( 'header_video' ) ) {
				$video = scientia_get_theme_option( 'header_video' );
				if ( is_numeric( $video ) && (int) $video > 0 ) {
					$video = wp_get_attachment_url( $video );
				}
			} elseif ( function_exists( 'get_header_video_url' ) ) {
				$video = get_header_video_url();
			}
		}
		return $video;
	}
}


//----------------------------------------------------------------------
//-- Post parts
//----------------------------------------------------------------------

// Show post banner
if ( ! function_exists( 'scientia_show_post_banner' ) ) {
	function scientia_show_post_banner( $banner_pos = '') {
		if ( is_singular( 'post' ) && '' !== $banner_pos ){
			$banner_code   = scientia_get_theme_option( $banner_pos . '_banner_code' );
			$banner_img    = scientia_get_theme_option( $banner_pos . '_banner_img' );
			$banner_height = scientia_get_theme_option( $banner_pos . '_banner_height' );
			$banner_class  = !empty( $banner_img )
								? ( 'background' == $banner_pos ? '' : 'banner_with_image ' )
									. scientia_add_inline_css_class( 
										'background-image:url(' . esc_url( $banner_img ) . ');'
										. ( ! empty( $banner_height )
											? 'min-height:' . scientia_prepare_css_value( $banner_height ) . ';'
											: ''
											)
										)
								: '';
			$banner_link   = scientia_get_theme_option( $banner_pos . '_banner_link' );
			if ( ! empty( $banner_code ) || ! empty( $banner_img ) ) {
				$banner_pos = 'background' == $banner_pos ? 'page' : $banner_pos;
				echo '<div class="' . esc_attr( $banner_pos ) . '_banner_wrap ' . esc_attr( $banner_class ) . '">';
				scientia_show_layout( wp_kses( $banner_code, 'scientia_kses_content' ) );
				if ( ! empty( $banner_link ) ) {
					echo '<a href="' . esc_url( $banner_link ) . '" class="banner_link"></a>';
				}
				echo '</div>';
			}
		}	
	}
}


// Show post featured image
if ( ! function_exists( 'scientia_show_post_featured_image' ) ) {
	function scientia_show_post_featured_image() {
		$seo = scientia_is_on( scientia_get_theme_option( 'seo_snippets' ) );
		// Featured image
		if ( scientia_is_off( scientia_get_theme_option( 'hide_featured_on_single' ) )
					&& ! scientia_sc_layouts_showed( 'featured' )
					&& strpos( scientia_get_post_content(), '[trx_widget_banner]' ) === false ) {
			do_action( 'scientia_action_before_post_featured' );
			scientia_show_post_featured(
				array(
					'singular' => true,
					'thumb_bg' => scientia_get_theme_option( 'post_thumbnail_type' ) == 'fullwidth'
				)
			);
			do_action( 'scientia_action_after_post_featured' );
		} elseif ( $seo && has_post_thumbnail() ) {
			?>
			<meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>">
			<?php
		}
	}
}

// Show post title and meta
if ( ! function_exists( 'scientia_show_post_title_and_meta' ) ) {
	function scientia_show_post_title_and_meta() {

		$seo = scientia_is_on( scientia_get_theme_option( 'seo_snippets' ) );

		// Title and post meta
		if ( ( ! scientia_sc_layouts_showed( 'title' ) || ! scientia_sc_layouts_showed( 'postmeta' ) ) ) {
			do_action( 'scientia_action_before_post_title' );
			$need_content_wrap = scientia_get_theme_option( 'post_thumbnail_type' ) == 'fullwidth' && scientia_get_theme_option( 'post_header_position' ) !== 'on_thumb';
			?>
			<div class="post_header post_header_single entry-header">
				<?php
				if ( $need_content_wrap ) {
					?>
					<div class="content_wrap">
					<?php
				}
				// Post title
				if ( ! scientia_sc_layouts_showed( 'title' ) ) {
					the_title( '<h1 class="post_title entry-title"' . ( $seo ? ' itemprop="headline"' : '' ) . '>', '</h1>' );
				}
				// Post meta
				$meta_components = scientia_array_get_keys_by_value( scientia_get_theme_option( 'meta_parts' ) );
				$show_categories = strpos($meta_components, 'categories') !== false;
				$meta_components = str_replace(array('categories,', ',categories'), '', $meta_components);
				if ( $show_categories && ! scientia_sc_layouts_showed( 'postmeta' ) && scientia_is_on( scientia_get_theme_option( 'show_post_meta' ) ) ) {
					scientia_show_post_meta(
						apply_filters(
							'scientia_filter_post_meta_args',
							array(
								'components' => 'categories',
								'class'      => 'post_meta_categories',
							),
							'single',
							1
						)
					);
				}
				// Post subtitle
				$post_subtitle = scientia_get_theme_option( 'post_subtitle' );
				if ( ! empty( $post_subtitle ) ) {
					?>
					<div class="post_subtitle">
						<?php scientia_show_layout( $post_subtitle ); ?>
					</div>
					<?php
				}
				// Post meta
				if ( ! scientia_sc_layouts_showed( 'postmeta' ) && scientia_is_on( scientia_get_theme_option( 'show_post_meta' ) ) ) {
					scientia_show_post_meta(
						apply_filters(
							'scientia_filter_post_meta_args',
							array(
								'components' => $meta_components,
								'counters'   => scientia_array_get_keys_by_value( scientia_get_theme_option( 'counters' ) ),
								'seo'        => $seo,
								'class'      => 'post_meta_other',
							),
							'single',
							1
						)
					);
				}
				if ( $need_content_wrap ) {
					?>
					</div>
					<?php
				}
				?>
			</div><!-- .post_header -->
			<?php
			do_action( 'scientia_action_after_post_title' );
		}
	}
}


// Show post content in the blog posts
if ( ! function_exists( 'scientia_show_post_content' ) ) {
	function scientia_show_post_content( $args = array(), $otag='', $ctag='', $off = '' ) {
		$plain = true;
		$post_format = get_post_format();
		$post_format = empty( $post_format ) ? 'standard' : str_replace( 'post-format-', '', $post_format );
		ob_start();
		if ( has_excerpt() ) {
			the_excerpt();
		} elseif ( strpos( get_the_content( '!--more' ), '!--more' ) !== false ) {
			do_action( 'scientia_action_before_full_post_content' );
			scientia_show_layout( scientia_filter_post_content( get_the_content('') ) );
			do_action( 'scientia_action_after_full_post_content' );
		} elseif ( in_array( $post_format, array( 'link', 'aside', 'status' ) ) ) {
			do_action( 'scientia_action_before_full_post_content' );
			scientia_show_layout( scientia_filter_post_content( get_the_content() ) );
			do_action( 'scientia_action_after_full_post_content' );
			$plain = false;
		} elseif ( 'quote' == $post_format ) {
			$quote = scientia_get_tag( scientia_filter_post_content( get_the_content() ), '<blockquote', '</blockquote>' );
			if ( !empty( $quote ) && !$off=='quote' ) {
				scientia_show_layout( wpautop( $quote ) );
				$plain = false;
			} else {
				scientia_show_layout( scientia_filter_post_content( get_the_content() ) );
			}
		} elseif ( substr( get_the_content(), 0, 4 ) != '[vc_' ) {
			scientia_show_layout( scientia_filter_post_content( get_the_content() ) );
		}
		$output = ob_get_contents();
		ob_end_clean();
		if ( ! empty( $output ) ) {
			if ( $plain ) {
				$len = ! empty( $args['hide_excerpt'] )
							? 0
							: ( ! empty( $args['excerpt_length'] )
								? max( 0, (int) $args['excerpt_length'] )
								: scientia_get_theme_option( 'excerpt_length' )
								);
				$output = scientia_excerpt( $output, $len );
			}
		}
		scientia_show_layout( $output, $otag, $ctag);
	}
}


// Show post link 'Read more' in the blog posts
if ( ! function_exists( 'scientia_show_post_more_link' ) ) {
	function scientia_show_post_more_link( $args = array(), $otag='', $ctag='' ) {
		scientia_show_layout(
			'<a class="more-link" href="' . esc_url( get_permalink() ) . '">'
				. ( ! empty( $args['more_text'] )
						? esc_html( $args['more_text'] )
						: esc_html__( 'Read more', 'scientia' )
						)
			. '</a>',
			$otag,
			$ctag
		);
	}
}


// Show post meta block: post date, author, categories, counters, etc.
if ( ! function_exists( 'scientia_show_post_meta' ) ) {
	function scientia_show_post_meta( $args = array() ) {
		if ( is_single() && scientia_is_off( scientia_get_theme_option( 'show_post_meta' ) ) ) {
			return ' ';  // Space is need!
		}
		$args = array_merge(
			array(
				'components'  => 'categories,date,author,counters,share,edit',
				'counters'    => 'comments',   //comments,views,likes,rating
				'share_type'  => 'drop',
				'seo'         => false,
				'date_format' => '',
				'class'       => '',
				'echo'        => true,
			),
			$args
		);
		if ( ! $args['echo'] ) {
			ob_start();
		}
		?>
		<div class="post_meta<?php echo ! empty( $args['class'] ) ? ' ' . esc_attr( $args['class'] ) : ''; ?>">
			<?php
			$components = explode( ',', $args['components'] );
			foreach ( $components as $comp ) {
				$comp = trim( $comp );
				if ( 'categories' == $comp ) {
					// Post categories
					$cats = get_post_type() == 'post' ? get_the_category_list( ', ' ) : apply_filters( 'scientia_filter_get_post_categories', '' );
					if ( ! empty( $cats ) ) {
						scientia_show_layout( $cats, '<span class="post_meta_item post_categories">', '</span> ');
					}
				} elseif ( 'date' == $comp ) {
					// Post date
					$dt = apply_filters( 'scientia_filter_get_post_date', scientia_get_date( '', ! empty( $args['date_format'] ) ? $args['date_format'] : '' ) );
					if ( ! empty( $dt ) ) {
						scientia_show_layout(
							$dt,
							'<span class="post_meta_item post_date' . ( ! empty( $args['seo'] ) ? ' date updated' : '' ) . '"'
								. ( ! empty( $args['seo'] ) ? ' itemprop="datePublished"' : '' )
								. '> '.esc_html__( 'Posted on', 'scientia' ).' '
								. ( ! is_singular() ? '<a href="' . esc_url( get_permalink() ) . '">' : '' ),
							( ! is_singular() ? '</a>' : '' ) . '</span> '
						);
					}
				} elseif ( 'author' == $comp ) {
					// Post author
					$author_id = get_the_author_meta( 'ID' );
					if ( empty( $author_id ) && ! empty( $GLOBALS['post']->post_author ) ) {
						$author_id = $GLOBALS['post']->post_author;
					}
					if ( $author_id > 0 ) {
						$author_link   = get_author_posts_url( $author_id );
						$author_name   = get_the_author_meta( 'display_name', $author_id );
						$author_avatar = get_avatar( get_the_author_meta( 'user_email', $author_id ), 32 * scientia_get_retina_multiplier() );
						echo esc_html__( 'by', 'scientia' ).' <a class="post_meta_item post_author" rel="author" href="' . esc_url( $author_link ) . '">'
								. ( scientia_get_theme_setting( 'show_author_avatar' )
									? sprintf( '<span class="post_author_avatar">%s</span>', $author_avatar )
									: ''
									)
								. '<span class="post_author_name">' . esc_html( $author_name ) . '</span>'
							. '</a> ';
					}

				} else if ( 'comments' == $comp ) {
					// Comments
					if ( !is_singular() || have_comments() || comments_open() ) {
						$post_comments = get_comments_number();
						echo '<a href="' . esc_url( get_comments_link() ) . '" class="post_meta_item post_meta_comments icon-comment-light">'
								. '<span class="post_meta_number">' . esc_html( $post_comments ) . '</span>'
								. '<span class="post_meta_label">' . ( ($post_comments === 1) ? esc_html__('Comment', 'scientia') :  esc_html__('Comments', 'scientia') ) . '</span>'
							. '</a> ';
					}

				// Views
				} else if ( 'views' == $comp ) {
					if ( function_exists( 'trx_addons_get_post_views' ) ) {
						$post_views = trx_addons_get_post_views( get_the_ID() );
						echo ( is_singular()
								? '<span'
								: '<a href="' . esc_url( get_permalink() ) . '"'
								)
							. ' class="post_meta_item post_meta_views trx_addons_icon-eye">'
								. '<span class="post_meta_number">' . esc_html( $post_views ) . '</span>'
								. '<span class="post_meta_label">' . ( ($post_views === 1) ? esc_html__('View', 'scientia') :  esc_html__('Views', 'scientia') ) . '</span>'
							. ( is_singular()
								? '</span> '
								: '</a> '
								);
					}

				// Likes (Emotions)
				} else if ( 'likes' == $comp ) {
					if ( function_exists( 'trx_addons_get_post_likes' ) ) {
						$emotions_allowed = trx_addons_is_on( trx_addons_get_option( 'emotions_allowed' ) );
						if ( $emotions_allowed ) {
							$post_emotions = trx_addons_get_post_emotions( get_the_ID() );
							$post_likes = 0;
							if ( is_array( $post_emotions ) ) {
								foreach ( $post_emotions as $v ) {
									$post_likes += (int) $v;
								}
							}
						} else {
							$post_likes = trx_addons_get_post_likes( get_the_ID() );
						}
						$liked = isset( $_COOKIE['trx_addons_likes'] ) ? $_COOKIE['trx_addons_likes'] : '';
						$allow = strpos( $liked, sprintf( ',%d,', get_the_ID() ) ) === false;
						echo ( true == $emotions_allowed
								? '<a href="' . esc_url( trx_addons_add_hash_to_url( get_permalink(), 'trx_addons_emotions' ) ) . '"'
									. ' class="post_meta_item post_meta_emotions trx_addons_icon-angellist">'
								: '<a href="#"'
									. ' class="post_meta_item post_meta_likes trx_addons_icon-heart' . ( ! empty( $allow ) ? '-empty enabled' : ' disabled' ) . '"'
									. ' title="' . ( ! empty( $allow ) ? esc_attr__( 'Like', 'scientia') : esc_attr__( 'Dislike', 'scientia' ) ) . '"'
									. ' data-postid="' . esc_attr( get_the_ID() ) . '"'
									. ' data-likes="' . esc_attr( $post_likes ) . '"'
									. ' data-title-like="' . esc_attr__( 'Like', 'scientia') . '"'
									. ' data-title-dislike="' . esc_attr__( 'Dislike', 'scientia' ) . '"'
									. '>'
								)
									. '<span class="post_meta_number">' . esc_html($post_likes) . '</span>'
									. '<span class="post_meta_label">'
										. ( true == $emotions_allowed
											? ( ($post_likes === 1) ? esc_html__('Reaction', 'scientia') :  esc_html__('Reactions', 'scientia') )
											: ( ($post_likes === 1) ? esc_html__('Like', 'scientia') :  esc_html__('Likes', 'scientia') )
											)
									. '</span>'
								. '</a> ';
					}

				} elseif ( 'share' == $comp ) {
					// Socials share
					scientia_show_share_links(
						array(
							'type'    => $args['share_type'],
							'caption' => 'drop' == $args['share_type'] ? esc_html__( 'Share', 'scientia' ) : '',
							'before'  => '<span class="post_meta_item post_share">',
							'after'   => '</span> ',
						)
					);

				} elseif ( 'edit' == $comp ) {
					// Edit page link
					edit_post_link( esc_html__( 'Edit', 'scientia' ), '', '', 0, 'post_meta_item post_edit icon-pencil' );

				} else {
					// Custom counter
					do_action( 'scientia_action_show_post_meta', $comp, get_the_ID(), $args );
				}
			}
			?>
		</div><!-- .post_meta -->
		<?php
		if ( ! $args['echo'] ) {
			$rez = ob_get_contents();
			ob_end_clean();
			return $rez;
		} else {
			return '';
		}
	}
}

// Show post featured block: image, video, audio, etc.
if ( ! function_exists( 'scientia_show_post_featured' ) ) {
	function scientia_show_post_featured( $args = array() ) {

		$args = array_merge(
			array(
				'hover'         => scientia_get_theme_option( 'image_hover' ), // Hover effect
				'no_links'      => false,                              // Disable links
				'link'          => '',                                 // Alternative (external) link
				'class'         => '',                                 // Additional Class for featured block
				'data'          => array(),                            // Data parameters
				'post_info'     => '',                                 // Additional layout after hover
				'thumb_bg'      => false,                              // Put thumb image as block background or as separate tag
				'thumb_size'    => '',                                 // Image size
				'thumb_ratio'   => '',                                 // Image's ratio for the slider
				'thumb_only'    => false,                              // Display only thumb (without post formats)
				'show_no_image' => scientia_is_on( scientia_get_theme_setting( 'allow_no_image' ) ),  // Display 'no-image.jpg' if post haven't thumbnail
				'seo'           => scientia_is_on( scientia_get_theme_option( 'seo_snippets' ) ),     // Add SEO-snippets
				'singular'      => false                               // Current page is singular (true) or blog/shortcode (false)
			), $args
		);

		if (isset($args['modern_mod']) && $args['modern_mod']) {
			$args['singular'] = $args['thumb_bg'] = true;
		}

		if ( post_password_required() ) {
			return;
		}
		$thumb_size  = ! empty( $args['thumb_size'] )
						? $args['thumb_size']
						: scientia_get_thumb_size( is_attachment() || is_single() ? 'full' : 'big' );
		$post_format = str_replace( 'post-format-', '', get_post_format() );
		$no_image    = ! empty( $args['show_no_image'] ) ? scientia_get_no_image( '', true ) : '';
		if ( $args['thumb_bg'] ) {
			if ( has_post_thumbnail() ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
				$image = $image[0];
			} elseif ( 'image' == $post_format ) {
				$image = scientia_get_post_image();
				if ( ! empty( $image ) ) {
					$image = scientia_add_thumb_size( $image, $thumb_size );
				}
			}
			if ( empty( $image ) ) {
				$image = $no_image;
			}
			if ( ! empty( $image ) ) {
				$args['class'] .= ( $args['class'] ? ' ' : '' ) . 'post_featured_bg' . ' ' . scientia_add_inline_css_class( 'background-image: url(' . esc_url( $image ) . ');' );
			}
		}

		if ( ! empty( $args['singular'] ) ) {

			if ( is_attachment() ) {
				?>
				<div class="post_featured post_attachment
				<?php
				if ( $args['class'] ) {
					echo ' ' . esc_attr( $args['class'] );
				}
				?>
				">
				<?php
				if ( ! $args['thumb_bg'] ) {
					echo wp_get_attachment_image(
						get_the_ID(), $thumb_size, false,
						scientia_is_on( scientia_get_theme_option( 'seo_snippets' ) )
													? array( 'itemprop' => 'image' )
						: ''
					);
				}
				if ( scientia_get_theme_setting( 'attachments_navigation' ) ) {
					?>
						<nav id="image-navigation" class="navigation image-navigation">
							<div class="nav-previous"><?php previous_image_link( false, '' ); ?></div>
							<div class="nav-next"><?php next_image_link( false, '' ); ?></div>
						</nav><!-- .image-navigation -->
						<?php
				}
				?>
				</div><!-- .post_featured -->
				<?php
				if ( has_excerpt() ) {
					?>
					<div class="entry-caption"><?php the_excerpt(); ?></div><!-- .entry-caption -->
					<?php
				}
			} elseif ( has_post_thumbnail() || ! empty( $args['show_no_image'] ) ) {
				$output = '<div class="post_featured' . ( $args['class'] ? ' ' . esc_attr( $args['class'] ) : '' ) . '"'
					. ( $args['seo'] ? ' itemscope itemprop="image" itemtype="//schema.org/ImageObject"' : '')
					. ( ! empty( $args['thumb_bg'] ) && ! empty( $args['thumb_ratio'] ) ? ' data-ratio="' . esc_attr($args['thumb_ratio']) . '"' : '' );
				if ( ! empty( $args['data'] ) && is_array( $args['data'] ) ) {
					foreach( $args['data'] as $k => $v ) {
						$output .= ' data-' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
					}
				}
				$output .= '>';
				scientia_show_layout( $output );
				if ( has_post_thumbnail() && $args['seo'] ) {
					$scientia_attr = scientia_getimagesize( wp_get_attachment_url( get_post_thumbnail_id() ) );
					?>
						<meta itemprop="width" content="<?php echo esc_attr( $scientia_attr[0] ); ?>">
						<meta itemprop="height" content="<?php echo esc_attr( $scientia_attr[1] ); ?>">
						<?php
				}
				if ( ! $args['thumb_bg'] ) {
					if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								$thumb_size, array(
									'itemprop' => 'url',
								)
							);
					} elseif ( ! empty( $no_image ) ) {
						?>
						<img
							<?php
							if ( $args['seo'] ) {
								echo ' itemprop="url"';
							}
							?>
							src="<?php echo esc_url( $no_image ); ?>" alt="<?php the_title_attribute( '' ); ?>">
						<?php
					}
				}

				// Put optional info block over the thumb
				if (isset($args['modern_mod']) && $args['modern_mod']) {
					$post_info = ! empty( $args['post_info'] ) ? $args['post_info'] : '';
					scientia_show_layout( $post_info );
				}

				echo '</div><!-- .post_featured -->';
			} elseif ((isset($args['modern_mod']) && $args['modern_mod'])) {
				$output = '<div class="post_featured' . ( $args['class'] ? ' ' . esc_attr( $args['class'] ) : '' ) . '"'
					. ( $args['seo'] ? ' itemscope itemprop="image" itemtype="//schema.org/ImageObject"' : '')
					. ( ! empty( $args['thumb_bg'] ) && ! empty( $args['thumb_ratio'] ) ? ' data-ratio="' . esc_attr($args['thumb_ratio']) . '"' : '' );
				if ( ! empty( $args['data'] ) && is_array( $args['data'] ) ) {
					foreach( $args['data'] as $k => $v ) {
						$output .= ' data-' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
					}
				}
				$output .= '>';
				scientia_show_layout($output);

				// Put optional info block over the thumb
				$post_info = ! empty( $args['post_info'] ) ? $args['post_info'] : '';
				scientia_show_layout( $post_info );

				echo '</div><!-- .post_featured -->';
			}

		} else {

			if ( empty( $post_format ) ) {
				$post_format = 'standard';
			}
			$has_thumb = has_post_thumbnail();
			$post_info = ! empty( $args['post_info'] ) ? $args['post_info'] : '';
			if ( $has_thumb
				|| ! empty( $args['show_no_image'] )
				|| ( ! $args['thumb_only']
						&& ( in_array( $post_format, array( 'image', 'audio', 'video' ) )
							|| ( 'gallery' == $post_format && scientia_exists_trx_addons() )
							)
					)
			) {
				$output = '<div class="post_featured '
					. ( ! empty( $has_thumb ) || 'image' == $post_format || ! empty( $args['show_no_image'] )
						? ( 'with_thumb' . ( $args['thumb_only']
												|| ! in_array( $post_format, array( 'audio', 'video', 'gallery' ) )
												|| ( 'gallery' == $post_format && ( $has_thumb || $args['thumb_bg'] ) )
													? ' hover_' . esc_attr( $args['hover'] )
													: ( in_array( $post_format, array( 'video' ) ) ? ' hover_play' : '' )
											)
							)
						: 'without_thumb' )
					. ( ! empty( $args['class'] ) ? ' ' . esc_attr( $args['class'] ) : '' )
					. '"'
					. ( ! empty( $args['thumb_bg'] ) && ! empty( $args['thumb_ratio'] ) ? ' data-ratio="' . esc_attr($args['thumb_ratio']) . '"' : '' );
				if ( ! empty( $args['data'] ) && is_array( $args['data'] ) ) {
					foreach( $args['data'] as $k => $v ) {
						$output .= ' data-' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
					}
				}
				$output .= '>';
				scientia_show_layout( $output );
				// Put the thumb or gallery or image or video from the post
				if ( $args['thumb_bg'] ) {
					if ( ! empty( $args['hover'] ) ) {
						?>
						<div class="mask"></div>
						<?php
					}
					if ( ! in_array( $post_format, array( 'audio', 'video', 'gallery' ) ) ) {
						scientia_hovers_add_icons(
							$args['hover'],
							array(
								'no_links' => $args['no_links'],
								'link'     => $args['link'],
							)
						);
					}
				} elseif ( $has_thumb ) {
					the_post_thumbnail(
						$thumb_size, array()
					);
					if ( ! empty( $args['hover'] ) ) {
						?>
						<div class="mask"></div>
						<?php
					}
					if ( $args['thumb_only'] || ! in_array( $post_format, array( 'audio', 'video', 'gallery' ) ) ) {
						scientia_hovers_add_icons(
							$args['hover'],
							array(
								'no_links' => $args['no_links'],
								'link'     => $args['link'],
							)
						);
					}
				} elseif ( false && 'gallery' == $post_format && ! $args['thumb_only'] ) {
					//------- ^^ Start: Moved down --------
					$slider_args = array(
						'thumb_size' => $thumb_size,
						'controls'   => 'yes',
						'pagination' => 'yes',
					);
					if ( isset( $args['thumb_ratio'] ) ) {
						$slider_args['slides_ratio'] = $args['thumb_ratio'];
					}
					$output = scientia_get_slider_layout( $slider_args );
					if ( '' != $output ) {
						scientia_show_layout( $output );
					}
					//------- End: Moved down --------
				} elseif ( 'image' == $post_format ) {
					$image = scientia_get_post_image();
					if ( ! empty( $image ) ) {
						$image = scientia_add_thumb_size( $image, $thumb_size );
						?>
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(''); ?>">
						<?php
						if ( ! empty( $args['hover'] ) ) {
							?>
							<div class="mask"></div>
							<?php
						}
						scientia_hovers_add_icons(
							$args['hover'],
							array(
								'no_links' => $args['no_links'],
								'link'     => $args['link'],
								'image'    => $image,
							)
						);
					}
				} elseif ( ! empty( $args['show_no_image'] ) && ! empty( $no_image ) ) {
					?>
					<img src="<?php echo esc_url( $no_image ); ?>" alt="<?php the_title_attribute(''); ?>">
					<?php
					if ( ! empty( $args['hover'] ) ) {
						?>
						<div class="mask"></div>
						<?php
					}
					scientia_hovers_add_icons(
						$args['hover'],
						array(
							'no_links' => $args['no_links'],
							'link'     => $args['link'],
						)
					);
				}
				// Add audio, video or gallery
				if ( ! $args['thumb_only'] && ( in_array( $post_format, array( 'video', 'audio', 'gallery' ) ) ) ) {
					$post_content = scientia_get_post_content();
					$post_content_parsed = $post_content;

					if ( 'video' == $post_format ) {
						$video = scientia_get_post_video( $post_content, false );
						if ( empty( $video ) ) {
							$video = scientia_get_post_iframe( $post_content, false );
						}
						if ( empty( $video ) ) {
							// Only get video from the content if a playlist isn't present.
							$post_content_parsed = scientia_filter_post_content( $post_content );
							if ( false === strpos( $post_content_parsed, 'wp-playlist-script' ) ) {
								$videos = get_media_embedded_in_content( $post_content_parsed, array( 'video', 'object', 'embed', 'iframe' ) );
								if ( ! empty( $videos ) && is_array( $videos ) ) {
									$video = scientia_array_get_first( $videos, false );
								}
							}
						}
						if ( ! empty( $video ) ) {
							if ( $has_thumb ) {
								$video = scientia_make_video_autoplay( $video );
								?>
								<div class="post_video_hover" data-video="<?php echo esc_attr( $video ); ?>"></div>
								<?php
							}
							?>
							<div class="post_video video_frame">
								<?php
								if ( ! $has_thumb ) {
									scientia_show_layout( $video );
								}
								?>
							</div>
							<?php
						}

					} elseif ( 'audio' == $post_format ) {
						// Put audio over the thumb
						$audio = scientia_get_post_audio( $post_content, false );
						if ( empty( $audio ) ) {
							$audio = scientia_get_post_iframe( $post_content, false );
						}
						// Apply filters to get audio, title and author
						$post_content_parsed = scientia_filter_post_content( $post_content );
						if ( empty( $audio ) ) {
							// Only get audio from the content if a playlist isn't present.
							if ( false === strpos( $post_content_parsed, 'wp-playlist-script' ) ) {
								$audios = get_media_embedded_in_content( $post_content_parsed, array( 'audio' ) );
								if ( ! empty( $audios ) && is_array( $audios ) ) {
									$audio = scientia_array_get_first( $audios, false );
								}
							}
						}
						if ( ! empty( $audio ) ) {
							?>
							<div class="post_audio
								<?php
								if ( strpos( $audio, 'soundcloud' ) !== false ) {
									echo ' with_iframe';
								}
								?>
							">
								<?php
								// Get author and audio title
								$media_author = '';
								$media_title  = '';
								if ( strpos( $audio, '<audio' ) !== false ) {
									$media_author = scientia_get_tag_attrib( $audio, '<audio>', 'data-author' );
									$media_title  = scientia_get_tag_attrib( $audio, '<audio>', 'data-caption' );
								}
								if ( empty( $media_author) &&  empty( $media_title) ) {
									$media = urldecode( scientia_get_tag_attrib( $post_content, '[trx_widget_audio]', 'media' ) );
									if ( ! empty( $media ) ) {
										// Shortcode found in the content
									 	if ( '[{' == substr( $media, 0, 2 ) ) {
											$media = json_decode( $media, true );
											if ( is_array( $media ) ) {
												if ( !empty( $media[0]['author'] ) ) {
													$media_author = $media[0]['author'];
												}
												if ( !empty( $media[0]['caption'] ) ) {
													$media_title = $media[0]['caption'];
												}
											}
										}
									} else {
										// Parse tag params
										$media_author = strip_tags( scientia_get_tag( $post_content_parsed, '<h6 class="audio_author">', '</h6>' ) );
										$media_title  = strip_tags( scientia_get_tag( $post_content_parsed, '<h5 class="audio_caption">', '</h5>' ) );

									}
								}
								if ( ! empty( $media_author ) ) {
									?>
									<div class="post_audio_author"><?php scientia_show_layout( $media_author ); ?></div>
									<?php
								}
								if ( ! empty( $media_title ) ) {
									?>
									<h5 class="post_audio_title"><?php scientia_show_layout( $media_title ); ?></h5>
									<?php
								}
								// Display audio
								scientia_show_layout( $audio );
								?>
							</div>
							<?php
						}

					} elseif ( 'gallery' == $post_format ) {
						$slider_args = array(
							'thumb_size' => $thumb_size,
							'controls'   => 'yes',
							'pagination' => 'yes',
						);
						if ( !empty( $args['thumb_ratio'] ) ) {
							$slider_args['slides_ratio'] = $args['thumb_ratio'];
						}
						$output = scientia_get_slider_layout( $slider_args );
						if ( '' != $output ) {
							scientia_show_layout( $output );
						}
					}
				}
				// Put optional info block over the thumb
				scientia_show_layout( $post_info );
				// Close div.post_featured
				echo '</div>';
			} else {
				// Put optional info block over the thumb
				scientia_show_layout( $post_info );
			}
		}
	}
}


// Return path to the 'no-image'
if ( ! function_exists( 'scientia_get_no_image' ) ) {
	function scientia_get_no_image( $no_image = '', $need = false ) {
		static $no_image_url = '';
		$img = scientia_get_theme_option( 'no_image' );
		if ( empty( $img ) && ( $need || scientia_get_theme_setting( 'allow_no_image' ) ) ) {
			if ( empty( $no_image_url ) ) {
				$no_image_url = scientia_get_file_url( 'images/no-image.jpg' );
			}
			$img = $no_image_url;
		}
		if ( ! empty( $img ) ) {
			$no_image = $img;
		}
		return $no_image;
	}
}


// Add featured image as background image to post navigation elements.
if ( ! function_exists( 'scientia_add_bg_in_post_nav' ) ) {
	function scientia_add_bg_in_post_nav() {
		if ( ! is_single() ) {
			return;
		}

		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		$css      = '';
		$noimg    = scientia_get_no_image();

		if ( is_attachment() && 'attachment' == $previous->post_type ) {
			return;
		}

		if ( $previous ) {
			$img = '';
			if ( has_post_thumbnail( $previous->ID ) ) {
				$img = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), scientia_get_thumb_size( 'med' ) );
				$img = $img[0];
			} else {
				$img = $noimg;
			}
			if ( ! empty( $img ) ) {
				$css .= '.post-navigation .nav-previous a .nav-arrow { background-image: url(' . esc_url( $img ) . '); }';
			} else {
				$css .= '.post-navigation .nav-previous a .nav-arrow { background-color: rgba(128,128,128,0.05); border: 1px solid rgba(128,128,128,0.1); }'
					. '.post-navigation .nav-previous a .nav-arrow:after { top: 0; opacity: 1; }';
			}
		}

		if ( $next ) {
			$img = '';
			if ( has_post_thumbnail( $next->ID ) ) {
				$img = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), scientia_get_thumb_size( 'med' ) );
				$img = $img[0];
			} else {
				$img = $noimg;
			}
			if ( ! empty( $img ) ) {
				$css .= '.post-navigation .nav-next a .nav-arrow { background-image: url(' . esc_url( $img ) . '); }';
			} else {
				$css .= '.post-navigation .nav-next a .nav-arrow { background-color: rgba(128,128,128,0.05); border: 1px solid rgba(128,128,128,0.1); }'
					. '.post-navigation .nav-next a .nav-arrow:after { top: 0; opacity: 1; }';
			}
		}

		wp_add_inline_style( 'scientia-main', $css );
	}
}

// Show related posts
if ( ! function_exists( 'scientia_show_related_posts' ) ) {
	function scientia_show_related_posts( $args = array(), $style = 1, $title = '' ) {
		$args = array_merge(
			array(
				//  Attention! Parameter 'suppress_filters' is damage WPML-queries!
				'ignore_sticky_posts' => true,
				'posts_per_page'      => 2,
				'columns'             => 0,
				'orderby'             => 'rand',
				'order'               => 'DESC',
				'post_type'           => '',
				'post_status'         => 'publish',
				'post__not_in'        => array(),
				'category__in'        => array(),
			), $args
		);

		if ( empty( $args['post_type'] ) ) {
			$args['post_type'] = get_post_type();
		}

		$taxonomy = 'post' == $args['post_type'] ? 'category' : scientia_get_post_type_taxonomy();

		$args['post__not_in'][] = get_the_ID();

		if ( empty( $args['columns'] ) ) {
			$args['columns'] = $args['posts_per_page'];
		}

		if ( empty( $args['category__in'] ) || is_array( $args['category__in'] ) && count( $args['category__in'] ) == 0 ) {
			$post_categories_ids = array();
			$post_cats           = get_the_terms( get_the_ID(), $taxonomy );
			if ( is_array( $post_cats ) && ! empty( $post_cats ) ) {
				foreach ( $post_cats as $cat ) {
					$post_categories_ids[] = $cat->term_id;
				}
			}
			$args['category__in'] = $post_categories_ids;
		}

		if ( 'post' != $args['post_type'] && count( $args['category__in'] ) > 0 ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_taxonomy_id',
					'terms'    => $args['category__in'],
				),
			);
			unset( $args['category__in'] );
		}

		$query = new WP_Query( $args );

		if ( $query->found_posts > 0 ) {
			$slider_args = array();
			$columns = intval( max( 1, min( 6, $args['columns'] ) ) );
			$args['slider'] = (int) scientia_get_theme_option( 'related_slider' ) && min( $args['posts_per_page'], $query->found_posts) > $columns;
			$related_position = scientia_get_theme_option( 'related_position' );
			$related_style = scientia_get_theme_option( 'related_style' );
			$related_tag = strpos( $related_position, 'inside' ) === 0 ? 'h5' : 'h3';
			if ( in_array( $related_position, array( 'inside_left', 'inside_right' ) ) ) {
				$columns = 1;
			}
			?>
			<section class="related_wrap related_position_<?php echo esc_attr( $related_position ); ?> related_style_<?php echo esc_attr( $related_style ); ?>">
				<<?php echo esc_html( $related_tag ); ?> class="section_title related_wrap_title"><?php
					if ( ! empty( $title ) ) {
						echo esc_html( $title );
					} else {
						esc_html_e( 'Related Posts', 'scientia' );
					}
				?></<?php echo esc_html( $related_tag ); ?>><?php
				if ( $args['slider'] ) {
					$slider_args                      = $args;
					$slider_args['count']             = max(1, $query->found_posts);
					$slider_args['slides_min_width']  = 250;
					$slider_args['slides_space']      = scientia_get_theme_option( 'related_slider_space' );
					$slider_args['slider_controls']   = scientia_get_theme_option( 'related_slider_controls' );
					$slider_args['slider_pagination'] = scientia_get_theme_option( 'related_slider_pagination' );
					$slider_args                      = apply_filters( 'scientia_related_posts_slider_args', $slider_args, $query );
					?><div class="related_wrap_slider"><?php
					scientia_get_slider_wrap_start('related_posts_wrap', $slider_args);
				} else {
					?><div class="columns_wrap posts_container columns_padding_bottom"><?php
				}
					while ( $query->have_posts() ) {
						$query->the_post();
						if ( $args['slider'] ) {
							?><div class="slider-slide swiper-slide"><?php
						} else {
							?><div class="column-1_<?php echo intval( max( 1, min( 4, $columns ) ) ); ?>"><?php
						}
						get_template_part( apply_filters( 'scientia_filter_get_template_part', 'templates/related-posts', $style ), $style );
						?></div><?php
					}
				?></div><?php
				if ( $args['slider'] ) {
					scientia_get_slider_wrap_end('related_posts_wrap', $slider_args);
					?></div><!-- /.related_wrap_slider --><?php
				}
				wp_reset_postdata();
				?>
			</section><!-- </.related_wrap> -->
			<?php
		}
	}
}

// Callback for action 'Related posts'
if ( ! function_exists( 'scientia_show_related_posts_callback' ) ) {
	add_action( 'scientia_action_related_posts', 'scientia_show_related_posts_callback' );
	function scientia_show_related_posts_callback() {
		if ( is_single() && ! apply_filters( 'scientia_filter_show_related_posts', false ) ) {
			$scientia_related_posts   = (int) scientia_get_theme_option( 'related_posts' );
			$scientia_related_columns = (int) scientia_get_theme_option( 'related_columns' );
			$scientia_related_style   = scientia_get_theme_option( 'related_style' );
			if ( (int) scientia_get_theme_option( 'show_related_posts' ) && $scientia_related_posts > 0 ) {
				scientia_show_related_posts(
					array(
						'orderby'        => 'rand',
						'posts_per_page' => max( 1, min( 9, $scientia_related_posts ) ),
						'columns'        => max( 1, min( 6, $scientia_related_posts, $scientia_related_columns ) ),
					),
					$scientia_related_style
				);
			}
		}
	}
}


// Show portfolio posts
if ( ! function_exists( 'scientia_show_portfolio_posts' ) ) {
	function scientia_show_portfolio_posts( $args = array() ) {
		$args = array_merge(
			array(
				'cat'        => 0,
				'parent_cat' => 0,
				'taxonomy'   => 'category',
				'post_type'  => 'post',
				'page'       => 1,
				'sticky'     => false,
				'blog_style' => '',
				'echo'       => true,
			), $args
		);

		$blog_style = explode( '_', empty( $args['blog_style'] ) ? scientia_get_theme_option( 'blog_style' ) : $args['blog_style'] );
		$style      = $blog_style[0];
		$columns    = empty( $blog_style[1] ) ? 2 : max( 2, $blog_style[1] );

		if ( ! $args['echo'] ) {
			ob_start();

			$q_args = array(
				'post_status' => current_user_can( 'read_private_pages' ) && current_user_can( 'read_private_posts' )
										? array( 'publish', 'private' )
										: 'publish',
			);
			$q_args = scientia_query_add_posts_and_cats( $q_args, '', $args['post_type'], $args['cat'], $args['taxonomy'] );
			if ( $args['page'] > 1 ) {
				$q_args['paged']               = $args['page'];
				$q_args['ignore_sticky_posts'] = true;
			}
			$ppp = scientia_get_theme_option( 'posts_per_page' );
			if ( 0 != (int) $ppp ) {
				$q_args['posts_per_page'] = (int) $ppp;
			}

			// Make a new query
			$q             = 'wp_query';
			$GLOBALS[ $q ] = new WP_Query( $q_args );
		}

		// Show posts
		$class = sprintf( 'masonry_wrap masonry_%1$d portfolio_wrap posts_container portfolio_%1$d', $columns )
				. ( 'portfolio' != $style ? sprintf( ' %1$s_wrap %1$s_%2$d', $style, $columns ) : '' );
		if ( $args['sticky'] ) {
			?>
			<div class="columns_wrap sticky_wrap">
			<?php
		} else {
			?>
			<div class="<?php echo esc_attr( $class ); ?>">
			<?php
		}

		while ( have_posts() ) {
			the_post();
			if ( $args['sticky'] && ! is_sticky() ) {
				$args['sticky'] = false;
				?>
				</div><div class="<?php echo esc_attr( $class ); ?>">
				<?php
			}
			$scientia_part = $args['sticky'] && is_sticky() ? 'sticky' : ( 'gallery' == $style ? 'portfolio-gallery' : $style );
			get_template_part( apply_filters( 'scientia_filter_get_template_part', 'content', $scientia_part ), $scientia_part );
		}

		?>
		</div>
		<?php

		scientia_show_pagination();

		if ( ! $args['echo'] ) {
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
}

// AJAX handler for the scientia_ajax_get_posts action
if ( ! function_exists( 'scientia_ajax_get_posts_callback' ) ) {
	add_action( 'wp_ajax_scientia_ajax_get_posts', 'scientia_ajax_get_posts_callback' );
	add_action( 'wp_ajax_nopriv_scientia_ajax_get_posts', 'scientia_ajax_get_posts_callback' );
	function scientia_ajax_get_posts_callback() {
		if ( ! wp_verify_nonce( scientia_get_value_gp( 'nonce' ), admin_url( 'admin-ajax.php' ) ) ) {
			wp_die();
		}

		$id = ! empty( $_REQUEST['blog_template'] ) ? wp_kses_data( wp_unslash( $_REQUEST['blog_template'] ) ) : 0;
		if ( (int) $id > 0 ) {
			scientia_storage_set( 'blog_archive', true );
			scientia_storage_set( 'blog_mode', 'blog' );
			scientia_storage_set( 'options_meta', get_post_meta( $id, 'scientia_options', true ) );
		}

		$response = array(
			'error' => '',
			'data'  => scientia_show_portfolio_posts(
				array(
					'cat'        => intval( wp_unslash( $_REQUEST['cat'] ) ),
					'parent_cat' => intval( wp_unslash( $_REQUEST['parent_cat'] ) ),
					'page'       => intval( wp_unslash( $_REQUEST['page'] ) ),
					'post_type'  => trim( wp_unslash( $_REQUEST['post_type'] ) ),
					'taxonomy'   => trim( wp_unslash( $_REQUEST['taxonomy'] ) ),
					'blog_style' => trim( wp_unslash( $_REQUEST['blog_style'] ) ),
					'echo'       => false,
				)
			),
		);

		if ( empty( $response['data'] ) ) {
			$response['error'] = esc_html__( 'Sorry, but nothing matched your search criteria.', 'scientia' );
		}
		echo json_encode( $response );
		wp_die();
	}
}


// Show pagination
if ( ! function_exists( 'scientia_show_pagination' ) ) {
	function scientia_show_pagination( $args = array() ) {
		global $wp_query;
		$pagination = ! empty( $args[ 'pagination' ] )
						? $args[ 'pagination' ]
						: scientia_get_theme_option( 'blog_pagination' );
		$prefix     = ! empty( $args[ 'class_prefix' ] )
						? $args[ 'class_prefix' ]
						: 'nav';
		if ( 'pages' == $pagination ) {
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'prev_text'          => esc_html__( '<', 'scientia' ),
					'next_text'          => esc_html__( '>', 'scientia' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'scientia' ) . ' </span>',
				)
			);
		} elseif ( 'more' == $pagination || 'infinite' == $pagination ) {
			$page_number = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
			if ( $page_number < $wp_query->max_num_pages ) {
				?>
				<div class="<?php echo esc_attr( $prefix ); ?>-links-more
					<?php
					if ( 'infinite' == $pagination ) {
						echo ' ' . esc_attr( $prefix ) . '-links-infinite';
					} else {
						echo ' ' . esc_attr( $prefix ) . '-links-more-button';
					}
					?>
				">
					<?php if ('more' == $pagination) { ?>
						<span class="nav-load-more-line"></span>
					<?php } ?>
					<a class="<?php echo esc_attr( $prefix ); ?>-load-more" href="#" 
						data-page="<?php echo esc_attr( $page_number ); ?>" 
						data-max-page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
						><span><?php esc_html_e( 'Load More', 'scientia' ); ?></span></a>
					<?php if ('more' == $pagination) { ?>
						<span class="nav-load-more-line"></span>
					<?php } ?>
				</div>
				<?php
			}
		} elseif ( 'links' == $pagination ) {
			?>
			<div class="<?php echo esc_attr( $prefix ); ?>-links-old">
				<span class="<?php echo esc_attr( $prefix ); ?>-prev"><?php previous_posts_link( is_search() ? esc_html__( 'Previous posts', 'scientia' ) : esc_html__( 'Newest posts', 'scientia' ) ); ?></span>
				<span class="<?php echo esc_attr( $prefix ); ?>-next"><?php next_posts_link( is_search() ? esc_html__( 'Next posts', 'scientia' ) : esc_html__( 'Older posts', 'scientia' ), $wp_query->max_num_pages ); ?></span>
			</div>
			<?php
		}
	}
}



// Return template for the single field in the comments
if ( ! function_exists( 'scientia_single_comments_field' ) ) {
	function scientia_single_comments_field( $args ) {
		$path_height = 'path' == $args['form_style']
							? ( 'text' == $args['field_type'] ? 75 : 190 )
							: 0;
		$html = '<div class="comments_field comments_' . esc_attr( $args['field_name'] ) . '">'
					. ( 'default' == $args['form_style'] && 'checkbox' != $args['field_type']
						? '<label for="' . esc_attr( $args['field_name'] ) . '" class="' . esc_attr( $args['field_req'] ? 'required' : 'optional' ) . '">' . esc_html( $args['field_title'] ) . '</label>'
						: ''
						)
					. '<span class="sc_form_field_wrap">';
		if ( 'text' == $args['field_type'] ) {
			$html .= '<input id="' . esc_attr( $args['field_name'] ) . '" name="' . esc_attr( $args['field_name'] ) . '" type="text"' . ( 'default' == $args['form_style'] ? ' placeholder="' . esc_attr( $args['field_placeholder'] ) . ( $args['field_req'] ? ' *' : '' ) . '"' : '' ) . ' value="' . esc_attr( $args['field_value'] ) . '"' . ( $args['field_req'] ? ' aria-required="true"' : '' ) . ' />';
		} elseif ( 'checkbox' == $args['field_type'] ) {
			$html .= '<input id="' . esc_attr( $args['field_name'] ) . '" name="' . esc_attr( $args['field_name'] ) . '" type="checkbox" value="' . esc_attr( $args['field_value'] ) . '"' . ( $args['field_req'] ? ' aria-required="true"' : '' ) . ' />'
					. ' <label for="' . esc_attr( $args['field_name'] ) . '" class="' . esc_attr( $args['field_req'] ? 'required' : 'optional' ) . '">' . wp_kses_post( $args['field_title'] ) . '</label>';
		} else {
			$html .= '<textarea id="' . esc_attr( $args['field_name'] ) . '" name="' . esc_attr( $args['field_name'] ) . '"' . ( 'default' == $args['form_style'] ? ' placeholder="' . esc_attr( $args['field_placeholder'] ) . ( $args['field_req'] ? ' *' : '' ) . '"' : '' ) . ( $args['field_req'] ? ' aria-required="true"' : '' ) . ' rows="12"></textarea>';
		}
		if ( 'default' != $args['form_style'] && in_array( $args['field_type'], array( 'text', 'textarea' ) ) ) {
			$html .= '<span class="sc_form_field_hover">'
						. ( 'path' == $args['form_style']
							? '<svg class="sc_form_field_graphic" preserveAspectRatio="none" viewBox="0 0 520 ' . intval( $path_height ) . '" height="100%" width="100%"><path d="m0,0l520,0l0,' . intval( $path_height ) . 'l-520,0l0,-' . intval( $path_height ) . 'z"></svg>'
							: ''
							)
						. ( 'iconed' == $args['form_style']
							? '<i class="sc_form_field_icon ' . esc_attr( $args['field_icon'] ) . '"></i>'
							: ''
							)
						. '<span class="sc_form_field_content" data-content="' . esc_attr( $args['field_title'] ) . '">' . wp_kses_post( $args['field_title'] ) . '</span>'
					. '</span>';
		}
		$html .= '</span></div>';
		return $html;
	}
}
