<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Checkbox_Switch extends Field {

	public $type = 'thim-switch';

	protected $control_class = '\ThimPress\Customizer\Control\Checkbox_Switch';

	protected $control_has_js_template = true;

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = function( $value ) {
					return ( '0' === $value || 'false' === $value ) ? false : (bool) $value;
				};
			}

			$args['default'] = isset( $args['default'] ) ? $args['default'] : false;

			$args['default'] = (bool) ( 1 === $args['default'] || '1' === $args['default'] || true === $args['default'] || 'true' === $args['default'] || 'on' === $args['default'] );
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-switch';
		}

		return $args;
	}
}
