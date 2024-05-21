<?php

/**
 * Class Thim_System_Status.
 *
 * @since 0.8.5
 */
class Thim_Main_Dashboard extends Thim_Admin_Sub_Page {
	/**
	 * @var string
	 *
	 * @since 0.8.5
	 */
	public $key_page = 'dashboard';

	/**
	 * @var array
	 *
	 * @since 0.8.9
	 */
	public static $boxes = null;

	/**
	 * Get all boxes.
	 *
	 * @since 0.8.9
	 */
	public static function all_boxes() {
		if ( self::$boxes === null ) {
			$theme_data = Thim_Theme_Manager::get_metadata();

			self::$boxes       = array(
				'appearance'    => array(
					'id'    => 'appearance',
					'title' => __( 'Quick settings', 'thim-core' )
				),
				'open_row'      => array(
					'title' => 'Open div'
				),
				'close_row'     => array(
					'title' => 'close div'
				),
				'documentation' => array(
					'id'    => 'documentation',
					'title' => __( 'Help & Support', 'thim-core' ),
				),
				'support-us'    => array(
					'id'    => 'support-us',
					'title' => __( 'Support us', 'thim-core' ),
				)
			);
			$integrations_file = isset( $theme_data['integrations_file'] ) ? $theme_data['integrations_file'] : '';
			if ( $integrations_file ) {
				self::$boxes['integrations'] = array(
					'id'    => 'integrations',
					'title' => $theme_data['name'] . ' ' . __( 'Integrations', 'thim-core' ),
				);
			}
			if ( ! Thim_Free_Theme::get_theme_id() ) {
				$envato_id = ! empty( $theme_data['envato_item_id'] ) ? $theme_data['envato_item_id'] : false;
				if ( $envato_id ) {
					self::$boxes['updates'] = array(
						'id'    => 'updates',
						'title' => __( 'Welcome admin', 'thim-core' ),
					);
				}
			} else {
				self::$boxes['updates-lite'] = array(
					'id'    => 'updates-lite',
					'title' => __( 'Welcome admin', 'thim-core' ),
				);
			}

			$changelog_file = isset( $theme_data['changelog_file'] ) ? $theme_data['changelog_file'] : '';
			if ( $changelog_file ) {
				self::$boxes['changelog'] = array(
					'id'    => 'changelog',
					'title' => __( 'What is the new?', 'thim-core' ),
					'links' => $theme_data['links']['changelog']
				);
			}
		}

		return apply_filters( 'thim_dashboard_all_boxes', self::$boxes );
	}

	/**
	 * Thim_System_Status constructor.
	 *
	 * @since 0.8.5
	 */
	protected function __construct() {
		parent::__construct();

		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 0.8.5
	 */
	private function init_hooks() {
		//        add_action( 'wp_ajax_thim_dashboard_order_boxes', array( $this, 'handle_order_boxes_dashboard' ) );
		add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
		add_action( 'thim_dashboard_registration_box', array( $this, 'render_registration_box' ), 10 );
		add_action( 'thim_dashboard_boxes_left', array( $this, 'render_boxes_left' ) );
		add_action( 'thim_dashboard_boxes_right', array( $this, 'render_boxes_right' ) );
		add_action( 'thim_dashboard_boxes_content', array( $this, 'thim_dashboard_boxes_content' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Render registration box.
	 *
	 * @since 1.0.1
	 */
	public function render_registration_box() {
		if ( Thim_Product_Registration::is_active() ) {
			return;
		}

		if ( Thim_Free_Theme::get_theme_id() ) {
			return;
		}

		$envato_id = Thim_Theme_Manager::get_data( 'envato_item_id', false );
		if ( ! $envato_id ) {
			return;
		}

		Thim_Dashboard::get_template( 'partials/registration.php' );
	}

	/**
	 * Handle ajax order.
	 *
	 * @since 0.8.9
	 */
	public function handle_order_boxes_dashboard() {
		$post_data = wp_parse_args( $_POST, array(
			'left'  => array(),
			'right' => array(),
		) );

		update_option( 'thim_dashboard_order_boxes', $post_data );

		wp_send_json_success( $post_data );
	}

	/**
	 * Set global temporary list boxes
	 *
	 * @since 0.8.0
	 */
	private function all_boxes_temp() {
		global $render_boxes;

		if ( $render_boxes === null ) {
			$render_boxes = self::all_boxes();
		}
	}

	/**
	 * Render box with key.
	 *
	 * @param $key
	 *
	 * @since 0.8.9
	 *
	 */
	private function render_box( $key ) {
		$this->all_boxes_temp();

		global $render_boxes;
		if ( $key == 'open_row') {
			echo '<div class="display-flex">';
		}
 		if ( empty( $render_boxes[$key] ) ) {
			return;
		}

		$box  = $render_boxes[$key];
		$args = wp_parse_args( $box, array(
			'id'       => '',
			'title'    => '',
			'lock'     => false,
			'template' => '',
		) );

		if ( empty( $args['template'] ) ) {
			$args['template'] = $args['id'];
		}

		if($args['template']){
			Thim_Dashboard::get_template( 'boxes/master.php', $args );
		}

		if ( $key == 'close_row') {
			echo '</div>';
		}
		/**
		 * Only once render box.
		 */
		unset( $render_boxes[$key] );
	}

	/**
	 * Render boxes with order.
	 *
	 * @param $boxes
	 *
	 * @since 0.8.9
	 *
	 */
	private function render_boxes( $boxes ) {
		foreach ( $boxes as $box ) {

			$this->render_box( $box );
		}
	}

	/**
	 * Render boxes on the left.
	 *
	 * @since 0.8.9
	 */
	public function render_boxes_left() {
		$boxes_default = array(
			'updates',
			'updates-lite',
			'changelog',
			'subscribe',
		);

		$order = (array) get_option( 'thim_dashboard_order_boxes', array() );
		$boxes = isset( $order['left'] ) ? $order['left'] : $boxes_default;

		$this->render_boxes( $boxes );
	}

	/**
	 * Render boxes on the right.
	 *
	 * @since 0.8.9
	 */
	public function render_boxes_right() {
		$boxes_default = array(
			'appearance',
			'documentation',
			'integrations'
		);

		$order = (array) get_option( 'thim_dashboard_order_boxes', array() );
		$boxes = isset( $order['right'] ) ? $order['right'] : $boxes_default;

		$this->render_boxes( $boxes );

		/**
		 * Render others boxes have not rendered.
		 */
		global $render_boxes;
		foreach ( $render_boxes as $key => $box ) {
			$this->render_box( $key );
		}
	}

	public function thim_dashboard_boxes_content() {
		$boxes_default = array(
			'updates',
			'updates-lite',
			'open_row',
			'changelog',
			'appearance',
			'close_row',
			'documentation',
			'open_row',
			'support-us',
			'integrations',
			'close_row',
		);

		//        $order = (array) get_option( 'thim_dashboard_order_boxes', array() );
		//        $boxes = isset( $order['right'] ) ? $order['right'] : $boxes_default;

		$this->render_boxes( $boxes_default );

		/**
		 * Render others boxes have not rendered.
		 */
		//        global $render_boxes;
		//        foreach ( $render_boxes as $key => $box ) {
		//            $this->render_box( $key );
		//        }
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
		$sub_pages['dashboard'] = array(
			'title' => __( 'Dashboard', 'thim-core' ),
			'icon'  => '<svg width="26px" height="25px" viewBox="0 0 26 25" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<g transform="translate(0.500000, 0.000000)" fill="#444444" fill-rule="nonzero">
								<path d="M22.0703,13.4766 L16.4062,13.4766 C14.7908,13.4766 13.4766,14.7908 13.4766,16.4062 L13.4766,22.0703 C13.4766,23.6857 14.7908,25 16.4062,25 L22.0703,25 C23.6857,25 25,23.6857 25,22.0703 L25,16.4062 C25,14.7908 23.6857,13.4766 22.0703,13.4766 Z M23.0469,22.0703 C23.0469,22.6088 22.6088,23.0469 22.0703,23.0469 L16.4062,23.0469 C15.8678,23.0469 15.4297,22.6088 15.4297,22.0703 L15.4297,16.4062 C15.4297,15.8678 15.8678,15.4297 16.4062,15.4297 L22.0703,15.4297 C22.6088,15.4297 23.0469,15.8678 23.0469,16.4062 L23.0469,22.0703 Z M8.59375,13.4766 L2.92969,13.4766 C1.31426,13.4766 0,14.7908 0,16.4062 L0,22.0703 C0,23.6857 1.31426,25 2.92969,25 L8.59375,25 C10.2092,25 11.5234,23.6857 11.5234,22.0703 L11.5234,16.4062 C11.5234,14.7908 10.2092,13.4766 8.59375,13.4766 Z M9.5703,22.0703 C9.5703,22.6088 9.13223,23.0469 8.59375,23.0469 L2.92969,23.0469 C2.39121,23.0469 1.95312,22.6088 1.95312,22.0703 L1.95312,16.4062 C1.95312,15.8678 2.39121,15.4297 2.92969,15.4297 L8.59375,15.4297 C9.13223,15.4297 9.5703,15.8678 9.5703,16.4062 L9.5703,22.0703 Z M8.59375,0 L2.92969,0 C1.31426,0 0,1.31426 0,2.92969 L0,8.59375 C0,10.2092 1.31426,11.5234 2.92969,11.5234 L8.59375,11.5234 C10.2092,11.5234 11.5234,10.2092 11.5234,8.59375 L11.5234,2.92969 C11.5234,1.31426 10.2092,0 8.59375,0 Z M9.5703,8.59375 C9.5703,9.13223 9.13223,9.57031 8.59375,9.57031 L2.92969,9.57031 C2.39121,9.57031 1.95312,9.13223 1.95312,8.59375 L1.95312,2.92969 C1.95312,2.39121 2.39121,1.95312 2.92969,1.95312 L8.59375,1.95312 C9.13223,1.95312 9.5703,2.39121 9.5703,2.92969 L9.5703,8.59375 Z M22.0703,0 L16.4062,0 C14.7908,0 13.4766,1.31426 13.4766,2.92969 L13.4766,8.59375 C13.4766,10.2092 14.7908,11.5234 16.4062,11.5234 L22.0703,11.5234 C23.6857,11.5234 25,10.2092 25,8.59375 L25,2.92969 C25,1.31426 23.6857,0 22.0703,0 Z M23.0469,8.59375 C23.0469,9.13223 22.6088,9.57031 22.0703,9.57031 L16.4062,9.57031 C15.8678,9.57031 15.4297,9.13223 15.4297,8.59375 L15.4297,2.92969 C15.4297,2.39121 15.8678,1.95312 16.4062,1.95312 L22.0703,1.95312 C22.6088,1.95312 23.0469,2.39121 23.0469,2.92969 L23.0469,8.59375 Z"></path>
							</g>
						</g>
					</svg>',
		);

		return $sub_pages;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.9.0
	 */
	public function enqueue_scripts() {
		if ( ! self::is_myself() ) {
			return;
		}
	}
}
