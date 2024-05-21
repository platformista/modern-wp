<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

class Select extends Base {

	public $type = 'thim-select';

	public $placeholder = false;

	public $clearable = false;

	public $multiple = false;

	public $max_selection_number = 999;

	public function to_json() {

		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['isClearable'] = $this->clearable;
		$this->json['isMulti']     = $this->multiple;
		$this->json['placeholder'] = ( $this->placeholder ) ? $this->placeholder : 'Select...';

		$this->json['maxSelectionNumber'] = $this->max_selection_number;

		$this->json['messages'] = array(
			'maxLimitReached' => sprintf( 'You can only select %s items', $this->max_selection_number ),
		);
	}
}
