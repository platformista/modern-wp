<?php

/**
 * Class Thim_Core_Admin.
 *
 * @package   Thim_Core
 * @since     0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Thim_Core_Admin' ) ) {
	class Thim_Core_Admin extends Thim_Singleton {
		/**
		 * Go to theme dashboard.
		 *
		 * @since 0.8.1
		 */
		public static function go_to_theme_dashboard() {
			$link_page = admin_url( '?thim-core-redirect-to-dashboard' );

			thim_core_redirect( $link_page );
		}

		/**
		 * Detect my theme.
		 *
		 * @return bool
		 * @since 0.8.0
		 *
		 */
		public static function is_my_theme() {
			return (bool) get_theme_support( 'thim-core' );
		}

		/**
		 * Thim_Core_Admin constructor.
		 *
		 * @since 0.1.0
		 */
		protected function __construct() {
			spl_autoload_register( array( $this, 'autoload' ) );

			if ( ! self::is_my_theme() ) {
				return;
			}

			$this->init();
			$this->init_hooks();
		}

		/**
		 * Fake page to redirect to dashboard.
		 *
		 * @since 0.8.1
		 */
		public function redirect_to_dashboard() {
			$request = isset( $_REQUEST['thim-core-redirect-to-dashboard'] );

			if ( ! $request ) {
				return;
			}

			$this->redirect_user();
		}

		/**
		 * Handle redirect the user.
		 *
		 * @since 0.8.5
		 */
		private function redirect_user() {
			$url = Thim_Dashboard::get_link_main_dashboard();

			if ( Thim_Dashboard::check_first_install() ) {
				Thim_Admin_Settings::set( 'first_install', false );

				$url = Thim_Dashboard::get_link_page_by_slug( 'getting-started' );
			}

			thim_core_redirect( $url );
		}

		/**
		 * Init.
		 *
		 * @since 0.1.0
		 */
		private function init() {
			$this->run();
		}

		/**
		 * Autoload classes.
		 *
		 * @param $class
		 *
		 * @since 0.3.0
		 *
		 */
		public function autoload( $class ) {
			$class = strtolower( $class );

			$file_name = 'class-' . str_replace( '_', '-', $class ) . '.php';

			if ( strpos( $class, 'service' ) !== false ) {
				$file_name = 'services/' . $file_name;
			}

			$file = THIM_CORE_ADMIN_PATH . DIRECTORY_SEPARATOR . $file_name;
			if ( is_readable( $file ) ) {
				require_once $file;
			}
		}

		/**
		 * Notice permission uploads.
		 *
		 * @since 0.8.9
		 */
		public function notice_permission_uploads() {
			$dir = WP_CONTENT_DIR;

			$writable = wp_is_writable( $dir );
			if ( $writable ) {
				return;
			}

			Thim_Notification::add_notification(
				array(
					'id'          => 'permission_uploads',
					'type'        => 'error',
					'content'     => __(
						"<h3>Important!</h3>Your server doesn't not have a permission to write in <strong>WP Uploads</strong> folder ($dir).
									The theme may not work properly with the issue. Please check this <a href='https://goo.gl/guirO5' target='_blank'>guide</a> to fix it.", 'thim-core'
					),
					'dismissible' => false,
					'global'      => true,
				)
			);
		}

		/**
		 * Run admin core.
		 *
		 * @since 0.3.0
		 */
		private function run() {
			Thim_Admin_Config::instance();

			Thim_Modal::instance();
			Thim_Metabox::instance();
			Thim_Post_Formats::instance();
			Thim_Singular_Settings::instance();
			Thim_Sidebar_Manager::instance();
			Thim_Dashboard::instance();
			Thim_Layout_Builder::instance();
			if ( apply_filters( 'thim-support-mega-menu', true ) ) {
				Thim_Menu_Manager::instance();
			}
			Thim_Importer_Mapping::instance();
			Thim_Self_Update::instance();
			Thim_Welcome_Panel::instance();
			Thim_Developer_Access::instance();
			Thim_Pointers::instance();
			Thim_Free_Theme::instance();

			if( Thim_Product_Registration::get_site_key() ){
               Thim_Core_Schedule::instance();
			}

		}

		/**
		 * Init hooks.
		 *
		 * @since 0.1.0
		 */
		private function init_hooks() {
			add_action( 'admin_init', array( $this, 'redirect_to_dashboard' ) );
			add_action( 'admin_menu', array( $this, 'remove_unnecessary_menus' ), 999 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 5 );
			add_filter( 'plugin_action_links_thim-core/thim-core.php', array( $this, 'add_action_links' ) );
			add_action( 'admin_head', array( $this, 'admin_styles' ) );
			add_filter( 'thim_core_installer_hidden_menu', array( $this, 'hidden_menu_installer' ) );
			add_action( 'thim_core_dashboard_init', array( $this, 'notice_permission_uploads' ) );
			add_filter( 'thim_core_admin_memory_limit', array( $this, 'memory_limit' ) );

			add_action( 'thim_core_installer_complete', array( 'Thim_Core_Admin', 'go_to_theme_dashboard' ) );
		}

		/**
		 * Raise memory limit.
		 *
		 * @param $current
		 *
		 * @return string
		 * @since 1.4.8.1
		 *
		 */
		public function memory_limit( $current ) {
			$current_limit_int = wp_convert_hr_to_bytes( $current );

			if ( $current_limit_int > 268435456 ) {
				return $current;
			}

			return '256M';
		}


		/**
		 * Hidden menu installer.
		 *
		 * @return bool
		 * @since 1.0.0
		 *
		 */
		public function hidden_menu_installer() {
			return true;
		}

		/**
		 * Add custom style inline in admin.
		 *
		 * @since 0.9.1
		 */
		public function admin_styles() {
			global $_wp_admin_css_colors;

			$colors = array(
				'#222',
				'#333',
				'#0073aa',
				'#00a0d2',
			);

			$pack = get_user_meta( get_current_user_id(), 'admin_color', true );
			if ( is_array( $_wp_admin_css_colors ) ) {
				foreach ( $_wp_admin_css_colors as $key => $package ) {
					if ( $pack == $key ) {
						$package = (array) $package;
						$colors  = $package['colors'];
					}
				}
			}

			Thim_Template_Helper::template( 'admin-styles.php', array( 'colors' => $colors, 'key' => $pack ), true );
		}

		/**
		 * Remove unnecessary menus.
		 *
		 * @since 0.8.8
		 */
		public function remove_unnecessary_menus() {
			global $submenu;
			unset( $submenu['themes.php'][15] );
			unset( $submenu['themes.php'][20] );
		}

		/**
		 * Add action links.
		 *
		 * @param $links
		 *
		 * @return string[]
		 * @since 0.8.0
		 *
		 */
		public function add_action_links( $links ) {
			$links[] = '<a href="https://thimpress.com/forums/" target="_blank">' . __( 'Support', 'thim-core' ) . '</a>';

			return $links;
		}

		/**
		 * Enqueue scripts.
		 *
		 * @since 0.2.1
		 */
		public function enqueue_scripts() {
 			$ver = THIM_CORE_VERSION;
			if ( TP::is_debug() ) {
 				$ver = uniqid();
			}
 			wp_register_script( 'thim-core-admin', THIM_CORE_ADMIN_URI . '/assets/js/core.min.js', array( 'jquery' ), $ver );
			wp_register_script( 'thim-core-clipboard', THIM_CORE_ADMIN_URI . '/assets/js/clipboard.min.js', array(), '1.6.0' );
			wp_register_style( 'thim-font-awesome', 'https://use.fontawesome.com/e8cbfd9eca.css', array(), '4.7.0' );
			wp_register_script( 'youtube-api', 'https://www.youtube.com/iframe_api', array() );
			wp_register_script(
				'thim-video-youtube',
				THIM_CORE_ADMIN_URI . '/assets/js/youtube.js',
				array(
					'jquery',
					'youtube-api',
				),
				THIM_CORE_VERSION
			);

			wp_enqueue_style( 'thim-admin', THIM_CORE_ADMIN_URI . '/assets/css/admin.css', array(), THIM_CORE_VERSION );

			$this->localize_script();
		}

		/**
		 * Localize script.
		 *
		 * @since 1.3.4
		 */
		private function localize_script() {
			$theme_metadata = Thim_Theme_Manager::get_metadata();

			wp_localize_script( 'thim-core-admin', 'thim_core_settings', array(
				'active'  => Thim_Product_Registration::is_active() ? 'yes' : 'no',
				'theme'   => $theme_metadata
			) );
		}
	}

	/**
	 * Thim Core Admin init.
	 *
	 * @since 0.8.1
	 */
	function thim_core_admin_init() {
		Thim_Core_Admin::instance();
	}

	add_action( 'after_setup_theme', 'thim_core_admin_init', 99999 );
}

/**
 * Include functions.
 *
 * @since 0.1.0
 */
include_once THIM_CORE_ADMIN_PATH . '/functions.php';
