<?php
namespace ThimPress\Customizer\Modules;

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	require_once ABSPATH . WPINC . '/class-wp-customize-control.php';
}

class Base extends \WP_Customize_Control {

	public $output = array();

	public $option_type = 'theme_mod';

	public $option_name = false;

	public $thim_config = 'global';

	public $preset = array();

	public $css_vars = '';

	public $parent_setting;

	public $wrapper_attrs = array();

	public $wrapper_atts = array();

	public $wrapper_opts = array();

	public function script_dependencies() {
		return array();
	}

	public function enqueue() {
		$script_info = include THIM_CUSTOMIZER_DIR . '/build/customizer.asset.php';

		wp_enqueue_script( 'thim-customizer-control', THIM_CUSTOMIZER_URI . '/build/customizer.js', array_merge( $script_info['dependencies'], array( 'jquery-ui-sortable', 'jquery', 'customize-base', 'customize-controls' ) ), $script_info['version'], true );
		wp_enqueue_style( 'thim-customizer-control', THIM_CUSTOMIZER_URI . '/build/customizer.css', array( 'wp-components' ), $script_info['version'] );
	}

	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-thim-customizer customize-control-' . $this->type;
		$gap   = isset( $this->wrapper_opts['gap'] ) ? $this->wrapper_opts['gap'] : 'default';
		$tag   = isset( $this->wrapper_opts['tag'] ) ? $this->wrapper_opts['tag'] : 'li';

		switch ( $gap ) {
			case 'small':
				$class .= ' customize-control-has-small-gap';
				break;

			case 'none':
				$class .= ' customize-control-is-gapless';
				break;

			default:
				break;
		}

		if ( empty( $this->wrapper_attrs ) && ! empty( $this->wrapper_atts ) ) {
			$this->wrapper_attrs = $this->wrapper_atts;
		}

		if ( isset( $this->wrapper_attrs['id'] ) ) {
			$id = $this->wrapper_attrs['id'];
		}

		if ( ! isset( $this->wrapper_attrs['data-thim-customizer-setting'] ) ) {
			$this->wrapper_attrs['data-thim-customizer-setting'] = $this->id;
		}

		if ( ! isset( $this->wrapper_attrs['data-thim-customizer-setting-link'] ) ) {
			if ( isset( $this->settings['default'] ) ) {
				$this->wrapper_attrs['data-thim-customizer-setting-link'] = $this->settings['default']->id;
			}
		}

		$data_attrs = '';

		foreach ( $this->wrapper_attrs as $attr_key => $attr_value ) {
			if ( 0 === strpos( $attr_key, 'data-' ) ) {
				$data_attrs .= ' ' . esc_attr( $attr_key ) . '="' . esc_attr( $attr_value ) . '"';
			}
		}

		if ( isset( $this->wrapper_attrs['class'] ) ) {
			$class = str_ireplace( '{default_class}', $class, $this->wrapper_attrs['class'] );
		}

		printf( '<' . esc_attr( $tag ) . ' id="%s" class="%s"%s>', esc_attr( $id ), esc_attr( $class ), $data_attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$this->render_content();
		echo '</' . esc_attr( $tag ) . '>';
	}

	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;

		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		// Output.
		$this->json['output'] = $this->output;

		// Value.
		$this->json['value'] = $this->value();

		// Choices.
		$this->json['choices'] = $this->choices;

		// The link.
		$this->json['link'] = $this->get_link();

		// The ID.
		$this->json['id'] = $this->id;

		// Translation strings.
		$this->json['l10n'] = $this->l10n();

		// The ajaxurl in case we need it.
		$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );

		// Input attributes.
		$this->json['inputAttrs'] = '';

		if ( is_array( $this->input_attrs ) ) {
			foreach ( $this->input_attrs as $attr => $value ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
			}
		}

		// The kirki-config.
		$this->json['thimCustomizerConfig'] = $this->thim_config;

		// The option-type.
		$this->json['thimCustomizerOptionType'] = $this->option_type;

		// The option-name.
		$this->json['thimCustomizerOptionName'] = $this->option_name;

		// The preset.
		$this->json['preset'] = $this->preset;

		// The CSS-Variables.
		$this->json['css-var'] = $this->css_vars;

		// Parent setting.
		$this->json['parent_setting'] = $this->parent_setting;

		// Wrapper Attributes.
		$this->json['wrapper_attrs'] = $this->wrapper_attrs;
	}

	protected function render_content() {}

	protected function content_template() {}

	protected function l10n() {
		return array();
	}
}
