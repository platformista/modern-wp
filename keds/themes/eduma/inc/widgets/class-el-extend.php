<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class Thim_Elementor_Extend {
	private static $instance = null;

	public function __construct() {
//		add_action( 'elementor/frontend/before_enqueue_styles', array( $this, 'font_setup' ) );
 		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'backend_style' ) );
		// add widget categories
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );

		add_action( 'elementor/widgets/register', array( $this, 'thim_register_widgets' ), 200 );

		// register font for vc
		add_action( 'vc_backend_editor_enqueue_js_css', array( $this, 'thim_vc_iconpicker_editor_jscss' ) );
		add_action( 'vc_frontend_editor_enqueue_js_css', array( $this, 'thim_vc_iconpicker_editor_jscss' ) );

		// add custom font for VC and SO and EL
		$list_icons = array( 'ionicons', 'flat_icon', 'stroke_icon' );
		foreach ( $list_icons as $list_icon ) {

			add_filter(
				'thim-builder-el-' . $list_icon . '-icon',
				function () use ( $list_icon ) {
					$arr              = $this->thim_load_font_icon();
					$list_new_icon_el = array();
					if ( ! empty( $arr ) ) {
						foreach ( $arr[ $list_icon ] as $icons ) {
							foreach ( $icons as $key => $label ) {
								$list_new_icon_el[ $key ] = $key;
							}
						}
					}

					return $list_new_icon_el;
				}
			);

			add_filter(
				'vc_iconpicker-type-' . $list_icon,
				function () use ( $list_icon ) {
					$custom_icon = $this->thim_load_font_icon();

					return $custom_icon[ $list_icon ];
				}
			);

			add_filter(
				'thim-builder-so-' . $list_icon . '-icon',
				function () use ( $list_icon ) {
					$arr           = $this->thim_load_font_icon();
					$list_new_icon = array();
					if ( ! empty( $arr ) ) {
						foreach ( $arr[ $list_icon ] as $icons ) {
							foreach ( $icons as $key => $label ) {
								$list_new_icon[] = str_replace( array( 'pe-7s-', 'flaticon-' ), '', $key );
							}
						}
					}

					return $list_new_icon;
				}
			);
		}

		// change HTML thim_ekit_footer_header
		$this->theme_ekit_footer_header();

		add_filter( 'learn-thim-kits-lp-meta-data', array( $this, 'thim_review_meta_data_widget_course' ), 100 );
		add_filter( 'thim-kits-extral-meta-data', array( $this, 'thim_kits_meta_data_course_ratting' ), 100, 3 );

	}

//	public function font_setup() {
// 		wp_register_style( 'flaticon', THIM_URI . 'assets/css/flaticon.css' );
//		wp_register_style( 'font-pe-icon-7', THIM_URI . 'assets/css/font-pe-icon-7.css' );
//		wp_register_style( 'ionicons', THIM_URI . 'assets/css/ionicons.min.css' );
//	}
	public function backend_style() {
		wp_enqueue_style( 'flaticon', THIM_URI . 'assets/css/flaticon.css' );
		wp_enqueue_style( 'font-pe-icon-7', THIM_URI . 'assets/css/font-pe-icon-7.css' );
		wp_enqueue_style( 'ionicons', THIM_URI . 'assets/css/ionicons.min.css' );
		wp_enqueue_style( 'thim-font-icon', THIM_URI . 'assets/css/thim-icons.css' );
	}
	function theme_ekit_footer_header() {
		// Thim Elementor Kit
		add_action( 'thim_ekit/header_footer/template/before_footer', 'thim_above_footer_area_fnc' );
		add_action( 'thim_ekit/header_footer/template/before_header', 'thim_print_preload', 5 );

		add_action(
			'thim_ekit/header_footer/template/after_footer',
			function () {
				echo '</div>';
			},
			1
		);
		add_action( 'thim_ekit/header_footer/template/after_footer', 'thim_footer_bottom', 5 );
		add_action(
			'thim_ekit/header_footer/template/after_footer',
			function () {
				echo '</div></div>';
			},
			10
		);

		add_action(
			'thim_ekit/header_footer/template/before_header',
			function () {
				echo '<div id="wrapper-container" class="wrapper-container"><div class="content-pusher">';
			},
			10
		);
		add_action(
			'thim_ekit/header_footer/template/after_header',
			function () {
				echo '<div id="main-content">';
			},
			5
		);
	}

	public function register_categories() {
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'thim_ekit',
			array(
				'title' => esc_html__( 'Thim Basic', 'thim-elementor-kit' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	public function thim_register_widgets( $widgets_manager ) {

		$widgets_all = apply_filters( 'thim_register_shortcode', array() );
		if ( ! empty( $widgets_all ) ) {
			foreach ( $widgets_all as $base => $widgets ) {

				if ( $base == 'general' || ( $base != 'general' && class_exists( $base ) ) ) {
					foreach ( $widgets as $widget ) {
						// unregister thim wp-widget
						$widgets_manager->unregister( 'wp-widget-' . $widget );
						// register widget for EL
						$file = THIM_DIR . "thim-elementor-kit/$widget/$widget.php";

						if ( file_exists( $file ) ) {
							require_once $file;

							$class = ucwords( str_replace( '-', ' ', $widget ) );
							$class = str_replace( ' ', '_', $class );
							$class = sprintf( '\Elementor\Thim_Ekit_Widget_%s', $class );

							if ( class_exists( $class ) ) {
								$widgets_manager->register( new $class() );
							}
						}
					}
				}
			}
		}
		// register widget login popup
		require_once THIM_DIR . 'thim-elementor-kit/login-popup/login-popup.php';
		if ( class_exists( '\Elementor\Thim_Ekit_Widget_Login_Popup' ) ) {
			$widgets_manager->register( new \Elementor\Thim_Ekit_Widget_Login_Popup() );
		}
	}

	public static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	function thim_vc_iconpicker_editor_jscss() {
		wp_enqueue_style( 'thim-admin-ionicons' );
		wp_enqueue_style( 'thim-admin-font-flaticon' );
	}

	public function thim_load_font_icon() {
  	    $icon = include THIM_DIR . 'inc/widgets/icons.php';
 		return $icon;
	}

	function thim_review_meta_data_widget_course( $opt ) {
		if ( class_exists( 'LP_Addon_Course_Review' ) ) {
			$opt['review_course'] = esc_html__( 'Review', 'eduma' );
		}

		return $opt;
	}

	function thim_kits_meta_data_course_ratting( $string, $meta_data, $settings ) {
		if ( class_exists( 'LP_Addon_Course_Review' ) && in_array( 'review_course', $meta_data ) ) {
			$course_rate = learn_press_get_course_rate( get_the_ID() );
			?>
			<span class="course-review">
			 <?php thim_print_rating( $course_rate ); ?>
		</span>
			<?php
		}

		return $string;
	}
}

Thim_Elementor_Extend::get_instance();
