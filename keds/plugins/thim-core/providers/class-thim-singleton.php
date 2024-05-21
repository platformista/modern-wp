<?php

if ( ! class_exists( 'Thim_Singleton' ) ) {
	/**
	 * Class Thim_Singleton.
	 *
	 * @since 0.8.5
	 */
	abstract class Thim_Singleton {
		/**
		 * @var null
		 *
		 * @since 0.8.5
		 */
		static protected $instances = array();

		/**
		 * Thim_Singleton constructor.
		 *
		 * @since 0.8.5
		 */
		abstract protected function __construct();

		/**
		 * @since 0.8.5
		 *
		 * @return self
		 */
		static public function instance() {
			$class = self::get_called_class();
			if ( ! array_key_exists( $class, self::$instances ) ) {
				self::$instances[ $class ] = new $class();
			}

			return self::$instances[ $class ];
		}

		/**
		 * Get called class.
		 *
		 * @since 1.1.1
		 *
		 * @return string
		 */
		private static function get_called_class() {
			if ( function_exists( 'get_called_class' ) ) {
				return get_called_class();
			}

			// PHP 5.2 only
			$backtrace = debug_backtrace();
			if ( 'call_user_func' === $backtrace[2]['function'] ) {
				return $backtrace[2]['args'][0][0];
			}

			return $backtrace[2]['class'];
		}
	}
}
