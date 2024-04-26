<?php

/**
 * Animation
 *
 * @param $css_animation
 *
 * @return string
 */

if ( ! function_exists( 'thim_getCSSAnimation' ) ) {
	function thim_getCSSAnimation( $css_animation ) {
		$output = '';
		if ( $css_animation != '' ) {
			wp_enqueue_script( 'thim-waypoints' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}

		return $output;
	}
}

if ( ! function_exists( 'thim_lp_style_content_course' ) ) {
	function thim_lp_style_content_course() {
		$style_content_course = get_theme_mod( 'thim_style_content_course' );
		if ( isset( $style_content_course ) && empty( $style_content_course ) ) {
			$style_content_course = get_theme_mod( 'thim_layout_content_page' );
		}

		return apply_filters( 'thim-setting-content-course', $style_content_course );
	}
}

if ( ! function_exists( 'thim_lp_style_single_course' ) ) {
	function thim_lp_style_single_course() {
		$layout_single_course = get_theme_mod( 'thim_layout_content_page', 'normal' );

		$custom_single_course = get_post_meta( get_the_ID(), 'thim_mtb_layout_content_page', true );
		if ( $custom_single_course ) {
			$layout_single_course = $custom_single_course;
		}

		return apply_filters( 'thim-setting-content-single-course', $layout_single_course );
	}
}

/**
 * Custom excerpt
 *
 * @param $limit
 *
 * @return array|mixed|string|void
 */
function thim_excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}
	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return '<p>' . wp_strip_all_tags( $excerpt ) . '</p>';
}

if ( ! function_exists( 'thim_str_short' ) ) {
	function thim_str_short( $string, $limit ) {
		$excerpt = explode( ' ', $string, $limit );
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );
			$excerpt = implode( " ", $excerpt ) . ' ...';
		} else {
			$excerpt = implode( " ", $excerpt );
		}

		return $excerpt;
	}
}
/**
 * Get related posts
 *
 * @param     $post_id
 * @param int $number_posts
 *
 * @return WP_Query
 */
function thim_get_related_posts( $post_id, $number_posts = - 1 ) {
	$query = new WP_Query();
	$args  = '';
	if ( $number_posts == 0 ) {
		return $query;
	}
	$args  = wp_parse_args(
		$args, array(
			'posts_per_page'      => $number_posts,
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => 0,
			'category__in'        => wp_get_post_categories( $post_id )
		)
	);
	$query = new WP_Query( $args );

	return $query;
}

/**
 * Check is on page of bbpress
 * @return bool
 */
function thim_use_bbpress() {
	if ( function_exists( 'is_bbpress' ) ) {
		return is_bbpress();
	} else {
		return false;
	}
}

/************ List Comment ***************/
if ( ! function_exists( 'thim_comment' ) ) {
	function thim_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		//extract( $args, EXTR_SKIP );
		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag . ' ' ); ?><?php comment_class( 'description_comment' ) ?>>
		<div class="wrapper-comment">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo '<div class="avatar">';
				echo get_avatar( $comment, $args['avatar_size'] );
				echo '</div>';
			}
			?>
			<div class="comment-right">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'eduma' ) ?></em>
				<?php endif; ?>

				<div class="comment-extra-info">
					<div
						class="author"><span class="author-name"><?php echo get_comment_author_link(); ?></span>
					</div>
					<div class="date" itemprop="commentTime">
						<?php printf( get_comment_date(), get_comment_time() ); ?>
					</div>
					<?php edit_comment_link( esc_html__( 'Edit', 'eduma' ), '', '' ); ?>
					<?php comment_reply_link(
						array_merge(
							$args, array(
								'add_below' => $add_below,
								'depth'     => $depth,
								'max_depth' => $args['max_depth']
							)
						)
					)
					?>
				</div>

				<div class="content-comment">
					<?php comment_text() ?>
				</div>

				<div class="comment-meta" id="div-comment-<?php comment_ID() ?>">

				</div>
			</div>
		</div>
		</<?php echo esc_attr( $tag . ' ' ); ?>
		<?php
	}
}

// dislay setting layout
require THIM_DIR . 'inc/wrapper-before-after.php';
require THIM_DIR . 'inc/templates/page-title.php';

/**
 * @return string
 */
function thim_excerpt_length() {
	$theme_options_data = get_theme_mods();
	if ( isset( $theme_options_data['thim_archive_excerpt_length'] ) ) {
		$length = $theme_options_data['thim_archive_excerpt_length'];
	} else {
		$length = '50';
	}

	return $length;
}

add_filter( 'excerpt_length', 'thim_excerpt_length', 999 );

if ( ! function_exists( 'thim_excerpt_more' ) ) {
	function thim_excerpt_more( $link ) {
		return ' &hellip; ';
	}
}
add_filter( 'excerpt_more', 'thim_excerpt_more' );

/**
 * Social sharing
 */
if ( ! function_exists( 'thim_social_share' ) ) {
	function thim_social_share() {
		$sharings = get_theme_mod( 'group_sharing' );

		if ( isset( $sharings ) && $sharings ) {
			echo '<ul class="thim-social-share">';
			do_action( 'thim_before_social_list' );
			echo '<li class="heading">' . esc_html__( 'Share:', 'eduma' ) . '</li>';
			foreach ( $sharings as $sharing ) {
				switch ( $sharing ) {
					case 'facebook':
						echo '<li><div class="facebook-social"><a target="_blank" class="facebook"  href="https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink() ) . '" title="' . esc_attr__( 'Facebook', 'eduma' ) . '"><i class="fa fa-facebook"></i></a></div></li>';
						break;
					case 'twitter':
						echo '<li><div class="twitter-social"><a target="_blank" class="twitter" href="https://twitter.com/share?url=' . urlencode( get_permalink() ) . '&amp;text=' . rawurlencode( esc_attr( get_the_title() ) ) . '" title="' . esc_attr__( 'Twitter', 'eduma' ) . '"><i class="fa fa-x-twitter"></i></a></div></li>';
						break;
					case 'pinterest':
						echo '<li><div class="pinterest-social"><a target="_blank" class="pinterest"  href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;description=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '&amp;media=' . urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ) . '" onclick="window.open(this.href); return false;" title="' . esc_attr__( 'Pinterest', 'eduma' ) . '"><i class="fa fa-pinterest-p"></i></a></div></li>';
						break;
					case 'linkedin':
						echo '<li><div class="linkedin-social"><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink() ) . '&title=' . rawurlencode( esc_attr( get_the_title() ) ) . '&summary=&source=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '"><i class="fa fa-linkedin-square"></i></a></div></li>';
						break;
				}
			}
			do_action( 'thim_after_social_list' );

			echo '</ul>';
		}
	}
}
add_action( 'thim_social_share', 'thim_social_share' );


if ( ! function_exists( 'thim_multisite_signup_redirect' ) ) {
	function thim_multisite_signup_redirect() {
		if ( is_multisite() ) {
			wp_redirect( wp_registration_url() );
			die();
		}
	}
}
add_action( 'signup_header', 'thim_multisite_signup_redirect' );


/**
 * aq_resize function fake.
 * Aq_Resize
 */
if ( ! class_exists( 'Aq_Resize' ) ) {
	function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
		return $url;
	}
}
/**
 * Display feature image
 *
 * @param $attachment_id
 * @param $size_type
 * @param $width
 * @param $height
 * @param $alt
 * @param $title
 *
 * @return string
 */
if ( ! function_exists( 'thim_get_feature_image' ) ) {
	function thim_get_feature_image( $attachment_id, $size_type = null, $width = null, $height = null, $alt = null, $title = null, $no_lazyload = null ) {

		if ( ! $size_type ) {
			$size_type = 'full';
		}
		$style = '';

		if ( $width && $height ) {
			$src = wp_get_attachment_image_src( $attachment_id, array( trim( $width ), trim( $height ) ) );
			if ( ! empty( $src[1] ) && ! empty( $src[2] ) ) {
				$style = ' width="' . $src[1] . '" height="' . $src[2] . '"';
			}
		} else {
			$src = wp_get_attachment_image_src( $attachment_id, $size_type );
			if ( ! empty( $src[1] ) && ! empty( $src[2] ) ) {
				$style = ' width="' . $src[1] . '" height="' . $src[2] . '"';
			}
		}

		if ( ! $src ) {
			$query_args    = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'meta_query'  => array(
					array(
						'key'     => '_wp_attached_file',
						'compare' => 'LIKE',
						'value'   => 'demo_image.jpg'
					)
				)
			);
			$attachment_id = get_posts( $query_args );
			if ( ! empty( $attachment_id ) && $attachment_id[0] ) {
				$attachment_id = $attachment_id[0]->ID;
				$src           = wp_get_attachment_image_src( $attachment_id, 'full' );
			}
		}


		if ( ! $alt ) {
			$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ? get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) : get_the_title( $attachment_id );
		}
		if ( $no_lazyload == 1 ) {
			$style .= ' data-skip-lazy';
		}
		if ( ! $title ) {
			$title = get_the_title( $attachment_id );
		}

		if ( empty( $src ) ) {
			return '<img src="' . esc_url( THIM_URI . 'images/demo_images/demo_image.jpg' ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" ' . $style . '>';
		}

		return '<img src="' . esc_url( $src[0] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" ' . $style . '>';

	}
}


/**
 * Change default comment fields
 *
 * @param $field
 *
 * @return string
 */
if ( ! function_exists( 'thim_new_comment_fields' ) ) {
	function thim_new_comment_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? 'aria-required=true' : '' );

		$fields = array(
			'author' => '<p class="comment-form-author">' . '<input placeholder="' . esc_attr__( 'Name', 'eduma' ) . ( $req ? ' *' : '' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email">' . '<input placeholder="' . esc_attr__( 'Email', 'eduma' ) . ( $req ? ' *' : '' ) . '" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></p>',
			'url'    => '<p class="comment-form-url">' . '<input placeholder="' . esc_attr__( 'Website', 'eduma' ) . ( $req ? ' *' : '' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" ' . $aria_req . ' /></p>',
		);

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'thim_new_comment_fields', 1 );


/**
 * Remove Emoji scripts
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


/**
 * Optimize script files
 */
if ( ! function_exists( 'thim_optimize_scripts' ) ) {
	function thim_optimize_scripts() {
		global $wp_scripts;
		if ( ! is_a( $wp_scripts, 'WP_Scripts' ) ) {
			return;
		}
		foreach ( $wp_scripts->registered as $handle => $script ) {
			$wp_scripts->registered[ $handle ]->ver = null;
		}
	}
}


/**
 * Optimize style files
 */
if ( ! function_exists( 'thim_optimize_styles' ) ) {
	function thim_optimize_styles() {
		global $wp_styles;
		if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
			return;
		}
		foreach ( $wp_styles->registered as $handle => $style ) {
			if ( $handle !== 'thim-rtl' ) {
				$wp_styles->registered[ $handle ]->ver = null;
			}
		}
	}
}
/**
 * Remove query string in css files & js files
 */
$theme_remove_string = apply_filters( 'thim_no_remove_query_string', false );
if ( $theme_remove_string ) {
	add_action( 'wp_print_scripts', 'thim_optimize_scripts', 999 );
	add_action( 'wp_print_footer_scripts', 'thim_optimize_scripts', 999 );
	add_action( 'admin_print_styles', 'thim_optimize_styles', 999 );
	add_action( 'wp_print_styles', 'thim_optimize_styles', 999 );
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 *
 * @return array
 */
function thim_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

add_filter( 'wp_page_menu_args', 'thim_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
if ( ! function_exists( 'thim_body_classes' ) ) {
	function thim_body_classes( $classes ) {
		$item_only = ! empty( $_REQUEST['content-item-only'] ) ? $_REQUEST['content-item-only'] : false;
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		if ( get_theme_mod( 'thim_body_custom_class', false ) ) {
			$classes[] = get_theme_mod( 'thim_body_custom_class', false );
		}

		if ( is_rtl() ) {
			$classes[] = 'rtl';
		}

		if ( get_theme_mod( 'thim_preload', true ) && empty( $item_only ) && ! is_page_template( 'page-templates/blank-page.php' ) && ! is_admin() ) {
			if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'tve_lead_shortcode' && isset( $_GET['tve'] ) && $_GET['tve'] === 'true' ) {
				# do nothings
			} else {
				$classes[] = 'thim-body-preload';
			}
		} else {
			$classes[] = 'thim-body-load-overlay';
		}

		if ( get_theme_mod( 'thim_box_layout', 'wide' ) == 'boxed' ) {
			$classes[] = 'boxed-area';
		}

		if ( get_theme_mod( 'thim_bg_boxed_type', 'image' ) == 'image' ) {
			$classes[] = 'bg-boxed-image';
		} else {
			$classes[] = 'bg-boxed-pattern';
		}

		if ( get_theme_mod( 'thim_size_body', '' ) == 'wide' ) {
			$classes[] = 'size_wide';
		}
		//
		if ( thim_lp_style_single_course() != 'normal' ) {
			$classes[] = 'thim-style-content-' . thim_lp_style_single_course();
		}

		if ( thim_lp_style_content_course() != 'normal' ) {
			$classes[] = 'thim-course-content-' . esc_attr( thim_lp_style_content_course() );
		}

		if ( get_theme_mod( 'thim_content_course_border', false ) == true ) {
			$classes[] = 'thim-border-radius';
		}

		if ( is_archive() ) {
			// switch layout
			$style_switch_layout = get_theme_mod( 'thim_switch_layout_style' );
			// fix old option
			if ( $style_switch_layout == '' && thim_lp_style_single_course() == 'new-1' ) {
				$style_switch_layout = 'style_1';
			} elseif ( $style_switch_layout == '' && thim_lp_style_single_course() == 'layout_style_2' ) {
				$style_switch_layout = 'style_2';
			}
			if ( $style_switch_layout ) {
				$classes[] = 'switch-layout-' . $style_switch_layout;
			}
		}

		if ( get_theme_mod( 'thim_learnpress_single_popup', true ) ) {
			$classes[] = 'thim-popup-feature';
		}

		if ( thim_is_new_learnpress( '4.0.0' ) ) {
			$classes[] = 'learnpress-v4';
		}
		// Fix before loader
		if ( ( get_theme_mod( 'thim_header_sticky', false ) && ! ( is_singular( 'lpr_course' ) || is_singular( 'lp_course' ) ) ) || thim_eduma_header_position() == 'header_overlay' ) {
			$classes[] = 'fixloader';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'thim_body_classes' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * @return void
 * @global WP_Query $wp_query WordPress Query object.
 */
function thim_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'thim_setup_author' );


/**
 * Check a plugin activate
 *
 * @param $plugin
 *
 * @return bool
 */
function thim_plugin_active( $plugin ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( $plugin ) ) {
		return true;
	}

	return false;
}

/**
 * Display post thumbnail by default
 *
 * @param $size
 */

add_action( 'thim_entry_top', 'thim_regites_query_post_format_gallery', 19 );
if ( ! function_exists( 'thim_regites_query_post_format_gallery' ) ) {
	function thim_regites_query_post_format_gallery() {
		if ( get_post_format() == 'gallery' ) {
			wp_enqueue_script( 'flexslider' );
		}
	}
}

if ( ! function_exists( 'thim_default_get_post_thumbnail' ) ) {
	function thim_default_get_post_thumbnail( $size ) {

		if ( thim_plugin_active( 'thim-core/thim-core.php' ) ) {
			return;
		}

		if ( get_the_post_thumbnail( get_the_ID(), $size ) ) {
			?>
			<div class='post-formats-wrapper'>
				<a class="post-image" href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo get_the_post_thumbnail( get_the_ID(), $size ); ?>
				</a>
			</div>
			<?php
		}
	}
}
add_action( 'thim_entry_top', 'thim_default_get_post_thumbnail', 20 );


/**
 * Check images for ssl
 */
if ( ! function_exists( 'thim_ssl_secure_url' ) ) {
	function thim_ssl_secure_url( $sources ) {
		$scheme = parse_url( site_url(), PHP_URL_SCHEME );
		if ( 'https' == $scheme ) {
			if ( stripos( $sources, 'http://' ) === 0 ) {
				$sources = 'https' . substr( $sources, 4 );
			}

			return $sources;
		}

		return $sources;
	}
}

if ( ! function_exists( 'thim_ssl_secure_image_srcset' ) ) {
	function thim_ssl_secure_image_srcset( $sources ) {
		$scheme = parse_url( site_url(), PHP_URL_SCHEME );
		if ( 'https' == $scheme ) {
			foreach ( $sources as &$source ) {
				if ( stripos( $source['url'], 'http://' ) === 0 ) {
					$source['url'] = 'https' . substr( $source['url'], 4 );
				}
			}

			return $sources;
		}

		return $sources;
	}
}

add_filter( 'wp_calculate_image_srcset', 'thim_ssl_secure_image_srcset' );
add_filter( 'wp_get_attachment_url', 'thim_ssl_secure_url', 1000 );
add_filter( 'image_widget_image_url', 'thim_ssl_secure_url' );


/**
 * Testing with CF7 scripts
 */
if ( ! function_exists( 'thim_disable_cf7_cache' ) ) {
	function thim_disable_cf7_cache() {
		global $wp_scripts;
		if ( ! empty( $wp_scripts->registered['contact-form-7'] ) ) {
			if ( ! empty( $wp_scripts->registered['contact-form-7']->extra['data'] ) ) {
				$localize                                                = $wp_scripts->registered['contact-form-7']->extra['data'];
				$localize                                                = str_replace( '"cached":"1"', '"cached":0', $localize );
				$wp_scripts->registered['contact-form-7']->extra['data'] = $localize;
			}
		}
	}
}

add_action( 'wpcf7_enqueue_scripts', 'thim_disable_cf7_cache' );

/**
 * Function thim_related_our_team
 */
if ( ! function_exists( 'thim_related_our_team' ) ) {
	function thim_related_our_team( $post_id, $number_posts = - 1 ) {
		$query = new WP_Query();
		$args  = '';
		if ( $number_posts == 0 ) {
			return $query;
		}
		$args  = wp_parse_args(
			$args, array(
				'posts_per_page'      => $number_posts,
				'post_type'           => 'our_team',
				'post__not_in'        => array( $post_id ),
				'ignore_sticky_posts' => true,
				'tax_query'           => array(
					array(
						'taxonomy' => 'our_team_category',
						// taxonomy name
						'field'    => 'term_id',
						// term_id, slug or name
						'operator' => 'IN',
						'terms'    => wp_get_post_terms( $post_id, 'our_team_category', array( "fields" => "ids" ) ),
						// term id, term slug or term name
					)
				),
			)
		);
		$query = new WP_Query( $args );

		return $query;
	}
}

/**
 * Replace password message
 */
if ( ! function_exists( 'thim_replace_retrieve_password_message' ) ) {
	function thim_replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {

		$reset_link = add_query_arg(
			array(
				'action' => 'rp',
				'key'    => $key,
				'login'  => rawurlencode( $user_login )
			), thim_get_login_page_url()
		);

		// Create new message
		$message = __( 'Someone has requested a password reset for the following account:', 'eduma' ) . "\n";
		$message .= sprintf( __( 'Site Name: %s', 'eduma' ), network_home_url( '/' ) ) . "\n";
		$message .= sprintf( __( 'Username: %s', 'eduma' ), $user_login ) . "\n";
		$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'eduma' ) . "\n";
		$message .= __( 'To reset your password, visit the following address:', 'eduma' ) . "\n";
		$message .= $reset_link . "\n";

		return $message;
	}
}
/**
 * Add filter if without using wpengine
 */
if ( ! function_exists( 'is_wpe' ) && ! function_exists( 'is_wpe_snapshot' ) ) {
	add_filter( 'retrieve_password_message', 'thim_replace_retrieve_password_message', 10, 4 );
}

/**
 * Related portfolio
 */
if ( ! function_exists( 'thim_related_portfolio' ) ) {
	function thim_related_portfolio( $post_id ) {

		?>
		<div class="related-portfolio col-md-12">
			<div class="module_title"><h4 class="widget-title"><?php esc_html_e( 'Related Items', 'eduma' ); ?></h4>
			</div>

			<?php //Get Related posts by category	-->
			$args      = array(
				'posts_per_page' => 3,
				'post_type'      => 'portfolio',
				'post_status'    => 'publish',
				'post__not_in'   => array( $post_id )
			);
			$port_post = get_posts( $args );
			?>

			<ul class="row">
				<?php
				foreach ( $port_post as $post ) : setup_postdata( $post ); ?>
					<?php
					$bk_ef = get_post_meta( $post->ID, 'thim_portfolio_bg_color_ef', true );
					if ( $bk_ef == '' ) {
						$bk_ef = get_post_meta( $post->ID, 'thim_portfolio_bg_color_ef', true );
						$bg    = '';
					} else {
						$bk_ef = get_post_meta( $post->ID, 'thim_portfolio_bg_color_ef', true );
						$bg    = 'style="background-color:' . $bk_ef . ';"';
					}
					?>
					<li class="col-sm-4">
						<?php

						$imImage = get_permalink( $post->ID );

						$image_url = thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'thim_portfolio_thumbnail_width', 480 ), apply_filters( 'thim_portfolio_thumbnail_height', 320 ) );
						echo '<div data-color="' . $bk_ef . '" ' . $bg . '>';
						echo '<div class="portfolio-image" ' . $bg . '>' . $image_url . '
						<div class="portfolio_hover"><div class="thumb-bg"><div class="mask-content">';
						echo '<h3><a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" >' . get_the_title( $post->ID ) . '</a></h3>';
						echo '<span class="p_line"></span>';
						$terms    = get_the_terms( $post->ID, 'portfolio_category' );
						$cat_name = "";
						if ( $terms && ! is_wp_error( $terms ) ) :
							foreach ( $terms as $term ) {
								if ( $cat_name ) {
									$cat_name .= ', ';
								}
								$cat_name .= '<a href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . "</a>";
							}
							echo '<div class="cat_portfolio">' . $cat_name . '</div>';
						endif;
						echo '<a href="' . esc_url( $imImage ) . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" class="btn_zoom ">' . esc_html__( 'Zoom', 'eduma' ) . '</a>';
						echo '</div></div></div></div></div>';
						?>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
	}
}

add_action( 'wp_ajax_thim_gallery_popup', 'thim_gallery_popup' );
add_action( 'wp_ajax_nopriv_thim_gallery_popup', 'thim_gallery_popup' );
/**
 * Function ajax widget gallery-posts
 */
if ( ! function_exists( 'thim_gallery_popup' ) ) {
	function thim_gallery_popup() {
		global $post;
		$post_id = $_POST["post_id"];
		$post    = get_post( $post_id );

		$format = get_post_format( $post_id->ID );

		$error = true;
		$link  = get_edit_post_link( $post_id );
		ob_start();

		if ( $format == 'video' ) {
			$url_video = get_post_meta( $post_id, 'thim_video', true );
			if ( empty( $url_video ) ) {
				echo '<div class="thim-gallery-message"><a class="link" href="' . $link . '">' . esc_html__( 'This post doesn\'t have config video, please add the video!', 'eduma' ) . '</a></div>';
			}
			// If URL: show oEmbed HTML
			if ( filter_var( $url_video, FILTER_VALIDATE_URL ) ) {
				if ( $oembed = @wp_oembed_get( $url_video ) ) {
					echo '<div class="video">' . $oembed . '</div>';
				}
			} else {
				echo '<div class="video">' . $url_video . '</div>';
			}

		} else {
			$images = thim_meta( 'thim_gallery', "type=image&single=false&size=full" );
			// Get category permalink

			if ( ! empty( $images ) ) {
				foreach ( $images as $k => $value ) {
					$url_image = $value['url'];
					if ( $url_image && $url_image != '' ) {
						echo '<a href="' . $url_image . '">';
						echo '<img src="' . $url_image . '" />';
						echo '</a>';
						$error = false;
					}
				}
			}
			if ( $error ) {
				if ( is_user_logged_in() ) {
					echo '<div class="thim-gallery-message"><a class="link" href="' . $link . '">' . esc_html__( 'This post doesn\'t have any gallery images, please add some!', 'eduma' ) . '</a></div>';
				} else {
					echo '<div class="thim-gallery-message">' . esc_html__( 'This post doesn\'t have any gallery images, please add some!', 'eduma' ) . '</div>';
				}

			}
		}

		$output = ob_get_contents();
		ob_end_clean();
		echo ent2ncr( $output );
		die();
	}
}

/**
 * LearnPress section
 */
function thim_eduma_child_locate_template() {
	$base_directory = basename( get_stylesheet_directory() );
	if ( ( $base_directory == 'eduma-child-kid-art' ) || ( $base_directory == 'eduma-child-kindergarten' ) || ( $base_directory == 'eduma-child-new-art' ) || ( $base_directory == 'eduma-child-udemy' ) ) {
		return $base_directory;
	} else {
		return '';
	}
}

if ( class_exists( 'LearnPress' ) ) {
	$field_course_offline = true;

	require_once THIM_DIR . 'inc/learnpress-functions.php';
	if ( thim_is_new_learnpress( '4.0.0' ) ) {
		require_once THIM_DIR . 'inc/learnpress-v4-functions.php';
		function thim_new_learnpress_template_path( $slash ) {
			return 'learnpress-v4';
		}

		add_filter( 'learn_press_template_path', 'thim_new_learnpress_template_path', 999 );
	} else {
		add_filter( 'thim_required_plugin_sp_lp3', '__return_true' );
		add_action( 'admin_notices', 'theme_show_note_use_plugin_support_lernpress_v3', 5 );
		function theme_show_note_use_plugin_support_lernpress_v3() {
			if ( ! defined( 'EDUMA_LP_SP_V3_VERSION' ) ) {
				echo '<div class="notice notice-error"><p>Please install plugin <a href="' . admin_url( 'admin.php?page=thim-plugins' ) . '">Theme Eduma Layout LearnPress V3</a> or Update LearnPress to last version</p></div>';
			}
		}
	}

	if ( is_child_theme() === true && thim_is_new_learnpress( '4.0.0' ) ) {
		$base_directory = thim_eduma_child_locate_template();
		add_filter( 'learn_press_child_in_parrent_template_path', 'thim_eduma_child_locate_template', 999 );
		if ( $base_directory ) {
			require_once THIM_DIR . 'lp-child-path/learnpress-v4/' . $base_directory . '/custom-functions-child.php';
			$field_course_offline = false;
		}
	}
	if ( get_theme_mod( 'thim_single_course_offline', false ) == true && $field_course_offline ) {
		require_once THIM_DIR . 'inc/lp-course_offline.php';
	}
}

/**
 * Check new version of LearnPress
 *
 * @return mixed
 */
function thim_is_new_learnpress( $version ) {
	if ( defined( 'LEARNPRESS_VERSION' ) ) {
		return version_compare( LEARNPRESS_VERSION, $version, '>=' );
	} else {
		return version_compare( get_option( 'learnpress_version' ), $version, '>=' );
	}
}

/**
 * Check new version of addons LearnPress woo
 *
 * @return mixed
 */
function thim_is_version_addons_woo( $version ) {
	if ( defined( 'LP_ADDON_WOO_PAYMENT_VER' ) ) {
		return ( version_compare( LP_ADDON_WOO_PAYMENT_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Check new version of addons LearnPress course review
 *
 * @return mixed
 */
function thim_is_version_addons_review( $version ) {
	if ( defined( 'LP_ADDON_COURSE_REVIEW_VER' ) ) {
		return ( version_compare( LP_ADDON_COURSE_REVIEW_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Check new version of addons LearnPress bbpress
 *
 * @return mixed
 */
function thim_is_version_addons_bbpress( $version ) {
	if ( defined( 'LP_ADDON_BBPRESS_VER' ) ) {
		return ( version_compare( LP_ADDON_BBPRESS_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Check new version of addons LearnPress certificate
 *
 * @return mixed
 */
function thim_is_version_addons_certificates( $version ) {
	if ( defined( 'LP_ADDON_CERTIFICATES_VER' ) ) {
		return ( version_compare( LP_ADDON_CERTIFICATES_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Check new version of addons LearnPress wishlist
 *
 * @return mixed
 */
function thim_is_version_addons_wishlist( $version ) {
	if ( defined( 'LP_ADDON_WISHLIST_VER' ) ) {
		return ( version_compare( LP_ADDON_WISHLIST_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Check new version of addons LearnPress Woo Payment
 *
 * @return mixed
 */
function thim_is_version_addons_woo_payment( $version ) {
	if ( defined( 'LP_ADDON_WOO_PAYMENT_VER' ) ) {
		return ( version_compare( LP_ADDON_WOO_PAYMENT_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Check new version of addons LearnPress Co-instructor
 *
 * @return mixed
 */
function thim_is_version_addons_instructor( $version ) {
	if ( defined( 'LP_ADDON_CO_INSTRUCTOR_VER' ) ) {
		return ( version_compare( LP_ADDON_CO_INSTRUCTOR_VER, $version, '>=' ) );
	}

	return false;
}

/**
 * Define ajaxurl if not exist
 */
if ( ! function_exists( 'thim_define_ajaxurl' ) ) {
	function thim_define_ajaxurl() {
		?>
		<script type="text/javascript">
			if (typeof ajaxurl === 'undefined') {
				/* <![CDATA[ */
				var ajaxurl = "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>"
				/* ]]> */
			}
		</script>
		<?php
	}
}
add_action( 'wp_head', 'thim_define_ajaxurl', 1000 );

/**
 * Add js for thim-preload
 */
if ( ! function_exists( 'thim_js_inline_windowload' ) ) {
	function thim_js_inline_windowload() {
		$item_only = ! empty( $_REQUEST['content-item-only'] ) ? $_REQUEST['content-item-only'] : false;
		if ( get_theme_mod( 'thim_preload', true ) && empty( $item_only ) && ! is_admin() ) {
			?>
			<script data-cfasync="false" type="text/javascript">
				window.onload = function () {
					var thim_preload = document.getElementById('preload')
					if (thim_preload) {
						setTimeout(function () {
							var body = document.body;
							len = body.childNodes.length,
								class_name = body.className.replace(/(?:^|\s)thim-body-preload(?!\S)/, '').replace(/(?:^|\s)thim-body-load-overlay(?!\S)/, '')

							body.className = class_name
							if (typeof thim_preload !== 'undefined' && thim_preload !== null) {
								for (var i = 0; i < len; i++) {
									if (body.childNodes[i].id !== 'undefined' && body.childNodes[i].id == 'preload') {
										body.removeChild(body.childNodes[i])
										break
									}
								}
							}
						}, 500)
					} else {

					}
				}
			</script>
			<?php
		}
		?>
		<script>
			window.addEventListener('load', function () {
				setTimeout(function () {
					var $ = jQuery
					var $carousel = $('.thim-owl-carousel-post').each(function () {
						$(this).find('.image').css('min-height', 0)
						$(window).trigger('resize')
					})
				}, 500)
			})
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'thim_js_inline_windowload' );


/**
 * @param $output
 * @param $args
 *
 * @return string
 */
if ( ! function_exists( 'thim_polylang_dropdown' ) ) {
	function thim_polylang_dropdown( $output, $args ) {

		if ( $args['dropdown'] ) {
			$languages        = PLL()->model->get_languages_list();
			$current_language = $list = '';

			foreach ( $languages as $language ) {
				if ( pll_current_language() == $language->slug ) {
					$current_language = '<a class="lang-item active" href="' . $language->home_url . '"><img src="' . $language->flag_url . '" alt="' . $language->slug . '" />' . $language->name . '</a>';
				}
				$list .= '<li class="lang-item"><a class="lang-select" href="' . $language->home_url . '"><img src="' . $language->flag_url . '" alt="' . $language->slug . '" />' . $language->name . '</a></li>';
			}

			$output = sprintf(
				'<div class="thim-language" id="lang_choice_polylang-3">%s<ul class="list-lang">%s</ul></div>',
				$current_language, $list
			);
		}

		return $output;
	}
}
add_filter( 'pll_the_languages', 'thim_polylang_dropdown', 10, 2 );


/*
 * Remove login page link in the email new user notification
 * */

// Detect thim register form
function thim_check_user_notification_option() {
	global $wp;

	if ( ! empty( $_REQUEST['modify_user_notification'] ) ) {
		$wp->query_vars['modify_user_notification'] = 1;
	}
}

add_action( 'retrieve_password_key', 'thim_check_user_notification_option' );

/**
 * Get current url
 */
if ( ! function_exists( 'thim_get_current_url' ) ) {
	function thim_get_current_url() {
		static $current_url;
		if ( ! $current_url ) {
			if ( ! empty( $_REQUEST['login'] ) ) {
				$url = add_query_arg( array( 'login' => rawurlencode( $_REQUEST['login'] ) ) );
			} else {
				$url = add_query_arg();
			}

			if ( is_multisite() ) {
				if ( ! preg_match( '!^https?!', $url ) ) {
					$segs1 = explode( '/', get_site_url() );
					$segs2 = explode( '/', $url );
					if ( $removed = array_intersect( $segs1, $segs2 ) ) {
						$segs2 = array_diff( $segs2, $removed );
						$url   = get_site_url() . '/' . join( '/', $segs2 );
					}
				}
			} else {
				if ( ! preg_match( '!^https?!', $url ) ) {
					$segs1 = explode( '/', home_url( '/' ) );
					$segs2 = explode( '/', $url );
					if ( $removed = array_intersect( $segs1, $segs2 ) ) {
						$segs2 = array_diff( $segs2, $removed );
						$url   = home_url( '/' ) . join( '/', $segs2 );
					}
				}
			}

			$current_url = $url;

		}

		return $current_url;
	}
}

/**
 * Check is current url
 */
if ( ! function_exists( 'thim_is_current_url' ) ) {
	function thim_is_current_url( $url ) {
		return strcmp( thim_get_current_url(), $url ) == 0;
	}
}


/**
 * Check is course
 */
if ( ! function_exists( 'thim_check_is_course' ) ) {
	function thim_check_is_course() {
		if ( function_exists( 'learn_press_is_courses' ) && learn_press_is_courses() ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Check is course taxonomy
 */
if ( ! function_exists( 'thim_check_is_course_taxonomy' ) ) {
	function thim_check_is_course_taxonomy() {
		if ( function_exists( 'learn_press_is_course_taxonomy' ) && learn_press_is_course_taxonomy() ) {
			return true;
		} else {
			return false;
		}
	}
}
if ( ! function_exists( 'thim_check_is_profile' ) ) {
	function thim_check_is_profile() {
		if ( function_exists( 'learn_press_is_profile' ) && learn_press_is_profile() ) {
			return true;
		} else {
			return false;
		}
	}
}
if ( ! function_exists( 'thim_check_learnpress' ) ) {
	function thim_check_learnpress() {
		if ( function_exists( 'is_learnpress' ) && is_learnpress() ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Remove redirect register url buddypress
 */
remove_filter( 'register_url', 'bp_get_signup_page' );
remove_action( 'bp_init', 'bp_core_wpsignup_redirect' );

/**
 * Remove additional CSS
 */
if ( ! function_exists( 'thim_wp_get_custom_css' ) ) {
	function thim_wp_get_custom_css() {
		return false;
	}
}
add_filter( 'wp_get_custom_css', 'thim_wp_get_custom_css' );

/**
 * Remove vc hook that prevents upgrading from theme
 *
 * @return mixed
 */
if ( ! function_exists( 'thim_remove_vc_hooks' ) ) {
	function thim_remove_vc_hooks() {

		global $vc_manager;
		if ( ! $vc_manager ) {
			return false;
		}
		global $wp_filter;

		$tag = 'upgrader_pre_download';
		if ( empty( $wp_filter[ $tag ] ) ) {
			return false;
		}

		/**
		 * Since WP 4.7
		 */
		if ( $wp_filter[ $tag ] instanceof WP_Hook ) {
			if ( empty( $wp_filter[ $tag ]->callbacks ) ) {
				return false;
			}
			$hook        = &$wp_filter[ $tag ];
			$remove_keys = array();
			foreach ( $hook->callbacks as $priority => $filter ) {
				foreach ( $hook->callbacks[ $priority ] as $k => $v ) {
					$callback = $v['function'];
					if ( $callback[0] instanceof Vc_Updater && $callback[1] == 'preUpgradeFilter' ) {
						if ( empty( $remove_keys[ $priority ] ) ) {
							$remove_keys[ $priority ] = array();
						}
						$remove_keys[ $priority ][] = $k;
					}
				}
			}
			if ( $remove_keys ) {
				foreach ( $remove_keys as $priority => $keys ) {
					foreach ( $keys as $key ) {
						if ( ! empty( $hook->callbacks[ $priority ][ $key ] ) ) {
							unset( $hook->callbacks[ $priority ][ $key ] );
						}
						if ( array_key_exists( $priority, $hook->callbacks ) && empty( $hook->callbacks[ $priority ] ) ) {
							unset( $hook->callbacks[ $priority ] );
						}
					}
				}
			}

			return $wp_filter;
		}

		/**
		 * Backward compatibility for other version of WP
		 */
		return _thim_backward_remove_vc_hooks();
	}
}

/**
 * Backward compatibility remove vc hook for WP version less than 4.7
 */
if ( ! function_exists( '_thim_backward_remove_vc_hooks' ) ) {
	function _thim_backward_remove_vc_hooks() {
		global $wp_filter;
		$tag         = 'upgrader_pre_download';
		$remove_keys = array();

		foreach ( $wp_filter[ $tag ] as $priority => $filter ) {
			foreach ( $wp_filter[ $tag ][ $priority ] as $k => $v ) {
				$callback = $v['function'];
				if ( $callback[0] instanceof Vc_Updater && $callback[1] == 'preUpgradeFilter' ) {
					if ( empty( $remove_keys[ $priority ] ) ) {
						$remove_keys[ $priority ] = array();
					}
					$remove_keys[ $priority ][] = $k;
				}
			}
		}
		if ( $remove_keys ) {
			foreach ( $remove_keys as $priority => $keys ) {
				foreach ( $keys as $key ) {
					if ( ! empty( $wp_filter[ $tag ][ $priority ][ $key ] ) ) {
						unset( $wp_filter[ $tag ][ $priority ][ $key ] );
					}
					if ( array_key_exists( $priority, $wp_filter[ $tag ] ) && empty( $wp_filter[ $tag ][ $priority ] ) ) {
						unset( $wp_filter[ $tag ][ $priority ] );
					}
					if ( array_key_exists( $tag, $wp_filter ) && empty( $wp_filter[ $tag ] ) ) {
						unset( $wp_filter[ $tag ] );
					}
				}
			}
		}

		return $wp_filter;
	}
}
add_action( 'vc_before_mapping', 'thim_remove_vc_hooks' );

/**
 * Add excerpt field to page
 */
if ( ! function_exists( 'thim_update_page_features' ) ) {
	function thim_update_page_features() {
		add_post_type_support( 'page', 'excerpt' );
	}
}
add_action( 'init', 'thim_update_page_features', 100 );


/**
 * Add google analytics & facebook pixel code
 */
if ( ! function_exists( 'thim_add_marketing_code' ) ) {
	function thim_add_marketing_code() {
		$custom_js = get_theme_mod( 'thim_custom_js', '' );
		if ( ! empty( get_theme_mod( 'thim_google_analytics', '' ) ) ) {
			?>
			<script>
				(function (i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r
					i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date()
					a = s.createElement(o),
						m = s.getElementsByTagName(o)[0]
					a.async = 1
					a.src = g
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga')

				ga('create', '<?php echo esc_html( get_theme_mod( 'thim_google_analytics', '' ) ); ?>', 'auto')
				ga('send', 'pageview')
			</script>
			<?php
		}
		if ( ! empty( get_theme_mod( 'thim_facebook_pixel', '' ) ) ) {
			?>
			<script>
				!function (f, b, e, v, n, t, s) {
					if (f.fbq) return
					n = f.fbq = function () {
						n.callMethod ?
							n.callMethod.apply(n, arguments) : n.queue.push(arguments)
					}
					if (!f._fbq) f._fbq = n
					n.push = n
					n.loaded = !0
					n.version = '2.0'
					n.queue = []
					t = b.createElement(e)
					t.async = !0
					t.src = v
					s = b.getElementsByTagName(e)[0]
					s.parentNode.insertBefore(t, s)
				}(window, document, 'script',
					'https://connect.facebook.net/en_US/fbevents.js')
				fbq('init', '<?php echo esc_html( get_theme_mod( 'thim_facebook_pixel', '' ) ); ?>')
				fbq('track', 'PageView')
			</script>
			<noscript>
				<img height="1" width="1" style="display:none"
					 src="https://www.facebook.com/tr?id=<?php echo esc_attr( get_theme_mod( 'thim_facebook_pixel', '' ) ); ?>&ev=PageView&noscript=1"/>
			</noscript>
			<?php
		}

		if ( ! empty( $custom_js ) ) {
			if ( strpos( $custom_js, '</script>' ) !== false ) {
				echo $custom_js;
			} else {
				?>
				<script data-cfasync="false" type="text/javascript">
					<?php echo $custom_js; ?>
				</script>
				<?php
			}
		}
	}
}
add_action( 'wp_footer', 'thim_add_marketing_code' );


/**
 * Filter add to cart message
 */
add_filter( 'wc_add_to_cart_message_html', 'thim_add_to_cart_message', 10, 2 );
if ( ! function_exists( 'thim_add_to_cart_message' ) ) {
	function thim_add_to_cart_message( $message, $product_id ) {
		$course_id = 0;
		if ( is_array( $product_id ) ) {
			$keys      = array_keys( $product_id );
			$course_id = $keys[0];
		} else {
			$course_id = $product_id;
		}
		$title = get_the_title( $course_id );
		if ( ! empty( $title ) ) {
			$added_text = sprintf( '%s %s', $title, esc_html__( 'has been added to your cart.', 'eduma' ) );

			// Output success messages
			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );
				$message   = sprintf( '<a href="%s" class="button wc-forward">%s</a> <span>%s</span>', esc_url( $return_to ), esc_html__( 'Continue Shopping', 'eduma' ), esc_html( $added_text ) );
			} else {
				$message = sprintf( '<a href="%s" class="button wc-forward">%s</a> <span>%s</span>', esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View Cart', 'eduma' ), esc_html( $added_text ) );
			}
		}

		return $message;
	}
}

/**
 * Set login cookie
 *
 * @param $logged_in_cookie
 * @param $expire
 * @param $expiration
 * @param $user_id
 * @param $logged_in
 */
function thim_set_logged_in_cookie( $logged_in_cookie, $expire, $expiration, $user_id, $logged_in ) {
	if ( $logged_in == 'logged_in' ) {
		// Hack for wp checking empty($_COOKIE[LOGGED_IN_COOKIE]) after user logged in
		// in "private mode". $_COOKIE is not set after calling setcookie util the response
		// is sent back to client (do not know why in "private mode").
		// @see wp-login.php line #789
		$_COOKIE[ LOGGED_IN_COOKIE ] = $logged_in_cookie;
	}
}

add_action( 'set_logged_in_cookie', 'thim_set_logged_in_cookie', 100, 5 );


/**
 * Get prefix for page title
 */
if ( ! function_exists( 'thim_get_prefix_page_title' ) ) {
	function thim_get_prefix_page_title() {

		if ( is_tax() ) {
			$queried_object = get_queried_object();

			if ( $queried_object->taxonomy == "product_cat" ) {
				$prefix = 'thim_woo';
			} elseif ( $queried_object->taxonomy == 'course_category' ) {
				$prefix = 'thim_learnpress';
			} elseif ( $queried_object->taxonomy == 'tp_event_category' ) {
				$prefix = 'thim_event';
			} elseif ( $queried_object->taxonomy == 'our_team_category' ) {
				$prefix = 'thim_team';
			} else {
				$prefix = 'thim_archive';
			}
		} else {
			if ( get_post_type() == "product" ) {
				$prefix = 'thim_woo';
			} elseif ( get_post_type() == "lp_course" || get_post_type() == "lp_quiz" || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
				$prefix = 'thim_learnpress';
			} elseif ( get_post_type() == "lp_collection" ) {
				$prefix = 'thim_collection';
			} elseif ( get_post_type() == "tp_event" ) {
				$prefix = 'thim_event';
			} elseif ( get_post_type() == "our_team" ) {
				$prefix = 'thim_team';
			} elseif ( get_post_type() == "testimonials" ) {
				$prefix = 'thim_testimonials';
			} elseif ( get_post_type() == "portfolio" ) {
				$prefix = 'thim_portfolio';
			} elseif ( get_post_type() == "forum" ) {
				$prefix = 'thim_forum';
			} elseif ( is_front_page() || is_home() ) {
				$prefix = 'thim';
			} else {
				$prefix = 'thim_archive';
			}
		}

		return $prefix;
	}
}

/**
 * Get prefix inner for page title
 */
if ( ! function_exists( 'thim_get_prefix_inner_page_title' ) ) {
	function thim_get_prefix_inner_page_title() {
		if ( ( is_page() || is_single() ) && ! is_front_page() && ! is_home() ) {
			$prefix_inner = '_single_';
			if ( is_page() && get_post_type() == "portfolio" ) {
				$prefix_inner = '_cate_';
			}
		} else {
			if ( is_front_page() || is_home() ) {
				$prefix_inner = '_front_page_';
			} else {
				$prefix_inner = '_cate_';
				if ( get_post_type() == "lp_collection" ) {
					$prefix_inner = '_single_';
				}
			}
		}

		return $prefix_inner;
	}
}

/**
 * Print breadcrumbs
 */
if ( ! function_exists( 'thim_print_breadcrumbs' ) ) {
	function thim_print_breadcrumbs() {
		?>
		<div class="breadcrumbs-wrapper">
			<div class="container">
				<?php
				//Check seo by yoast breadcrumbs
				$wpseo = get_option( 'wpseo_titles' );
				if ( ( class_exists( 'WPSEO' ) || class_exists( 'WPSEO_Premium' ) ) && $wpseo['breadcrumbs-enable'] && function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' );
				} else {
					if ( thim_use_bbpress() ) {
						bbp_breadcrumb();
					} else {
						do_action( 'thim_breadcrumbs' );
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}

/**
 * Get page title
 */
if ( ! function_exists( 'thim_get_page_title' ) ) {
	function thim_get_page_title( $custom_title, $front_title ) {
		$heading_title = esc_html__( 'Page title', 'eduma' );
		if ( is_post_type_archive() ) {
			$heading_title = ! empty( $custom_title ) ? $custom_title : post_type_archive_title( '', false );
		} elseif ( get_post_type() == 'product' ) {
			$heading_title = ! empty( $custom_title ) ? $custom_title : woocommerce_page_title( false );
		} elseif ( ( is_category() || is_archive() || is_search() || is_404() ) && ! thim_use_bbpress() ) {
			$heading_title = thim_archive_title();
		} elseif ( thim_use_bbpress() ) {
			$heading_title = thim_forum_title();
		} elseif ( is_single() ) {
			$single_title = get_the_title();
			if ( get_post_type() == 'post' ) {
				$category = get_the_category();
				if ( $category ) {
					$single_title = $category[0]->cat_name;
				}
			} elseif ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' ) {
				$course_cat = get_the_terms( get_the_ID(), 'course_category' );
				if ( ! empty( $course_cat ) ) {
					$single_title = $course_cat[0]->name;
				} else {
					$post_type = get_post_type_object( get_post_type() );
					if ( $post_type ) {
						$single_title = $post_type->labels->name;
					}
				}
			} elseif ( get_post_type() == 'portfolio' ) {
				$single_title = get_the_title();
			} else {
				$post_type = get_post_type_object( get_post_type() );
				if ( $post_type ) {
					$single_title = $post_type->labels->name;
				}
			}

			$heading_title = ! empty( $custom_title ) ? $custom_title : $single_title;
		} elseif ( is_page() ) {
			$heading_title = ! empty( $custom_title ) ? $custom_title : get_the_title();
		} elseif ( ! is_front_page() && is_home() ) {
			$heading_title = ! empty( $front_title ) ? $front_title : esc_html__( 'Blog', 'eduma' );;
		}

		return $heading_title;
	}
}


/**
 * Function print preload
 */
if ( ! function_exists( 'thim_print_preload' ) ) {
	function thim_print_preload() {
		$enable_preload     = get_theme_mod( 'thim_preload', 'default' );
		$thim_preload_image = get_theme_mod( 'thim_preload_image', false );
		$item_only          = ! empty( $_REQUEST['content-item-only'] ) ? $_REQUEST['content-item-only'] : false;
		if ( ! empty( $enable_preload ) && empty( $item_only ) ) { ?>
			<div id="preload">
				<?php
				if ( $thim_preload_image && $enable_preload == 'image' ) {
					if ( is_numeric( $thim_preload_image ) ) {
						echo wp_get_attachment_image( $thim_preload_image, 'full' );
					} else {
						echo '<img src="' . $thim_preload_image . '" alt="' . esc_html__( 'Preaload Image', 'eduma' ) . '"/>';
					}
				} else {
					switch ( $enable_preload ) {
						case 'style_1':
							$output_preload = '<div class="cssload-loader-style-1">
													<div class="cssload-inner cssload-one"></div>
													<div class="cssload-inner cssload-two"></div>
													<div class="cssload-inner cssload-three"></div>
												</div>';
							break;
						case 'style_2':
							$output_preload = '<div class="cssload-loader-style-2">
												<div class="cssload-loader-inner"></div>
											</div>';
							break;
						case 'style_3':
							$output_preload = '<div class="sk-folding-cube">
												<div class="sk-cube1 sk-cube"></div>
												<div class="sk-cube2 sk-cube"></div>
												<div class="sk-cube4 sk-cube"></div>
												<div class="sk-cube3 sk-cube"></div>
											</div>';
							break;
						case 'wave':
							$output_preload = '<div class="sk-wave">
										        <div class="sk-rect sk-rect1"></div>
										        <div class="sk-rect sk-rect2"></div>
										        <div class="sk-rect sk-rect3"></div>
										        <div class="sk-rect sk-rect4"></div>
										        <div class="sk-rect sk-rect5"></div>
										      </div>';
							break;
						case 'rotating-plane':
							$output_preload = '<div class="sk-rotating-plane"></div>';
							break;
						case 'double-bounce':
							$output_preload = '<div class="sk-double-bounce">
										        <div class="sk-child sk-double-bounce1"></div>
										        <div class="sk-child sk-double-bounce2"></div>
										      </div>';
							break;
						case 'wandering-cubes':
							$output_preload = '<div class="sk-wandering-cubes">
										        <div class="sk-cube sk-cube1"></div>
										        <div class="sk-cube sk-cube2"></div>
										      </div>';
							break;
						case 'spinner-pulse':
							$output_preload = '<div class="sk-spinner sk-spinner-pulse"></div>';
							break;
						case 'chasing-dots':
							$output_preload = '<div class="sk-chasing-dots">
										        <div class="sk-child sk-dot1"></div>
										        <div class="sk-child sk-dot2"></div>
										      </div>';
							break;
						case 'three-bounce':
							$output_preload = '<div class="sk-three-bounce">
										        <div class="sk-child sk-bounce1"></div>
										        <div class="sk-child sk-bounce2"></div>
										        <div class="sk-child sk-bounce3"></div>
										      </div>';
							break;
						case 'cube-grid':
							$output_preload = '<div class="sk-cube-grid">
										        <div class="sk-cube sk-cube1"></div>
										        <div class="sk-cube sk-cube2"></div>
										        <div class="sk-cube sk-cube3"></div>
										        <div class="sk-cube sk-cube4"></div>
										        <div class="sk-cube sk-cube5"></div>
										        <div class="sk-cube sk-cube6"></div>
										        <div class="sk-cube sk-cube7"></div>
										        <div class="sk-cube sk-cube8"></div>
										        <div class="sk-cube sk-cube9"></div>
										      </div>';
							break;
						default:
							$output_preload = '<div class="sk-folding-cube">
												<div class="sk-cube1 sk-cube"></div>
												<div class="sk-cube2 sk-cube"></div>
												<div class="sk-cube4 sk-cube"></div>
												<div class="sk-cube3 sk-cube"></div>
											</div>';
					}
					echo ent2ncr( $output_preload );
				}
				?>
			</div>
		<?php }
	}
}
add_action( 'thim_before_body', 'thim_print_preload' );

function thim_eduma_header_position() {
	$thim_header_position = get_theme_mod( 'thim_header_position', 'header_overlay' );
	// Custom Header position a page and post
	if ( is_page() || is_single() ) {
		$thim_mtb_header_position = get_post_meta( get_the_ID(), 'thim_mtb_header_position', true );
		if ( $thim_mtb_header_position ) {
			$thim_header_position = $thim_mtb_header_position;
		}
	}

	return $thim_header_position;
}

/**
 * Echo header class
 */
if ( ! function_exists( 'thim_header_class' ) ) {
	function thim_header_class() {
		$header_class = '';
		if ( get_theme_mod( 'thim_config_att_sticky', 'sticky_same' ) == 'sticky_custom' ) {
			$header_class .= ' bg-custom-sticky';
		}
		if ( get_theme_mod( 'thim_header_sticky', false ) && ! ( is_singular( 'lpr_course' ) || is_singular( 'lp_course' ) ) ) {
			$header_class .= ' sticky-header';
		}

		$header_class .= ' ' . thim_eduma_header_position();

		if ( get_theme_mod( 'thim_header_style', 'header_v1' ) ) {
			$header_class .= ' ' . get_theme_mod( 'thim_header_style', 'header_v1' );
		}
		//		if ( get_theme_mod( 'thim_config_logo_mobile', 'default_logo' ) == 'custom_logo' ) {
		//			$header_class .= ' mobile-logo-custom';
		//		}
		if ( get_theme_mod( 'thim_line_active_item_menu', 'bottom' ) == 'top' ) {
			$header_class .= ' item_menu_active_top';
		} elseif ( get_theme_mod( 'thim_line_active_item_menu', 'bottom' ) == 'noline' ) {
			$header_class .= ' noline_menu_active';
		}

		if ( get_theme_mod( 'thim_header_style', 'header_v1' ) == 'header_v4' && get_theme_mod( 'thim_line_active_item_menu', 'bottom' ) != 'noline' ) {
			$header_class .= ' noline_menu_active';
		}
		echo esc_attr( $header_class );
	}
}

/**
 * Footer Bottom
 */
if ( ! function_exists( 'thim_footer_bottom' ) ) {
	function thim_footer_bottom() {
		if ( ( is_active_sidebar( 'footer_bottom' ) ) ) {
			?>
			<div class="footer-bottom">

				<div class="container">
					<?php dynamic_sidebar( 'footer_bottom' ); ?>
				</div>

			</div>
		<?php }
	}
}
add_action( 'thim_end_content_pusher', 'thim_footer_bottom' );

if ( ! function_exists( 'thim_above_footer_area_fnc' ) ) {
	function thim_above_footer_area_fnc() {
		if ( is_active_sidebar( 'footer_top' ) ) {
			?>
			<div class="footer-bottom-above">

				<div class="container">
					<?php dynamic_sidebar( 'footer_top' ); ?>
				</div>

			</div>
			<?php
		}
	}
}
add_action( 'thim_above_footer_area', 'thim_above_footer_area_fnc' );

/**
 * Back to top
 */
if ( ! function_exists( 'thim_back_to_top' ) ) {
	function thim_back_to_top() {
		if ( get_theme_mod( 'thim_show_to_top', false ) ) {
			$class    = 'scroll-to-top';
			$svg_html = '';
			if ( get_theme_mod( 'thim_to_top_style', '' ) == 'circle' ) {
				$class    = 'scroll-circle-progress';
				$svg_html = '<svg width="100%" height="100%" viewBox="-1 -1 102 102">
					<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
				</svg>';
			}
			echo '<div class="' . $class . '" id="back-to-top">' . $svg_html . '<i class="fa fa-chevron-up" aria-hidden="true"></i></div>';
		}
	}
}
add_action( 'thim_end_wrapper_container', 'thim_back_to_top' );


/**
 * Copyright Area
 */
if ( ! function_exists( 'thim_print_copyright' ) ) {
	function thim_print_copyright() {
		$html_to_top         = $div_inline = '';
		$theme_mods          = get_theme_mods();
		$copyright_text      = isset( $theme_mods['thim_copyright_text'] ) ? $theme_mods['thim_copyright_text'] : 'Education WordPress Theme by ThimPress';
		$display_copyright   = $copyright_text ? true : false;
		$show_copyright      = get_theme_mod( 'thim_copyright_show', 'true' );
		$is_active_copyright = is_active_sidebar( 'copyright' );
		if ( $show_copyright && ( $display_copyright || $is_active_copyright ) ) { ?>
			<div class="copyright-area">
				<div class="container">
					<div class="copyright-content">
						<div class="row">
							<?php
							$class_copyright = $is_active_copyright ? 'col-sm-' . get_theme_mod( 'thim_copyright_column', 6 ) : 'col-sm-12';
							echo '<div class="' . $class_copyright . '"><p class="text-copyright">' . $copyright_text . '</p></div>';
							if ( $is_active_copyright ) {
								echo '<div class="col-sm-' . ( 12 - get_theme_mod( 'thim_copyright_column', 6 ) ) . ' text-right' . $div_inline . '">';
								dynamic_sidebar( 'copyright' );
								echo $html_to_top;
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		<?php }
	}
}
add_action( 'thim_copyright_area', 'thim_print_copyright' );

/**
 * Footer Class
 */
if ( ! function_exists( 'thim_footer_class' ) ) {
	function thim_footer_class() {
		$theme_options_data = get_theme_mods();
		$style_header       = isset( $theme_options_data['thim_header_style'] ) ? $theme_options_data['thim_header_style'] : 'header_v1';
		$custom_class       = get_theme_mod( 'thim_footer_custom_class', '' ) . ' site-footer';
		$footer_bg_image    = get_theme_mod( 'thim_footer_background_img', '' );
		$custom_class       .= ! empty( $footer_bg_image ) ? ' footer-bg-image' : '';
		$footer_class       = ( ( is_active_sidebar( 'footer_bottom' ) && thim_lp_style_single_course() != 'new-1' ) || ( is_active_sidebar( 'footer_bottom' ) && $style_header != 'header_v4' ) ) ? $custom_class . ' has-footer-bottom' : $custom_class;

		echo esc_attr( $footer_class );
	}
}

function thim_eduma_after_switch_theme() {
	update_option( 'thim_eduma_version', THIM_THEME_VERSION );
}

add_action( 'after_switch_theme', 'thim_eduma_after_switch_theme' );

//add icon for level membership
if ( thim_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) ) {
	require_once THIM_DIR . 'paid-memberships-pro/functions.php';
}

if ( ! function_exists( 'thim_time_ago' ) ) {
	function thim_time_ago( $time ) {
		$periods = array(
			esc_html__( 'second', 'eduma' ),
			esc_html__( 'minute', 'eduma' ),
			esc_html__( 'hour', 'eduma' ),
			esc_html__( 'day', 'eduma' ),
			esc_html__( 'week', 'eduma' ),
			esc_html__( 'month', 'eduma' ),
			esc_html__( 'year', 'eduma' ),
			esc_html__( 'decade', 'eduma' ),
		);
		$lengths = array(
			'60',
			'60',
			'24',
			'7',
			'4.35',
			'12',
			'10'
		);


		$now = time();

		$difference = $now - $time;
		$tense      = esc_html__( 'ago', 'eduma' );

		for ( $j = 0; $difference >= $lengths[ $j ] && $j < count( $lengths ) - 1; $j ++ ) {
			$difference /= $lengths[ $j ];
		}

		$difference = round( $difference );

		if ( $difference != 1 ) {
			$periods[ $j ] .= "s";
		}

		return "$difference $periods[$j] $tense";
	}
}

/*
 * Display an author bio excerpt
 *
 * */
if ( ! function_exists( 'thim_author_bio_excerpt' ) ) {
	function thim_author_bio_excerpt( $author_id, $word_limit = 16, $text_end = '...' ) {
		$content_arr = explode( " ", get_the_author_meta( 'description', $author_id ) );

		$end_line = count( $content_arr ) > $word_limit ? $text_end : '';

		$author_des = array_slice( $content_arr, 0, ( $word_limit ) );

		return ( implode( ' ', $author_des ) ) . $end_line;

	}
}

/*
 * Upload translation language files
 * */
if ( ! function_exists( 'thim_upload_language_files' ) ) {
	function thim_upload_language_files() {
		if ( empty( $_GET['activated'] ) ) {
			return false;
		}

		// Check folder permission and create folder languages in not exist
		if ( ! wp_mkdir_p( ABSPATH . 'wp-content/languages/' ) ) {
			esc_html_e( 'Languages path could not be created', 'eduma' );
		}

		$prefix       = 'eduma';
		$default_lang = array(
			$prefix . '-bg_BG' => 'Bulgarian',
			$prefix . '-da_DK' => 'Danish',
			$prefix . '-es_ES' => 'Spanish(Spain)',
			$prefix . '-es_MX' => 'Spanish(Mexico)',
			$prefix . '-fa_IR' => 'Persian',
			$prefix . '-pl_PL' => 'Polish',
			$prefix . '-pt_BR' => 'Portuguese(Brazil)',
			$prefix . '-ru_RU' => 'Russian',
			$prefix . '-tr_TR' => 'Turkish'
		);

		$required = false;

		foreach ( $default_lang as $k => $val ) {
			$file_dir = WP_CONTENT_DIR . '/languages/themes/' . $k . '.mo';
			//			clearstatcache(true, $file_dir);

			if ( ! file_exists( $file_dir ) ) {
				if ( ! $required ) {
					require_once ABSPATH . 'wp-admin/includes/template.php';
					require_once ABSPATH . 'wp-admin/includes/misc.php';
					require_once ABSPATH . 'wp-admin/includes/file.php';
					require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
					$required = true;
				}

				$skin    = new WP_Ajax_Upgrader_Skin();
				$install = new WP_Upgrader( $skin );

				$is_success = $install->run(
					array(
						'package'                     => 'https://github.com/ThimPressWP/demo-data/blob/master/' . $prefix . '/languages/' . $val . '.zip?raw=true',
						'destination'                 => WP_CONTENT_DIR . '/languages/themes/',
						'clear_destination'           => false,
						'abort_if_destination_exists' => false,
						'clear_working'               => false,
					)
				);

				if ( ! $is_success ) {
					echo '<div class="message error"><p><strong>' . __( 'Installation failed', 'eduma' ) . '</strong></p></div>';
				}
			}
		}
	}
}

add_action( 'after_switch_theme', 'thim_upload_language_files' );


/**
 * Add Thim VC templates.
 *
 */
if ( thim_plugin_active( 'js_composer/js_composer.php' ) ) {
	require THIM_DIR . 'inc/admin/thim-vc-tempate.php';
}

/*
 * Handle conflict between Google captcha plugin vs Revolution Slider plugin
 */

if ( thim_plugin_active( 'google-captcha/google-captcha.php' ) ) {
	remove_filter( 'widget_text', 'do_shortcode' );
}

if ( ! function_exists( "thim_get_cat_taxonomy" ) ) {
	function thim_get_cat_taxonomy( $term = 'category', $cats = false, $vc = false ) {
		if ( ! $cats ) {
			$cats = array();
		}
		if ( is_admin() ) {

			$terms = new WP_Term_Query(
				array(
					'taxonomy'   => $term,
					'orderby'    => 'name',
					'order'      => 'DESC',
					'child_of'   => 0,
					'parent'     => 0,
					'fields'     => 'all',
					'hide_empty' => false,
				)
			);

			if ( is_wp_error( $terms ) ) {
			} else {
				if ( empty( $terms->terms ) ) {
				} else {
					$prefix = '';
					foreach ( $terms->terms as $term ) {
						if ( $term->parent > 0 ) {
							$prefix = "--";
						}
						if ( $vc == true ) {
							$cats[ $prefix . $term->name ] = $term->term_id;
						} else {
							$cats[ $term->term_id ] = $prefix . $term->name;
						}
					}
				}
			}
		}

		return $cats;
	}
}

if ( ! function_exists( "thim_sc_get_course_categories" ) ) {
	function thim_sc_get_course_categories( $cats = false ) {
		if ( ! $cats ) {
			$cats = array();
		}
		if ( is_admin() ) {
			$args = array(
				'taxonomy'     => 'course_category',
				'pad_counts'   => 1,
				'hierarchical' => 1,
				'hide_empty'   => 1,
				'orderby'      => 'name',
				'menu_order'   => false
			);
			//			$terms = get_terms( 'course_category', $args );
			$terms = new WP_Term_Query( $args );
			if ( is_wp_error( $terms ) ) {
			} else {
				if ( empty( $terms->terms ) ) {
				} else {
					foreach ( $terms->terms as $term ) {
						$cats[ $term->name ] = $term->term_id;
					}
				}
			}
		}

		return $cats;
	}
}

if ( ! function_exists( "thim_get_instructors" ) ) {
	function thim_get_instructors( $ins = false, $vc = false ) {
		if ( ! $ins ) {
			$ins = array();
		}
		if ( is_admin() ) {
			//				$co_instructors = thim_get_all_courses_instructors();
			$users_by_role = get_users( array( 'role' => 'lp_teacher' ) );
			if ( $users_by_role ) {
				foreach ( $users_by_role as $user ) {
					//						$co_instructors[] = $user->ID;
					if ( $vc == true ) {
						$ins[ get_the_author_meta( 'display_name', $user->ID ) ] = $user->ID;
					} else {
						$ins[ $user->ID ] = get_the_author_meta( 'display_name', $user->ID );
					}
				}
			}
		}

		return $ins;
	}
}

/**
 * Get popular list courses
 *
 * Count all user enroll, buy course (No discrimination order status)
 *
 * @param int $limit
 *
 * @return array|false|mixed
 * @since  4.2.9.7
 * @note   should write on LP | function is temporary | see same get_popular_courses function of LP
 * @author tungnx
 *
 */
function eduma_lp_get_popular_courses( $limit = 10 ) {
	global $wpdb;

	$result = wp_cache_get( 'lp-popular-course', '', true );

	if ( ! $result ) {
		$query = $wpdb->prepare(
			"SELECT ID, cStudentsFake + IF(cSutdents IS NULL, 0, cSutdents) AS students
        FROM (SELECT p.ID as ID, IF(pm.meta_value, pm.meta_value, 0) as cStudentsFake,
                  (SELECT COUNT(item_id)
                   FROM {$wpdb->prefix}learnpress_user_items
                   WHERE item_type = %s
                   GROUP BY item_id
                   HAVING item_id = p.ID) AS cSutdents
              FROM {$wpdb->posts} p
                       LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id AND pm.meta_key = %s
              WHERE p.post_type = %s AND p.post_status = %s
              GROUP BY ID) AS Z
        ORDER BY students DESC
        LIMIT 0, $limit
        ", LP_COURSE_CPT, '_lp_students', LP_COURSE_CPT, 'publish'
		);

		$result = $wpdb->get_col( $query );
	}

	$time_cache = apply_filters( 'lp/time-cache/popular-courses', 60 * 60 * 60 );

	wp_cache_set( 'lp-popular-courses', $result, '', current_time( 'timestamp' ) + $time_cache );

	return $result;
}

/* Disable VC auto-update */
function thimpress_vc_disable_update() {
	if ( function_exists( 'vc_license' ) && function_exists( 'vc_updater' ) && ! vc_license()->isActivated() ) {
		remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10 );
		remove_filter(
			'pre_set_site_transient_update_plugins', array(
				vc_updater()->updateManager(),
				'check_update'
			)
		);

	}
}

add_action( 'admin_init', 'thimpress_vc_disable_update', 9 );

function thim_sc_get_list_image_size() {
	global $_wp_additional_image_sizes;

	$sizes                        = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach ( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']  = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop']   = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}

	$image_size                                          = array();
	$image_size[ esc_html__( "No Image", 'eduma' ) ]     = 'none';
	$image_size[ esc_html__( "Custom Image", 'eduma' ) ] = 'custom_image';
	if ( ! empty( $sizes ) ) {
		foreach ( $sizes as $key => $value ) {
			if ( $value['width'] && $value['height'] ) {
				$image_size[ $value['width'] . 'x' . $value['height'] ] = $key;
			} else {
				$image_size[ $key ] = $key;
			}
		}
	}

	return $image_size;
}

if ( ! function_exists( 'list_item_course_cat' ) ) {
	function list_item_course_cat( $course_id ) {
		$html  = '';
		$terms = get_the_terms( $course_id, 'course_category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$html .= '<div class="wrapper-cat">';
			foreach ( $terms as $term ) {
				$sub_color_cate = get_term_meta( $term->term_id, 'learnpress_cate_text_color', true );
				$style          = ( isset( $sub_color_cate ) && ! empty( $sub_color_cate ) ) ? ' style="color:' . $sub_color_cate . '; border-color:' . $sub_color_cate . '"' : '';
				$html           .= '<a href="' . get_term_link( $term->slug, 'course_category' ) . '" class="cat-item"' . $style . '>' . $term->name . '</a>';
			}
			$html .= '</div>';
		}

		echo $html;
	}
}

/**
 * Extra class to widget
 * -----------------------------------------------------------------------------
 */
add_action( 'widgets_init', array( 'Thim_Widget_Attributes', 'setup' ) );

class Thim_Widget_Attributes {
	const VERSION = '0.2.2';

	/**
	 * Initialize plugin
	 */
	public static function setup() {
		if ( is_admin() ) {
			// Add necessary input on widget configuration form
			add_action( 'in_widget_form', array( __CLASS__, '_input_fields' ), 10, 3 );

			// Save widget attributes
			add_filter( 'widget_update_callback', array( __CLASS__, '_save_attributes' ), 10, 4 );
		} else {
			// Insert attributes into widget markup
			add_filter( 'dynamic_sidebar_params', array( __CLASS__, '_insert_attributes' ) );
		}
	}


	/**
	 * Inject input fields into widget configuration form
	 *
	 * @param object $widget Widget object
	 *
	 * @return NULL
	 * @since   0.1
	 * @wp_hook action in_widget_form
	 *
	 */
	public static function _input_fields( $widget, $return, $instance ) {
		$instance = self::_get_attributes( $instance );
		?>
		<p>
			<?php printf(
				'<label for="%s">%s</label>',
				esc_attr( $widget->get_field_id( 'widget-class' ) ),
				esc_html__( 'Extra Class', 'eduma' )
			) ?>
			<?php printf(
				'<input type="text" class="widefat" id="%s" name="%s" value="%s" />',
				esc_attr( $widget->get_field_id( 'widget-class' ) ),
				esc_attr( $widget->get_field_name( 'widget-class' ) ),
				esc_attr( $instance['widget-class'] )
			) ?>
		</p>
		<?php
		return null;
	}

	/**
	 * Get default attributes
	 *
	 * @param array $instance Widget instance configuration
	 *
	 * @return array
	 * @since 0.1
	 *
	 */
	private static function _get_attributes( $instance ) {
		$instance = wp_parse_args(
			$instance,
			array(
				'widget-class' => '',
			)
		);

		return $instance;
	}

	/**
	 * Save attributes upon widget saving
	 *
	 * @param array $instance Current widget instance configuration
	 * @param array $new_instance New widget instance configuration
	 * @param array $old_instance Old Widget instance configuration
	 * @param object $widget Widget object
	 *
	 * @return array
	 * @since   0.1
	 * @wp_hook filter widget_update_callback
	 *
	 */
	public static function _save_attributes( $instance, $new_instance, $old_instance, $widget ) {
		$instance['widget-class'] = '';

		// Classes
		if ( ! empty( $new_instance['widget-class'] ) ) {
			$instance['widget-class'] = apply_filters(
				'widget_attribute_classes',
				implode(
					' ',
					array_map(
						'sanitize_html_class',
						explode( ' ', $new_instance['widget-class'] )
					)
				)
			);
		} else {
			$instance['widget-class'] = '';
		}

		return $instance;
	}

	/**
	 * Insert attributes into widget markup
	 *
	 * @param array $params Widget parameters
	 *
	 * @return Array
	 * @since  0.1
	 * @filter dynamic_sidebar_params
	 *
	 */
	public static function _insert_attributes( $params ) {
		global $wp_registered_widgets;

		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[ $widget_id ];

		if (
			! isset( $widget_obj['callback'][0] )
			|| ! is_object( $widget_obj['callback'][0] )
		) {
			return $params;
		}

		$widget_options = get_option( $widget_obj['callback'][0]->option_name );
		if ( empty( $widget_options ) ) {
			return $params;
		}

		$widget_num = $widget_obj['params'][0]['number'];
		if ( empty( $widget_options[ $widget_num ] ) ) {
			return $params;
		}

		$instance = $widget_options[ $widget_num ];

		// Classes
		if ( ! empty( $instance['widget-class'] ) ) {
			$params[0]['before_widget'] = preg_replace(
				'/class="/',
				sprintf( 'class="%s ', $instance['widget-class'] ),
				$params[0]['before_widget'],
				1
			);
		}

		return $params;
	}
}

if ( ! function_exists( "thim_message_before_importer" ) ) {
	function thim_message_before_importer() {
		$title = 'Import data demo with Elementor Page Builder';
		if ( get_theme_mod( 'thim_page_builder_chosen' ) == 'visual_composer' ) {
			$title = 'You has import data demo with WPBakery Page Builder';
		} elseif ( get_theme_mod( 'thim_page_builder_chosen' ) == 'site_origin' ) {
			$title = 'You has import data demo with SiteOrigin Page Builder';
		}
		if ( apply_filters( 'thim-importer-demo-vc', false ) ) {
			$title = 'You has enabled import data demo with WPBakery Page Builder';
		} elseif ( apply_filters( 'thim-importer-demo-so', false ) ) {
			$title = 'You has enabled import data demo with SiteOrigin Page Builder';
		}
		echo '<div class="thim-message-import"><h2>' . esc_html__( $title, 'eduma' ) . '</h2>';
		echo '<p><i>If you want to import data with <b>WPBakery</b> or <b>SiteOrigin</b> Page Builder <a href="https://thimpress.com/knowledge-base/how-to-import-data-with-wpbakery-or-siteorigin/" target="_blank">Please read the guide here.</a></i></p></div>';
	}
}
add_filter( 'thim-message-before-importer', 'thim_message_before_importer' );

add_filter( 'thim_breadcrumb_text_home', function () {
	return _x( 'Home', 'breadcrumb', 'eduma' );
} );

// add internal css in header
add_filter( 'thim_custom_internal_css', 'thim_custom_internal_css' );
function thim_custom_internal_css() {
	ob_start();
	$base_directory      = thim_eduma_child_locate_template();
	$custom_body_class   = array( 'thim-demo-university-4', 'thim-demo-university-3', 'three_line_top_bottom', 'body-grad-layout' );
	$custom_footer_class = array( 'thim-footer-new-eduma', 'white_background', 'custom-title' );
	$css_preview         = apply_filters( 'thim-disable-optimize-css', false );
	// Add css when edit page with elementor
	if ( defined( 'ELEMENTOR_VERSION' ) || is_plugin_active( 'elementor/elementor.php' ) ) {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$css_preview = true;
		}
	}

	if ( get_theme_mod( 'thim_preload', true ) ) {
		echo "\r\n/** CSS preloading */\r\n";
		include_once THIM_DIR . "/assets/css/libs/preloading.css";
	}
	// Css BBpress
	if ( thim_use_bbpress() ) {
		echo "\r\n/** CSS bbPress */\r\n";
		include_once THIM_DIR . "/assets/css/libs/bbpress-forum.css";
	}

	// Css BuddyPress
	if ( class_exists( 'BuddyPress' ) ) {
		echo "\r\n/** CSS BuddyPress */\r\n";
		include_once THIM_DIR . "/assets/css/libs/buddypress.css";
	}
	if ( ( is_child_theme() === true && $base_directory ) || in_array( get_theme_mod( 'thim_body_custom_class', false ), $custom_body_class, true ) ) {
		echo "\r\n/** CSS Fix Child Theme */\r\n";
		include_once THIM_DIR . "/assets/css/libs/child-theme.css";
	}

	if ( in_array( get_theme_mod( 'thim_footer_custom_class', false ), $custom_footer_class, true ) ) {
		echo "\r\n/** CSS Fix Footer */\r\n";
		include_once THIM_DIR . "/assets/css/libs/custom-footer.css";
	}

	if ( get_theme_mod( 'thim_footer_custom_class', false ) == 'footer-restaurant' || get_theme_mod( 'thim_body_custom_class', false ) == 'eduma-restaurant' ) {
		echo "\r\n/** CSS Demo Restaurant */\r\n";
		include_once THIM_DIR . "/assets/css/libs/demo-restaurant.css";
	}

	//Load style for page builder Visual Composer
	if ( thim_plugin_active( 'js_composer/js_composer.php' ) ) {
		echo "\r\n/** CSS Custom VC */\r\n";
		include_once THIM_DIR . "/assets/css/custom-vc.css";
	}

	if ( ( is_single() && is_singular( 'lp_course' ) ) || $css_preview ) {
		echo "\r\n/** CSS Single Course */\r\n";
		include_once THIM_DIR . "/assets/css/libs/course-single.css";
	}
	if ( ( ( get_post_type() == "lp_course" || thim_check_is_course() || thim_check_is_profile() ) & ! is_single() ) || get_post_type() == "lp_collection" || $css_preview ) {
		echo "\r\n/** CSS Archive Course */\r\n";
		include_once THIM_DIR . "/assets/css/libs/archive-course.css";
	}

	if ( get_post_type() == 'post' && ( is_category() || is_archive() || is_singular( 'post' ) || is_front_page() || is_home() || is_search() || $css_preview ) ) {
		echo "\r\n/** CSS Blog */\r\n";
		include_once THIM_DIR . "/assets/css/libs/blog.css";
	}
	if ( is_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) ) {
		echo "\r\n/** CSS Paid Memberships Pro */\r\n";
		include_once THIM_DIR . "/assets/css/libs/pmpro.css";
	}
	// woocommerce
	if ( class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_shop() || is_product_category() || is_product() ||
			is_cart() || is_checkout() || is_account_page() || $css_preview )
	) {
		echo "\r\n/** CSS Woocommerce */\r\n";
		include_once THIM_DIR . "/assets/css/libs/woocommerce.css";
	}

	if ( class_exists( 'RevSlider' ) ) {
		echo "\r\n/** CSS RevSlider */\r\n";
		include_once THIM_DIR . "/assets/css/libs/rev_slider.css";
	}

	if ( apply_filters( 'thim-support-mega-menu', true ) ) {
		echo "\r\n/** CSS TC Megamenu */\r\n";
		include_once THIM_DIR . "/assets/css/libs/tc-megamenu.css";
	}
	if ( get_theme_mod( 'thim_custom_css' ) ) {
		echo "\r\n/** CSS Extral Customizer */\r\n";
		echo trim( get_theme_mod( 'thim_custom_css' ) );
	}

	if ( strpos( get_theme_mod( 'thim_body_custom_class', false ), 'demo-marketplace' ) !== false ) {
		echo "\r\n/** CSS Demo Marketplace */\r\n";
		include_once THIM_DIR . "/assets/css/libs/demo-marketplace.css";
	}
	if ( get_theme_mod( 'thim_body_custom_class', false ) == 'demo-ecommerce' ) {
		echo "\r\n/** CSS Demo Ecommerce */\r\n";
		include_once THIM_DIR . "/assets/css/libs/demo-ecommerce.css";
	}

	$css = ob_get_contents();
	ob_end_clean();

	return $css;
}

if ( ! function_exists( 'thim_customizer_extral_class' ) ) {
	function thim_customizer_extral_class( $type, $rules = array( 'all' ) ) {
		if ( $type == 'archive-post' && count( $rules ) == 1 ) {
			$rules = array( 'all', 'post_categories', 'post_tags', 'post_tags', 'post_search', 'post_term', 'select_post_author' );
		}
		if ( class_exists( '\Thim_EL_Kit\Functions' ) ) {
			$build_el = \Thim_EL_Kit\Functions::instance()->get_conditions_by_type( $type );
			foreach ( $rules as $rule ) {
				if ( ! empty( $build_el[ $rule ] ) ) {
					return ' hidden';
				}
			}
		}

		return;
	}
}

function thim_theme_eduma_system_color_dark_mode( $color_system ) {
	$color_system['theme_color'] =
		array(
			array(
				'_id'   => '--thim-body-primary-color',
				'title' => esc_html__( 'Primary', 'eduma' ),
				'color' => '#FF7700'
			),
			array(
				'_id'   => '--thim-body-secondary-color',
				'title' => esc_html__( 'Secondary', 'eduma' ),
				'color' => '#F94C10'
			),
			array(
				'_id'   => '--thim-body-bg-color',
				'title' => esc_html__( 'Body Background', 'eduma' ),
				'color' => '#000927'
			),
			array(
				'_id'   => '--thim-font-title-color',
				'title' => esc_html__( 'Headings', 'eduma' ),
				'color' => '#E8E2FF'
			),
			array(
				'_id'   => '--thim-font-body-color',
				'title' => esc_html__( 'Body Text', 'eduma' ),
				'color' => '#8e88a8'
			),
			array(
				'_id'   => '--thim-button-text-color',
				'title' => esc_html__( 'Button Text', 'eduma' ),
				'color' => '#FFFFFF'
			),
			array(
				'_id'   => '--thim-border-color',
				'title' => esc_html__( 'Border', 'eduma' ),
				'color' => '#1f3064'
			),
			array(
				'_id'   => '--thim-footer-bg-color',
				'title' => esc_html__( 'Footer Background', 'eduma' ),
				'color' => '#000927'
			),
			array(
				'_id'   => '--thim-footer-color-text',
				'title' => esc_html__( 'Footer Text', 'eduma' ),
				'color' => '#8e88a8'
			),
			array(
				'_id'   => '--thim-footer-color-link',
				'title' => esc_html__( 'Footer Link', 'eduma' ),
				'color' => '#8e88a8'
			),
			array(
				'_id'   => '--menu-text-color',
				'title' => esc_html__( 'Menu Text', 'eduma' ),
				'color' => '#e8e2ff'
			),
			array(
				'_id'   => '--thim-breacrumb-color',
				'title' => esc_html__( 'Breadcrumb', 'eduma' ),
				'color' => '#514b6b'
			),
			array(
				'_id'   => '--thim-breacrumb-bg-color',
				'title' => esc_html__( 'Breadcrumb Background', 'eduma' ),
				'color' => '#000927'
			),
			array(
				'_id'   => '--thim-breacrumb-border-color',
				'title' => esc_html__( 'Breadcrumb Border', 'eduma' ),
				'color' => '#000927'
			),
			array(
				'_id'   => '--thim-bg-order-cart',
				'title' => esc_html__( 'Order Cart Background', 'eduma' ),
				'color' => '#1f3064'
			),
		);

	return $color_system;
}

add_filter( 'thim_ekits_system_color_dark_mode', 'thim_theme_eduma_system_color_dark_mode' );

if ( ! function_exists( "thim_ekit_custom_single_widget_thumbnail" ) ) {
	function thim_ekit_custom_single_widget_thumbnail( $thumbnail_html ) {
		wp_enqueue_script( 'thim-flexslider' );
		switch ( get_post_format() ) {
			case 'image':
			case 'gallery':
			case 'video':
			case 'audio':
				do_action( 'thim_entry_top', 'full' );
				break;
			default:
				return $thumbnail_html;
		}
	}

	add_filter( 'thim-ekit-single-post-thumbnail', 'thim_ekit_custom_single_widget_thumbnail' );
}
