<?php
namespace ThimPress\Customizer\Field;

if ( ! class_exists( '\ThimPress\Customizer\Field\Radio' ) ) {
	require_once THIM_CUSTOMIZER_DIR . '/controls/radio/field.php';
}

class Radio_Image extends Radio {

	public $type = 'thim-radio-image';

	protected $control_class = '\ThimPress\Customizer\Control\Radio_Image';

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-radio-image';
		}
		
		return $args;
	}
}
