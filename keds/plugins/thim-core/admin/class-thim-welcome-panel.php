<?php

/**
 * Class Thim_Welcome_Panel.
 *
 * @since 1.2.0
 */
class Thim_Welcome_Panel extends Thim_Singleton {

	/**
	 * Thim_Welcome_Panel constructor.
	 *
	 * @since 1.2.0
	 */
	protected function __construct() {
		$this->hooks();
	}

	/**
	 * Add hooks.
	 *
	 * @since 1.0.0
	 */
	private function hooks() {
		add_action( 'admin_init', function () {
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
		} );
		add_action( 'welcome_panel', array( $this, 'welcome_panel_template' ) );
	}

	/**
	 * Template welcome panel.
	 *
	 * @since 1.0.0
	 */
	public function welcome_panel_template() {
		$args = $this->get_args_welcome_template();

		return Thim_Template_Helper::template( 'welcome-panel.php', $args, true );
	}

	/**
	 * Get arguments welcome template.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	private function get_args_welcome_template() {
		$links = Thim_Theme_Manager::get_data( 'links' );
		return array(
			'data'  => $this->get_data_panel_remote(),
			'links' => $links,
		);
	}

	/**
	 * Get data welcome panel.
	 *
	 * @since 1.3.0
	 *
	 * @return bool|mixed
	 */
	private function get_data_panel_remote() {
		$data = get_transient( 'thim_core_welcome_panel_data' );
 		if ( ! $data ) {
			$data = $this->fetch_data_panel_remote();

			if ( $data ) {
				set_transient( 'thim_core_welcome_panel_data', $data, DAY_IN_SECONDS );
			}
		}

		return $data;
	}

	/**
	 * Get data remote.
	 *
	 * @since 1.3.0
	 *
	 * @return false|array
	 */
	private function fetch_data_panel_remote() {
		$link = Thim_Admin_Config::get( 'welcome_panel_remote' );

		if ( empty( $link ) ) {
			return false;
		}

		$link     = add_query_arg( 'random', time(), $link );
		$response = Thim_Remote_Helper::get( $link, array(), true );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		return (array) $response;
	}
}
