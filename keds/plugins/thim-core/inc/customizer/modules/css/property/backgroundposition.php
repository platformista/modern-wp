<?php
namespace ThimPress\Customizer\Modules\CSS\Property;

use ThimPress\Customizer\Modules\CSS\Property;

class Backgroundposition extends Property {

	protected function process_value() {
		$this->value = trim( $this->value );

		if ( false !== strpos( $this->value, 'calc' ) ) {
			return;
		}

		if ( 'initial' === $this->value || 'inherit' === $this->value ) {
			return;
		}

		$x_dimensions = [ 'left', 'center', 'right' ];
		$y_dimensions = [ 'top', 'center', 'bottom' ];

		if ( false !== strpos( $this->value, ' ' ) ) {
			$xy = explode( ' ', $this->value );

			$x = trim( $xy[0] );
			$y = trim( $xy[1] );

			if ( ! in_array( $x, $x_dimensions, true ) ) {
				$x = sanitize_text_field( $x );
			}
			if ( ! in_array( $y, $y_dimensions, true ) ) {
				$y = sanitize_text_field( $y );
			}
			$this->value = $x . ' ' . $y;
			return;
		}

		$x = 'center';

		foreach ( $x_dimensions as $x_dimension ) {
			if ( false !== strpos( $this->value, $x_dimension ) ) {
				$x = $x_dimension;
			}
		}

		$y = 'center';

		foreach ( $y_dimensions as $y_dimension ) {
			if ( false !== strpos( $this->value, $y_dimension ) ) {
				$y = $y_dimension;
			}
		}

		$this->value = $x . ' ' . $y;
	}
}
