<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Select extends Field {

	public $type = 'thim-select';

	protected $multiple = false;

	protected $max_selection_number = 999;

	protected $placeholder = false;

	protected $control_class = '\ThimPress\Customizer\Control\Select';

	protected $control_has_js_template = true;

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( isset( $args['multiple'] ) && $args['multiple'] ) {
				$multiple_and_max             = self::get_multiple_and_max( $args['multiple'] );
				$args['multiple']             = $multiple_and_max['multiple'];
				$args['max_selection_number'] = $multiple_and_max['max_selection_number'];
			} else {
				$args['multiple'] = false;
			}

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = ! $args['multiple'] ? 'sanitize_text_field' : function( $values ) use ( $args ) {
					$values           = (array) $values;
					$sanitized_values = array();

					// If total selected values > max_selection_number, then we need to remove the excess.
					if ( count( $values ) > $args['max_selection_number'] ) {
						for ( $i = 0; $i < $args['max_selection_number']; $i++ ) {
							$sanitized_values[ $i ] = isset( $values[ $i ] ) ? sanitize_text_field( $values[ $i ] ) : '';
						}
					} else {
						foreach ( $values as $index => $subvalue ) {
							$sanitized_values[ $index ] = sanitize_text_field( $subvalue );
						}
					}

					return $sanitized_values;
				};
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			if ( isset( $args['multiple'] ) && $args['multiple'] ) {
				$multiple_and_max             = self::get_multiple_and_max( $args['multiple'] );
				$args['multiple']             = $multiple_and_max['multiple'];
				$args['max_selection_number'] = $multiple_and_max['max_selection_number'];
			}

			$args['type'] = 'thim-select';
		}

		return $args;
	}

	public static function get_multiple_and_max( $multiple ) {
		$max_selection_number = 999;

		if ( is_numeric( $multiple ) ) {
			$multiple = (int) $multiple;

			if ( 0 >= $multiple ) {
				$max_selection_number = 999;
				$multiple             = true;
			} else {
				if ( 1 < $multiple ) {
					$max_selection_number = $multiple;
					$multiple             = true;
				} else {
					$multiple = false;
				}
			}
		}

		return array(
			'multiple'             => $multiple,
			'max_selection_number' => $max_selection_number,
		);
	}
}
