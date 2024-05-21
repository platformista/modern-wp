<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

class Slider extends Base {

	public $type = 'thim-slider';

	public function to_json() {
		parent::to_json();

		$this->json['choices'] = wp_parse_args(
			$this->json['choices'],
			array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			)
		);

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['choices']['min']  = (float) $this->json['choices']['min'];
		$this->json['choices']['max']  = (float) $this->json['choices']['max'];
		$this->json['choices']['step'] = (float) $this->json['choices']['step'];

		$this->json['value'] = $this->json['value'] < $this->json['choices']['min'] ? $this->json['choices']['min'] : $this->json['value'];
		$this->json['value'] = $this->json['value'] > $this->json['choices']['max'] ? $this->json['choices']['max'] : $this->json['value'];
		$this->json['value'] = (float) $this->json['value'];

	}

	protected function content_template() {}
}
