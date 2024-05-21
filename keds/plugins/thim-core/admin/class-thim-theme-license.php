<?php

class Thim_Theme_License extends Thim_Admin_Sub_Page {

	public $key_page = 'license';
	/**
	 * Premium themes.
	 *
	 * @since 0.9.0
	 *
	 * @var null
	 */
	private static $themes = null;

	protected function __construct() {
		parent::__construct();
		add_filter( 'thim_dashboard_sub_pages', array( $this, 'add_sub_page' ) );
		$site_key = Thim_Product_Registration::get_site_key();
		if ( ! $site_key ) {
			add_action( 'rest_api_init', array( $this, 'rest_router' ) );
		}
	}

	public function rest_router( $request ) {
		$namespace = 'thim/v1';
		$base      = 'license';

		register_rest_route(
			$namespace,
			'/' . $base . '/activate',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'activate' ),
				'permission_callback' => function () {
					return current_user_can( 'administrator' );
				},
			)
		);
		register_rest_route(
			$namespace,
			'/' . $base . '/update-personal',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_personal' ),
				'permission_callback' => function () {
					return current_user_can( 'administrator' );
				},
			)
		);
		register_rest_route(
			$namespace,
			'/' . $base . '/deactivate',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'deactivate' ),
				'permission_callback' => function () {
					return current_user_can( 'administrator' );
				},
			)
		);
	}

	public function activate( $request ) {
		$purchase_code  = $request['purchase_code'] ? sanitize_text_field( $request['purchase_code'] ) : '';
		$personal_token = $request['personal_token'] ? sanitize_text_field( $request['personal_token'] ) : '';
		$domain         = $request['domain'] ? esc_url_raw( $request['domain'] ) : '';
		$theme          = $request['theme'] ? sanitize_text_field( $request['theme'] ) : '';
		$theme_version  = $request['theme_version'] ? sanitize_text_field( $request['theme_version'] ) : '';
		$user_email     = $request['user_email'] ? sanitize_email( $request['user_email'] ) : '';

		try {
			// Call API to server.
			if ( empty( $purchase_code ) ) {
				throw new \Exception( 'Purchase code is empty.' );
			}

			$api_url = Thim_Admin_Config::get( 'api_thim_market' ) . '/activate/';

			$body_args = array(
				'purchase_code' => $purchase_code,
				'personal_code' => $personal_token,
				'domain'        => $domain,
				'theme'         => $theme,
				'theme_version' => $theme_version,
				'user_email'    => $user_email,
			);

			// Is my theme.
			if ( ! empty( Thim_Free_Theme::get_theme_id() ) ) {
				$body_args['my_theme_id'] = Thim_Free_Theme::get_theme_id();
			}

			$args = array(
				'body'    => $body_args,
				'timeout' => 30,
			);

			$response = wp_remote_post( $api_url, $args );

			if ( is_wp_error( $response ) ) {
				throw new \Exception( $response->get_error_message() );
			}

			$response_code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $response_code ) {
				throw new \Exception( 'Error: ' . wp_remote_retrieve_response_message( $response ) );
			}

			$response_body = wp_remote_retrieve_body( $response );

			$data = json_decode( $response_body, true );

			if ( ! $data ) {
				throw new \Exception( 'Error: ' . wp_remote_retrieve_response_message( $response ) );
			}

			if ( $data['status'] !== 'success' ) {
				throw new \Exception( $data['message'] ?? 'Error: ' . wp_remote_retrieve_response_message( $response ) );
			}

			// Save purchase code to database.
 			self::save_data_by_theme_key('purchase_code', $purchase_code);

			if ( ! empty( $data['data']['site_code'] ) ) {
  				self::save_data_by_theme_key('purchase_token', $data['data']['site_code']);
			}
			// get personal_tockem from database
 			$personal_token = Thim_Product_Registration::get_data_theme_register('personal_token') ? Thim_Product_Registration::get_data_theme_register('personal_token') : $personal_token;
			if ( ! empty( $personal_token ) ) {
				$purchase_codes = Thim_Envato_API::list_all_purchase_codes( $personal_token );

				if ( ! empty( $purchase_codes ) && in_array( $purchase_code, $purchase_codes ) ) {
 					self::save_data_by_theme_key('personal_token', $personal_token);
 				} else {
  					self::save_data_by_theme_key('personal_token', false);
					throw new \Exception( 'Personal token is invalid.');
  				}
			}

			return array(
				'status'  => 'success',
				'message' => 'Theme license activated.',
			);
		}
		catch ( \Throwable $th ) {
			return array(
				'status'  => 'error',
				'message' => $th->getMessage(),
			);
		}
	}

	public function deactivate( $request ) {
		try {
			// Call API to server.
			$api_url = Thim_Admin_Config::get( 'api_thim_market' ) . '/deactivate/';

			$body_args = array(
				'site_code' => Thim_Product_Registration::get_data_theme_register('purchase_token'),
			);

			if ( ! empty( Thim_Free_Theme::get_theme_id() ) ) {
				$body_args['my_theme_id'] = Thim_Free_Theme::get_theme_id();
			}

			$args = array(
				'body'    => $body_args,
				'timeout' => 30,
			);

			$response = wp_remote_post( $api_url, $args );

			if ( is_wp_error( $response ) ) {
				throw new \Exception( $response->get_error_message() );
			}

			$response_code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $response_code ) {
				throw new \Exception( 'Error: ' . wp_remote_retrieve_response_message( $response ) );
			}

			$response_body = wp_remote_retrieve_body( $response );

			$data = json_decode( $response_body, true );

			if ( ! $data ) {
				throw new \Exception( 'Error: ' . wp_remote_retrieve_response_message( $response ) );
			}

			if ( $data['status'] !== 'success' ) {
				if ( ! empty( $data['message'] ) && $data['message'] !== 'Site code is not exist' ) {
					throw new \Exception( $data['message'] );
				}
			}

			// Save purchase code to database.
 			Thim_Product_Registration::destroy_active();
			return array(
				'status'  => 'success',
				'message' => 'Theme license deactivated.',
			);
		}
		catch ( \Throwable $th ) {
			return array(
				'status'  => 'error',
				'message' => $th->getMessage(),
			);
		}
	}

	public function update_personal( $request ) {
		$personal_token = $request['personal_token'] ? sanitize_text_field( $request['personal_token'] ) : '';

		if ( ! empty( $personal_token ) ) {
 			$purchase_codes = Thim_Envato_API::list_all_purchase_codes( $personal_token );
			$purchase_code  = Thim_Product_Registration::get_data_theme_register('purchase_code');
 			if ( ! empty( $purchase_codes ) && in_array( $purchase_code, $purchase_codes ) ) {
 				self::save_data_by_theme_key('personal_token', $personal_token);
			} else {
   				self::save_data_by_theme_key('personal_token', false);
 				return array(
					'status'  => 'error',
					'message' => 'Personal token is invalid.',
				);
			}

			return array(
				'status'  => 'success',
				'message' => 'Personal token updated.',
			);
		}

		return array(
			'status'  => 'error',
			'message' => 'Personal token is empty.',
		);
	}

	public function add_sub_page( $sub_pages ) {

		if ( ! current_user_can( 'administrator' ) ) {
			return $sub_pages;
		}

		$sub_pages['license'] = array(
			'title' => __( 'License', 'thim-core' ),
			'icon' => '<svg width="20" height="25" viewBox="0 0 20 25" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3.81934 10.4687C3.81934 10.8756 4.14914 11.2054 4.55606 11.2054H15.2447C15.6516 11.2054 15.9814 10.8756 15.9814 10.4687C15.9814 10.0618 15.6516 9.73196 15.2447 9.73196H4.55606C4.14914 9.73196 3.81934 10.0618 3.81934 10.4687Z" fill="#444444"/>
							<path d="M4.55606 13.7962H15.2447C15.6516 13.7962 15.9814 13.4664 15.9814 13.0595C15.9814 12.6526 15.6516 12.3228 15.2447 12.3228H4.55606C4.14914 12.3228 3.81934 12.6526 3.81934 13.0595C3.81934 13.4664 4.14914 13.7962 4.55606 13.7962Z" fill="#444444"/>
							<path d="M4.55606 4.95553H8.18574C8.59265 4.95553 8.92246 4.62573 8.92246 4.21881C8.92246 3.81189 8.59265 3.48209 8.18574 3.48209H4.55606C4.14914 3.48209 3.81934 3.81189 3.81934 4.21881C3.81934 4.62573 4.14914 4.95553 4.55606 4.95553Z" fill="#444444"/>
							<path d="M9.73777 19.8403H4.55606C4.14914 19.8403 3.81934 20.1701 3.81934 20.577C3.81934 20.9839 4.14914 21.3138 4.55606 21.3138H9.73777C10.1447 21.3138 10.4745 20.9839 10.4745 20.577C10.4745 20.1701 10.1447 19.8403 9.73777 19.8403Z" fill="#444444"/>
							<path d="M9.73777 17.5596H4.55606C4.14914 17.5596 3.81934 17.8894 3.81934 18.2963C3.81934 18.7032 4.14914 19.033 4.55606 19.033H9.73777C10.1447 19.033 10.4745 18.7032 10.4745 18.2963C10.4745 17.8894 10.1447 17.5596 9.73777 17.5596Z" fill="#444444"/>
							<path d="M19.3614 5.78026L13.797 0.215778C13.6588 0.0776016 13.4714 0 13.2761 0H1.15909C0.75217 0 0.422363 0.329807 0.422363 0.736724V24.2633C0.422363 24.6702 0.75217 25 1.15909 25H18.8405C19.2474 25 19.5772 24.6702 19.5772 24.2633V6.3012C19.5772 6.10581 19.4996 5.91843 19.3614 5.78026ZM13.8491 2.35162L17.2256 5.72819H13.8491V2.35162ZM18.1037 23.5266H1.89581V1.47345H12.3755V6.46492C12.3755 6.87184 12.7054 7.20164 13.1123 7.20164H18.1037V23.5266Z" fill="#444444"/>
							<path d="M13.8692 17.0684C12.5531 17.0684 11.4824 18.1392 11.4824 19.4553C11.4824 20.7714 12.5531 21.8421 13.8692 21.8421C15.1854 21.8421 16.2561 20.7714 16.2561 19.4553C16.2561 18.1392 15.1854 17.0684 13.8692 17.0684ZM13.8692 20.3687C13.3657 20.3687 12.9559 19.959 12.9559 19.4553C12.9559 18.9517 13.3657 18.5419 13.8692 18.5419C14.3728 18.5419 14.7826 18.9517 14.7826 19.4553C14.7826 19.959 14.3728 20.3687 13.8692 20.3687Z" fill="#444444"/>
						</svg>',
		);

		return $sub_pages;
	}

	/**
	 * Save data jey.
	 *
	 * @param $key
	 * @param $value
	 *
	 * @since 1.3.0
	 *
	 */
	public static function save_data_by_theme_key( $key, $value ) {
		Thim_Product_Registration::set_data_by_theme( $key, $value );
	}

}
