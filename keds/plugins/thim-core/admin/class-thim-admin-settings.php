<?php

/**
 * Class Thim_Admin_Settings
 *
 * @since 1.1.0
 */
class Thim_Admin_Settings extends Thim_Singleton {
	/**
	 * @var string
	 *
	 * @since 1.1.0
	 */
	private static $key_option = 'thim_core_admin_settings';

	/**
	 * @var array
	 *
	 * @since 1.1.0
	 */
	private static $settings = null;

	/**
	 * Thim_Admin_Settings constructor.
	 *
	 * @since 1.1.0
	 */
	protected function __construct() {
	}

	/**
	 * Get all settings.
	 *
	 * @since 1.1.0
	 *
	 * @return array
	 */
	private static function get_settings() {
		if ( self::$settings === null ) {
			self::$settings = get_option( self::$key_option, array() );
		}

		return (array) self::$settings;
	}

	/**
	 * Update settings.
	 *
	 * @since 1.1.0
	 *
	 * @param $settings array
	 */
	private static function update_settings( $settings ) {
		self::$settings = $settings;
		update_option( self::$key_option, $settings );
	}

	/**
	 * Get setting by key.
	 *
	 * @since 1.1.0
	 *
	 * @param $key
	 * @param $default
	 *
	 * @return mixed
	 */
	public static function get( $key, $default ) {
		$settings = self::get_settings();
		if ( ! isset( $settings[ $key ] ) ) {
			return $default;
		}

		return $settings[ $key ];
	}

	/**
	 * Set settings.
	 *
	 * @since 1.1.0
	 *
	 * @param $key
	 * @param $value
	 */
	public static function set( $key, $value ) {
		$settings         = self::get_settings();
		$settings[ $key ] = $value;
		self::update_settings( $settings );
	}
}