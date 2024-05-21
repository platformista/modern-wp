<?php
namespace ThimPress\Customizer\Modules\CSS\Property;

use ThimPress\Customizer\Modules\CSS\Property;

class Fontfamily extends Property {

	protected function process_value() {
		$family = $this->value;

		if ( ! is_string( $family ) ) {
			return;
		}

		$family = str_replace( '&quot;', '"', $family );

		if ( false !== strpos( $family, ' ' ) && false === strpos( $family, '"' ) ) {
			$this->value = '"' . $family . '"';
		}

		$this->value = html_entity_decode( $family, ENT_QUOTES );
	}
}
