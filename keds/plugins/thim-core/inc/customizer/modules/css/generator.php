<?php
namespace ThimPress\Customizer\Modules\CSS;

defined( 'ABSPATH' ) || exit;

final class Generator {

	public static $instance = null;

	public static $settings = null;

	public static $output = [];

	public static $callback = null;

	public static $option_name = null;

	public static $field_type = null;

	public static $google_fonts = null;

	public static $css;

	public static $value = null;

	private function __construct() {
		$googlefonts = new \ThimPress\Customizer\Utils\GoogleFonts();
		
		if ( is_null( self::$google_fonts ) ) {
			self::$google_fonts = $googlefonts->get_google_fonts();
		}
	}

	public static function css( $field ) {
		self::$settings   = $field['id'];
		self::$callback   = isset( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : '';
		self::$field_type = $field['type'];
		self::$field_type = ( isset( $field['choices'] ) && isset( $field['choices']['parent_type'] ) ) ? $field['choices']['parent_type'] : self::$field_type;
		self::$output     = $field['output'];

		$field['thim_config'] = isset( $field['thim_config'] ) ? $field['thim_config'] : 'global';

		if ( ! is_array( self::$output ) ) {
			self::$output = [
				[
					'element'           => self::$output,
					'sanitize_callback' => null,
				],
			];
		}

		$option_type  = ( isset( $field['option_type'] ) ) ? $field['option_type'] : 'theme_mod';
		$default      = ( isset( $field['default'] ) ) ? $field['default'] : '';
		$setting_name = $field['id'];

		if ( 'option' === $option_type ) {
			if ( ! empty( $field['option_name'] ) && 0 !== stripos( $setting_name, $field['option_name'] . '[' ) ) {
				$setting_name = $field['option_name'] . '[' . $field['id'] . ']';
			}
		}

		self::$value = apply_filters( 'thim_get_value', get_theme_mod( $field['id'], $default ), $setting_name, $default, $option_type );

		$classname            = '\ThimPress\Customizer\Modules\CSS\Output';
		$field_output_classes = apply_filters( 'thim_customizer_output_control_classnames', [] );
		$field_output_classes = apply_filters( "thim_customizer_{$field['thim_config']}_output_control_classnames", $field_output_classes );

		if ( array_key_exists( self::$field_type, $field_output_classes ) ) {
			$classname = $field_output_classes[ self::$field_type ];
		}

		$obj = new $classname( $field['thim_config'], self::$output, self::$value, $field );

		return $obj->get_styles();
	}

	public static function styles_parse( $css = [] ) {
		$css = apply_filters( 'thim_customizer_styles_array', $css );

		$final_css = '';

		if ( ! is_array( $css ) || empty( $css ) ) {
			return '';
		}

		foreach ( $css as $media_query => $styles ) {
			$final_css .= ( 'global' !== $media_query ) ? $media_query . '{' : '';
			foreach ( $styles as $style => $style_array ) {
				$css_for_style = '';

				foreach ( $style_array as $property => $value ) {
					if ( is_string( $value ) && '' !== $value ) {
						$css_for_style .= $property . ':' . $value . ';';
					} elseif ( is_array( $value ) ) {
						foreach ( $value as $subvalue ) {
							if ( is_string( $subvalue ) && '' !== $subvalue ) {
								$css_for_style .= $property . ':' . $subvalue . ';';
							}
						}
					}
					$value = ( is_string( $value ) ) ? $value : '';
				}

				if ( '' !== $css_for_style ) {
					$final_css .= $style . '{' . $css_for_style . '}';
				}
			}

			$final_css .= ( 'global' !== $media_query ) ? '}' : '';
		}

		return $final_css;
	}

	public static function add_prefixes( $css ) {
		if ( is_array( $css ) ) {
			foreach ( $css as $media_query => $elements ) {
				foreach ( $elements as $element => $style_array ) {
					foreach ( $style_array as $property => $value ) {

						// Add -webkit-* and -moz-*.
						if ( is_string( $property ) && in_array(
							$property,
							[
								'border-radius',
								'box-shadow',
								'box-sizing',
								'text-shadow',
								'transform',
								'background-size',
								'transition',
								'transition-property',
							],
							true
						) ) {
							unset( $css[ $media_query ][ $element ][ $property ] );
							$css[ $media_query ][ $element ][ '-webkit-' . $property ] = $value;
							$css[ $media_query ][ $element ][ '-moz-' . $property ]    = $value;
							$css[ $media_query ][ $element ][ $property ]              = $value;
						}

						// Add -ms-* and -o-*.
						if ( is_string( $property ) && in_array(
							$property,
							[
								'transform',
								'background-size',
								'transition',
								'transition-property',
							],
							true
						) ) {
							unset( $css[ $media_query ][ $element ][ $property ] );
							$css[ $media_query ][ $element ][ '-ms-' . $property ] = $value;
							$css[ $media_query ][ $element ][ '-o-' . $property ]  = $value;
							$css[ $media_query ][ $element ][ $property ]          = $value;
						}
					}
				}
			}
		}
		return $css;
	}

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
