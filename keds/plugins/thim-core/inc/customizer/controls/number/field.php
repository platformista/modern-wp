<?php
namespace ThimPress\Customizer\Field;

class Number extends Generic {

	public $type = 'thim-number';

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] !== $this->args['id'] ) {
			return $args;
		}

		if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
			$args['sanitize_callback'] = function( $value ) use ( $args ) {
				$value = filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

				if ( isset( $args['choices'] ) && isset( $args['choices']['min'] ) && isset( $args['choices']['max'] ) ) {
					$min = filter_var( $args['choices']['min'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$max = filter_var( $args['choices']['max'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

					if ( $value < $min ) {
						$value = $min;
					} elseif ( $value > $max ) {
						$value = $max;
					}
				}

				return $value;
			};
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			$args['type'] = 'thim-generic';

			$args['choices']            = isset( $args['choices'] ) ? $args['choices'] : array();
			$args['choices']['element'] = 'input';
			$args['choices']['type']    = 'number';
			$args['choices']            = wp_parse_args(
				$args['choices'],
				array(
					'min'  => -999999999,
					'max'  => 999999999,
					'step' => 1,
				)
			);

			$args['choices']['min']  = filter_var( $args['choices']['min'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			$args['choices']['max']  = filter_var( $args['choices']['max'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			$args['choices']['step'] = filter_var( $args['choices']['step'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		}

		return $args;
	}
}
