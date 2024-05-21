<?php

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class Thim_Plugin.
 *
 * @since   0.4.0
 *
 * @version 1.1.3
 */
if ( ! class_exists( 'Thim_Plugin' ) ) {
	class Thim_Plugin {
		/**
		 * @var array
		 */
		private static $update_plugins = null;

		/**
		 * @var string
		 */
		private $slug = '';

		/**
		 * @var string
		 */
		private $plugin = '';

		/**
		 * @var null
		 */
		private $info = null;

		/**
		 * @var null
		 *
		 * @since 1.0.0
		 */
		private $data = null;

		/**
		 * @var array
		 */
		private $args = array();

		/**
		 * @var bool
		 */
		public $is_wporg = false;

		/**
		 * @var array
		 */
		private $messages = array();
		/**
		 * @var WP_Filesystem_Base
		 */
		public $wp_filesystem;
		/**
		 * @var string[][] Addon dependencies.
		 */
		private $addon_dependency = [
			'learnpress-wpml/learnpress-wpml.php'       => [
				'learnpress/learnpress.php'                => 'LearnPress',
				'sitepress-multilingual-cms/sitepress.php' => 'WPML',
			],
			'learnpress-woo-payment/learnpress-woo-payment.php' => [
				'learnpress/learnpress.php'   => 'LearnPress',
				'woocommerce/woocommerce.php' => 'Woocommerce',
			],
			'learnpress-h5p/learnpress-h5p.php'         => [
				'learnpress/learnpress.php' => 'LearnPress',
				'h5p/h5p.php'               => 'H5P',
			],
			'learnpress-bbpress/learnpress-bbpress.php' => [
				'learnpress/learnpress.php' => 'LearnPress',
				'bbpress/bbpress.php'       => 'bbpress',
			],
			'learnpress-buddypress/learnpress-buddypress.php' => [
				'learnpress/learnpress.php' => 'LearnPress',
				'buddypress/bp-loader.php'  => 'buddypress',
			],
			'learnpress-paid-membership-pro/learnpress-paid-memberships-pro.php' => [
				'learnpress/learnpress.php' => 'LearnPress',
				'paid-memberships-pro/paid-memberships-pro.php' => 'Paid Memberships Pro',
			],
		];

		/**
		 * Thim_Plugin constructor.
		 *
		 * @param string $slug
		 * @param        $is_wporg
		 *
		 * @since 0.4.0ß
		 *
		 */
		public function __construct( $slug = '', $is_wporg = false ) {
			global $wp_filesystem;
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
			$this->wp_filesystem = $wp_filesystem;

			$this->slug = strtolower( $slug );

			if ( ! empty( $this->slug ) ) {
				$this->set_plugin_file();
			}

			$this->is_wporg = $is_wporg;
		}

		/**
		 * Get plugin updates.
		 *
		 * @return array|null
		 * @since 1.0.0
		 *
		 */
		public static function get_plugin_updates() {
			if ( self::$update_plugins == null ) {
				$external_plugins = get_transient( 'thim_core_update_plugins' );

				if ( ! is_array( $external_plugins ) ) {
					$external_plugins = array();
				}

				include_once ABSPATH . 'wp-admin/includes/update.php';
				$internal_plugins = get_plugin_updates();

				$arr = array();
				foreach ( $internal_plugins as $key => $internal_plugin ) {
					if ( isset( $internal_plugin->update ) ) {
						$arr[ $key ] = $internal_plugin->update;
					}
				}

				self::$update_plugins = array_merge( $external_plugins, $arr );
			}

			return self::$update_plugins;
		}

		/**
		 * Set plugin file.
		 *
		 * @return bool
		 * @since 0.4.0
		 *
		 */
		public function set_plugin_file() {
			$plugins_installed = get_plugins();

			if ( ! count( $plugins_installed ) ) {
				return false;
			}

			foreach ( $plugins_installed as $key => $value ) {
				if ( strpos( $key, $this->slug . '/' ) === 0 ) {

					$this->plugin = $key;

					return $key;
				}
			}

			return false;
		}

		/**
		 * Set args.
		 *
		 * @param array $args
		 *
		 * @since 0.4.0
		 *
		 */
		public function set_args( array $args ) {
			$default    = array(
				'name'               => '',
				'slug'               => '',
				'disable_deactivate' => false,
			);
			$this->args = wp_parse_args( $args, $default );

			$source = isset( $args['source'] ) ? $args['source'] : false;

			if ( ! $source || $source === 'repo' ) {
				$this->is_wporg = true;
			}

			if ( isset( $args['premium'] ) && $args['premium'] ) {
				$this->is_wporg = false;
			}

			$this->slug = $this->args['slug'];
			$this->set_plugin_file();
		}

		/**
		 * Get disable deactivate plugin.
		 *
		 * @return bool
		 * @since 1.8.0
		 *
		 */
		public function disable_deactivate() {
			$args = $this->args;

			return isset( $args['disable_deactivate'] ) && $args['disable_deactivate'];
		}

		/**
		 * Install plugin.
		 *
		 * @return bool
		 * @since 0.4.0
		 *
		 */
		public function install() {
			$status = $this->get_status();

			if ( $status !== 'not_installed' ) {
				return false;
			}

			if ( $this->is_wporg ) {
				return $this->install_form_wporg();
			}

			return $this->install_by_local_file();
		}

		/**
		 * Check can update?
		 *
		 * @return bool
		 * @since 1.0.0
		 *
		 */
		public function can_update() {
			$plugin_updates = self::get_plugin_updates();

			foreach ( $plugin_updates as $key => $plugin_update ) {
				$plugin_file = $this->get_plugin_file();
				$new_version = isset( $plugin_update->new_version ) ? $plugin_update->new_version : false;

				if ( $key === $plugin_file ) {
					return version_compare( $new_version, $this->get_current_version(), '>' );
				}
			}

			return false;
		}

		/**
		 * Get messages.
		 *
		 * @return array
		 * @since 0.8.4
		 *
		 */
		public function get_messages() {
			return $this->messages;
		}

		/**
		 * Get plugin file. Ex: thim-core/thim-core.php
		 *
		 * @return string
		 * @since 0.4.0
		 *
		 */
		public function get_plugin_file() {
			return $this->plugin;
		}

		/**
		 * Get is active.
		 *
		 * @return bool
		 * @since 0.4.0
		 *
		 */
		public function is_active() {
			return is_plugin_active( $this->plugin );
		}

		/**
		 * Get is active network.
		 *
		 * @return bool
		 * @since 0.8.0
		 *
		 */
		public function is_active_network() {
			return is_plugin_active_for_network( $this->plugin );
		}

		/**
		 * Get slug plugin.
		 *
		 * @return string
		 * @since 0.4.0
		 *
		 */
		public function get_slug() {
			return $this->slug;
		}

		/**
		 * Get name plugin.
		 *
		 * @return bool|mixed
		 * @since 0.5.0
		 *
		 */
		public function get_name() {
			$args = $this->args;
			$name = ! empty( $args['name'] ) ? $args['name'] : false;

			return $name;
		}

		/**
		 * Get url plugin.
		 *
		 * @return bool|string
		 * @since 1.0.0
		 *
		 */
		public function get_url() {
			$args = $this->args;
			$url  = ! empty( $args['url'] ) ? $args['url'] : false;

			if ( $url ) {
				return $url;
			}

			$info = $this->get_info();

			return ! empty( $info['PluginURI'] ) ? $info['PluginURI'] : false;
		}

		/**
		 * Get source plugin (path zip file).
		 *
		 * @return bool|string
		 * @since 1.0.0
		 *
		 */
		public function get_source() {
			$args = $this->args;

			$source = ! empty( $args['source'] ) ? $args['source'] : false;

			return apply_filters( 'thim_core_url_download_private_plugin', $source, $this );
		}

		/**
		 * Get description plugin.
		 *
		 * @return bool|mixed
		 * @since 1.0.0
		 *
		 */
		public function get_description() {
			$info = $this->get_info();

			$description = ! empty( $info['Description'] ) ? $info['Description'] : false;
			if ( $description ) {
				return $description;
			}

			$arg         = $this->args;
			$description = ! empty( $arg['description'] ) ? $arg['description'] : false;
			if ( $description ) {
				return $description;
			}

			return false;
		}

		/**
		 * Get require version.
		 *
		 * @return bool|string
		 * @since 1.0.0
		 *
		 */
		public function get_require_version() {
			$args = $this->args;

			return ! empty( $args['version'] ) ? $args['version'] : false;
		}

		/**
		 * Get current version.
		 *
		 * @return bool|string
		 * @since 1.0.0
		 *
		 */
		public function get_current_version() {
			$info = $this->get_info();

			return ! empty( $info['Version'] ) ? $info['Version'] : false;
		}

		/**
		 * Is require plugin.
		 *
		 * @return bool
		 * @since 0.8.7
		 *
		 */
		public function is_required() {
			$args        = $this->args;
			$is_required = ! empty( $args['required'] ) ? $args['required'] : false;

			return $is_required;
		}

		/**
		 * Get plugin status
		 *
		 * @return string
		 * @since 0.4.0
		 *
		 */
		public function get_status() {
			if ( empty( $this->plugin ) ) {
				return 'not_installed';
			}

			$file_plugin = WP_PLUGIN_DIR . '/' . $this->plugin;

			if ( ! file_exists( $file_plugin ) ) {
				return 'not_installed';
			}

			$is_active = $this->is_active();
			if ( ! $is_active ) {
				return 'inactive';
			}

			return 'active';
		}

		/**
		 * Get text status.
		 *
		 * @return mixed|string
		 * @since 0.8.5
		 *
		 */
		public function get_text_status() {
			$arrText = array(
				'active'        => __( 'Active', 'thim-core' ),
				'inactive'      => __( 'Inactive', 'thim-core' ),
				'not_installed' => __( 'Not Installed', 'thim-core' ),
			);

			$status = $this->get_status();

			if ( isset( $arrText[ $status ] ) ) {
				return $arrText[ $status ];
			}

			return '';
		}

		/**
		 * Get url icon plugin.
		 *
		 * @return bool|string
		 * @since 0.5.0
		 *
		 */
		public function get_icon() {
			$args = $this->args;
			$icon = ! empty( $args['icon'] ) ? $args['icon'] : false;

			return $icon;
		}

		/**
		 * Get array args.
		 *
		 * @return array
		 * @since 0.5.0
		 *
		 */
		public function to_array() {
			return array(
				'slug'   => $this->get_slug(),
				'name'   => $this->get_name(),
				'status' => $this->get_status(),
			);
		}

		/**
		 * Activate plugin.
		 *
		 * @param bool $silent
		 * @param bool $network_wide
		 * @param string $plugin_file_relative
		 *
		 * @return WP_Error|bool
		 * @since 0.4.0
		 *
		 */
		public function activate( $silent = null, $network_wide = false, $plugin_file_relative = '' ) {
			$status = $this->get_status();

			if ( $status == 'not_installed' ) {
				return false;
			}

			$is_active_network = $this->is_active_network();
			if ( $is_active_network ) {
				return false;
			}

			if ( ! $network_wide && $status == 'active' ) {
				return false;
			}

			if ( $silent === null && isset( $this->args['silent'] ) ) {
				$silent = $this->args['silent'];
			}

			$plugin = $this->plugin;

			if ( ! empty( $plugin_file_relative ) ) {
				$plugin = $plugin_file_relative;
			}

			if ( isset( $this->addon_dependency[ $plugin ] ) ) {
				foreach ( $this->addon_dependency[ $plugin ] as $addon_slug => $addon_label ) {
					if ( ! is_plugin_active( $addon_slug ) ) {
						return new WP_Error(
							'thim_core_plugin_activate',
							sprintf( 'Please activate "%s" before activate this plugin', $addon_label )
						);
					}
				}
			}

			$result = activate_plugin( $plugin, '', $network_wide, $silent );
			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$recent = (array) get_option( 'recently_activated' );
			unset( $recent[ $plugin ] );
			update_option( 'recently_activated', $recent );

			do_action( 'thim_core_activate_plugin', $plugin, $network_wide, $silent );

			return true;
		}

		/**
		 * Deactivate plugin.
		 *
		 * @return bool
		 * @since 0.4.0
		 *
		 */
		public function deactivate() {
			$plugin = $this->plugin;
			deactivate_plugins( $plugin );

			$data = array(
				$plugin => time(),
			);
			$old  = (array) get_option( 'recently_activated' );

			update_option( 'recently_activated', $data + $old );

			return true;
		}

		/**
		 * Get plugin is form wporg.
		 *
		 * @return bool
		 * @since 0.4.0
		 *
		 */
		public function is_wporg() {
			return $this->is_wporg;
		}

		/**
		 * Is add-on plugin.
		 *
		 * @since 0.8.6
		 */
		public function is_add_on() {
			$args      = $this->args;
			$is_add_on = ! empty( $args['add-on'] ) ? $args['add-on'] : false;

			return $is_add_on;
		}

		/**
		 * No install plugin in step setup demo.
		 *
		 * @since 0.8.6
		 */
		public function no_install_default() {
			$args       = $this->args;
			$no_install = ! empty( $args['no-install'] ) ? $args['no-install'] : false;

			return $no_install;
		}

		/**
		 * Get info plugin.
		 *
		 * @return array|bool
		 * @since 0.4.0
		 *
		 */
		public function get_info() {
			if ( $this->data !== null ) {
				return $this->data;
			}

			if ( empty( $this->plugin ) ) {
				return false;
			}

			$plugin_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $this->plugin;

			if ( ! file_exists( $plugin_file ) ) {
				return false;
			}

			$this->data = get_plugin_data( $plugin_file );

			return $this->data;
		}

		/**
		 * Install plugin from wp.org
		 *
		 * @return bool
		 * @since 0.4.0
		 *
		 */
		public function install_form_wporg() {
			$info = $this->get_info_wporg();

			if ( ! $info ) {
				return false;
			}

			$download_link = $info['download_link'];

			$install = $this->wp_install( $download_link );

			return $install;
		}

		/**
		 * Install plugin by zip file.
		 *
		 * @param $file_path
		 *
		 * @return bool|WP_Error
		 * @since 0.4.0
		 * @version 0.4.1
		 * @editor Tungnx.
		 */
		public function install_by_local_file() {
			$file_path = $this->download_from_thimpress();
			if ( is_wp_error( $file_path ) ) {
				return $file_path;
			}

			return $this->wp_install( $file_path );
		}

		/**
		 * Get info plugin from wporg.
		 *
		 * @return array|bool
		 * @since 0.4.0
		 *
		 */
		public function get_info_wporg() {
			if ( ! $this->is_wporg() ) {
				return false;
			}

			if ( $this->info ) {
				return $this->info;
			}

			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

			$api = plugins_api(
				'plugin_information',
				array(
					'slug' => $this->slug,
				)
			);

			if ( is_wp_error( $api ) ) {
				return false;
			}

			$this->info = (array) $api;

			return $this->get_info_wporg();
		}

		/**
		 * Install plugin by uri or local path.
		 *
		 * @param $package
		 *
		 * @return bool|WP_Error
		 * @since 0.8.4
		 *
		 */
		public function wp_install( $package ) {
			do_action( 'thim_core_pre_install_plugin', $package, $this );

			include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

			$skin            = new WP_Ajax_Upgrader_Skin();
			$plugin_upgrader = new Plugin_Upgrader( $skin );
			$result          = $plugin_upgrader->install( $package );
			$messages        = $skin->get_upgrade_messages();

			$this->messages = $messages;

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			return true;
		}

		/**
		 * Update plugin.
		 *
		 * @return bool|WP_Error
		 * @since 0.8.4
		 *
		 */
		public function update() {
			try {
				include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$plugin   = $this->get_plugin_file();

				if ( ! $this->is_wporg ) {
					$plugin = $this->download_from_thimpress();
					if ( is_wp_error( $plugin ) ) {
						throw new Exception( $plugin->get_error_message() );
					}

					$args_upgrade = [
						'package'                     => $plugin,
						'destination'                 => WP_PLUGIN_DIR,
						'clear_destination'           => false,
						'clear_working'               => true,
						'hook_extra'                  => [],
						'abort_if_destination_exists' => false,
					];
					$result       = $upgrader->run( $args_upgrade );
					$this->wp_filesystem->delete( $plugin );
					if ( ! $result ) {
						throw new Exception( 'Update failed!' );
					}

					$this->messages = $skin->get_upgrade_messages();
					if ( is_wp_error( $result ) ) {
						throw new Exception( $plugin->get_error_message() );
					}
				} else {
					$result = $upgrader->bulk_upgrade( array( $plugin ) );
				}

				wp_update_plugins();

				if ( is_wp_error( $result ) ) {
					throw new Exception( $plugin->get_error_message() );
				}

				return true;
			} catch ( Throwable $e ) {
				return new WP_Error( 'thim_core_update_plugin', $e->getMessage() );
			}
		}

		/**
		 * Download addon from Thimpress.
		 *
		 * return string|WP_Error
		 */
		public function download_from_thimpress() {
			$result = wp_remote_get( $this->get_source() );
			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$data = wp_remote_retrieve_body( $result );
//			if ( preg_match( '/^Error.*/', $data ) ) {
//				return new WP_Error( 'thim_err_download_plugin', $data );
//			}
			// New add
			$data_json = json_decode( $data, true );

			if ( ! empty( $data_json['message'] ) ) {
				return new WP_Error( 'thim_err_download_plugin', ! empty( $data_json['message'] ) ? $data_json['message'] : __( 'Error download plugin', 'arrowpress-core' ) );
			}

			// Create file temp zip addon to install with
			$wp_upload_dir = wp_upload_dir( null, false );
			$name          = 'addon.zip';
			$path_file     = $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . $name;
			$this->wp_filesystem->put_contents( $path_file, $data );

			return $path_file;
		}
	}
}
