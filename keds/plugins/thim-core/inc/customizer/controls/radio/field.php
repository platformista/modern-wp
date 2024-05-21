<?php 
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Radio extends Field {

	public $type = 'thim-radio';

	protected $control_class = '\ThimPress\Customizer\Control\Radio';

	protected $control_has_js_template = true;

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = function( $value ) {
					if ( ! isset( $this->args['choices'][ $value ] ) ) {
						return ( isset( $this->args['default'] ) ) ? $this->args['default'] : '';
					}

					return $value;
				};
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-radio';
		}

		return $args;
	}
}
