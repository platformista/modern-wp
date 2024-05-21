<?php
namespace ThimPress\Customizer\Modules;

use \ThimPress\Customizer\Modules\Webfonts\Embed as WebfontsEmbed;

class Webfonts {

	public static $fields = array();

	public $fonts = array();

	public function __construct() {
		add_action( 'thim_customizer_field_init', array( $this, 'field_init' ), 10, 2 );
		add_action( 'wp_loaded', array( $this, 'init' ) );
	}

	public function init() {
		if ( is_customize_preview() || is_admin() ) {
			add_action( 'wp_head', array( $this, 'enqueue_google_fonts' ) );
			// add_filter( 'wp_resource_hints', array( $this, 'resource_hints' ), 10, 2 );
		} else {
			new WebfontsEmbed( $this );
		}
	}

	public function resource_hints( $urls, $relation_type ) {
		if ( ! empty( $this->general_google_fonts() ) && 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => '//fonts.googleapis.com',
			);
			$urls[] = array(
				'href' => '//fonts.gstatic.com',
				'crossorigin',
			);
		}

		return $urls;
	}

	public function enqueue_google_fonts() {
		$url = $this->google_fonts_api_v2_link();

		if ( ! empty( $url ) ) {
			echo '<link href="' . esc_url_raw( $url ) . '" rel="stylesheet">';
		}
	}

	public function google_fonts_api_v2_link() {
		$fonts = $this->general_google_fonts();
		$request_url = '';

		if ( ! empty( $fonts ) ) {
			$request_url = 'https://fonts.googleapis.com/css2?display=swap';

			foreach ( $fonts as $family => $variants ) {
				usort(
					$variants,
					function( $a, $b ) {
						$a_is_italic = \strpos( $a, 'italic' ) !== false;
						$b_is_italic = \strpos( $b, 'italic' ) !== false;

						$a = \str_replace( 'italic', '', $a );
						$b = \str_replace( 'italic', '', $b );

						$font_weight_a = empty( $a ) ? '400' : $a;
						$font_weight_b = empty( $b ) ? '400' : $b;

						if ( $a_is_italic && ! $b_is_italic ) {
							return 1;
						}

						if ( ! $a_is_italic && $b_is_italic ) {
							return -1;
						}

						if ( $font_weight_a === $font_weight_b ) {
							return 0;
						}

						return ( $font_weight_a < $font_weight_b ) ? -1 : 1;
					}
				);

				$has_italic               = false;
				$load_additional_variants = false;

				foreach ( $variants as $variant ) {
					if ( 400 !== $variant && 'regular' !== $variant ) {
						$load_additional_variants = true;
					}

					if ( false !== \strpos( $variant, 'italic' ) ) {
						$has_italic = true;
					}
				}

				$url_fragment = '&family=' . rawurlencode( $family );

				// Regular only (no italic).
				if ( ! $has_italic && ! $load_additional_variants ) {
					$request_url .= $url_fragment;
					continue;
				}

				// Regular only (italic).
				if ( $has_italic && ! $load_additional_variants ) {
					$request_url .= "{$url_fragment}:ital@1";
					continue;
				}

				// Additional variants (no italic).
				if ( ! $has_italic && $load_additional_variants ) {
					$request_url .= "{$url_fragment}:wght@" . \implode( ';', array_unique( $variants ) );
					continue;
				}

				// Additional variants (some italic).
				$additional_variants = array_map(
					function( $variant ) {
						$is_italic   = \strpos( $variant, 'italic' ) !== false;
						$font_weight = \str_replace( 'italic', '', $variant );
						$font_weight = empty( $font_weight ) ? '400' : $font_weight;

						return $is_italic ? "1,{$font_weight}" : "0,{$font_weight}";
					},
					$variants
				);

				if ( $has_italic && $load_additional_variants ) {
					$request_url .= "{$url_fragment}:ital,wght@" . \implode( ';', array_unique( $additional_variants ) );
				}
			}
		}

		return $request_url;
	}

	private function general_google_fonts() {
		$fonts = array();

		$google = new \ThimPress\Customizer\Utils\GoogleFonts();

		if ( ! empty( self::$fields ) ) {
			foreach ( self::$fields as $field_id => $field ) {
				$default     = isset( $field['default'] ) ? $field['default'] : '';
				$font_values = get_theme_mod( $field_id, $default );

				if ( ! isset( $font_values['font-family'] ) ) {
					continue;
				}

				if ( ! $google->is_google_font( $font_values['font-family'] ) ) {
					continue;
				}

				$font_values['family-variant'] = ! empty( $font_values['family-variant'] ) ? (array) $font_values['family-variant'] : array( '400' );

				if ( ! empty( $font_values['variant'] ) ) {
					$font_values['family-variant'] = array_merge( $font_values['family-variant'], (array) $font_values['variant'] );
				}

				if ( ! is_array( $font_values ) || ! isset( $font_values['font-family'] ) || ! isset( $fonts[ $font_values['font-family'] ] ) ) {
					$fonts[ $font_values['font-family'] ] = array();
				}

				// Replace 'regular' with '400'.
				$font_values['family-variant'] = ! empty( $font_values['family-variant'] ) ? array_map(
					function( $variant ) {
						$variant = 'regular' === $variant ? '400' : $variant;
						$variant = 'normal' === $variant ? '400' : $variant;

						return $variant;
					},
					(array) $font_values['family-variant']
				) : array();

				$fonts[ $font_values['font-family'] ] = array_merge( $fonts[ $font_values['font-family'] ] ?? array(), (array) $font_values['family-variant'] );
			}
		}

		return $fonts;
	}

	public function field_init( $args, $object ) {
		if ( ! isset( $args['type'] ) && isset( $object->type ) ) {
			$args['type'] = $object->type;
		}

		if ( ! isset( $args['type'] ) || $args['type'] !== 'thim-typography' ) {
			return;
		}

		self::$fields[ $args['id'] ] = $args;
	}
}
