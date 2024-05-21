<?php

/**
 * Class Thim_Theme_Upgrader.
 *
 * @since 0.9.0
 */
class Thim_Auto_Upgrader extends Thim_Singleton {
	/**
	 * Thim_Theme_Upgrader constructor.
	 *
	 * @since 0.9.0
	 */
	protected function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.9.0
	 */
	private function init_hooks() {
		add_filter( 'http_request_args', array( $this, 'exclude_check_update_themes_from_wp_org' ), 100, 2 );
		add_filter( 'http_request_args', array( $this, 'exclude_check_update_plugins_from_wp_org' ), 100, 2 );

		add_filter( 'pre_site_transient_update_themes', array( $this, 'inject_update_themes' ), 100 );
		add_filter( 'upgrader_package_options', array( $this, 'pre_update_theme' ), 100 );

		add_filter( 'pre_site_transient_update_plugins', array( $this, 'inject_update_plugins' ), 100 );
		add_filter( 'upgrader_package_options', array( $this, 'pre_update_plugin' ), 100 );

		add_filter( 'upgrader_pre_download', array( $this, 'pre_filter_download_plugin' ), 100, 3 );

		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'add_check_update_plugins' ) );
		add_action( 'thim_core_check_update_external_plugins', array( $this, 'check_update_external_plugins' ) );
	}

	/**
	 * Check update when core check update.
	 *
	 * @since 1.4.0
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	public function add_check_update_plugins( $value ) {
		do_action( 'thim_core_check_update_external_plugins' );

		return $value;
	}

	/**
	 * Check update external plugins.
	 *
	 * @since 1.4.0
	 */
	public function check_update_external_plugins() {
		$data           = get_transient( 'thim_core_update_plugins' );
		$update_plugins = is_array( $data ) ? $data : array();

		$api_check_update_plugin = Thim_Admin_Config::get( 'api_update_plugins' );
		$plugin_checker          = new Thim_Plugin_Upgrader( $api_check_update_plugin );

		$plugins = Thim_Plugins_Manager::get_external_plugins();
		foreach ( $plugins as $index => $plugin ) {
			$status = $plugin->get_status();
			if ( $status === 'not_installed' ) {
				continue;
			}

			$plugin_file = $plugin->get_plugin_file();

			$update = $plugin_checker->check_can_update( $plugin );
			if ( ! $update ) {
				if ( isset( $update_plugins[ $plugin_file ] ) ) {
					unset( $update_plugins[ $plugin_file ] );
				}
				continue;
			}

			$object              = new stdClass();
			$object->slug        = $plugin->get_slug();
			$object->plugin      = $plugin_file;
			$object->new_version = $update['version'];
			$object->url         = $update['homepage'];
			$object->package     = $update['download_link'];
			$object->tested      = $update['tested'];

			$update_plugins[ $plugin_file ] = $object;
		}

		set_transient( 'thim_core_update_plugins', $update_plugins );
	}

	/**
	 * Filter package plugin.
	 *
	 * @since 1.4.0
	 *
	 * @param $options
	 *
	 * @return mixed
	 */
	public function pre_update_plugin( $options ) {
		// After check user buy theme Academy LMS.. will remove check is_free.
		if ( ! Thim_Product_Registration::is_active() ) {
			return $options;
		}

		$hook_extra = isset( $options['hook_extra'] ) ? $options['hook_extra'] : false;

		if ( ! $hook_extra ) {
			return $options;
		}

		$plugin_file = ! empty( $hook_extra['plugin'] ) ? $hook_extra['plugin'] : false;

		if ( ! $plugin_file ) {
			return $options;
		}

		$plugins = Thim_Plugins_Manager::get_external_plugins();
		foreach ( $plugins as $plugin ) {
			if ( $plugin_file === $plugin->get_plugin_file() ) {
				$options['package'] = Thim_Plugins_Manager::get_link_download_plugin( $plugin->get_slug() );

				return $options;
			}
		}

		return $options;
	}

	/**
	 * Inject filter download plugin.
	 *
	 * @since 1.1.0
	 *
	 * @param $reply
	 * @param $package
	 * @param $updater WP_Upgrader
	 *
	 * @return bool
	 */
	public function pre_filter_download_plugin( $reply, $package, $updater ) {
		if ( is_wp_error( $reply ) && ! empty( $package ) ) {//Override Visual Composer
			return false;
		}

		return $reply;
	}

	/**
	 * Pre update theme, get again link download theme.
	 *
	 * @since 0.8.0
	 *
	 * @param $options
	 *
	 * @return mixed
	 */
	public function pre_update_theme( $options ) {
		$hook_extra = isset( $options['hook_extra'] ) ? $options['hook_extra'] : false;

		if ( ! $hook_extra ) {
			return $options;
		}

		$theme = isset( $hook_extra['theme'] ) ? $hook_extra['theme'] : false;

		if ( ! $theme ) {
			return $options;
		}

		$return = apply_filters( 'thim_core_get_link_download_theme', false, $theme );
		if ( is_string( $return ) ) {
			$options['package'] = $return;

			return $options;
		}

		$themes = Thim_Product_Registration::get_themes();
		foreach ( $themes as $stylesheet => $data ) {
			if ( $theme == $stylesheet ) {
				$url_download = Thim_Product_Registration::get_url_download_theme( $stylesheet );
				if ( ! is_wp_error( $url_download ) ) {
					$options['package'] = $url_download;
				} else {
					if ( $url_download->get_error_code() == 'thim_core_key_broken' ) {
						Thim_Product_Registration::destroy_active();
					}
				}

				return $options;
			}
		}

		return $options;
	}

	/**
	 * Add filter update plugins.
	 *
	 * @since 1.0.0
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	public function inject_update_plugins( $value ) {
		$detect_ajax_update = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
		if ( $detect_ajax_update !== 'thim_plugins_manager' ) {
			return $value;
		}

		$slug = ! empty( $_REQUEST['slug'] ) ? $_REQUEST['slug'] : false;
		if ( ! $slug ) {
			return $value;
		}

		$value    = new stdClass();
		$response = array();

		$all_plugins      = Thim_Plugins_Manager::get_plugins();
		$external_plugins = get_transient( 'thim_core_update_plugins' );
		foreach ( $all_plugins as $plugin ) {
			if ( $slug === $plugin->get_slug() ) {
				if ( $plugin->is_wporg() ) {
					return false;
				}

				$plugin_file = $plugin->get_plugin_file();

				if ( isset( $external_plugins[ $plugin_file ] ) ) {
					$response[ $plugin_file ] = $external_plugins[ $plugin_file ];
				} else {
					if ( isset( $response[ $plugin_file ] ) ) {
						unset( $response[ $plugin_file ] );
					}
				}
			}
		}

		if ( ! count( $response ) ) {
			return false;
		}

		$value->response = $response;

		return $value;
	}

	/**
	 * Add filter update theme.
	 *
	 * @since 0.7.0
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	public function inject_update_themes( $value ) {
		$detect_ajax_update = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

		if ( $detect_ajax_update !== 'thim_core_update_theme' ) {
			return $value;
		}

		Thim_Product_Registration::double_check_theme_update();

		$theme_data         = Thim_Theme_Manager::get_metadata();
		$template           = $theme_data['template'];
		$update_themes      = Thim_Product_Registration::get_update_themes();
		$update_free_themes = Thim_Free_Theme::get_update_themes();
		$themes             = $update_themes['themes'];
		$free_themes        = $update_free_themes['themes'];

		$data      = isset( $themes[ $template ] ) ? $themes[ $template ] : false;
		$free_data = isset( $free_themes[ $template ] ) ? $free_themes[ $template ] : false;
		if ( ! $data && ! $free_data ) {
			return $value;
		}

//		$dataUpdate = $data || $free_data;
		$dataUpdate = $data ? $data : $free_data;

		$value    = new stdClass();

		$value->response[ $template ] = array(
			'theme'       => $template,
			'new_version' => $dataUpdate['version'],
			'package'     => isset( $data['package'] ) ? $data['package'] : '',
			'url'         => $dataUpdate['url']
		);

		return $value;
	}

	/**
	 * Exclude check plugins update from wp.org.
	 *
	 * @since 1.1.0
	 *
	 * @param $request
	 * @param $url
	 *
	 * @return mixed
	 */
	public function exclude_check_update_plugins_from_wp_org( $request, $url ) {
		if ( false === strpos( $url, '//api.wordpress.org/plugins/update-check/1.1/' ) ) {
			return $request;
		}

		$data    = json_decode( $request['body']['plugins'] );
		$plugins = $this->get_exclude_plugins_update();
		foreach ( $plugins as $index => $plugin_file ) {
			if ( isset( $data->plugins->$plugin_file ) ) {
				unset( $data->plugins->$plugin_file );
			}
		}

		$request['body']['plugins'] = wp_json_encode( $data );

		return $request;
	}

	/**
	 * Exclude check themes update from wp.org.
	 *
	 * @since 0.9.0
	 *
	 * @param $request
	 * @param $url
	 *
	 * @return mixed
	 */
	public function exclude_check_update_themes_from_wp_org( $request, $url ) {
		if ( false === strpos( $url, '//api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $request;
		}

		$data   = json_decode( $request['body']['themes'] );
		$themes = Thim_Product_Registration::get_themes();
		foreach ( $themes as $slug => $theme ) {
			if ( isset( $data->themes->$slug ) ) {
				unset( $data->themes->$slug );
			}
		}

		$request['body']['themes'] = wp_json_encode( $data );

		return $request;
	}

	/**
	 * Get list exclude check update plugins.
	 *
	 * @since 1.1.0
	 *
	 * @since array
	 */
	private function get_exclude_plugins_update() {
		$plugins = Thim_Plugins_Manager::get_external_plugins();

		$exclude_plugins = array();
		foreach ( $plugins as $index => $plugin ) {
			$plugin_file = $plugin->get_plugin_file();

			$exclude_plugins[] = $plugin_file;
		}

		return apply_filters( 'thim_core_exclude_plugins_check_update', $exclude_plugins );
	}
}
