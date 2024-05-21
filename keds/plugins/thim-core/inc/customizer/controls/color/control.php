<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

defined( 'ABSPATH' ) || exit;

class Color extends Base {

	public $type = 'thim-color';

	/**
	 * The color mode.
	 *
	 * Used by 'mode' => 'alpha' argument.
	 *
	 * @access public
	 * @var string
	 */
	public $mode = '';


	public function to_json() {
		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['value'] = empty( $this->value() ) ? '' : ( 'hue' === $this->mode ? absint( $this->value() ) : $this->value() );

		if ( is_string( $this->json['value'] ) ) {
			$this->json['value'] = strtolower( $this->json['value'] );
		}

		$this->json['mode'] = $this->mode;

		$this->json['choices']['labelStyle'] = isset( $this->choices['label_style'] ) ? $this->choices['label_style'] : 'default';

		$this->json['choices']['swatches'] = $this->color_swatches();

		if ( isset( $this->choices['form_component'] ) ) {
			$this->json['choices']['formComponent'] = $this->choices['form_component'];
		}

		$this->remove_unused_json_props();
	}

	public function remove_unused_json_props() {
		if ( isset( $this->json['choices']['label_style'] ) ) {
			unset( $this->json['choices']['label_style'] );
		}

		if ( isset( $this->choices['form_component'] ) ) {
			unset( $this->json['choices']['form_component'] );
		}

		if ( isset( $this->json['choices']['trigger_style'] ) ) {
			unset( $this->json['choices']['trigger_style'] );
		}

		if ( isset( $this->json['choices']['button_text'] ) ) {
			unset( $this->json['choices']['button_text'] );
		}
	}

	public function color_swatches() {
		$default_swatches = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);

		$default_swatches = apply_filters( 'thim_customizer_default_color_swatches', $default_swatches );

		$defined_swatches = isset( $this->choices['swatches'] ) && ! empty( $this->choices['swatches'] ) ? $this->choices['swatches'] : array();

		if ( empty( $defined_swatches ) ) {
			$defined_swatches = isset( $this->choices['palettes'] ) && ! empty( $this->choices['palettes'] ) ? $this->choices['palettes'] : array();
		}

		if ( ! empty( $defined_swatches ) ) {
			$swatches       = $defined_swatches;
			$total_swatches = count( $swatches );

			if ( $total_swatches < 8 ) {
				for ( $i = $total_swatches; $i <= 8; $i++ ) {
					$swatches[] = $total_swatches[ $i ];
				}
			}
		} else {
			$swatches = $default_swatches;
		}

		$swatches = apply_filters( 'thim_customizer_color_swatches', $swatches );

		return $swatches;
	}

	protected function content_template() {}
}
