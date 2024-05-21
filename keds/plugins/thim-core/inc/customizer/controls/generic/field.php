<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Generic extends Field {

	public $type = 'thim-generic';

	protected $control_class = '\ThimPress\Customizer\Control\Generic';

	protected $control_has_js_template = true;

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = 'wp_kses_post';
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			$args['type'] = 'thim-generic';

			$args['choices']            = isset( $args['choices'] ) ? $args['choices'] : array();
			$args['choices']['element'] = isset( $args['choices']['element'] ) ? $args['choices']['element'] : 'input';
		}

		return $args;
	}
}
