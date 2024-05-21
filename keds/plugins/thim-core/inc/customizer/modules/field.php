<?php
namespace ThimPress\Customizer\Modules;

abstract class Field {

	protected $args;

	protected $control_class;

	protected $settings_class;

	protected $control_has_js_template = false;

	public function __construct( $args ) {

		$this->args = $args;

		if ( ! isset( $this->args['id'] ) ) {
			$this->args['id'] = md5( wp_json_encode( $this->args ) );
		}

		do_action( 'thim_customizer_field_init', $this->args, $this );

		$this->init( $this->args );

		// Register control-type for JS-templating in the customizer.
		add_action( 'customize_register', array( $this, 'register_control_type' ) );

		// Add customizer setting.
		add_action( 'customize_register', array( $this, 'add_setting' ) );

		// Add customizer control.
		add_action( 'customize_register', array( $this, 'add_control' ) );

		// Add default filters. Can be overriden in child classes.
		add_filter( 'thim_customize_field_add_setting_args', array( $this, 'filter_setting_args' ), 10, 2 );
		add_filter( 'thim_customize_field_add_control_args', array( $this, 'filter_control_args' ), 10, 2 );
	}

	/**
	 * Runs in the constructor. Can be used by child-classes to define extra logic.
	 *
	 * @access protected
	 * @since 0.1
	 * @param array $args The field arguments.
	 * @return void
	 */
	protected function init( $args ) {}

	/**
	 * Register the control-type.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function register_control_type( $wp_customize ) {
		if ( $this->control_class ) {
			$wp_customize->register_control_type( $this->control_class );
		}
	}

	/**
	 * Registers the setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $customizer The customizer instance.
	 * @return void
	 */
	public function add_setting( $customizer ) {
		$args = $this->args;

		$args['type'] = isset( $this->type ) ? $this->type : '';

		$args = apply_filters( 'thim_customize_field_add_setting_args', $args, $customizer );

		if ( ! isset( $args['id'] ) || empty( $args['id'] ) ) {
			return;
		}

		$setting_id = $args['id'];

		$args = array(
			'type'                 => isset( $args['option_type'] ) ? $args['option_type'] : 'theme_mod',
			'capability'           => isset( $args['capability'] ) ? $args['capability'] : 'edit_theme_options',
			'theme_supports'       => isset( $args['theme_supports'] ) ? $args['theme_supports'] : '',
			'default'              => isset( $args['default'] ) ? $args['default'] : '',
			'transport'            => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
			'sanitize_callback'    => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : '',
			'sanitize_js_callback' => isset( $args['sanitize_js_callback'] ) ? $args['sanitize_js_callback'] : '',
		);

		$settings_class = $this->settings_class ? $this->settings_class : null;

		if ( $settings_class ) {
			$customizer->add_setting( new $settings_class( $customizer, $setting_id, $args ) );
		} else {
			$customizer->add_setting( $setting_id, $args );
		}
	}

	/**
	 * Registers the control.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_control( $wp_customize ) {
		$control_class = $this->control_class;

		// If no class-name is defined, early exit.
		if ( ! $control_class ) {
			return;
		}

		$args = apply_filters( 'thim_customize_field_add_control_args', $this->args, $wp_customize );

		$wp_customize->add_control( new $control_class( $wp_customize, $this->args['id'], $args ) );
	}

	/**
	 * Filter setting args.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_setting_args( $args, $wp_customize ) {
		return $args;
	}

	/**
	 * Filter control args.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_control_args( $args, $wp_customize ) {
		return $args;
	}
}
