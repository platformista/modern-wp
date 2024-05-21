<?php
namespace ThimPress\Customizer\Field;

class URL extends Text {

	public $type = 'thim-url';

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = 'esc_url_raw';
			}
		}
		
		return $args;
	}
}
