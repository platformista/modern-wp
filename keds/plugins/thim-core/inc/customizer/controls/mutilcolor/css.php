<?php
namespace ThimPress\Customizer\CSS;

use ThimPress\Customizer\Modules\CSS\Output;

class Multicolor extends Output {

	protected function process_output( $output, $value ) {
		foreach ( $value as $key => $sub_value ) {
			if ( ! isset( $output['element'] ) ) {
				continue;
			}
			
			if ( isset( $output['choice'] ) && $key !== $output['choice'] ) {
				continue;
			}
			
			$property = ( ! isset( $output['property'] ) || empty( $output['property'] ) ) ? $key : $output['property'];

			if ( ! isset( $output['media_query'] ) || empty( $output['media_query'] ) ) {
				$output['media_query'] = 'global';
			}

			$output['suffix'] = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';

			$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $sub_value . $output['suffix'];
		}
	}
}
