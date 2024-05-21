<?php

/**
 * Class Thim_Template_Helper.
 *
 * @since 0.9.0
 *
 */
if ( ! class_exists( 'Thim_Template_Helper' ) ) {
	class Thim_Template_Helper {
		/**
		 * Get template path.
		 *
		 * @since 1.3.0
		 */
		private static function get_template_path() {
			return apply_filters( 'thim_core_template_path', 'thim-core/' );
		}

		/**
		 * Get template part.
		 *
		 * @since 1.3.0
		 *
		 * @param $path
		 * @param $args
		 * @param $render
		 *
		 * @return bool|string
		 */
		public static function template( $path, $args = array(), $render = false ) {
			$template = locate_template( self::get_template_path() . $path );

			if ( ! $template ) {
				$template = THIM_CORE_PATH . '/templates/' . $path;
			}

			if ( $render ) {
				return self::render_template( $template, $args );
			}

			return self::get_template( $template, $args );
		}

		/**
		 * Render template.
		 *
		 * @since 0.9.0
		 *
		 * @param $file
		 * @param $args
		 *
		 * @return bool
		 */
		private static function render_template( $file, $args = array() ) {
			if ( ! is_file( $file ) || ! is_readable( $file ) ) {
				return false;
			}

			include $file;

			return true;
		}

		/**
		 * Get template.
		 *
		 * @since 0.9.0
		 *
		 * @param $file
		 * @param $args
		 *
		 * @return bool|string
		 */
		private static function get_template( $file, $args = array() ) {
			if ( ! is_file( $file ) || ! is_readable( $file ) ) {
				return false;
			}

			ob_start();
			include $file;

			return ob_get_clean();
		}
	}
}
