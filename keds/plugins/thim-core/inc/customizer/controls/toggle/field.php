<?php
namespace ThimPress\Customizer\Field;

class Toggle extends Checkbox_Switch {

	public $type = 'thim-toggle';

	protected $control_class = '\ThimPress\Customizer\Control\Toggle';

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-toggle';
		}

		return $args;
	}
}
