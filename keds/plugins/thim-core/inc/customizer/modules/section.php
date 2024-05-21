<?php
namespace ThimPress\Customizer\Modules;

class Section {

	protected $id;

	protected $args;

	public function __construct( $id, $args ) {
		$this->id   = $id;
		$this->args = $args;

		if ( $this->args ) {
			add_action( 'customize_register', array( $this, 'add_section' ) );
		}
	}

	public function add_section( $wp_customize ) {
		$this->args['type'] = isset( $this->args['type'] ) ? $this->args['type'] : 'default';

		$this->args['type'] = false === strpos( $this->args['type'], 'thim-' ) ? 'thim-' . $this->args['type'] : $this->args['type'];

		$wp_customize->add_section(
			new \WP_Customize_Section(
				$wp_customize,
				$this->id,
				apply_filters( 'thim_customize_section_args', $this->args, $this->id )
			)
		);

		do_action( 'thim_customize_section_added', $this->id, $this->args );
	}

	public function remove() {
		add_action( 'customize_register', array( $this, 'remove_section' ), 9999 );
	}

	public function remove_section( $wp_customize ) {
		$wp_customize->remove_section( $this->id );
	}
}
