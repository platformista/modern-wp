<?php
namespace ThimPress\Customizer\Modules;

class Panel {

	protected $id;

	protected $args;

	public function __construct( $id, $args ) {
		$this->id   = $id;
		$this->args = $args;

		if ( $this->args ) {
			add_action( 'customize_register', array( $this, 'add_panel' ) );
		}
	}

	public function add_panel( $wp_customize ) {
		$this->args['type'] = isset( $this->args['type'] ) ? $this->args['type'] : 'default';

		$this->args['type'] = false === strpos( $this->args['type'], 'thim-' ) ? 'thim-' . $this->args['type'] : $this->args['type'];
		$this->args['type'] = 'thim-default' === $this->args['type'] ? 'default' : $this->args['type'];

		$wp_customize->add_panel(
			new \WP_Customize_Panel(
				$wp_customize,
				$this->id,
				apply_filters( 'thim_customize_panel_args', $this->args, $this->id )
			)
		);

		do_action( 'thim_customize_panel_added', $this->id, $this->args );
	}

	public function remove() {
		add_action( 'customize_register', array( $this, 'remove_panel' ), 9999 );
	}

	public function remove_panel( $wp_customize ) {
		$wp_customize->remove_panel( $this->id );
	}
}
