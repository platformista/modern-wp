<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Notice extends Field {

	public $type = 'thim-notice';

	protected $control_class = '\ThimPress\Customizer\Control\Notice';

	protected $control_has_js_template = true;

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-notice';
		}

		return $args;
	}
}
