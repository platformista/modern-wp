<?php

/**
 * Thim Core Plugin.
 * Plugin Name:       Thim Core
 * Plugin URI:        https://thimpresswp.github.io/thim-core/
 * Description:       The Ultimate Core Processor of all WordPress themes by ThimPress - Manage your website easier with Thim Core.
 * Version:           2.3.2
 * Author:            ThimPress
 * Author URI:        https://thimpress.com
 * Text Domain:       thim-core
 * Domain Path:       /languages
 * Tested up to: 6.0
 * Requires PHP: 7.4
 * @package   Thim_Core
 * @since     0.1.0
 * @author    ThimPress <contact@thimpress.com>
 * @link      https://thimpress.com
 * @copyright 2016 ThimPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Class TP
 *
 * @since 0.1.0
 */
if ( ! class_exists( 'TP' ) ) {
	class TP {
		/**
		 * @var null
		 *
		 * @since 0.1.0
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 *
		 * @since 0.1.0
		 */
		public static $prefix = 'thim_';

		/**
		 * @var string
		 *
		 * @since 0.8.5
		 */
		public static $slug = 'thim-core';

		/**
		 * @var string
		 *
		 * @since 0.2.0
		 */
		private static $option_version = 'thim_core_version';

		/**
		 * Return unique instance of TP.
		 *
		 * @since 0.1.0
		 */
		static function instance() {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Thim_Framework constructor.
		 *
		 * @since 0.1.0
		 */
		private function __construct() {
			$this->init();
			$this->hooks();

			do_action( 'thim_core_loaded' );
		}

		/**
		 * Get is debug?
		 *
		 * @return bool
		 * @since 0.1.0
		 */
		public static function is_debug() {
			if ( ! defined( 'THIM_DEBUG' ) ) {
				return false;
			}

			return (bool) THIM_DEBUG;
		}

		/**
		 * Init class.
		 *
		 * @since 0.1.0
		 */
		public function init() {
			do_action( 'before_thim_core_init' );

			$this->define_constants();
			$this->providers();

			spl_autoload_register( array( $this, 'autoload' ) );

			$this->inc();
			$this->admin();

			do_action( 'thim_core_init' );
		}

		/**
		 * Define constants.
		 *
		 * @since 0.2.0
		 */
		private function define_constants() {
			$this->define( 'THIM_CORE_FILE', __FILE__ );
			$this->define( 'THIM_CORE_PATH', dirname( __FILE__ ) );

			$this->define( 'THIM_CORE_URI', untrailingslashit( plugins_url( '/', THIM_CORE_FILE ) ) );
			$this->define( 'THIM_CORE_ASSETS_URI', THIM_CORE_URI . '/assets' );

			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			$thim_core_info = get_plugin_data( THIM_CORE_FILE );
			$this->define( 'THIM_CORE_VERSION', $thim_core_info['Version'] );

			$this->define( 'THIM_CORE_ADMIN_PATH', THIM_CORE_PATH . '/admin' );
			$this->define( 'THIM_CORE_ADMIN_URI', THIM_CORE_URI . '/admin' );
			$this->define( 'THIM_CORE_INC_PATH', THIM_CORE_PATH . '/inc' );
			$this->define( 'THIM_CORE_INC_URI', THIM_CORE_URI . '/inc' );

			$this->define( 'TP_THEME_THIM_DIR', trailingslashit( get_template_directory() ) );
			$this->define( 'TP_THEME_THIM_URI', trailingslashit( get_template_directory_uri() ) );
			$this->define( 'TP_CHILD_THEME_THIM_DIR', trailingslashit( get_stylesheet_directory() ) );
			$this->define( 'TP_CHILD_THEME_THIM_URI', trailingslashit( get_stylesheet_directory_uri() ) );
		}

		/**
		 * Define constant.
		 *
		 * @param $name
		 * @param $value
		 *
		 * @since 1.0.0
		 *
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Init hooks.
		 *
		 * @since 0.1.0
		 */
		private function hooks() {
			register_activation_hook( __FILE__, array( $this, 'install' ) );
			add_action( 'activated_plugin', array( $this, 'activated' ) );
			add_action( 'plugins_loaded', array( $this, 'text_domain' ), 1 );
		}

		/**
		 * Autoload classes.
		 *
		 * @param $class
		 *
		 * @return bool
		 * @since 1.0.0
		 *
		 */
		public function autoload( $class ) {
			$class = strtolower( $class );

			$file_name = 'class-' . str_replace( '_', '-', $class ) . '.php';

			/**
			 * Helper classes.
			 */
			if ( strpos( $class, 'helper' ) !== false ) {
				$path = THIM_CORE_PATH . '/helpers/' . $file_name;

				return $this->_require( $path );
			}

			/**
			 * Inc
			 */
			$path = THIM_CORE_INC_PATH . DIRECTORY_SEPARATOR . $file_name;
			if ( is_readable( $path ) ) {
				return $this->_require( $path );
			}

			/**
			 * Admin
			 */
			$path = THIM_CORE_ADMIN_PATH . DIRECTORY_SEPARATOR . $file_name;
			if ( is_readable( $path ) ) {
				return $this->_require( $path );
			}

			return false;
		}

		/**
		 * Require file.
		 *
		 * @param $path
		 *
		 * @return bool
		 * @since 1.0.5
		 *
		 */
		private function _require( $path ) {
			if ( ! is_readable( $path ) ) {
				return false;
			}

			require_once $path;

			return true;
		}

		/**
		 * Providers.
		 *
		 * @since 0.8.5
		 */
		private function providers() {
			require_once THIM_CORE_PATH . '/providers/class-thim-singleton.php';
		}

		/**
		 * Core.
		 *
		 * @since 0.1.0
		 */
		private function inc() {
			require_once THIM_CORE_INC_PATH . '/class-thim-core.php';
		}

		/**
		 * Admin.
		 *
		 * @since 0.1.0
		 */
		private function admin() {
			require_once THIM_CORE_PATH . '/admin/class-thim-core-admin.php';
		}

		/**
		 * Activation hook.
		 *
		 * @since 0.2.0
		 */
		public function install() {
			add_option( self::$option_version, THIM_CORE_VERSION );

			do_action( 'thim_core_activation' );
		}

		/**
		 * Hook after plugin was activated.
		 *
		 * @param $plugin
		 *
		 * @since 0.2.0
		 *
		 */
		public function activated( $plugin ) {
			$plugins_are_activating = isset( $_POST['checked'] ) ? $_POST['checked'] : array();

			if ( count( $plugins_are_activating ) > 1 ) {
				return;
			}

			if ( 'thim-core/thim-core.php' !== $plugin ) {
				return;
			}

			Thim_Core_Admin::go_to_theme_dashboard();
		}

		/**
		 * Get active network.
		 *
		 * @return bool
		 * @since 0.8.1
		 *
		 */
		public static function is_active_network() {
			if ( ! is_multisite() ) {
				return true;
			}

			$plugin_file            = 'thim-core/thim-core.php';
			$active_plugins_network = get_site_option( 'active_sitewide_plugins' );

			if ( isset( $active_plugins_network[ $plugin_file ] ) ) {
				return true;
			}

			return false;
		}
		/**
		 * Load text domain.
		 *
		 * @since 0.1.0
		 *
		 */
		function text_domain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'thim-core' );

			load_textdomain(
				'thim-core',
				trailingslashit( WP_LANG_DIR ) . 'thim-core' . '/' . 'thim-core' . '-' . $locale . '.mo'
			);
			load_plugin_textdomain(
				'thim-core', false,
				basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/'
			);
		}

		public static function theme_version_compare( $theme_name, $version2, $operator ) {
			$theme_data = wp_get_theme();

			// child theme
			if ( get_template_directory() !== get_stylesheet_directory() ) {
				$theme_data = wp_get_theme( $theme_data->parent()->template );
			}

			if ( 'ThimPress' === $theme_data->get( 'Author' ) && $theme_name === $theme_data->get( 'Name' ) && version_compare( $theme_data->get( 'Version' ), $version2, $operator ) ) {
				return true;
			}
		}
	}

	TP::instance();
}// End if().
