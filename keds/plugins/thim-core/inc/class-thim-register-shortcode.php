<?php
/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ThimCore_Builder' ) ) {
	/**
	 * Class ThimCore_Builder
	 */
	final class ThimCore_Builder {

		/**
		 * @var null
		 */
		private static $_instance = null;

		/**
		 * BuilderPress constructor.
		 */
		public function __construct() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$this->init_hooks();
		}


		/**
		 * Init hook.
		 */
		public function init_hooks() {
			add_action( 'after_setup_theme', array( $this, 'init_elements' ) );
		}

		/**
		 * Init elements config.
		 */
		public function init_elements() {
			// edit folder shortcode and widget in theme and child theme by tuanta
			$folder_elements = apply_filters( 'thim_custom_folder_shortcodes', 'shortcodes' );

			define( 'TP_THEME_ELEMENTS_THIM_DIR', trailingslashit( get_template_directory() . '/inc/' . $folder_elements . '/' ) );
			define( 'TP_THEME_ELEMENTS_THIM_URI', trailingslashit( get_template_directory_uri() . '/inc/' . $folder_elements . '/' ) );
			define( 'TP_CHILD_THEME_ELEMENTS_THIM_DIR', trailingslashit( get_stylesheet_directory() . '/inc/' . $folder_elements . '/' ) );
			define( 'TP_CHILD_THEME_ELEMENTS_THIM_URI', trailingslashit( get_stylesheet_directory_uri() . '/inc/' . $folder_elements . '/' ) );


			$elements = self::get_elements();
			if ( empty( $elements ) ) {
				return;
			}

			require_once( THIM_CORE_INC_PATH . '/builders/class-abstract-config.php' );
			// visual composer
			if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
				require_once( THIM_CORE_INC_PATH . '/builders/visual-composer/class-vc.php' );
			}
			// widgets
			require_once( THIM_CORE_INC_PATH . '/builders/siteorigin/class-so.php' );

			// elementor
			$allow_thim_ekit = apply_filters( 'allow_thim_elementor_kit', false);
			if ( ! class_exists( 'Thim_EL_Kit' ) ) {
				$allow_thim_ekit = true;
			}

			if ( is_plugin_active( 'elementor/elementor.php' ) && $allow_thim_ekit ) {
				require_once( THIM_CORE_INC_PATH . '/builders/elementor/class-el.php' );
			}

			require_once( THIM_CORE_INC_PATH . '/builders/functions.php' );

			foreach ( $elements as $plugin => $group ) {
				foreach ( $group as $element ) {
					if ( thim_builder_folder_group() ) {
						$file_config = TP_THEME_ELEMENTS_THIM_DIR . "$plugin/$element/config.php";
					} else {
						$file_config = TP_THEME_ELEMENTS_THIM_DIR . $element . "/config.php";
					}
					if ( file_exists( $file_config ) ) {
						require_once $file_config;
					}
				}
			}

		}

		/**
		 * Get all features.
		 *
		 * @return mixed
		 */
		public static function get_elements() {
			$elements = apply_filters( 'thim_register_shortcode', array() );

			// disable elements when depends plugin not active
			foreach ( $elements as $plugin => $_elements ) {
				if ( $plugin == 'general' || $plugin == 'widgets' ) {
					continue;
				}

				if ( ! class_exists( $plugin ) ) {
					unset( $elements[$plugin] );
				}
			}

			return $elements;
		}


		/**
		 * @return null|ThimCore_Builder
		 */
		public static function instance() {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}
}

if ( ! function_exists( 'ThimCore_Builder' ) ) {
	/**
	 * @return null|ThimCore_Builder
	 */
	function ThimCore_Builder() {
		return ThimCore_Builder::instance();
	}
}

$GLOBALS['ThimCore_Builder'] = ThimCore_Builder();
