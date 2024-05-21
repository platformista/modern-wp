<?php

/**
 * Class Thim_Child_Theme
 *
 * @since 1.0.3
 */
if ( ! class_exists( 'Thim_Child_Theme' ) ) {
	class Thim_Child_Theme {
		/**
		 * @var array
		 * @since 1.2.0
		 */
		private $args = null;

		/**
		 * Thim_Child_Theme constructor.
		 *
		 * @since 1.0.3
		 *
		 * @param $args array
		 */
		public function __construct( $args ) {
			$this->parse( $args );
		}

		/**
		 * Parse arguments.
		 *
		 * @since 1.2.0
		 *
		 * @param $args array
		 */
		private function parse( $args ) {
			$this->args = wp_parse_args( $args, array(
				'name'       => '',
				'slug'       => '',
				'screenshot' => '',
				'source'     => '',
				'version'    => ''
			) );
		}

		/**
		 * Get data.
		 *
		 * @since 1.2.0
		 *
		 * @param $field
		 * @param $default
		 *
		 * @return mixed
		 */
		public function get( $field, $default = false ) {
			if ( ! isset( $this->args[ $field ] ) ) {
				return $default;
			}

			return $this->args[ $field ];
		}

		/**
		 * Get status.
		 *
		 * @since 1.2.0
		 *
		 * @return string
		 */
		public function get_status() {
			$current_child_theme = Thim_Theme_Manager::get_data( 'child_theme' );
			$slug                = $this->get( 'slug' );
			if ( $slug == $current_child_theme ) {
				return 'active';
			}

			$themes = Thim_Theme_Manager::themes_installed();

			foreach ( $themes as $theme ) {
				$stylesheet = $theme->get_stylesheet();

				if ( $slug == $stylesheet ) {
					return 'inactive';
				}
			}

			return 'not_installed';
		}

		/**
		 * Activate theme.
		 *
		 * @since 1.2.0
		 *
		 * @return true|WP_Error
		 */
		public function activate() {
			$slug   = $this->get( 'slug' );
			$status = $this->get_status();
			if ( $status == 'not_installed' ) {
				return new WP_Error( 'thim_child_theme', __( 'This theme have not installed!', 'thim-core' ) );
			}

			$theme = wp_get_theme( $slug );

			if ( is_multisite() ) {
				WP_Theme::network_enable_theme( $slug );
			}

			if ( ! $theme->exists() || ! $theme->is_allowed() ) {
				return new WP_Error( 'thim_core_forbidden', __( 'The requested theme does not exist.', 'thim-core' ) );
			}

			switch_theme( $theme->get_stylesheet() );

			return true;
		}

		/**
		 * Install theme.
		 *
		 * @since 1.2.0
		 *
		 * @return array|WP_Error
		 */
		public function install() {
			$source = $this->get( 'source' );
			$slug   = $this->get( 'slug' );

			if ( empty( $source ) ) {
				return new WP_Error( 'thim_core_wrong', __( 'The source theme is empty.', 'thim-core' ) );
			}

			$status = array(
				'install' => 'theme',
				'slug'    => $slug,
			);

			include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

			$skin     = new WP_Ajax_Upgrader_Skin();
			$upgrader = new Theme_Upgrader( $skin );
			$result   = $upgrader->install( $source );

			$status['messages'] = $skin->get_upgrade_messages();

			if ( is_wp_error( $result ) ) {
				$status = $result;
			} elseif ( is_wp_error( $skin->result ) ) {
				$status = $skin->result;
			} elseif ( $skin->get_errors()->get_error_code() ) {
				$status = $skin->get_errors();
			} elseif ( is_null( $result ) ) {
				global $wp_filesystem;

				$message = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'thim-core' );

				// Pass through the error from WP_Filesystem if one was raised.
				if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
					$message = esc_html( $wp_filesystem->errors->get_error_message() );
				}

				$status = new WP_Error( 'unable_to_connect_to_filesystem', $message );
			}

			return $status;
		}

		/**
		 * To array.
		 *
		 * @since 1.2.0
		 *
		 * @return array
		 */
		public function toArray() {
			$args = $this->args;

			$args['status'] = $this->get_status();

			return $args;
		}
	}
}