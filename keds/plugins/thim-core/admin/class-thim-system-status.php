<?php

/**
 * Class Thim_System_Status.
 *
 * @since 0.8.5
 */
class Thim_System_Status extends Thim_Admin_Sub_Page {
	/**
	 * @var string
	 *
	 * @since 0.8.5
	 */
	public $key_page = 'system-status';

	/**
	 * @var array
	 *
	 * @since 1.2.0
	 */
	public static $environments = null;

	/**
	 * Thim_System_Status constructor.
	 *
	 * @since 0.8.5
	 */
	protected function __construct() {
		parent::__construct();

		$this->hooks();
	}

	/**
	 * Add hooks.
	 *
	 * @since 1.2.0
	 */
	private function hooks() {
		add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
 		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Add sub page.
	 *
	 * @since 0.8.5
	 * @since 1.7.9
	 *
	 *
	 * @param $sub_pages
	 *
	 * @return mixed
	 */
	public function add_sub_page( $sub_pages ) {

 		if ( ! current_user_can( 'administrator' ) ) {
			return $sub_pages;
		}

		$sub_pages['system-status'] = array(
			'title' => __( 'System Status', 'thim-core' ),
			'icon' => '<svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0.5 19.8242H9.33789V22.7539H7.87305V24.2188H18.127V22.7539H16.6621V19.8242H25.5V0.78125H0.5V19.8242ZM15.1973 22.7539H10.8027V19.8242H15.1973V22.7539ZM1.96484 2.24609H24.0352V18.3594H1.96484V2.24609Z" fill="#444444"/>
							<path d="M17.1046 7.23394L18.179 6.15952L17.1432 5.12373L16.0688 6.19814C15.3978 5.69517 14.5998 5.35293 13.7324 5.22832V3.71094H12.2676V5.22832C11.4002 5.35293 10.6022 5.69512 9.9312 6.19814L8.85679 5.12373L7.821 6.15952L8.89541 7.23394C8.39243 7.90498 8.0502 8.70298 7.92559 9.57031H6.4082V11.0352H7.92559C8.0502 11.9025 8.39238 12.7005 8.89541 13.3715L7.821 14.4459L8.85679 15.4817L9.9312 14.4073C10.6022 14.9103 11.4002 15.2525 12.2676 15.3771V16.8945H13.7324V15.3771C14.5998 15.2525 15.3978 14.9104 16.0688 14.4073L17.1432 15.4817L18.179 14.4459L17.1046 13.3715C17.6076 12.7005 17.9498 11.9025 18.0744 11.0352H19.5918V9.57031H18.0744C17.9498 8.70298 17.6076 7.90498 17.1046 7.23394ZM13 13.9648C10.9807 13.9648 9.33789 12.322 9.33789 10.3027C9.33789 8.28345 10.9807 6.64062 13 6.64062C15.0193 6.64062 16.6621 8.28345 16.6621 10.3027C16.6621 12.322 15.0193 13.9648 13 13.9648Z" fill="#444444"/>
							<path d="M13 8.10547C11.7884 8.10547 10.8027 9.09116 10.8027 10.3027C10.8027 11.5143 11.7884 12.5 13 12.5C14.2116 12.5 15.1973 11.5143 15.1973 10.3027C15.1973 9.09116 14.2116 8.10547 13 8.10547ZM13 11.0352C12.5961 11.0352 12.2676 10.7066 12.2676 10.3027C12.2676 9.89888 12.5961 9.57031 13 9.57031C13.4039 9.57031 13.7324 9.89888 13.7324 10.3027C13.7324 10.7066 13.4039 11.0352 13 11.0352Z" fill="#444444"/>
						</svg>',
		);

		return $sub_pages;
	}

	/**
	 * Get arguments for template.
	 *
	 * @since 0.8.5
	 *
	 * @return null
	 */
	protected function get_template_args() {
		$args              = self::get_environment_info();
		$args['draw_text'] = self::get_draw_system_status();

		return $args;
	}

	/**
	 * Get array of environment information.
	 *
	 * @since 1.1.1
	 *
	 * @return array
	 */
	public static function get_environment_info() {
		if ( self::$environments === null ) {
			global $wpdb;
			$info = array();

			//Site
			$info['home_url']     = get_home_url();
			$info['site_url']     = get_site_url();
			$info['wp_version']   = get_bloginfo( 'version' );
			$info['is_multisite'] = is_multisite();
			$info['language']     = get_locale();

			//Theme
			$theme_data            = Thim_Theme_Manager::get_metadata();
			$info['theme_name']    = $theme_data['name'];
			$info['theme_version'] = $theme_data['version'];
			$info['theme_slug']    = $theme_data['stylesheet'];

			$info['server_info'] = $_SERVER['SERVER_SOFTWARE'];
			$info['php_version'] = phpversion();

			// Figure out cURL version, if installed.
			$curl_version = '';
			if ( function_exists( 'curl_version' ) ) {
				$curl_version = curl_version();
				$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
			}
			$info['curl_version'] = $curl_version;

			// WP memory limit
			$wp_memory_limit = thim_core_let_to_num( WP_MEMORY_LIMIT );
			if ( function_exists( 'memory_get_usage' ) ) {
				$wp_memory_limit = max( $wp_memory_limit, thim_core_let_to_num( ini_get( 'memory_limit' ) ) );
			}
			$info['memory_limit']      = $wp_memory_limit;
			$info['memory_limit_text'] = size_format( $info['memory_limit'] );

			// Max excution time.
			$info['max_execution_time'] = ini_get( 'max_execution_time' );

			$info['post_max_size']      = thim_core_let_to_num( ini_get( 'post_max_size' ) );
			$info['post_max_size_text'] = size_format( $info['post_max_size'] );

			$info['mysql_version'] = ! empty( $wpdb->is_mysql ) ? $wpdb->db_version() : '';

			$info['max_upload_size']      = wp_max_upload_size();
			$info['max_upload_size_text'] = size_format( $info['max_upload_size'] );

			// Test GET requests
			$response = thim_core_test_request( 'https://api.envato.com' );
			if ( $response['return'] ) {
				$response = thim_core_test_request( Thim_Admin_Config::get( 'host_downloads' ) . '/ping/' );

				if ( $response['return'] ) {
					$response = thim_core_test_request( Thim_Admin_Config::get( 'api_check_self_update' ) );
				}
			}
			$info['remote_get_test_url']   = $response['url'];
			$info['remote_get_successful'] = $response['return'];
			$info['remote_get_response']   = $response['message'];

			// dom extension
			$info['dom_extension'] = extension_loaded( 'dom' );

			//Site key
//			$info['site_key'] = Thim_Product_Registration::get_site_key();

			self::$environments = $info;
		}

		return self::$environments;
	}

	/**
	 * Get system status draw text.
	 *
	 * @since 1.2.0
	 *
	 * @return string
	 */
	public static function get_draw_system_status() {
		$environments = self::get_environment_info();
		$text         = "`\n";
		foreach ( $environments as $key => $environment ) {
			if ( is_string( $environment ) ) {
				$str = $environment;
			} else {
				$str = wp_json_encode( $environment );
			}
			$text .= $key . ' : ' . $str . "\n";
		}
		$text .= '`';

		return $text;
	}

	/**
	 * Enqueue script.
	 *
	 * @since 1.2.0
	 */
	public function enqueue_scripts() {
		if ( ! $this->is_myself() ) {
			return;
		}

		wp_enqueue_script( 'thim-developer-access' );
		wp_enqueue_script( 'thim-core-system-status', THIM_CORE_ADMIN_URI . '/assets/js/system-status.js', array(
			'jquery',
			'thim-core-clipboard'
		), THIM_CORE_VERSION );
	}
}
