<?php

/**
 * Class Thim_Importer_AJAX
 *
 * @package   Thim_Core_Admin
 * @since     0.3.1
 * @version   1.10.1
 */
class Thim_Importer_AJAX {
	/**
	 * @var string
	 *
	 * @since 0.6.0
	 */
	private static $key_option_current_demo = 'thim_importer_current_demo';

	/**
	 * Handle ajax uninstall.
	 *
	 * @return bool
	 * @since 0.7.0
	 *
	 */
	public function handle_ajax_uninstall() {
		Thim_Importer_Service::reset_data_demo();

		return $this->_send_response_success( null );
	}

	/**
	 * Handle post data.
	 *
	 * @return bool
	 * @since   0.3.1
	 * @version 1.10.1
	 */
	public function handle_ajax() {
		$res = new Thim_Import_REST_Response();

		try {
			if ( ! isset( $_POST['packages'] ) || count( $_POST['packages'] ) == 0 ) {
				throw Thim_Error::create( __( 'Invalid packages!', 'thim-core' ), 10 );
			}

			if ( ! isset( $_POST['step'] ) ) {
				throw Thim_Error::create( __( 'Invalid step!', 'thim-core' ), 10 );
			}

			$packages = $_POST['packages'];
			$step     = sanitize_key( $_POST['step'] );

			if ( 'start' == $step ) {
				if ( ! isset( $_POST['demo'] ) ) {
					throw Thim_Error::create( __( 'Invalid demo!', 'thim-core' ), 10 );
				}

				$demo  = sanitize_text_field( $_POST['demo'] );
				$demos = Thim_Importer::get_demo_data( true );

				if ( ! isset( $demos[ $demo ] ) ) {
					throw Thim_Error::create( __( 'Demo not found!', 'thim-core' ) );
				}

				$this->check_retry_import();

				$_initializeImporter = $this->_initializeImporter( $demos[ $demo ], $packages );

				if ( $_initializeImporter ) {
					$res->status  = 'success';
					$res->step    = $packages[0];
					$res->message = esc_html__( 'Prepare Importer success', 'thim-core' );
				}
			} else {
				/**
				 * @var $res_step Thim_Import_REST_Response
				 */
				$res_step = $this->_step_by_step( $step );

				//do_action( 'thim_core_importer_next_step', $done, $next, $ext );

				if ( isset( $res_step->step_finished ) && $res_step->step_finished ) {
					$index_step      = array_search( $step, $packages );
					$index_step_next = ++ $index_step;

					if ( isset( $packages[ $index_step_next ] ) ) {
						$next_step = $packages[ $index_step_next ];

						$res                = $res_step;
						$res->step          = $next_step;
						$res->step_finished = $step;
					} else {
						// Finish Import Demo
						$this->step_finish();
						$res             = $res_step;
						$res->message    = $res_step->message . '| Import all finished';
						$res->percentage = 100;
						$res->finish     = 1;
					}
				} else {
					$res       = $res_step;
					$res->step = $step;
				}
			}

			wp_send_json( $res );
		} catch ( Thim_Error $exception ) {
			$res->message = $exception->getMessage();
			wp_send_json( $res );
		} catch ( Exception $exception ) {
			$res->message = $exception->getMessage();
			wp_send_json( $res );
		}
	}

	/**
	 * Check retry import.
	 *
	 * @since 1.2.0
	 */
	private function check_retry_import() {
		$retry = isset( $_POST['retry'] ) ? $_POST['retry'] : false;

		if ( ! $retry || $retry === 'false' ) {
			return;
		}

		$current_posts_pp       = get_option( 'thim_importer_posts_pp', 100 );
		$current_attachments_pp = get_option( 'thim_importer_attachments_pp', 10 );

		update_option( 'thim_importer_posts_pp', max( intval( $current_posts_pp / 2 ), 10 ) );
		update_option( 'thim_importer_attachments_pp', max( intval( $current_attachments_pp / 2 ), 1 ) );
	}

	/**
	 * Initialize import.
	 *
	 * @param array $demo
	 * @param array $packages
	 *
	 * @return bool
	 * @since 0.3.1
	 *
	 */
	private function _initializeImporter( $demo, $packages = array() ) {
		do_action( 'thim_core_importer_start_import_demo', $demo );

		$packages = (array) $packages;
		$packages = apply_filters( 'thim_core_importer_prepare_packages', $packages );
		$this->_save_current_demo_data( $demo, $packages );
		update_option( 'thim_importer_prepare_wp_import', false );

		return true;
	}

	/**
	 * Prepare demo content.
	 *
	 * @since 0.5.0
	 */
	private function _prepare_demo_content() {
		$dir = $this->_get_dir_current_demo();
		$xml = $dir . '/content.xml';

		Thim_Importer_Service::analyze_content( $xml );
	}

	/**
	 * Store temporarily demo data.
	 *
	 * @param array $demo
	 * @param array $packages
	 *
	 * @return bool
	 * @since 0.3.1
	 *
	 */
	private function _save_current_demo_data( $demo, $packages ) {
		$theme_slug = get_option( 'stylesheet' );

		return update_option(
			self::$key_option_current_demo,
			array(
				'theme'                  => $theme_slug,
				'demo'                   => $demo['key'],
				'revsliders'             => isset( $demo['revsliders'] ) ? $demo['revsliders'] : array(),
				'packages'               => $packages,
				'dir'                    => $demo['dir'],
				'plugins_required'       => isset( $demo['plugins_required'] ) ? $demo['plugins_required'] : false,
				'plugins_required_count' => count( $demo['plugins_required'] ),
				'current_step'           => 0,
			)
		);
	}

	/**
	 * Update current demo data
	 *
	 * @param $args
	 *
	 * @return bool
	 * @since 0.4.0
	 *
	 */
	public static function update_current_demo_data( $args ) {
		return update_option( self::$key_option_current_demo, $args );
	}

	/**
	 * Get option current demo.
	 *
	 * @return array
	 * @since 0.3.1
	 *
	 */
	public static function get_current_demo_data() {
		return get_option( self::$key_option_current_demo );
	}

	/**
	 * Get dir current demo.
	 *
	 * @return string
	 * @since 0.3.1
	 *
	 */
	private function _get_dir_current_demo() {
		$current_demo = self::get_current_demo_data();

		$base_dir = apply_filters( 'thim_core_importer_base_path_demo_data', false, $current_demo );
		if ( ! $base_dir ) {
			return $current_demo['dir'];
		}

		return apply_filters(
			'thim_core_importer_directory_current_demo',
			$base_dir . $current_demo['demo'],
			$current_demo['demo']
		);
	}

	/**
	 * Get current demo data directory.
	 *
	 * @return string
	 * @since 1.7.8
	 *
	 */
	public function get_current_demo_data_directory() {
		return $this->_get_dir_current_demo();
	}

	/**
	 * Get selected packages.
	 *
	 * @return array
	 * @since 0.3.1
	 *
	 */
	private function _get_selected_packages() {
		$current_demo = self::get_current_demo_data();

		return ! empty( $current_demo['packages'] ) ? $current_demo['packages'] : array();
	}

	/**
	 * Get index current step.
	 *
	 * @return int
	 * @since 0.3.1
	 *
	 */
	private function _get_index_current_step() {
		$current_demo = self::get_current_demo_data();

		return ! empty( $current_demo['current_step'] ) ? intval( $current_demo['current_step'] ) : 0;
	}

	/**
	 * Increase index current step
	 *
	 * @since 0.3.1
	 */
	private function _increase_index_current_step() {
		$current_demo                 = self::get_current_demo_data();
		$current_demo['current_step'] = $this->_get_index_current_step() + 1;
		self::update_current_demo_data( $current_demo );
	}

	/**
	 * Get key current step.
	 *
	 * @return bool|mixed
	 * @since 0.3.1
	 *
	 */
	private function _get_key_current_step() {
		$index    = $this->_get_index_current_step();
		$packages = $this->_get_selected_packages();

		if ( $index < count( $packages ) ) {
			return $packages[ $index ];
		}

		return false;
	}

	/**
	 * Next step and get key step.
	 *
	 * @return bool|mixed
	 * @since 0.3.1
	 *
	 */
	private function _get_key_next_step() {
		$this->_increase_index_current_step();
		$index    = $this->_get_index_current_step();
		$packages = $this->_get_selected_packages();

		if ( $index < count( $packages ) ) {
			return $packages[ $index ];
		}

		$this->_finish();

		return false;
	}

	/**
	 * Finish process import.
	 *
	 * @since 0.5.0
	 */
	private function step_finish() {
		/**
		 * Delete post hello world.
		 */
		$delete_hello_post = get_page_by_path( 'hello-world' );
		if ( ! empty( $delete_hello_post->ID ) ) {
			wp_trash_post( $delete_hello_post->ID );
		}
		/**
		 * Remap menu locations.
		 */
		$thim_wp_import = Thim_WP_Import_Service::instance( false );
		$thim_wp_import->set_menu_locations();

		$this->_update_settings();

		/**
		 * Update option demo installed.
		 */
		$demo_data = self::get_current_demo_data();
		$demo_key  = isset( $demo_data['demo'] ) ? $demo_data['demo'] : false;
		if ( ! $demo_data ) {
			return;
		}

		Thim_Importer::update_key_demo_installed( $demo_key );
		$this->import_end();

		// Upload demo_key to server.
		$this->_update_demo_key_to_server( $demo_key );
	}

	private function _update_demo_key_to_server( $demo_key ) {
		try {
			$api_url = Thim_Admin_Config::get( 'api_thim_market' ) . '/update-demo-version/';
			$body_args = array(
				'site_code' => Thim_Product_Registration::get_data_theme_register('purchase_token'),
				'version'  => $demo_key,
			);

			$args = array(
				'body'    => $body_args,
				'timeout' => 30,
			);

			$response = wp_remote_post( $api_url, $args );
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	function import_end() {
		wp_import_cleanup( $this->id ?? '' );

		wp_cache_flush();
		foreach ( get_taxonomies() as $tax ) {
			delete_option( "{$tax}_children" );
			_get_term_hierarchy( $tax );
		}

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

		if ( class_exists( '\Thim_EL_Kit\Modules\Cache' ) ) {
			\Thim_EL_Kit\Modules\Cache::instance()->regenerate();
		}
	}

	/**
	 * Update site settings.
	 *
	 * @since 0.5.0
	 */
	private function _update_settings() {
		$dir           = $this->_get_dir_current_demo();
		$settings_file = $dir . '/settings.dat';

		Thim_Importer_Service::settings( $settings_file );
		// save customizer
		thim_compile_custom_css_theme();
	}

	/**
	 * Call step import.
	 *
	 * @param string $step
	 *
	 * @return mixed
	 * @return Thim_Import_REST_Response
	 * @throws Exception
	 * @since 1.10.1
	 *
	 * @see   step_plugins
	 * @see   step_download_demo_data
	 * @see   step_theme_options
	 * @see   step_main_content
	 * @see   step_media
	 * @see   step_widgets
	 * @see   step_revslider
	 *
	 */
	private function _step_by_step( $step = '' ) {
		do_action( 'thim_core_importer_start_step', $step );

		$callback_function = 'step_' . $step;

		$callable = apply_filters( "thim_core_importer_step_$step", array( $this, $callback_function ) );

		if ( is_callable( $callable ) ) {
			return call_user_func( $callable );
		}

		throw Thim_Error::create( __( 'Not found function' . $callable, 'thim-core' ), 3 );
	}

	/**
	 * Step install and activate plugins.
	 * Need 2 steps download then active plugin, not activate when have just download done
	 *
	 * @return Thim_Import_REST_Response
	 * @throws Exception
	 * @since   0.3.0
	 * @version 1.10.2
	 */
	public function step_plugins() {
		$response        = new Thim_Import_REST_Response();
		$response->extra = new stdClass();

		try {
			$current_demo      = self::get_current_demo_data();
			$plugins_required  = $current_demo['plugins_required'];
			$index_plugin      = 0;
			$count_all_plugins = $current_demo['plugins_required_count'];

			if ( isset( $_POST['extra'] ) && isset( $_POST['extra']['next_plugin'] ) ) {
				$index_plugin = absint( $_POST['extra']['next_plugin'] );
			}

			if ( ! ( $count_all_plugins ) || $index_plugin >= $count_all_plugins ) {
				$response->status        = 'success';
				$response->step_finished = 1;
				$response->percentage    = 100;
				$response->message       = esc_html__( 'Finish step activate plugins', 'thim-core' );

				return $response;
			}

			$percentage      = intval( ( 1 + $index_plugin ) / $count_all_plugins * 100 );
			$plugin_required = $plugins_required[ $index_plugin ];
			$plugin_slug     = $plugin_required['slug'] ?? false;

			if ( ! $plugin_slug ) {
				throw new Exception( 'Plugin slug must not empty!' );
			}

			$plugin = Thim_Plugins_Manager::get_plugin_by_slug( $plugin_slug );

			if ( $plugin ) {
				$response->extra->plugin = $plugin_slug;
				$status                  = $plugin->get_status();

				if ( 'not_installed' === $status ) {
					$install = $plugin->install();

					if ( $install ) {
						$plugin_file = $plugin->set_plugin_file();
						$rs_active   = activate_plugin( $plugin_file, '', false, false );

						if ( $rs_active instanceof WP_Error ) {
 //							throw new Exception( $rs_active->get_error_message() );
							$response->message = __( "Can't install the plugin {$plugin->get_name()}", "thim-core" );
  						}

						$response->status             = 'success';
						$response->percentage         = $percentage;
						$response->extra->next_plugin = ++ $index_plugin;
					} else {
						$messages = $plugin->get_messages();
						$string   = implode( '. ', $messages );
						throw new Exception(
							sprintf(
								__( 'Installing %1$s plugin failed. %2$s', 'thim-core' ),
								$plugin->get_name(),
								$string
							)
						);
					}
				} elseif ( 'inactive' === $status ) {
					$result_active = $plugin->activate( true );

					if ( $result_active ) {
						$response->status             = 'success';
						$response->percentage         = $percentage;
						$response->extra->next_plugin = ++ $index_plugin;
					} else {
						$messages = $plugin->get_messages();
						$string   = implode( '. ', $messages );
						throw new Exception(
							sprintf(
								__( 'Activate %1$s plugin failed. %2$s', 'thim-core' ),
								$plugin->get_name(),
								$string
							)
						);
					}
				} else {
					$response->status             = 'success';
					$response->message            = $status;
					$response->percentage         = $percentage;
					$response->extra->next_plugin = ++ $index_plugin;
				}
			} else {
				throw new Exception( 'Plugin ' . $plugin->get_name() . ' not exists' );
			}
		} catch ( Throwable $e ) {
			$response->message = $e->getMessage();
		}

		if ( 'error' == $response->status && empty( $response->message ) ) {
			$response->message = 'Has error when install plugins required, please contact supporter';
		}

		return $response;
	}

	/**
	 * Step download demo data
	 *
	 * @return Thim_Import_REST_Response
	 * @since   1.10.1
	 * @version 1.10.1
	 */
	public function step_download_demo_data() {
		$response         = new Thim_Import_REST_Response();
		$response->status = 'error';

		try {
			//Download demo data - hook add on plugin 'Eduma Demo Data'
			do_action( 'thim_core_importer_next_step', 'plugins', '', '' );

			$response->step_finished = 1;
			$response->status        = 'success';
			$response->percentage    = 100;
			$response->message       = esc_html__( 'Download demo data successfully', 'thim-core' );
		} catch ( Throwable $exception ) {
			$response->message = $exception->getMessage();
		}

		return $response;
	}

	/**
	 * Step import theme options.
	 *
	 * @since 0.3.1
	 */
	public function step_theme_options() {
		$response         = new Thim_Import_REST_Response();
		$response->status = 'error';

		try {
			$dir          = $this->_get_dir_current_demo();
			$setting_file = $dir . '/theme_options.dat';
			$result       = Thim_Importer_Service::theme_options( $setting_file );

			$response->status        = 'success';
			$response->message       = 'Set theme options success';
			$response->percentage    = 100;
			$response->step_finished = 1;
		} catch ( Thim_Error $exception ) {
			$response->message = $exception->getMessage();
		}

		return $response;
	}

	/**
	 * Step import main content.
	 *
	 * @since 0.3.0
	 */
	public function step_main_content() {
		$response = new Thim_Import_REST_Response();

		try {
			$prepare_wp_import = get_option( 'thim_importer_prepare_wp_import', false );

			if ( ! $prepare_wp_import ) {
				$this->_prepare_demo_content();
				update_option( 'thim_importer_prepare_wp_import', true );

				$response->status  = 'success';
				$response->message = 'Prepare import demo content success';

				return $response;
			}

			$packages         = $this->_get_selected_packages();
			$fetch_attachment = array_search( 'media', $packages ) !== false;
			$thim_wp_import   = Thim_WP_Import_Service::instance();
			$result           = $thim_wp_import->import_posts( $fetch_attachment );

			if ( $result['has_posts'] && ( $result['has_posts'] !== 'attachment' ) ) {
				$response->status     = 'success';
				$response->message    = 'success import ' . $result['current'];
				$response->percentage = $result['percentage'];

				return $response;
			}

			/**
			 * Fix issue while importing missing some menu items
			 */
			$thim_wp_import->backfill_parents();
			$thim_wp_import->backfill_attachment_urls();
			$thim_wp_import->remap_featured_images();

			$response->status        = 'success';
			$response->message       = 'Import content success';
			$response->percentage    = 100;
			$response->step_finished = 1;
		} catch ( Throwable $e ) {
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/**
	 * Step import media file.
	 *
	 * @since 0.3.1
	 */
	public function step_media() {
		$response       = new Thim_Import_REST_Response();
		$thim_wp_import = Thim_WP_Import_Service::instance();
		$result         = $thim_wp_import->import_posts( true );

		if ( $result['has_posts'] ) {
			$response->status     = 'success';
			$response->message    = 'Import media ' . $result['current'] . ' success';
			$response->percentage = $result['percentage'];

			return $response;
		}

		$response->status        = 'success';
		$response->message       = esc_html__( 'Import media success', 'thim-core' );
		$response->percentage    = 100;
		$response->step_finished = 1;

		return $response;
	}

	/**
	 * Step import widgets.
	 *
	 * @since 0.3.1
	 */
	public function step_widgets() {
		$response = new Thim_Import_REST_Response();

		try {
			$dir          = $this->_get_dir_current_demo();
			$widget_file  = $dir . '/widget/widget_data.json';
			$widget_logic = $dir . '/widget/widget_logic_options.txt';

			Thim_Importer_Service::widget( $widget_file, $widget_logic );

			$response->status        = 'success';
			$response->message       = 'Import Widget success';
			$response->percentage    = 100;
			$response->step_finished = 1;
		} catch ( Thim_Error $e ) {
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/**
	 * Step import Slider Revolution
	 *
	 * @return Thim_Import_REST_Response
	 * @since 0.4.0
	 */
	public function step_revslider() {
		$response = new Thim_Import_REST_Response();

		try {
			$demo_data  = self::get_current_demo_data();
			$revsliders = isset( $demo_data['revsliders'] ) ? $demo_data['revsliders'] : array();

			Thim_Importer_Service::revslider( $revsliders );

			$response->status        = 'success';
			$response->message       = 'Import slider success';
			$response->percentage    = 100;
			$response->step_finished = 1;
		} catch ( Thim_Error $e ) {
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/**
	 * Next step and return response success.
	 *
	 * @param mixed $ext
	 *
	 * @return bool
	 * @since 0.3.1
	 *
	 */
	public function next_step(
		$ext = null
	) {
		$done = $this->_get_key_current_step();
		$next = $this->_get_key_next_step();
		do_action( 'thim_core_importer_next_step', $done, $next, $ext );

		return $this->_send_response_success(
			array(
				'done' => $done,
				'next' => $next,
				'ext'  => $ext,
			)
		);
	}

	/**
	 * Next step and return response success.
	 *
	 * @param mixed $ext
	 *
	 * @return bool
	 * @since 0.3.1
	 *
	 */
	private function _try_step(
		$ext = null
	) {
		$current = $this->_get_key_current_step();
		do_action( 'thim_core_importer_try_step', $current, $ext );

		return $this->_send_response_success(
			array(
				'next' => $current,
				'ext'  => $ext,
			)
		);
	}

	/**
	 * Send response error.
	 *
	 * @param string $msg
	 * @param string $code
	 * @param string $how_to
	 * @param bool   $safe
	 *
	 * @return bool
	 * @since 0.3.1
	 *
	 */
	private function _send_response_error(
		$msg,
		$code,
		$how_to = '',
		$safe = true
	) {
		$data = array(
			'title'  => $msg,
			'how_to' => $how_to,
			'code'   => $code,
		);

		if ( ! $safe ) {
			wp_send_json_error( $data );
		}

		$response = array(
			'success' => false,
		);

		if ( isset( $data ) ) {
			if ( is_wp_error( $data ) ) {
				$result = array();
				foreach ( $data->errors as $code => $messages ) {
					foreach ( $messages as $message ) {
						$result[] = array(
							'code'    => $code,
							'message' => $message,
						);
					}
				}

				$response['data'] = $result;
			} else {
				$response['data'] = $data;
			}
		}

		$this->_send_response( $response );

		return true;
	}

	/**
	 * Send response success.
	 *
	 * @param $data
	 * @param $safe
	 *
	 * @return bool
	 * @since 0.3.1
	 *
	 */
	private function _send_response_success(
		$data,
		$safe = true
	) {
		if ( ! $safe ) {
			wp_send_json_success( $data );
		}
		$response = array(
			'success' => true,
		);

		if ( isset( $data ) ) {
			$response['data'] = $data;
		}

		$this->_send_response( $response );

		return true;
	}

	/**
	 * Send response.
	 *
	 * @param $data
	 *
	 * @since 0.4.0
	 *
	 */
	private function _send_response(
		$data
	) {
		echo '<!-- THIM_IMPORT_START -->';
		header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
		echo wp_json_encode( $data );
		echo '<!-- THIM_IMPORT_END -->';
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			wp_die();
		} else {
			die;
		}
	}
}
