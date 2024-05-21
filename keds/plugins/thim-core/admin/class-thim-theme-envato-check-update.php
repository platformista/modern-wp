<?php

/**
 * Class Thim_Theme_Check_Update
 *
 * @since 1.1.0
 */
class Thim_Theme_Envato_Check_Update {
	/**
	 * Personal token by ThimPress.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	private $token = null;

	/**
	 * Item id on themeforest.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	private $item_id = null;

	/**
	 * Theme current version.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	private $local_version = null;

	/**
	 * Theme data.
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 */
	private $theme_data = null;

	/**
	 * Thim_Theme_Check_Update constructor.
	 *
	 * @since 1.1.0
	 *
	 * @param $item_id string
	 * @param $local_version string
	 */
	public function __construct( $item_id, $local_version ) {
		$this->item_id       = $item_id;
		$this->local_version = $local_version;
		$this->token         = Thim_Admin_Config::get( 'personal_token' );
	}

	/**
	 * Check theme update by item id.
	 *
	 * @since 1.1.0
	 *
	 * @return bool
	 */
	public function can_update() {
		$remote_version = $this->get_remote_version();
		if ( ! $remote_version ) {
			return false;
		}

		$local_version = $this->local_version;

		return version_compare( $remote_version, $local_version, '>' );
	}

	/**
	 * Get remote version.
	 *
	 * @since 1.1.0
	 *
	 * @return false|string
	 */
	public function get_remote_version() {
		$data = $this->get_theme_data();
		if ( ! $data ) {
			return false;
		}

		return $data['version'];
	}

	/**
	 * Get theme data.
	 *
	 * @since 1.1.0
	 *
	 * @return false|array
	 */
	public function get_theme_data() {
		if ( $this->theme_data === null ) {
			$this->theme_data = $this->get_theme_data_remote();
		}

		return $this->theme_data;
	}

	/**
	 * Get theme data form api.
	 *
	 * @since 1.1.0
	 *
	 * @return false|array
	 */
	private function get_theme_data_remote() {
		$data = Thim_Envato_API::get_theme_metadata( $this->item_id, $this->token );

		if ( is_wp_error( $data ) ) {
			return false;
		}

		return $data;
	}
}
