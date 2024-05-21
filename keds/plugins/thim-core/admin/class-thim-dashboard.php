<?php

/**
 * Class Thim_Dashboard.
 *
 * @package   Thim_Core
 * @since     0.1.0
 */
class Thim_Dashboard extends Thim_Singleton {
	/**
	 * Do not edit value.
	 *
	 * @since 0.2.0
	 *
	 * @var string
	 */
	private static $main_slug = 'dashboard';

	/**
	 * @var string
	 *
	 * @since 0.2.0
	 */
	public static $prefix_slug = 'thim-';

	/**
	 * List sub pages.
	 *
	 * @since 0.2.0
	 * @var array
	 */
	private static $sub_pages = array();

	/**
	 * @since 0.8.5
	 *
	 * @var null
	 */
	private static $current_key_page = null;

	/**
	 * Check first install.
	 *
	 * @since 0.8.5
	 */
	public static function check_first_install() {
		return Thim_Admin_Settings::get( 'first_install', true );
	}

	/**
	 * Get link page by slug.
	 *
	 * @param $slug
	 *
	 * @return string
	 * @since 0.5.0
	 *
	 */
	public static function get_link_page_by_slug( $slug ) {
		if ( ! Thim_Core_Admin::is_my_theme() ) {
			return admin_url();
		}

		return admin_url( 'admin.php?page=' . self::$prefix_slug . $slug );
	}

	/**
	 * Get link main dashboard.
	 *
	 * @param array $args [key => value] => &key=value
	 *
	 * @return string
	 * @since 0.2.0
	 *
	 */
	public static function get_link_main_dashboard( $args = null ) {
		$url = self::get_link_page_by_slug( self::$main_slug );

		if ( is_array( $args ) ) {
			$url = add_query_arg( $args, $url );
		}

		return $url;
	}

	/**
	 * Get key (slug) current page.
	 *
	 * @since 0.3.0
	 */
	public static function get_current_page_key() {
		if ( is_null( self::$current_key_page ) ) {
			$current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
			$prefix_slug  = Thim_Dashboard::$prefix_slug;

			$pages = self::get_sub_pages();
			foreach ( $pages as $key => $page ) {
				if ( $prefix_slug . $key === $current_page ) {
					self::$current_key_page = $key;

					return self::$current_key_page;
				}
			}

			self::$current_key_page = false;
		}

		return self::$current_key_page;
	}

	/**
	 * Check current request is for a page of Thim Core Dashboard interface.
	 *
	 * @return bool True if inside Thim Core Dashboard interface, false otherwise.
	 * @since 0.3.0
	 *
	 */
	public static function is_dashboard() {
		$current_page = self::get_current_page_key();

		return (bool) ( $current_page );
	}

	/**
	 * Set list sub pages.
	 *
	 * @since 0.2.0
	 */
	private static function set_sub_pages() {
		self::$sub_pages = apply_filters( 'thim_dashboard_sub_pages', array() );
	}

	/**
	 * Get list sub pages.
	 *
	 * @return array
	 * @since 0.2.0
	 *
	 */
	public static function get_sub_pages() {
		if ( empty( self::$sub_pages ) ) {
			self::set_sub_pages();
		}

		return self::$sub_pages;
	}

	/**
	 * Add notifications.
	 *
	 * @param array $args
	 *
	 * @since 0.3.0
	 *
	 */
	public static function add_notification( $args = array() ) {
		$current_page = self::get_current_page_key();

		$default = array(
			'content' => '',
			'type'    => 'success',
			'page'    => $current_page,
		);
		$args    = wp_parse_args( $args, $default );

		$page = $args['page'];
		if ( $page !== $current_page ) {
			return;
		}

		$type    = $args['type'];
		$content = $args['content'];
		add_action( 'thim_dashboard_notifications', function () use ( $type, $content ) {

			?>
			<div class="tc-notice tc-<?php echo esc_attr( $type ); ?>">
				<div class="content"><?php echo $content; ?></div>
			</div>
			<?php
		} );
	}

	/**
	 * Get page template.
	 *
	 * @param       $template
	 * @param array $args
	 *
	 * @return bool
	 * @since 0.5.0
	 *
	 */
	public static function get_template( $template, $args = array() ) {
		return Thim_Template_Helper::template( 'dashboard/' . $template, $args, true );
	}

	/**
	 * Thim_Dashboard constructor.
	 *
	 * @since 0.2.0
	 */
	protected function __construct() {
		$this->init();
		$this->init_hooks();
	}

	/**
	 * Init.
	 *
	 * @since 0.2.0
	 */
	private function init() {
		Thim_Main_Dashboard::instance();
		Thim_Product_Registration::instance();
		Thim_Getting_Started::instance();
		if ( empty( Thim_Free_Theme::get_theme_id() ) && Thim_Free_Theme::is_free() ) {

		} else {
			Thim_Theme_License::instance();
		}
		Thim_Importer::instance();
		Thim_Plugins_Manager::instance();
		Thim_System_Status::instance();
		Thim_Service::instance();
		Thim_Child_Themes::instance();
  		//  Thim_For_Developer::instance();
	}

	/**
	 * Get page template.
	 *
	 * @param string $template
	 * @param mixed  $args
	 *
	 * @return bool
	 * @since 0.2.0
	 *
	 */
	private function get_page_template( $template, $args = array() ) {
		return Thim_Template_Helper::template( 'dashboard/' . $template, $args, true );
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.2.0
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		add_action( 'admin_menu', array( $this, 'add_sub_menu_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'thim_dashboard_notifications', array( $this, 'add_notification_requirements' ) );

		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
		add_action( 'admin_bar_menu', array( $this, 'add_menu_admin_bar' ), 50 );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
		add_filter( 'update_footer', array( $this, 'admin_footer_version' ), 999 );
		$can_update_theme = Thim_Theme_Manager::can_update();
		if ( $can_update_theme ) {
			add_filter( 'thim_core_theme_dashboard_menu_title', array( $this, 'add_count_number_theme_notification' ) );
			add_filter( 'thim_core_tab_dashboard_menu_title', array( $this, 'add_count_number_theme_notification' ) );
		} else {
			add_filter( 'thim_core_theme_dashboard_menu_title', array( $this, 'add_count_number_notification' ) );
		}
		add_filter( 'thim_core_tab_plugins_menu_title', array( $this, 'add_count_number_notification' ) );
		add_filter( 'thim_core_plugins_menu_title', array( $this, 'add_count_number_notification' ) );
		add_filter( 'thim_core_number_requirements_notification', array( $this, 'add_count_number_requirements_notification' ) );
		add_action( 'thim_core_dashboard_init', array( $this, 'handle_notification_error' ) );
	}

	/**
	 * Handle notification error.
	 *
	 * @since 1.4.2
	 */
	public function handle_notification_error() {
		$code = ! empty( $_REQUEST['thim-core-error'] ) ? $_REQUEST['thim-core-error'] : false;
		if ( ! $code ) {
			return;
		}

		$messages = array(
			'something_went_wrong' => __( 'Something went wrong! Please try again later.', 'thim-core' )
		);
		$messages = apply_filters( 'thim_core_list_error_messages', $messages );

		if ( ! isset( $messages[$code] ) ) {
			return;
		}

		Thim_Notification::add_notification( array(
			'id'          => 'thim_core_dashboard_error',
			'type'        => 'error',
			'content'     => $messages[$code],
			'dismissible' => false,
			'global'      => false,
		) );
	}

	/**
	 * Add count number notification.
	 *
	 * @param $title
	 *
	 * @return string
	 * @since 1.4.0
	 *
	 */
	public function add_count_number_notification( $title ) {
		$plugins = Thim_Plugin::get_plugin_updates();

		$plugins_required = Thim_Plugins_Manager::get_plugins();
		$count            = 0;
		foreach ( $plugins_required as $thim_plugin ) {
			$plugin_file = $thim_plugin->get_plugin_file();

			if ( isset( $plugins[$plugin_file] ) ) {
				$count ++;
			}
		}

		if ( $count != 0 ) {
			$title .= sprintf( ' <span class="thim-core-count-notification update-plugins count-%1$s"><span class="plugin-count">%1$s</span></span>', $count );
		}

		return $title;
	}


	public function add_count_number_theme_notification( $title ) {
		$count = 0;

		$can_update_theme = Thim_Theme_Manager::can_update();
		if ( $can_update_theme ) {
			$count ++;
		}

		if ( $count != 0 ) {
			$title .= sprintf( '<span class="theme-count-notification update-plugins count-%1$s" data-count="%1$s"><span class="theme-count">%1$s</span></span>', $count );
		}

		return $title;
	}

	public function add_count_number_requirements_notification( $count = 0 ) {
		$environments = Thim_System_Status::get_environment_info();
 		if ( version_compare( phpversion(), 7.0, '<=' ) ) {
			$count ++;
		}
		if ( $environments['memory_limit'] < 134217728 ) {
			$count ++;
		}
		if ( ! $environments['remote_get_successful'] ) {
			$count ++;
		}
		if ( ! $environments['dom_extension'] ) {
			$count ++;
		}
		if ( $environments['max_execution_time'] < 60 ) {
			$count ++;
		}

		return $count;
	}

	/**
	 * Add notification requirements.
	 *
	 * @since 0.8.3
	 */
	public function add_notification_requirements() {
		$version_require = '7.0';

		if ( version_compare( phpversion(), $version_require, '>=' ) ) {
			return;
		}

		?>
		<div class="tc-notice tc-error">
			<div class="content">
				<?php printf( __( '<strong>Important:</strong> We found out your system is using PHP version %1$s. Please consider upgrading to version %2$s or higher.', 'thim-core' ), phpversion(), $version_require ); ?>
			</div>
		</div>
		<?php
		exit();
	}

	/**
	 * Filter admin footer version (on the right).
	 *
	 * @param $msg
	 *
	 * @return string
	 * @since 0.8.5
	 *
	 */
	public function admin_footer_version( $msg ) {
		if ( ! self::is_dashboard() ) {
			return $msg;
		}

		return sprintf( 'Thim Core Version %s', THIM_CORE_VERSION );
	}

	/**
	 * Filter admin footer text.
	 *
	 * @param $html
	 *
	 * @return string
	 * @since 0.8.2
	 *
	 */
	public function admin_footer_text( $html ) {
		if ( ! self::is_dashboard() ) {
			return $html;
		}

		$text = sprintf( __( 'Thank you for creating with <a href="%s" target="_blank">ThimPress</a>.', 'thim-core' ), __( 'https://thimpress.com' ) );

		return '<span id="footer-thankyou">' . $text . '</span>';
	}

	/**
	 * Add admin bar menu.
	 *
	 * @param $wp_admin_bar WP_Admin_Bar
	 *
	 * @since 0.5.0
	 *
	 */
	public function add_menu_admin_bar( $wp_admin_bar ) {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		};

		if ( is_admin() ) {
			return;
		}

		$theme_data = Thim_Theme_Manager::get_metadata();
		$theme_name = $theme_data['name'];

		$menu_title = ! empty( $theme_name ) ? $theme_name : __( 'ThimPress Dashboard', 'thim-core' );

		$args = array(
			'id'    => 'thim_core',
			'title' => $menu_title,
			'href'  => self::get_link_main_dashboard()
		);
		$wp_admin_bar->add_node( $args );

		$pages = self::get_sub_pages();
		foreach ( $pages as $key => $page ) {
			$args = array(
				'id'     => self::$prefix_slug . $key,
				'title'  => $page['title'],
				'href'   => self::get_link_page_by_slug( $key ),
				'parent' => 'thim_core'
			);
			$wp_admin_bar->add_node( $args );
		}
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.2.0
	 */
	public function enqueue_scripts() {
		if ( ! self::is_dashboard() ) {
			return;
		}

		do_action( 'thim_core_dashboard_enqueue_scripts' );

		wp_enqueue_script( 'thim-core-admin' );
		wp_enqueue_script( 'thim-modal-v2' );
		wp_enqueue_script( 'thim-dashboard', THIM_CORE_ADMIN_URI . '/assets/js/thim-dashboard.js', array( 'jquery-ui-sortable', 'wp-api-fetch' ), THIM_CORE_VERSION );
		wp_enqueue_style( 'thim-dashboard', THIM_CORE_ADMIN_URI . '/assets/css/dashboard.css', array(), THIM_CORE_VERSION );

		$this->localize_script();
	}

	/**
	 * Localize script.
	 *
	 * @since 0.8.9
	 */
	private function localize_script() {
		wp_localize_script( 'thim-dashboard', 'thim_dashboard', array(
			'admin_ajax' => admin_url( 'admin-ajax.php?action=thim_dashboard_order_boxes' )
		) );
	}

	/**
	 * Add class to body class in admin.
	 *
	 * @param $body_classes
	 *
	 * @return string
	 * @since 0.3.0
	 *
	 */
	public function admin_body_class( $body_classes ) {
		if ( ! self::is_dashboard() ) {
			return $body_classes;
		}

		$current_page_key = self::get_current_page_key();
		$prefix           = self::$prefix_slug;
		$current_page     = $prefix . $current_page_key;
		$main_page        = $prefix . self::$main_slug;

		$body_classes .= ' ' . $main_page . ' ' . $current_page . '-wrapper';

		return $body_classes;
	}

	/**
	 * Add menu page (Main page).
	 *
	 * @since 0.2.0
	 */
	public function add_menu_page() {
		$theme_data = Thim_Theme_Manager::get_metadata();
		$theme_name = $theme_data['name'];
		$title      = ! empty( $theme_name ) ? $theme_name : __( 'ThimPress Dashboard', 'thim-core' );
		$menu_title = apply_filters( 'thim_core_theme_dashboard_menu_title', $title );

		add_menu_page(
			$title,
			$menu_title,
			'manage_options',
			self::$prefix_slug . self::$main_slug,
			array(
				$this,
				'master_template'
			),
			THIM_CORE_ADMIN_URI . '/assets/images/logo.svg',
			2
		);
	}

	/**
	 * Add sub menu pages.
	 *
	 * @since 0.2.0
	 */
	public function add_sub_menu_pages() {
		$sub_pages = $this->get_sub_pages();
		$prefix    = Thim_Dashboard::$prefix_slug;

		foreach ( $sub_pages as $key => $page ) {

			$default = array(
				'title'    => '',
				'template' => '',
			);
			$page    = wp_parse_args( $page, $default );

			$slug  = $prefix . $key;
			$title = $page['title'];

			$menu_title = apply_filters( 'thim_core_' . $key . '_menu_title', $title );
			add_submenu_page( self::$prefix_slug . self::$main_slug, $title, $menu_title, 'manage_options', $slug, array(
					$this,
					'master_template'
				) );

		}
 	}

	/**
	 * Master template.
	 *
	 * @since 0.8.5
	 * @since 1.3.1
	 */
	public function master_template() {
		do_action( 'thim_core_dashboard_init' );

		$this->get_page_template( 'master.php' );
	}
}
