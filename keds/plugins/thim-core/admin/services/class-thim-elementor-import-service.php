<?php
class Thim_Elementor_Import_Service {

	protected $extensions = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
		'webp'         => 'image/webp',
		'svg'          => 'image/svg+xml',
	);

	private $meta_key = '_elementor_data';

	private $value = null;

	private $import_url = null;

	public function __construct( $unfiltered_value, $site_url ) {
		$this->value      = $unfiltered_value;
		$this->import_url = $site_url;
	}

	public function filter_meta() {
		add_filter( 'sanitize_post_meta_' . $this->meta_key, array( $this, 'allow_escaped_json_meta' ), 10, 3 );
	}

	public function allow_escaped_json_meta( $val, $key, $type ) {
		if ( empty( $this->value ) ) {
			return $val;
		}

		$this->value = $this->replace_image_urls( $this->value );
		$this->replace_link_urls();

		return $this->value;
	}

	private function replace_link_urls() {
		$decoded_meta = json_decode( $this->value, true );
		if ( ! is_array( $decoded_meta ) ) {
			return;
		}

		$site_url  = get_site_url();
		$url_parts = parse_url( $site_url );

		array_walk_recursive(
			$decoded_meta,
			function ( &$value, $key ) use ( $site_url, $url_parts ) {
				if ( filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
					return;
				}

				$url = parse_url( $value );

				if ( ! isset( $url['host'] ) || ! isset( $url_parts['host'] ) ) {
					return;
				}

				if ( $url['host'] !== $url_parts['host'] ) {
					$value = str_replace( $this->import_url, $site_url, $value );
				}
			}
		);

		$this->value = json_encode( $decoded_meta );
	}

	public function replace_image_urls( $markup ) {
		// Get all slashed and un-slashed urls.
		$old_urls = $this->get_urls_to_replace( $markup );
		if ( ! is_array( $old_urls ) || empty( $old_urls ) ) {
			return $markup;
		}

		// Create an associative array.
		$urls = array_combine( $old_urls, $old_urls );
		// Unslash values of associative array.
		$urls = array_map( 'wp_unslash', $urls );
		// Remap host and directory path.
		$urls = array_map( array( $this, 'remap_host' ), $urls );
		// Replace image urls in meta.
		$markup = str_replace( array_keys( $urls ), array_values( $urls ), $markup );

		return $markup;
	}

	private function get_urls_to_replace( $markup ) {
		$regex = '/(?:http(?:s?):)(?:[\/\\\\\\\\|.|\w|\s|-])*\.(?:' . implode( '|', array_keys( $this->extensions ) ) . ')/m';

		if ( ! is_string( $markup ) ) {
			return array();
		}

		preg_match_all( $regex, $markup, $urls );

		$urls = array_map(
			function ( $value ) {
				return rtrim( html_entity_decode( $value ), '\\' );
			},
			$urls[0]
		);

		$urls = array_unique( $urls );

		return array_values( $urls );
	}

	private function remap_host( $url ) {
		if ( ! strpos( $url, '/uploads/' ) ) {
			return $url;
		}
		$old_url   = $url;
		$url_parts = parse_url( $url );

		if ( ! isset( $url_parts['host'] ) ) {
			return $url;
		}
		$url_parts['path'] = preg_split( '/\//', $url_parts['path'] );
		$url_parts['path'] = array_slice( $url_parts['path'], - 3 );

		$uploads_dir = wp_get_upload_dir();
		$uploads_url = $uploads_dir['baseurl'];

		$new_url = esc_url( $uploads_url . '/' . join( '/', $url_parts['path'] ) );

		return str_replace( $old_url, $new_url, $url );
	}
}
