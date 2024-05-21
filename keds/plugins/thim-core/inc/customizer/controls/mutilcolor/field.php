<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Multicolor extends Field {

	public $type = 'thim-multicolor';

	public function init( $args ) {
		add_filter( 'thim_customizer_output_control_classnames', array( $this, 'output_control_classnames' ) );

		$parent_control_args = wp_parse_args(
			array(
				'type'              => 'thim-generic',
				'default'           => '',
				'wrapper_opts'      => array(
					'gap' => 'small',
				),
				'input_attrs'       => '',
				'choices'           => array(
					'type'        => 'hidden',
					'parent_type' => 'thim-multicolor',
				),
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
			),
			$args
		);

		new \ThimPress\Customizer\Field\Generic( $parent_control_args );

		$total_colors = count( $args['choices'] );
		$loop_index   = 0;

		$use_alpha = $this->filter_preferred_choice_setting( 'alpha', null, $args ) ? true : false;
		$swatches  = $this->filter_preferred_choice_setting( 'swatches', null, $args );
		$swatches  = empty( $swatches ) ? $this->filter_preferred_choice_setting( 'palettes', null, $args ) : $swatches;
		$swatches  = empty( $swatches ) ? array() : $swatches;

		if ( empty( $swatches ) ) {
			$swatches = isset( $args['palettes'] ) && ! empty( $args['palettes'] ) ? $args['palettes'] : array();
		}

		foreach ( $args['choices'] as $choice => $choice_label ) {
			$loop_index++;

			$classnames  = isset( $args['wrapper_attrs']['class'] ) ? $args['wrapper_attrs']['class'] . ' thim-group-item' : '{default_class} thim-group-item';
			$classnames .= 1 === $loop_index ? ' thim-group-start' : ( $loop_index === $total_colors ? ' thim-group-end' : $classnames );

			$use_alpha_per_choice = $this->filter_preferred_choice_setting( 'alpha', $choice, $args ) ? true : $use_alpha;
			$swatches_per_choice  = $this->filter_preferred_choice_setting( 'swatches', $choice, $args );
			$swatches_per_choice  = empty( $swatches_per_choice ) ? $this->filter_preferred_choice_setting( 'palettes', $choice, $args ) : $swatches_per_choice;
			$swatches_per_choice  = empty( $swatches_per_choice ) ? $swatches : $swatches_per_choice;

			$control_args = wp_parse_args(
				array(
					'id'             => $args['id'] . '[' . $choice . ']',
					'parent_setting' => $args['id'],
					'label'          => $choice_label,
					'description'    => '',
					'default'        => $this->filter_preferred_choice_setting( 'default', $choice, $args ),
					'wrapper_attrs'  => array(
						'data-thim-parent-control-type' => 'thim-multicolor',
						'class'                         => $classnames,
					),
					'input_attrs'    => $this->filter_preferred_choice_setting( 'input_attrs', $choice, $args ),
					'choices'        => array(
						'alpha'       => $use_alpha_per_choice,
						'label_style' => 'tooltip',
						'swatches'    => $swatches_per_choice,
					),
					'css_vars'       => array(),
					'output'         => array(),
				),
				$args
			);

			foreach ( $control_args['choices'] as $control_choice_id => $control_choice_value ) {
				if ( isset( $control_args[ $control_choice_id ] ) ) {
					unset( $control_args[ $control_choice_id ] );
				} else {
					if ( 'swatches' === $control_choice_id || 'palettes' === $control_choice_id ) {
						if ( isset( $control_args['palettes'] ) ) {
							unset( $control_args['palettes'] );
						}

						if ( isset( $control_args['swatches'] ) ) {
							unset( $control_args['swatches'] );
						}
					}
				}
			}

			new \ThimPress\Customizer\Field\Color( $control_args );
		}
	}

	public function filter_preferred_choice_setting( $setting, $choice, $args ) {
		if ( ! isset( $args[ $setting ] ) ) {
			return '';
		}

		if ( null === $choice ) {
			$per_choice_found = false;

			foreach ( $args['choices'] as $choice_id => $choice_label ) {
				if ( isset( $args[ $setting ][ $choice_id ] ) ) {
					$per_choice_found = true;
					break;
				}
			}

			if ( ! $per_choice_found ) {
				return $args[ $setting ];
			}

			return '';
		}

		if ( isset( $args[ $setting ][ $choice ] ) ) {
			return $args[ $setting ][ $choice ];
		}

		foreach ( $args['choices'] as $id => $set ) {
			if ( $id !== $choice && isset( $args[ $setting ][ $id ] ) ) {
				unset( $args[ $setting ][ $id ] );
			} elseif ( ! isset( $args[ $setting ][ $id ] ) ) {
				$args[ $setting ] = '';
			}
		}

		return $args[ $setting ];
	}

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] !== $this->args['id'] ) {
			return $args;
		}

		if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
			$args['sanitize_callback'] = array( __CLASS__, 'sanitize' );
		}

		return $args;
	}

	public static function sanitize( $value ) {
		foreach ( $value as $key => $subvalue ) {
			$value[ $key ] = \ThimPress\Customizer\Field\Color::sanitize( $subvalue );
		}

		return $value;
	}

	public function add_setting( $wp_customize ) {}

	public function add_control( $wp_customize ) {}

	public function output_control_classnames( $classnames ) {
		$classnames['thim-multicolor'] = '\ThimPress\Customizer\CSS\Multicolor';

		return $classnames;
	}
}
