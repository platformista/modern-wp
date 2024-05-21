<?php
namespace ThimPress\Customizer\CSS;

use ThimPress\Customizer\Modules\CSS\Output;

class Image extends Output {

	protected function process_output( $output, $value ) {
		if ( ! isset( $output['element'] ) || ! isset( $output['property'] ) ) {
			return;
		}
		$output = wp_parse_args(
			$output,
			array(
				'media_query' => 'global',
				'prefix'      => '',
				'units'       => '',
				'suffix'      => '',
			)
		);
		if ( is_array( $value ) ) {
			if ( isset( $output['choice'] ) && $output['choice'] ) {
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value[ $output['choice'] ] ) . $output['units'] . $output['suffix'];
				return;
			}
			if ( isset( $value['url'] ) ) {
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value['url'] ) . $output['units'] . $output['suffix'];
				return;
			}
			return;
		}
		$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value ) . $output['units'] . $output['suffix'];
	}
}
