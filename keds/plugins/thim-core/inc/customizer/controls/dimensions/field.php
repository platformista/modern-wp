<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Dimensions extends Field {

	public $type = 'thim-dimensions';

	public function init( $args = array() ) {
		$args['required'] = isset( $args['required'] ) ? (array) $args['required'] : array();

		$labels = array(
			'left-top'       => 'Left Top',
			'left-center'    => 'Left Center',
			'left-bottom'    => 'Left Bottom',
			'right-top'      => 'Right Top',
			'right-center'   => 'Right Center',
			'right-bottom'   => 'Right Bottom',
			'center-top'     => 'Center Top',
			'center-center'  => 'Center Center',
			'center-bottom'  => 'Center Bottom',
			'font-size'      => 'Font Size',
			'font-weight'    => 'Font Weight',
			'line-height'    => 'Line Height',
			'font-style'     => 'Font Style',
			'letter-spacing' => 'Letter Spacing',
			'word-spacing'   => 'Word Spacing',
			'top'            => 'Top',
			'bottom'         => 'Bottom',
			'left'           => 'Left',
			'right'          => 'Right',
			'center'         => 'Center',
			'size'           => 'Size',
			'spacing'        => 'Spacing',
			'width'          => 'Width',
			'height'         => 'Height',
			'invalid-value'  => 'Invalid Value',
		);

		new \ThimPress\Customizer\Field\Generic(
			wp_parse_args(
				array(
					'type'              => 'thim-generic',
					'default'           => '',
					'wrapper_opts'      => array(
						'gap' => 'small',
					),
					'sanitize_callback' => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : array( __CLASS__, 'sanitize' ),
					'choices'           => array(
						'type'        => 'hidden',
						'parent_type' => 'thim-dimensions',
					),
				),
				$args
			)
		);

		$args['choices']           = isset( $args['choices'] ) ? $args['choices'] : array();
		$args['choices']['labels'] = isset( $args['choices']['labels'] ) ? $args['choices']['labels'] : array();

		if ( isset( $args['transport'] ) && 'auto' === $args['transport'] ) {
			$args['transport'] = 'postMessage';
		}

		$total_items = count( $args['default'] );
		$item_count  = 0;

		$width = 100;

		$break_indexes = array();

		if ( 2 === $total_items ) {
			$width = 50;
		} elseif ( 3 === $total_items ) {
			$width = 33;
		} elseif ( 4 === $total_items ) {
			$width = 25;
		} elseif ( 5 === $total_items ) {
			array_push( $break_indexes, 3 );
			$width = 33;
		} elseif ( 6 === $total_items ) {
			array_push( $break_indexes, 3 );
			$width = 33;
		} elseif ( 7 === $total_items || 8 === $total_items ) {
			array_push( $break_indexes, 4 );
			$width = 25;
		} elseif ( 9 === $total_items ) {
			array_push( $break_indexes, 3, 6 );
			$width = 33;
		} elseif ( $total_items > 9 ) {
			array_push( $break_indexes, 4, 8 );
			$width = 25;
		}

		foreach ( $args['default'] as $choice => $default ) {
			$item_count++;

			$label = $choice;
			$label = isset( $labels[ $choice ] ) ? $labels[ $choice ] : $label;
			$label = isset( $args['choices']['labels'][ $choice ] ) ? $args['choices']['labels'][ $choice ] : $label;

			$wrapper_attrs = array(
				'data-thim-parent-control-type'    => 'thim-dimensions',
				'data-thim-parent-control-setting' => $args['id'],
				'class'                            => isset( $args['wrapper_attrs']['class'] ) ? $args['wrapper_attrs']['class'] . ' thim-group-item thim-w' . $width : '{default_class} thim-group-item thim-w' . $width,
			);

			if ( $item_count === 1 ) {
				$wrapper_attrs['class'] .= ' thim-group-start';
			}

			if ( in_array( $item_count, $break_indexes, true ) ) {
				$wrapper_attrs['class'] .= ' thim-group-break';
			}

			if ( $item_count === $total_items ) {
				$wrapper_attrs['class'] .= ' thim-group-end';
			}

			new \ThimPress\Customizer\Field\Dimension(
				wp_parse_args(
					array(
						'type'           => 'thim-dimension',
						'id'             => $args['id'] . '[' . $choice . ']',
						'parent_setting' => $args['id'],
						'label'          => $label,
						'default'        => $default,
						'wrapper_attrs'  => $wrapper_attrs,
						'choices'        => array(
							'label_position' => 'bottom',
						),
						'js_vars'        => array(),
						'css_vars'       => array(),
						'output'         => array(),
					),
					$args
				)
			);
		}
	}

	public static function sanitize( $value ) {
		if ( ! is_array( $value ) ) {
			return array();
		}

		foreach ( $value as $key => $val ) {
			$value[ $key ] = sanitize_text_field( $val );
		}

		return $value;
	}

	public function add_setting( $wp_customize ) {}

	public function add_control( $wp_customize ) {}
}
