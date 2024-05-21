<?php

/**
 * Class Thim_Plugins_Manager.
 *
 * @since 0.5.0
 */
class Thim_Plugins_Manager extends Thim_Admin_Sub_Page {
	/**
	 * @since 1.1.0
	 *
	 * @var null
	 */
	private static $plugins = null;

	/**
	 * @since 0.8.5
	 *
	 * @var string
	 */
	public $key_page = 'plugins';

	/**
	 * @var string
	 *
	 * @since 0.4.0
	 */
	public static $page_key = 'plugins';

	/**
	 * @var null
	 *
	 * @since 0.5.0
	 */
	private static $all_plugins_require = null;

	/**
	 * Is writable.
	 *
	 * @since 0.5.0
	 *
	 * @var bool
	 */
	private static $is_writable = null;

	/**
	 * Add notice.
	 *
	 * @param string $content
	 * @param string $type
	 *
	 * @since 0.5.0
	 *
	 */
	public static function add_notification( $content = '', $type = 'success' ) {
		Thim_Dashboard::add_notification(
			array(
				'content' => $content,
				'type'    => $type,
				'page'    => self::$page_key,
			)
		);
	}

	/**
	 * Get url plugin actions.
	 *
	 * @param $args
	 *
	 * @return string
	 * @since 0.8.8
	 *
	 */
	public static function get_url_plugin_actions( $args ) {
		$args = wp_parse_args(
			$args,
			array(
				'slug'          => '',
				'plugin-action' => '',
				'network'       => '',
			)
		);

		$args['action'] = 'thim_plugins';

		$url = admin_url( 'admin.php' );
		$url = add_query_arg( $args, $url );

		return $url;
	}

	/**
	 * Get link delete plugin.
	 *
	 * @param $plugin_file
	 *
	 * @return string
	 * @since 1.0.3
	 *
	 */
	public static function get_url_delete_plugin( $plugin_file ) {
		$url = wp_nonce_url( 'plugins.php?action=delete-selected&checked[]=' . $plugin_file . '&plugin_status=all', 'bulk-plugins' );

		return network_admin_url( $url );
	}

	/**
	 * Thim_Plugins_Manager constructor.
	 *
	 * @since 0.4.0
	 */
	protected function __construct() {
		parent::__construct();

		$this->init_hooks();
	}

	/**
	 * Get link download plugin by slug.
	 *
	 * @param $slug
	 *
	 * @return bool|string
	 * @since 1.4.1
	 *
	 */
	public static function get_link_download_plugin( $slug ) {
		$url = '';
		//		if ( ! Thim_Product_Registration::is_active() && ! Thim_Free_Theme::is_free() ) {
		//			$envato_id = Thim_Theme_Manager::get_data( 'envato_item_id', false );
		//			if ( $envato_id ) {
		//				return false;
		//			}
		//		}
		$purchase_token = Thim_Product_Registration::get_data_theme_register('purchase_token');
		$site_key       = Thim_Product_Registration::get_site_key();
		if ( $site_key ) {
			$code = thim_core_generate_code_by_site_key( $site_key );
			$url  = sprintf(
				'%s/download-plugin/?plugin=%s&code=%s',
				Thim_Admin_Config::get( 'host_downloads' ),
				$slug,
				$code
			);
		}
		if ( $purchase_token ) {
			$url = Thim_Admin_Config::get( 'host_downloads_api' ) . '/wp-json/thim-market/v1/download-plugin/';
			$url = add_query_arg(
				array(
					'plugin'    => $slug,
					'site_code' => $purchase_token,
				),
				$url
			);
		}


		if ( ! empty( Thim_Free_Theme::get_theme_id() ) ) {
			$url .= sprintf( '&mythemeid=%d', Thim_Free_Theme::get_theme_id() );
		}

		return apply_filters( 'thim_core_get_link_download_plugin', $url );
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.4.0
	 */
	private function init_hooks() {
		add_action( 'wp_ajax_thim_plugins_manager', array( $this, 'handle_ajax_plugin_request_actions' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
		add_action( 'admin_action_thim_plugins', array( $this, 'handle_plugin_actions' ) );
		add_action( 'thim_core_dashboard_init', array( $this, 'notification' ) );
		add_filter( 'thim_core_url_download_private_plugin', array( $this, 'filter_link_download_plugin' ), 10, 2 );
		add_action( 'thim_core_pre_install_plugin', array( $this, 'raise_limit_plugin_installation' ) );
		add_action( 'thim_core_pre_upgrade_plugin', array( $this, 'raise_limit_plugin_installation' ) );
	}

	/**
	 * Raise limit for plugin installation (install/upgrade)
	 *
	 * @since 1.4.8
	 */
	public function raise_limit_plugin_installation() {
		thim_core_set_time_limit();
		wp_raise_memory_limit( 'thim_core_admin' );
	}

	/**
	 * Get link download plugin.
	 *
	 * @param             $source
	 * @param Thim_Plugin $plugin
	 *
	 * @return string
	 * @since 1.4.1
	 *
	 */
	public function filter_link_download_plugin( $source, $plugin ) {
		//        if ( ! Thim_Product_Registration::is_active() && ! Thim_Free_Theme::is_free() ) {
		//            $envato_id = Thim_Theme_Manager::get_data( 'envato_item_id', false );
		//            if ( $envato_id ) {
		//                return $source;
		//            }
		//        }

		return self::get_link_download_plugin( $plugin->get_slug() );
	}

	/**
	 * Handle plugin actions like install, activate, deactivate.
	 *
	 * @since 0.8.8
	 */
	public function handle_plugin_actions() {
		$action   = isset( $_GET['plugin-action'] ) ? $_GET['plugin-action'] : false;
		$slug     = isset( $_GET['slug'] ) ? $_GET['slug'] : false;
		$network  = ! empty( $_GET['network'] ) ? true : false;
		$is_wporg = ! empty( $_GET['wporg'] ) ? true : false;

		if ( ! $action || ! $slug ) {
			return;
		}

		$plugin = new Thim_Plugin( $slug, $is_wporg );

		if ( $action == 'install' ) {
			$plugin->install();

			// Activate after install.
			$link_activate = self::get_url_plugin_actions(
				array(
					'slug'          => $slug,
					'plugin-action' => 'activate',
					'network'       => $network,
				)
			);

			thim_core_redirect( $link_activate );
		}

		if ( $action == 'activate' ) {
			$plugin->activate( false, $network );
		}

		if ( $action == 'deactivate' ) {
			$plugin->deactivate();
		}

		thim_core_redirect( admin_url( 'plugins.php' ) );
	}

	/**
	 * Add sub page.
	 *
	 * @param $sub_pages
	 *
	 * @return mixed
	 * @since 0.8.5
	 *
	 */
	public function add_sub_page( $sub_pages ) {
		$sub_pages['plugins'] = array(
			'title' => __( 'Plugins', 'thim-core' ),
			'icon' => '<svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M22.4141 13.2324H24.7676C25.1721 13.2324 25.5 12.9045 25.5 12.5V5.43945C25.5 5.03496 25.1721 4.70703 24.7676 4.70703H18.4395V3.08594C18.4395 1.38433 17.0551 0 15.3535 0C13.652 0 12.2676 1.38438 12.2676 3.08594V4.70703H5.93945C5.53496 4.70703 5.20703 5.03496 5.20703 5.43945V11.7676H3.58594C1.88438 11.7676 0.5 13.152 0.5 14.8535C0.5 16.5551 1.88438 17.9395 3.58594 17.9395H5.20703V24.2676C5.20703 24.6721 5.53496 25 5.93945 25H13C13.4045 25 13.7324 24.6721 13.7324 24.2676V21.9141C13.7324 21.0202 14.4597 20.293 15.3535 20.293C16.2474 20.293 16.9746 21.0202 16.9746 21.9141V24.2676C16.9746 24.6721 17.3025 25 17.707 25H24.7676C25.1721 25 25.5 24.6721 25.5 24.2676V17.207C25.5 16.8025 25.1721 16.4746 24.7676 16.4746H22.4141C21.5202 16.4746 20.793 15.7474 20.793 14.8535C20.793 13.9597 21.5202 13.2324 22.4141 13.2324ZM22.4141 17.9395H24.0352V23.5352H18.4395V21.9141C18.4395 20.2125 17.0551 18.8281 15.3535 18.8281C13.652 18.8281 12.2676 20.2125 12.2676 21.9141V23.5352H6.67188V17.207C6.67188 16.8025 6.34395 16.4746 5.93945 16.4746H3.58594C2.69204 16.4746 1.96484 15.7474 1.96484 14.8535C1.96484 13.9597 2.69209 13.2324 3.58594 13.2324H5.93945C6.34395 13.2324 6.67188 12.9045 6.67188 12.5V6.17188H13C13.4045 6.17188 13.7324 5.84395 13.7324 5.43945V3.08594C13.7324 2.19204 14.4597 1.46484 15.3535 1.46484C16.2474 1.46484 16.9746 2.19209 16.9746 3.08594V5.43945C16.9746 5.84395 17.3025 6.17188 17.707 6.17188H24.0352V11.7676H22.4141C20.7125 11.7676 19.3281 13.152 19.3281 14.8535C19.3281 16.5551 20.7125 17.9395 22.4141 17.9395Z" fill="#444444"/>
						</svg>',
		);

		return $sub_pages;
	}

	/**
	 * Handle ajax plugin request action.
	 *
	 * @since 0.4.0
	 */
	public function handle_ajax_plugin_request_actions() {
		$slug   = $_POST['slug'] ?? false;
		$action = $_POST['plugin_action'] ?? false;

		$plugins = self::get_plugins();
		foreach ( $plugins as $plugin ) {
			if ( $plugin->get_slug() == $slug ) {
				$result = false;

				$next_action = 'activate';

				switch ( $action ) {
					case 'install':
						$result = $plugin->install();
						break;
					case 'activate':
						$result      = $plugin->activate( false );
						$next_action = 'deactivate';
						break;
					case 'deactivate':
						$result = $plugin->deactivate();
						break;
					case 'update':
						$result    = $plugin->update();
						$is_active = $plugin->is_active();
						if ( $is_active ) {
							$next_action = 'deactivate';
						}
						break;
				}

				if ( is_wp_error( $result ) ) {
					wp_send_json_error( [ 'messages' => [ $result->get_error_message() ] ] );
				} elseif ( ! $result ) {
					wp_send_json_error( [ 'messages' => [ 'Install failed!' ] ] );
				}

				wp_send_json_success(
					array(
						'messages' => $plugin->get_messages(),
						'action'   => $next_action,
						'text'     => ucfirst( $next_action ),
						'slug'     => $plugin->get_slug(),
						'version'  => $plugin->get_current_version(),
						'info'     => $plugin->get_info(),
						'status'   => $plugin->get_status(),
					)
				);
			}
		}

		wp_send_json_error();
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.4.0
	 *
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'thim-plugins', THIM_CORE_ADMIN_URI . '/assets/js/plugins/thim-plugins.js', array( 'jquery' ), THIM_CORE_VERSION );
		$this->localize_script();

		if ( ! $this->is_myself() ) {
			return;
		}

 		$ver = THIM_CORE_VERSION;
		if ( TP::is_debug() ) {
 			$ver = uniqid();
		}

		wp_enqueue_script( 'thim-isotope', THIM_CORE_ADMIN_URI . '/assets/js/plugins/isotope.pkgd.min.js', array( 'jquery' ), THIM_CORE_VERSION );
		wp_enqueue_script(
			'thim-plugins-manager',
			THIM_CORE_ADMIN_URI . '/assets/js/plugins/plugins-manager.min.js',
			array(
				'thim-plugins',
				'thim-isotope',
				'updates',
				'thim-core-admin',
			),
			$ver
		);
	}

	/**
	 * Localize script.
	 *
	 * @since 0.4.0
	 */
	public function localize_script() {
		wp_localize_script(
			'updates',
			'_wpUpdatesItemCounts',
			array(
				'totals' => wp_get_update_data(),
			)
		);

		wp_localize_script(
			'thim-plugins',
			'thim_plugins_manager',
			array(
				'admin_ajax_action' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Get all plugins require.
	 *
	 * @return Thim_Plugin[]
	 * @since 1.1.0
	 *
	 */
	public static function get_plugins() {
		if ( self::$plugins == null ) {
			$all_plugins = self::get_all_plugins();

			$plugins = array();
			foreach ( $all_plugins as $index => $plugin ) {
				$thim_plugin = new Thim_Plugin();
				$thim_plugin->set_args( $plugin );

				$plugins[] = $thim_plugin;
			}

			self::$plugins = $plugins;
		}

		return self::$plugins;
	}

	/**
	 * Get all plugins.
	 *
	 * @return array
	 * @since 0.4.0
	 *
	 */
	private static function get_all_plugins() {
		if ( self::$all_plugins_require == null ) {
			$plugins = array();

			$plugins = apply_filters( 'thim_core_get_all_plugins_require', $plugins );

			foreach ( $plugins as $index => $plugin ) {
				$plugin = wp_parse_args(
					$plugin,
					array(
						'required' => false,
						'add-on'   => false,
						'silent'   => false,
					)
				);

				$plugins[ $index ] = $plugin;
			}

			uasort(
				$plugins,
				function ( $first, $second ) {
					if ( $first['required'] === $second['required'] ) {
						return 0;
					}

					if ( $first['required'] ) {
						return - 1;
					}

					return 1;
				}
			);

			self::$all_plugins_require = apply_filters( 'thim_core_list_plugins_required', $plugins );
		}

		return self::$all_plugins_require;
	}

	/**
	 * Get external plugins (outside wp.org).
	 *
	 * @return Thim_Plugin[]
	 * @since 1.1.0
	 *
	 */
	public static function get_external_plugins() {
		$required_plugins = self::get_plugins();

		$plugins = array();
		foreach ( $required_plugins as $thim_plugin ) {
			if ( $thim_plugin->is_wporg() ) {
				continue;
			}

			$plugins[] = $thim_plugin;
		}

		return $plugins;
	}

	/**
	 * Get required plugins inactive or not installed.
	 *
	 * @return Thim_Plugin[]
	 * @since 0.8.7
	 *
	 */
	public static function get_required_plugins_inactive() {
		$required_plugins = self::get_plugins();

		$plugins = array();

		foreach ( $required_plugins as $thim_plugin ) {
 			$install_pl = false;
 			$no_install = array( 'leadin', 'learnpress-assignments', 'learnpress-announcements', 'js_composer', 'siteorigin-panels', 'elementor', 'bbpress', 'buddypress', 'widget-logic', 'classic-editor' );
			if ( ($thim_plugin->is_required() == false && in_array( $thim_plugin->get_slug(), $no_install )) ||   $thim_plugin->no_install_default() ) {
				$install_pl = true;
			}
			if ( $install_pl || $thim_plugin->is_active() || $thim_plugin->is_add_on() ) {
				continue;
			}

			$plugins[] = $thim_plugin;
		}

		return $plugins;
	}

	/**
	 * Get all add ons.
	 *
	 * @return Thim_Plugin[]
	 * @since 0.8.6
	 *
	 */
	public static function get_all_add_ons() {
		$all_plugins = self::get_plugins();

		$plugins = array();
		foreach ( $all_plugins as $plugin ) {
			if ( ! $plugin->is_add_on() ) {
				continue;
			}

			$plugins[] = $plugin;
		}

		return $plugins;
	}

	/**
	 * Get list slug plugins require all demo.
	 *
	 * @return array
	 * @since 0.5.0
	 *
	 */
	public static function get_slug_plugins_require_all() {
		$all_plugins = self::get_plugins();

		$plugins_require_all = array();
		foreach ( $all_plugins as $index => $plugin ) {
			if ( $plugin->is_required() ) {
				array_push( $plugins_require_all, $plugin->get_slug() );
			}
		}

		return $plugins_require_all;
	}

	/**
	 * Get plugin by slug.
	 *
	 * @param $slug
	 *
	 * @return false|Thim_Plugin
	 * @since 0.5.0
	 *
	 */
	public static function get_plugin_by_slug( $slug ) {
		$all_plugins = self::get_plugins();

		if ( count( $all_plugins ) === 0 ) {
			return false;
		}

		foreach ( $all_plugins as $plugin ) {
			if ( $plugin->get_slug() == $slug ) {
				return $plugin;
			}
		}

		return false;
	}

	/**
	 * Check permission plugins directory.
	 *
	 * @since 0.5.0
	 */
	private static function check_permission() {
		self::$is_writable = wp_is_writable( WP_PLUGIN_DIR );
	}

	/**
	 * Get permission writable plugins directory.
	 *
	 * @since 0.8.2
	 */
	public static function get_permission() {
		if ( is_null( self::$is_writable ) ) {
			self::check_permission();
		}

		return self::$is_writable;
	}

	/**
	 * Notice waring.
	 *
	 * @since 0.5.0
	 * @since 1.3.1
	 */
	public function notification() {
		if ( ! self::get_permission() ) {
			Thim_Dashboard::add_notification(
				array(
					'content' => '<strong>Important!</strong> Please check permission directory <code>' . WP_PLUGIN_DIR . '</code>. Please follow <a href="https://goo.gl/guirO5" target="_blank">the guide</a>.',
					'type'    => 'error',
				)
			);
		}
	}
}
