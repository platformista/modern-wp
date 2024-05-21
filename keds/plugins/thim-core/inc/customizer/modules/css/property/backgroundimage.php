<?php
namespace ThimPress\Customizer\Modules\CSS\Property;

use ThimPress\Customizer\Modules\CSS\Property;

class Backgroundimage extends Property {

	protected function process_value() {
		if ( is_array( $this->value ) && isset( $this->value['url'] ) ) {
			$this->value = $this->value['url'];
		}
		if ( false === strpos( $this->value, 'gradient' ) && false === strpos( $this->value, 'url(' ) ) {
			if ( empty( $this->value ) ) {
				return;
			}
			if ( preg_match( '/^\d+$/', $this->value ) ) {
				$this->value = 'url("' . set_url_scheme( wp_get_attachment_url( $this->value ) ) . '")';
			} else {
				$this->value = 'url("' . set_url_scheme( $this->value ) . '")';
			}
		}
	}
}
