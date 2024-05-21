<?php

/**
 * Class Thim_Importer.
 *
 * @package   Thim_Core
 * @since     0.1.0
 */
class Thim_Importer extends Thim_Admin_Sub_Page {
	/**
	 * @since 0.8.5
	 *
	 * @var string
	 */
	public $key_page = 'importer';

	/**
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public static $key_option_demo_installed = 'thim_importer_demo_installed';

	/**
	 * Get key demo installed.
	 *
	 * @return bool|string
	 * @since 0.6.0
	 *
	 */
	public static function get_key_demo_installed() {
		$option = get_option( self::$key_option_demo_installed );

		if ( empty( $option ) ) {
			return false;
		}

		return $option;
	}

	/**
	 * Update key demo installed.
	 *
	 * @param string|bool $demo
	 *
	 * @return bool
	 * @since 0.8.1
	 *
	 */
	public static function update_key_demo_installed( $demo = '' ) {
		return update_option( self::$key_option_demo_installed, $demo );
	}

	/**
	 * Get packages import.
	 *
	 * @return array
	 * @since 0.3.0
	 *
	 */
	public static function get_import_packages() {
		$packages = array(
			'theme_options' => array(
				'title'       => esc_attr__( 'Theme Options', 'thim-core' ),
				'description' => esc_attr__( 'Import theme options and rewrite all current settings.', 'thim-core' ),
			),
			'main_content'  => array(
				'title'       => esc_attr__( 'Main Content', 'thim-core' ),
				'description' => esc_attr__(
					'Import posts, pages, comments, menus, custom fields, terms and custom posts.',
					'thim-core'
				),
			),
			'media'         => array(
				'title'       => esc_attr__( 'Media File', 'thim-core' ),
				'description' => esc_attr__( 'Download media files.', 'thim-core' ),
				'required'    => 'main_content',
			),
			'widgets'       => array(
				'title'       => esc_attr__( 'Widgets', 'thim-core' ),
				'description' => esc_attr__( 'Import widgets data.', 'thim-core' ),
			),
			'revslider'     => array(
				'title'       => esc_attr__( 'Slider Revolution', 'thim-core' ),
				'description' => esc_attr__( 'Import Slider Revolution.', 'thim-core' ),
			),
		);

		return apply_filters( 'thim_core_importer_packages', $packages );
	}

	/**
	 * Get demo data.
	 *
	 * @param bool $check_plugins_require
	 *
	 * @return array
	 * @since 0.2.0
	 *
	 */
	public static function get_demo_data( $check_plugins_require = false ) {

		$THEME_URI  = get_template_directory_uri();
		$THEME_PATH = get_template_directory();

		$file_demo_data = $THEME_PATH . '/inc/data/demos.php';
		if ( ! file_exists( $file_demo_data ) ) {
			return array();
		}

		$demo_data = include $file_demo_data;

		if ( ! is_array( $demo_data ) ) {
			return array();
		}
		// download folder data demo to upload
		$prefix_folder_data_demo = apply_filters( 'thim_prefix_folder_download_data_demo', '' );
		if ( $prefix_folder_data_demo ) {
			$base_uri_demo_data  = trailingslashit( WP_CONTENT_URL ) . 'uploads/thim-data-demos/' . esc_attr( $prefix_folder_data_demo ) . '/';
			$base_path_demo_data = trailingslashit( WP_CONTENT_DIR ) . 'uploads/thim-data-demos/' . esc_attr( $prefix_folder_data_demo ) . '/';
		} else {
			$base_uri_demo_data  = apply_filters( 'thim_core_importer_base_uri_demo_data', $THEME_URI . '/inc/data/demos/' );
			$base_path_demo_data = $THEME_PATH . '/inc/data/demos/';
		}


		foreach ( $demo_data as $key => $demo ) {
			$demo_data[$key]['key']        = $key;
			$demo_data[$key]['screenshot'] = $base_uri_demo_data . $key . '/screenshot.jpg';
			if ( isset( $demo['thumbnail_url'] ) ) {
				$demo_data[$key]['screenshot'] = $demo['thumbnail_url'];
			}
			$demo_data[$key]['dir'] = $base_path_demo_data . $key;

			if ( ! $check_plugins_require ) {
				continue;
			}

			$plugins_require = isset( $demo['plugins_required'] ) ? $demo['plugins_required'] : false;
			if ( ! $plugins_require ) {
				continue;
			}

			if ( ! is_array( $plugins_require ) ) {
				continue;
			}

			$plugins_required_ = array();

			$plugins_require_all = Thim_Plugins_Manager::get_slug_plugins_require_all();
			$plugins_require     = array_merge( $plugins_require_all, $plugins_require );
			$plugins_require     = array_unique( $plugins_require );

			foreach ( $plugins_require as $slug ) {
				$plugin = Thim_Plugins_Manager::get_plugin_by_slug( $slug );

				if ( ! $plugin ) {
					continue;
				}

				if ( $plugin->get_status() === 'active' ) {
					continue;
				}

				array_push( $plugins_required_, $plugin->to_array() );
			}

			$demo_data[$key]['plugins_required'] = $plugins_required_;
		}

		return $demo_data;
	}

	/**
	 * Thim_Importer constructor.
	 *
	 * @since 0.2.0
	 */
	protected function __construct() {
		parent::__construct();

		$this->init_hooks();
	}

	/**
	 * Get arguments for template.
	 *
	 * @return array
	 * @since 0.8.5
	 *
	 */
	protected function get_template_args() {
		$demo_data = self::get_demo_data();

		return array(
			'$demo_data'      => $demo_data,
			'$demo_installed' => self::get_key_demo_installed(),
		);
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.3.0
	 */
	private function init_hooks() {
		add_action( 'tc_after_dashboard_wrapper', array( $this, 'add_modal_import' ) );
		add_action( 'tc_after_dashboard_wrapper', array( $this, 'add_modal_uninstall_demo' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_thim_importer', array( $this, 'handle_ajax' ) );
		add_action( 'wp_ajax_thim_importer_uninstall', array( $this, 'handle_ajax_uninstall' ) );
		add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
		add_action( 'admin_init', array( $this, 'reset_import_demo' ) );
		add_filter( 'thim_importer_memory_limit', array( $this, 'memory_limit_importer' ) );
		add_action( 'admin_action_thim_importer_demo_data', array( $this, 'show_current_demo_data' ) );
		add_action( 'wp_import_insert_post', array( $this, 'import_mail_chimp' ), 10, 4 );
		if ( apply_filters( 'thim_download_data_demo', true ) ) {
			add_action( 'thim_core_importer_next_step', array( $this, 'importer_download_demo_data' ), 10, 2 );
		}
	}

	/**
	 * Download and unzip demo data.
	 *
	 * @param $done
	 * @param $next
	 *
	 * @throws Thim_Error
	 * @since 1.1.0
	 *
	 */
	public function importer_download_demo_data( $done, $next ) {

		if ( $done !== 'plugins' ) {
			return;
		}
		$prefix_folder_data_demo = apply_filters( 'thim_prefix_folder_download_data_demo', '' );

		if ( empty( $prefix_folder_data_demo ) ) {
			return;
		}

		$demo_data = Thim_Importer_AJAX::get_current_demo_data();
		$demo_key  = $demo_data['demo'];
		$url       = Thim_Admin_Config::get( 'demo_data' ) . esc_attr( $prefix_folder_data_demo ) . '/demos/' . $demo_key . '.zip';

		$package = Thim_File_Helper::download_file( $url );
		if ( is_wp_error( $package ) ) {
			throw Thim_Error::create( $package->get_error_message(), 8, __( 'Please try again later.', 'estatesy-demo-data' ) );
		}

		$path_file = trailingslashit( WP_CONTENT_DIR ) . 'uploads/thim-data-demos/' . esc_attr( $prefix_folder_data_demo ) . '/' . $demo_key . '.zip';

		$dir   = pathinfo( $path_file, PATHINFO_DIRNAME );
		$unzip = Thim_File_Helper::unzip_file( $package, $dir );
		if ( is_wp_error( $unzip ) ) {
			throw Thim_Error::create( $unzip->get_error_message(), 0, __( 'Please try again later.', 'thim-core' ) );
		}
	}

	/**
	 * Update option form default MailChimp
	 *
	 * @param $post
	 *
	 * @since 0.6.0
	 *
	 */
	public function import_mail_chimp( $post_id, $original_post_ID, $postdata, $post ) {
		if ( $post['post_type'] === 'mc4wp-form' ) {

			update_option( 'mc4wp_default_form_id', $post_id );
		}
	}

	/**
	 * Show current demo data.
	 *
	 * @since 1.4.8
	 */
	public function show_current_demo_data() {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		$current = Thim_Importer_AJAX::get_current_demo_data();
		print_r( $current );
	}

	/**
	 * Set memory limit for importer.
	 *
	 * @param $current
	 *
	 * @return string
	 * @since 1.4.6
	 *
	 */
	public function memory_limit_importer( $current ) {
		$current_limit_int = wp_convert_hr_to_bytes( $current );

		if ( $current_limit_int > 268435456 ) {
			return $current;
		}

		return '256M';
	}

	/**
	 * Reset config import demo.
	 *
	 * @since 1.3.1
	 */
	public function reset_import_demo() {
		if ( ! $this->is_myself() ) {
			return;
		}

		$detect = isset( $_GET['reset-importer'] );
		if ( ! $detect ) {
			return;
		}

		delete_option( 'thim_importer_posts_pp' );
		delete_option( 'thim_importer_attachments_pp' );
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
		// check has demo
		$demos = Thim_Importer::get_demo_data( true );
		if ( empty( $demos ) ) {
			return $sub_pages;
		}

		$sub_pages['importer'] = array(
			'title' => __( 'Import Demo', 'thim-core' ),
			'icon'  => '<svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M23.9375 18.75V21.875C23.9375 22.7367 23.2367 23.4375 22.375 23.4375H3.625C2.76328 23.4375 2.0625 22.7367 2.0625 21.875V18.75C2.0625 18.3188 2.4125 17.9688 2.84375 17.9688C3.275 17.9688 3.625 18.3188 3.625 18.75V21.875H22.375V18.75C22.375 18.3188 22.725 17.9688 23.1562 17.9688C23.5875 17.9688 23.9375 18.3188 23.9375 18.75Z" fill="#444444"/>
						<path d="M6.9791 13.0523C6.67363 12.7469 6.67363 12.2531 6.9791 11.9477C7.28457 11.6422 7.77832 11.6422 8.08379 11.9477L12.2189 16.0828V2.34375C12.2189 1.9125 12.5689 1.5625 13.0002 1.5625C13.4314 1.5625 13.7814 1.9125 13.7814 2.34375V16.0828L17.9166 11.9477C18.2221 11.6422 18.7158 11.6422 19.0213 11.9477C19.3268 12.2531 19.3268 12.7469 19.0213 13.0523L13.5525 18.5211C13.2432 18.8313 12.7471 18.8211 12.4471 18.5211L6.9791 13.0523Z" fill="#444444"/>
					</svg>',
		);

		return $sub_pages;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.3.0
	 *
	 */
	public function enqueue_scripts() {
		if ( ! $this->is_myself() ) {
			return;
		}
		wp_enqueue_script(
			'thim-importer',
			THIM_CORE_ADMIN_URI . '/assets/js/importer/importer.min.js',
			array( 'wp-util', 'jquery', 'backbone', 'underscore' ),
			THIM_CORE_VERSION,
			true
		);

		$this->localize_script();
	}

	/**
	 * Add modal importer.
	 *
	 * @since 0.3.0
	 */
	public function add_modal_import() {
		if ( ! $this->is_myself() ) {
			return;
		}

		Thim_Dashboard::get_template( 'partials/importer-modal.php' );
	}

	/**
	 * Add modal uninstall demo.
	 *
	 * @since 0.8.1
	 */
	public function add_modal_uninstall_demo() {
		if ( ! $this->is_myself() ) {
			return;
		}

		Thim_Dashboard::get_template( 'partials/importer-uninstall-modal.php' );
	}

	/**
	 * Handle ajax import demo.
	 *
	 * @since 0.3.1
	 */
	public function handle_ajax() {
		if ( function_exists( 'wp_raise_memory_limit' ) ) {
			wp_raise_memory_limit( 'thim_importer' );
		}

		$importer_ajax = new Thim_Importer_AJAX();
		$importer_ajax->handle_ajax();
	}

	/**
	 * Handle ajax uninstall demo.
	 *
	 * @since 0.6.0
	 */
	public function handle_ajax_uninstall() {
		if ( function_exists( 'wp_raise_memory_limit' ) ) {
			wp_raise_memory_limit( 'thim_importer' );
		}

		$importer_ajax = new Thim_Importer_AJAX();
		$importer_ajax->handle_ajax_uninstall();
	}

	/**
	 * Localize script.
	 *
	 * @since 0.3.0
	 */
	public function localize_script() {
		$demos = self::get_demo_data();
		$nonce = wp_create_nonce( 'thim-importer' );

		wp_localize_script( 'thim-importer', 'thim_importer_data', array(
			'nonce'                => $nonce,
			'url_ajax'             => admin_url( 'admin-ajax.php' ),
			'admin_ajax_action'    => admin_url( 'admin-ajax.php' ),
			'admin_ajax_uninstall' => admin_url( 'admin-ajax.php' ),
			'details_error'        => array(
				'title'     => __( 'The import demo content failed!', 'thim-core' ),
				'try_again' => __(
					'Import failed. The system will automatically adjust some configurations. Please give it one more try. Good luck!',
					'thim-core'
				),
				'code'      => array(
					'request' => '#001_REQUEST_ERROR',
					'server'  => '#002_SERVER_ERROR',
				),
			),
			'uninstall_successful' => __( 'Uninstall demo content successful :]', 'thim-core' ),
			'uninstall_failed'     => __( 'Uninstall demo content failed. Please try again :]', 'thim-core' ),
			'confirm_close'        => __( 'Do you really want to close?', 'thim-core' ),
			'something_went_wrong' => __( 'Some thing went wrong. Please try again :]', 'thim-core' ),
		) );

		wp_localize_script( 'thim-importer', 'thim_importer', array(
			'demos'     => $demos,
			'installed' => self::get_key_demo_installed(),
		) );
	}
}
