<?php

/**
 * Class Thim_Plugin_Upgrader
 *
 * @since 1.1.0
 */
class Thim_Plugin_Upgrader {
	/**
	 * @since 1.1.0
	 *
	 * @var string
	 */
	private static $tag = 'THIM_CORE_CHECK_PLUGIN_UPDATE';

	/**
	 * @since 1.1.0
	 *
	 * @var string
	 */
	private static $key_cached_information_plugins = 'thim_core_information_plugins';

	/**
	 * @since 1.1.0
	 *
	 * @var null
	 */
	private static $data_plugins = null;

	/**
	 * Url api to request information plugins.
	 *
	 * @since 1.1.0
	 *
	 * @var null
	 */
	private $url_api = null;

	/**
	 * Thim_Plugin_Upgrader constructor.
	 *
	 * @since 1.1.0
	 *
	 * @param $url_api
	 */
	public function __construct( $url_api ) {
		$this->url_api = $url_api;
	}

	/**
	 * Check can update.
	 *
	 * @since 1.1.0
	 *
	 * @param $plugin Thim_Plugin
	 *
	 * @return bool|array
	 */
	public function check_can_update( $plugin ) {
		$slug        = $plugin->get_slug();
		$data_plugin = $this->get_data_plugin( $slug );
		if ( ! $data_plugin ) {
			return false;
		}

		$latest_version  = isset( $data_plugin['version'] ) ? $data_plugin['version'] : false;
		$current_version = $plugin->get_current_version();

		if ( version_compare( $latest_version, $current_version, '<=' ) ) {
			return false;
		}

		return $data_plugin;
	}

	/**
	 * Get data plugin by slug.
	 *
	 * @since 1.1.0
	 *
	 * @param $slug
	 *
	 * @return false|array
	 */
	private function get_data_plugin( $slug ) {
		if ( empty( $slug ) ) {//Make sure $slug not empty.
			return false;
		}

		$plugins = $this->get_data_plugins();

		foreach ( $plugins as $index => $plugin ) {
			$slug_plugin = isset( $plugin->slug ) ? $plugin->slug : false;

			if ( $slug_plugin === $slug ) {
				$data = (array) $plugin;

				$data = wp_parse_args( $data, array(
					'homepage'          => '',
					'author'            => '',
					'download_link'     => false,
					'version'           => false,
					'short_description' => '',
					'banners'           => '',
					'tested'            => false,
				) );

				return $data;

			}
		}

		return false;
	}

	/**
	 * Get data plugins.
	 *
	 * @since 1.1.0
	 *
	 * @return array
	 */
	private function get_data_plugins() {
 		$force = isset( $_GET['force-check'] );
 		// add option thim_fix_check_update_plugin in another theme
   		$fix_check_update_plugin = true;
  		if ( self::$data_plugins == null ) {
 			$data = get_site_transient( self::$key_cached_information_plugins );
 			if ( $fix_check_update_plugin  || $force || empty( $data ) || ! is_array( $data ) ) {
				$information = $this->get_data_plugins_remote();
 				if ( is_wp_error( $information ) ) {
					self::$data_plugins = array();
				} else {
					self::$data_plugins = $information;
 					set_site_transient( self::$key_cached_information_plugins, $information, 12 * HOUR_IN_SECONDS );
   				}
			} else {
				self::$data_plugins = $data;
			}
		}

		return self::$data_plugins;
	}

	/**
	 * Get data plugins remote.
	 *
	 * @since 1.1.0
	 *
	 * @return array|WP_Error
	 */
	private function get_data_plugins_remote() {
		if ( ! $this->url_api ) {
			return new WP_Error( self::$tag, __( 'url_api is invalid', 'thim-core' ) );
		}

		$plugins = Thim_Plugins_Manager::get_external_plugins();

		$arr_slugs = array();
		foreach ( $plugins as $plugin ) {
			$arr_slugs[] = $plugin->get_slug();
		}

		$response = Thim_Remote_Helper::post(
			$this->url_api,
			array(
				'body' => array(
					'plugins' => $arr_slugs,
					'action'  => 'plugin_information',
				),
			),
			true
		);

		if ( is_wp_error( $response ) ) {
			return new WP_Error( self::$tag, $response->get_error_message() );
		}

		if ( ! is_array( $response ) ) {
			return array();
		}

		return $response;
	}
}
