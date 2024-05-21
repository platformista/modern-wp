<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

defined( 'ABSPATH' ) || exit;

class Custom extends Field {

	public $type = 'thim-custom';

	protected $control_class = '\ThimPress\Customizer\Control\Custom';

	protected $control_has_js_template = true;

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = '__return_null';
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'thim-custom';
		}

		return $args;
	}
}
