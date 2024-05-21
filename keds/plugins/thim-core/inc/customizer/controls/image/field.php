<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Image extends Field {

	public $type = 'thim-image';

	protected $control_class = '\ThimPress\Customizer\Control\Image';

	protected $control_has_js_template = true;

	protected function init( $args ) {
		add_filter( 'thim_customizer_output_item_args', array( $this, 'output_item_args' ), 10, 4 );
		add_filter( 'thim_customizer_output_control_classnames', array( $this, 'output_control_classnames' ) );
	}

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = function( $value ) {
					if ( isset( $this->args['choices']['save_as'] ) && 'array' === $this->args['choices']['save_as'] ) {
						return array(
							'id'     => ( isset( $value['id'] ) && '' !== $value['id'] ) ? (int) $value['id'] : '',
							'url'    => ( isset( $value['url'] ) && '' !== $value['url'] ) ? esc_url_raw( $value['url'] ) : '',
							'width'  => ( isset( $value['width'] ) && '' !== $value['width'] ) ? (int) $value['width'] : '',
							'height' => ( isset( $value['height'] ) && '' !== $value['height'] ) ? (int) $value['height'] : '',
						);
					}

					if ( isset( $this->args['choices']['save_as'] ) && 'id' === $this->args['choices']['save_as'] ) {
						return absint( $value );
					}

					return ( is_string( $value ) ) ? esc_url_raw( $value ) : $value;
				};
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			$args['button_labels'] = isset( $args['button_labels'] ) ? $args['button_labels'] : array();
			$args['button_labels'] = wp_parse_args(
				$args['button_labels'],
				array(
					'select'       => 'Select image',
					'change'       => 'Change image',
					'default'      => 'Default',
					'remove'       => 'Remove',
					'placeholder'  => 'No image selected',
					'frame_title'  => 'Select image',
					'frame_button' => 'Choose image',
				)
			);

			$args['choices']            = isset( $args['choices'] ) ? (array) $args['choices'] : array();
			$args['choices']['save_as'] = isset( $args['choices']['save_as'] ) ? $args['choices']['save_as'] : 'url';
			$args['choices']['labels']  = isset( $args['choices']['labels'] ) ? $args['choices']['labels'] : array();
			$args['choices']['labels']  = wp_parse_args( $args['choices']['labels'], $args['button_labels'] );

			// Set the control-type.
			$args['type'] = 'thim-image';
		}
		return $args;
	}

	public function output_item_args( $output, $value, $all_outputs, $field ) {
		if ( $field['id'] === $this->args['id'] ) {
			if ( isset( $output['property'] ) && in_array( array( 'background', 'background-image' ), $output['property'], true ) ) {
				if ( ! isset( $output['value_pattern'] ) || empty( $output['value_pattern'] ) || '$' === $output['value_pattern'] ) {
					$output['value_pattern'] = 'url("$")';
				}
			}
		}

		return $output;
	}


	public function output_control_classnames( $classnames ) {
		$classnames['thim-image'] = '\ThimPress\Customizer\CSS\Image';

		return $classnames;
	}
}
