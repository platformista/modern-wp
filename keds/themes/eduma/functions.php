<?php
/**
 * thim functions and definitions
 *
 * @package thim
 */

define( 'THIM_DIR', trailingslashit( get_template_directory() ) );
define( 'THIM_URI', trailingslashit( get_template_directory_uri() ) );
const THIM_THEME_VERSION = '5.4.7';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}
/**
 * Translation ready
 */

load_theme_textdomain( 'eduma', get_template_directory() . '/languages' );

function thim_eduma_get_current_url() {
	$schema = is_ssl() ? 'https://' : 'http://';

	return $schema . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

if ( ! function_exists( 'thim_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function thim_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on thim, use a find and replace
		 * to change 'eduma' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'eduma', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'eduma' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		/* Add WooCommerce support */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'thim-core' );

		//		add_theme_support( 'eduma-demo-data' );
		add_theme_support( 'thim-full-widgets' );
		/*
		* Enable support for Post Formats.
		* See http://codex.wordpress.org/Post_Formats
		*/
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				//				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Editor color palette.
		add_theme_support(
			'editor-color-palette', array(
				array(
					'name'  => esc_html__( 'Primary Color', 'eduma' ),
					'slug'  => 'primary',
					'color' => get_theme_mod( 'thim_body_primary_color', '#ffb606' ),
				),
				array(
					'name'  => esc_html__( 'Title Color', 'eduma' ),
					'slug'  => 'title',
					'color' => get_theme_mod( 'thim_font_title_color', '#333' ),
				),
				array(
					'name'  => esc_html__( 'Sub Title Color', 'eduma' ),
					'slug'  => 'sub-title',
					'color' => '#999',
				),
				array(
					'name'  => esc_html__( 'Border Color', 'eduma' ),
					'slug'  => 'border-input',
					'color' => '#ddd',
				),
			)
		);

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'eduma' ),
					'shortName' => __( 'S', 'eduma' ),
					'size'      => 13,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'eduma' ),
					'shortName' => __( 'M', 'eduma' ),
					'size'      => 15,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'eduma' ),
					'shortName' => __( 'L', 'eduma' ),
					'size'      => 28,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'eduma' ),
					'shortName' => __( 'XL', 'eduma' ),
					'size'      => 36,
					'slug'      => 'huge',
				),
			)
		);
		// don't enqueue file css when save customizer
		add_filter( 'thim_core_enqueue_file_css_customizer', '__return_false' );
		// remove wp_global_styles_render_svg_filters
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		add_filter( 'thim_prefix_folder_download_data_demo', function () {
			return 'eduma';
		} );
	}
endif; // thim_setup
add_action( 'after_setup_theme', 'thim_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
if ( ! function_exists( 'thim_widgets_inits' ) ) {
	function thim_widgets_inits() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'eduma' ),
				'id'            => 'sidebar',
				'description'   => esc_html__( 'Right Sidebar', 'eduma' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		if ( get_theme_mod( 'thim_toolbar_show', 'true' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Toolbar', 'eduma' ),
					'id'            => 'toolbar',
					'description'   => esc_html__( 'Toolbar Header', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}
		register_sidebar(
			array(
				'name'          => esc_html__( 'Menu Right', 'eduma' ),
				'id'            => 'menu_right',
				'description'   => esc_html__( 'Menu Right', 'eduma' ),
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget'  => '</li>',
				'before_title'  => '<h4>',
				'after_title'   => '</h4>',
			)
		);
		if ( 'header_v2' == get_theme_mod( 'thim_header_style', 'header_v1' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Menu Top', 'eduma' ),
					'id'            => 'menu_top',
					'description'   => esc_html__( 'Menu top only display with header version 2', 'eduma' ),
					'before_widget' => '<li id="%1$s" class="widget %2$s">',
					'after_widget'  => '</li>',
					'before_title'  => '<h4>',
					'after_title'   => '</h4>',
				)
			);
		}

		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Top', 'eduma' ),
				'id'            => 'footer_top',
				'description'   => esc_html__( 'Footer Top Sidebar', 'eduma' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s footer_bottom_widget">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'eduma' ),
				'id'            => 'footer',
				'description'   => esc_html__( 'Footer Sidebar', 'eduma' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s footer_widget">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		if ( 'new-1' != get_theme_mod( 'thim_layout_content_page', 'normal' ) || 'header_v4' != get_theme_mod( 'thim_header_style', 'header_v1' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Bottom', 'eduma' ),
					'id'            => 'footer_bottom',
					'description'   => esc_html__( 'Footer Bottom Sidebar', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s footer_bottom_widget">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}

		if ( get_theme_mod( 'thim_copyright_show', 'true' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Copyright', 'eduma' ),
					'id'            => 'copyright',
					'description'   => esc_html__( 'Copyright', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}

		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Sidebar Shop', 'eduma' ),
					'id'            => 'sidebar_shop',
					'description'   => esc_html__( 'Sidebar Shop', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}

		if ( class_exists( 'LearnPress' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Sidebar Courses', 'eduma' ),
					'id'            => 'sidebar_courses',
					'description'   => esc_html__( 'Sidebar Courses', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}

		if ( class_exists( 'TP_Event' ) || class_exists( 'WPEMS' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Sidebar Events', 'eduma' ),
					'id'            => 'sidebar_events',
					'description'   => esc_html__( 'Sidebar Events', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}
		if ( 'header_v3' == get_theme_mod( 'thim_header_style', 'header_v1' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Header', 'eduma' ),
					'id'            => 'header',
					'description'   => esc_html__( 'Sidebar display on header version 3', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s footer_bottom_widget">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}
		/**
		 * Feature create sidebar in wp-admin.
		 * Do not remove this.
		 */
		$sidebars = apply_filters( 'thim_core_list_sidebar', array() );
		if ( count( $sidebars ) > 0 ) {
			foreach ( $sidebars as $sidebar ) {
				$new_sidebar = array(
					'name'          => $sidebar['name'],
					'id'            => $sidebar['id'],
					'description'   => esc_html__( 'Custom widgets area.', 'eduma' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s footer_bottom_widget">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				);

				register_sidebar( $new_sidebar );
			}
		}
	}
}

add_action( 'widgets_init', 'thim_widgets_inits' );

/**
 * Enqueue styles.
 */
// remove font-awesome in elementor
add_action(
	'elementor/frontend/after_register_styles', function () {
	foreach ( [ 'solid', 'regular', 'brands' ] as $style ) {
		wp_deregister_style( 'elementor-icons-fa-' . $style );
		wp_deregister_style( 'font-awesome' );
	}
}, 20
);

/**
 * thim_get_option_var_css
 */
function thim_get_theme_option( $name = '', $value_default = '' ) {
	$data = get_theme_mods();
	if ( isset( $data[$name] ) ) {
		return $data[$name];
	} else {
		return $value_default;
	}
}

function thim_get_option_var_css() {
	$css           = '';
	$theme_options = array(
		// hearder
		'thim_body_primary_color'   => '#ffb606',
		'thim_body_secondary_color' => '#4caf50',
		'thim_button_text_color'    => '#333',
		'thim_button_hover_color'   => '#e6a303',
		'thim_border_color'         => '#eee',
		'top_info_course'           => array(
			'background_color' => '#273044',
			'text_color'       => '#fff',
		),

		'thim_footer_font_title'                 => array(
			'variant'        => get_theme_mod( 'thim_footer_font_title_font_weight', 700 ),
			'font-size'      => '14px',
			'line-height'    => '40px',
			'text-transform' => 'uppercase',
		),
		'thim_top_heading_title_align'           => 'left',
		'thim_top_heading_title_font'            => array(
			'size-desktop'   => '48px',
			'size-mobile'    => '35px',
			'text-transform' => 'uppercase',
			'weight'         => 'bold',
		),
		'thim_top_heading_padding'               => array(
			'top'           => '90px',
			'bottom'        => '90px',
			'top-mobile'    => '50px',
			'bottom-mobile' => '50px',
		),
		'thim_breacrumb_font_size'               => '1em',
		'thim_breacrumb_color'                   => '#666',
		'thim_breacrumb_bg_color'                => '',
		'thim_breacrumb_border_color'            => '',
		'thim_course_price_color'                => '#f24c0a',
		// Thim Logo
		'thim_width_logo'                        => '155px',
		// Thim ToolBar
		'thim_bg_color_toolbar'                  => '#111',
		'thim_text_color_toolbar'                => '#ababab',
		'thim_link_color_toolbar'                => '#fff',
		'thim_link_hover_color_toolbar'          => '#fff',
		'thim_toolbar'                           => array(
			'variant'        => get_theme_mod( 'thim_toolbar_font_weight', 600 ),
			'font-size'      => '12px',
			'line-height'    => '30px',
			'text-transform' => 'none',
		),
		//		'thim_toolbar_font_weight'               => '600',
		'thim_toolbar_border_type'               => 'dashed',
		'thim_toolbar_border_size'               => '1px',
		'thim_link_color_toolbar_border_button'  => '#ddd',
		// Main Menu
		'thim_bg_main_menu_color'                => 'rgba(255,255,255,0)',
		'thim_main_menu'                         => array(
			'variant'        => get_theme_mod( 'thim_main_menu_font_weight', 600 ),
			'font-size'      => '14px',
			'line-height'    => '1.3em',
			'text-transform' => 'uppercase',
		),
		'thim_main_menu_font_weight'             => '600',
		'thim_main_menu_text_color'              => '#fff',
		'thim_main_menu_text_hover_color'        => '#fff',
		// Sticky Menu
		'thim_sticky_bg_main_menu_color'         => '#fff',
		'thim_sticky_main_menu_text_color'       => '#333',
		'thim_sticky_main_menu_text_hover_color' => '#333',
		// Sub Menu
		'thim_sub_menu_bg_color'                 => '#fff',
		'thim_sub_menu_border_color'             => 'rgba(43,43,43,0)',
		'thim_sub_menu_text_color'               => '#999',
		'thim_sub_menu_text_color_hover'         => '#333',

		// Mobile Menu
		'thim_bg_mobile_menu_color'              => '#232323',
		'thim_mobile_menu_text_color'            => '#777',
		'thim_mobile_menu_text_hover_color'      => '#fff',
		// Footer
		'thim_footer_font_size'                  => '14px',

		'thim_bg_switch_layout_style'      => '#f5f5f5',
		'thim_padding_switch_layout_style' => '10px',

		'thim_font_body'             => array(
			'font-family' => 'Roboto',
			'variant'     => '400',
			'font-size'   => '15px',
			'line-height' => '1.7em',
			'color'       => '#666666',
		),
		'thim_font_title'            => array(
			'font-family' => 'Roboto Slab',
			'color'       => '#333333',
			'variant'     => '700',
		),
		'thim_font_h1'               => array(
			'font-size'      => '36px',
			'line-height'    => '1.6em',
			'text-transform' => 'none',
		),
		'thim_font_h2'               => array(
			'font-size'      => '28px',
			'line-height'    => '1.6em',
			'text-transform' => 'none',
		),
		'thim_font_h3'               => array(
			'font-size'      => '24px',
			'line-height'    => '1.6em',
			'text-transform' => 'none',
		),
		'thim_font_h4'               => array(
			'font-size'      => '18px',
			'line-height'    => '1.6em',
			'text-transform' => 'none',
		),
		'thim_font_h5'               => array(
			'font-size'      => '16px',
			'line-height'    => '1.6em',
			'text-transform' => 'none',
		),
		'thim_font_h6'               => array(
			'font-size'      => '16px',
			'line-height'    => '1.4em',
			'text-transform' => 'none',
		),
		'thim_font_title_sidebar'    => array(
			'font-size'      => '18px',
			'line-height'    => '1.4em',
			'text-transform' => 'uppercase',
		),
		'thim_font_button'           => array(
			'variant'        => 'regular',
			'font-size'      => '13px',
			'line-height'    => '1.6em',
			'text-transform' => 'uppercase',
		),
		'thim_preload_style'         => array(
			'background' => '#fff',
			'color'      => '#333333',
		),
		'thim_footer_bg_color'       => '#111',
		'thim_footer_color'          => array(
			'title' => '#ffffff',
			'text'  => '#ffffff',
			'link'  => '#ffffff',
			'hover' => '#ffb606',
		),
		'thim_padding_content'       => array(
			'pdtop-desktop'    => '60px',
			'pdbottom-desktop' => '60px',
			'pdtop-mobile'     => '40px',
			'pdbottom-mobile'  => '40px'
		),
		'thim_content_course_border' => false,
		'thim_border_radius'         => array(
			'item'     => '4px',
			'item-big' => '10px',
			'button'   => '4px',
		),

		'thim_copyright_bg_color'     => '#111',
		'thim_copyright_text_color'   => '#999',
		'thim_copyright_border_color' => '#222',

		'thim_bg_pattern'            => THIM_URI . 'images/patterns/pattern1.png',
		'thim_bg_upload'             => '',
		'thim_bg_repeat'             => 'no-repeat',
		'thim_bg_position'           => 'center',
		'thim_bg_attachment'         => 'inherit',
		'thim_bg_size'               => 'inherit',
		'thim_footer_background_img' => '',
		'thim_footer_bg_repeat'      => 'no-repeat',
		'thim_footer_bg_position'    => 'center',
		'thim_footer_bg_size'        => 'inherit',
		'thim_footer_bg_attachment'  => 'inherit',
		'thim_body_bg_color'         => '#fff'
	);

	if ( get_theme_mod( 'thim_content_course_border', false ) == false ) {
		unset( $theme_options['thim_border_radius'] );
	}

	foreach ( $theme_options as $key => $val ) {
		$val_opt = thim_get_theme_option( $key, $val );
		if ( is_array( $val_opt ) ) {
			// get options default
			foreach ( $val as $attr => $value ) {
				$val_ar = isset( $val_opt[$attr] ) ? $val_opt[$attr] : $value;
				$css    .= '--' . str_replace( '_', '-', $key ) . '-' . $attr . ':' . $val_ar . ';';
			}
		} else {
			if ( $val_opt != '' ) {
				if ( in_array( $key, array( 'thim_bg_pattern', 'thim_footer_background_img', 'thim_bg_upload' ) ) ) {
					$val_opt = 'url("' . $val_opt . '")';
				}

				$css .= '--' . str_replace( '_', '-', $key ) . ':' . $val_opt . ';';
				// convert primary color to rga
				if ( $key == 'thim_main_menu_text_color' || $key == 'thim_sticky_main_menu_text_color' || $key == 'thim_mobile_menu_text_color' ) {
					if ( $val_opt[0] == '#' ) {
						list( $r, $g, $b ) = sscanf( $val_opt, "#%02x%02x%02x" );
						$css .= '--' . $key . '_rgb: ' . $r . ',' . $g . ',' . $b . ';';
					} else {
						$rgba    = explode( ',', $val_opt );
						$rgba_rr = explode( '(', $rgba['0'] );
						$css     .= '--' . $key . '_rgb: ' . $rgba_rr['1'] . ',' . $rgba['1'] . ',' . $rgba['2'] . ';';
					}
				}
			}
		}

		// get data for on type is image
	}

	return apply_filters( 'thim_get_var_css_customizer', $css );
}

function thim_custom_color_header_single_page() {
	$css = '';
	if ( is_page() || is_single() ) {
		$bg_main_menu_color         = get_post_meta( get_the_ID(), 'thim_mtb_bg_main_menu_color', true );
		$main_menu_text_color       = get_post_meta( get_the_ID(), 'thim_mtb_main_menu_text_color', true );
		$main_menu_text_hover_color = get_post_meta( get_the_ID(), 'thim_mtb_main_menu_text_hover_color', true );
		$var_css                    = $bg_main_menu_color ? '--thim-bg-main-menu-color:' . $bg_main_menu_color . ';' : '';
		$var_css                    .= $bg_main_menu_color ? '--thim-main-menu-text-color:' . $main_menu_text_color . ';' : '';
		$var_css                    .= $bg_main_menu_color ? '--thim-main-menu-text-hover-color:' . $main_menu_text_hover_color . ';' : '';
		$css                        .= $var_css ? '#masthead{' . $var_css . '}' : '';
	}

	if ( thim_lp_style_single_course() == 'layout_style_3' ) {
		$top_info_color    = get_post_meta( get_the_ID(), 'thim_mtb_text_top_info_course', true );
		$bg_top_info_color = get_post_meta( get_the_ID(), 'thim_mtb_bg_top_info_course', true );
		$var_css           = $bg_top_info_color ? '--top-info-course-background_color:' . $bg_top_info_color . ';' : '';
		$var_css           .= $top_info_color ? '--top-info-course-text_color:' . $top_info_color . ';' : '';
		$css               .= $var_css ? '.postid-' . get_the_ID() . '.single-lp_course .course-info-top{' . $var_css . '}' : '';
	}

	return $css;
}

if ( ! function_exists( 'thim_styles' ) ) {
	function thim_styles() {
		$v_asset = THIM_THEME_VERSION;
		if ( class_exists( 'LP_Debug' ) && LP_Debug::is_debug() ) {
			$v_asset = uniqid();
		}
		wp_deregister_style( 'font-awesome' );
		if ( ! class_exists( 'TP' ) ) {
			wp_enqueue_style( 'thim-fontgoogle-default', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap', array(), THIM_THEME_VERSION );
		}
		// deregister font awesome in LP
		wp_enqueue_style( 'font-awesome-5-all', THIM_URI . 'assets/css/all.min.css', array(), THIM_THEME_VERSION );
		wp_enqueue_style( 'font-awesome-4-shim', THIM_URI . 'assets/css/v4-shims.min.css', array(), THIM_THEME_VERSION );

		wp_register_style( 'ionicons', THIM_URI . 'assets/css/ionicons.min.css' );
		wp_register_style( 'font-pe-icon-7', THIM_URI . 'assets/css/font-pe-icon-7.css' );
		wp_register_style( 'flaticon', THIM_URI . 'assets/css/flaticon.css' );
		wp_deregister_style( 'thim-ekit-font-icon' );

		wp_register_style( 'thim-portfolio', THIM_URI . 'assets/css/libs/portfolio.css', array(), THIM_THEME_VERSION );

		wp_enqueue_style( 'elementor-icons-thim-ekits-fonts', THIM_URI . 'assets/css/thim-ekits-icons.min.css', array(), THIM_THEME_VERSION );

		wp_enqueue_style( 'thim-style', get_stylesheet_uri(), array(), $v_asset );

		// css inline
		$css_line = ':root{' . preg_replace(
				array( '/\s*(\w)\s*{\s*/', '/\s*(\S*:)(\s*)([^;]*)(\s|\n)*;(\n|\s)*/', '/\n/', '/\s*}\s*/' ),
				array( '$1{ ', '$1$3;', "", '} ' ), thim_get_option_var_css()
			) . '}';
		$css_line .= trim( thim_custom_color_header_single_page() );
		$css_line .= apply_filters( 'thim_custom_internal_css', '' );
		wp_add_inline_style(
			'thim-style', $css_line
		);

		// fix font icon for child theme
		if ( apply_filters( 'learn_press_child_in_parrent_template_path', '' ) ) {
			wp_enqueue_style( 'ionicons' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'thim_styles', 1001 );

/**
 * Enqueue scripts.
 */
if ( ! function_exists( 'thim_scripts' ) ) {
	function thim_scripts() {
		$v_asset = THIM_THEME_VERSION;
		$min     = '.min';
		if ( class_exists( 'LP_Debug' ) && LP_Debug::is_debug() ) {
			$v_asset = uniqid();
			$min     = '';
		}
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		// New script update
		wp_register_script( 'thim-content-slider', THIM_URI . 'assets/js/thim-content-slider.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'flexslider', THIM_URI . 'assets/js/jquery.flexslider-min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'magnific-popup', THIM_URI . 'assets/js/jquery.magnific-popup.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'mb-commingsoon', THIM_URI . 'assets/js/mb-commingsoon.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'isotope', THIM_URI . 'assets/js/isotope.pkgd.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'thim_simple_slider', THIM_URI . 'assets/js/thim_simple_slider.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'thim-portfolio-appear', THIM_URI . 'assets/js/jquery.appear.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'thim-portfolio-widget', THIM_URI . 'assets/js/portfolio.min.js', array( 'jquery', 'isotope' ), THIM_THEME_VERSION, true );
		wp_register_script( 'search-course-widget', THIM_URI . 'assets/js/search-course' . $min . '.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'waypoints', THIM_URI . 'assets/js/jquery.waypoints.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_register_script( 'thim-CountTo', THIM_URI . 'assets/js/jquery.countTo.min.js', array( 'jquery' ), THIM_THEME_VERSION, true );
		wp_enqueue_script( 'thim-main', THIM_URI . 'assets/js/main.min.js', array( 'jquery', 'imagesloaded' ), THIM_THEME_VERSION, true );

		// thim archive api v2
		if ( thim_is_new_learnpress( '4.1.6' ) ) {
			if ( class_exists( 'LP_Page_Controller' ) && LP_PAGE_COURSES === LP_Page_Controller::page_current() ) {
				wp_enqueue_script( 'thim-scripts-course-filter', THIM_URI . 'assets/js/thim-course-filter-v2' . $min . '.js', array( 'jquery', 'wp-api-fetch', 'lp-courses', 'wp-hooks' ), $v_asset, true );
			}
		} else {
			wp_enqueue_script( 'thim-scripts-course-filter', THIM_URI . 'assets/js/thim-course-filter' . $min . '.js', array( 'jquery' ), $v_asset, true );
		}

		wp_enqueue_script( 'thim-scripts', THIM_URI . 'assets/js/thim-scripts' . $min . '.js', array( 'jquery' ), $v_asset, true );

		if ( get_post_type() == 'portfolio' && ( is_category() || is_archive() || is_singular( 'portfolio' ) ) ) {
			wp_enqueue_script( 'thim-portfolio-appear' );
			wp_enqueue_script( 'thim-portfolio-widget' );
			wp_enqueue_style( 'thim-portfolio' );
		}

		wp_dequeue_script( 'framework-bootstrap' );
		wp_dequeue_script( 'bootstrap' );

		// Remove some scripts LearnPress
		wp_dequeue_style( 'lpr-print-rate-css' );
		wp_dequeue_style( 'tipsy' );
		wp_dequeue_style( 'certificate' );
		wp_dequeue_style( 'fib' );
		wp_dequeue_style( 'sorting-choice' );
		wp_dequeue_style( 'course-wishlist-style' );
		wp_dequeue_script( 'tipsy' );
		wp_dequeue_script( 'lpr-print-rate-js' );
		wp_dequeue_script( 'course-wishlist-script' );
		wp_dequeue_style( 'learn-press-pmpro-style' );
		wp_dequeue_style( 'learn-press-jalerts' );

		if ( is_front_page() ) {
			wp_dequeue_script( 'webfont' );
			wp_dequeue_script( 'fabric-js' );
			wp_dequeue_script( 'certificate' );
		}

		wp_dequeue_style( 'mo_openid_admin_settings_style' );
		wp_dequeue_style( 'mo_openid_admin_settings_phone_style' );
		//wp_dequeue_style( 'mo-wp-bootstrap-social' );
		wp_dequeue_style( 'mo-wp-bootstrap-main' );
		wp_dequeue_style( 'mo-wp-font-awesome' );

		//Miniorange-login
		wp_dequeue_script( 'js-cookie-script' );
		wp_dequeue_script( 'mo-social-login-script' );

		if ( ! thim_use_bbpress() ) {
			wp_dequeue_style( 'bbp-default' );
			wp_dequeue_script( 'bbpress-editor' );
		}

		//LearnPress 2.0
		wp_dequeue_style( 'owl_carousel_css' );
		wp_dequeue_style( 'learn-press-coming-soon-course' );
		wp_dequeue_script( 'learn-press-jquery-mb-coming-soon' );
		//library css event
		$dequeue_style_event = true;
		if ( get_post_type() == 'tp_event' && is_single() ) {
			$dequeue_style_event = false;
		}

		if ( $dequeue_style_event ) {
			wp_dequeue_style( 'wpems-countdown-css' );
			wp_dequeue_style( 'wpems-owl-carousel-css' );
			wp_dequeue_style( 'wpems-fronted-css' );
			wp_dequeue_style( 'wpems-magnific-popup-css' );
			wp_dequeue_script( 'wpems-magnific-popup-js' );
			wp_dequeue_script( 'wpems-countdown-plugin-js' );
			wp_dequeue_script( 'wpems-countdown-js' );
			wp_dequeue_script( 'wpems-owl-carousel-js' );
			wp_dequeue_script( 'wpems-frontend-js' );
		}

		if ( class_exists( 'WooCommerce' ) && ! is_woocommerce() && ! is_shop() && ! is_product_category() && ! is_product() && ! is_cart() && ! is_checkout() ) {
			wp_dequeue_style( 'wc-blocks-vendors-style' );
			wp_dequeue_style( 'wc-blocks-style' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'jquery-blockui' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'thim_scripts', 1000 );
function thim_custom_admin_scripts() {
	wp_enqueue_script( 'thim-admin-custom-script', THIM_URI . 'assets/js/admin-custom-script.js', array( 'jquery' ), THIM_THEME_VERSION, true );
	wp_enqueue_style( 'thim-admin-theme-style', THIM_URI . 'assets/css/thim-admin.css', array(), THIM_THEME_VERSION );

	wp_register_style( 'thim-admin-font-icon7', THIM_URI . 'assets/css/font-pe-icon-7.css', array(), THIM_THEME_VERSION );
	wp_register_style( 'thim-admin-font-flaticon', THIM_URI . 'assets/css/flaticon.css', array(), THIM_THEME_VERSION );
	wp_register_style( 'thim-admin-ionicons', THIM_URI . 'assets/css/ionicons.min.css', array(), THIM_THEME_VERSION );

	$thim_mod                 = get_theme_mods();
	$thim_page_builder_chosen = ! empty( $thim_mod['thim_page_builder_chosen'] ) ? $thim_mod['thim_page_builder_chosen'] : '';
	wp_localize_script( 'thim-admin-custom-script', 'thim_theme_mods', array(
			'thim_page_builder_chosen' => $thim_page_builder_chosen,
		)
	);
}

add_action( 'admin_enqueue_scripts', 'thim_custom_admin_scripts' );


if ( defined( 'THIM_CORE_VERSION' ) && version_compare( THIM_CORE_VERSION, '2.2.4', '<' ) ) {
	require_once THIM_DIR . 'inc/libs/down_image_size.php';
}
// Custom functions.
require_once get_template_directory() . '/inc/custom-functions.php';

include_once THIM_DIR . '/inc/register-functions.php';

/**
 * Custom template tags for this theme.
 */
require_once THIM_DIR . 'inc/template-tags.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once THIM_DIR . 'woocommerce/woocommerce.php';
}

if ( class_exists( 'WPEMS' ) ) {
	require_once THIM_DIR . 'wp-events-manager/events.php';
}

if ( class_exists( 'BuddyPress' ) ) {
	require_once THIM_DIR . 'buddypress/bp-custom.php';
}

//logo
require_once THIM_DIR . 'inc/header/logo.php';

//custom logo mobile
require_once THIM_DIR . 'inc/header/logo-mobile.php';

// Remove references to SiteOrigin Premium
add_filter( 'siteorigin_premium_upgrade_teaser', '__return_false' );

//For use thim-core
require_once THIM_DIR . 'inc/thim-core-function.php';

add_filter( 'thim_ekit/mega_menu/menu_container/class', function () {
	return 'header .thim-nav-wrapper .tm-table';
} );

if ( ! function_exists( 'thim_enable_upload_svg' ) ) {
	function thim_enable_upload_svg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	add_filter( 'upload_mimes', 'thim_enable_upload_svg' );
}
