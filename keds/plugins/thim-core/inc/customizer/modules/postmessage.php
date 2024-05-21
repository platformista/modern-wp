<?php
namespace ThimPress\Customizer\Modules;

class Postmessage {

	protected $fields = array();

	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'postmessage_script' ), 100 );
		add_action( 'thim_customize_field_add_setting_args', array( $this, 'field_add_setting_args' ) );
	}

	public function field_add_setting_args( $args ) {
		if ( ! isset( $args['transport'] ) ) {
			return $args;
		}

		$args['transport'] = 'auto' === $args['transport'] ? 'postMessage' : $args['transport'];

		if ( 'postMessage' === $args['transport'] ) {
			$args['js_vars'] = isset( $args['js_vars'] ) ? (array) $args['js_vars'] : array();
			$args['output']  = isset( $args['output'] ) ? (array) $args['output'] : array();
			$js_vars         = $args['js_vars'];

			if ( empty( $args['js_vars'] ) && ! empty( $args['output'] ) ) {
				if ( isset( $args['output']['element'] ) ) {
					_doing_it_wrong( __METHOD__, sprintf( esc_html__( '"output" invalid format in field %s. The "output" argument should be defined as an array of arrays.', 'kirki' ), esc_html( $args['id'] ) ), '3.0.10' );

					$args['output'] = array( $args['output'] );
				}

				foreach ( $args['output'] as $output ) {
					$output['element']  = isset( $output['element'] ) ? $output['element'] : ':root';
					$output['element']  = is_array( $output['element'] ) ? implode( ',', $output['element'] ) : $output['element'];
					$output['function'] = isset( $output['function'] ) ? $output['function'] : 'style';
					$js_vars[]          = $output;
				}
			}

			$args['js_vars'] = $js_vars;
		}

		$this->fields[] = $args;

		return $args;
	}

	public function postmessage_script() {
		$fields = $this->fields;

		$data = array();

		foreach ( $fields as $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['id'] ) ) {
				$data[] = $field;
			}
		}

		wp_localize_script( 'thim-customizer-control', 'thimPostMessageFields', $data );
	}
}
