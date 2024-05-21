<?php

/**
 * Class Thim_Child_Themes.
 *
 * @since 1.1.1
 */
class Thim_Child_Themes extends Thim_Admin_Sub_Page {

	/**
	 * @since 1.1.1
	 *
	 * @var string
	 */
	public $key_page = 'child-themes';

	/**
	 * @var Thim_Child_Theme[]
	 *
	 * @since 1.2.0
	 */
	private static $child_themes = null;

	/**
	 * Get list child themes
	 *
	 * @since 1.2.0
	 *
	 * @return Thim_Child_Theme[]
	 */
	public static function child_themes() {
		if ( self::$child_themes === null ) {
			$themes = array();

			$input_child_themes = Thim_Theme_Manager::get_data( 'child_themes' );
			if ( empty( $input_child_themes ) || ! is_array( $input_child_themes ) ) {
				self::$child_themes = array();

				return self::$child_themes;
			}

			foreach ( $input_child_themes as $args ) {
				$themes[] = new Thim_Child_Theme( $args );
			}

			self::$child_themes = $themes;
		}

		return self::$child_themes;
	}

	/**
	 * Get data list child themes.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	public static function get_data_child_themes() {
		$child_themes = self::child_themes();
		$themes       = array_map(
			function ( $theme ) {
				$data = $theme->toArray();

				unset( $data['source'] );

				return $data;
			},
			$child_themes
		);

		return $themes;
	}

	/**
	 * Thim_Child_Themes constructor.
	 *
	 * @since 1.1.1
	 */
	protected function __construct() {
		parent::__construct();

		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since 1.1.1
	 */
	private function init_hooks() {
		add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'switch_theme', array( $this, 'switch_theme_update_mods' ) );
		add_action( 'wp_ajax_thim_child_themes_action', array( $this, 'handle_ajax_action' ) );
	}

	/**
	 * Handle ajax action.
	 *
	 * @since 1.2.0
	 */
	public function handle_ajax_action() {
		$slug   = isset( $_REQUEST['slug'] ) ? $_REQUEST['slug'] : false;
		$action = isset( $_REQUEST['thim_action'] ) ? $_REQUEST['thim_action'] : false;

		if ( empty( $slug ) || empty( $action ) ) {
			wp_send_json_error( __( 'Something went wrong!', 'thim-core' ) );
		}

		$result = new WP_Error( 'thim_core_them_not_found', __( 'This theme not exist!', 'thim-core' ) );

		$themes = self::child_themes();
		foreach ( $themes as $theme ) {
			$theme_slug   = $theme->get( 'slug' );
			$theme_status = $theme->get_status();

			if ( $slug == $theme_slug ) {
				switch ( $action ) {
					case 'install':
						if ( $theme_status != 'not_installed' ) {
							wp_send_json_error( __( 'This theme has already installed!', 'thim-core' ) );
						}

						$result = $theme->install();

						break;

					case 'activate':
						if ( $theme_status == 'not_installed' ) {
							wp_send_json_error( __( 'This theme has not installed yet!', 'thim-core' ) );
						}
						$result = $theme->activate();

						break;
				}
			}
		}

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() );
		}

		Thim_Theme_Manager::flush();
		$themes = self::get_data_child_themes();

		wp_send_json_success( $themes );
	}

	/**
	 * Update theme mods when switch theme.
	 *
	 * @since 1.0.3
	 */
	public function switch_theme_update_mods() {
		if ( ! thim_core_is_child_theme() ) {
			return;
		}

		$child_mods = get_theme_mods();
		if ( ! empty( $child_mods ) ) {
			//return;
		}

		if ( get_theme_mod( 'thim_core_extend_parent_theme', false ) ) {
			return;
		}

		$mods = get_option( 'theme_mods_' . get_option( 'template' ) );

		if ( false === $mods ) {
			return;
		}

		foreach ( (array) $mods as $mod => $value ) {
			set_theme_mod( $mod, $value );
		}

		set_theme_mod( 'thim_core_extend_parent_theme', true );
	}

	/**
	 * Add sub page.
	 *
	 * @since 1.1.1
	 *
	 * @param $sub_pages array
	 *
	 * @return array
	 */
	public function add_sub_page( $sub_pages ) {
		if ( ! current_user_can( 'switch_themes' ) && ! current_user_can( 'edit_theme_options' ) ) {
			return $sub_pages;
		}

		$theme_data   = Thim_Theme_Manager::get_metadata();
		$child_themes = $theme_data['child_themes'];

		if ( empty( $child_themes ) ) {
			return $sub_pages;
		}

		$sub_pages[ $this->key_page ] = array(
			'title' => __( 'Child Themes', 'thim-core' ),
			'icon' => '<svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M16.6667 0H9.01667C8.35843 0.00210351 7.72753 0.263481 7.26067 0.7275L3.22733 4.76083C2.76342 5.22769 2.5021 5.85851 2.5 6.51667V17.5C2.50075 18.1628 2.76438 18.7983 3.23306 19.2669C3.70174 19.7356 4.33719 19.9993 5 20H7.5V22.5C7.50075 23.1628 7.76438 23.7983 8.23306 24.2669C8.70174 24.7356 9.33719 24.9993 10 25H21.6667C22.3295 24.9993 22.9649 24.7356 23.4336 24.2669C23.9023 23.7983 24.1659 23.1628 24.1667 22.5V7.5C24.1659 6.83719 23.9023 6.20174 23.4336 5.73306C22.9649 5.26438 22.3295 5.00075 21.6667 5H19.1667V2.5C19.1659 1.83719 18.9023 1.20174 18.4336 0.733061C17.9649 0.264383 17.3295 0.000749912 16.6667 0ZM5 18.3333C4.77899 18.3333 4.56702 18.2455 4.41074 18.0893C4.25446 17.933 4.16667 17.721 4.16667 17.5V6.51667C4.1697 6.30055 4.25534 6.0938 4.406 5.93883L8.43933 1.9055C8.59425 1.75514 8.8008 1.6697 9.01667 1.66667H16.6667C16.8877 1.66667 17.0996 1.75446 17.2559 1.91074C17.4122 2.06702 17.5 2.27899 17.5 2.5V17.5C17.5 17.721 17.4122 17.933 17.2559 18.0893C17.0996 18.2455 16.8877 18.3333 16.6667 18.3333H5ZM21.6667 6.66667C21.8877 6.66667 22.0996 6.75446 22.2559 6.91074C22.4122 7.06702 22.5 7.27899 22.5 7.5V22.5C22.5 22.721 22.4122 22.933 22.2559 23.0893C22.0996 23.2455 21.8877 23.3333 21.6667 23.3333H10C9.77899 23.3333 9.56702 23.2455 9.41074 23.0893C9.25446 22.933 9.16667 22.721 9.16667 22.5V20H16.6667C17.3295 19.9993 17.9649 19.7356 18.4336 19.2669C18.9023 18.7983 19.1659 18.1628 19.1667 17.5V6.66667H21.6667Z" fill="#444444"/>
				</svg>',
		);

		return $sub_pages;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.2.0
	 */
	public function enqueue_scripts() {
		if ( ! $this->is_myself() ) {
			return;
		}

		wp_enqueue_script( 'thim-child-themes', THIM_CORE_ADMIN_URI . '/assets/js/child-themes.js', array( 'wp-util', 'jquery', 'backbone', 'underscore' ), THIM_CORE_VERSION );
		$this->localize_script();
	}

	/**
	 * Localize script.
	 *
	 * @since 1.2.0
	 */
	private function localize_script() {
		$data = $this->get_data_template();
		wp_localize_script( 'thim-child-themes', 'tc_child_themes', $data );
	}

	/**
	 * Get data template.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	private function get_data_template() {
		$themes = self::get_data_child_themes();

		return array(
			'themes'      => $themes,
			'url_ajax'    => admin_url( 'admin-ajax.php' ),
			'ajax_action' => 'thim_child_themes_action'
		);
	}
}
