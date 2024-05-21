<?php

/**
 * Class Thim_Sidebar_Manager.
 *
 * @package   Thim_Core_Admin
 * @since     0.2.0
 */
class Thim_Sidebar_Manager extends Thim_Singleton {
	/**
	 * @var string
	 *
	 * @since 0.1.0
	 */
	private static $key_options = 'thim_core_sidebar_manager';

	/**
	 * @var string
	 *
	 * @since 0.1.0
	 */
	public static $prefix_sidebar = 'thim_sidebar_';

	/**
	 * Thim_Sidebar_Manager constructor.
	 *
	 * @since 0.1.0
	 */
	protected function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.1.0
	 */
	private function init_hooks() {
		add_action( 'widgets_admin_page', array( $this, 'admin_page_sidebar' ) );
		add_filter( 'thim_core_list_sidebar', array( $this, 'add_filter_list_sidebar' ), 10, 1 );
		add_action( 'admin_init', array( $this, 'handle_action' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @param $page
	 *
	 * @since 0.1.0
	 */
	public function enqueue_script( $page ) {
		if ( 'widgets.php' !== $page ) {
			return;
		}

		wp_enqueue_style( 'thim_manager_sidebar', THIM_CORE_ADMIN_URI . '/assets/css/manager-sidebar.css', array(), THIM_CORE_VERSION );
		wp_enqueue_script( 'thim_manager_sidebar', THIM_CORE_ADMIN_URI . '/assets/js/sidebar-manager.js', array(), THIM_CORE_VERSION );

		$this->localize_script();
	}

	/**
	 * Localizes a registered script with data for a JavaScript variable.
	 *
	 * @since 0.1.0
	 */
	private function localize_script() {
		$data = array(
			'prefix'          => self::$prefix_sidebar,
			'remove_template' => $this->template_remove_button(),
			'confirm_remove'  => __( 'Are you sure want to remove sidebar ', 'thim-core' ),
		);
		wp_localize_script( 'thim_manager_sidebar', 'thim_sidebar_manager', $data );
	}

	/**
	 * Get template button remove sidebar.
	 *
	 * @return string
	 * @since 0.1.0
	 */
	private function template_remove_button() {
		ob_start();
		?>
        <button type="button" class="button thim-btn-remove-sidebar" title="<?php esc_attr_e( 'Remove this sidebar', 'thim-core' ); ?>">&times;</button>
		<?php

		return ob_get_clean();
	}

	/**
	 * Handle request create/delete sidebar.
	 *
	 * @since 0.1.0
	 */
	public function handle_action() {
		$method = isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : 'get';

		if ( 'post' !== strtolower( $method ) ) {
			return;
		}

		$new_sidebar_name = ! empty( $_POST['thim_input_sidebar_name'] ) ? esc_html( $_POST['thim_input_sidebar_name'] ) : false;

		if ( $new_sidebar_name ) {
			$id = self::create_new_sidebar( $new_sidebar_name );

			$this->refresh( "#$id" );
		}

		$delete_sidebar_id = ! empty( $_POST['thim_input_remove_sidebar'] ) ? esc_html( $_POST['thim_input_remove_sidebar'] ) : false;
		if ( $delete_sidebar_id ) {
			self::delete_sidebar( $delete_sidebar_id );
			$this->refresh();
		}
	}

	/**
	 * Form html page manage sidebars.
	 *
	 * @since 0.1.0
	 */
	public function admin_page_sidebar() {
		?>
        <div class="thim-manager-sidebar">
            <form method="POST" id="thim-form-remove-sidebar">
                <input type="hidden" name="thim_input_remove_sidebar" id="thim_input_remove_sidebar">
				<?php wp_nonce_field( 'thim_remove_sidebar', 'thim_nonce_remove_sidebar' ); ?>
            </form>

            <form method="POST">
                <h2><label for="thim_input_sidebar_name"><?php esc_html_e( 'Create new widget area', 'thim-core' ); ?></label></h2>
                <input class="widefat" type="text" name="thim_input_sidebar_name" id="thim_input_sidebar_name" style="width:300px;">
				<?php wp_nonce_field( 'thim_add_sidebar', 'thim_nonce_add_sidebar' ); ?>
                <button type="submit" class="button button-primary"><?php esc_html_e( 'Create', 'thim-core' ); ?></button>
            </form>
        </div>
		<?php
	}

	/**
	 * Create new sidebar with sidebar name.
	 *
	 * @since 0.1.0
	 *
	 * @param $name
	 *
	 * @return string
	 */
	private function create_new_sidebar( $name ) {
		$nonce  = isset( $_POST['thim_nonce_add_sidebar'] ) ? $_POST['thim_nonce_add_sidebar'] : '';
		$verify = wp_verify_nonce( $nonce, 'thim_add_sidebar' );
		if ( ! $verify ) {
			return false;
		}

		$id = self::generate_id_sidebar();

		$new_sidebar = array(
			'id'   => $id,
			'name' => $name,
		);

		$sidebars = $this->get_sidebars();
		array_push( $sidebars, $new_sidebar );

		update_option( self::$key_options, $sidebars );

		return $id;
	}

	/**
	 * Create new sidebar with sidebar id.
	 *
	 * @param $sidebar_id
	 *
	 * @return bool
	 * @since 0.1.0
	 */
	private function delete_sidebar( $sidebar_id ) {
		$nonce  = isset( $_POST['thim_nonce_remove_sidebar'] ) ? $_POST['thim_nonce_remove_sidebar'] : '';
		$verify = wp_verify_nonce( $nonce, 'thim_remove_sidebar' );
		if ( ! $verify ) {
			return false;
		}

		$sidebars = $this->get_sidebars();

		if ( 0 === count( $sidebars ) ) {
			return false;
		}

		foreach ( $sidebars as $index => $sidebar ) {
			if ( $sidebar_id === $sidebar['id'] ) {
				unset( $sidebars[ $index ] );

				return update_option( self::$key_options, $sidebars );
			}
		}

		return true;
	}

	/**
	 * Generate unique sidebar id.
	 *
	 * @return string
	 * @since 0.1.0
	 */
	private function generate_id_sidebar() {
		$time = time();

		return self::$prefix_sidebar . $time;
	}

	/**
	 * Get list sidebar.
	 *
	 * @return array
	 * @since 0.1.0
	 */
	private function get_sidebars() {
		$sidebars = get_option( self::$key_options );

		if ( ! $sidebars ) {
			return array();
		}

		return (array) $sidebars;
	}

	/**
	 * Add filter `thim_core_list_sidebar`
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function add_filter_list_sidebar() {
		return $this->get_sidebars();
	}

	/**
	 * Refresh to reload options.
	 *
	 * @param $hash
	 *
	 * @since 0.8.8
	 */
	private function refresh( $hash = '' ) {
		thim_core_redirect( admin_url( "widgets.php$hash" ) );
	}
}
