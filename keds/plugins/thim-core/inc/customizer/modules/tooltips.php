<?php
namespace ThimPress\Customizer\Modules;

class Tooltips {

	private $tooltips_content = array();

	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'tooltips_scripts' ), 100 );
		add_filter( 'thim_customize_field_add_control_args', array( $this, 'filter_control_args' ), 10, 2 );
	}

	public function tooltips_scripts() {
		wp_localize_script( 'thim-customizer-control', 'thimCustomizerTooltips', $this->tooltips_content );
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( ! empty( $args['tooltip'] ) ) {
			$this->tooltips_content[ $args['id'] ] = array(
				'id'      => sanitize_key( $args['id'] ),
				'content' => wp_kses_post( $args['tooltip'] ),
			);
		}

		return $args;
	}
}
