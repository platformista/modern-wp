<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

defined( 'ABSPATH' ) || exit;

class Color extends Field {

	public $type = 'thim-color';

	protected $control_class = '\ThimPress\Customizer\Control\Color';

	protected $control_has_js_template = true;

	protected function init( $args ) {
		add_filter( 'thim_customizer_output_control_classnames', array( $this, 'output_control_classnames' ) );
	}

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = array( __CLASS__, 'sanitize' );

				if ( isset( $args['mode'] ) && 'hue' === $args['mode'] ) {
					$args['sanitize_callback'] = 'absint';
				}
			}

			if ( isset( $args['output'] ) && ! empty( $args['output'] ) && is_array( $args['output'] ) && ! isset( $args['output']['element'] ) ) {
				foreach ( $args['output'] as $index => $output ) {
					if ( ! isset( $output['property'] ) ) {
						if ( empty( $args['output'][ $index ] ) ) {
							$args['output'][ $index ] = array();
						}

						$args['output'][ $index ]['property'] = 'color';
					}
				}
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-color';
		}

		return $args;
	}

	public static function sanitize( $value ) {
		$sanitized_value = '';

		if ( is_string( $value ) ) {
			$sanitized_value = self::sanitize_color_string( $value );
		} elseif ( is_array( $value ) ) {
			if ( isset( $value['r'] ) || isset( $value['g'] ) || isset( $value['b'] ) ) {
				$sanitized_value = self::sanitize_color_array( $value, 'rgb' );
			} elseif ( isset( $value['h'] ) || isset( $value['s'] ) ) {
				if ( isset( $value['l'] ) ) {
					$sanitized_value = self::sanitize_color_array( $value, 'hsl' );
				} elseif ( isset( $value['v'] ) ) {
					$sanitized_value = self::sanitize_color_array( $value, 'hsv' );
				}
			}
		}

		return $sanitized_value;
	}

	public static function sanitize_color_array( $color, $color_type = 'rgb' ) {
		$keys = array( 'r', 'g', 'b' );
		$mins = array( 0, 0, 0 );
		$maxs = array( 255, 255, 255 );

		if ( 'hsl' === $color_type || 'hsv' === $color_type ) {
			$keys    = array( 'h', 's', '' );
			$keys[2] = isset( $color['v'] ) ? 'v' : 'l';

			$mins = array( 0, 0, 0 );
			$maxs = array( 360, 100, 100 );
		}

		$sanitized_color = array();

		$sanitized_color = array(
			$keys[0] => isset( $color[ $keys[0] ] ) ? absint( $color[ $keys[0] ] ) : $mins[0],
			$keys[1] => isset( $color[ $keys[1] ] ) ? absint( $color[ $keys[1] ] ) : $mins[1],
			$keys[2] => isset( $color[ $keys[2] ] ) ? absint( $color[ $keys[2] ] ) : $mins[2],
		);

		$sanitized_color[ $keys[0] ] = $sanitized_color[ $keys[0] ] < $mins[0] ? $mins[0] : $sanitized_color[ $keys[0] ];
		$sanitized_color[ $keys[0] ] = $sanitized_color[ $keys[0] ] > $maxs[0] ? $maxs[0] : $sanitized_color[ $keys[0] ];

		$sanitized_color[ $keys[1] ] = $sanitized_color[ $keys[1] ] < $mins[1] ? $mins[1] : $sanitized_color[ $keys[1] ];
		$sanitized_color[ $keys[1] ] = $sanitized_color[ $keys[1] ] > $maxs[1] ? $maxs[1] : $sanitized_color[ $keys[1] ];

		$sanitized_color[ $keys[2] ] = $sanitized_color[ $keys[2] ] < $mins[2] ? $mins[2] : $sanitized_color[ $keys[2] ];
		$sanitized_color[ $keys[2] ] = $sanitized_color[ $keys[2] ] > $maxs[2] ? $maxs[2] : $sanitized_color[ $keys[2] ];

		if ( isset( $color['a'] ) ) {
			$sanitized_color['a'] = isset( $color['a'] ) ? filter_var( $color['a'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) : 1;
			$sanitized_color['a'] = $sanitized_color['a'] < 0 ? 0 : $sanitized_color['a'];
			$sanitized_color['a'] = $sanitized_color['a'] > 1 ? 1 : $sanitized_color['a'];
		}

		return $sanitized_color;
	}

	public static function sanitize_color_string( $value ) {
		$value = strtolower( $value );

		$pattern = '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\)|hsva\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|hsv\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';

		preg_match( $pattern, $value, $matches );

		if ( isset( $matches[0] ) ) {
			if ( is_string( $matches[0] ) ) {
				return $matches[0];
			}

			if ( is_array( $matches[0] ) && isset( $matches[0][0] ) ) {
				return $matches[0][0];
			}
		}

		return '';
	}
	public function output_control_classnames( $control_classes ) {
		$control_classes['thim-color'] = '\ThimPress\Customizer\CSS\Color';

		return $control_classes;
	}
}
