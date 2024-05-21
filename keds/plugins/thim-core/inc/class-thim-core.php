<?php
/**
 * Class Thim_Core
 *
 * @package   Thim_Core
 * @since     0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Thim Core.
 *
 * @since 0.1.0
 */
if ( ! class_exists( 'Thim_Core' ) ) {
	class Thim_Core extends Thim_Singleton {
		/**
		 * Thim_Core constructor.
		 *
		 * @since 0.1.0
		 */
		protected function __construct() {
			$this->init_global_variables();
			$this->init();
			$this->run();
		}

		/**
		 * Init global variables.
		 *
		 * @since 0.8.8
		 */
		private function init_global_variables() {
			/**
			 * List notifications in dashboard.
			 */
			global $thim_notifications;
			$thim_notifications = array();
		}

		/**
		 * Init functions.
		 *
		 * @since 0.1.0
		 */
		private function init() {
			$this->includes();
		}

		/**
		 * Run.
		 *
		 * @since 0.5.0
		 */
		private function run() {
			Thim_Notification::instance();
			Thim_Core_Customizer::instance();
 		}

		/**
		 * Include functions.
		 *
		 * @since 0.1.0
		 */
		private function functions() {
			$this->_require( 'functions.php' );
		}

		/**
		 * Include libraries and functions.
		 *
		 * @since 0.1.0
		 */
		private function includes() {
			$this->libraries();
			$this->functions();
		}

		/**
		 * Include libraries.
		 *
		 * @since 0.1.0
		 */
		private function libraries() {
			$this->resizer();
			$this->_require( 'class-thim-widget.php' );
			$this->_require( 'class-thim-register-shortcode.php' );
 			$this->_require( 'class-thim-breadcrumb.php' );
 			$this->_require( 'class-thim-crop-image-size.php' );
		}

		/**
		 * Include Aqua Resizer.
		 *
		 * @since 0.1.0
		 */
		private function resizer() {
			$this->_require( 'includes/aq-resizer/aq_resizer.php' );
		}

		/**
		 * Require file.
		 *
		 * @since 0.5.0
		 *
		 * @param $file
		 */
		private function _require( $file ) {
			$path = THIM_CORE_INC_PATH . DIRECTORY_SEPARATOR . $file;
			if ( ! file_exists( $path ) ) {
				return;
			}

			require_once $path;
		}
	}
}

Thim_Core::instance();
