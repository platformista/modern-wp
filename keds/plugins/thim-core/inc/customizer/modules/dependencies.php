<?php
namespace ThimPress\Customizer\Modules;

class Dependencies {

	private $dependencies = array();

	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'field_dependencies_scripts' ), 100 );
		add_filter( 'thim_customize_field_add_control_args', array( $this, 'field_add_control_args' ) );
	}

	public function field_add_control_args( $args ) {
		if ( isset( $args['active_callback'] ) ) {
			if ( is_array( $args['active_callback'] ) ) {
				if ( ! is_callable( $args['active_callback'] ) ) {
					foreach ( $args['active_callback'] as $key => $val ) {
						if ( is_callable( $val ) ) {
							unset( $args['active_callback'][ $key ] );
						}
					}
					if ( isset( $args['active_callback'][0] ) ) {
						$args['required'] = $args['active_callback'];
					}
				}
			}

			if ( ! empty( $args['required'] ) ) {
				$this->dependencies[ $args['id'] ] = $args['required'];
				$args['active_callback']           = '__return_true';
				return $args;
			}

			if ( '__return_true' === $args['active_callback'] ) {
				return $args;
			}

			if ( ! is_callable( $args['active_callback'] ) ) {
				$args['active_callback'] = '__return_true';
			}
		} else {
			if ( ! empty( $args['required'] ) ) {
				$this->dependencies[ $args['id'] ] = $args['required'];
			}
		}

		return $args;
	}

	public function field_dependencies_scripts() {
		wp_localize_script( 'thim-customizer-control', 'thimControlDependencies', $this->dependencies );
	}
}
