<?php

if ( ! class_exists( 'Thim_Remote_Helper' ) ) {
	/**
	 * Class Thim_Remote_Helper
	 *
	 * @since 1.0.0
	 */
	class Thim_Remote_Helper {
		/**
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private static $tag = 'THIM_CORE_REMOTE';

		/**
		 * Request post.
		 *
		 * @since 1.4.0
		 *
		 * @param       $url
		 * @param array $args
		 * @param bool  $parse_json
		 *
		 * @return WP_Error|mixed
		 */
		public static function post( $url, $args = array(), $parse_json = false ) {
			$defaults = array(
				'method'  => 'POST',
				'headers' => array(
					'User-Agent' => sprintf( 'WordPress - Thim Core %s', THIM_CORE_VERSION ),
				),
				'timeout' => 30,
			);

			$args = wp_parse_args( $args, $defaults );

			$response      = wp_remote_post( $url, $args );
			$response_code = wp_remote_retrieve_response_code( $response );

			if ( $response_code != 200 ) {
				$message = wp_remote_retrieve_response_message( $response );

				return new WP_Error( self::$tag, sprintf( __( 'Request to %1$s failed.<br><pre>%1$s</pre>', 'thim-core' ), $url, $message ) );
			}

			$body = wp_remote_retrieve_body( $response );

			if ( $parse_json ) {
				return json_decode( $body );
			}

			return $body;
		}

		/**
		 * Request get.
		 *
		 * @since 1.1.0
		 *
		 * @param $url
		 * @param $args
		 * @param $parse_json
		 *
		 * @return mixed|WP_Error
		 */
		public static function get( $url, $args = array(), $parse_json = false ) {
			$defaults = array(
				'headers'   => array(
					'User-Agent' => sprintf( 'WordPress - Thim Core %s', THIM_CORE_VERSION ),
				),
				'timeout'   => 30,
			);

			$args = wp_parse_args( $args, $defaults );

			$response      = wp_remote_get( $url, $args );
			$response_code = wp_remote_retrieve_response_code( $response );

			if ( $response_code != 200 ) {
				$message = wp_remote_retrieve_response_message( $response );

				return new WP_Error( self::$tag, sprintf( __( 'Request to %1$s failed.<br><pre>%2$s</pre>', 'thim-core' ), $url, $message ) );
			}

			$body = wp_remote_retrieve_body( $response );

			if ( $parse_json ) {
				return json_decode( $body );
			}

			return $body;
		}

		/**
		 * Download file.
		 *
		 * @since 1.0.0
		 *
		 * @param $url
		 * @param $path
		 *
		 * @return bool|WP_Error
		 */
		public static function download( $url, $path ) {
			$code          = 'tc_remote_download';
			$response      = wp_remote_get( $url );
			$response_code = wp_remote_retrieve_response_code( $response );

			if ( $response_code != 200 ) {
				$message = wp_remote_retrieve_response_message( $response );

				return new WP_Error( $code, "Download failed: <pre>$message</pre>" );
			}

			$body = wp_remote_retrieve_body( $response );

			return Thim_File_Helper::write( $path, $body );
		}
	}
}
