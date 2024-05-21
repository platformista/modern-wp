<?php
namespace ThimPress\Customizer\Modules;

use ThimPress\Customizer\Utils\Helper;
use ThimPress\Customizer\Modules\CSS\Generator;

class Css {	

	public static $css_array = array();

	protected static $fields = array();

	protected static $field_option_types = array();

	private static $css_handle = 'thim-customizer-styles';

	private static $inline_styles_id = 'thim-customizer-inline-styles';

	public function __construct() {
		add_action( 'thim_customizer_field_init', array( $this, 'field_init' ), 10, 2 );
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! apply_filters( 'thim_customizer_output_inline_styles', true ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		} else {
			add_action( 'wp_head', array( $this, 'print_styles_inline' ), 999 );
		}
	}

	public function field_init( $args, $object ) {
		if ( ! isset( $args['output'] ) ) {
			$args['output'] = array();
		}

		self::$field_option_types[ $args['id'] ] = isset( $args['option_type'] ) ? $args['option_type'] : 'theme_mod';

		if ( ! is_array( $args['output'] ) ) {
			$args['output'] = array(
				array(
					'element' => $args['output'],
				),
			);
		}

		if ( isset( $args['output']['element'] ) ) {
			$args['output'] = array( $args['output'] );
		}

		if ( empty( $args['output'] ) ) {
			return;
		}

		foreach ( $args['output'] as $key => $output ) {
			if ( empty( $output ) || ! isset( $output['element'] ) ) {
				unset( $args['output'][ $key ] );
				continue;
			}
			if ( ! isset( $output['sanitize_callback'] ) && isset( $output['callback'] ) ) {
				$args['output'][ $key ]['sanitize_callback'] = $output['callback'];
			}
			if ( isset( $output['element'] ) && is_array( $output['element'] ) ) {
				$args['output'][ $key ]['element'] = array_unique( $args['output'][ $key ]['element'] );
				sort( $args['output'][ $key ]['element'] );

				foreach ( $args['output'][ $key ]['element'] as $index => $element ) {
					$args['output'][ $key ]['element'][ $index ] = trim( $element );
				}
				$args['output'][ $key ]['element'] = implode( ',', $args['output'][ $key ]['element'] );
			}

			$args['output'][ $key ]['element'] = str_replace( array( "\t", "\n", "\r", "\0", "\x0B" ), ' ', $args['output'][ $key ]['element'] );
			$args['output'][ $key ]['element'] = trim( preg_replace( '/\s+/', ' ', $args['output'][ $key ]['element'] ) );
		}

		if ( ! isset( $args['type'] ) && isset( $object->type ) ) {
			$args['type'] = $object->type;
		}
		
		self::$fields[] = $args;
	}

	public function print_styles_inline() {
		$should_print = true;

		if ( defined( 'THIM_CUSTOMIZER_NO_OUTPUT' ) && true === THIM_CUSTOMIZER_NO_OUTPUT ) {
			$should_print = false;
		}

		ob_start();
		$this->print_styles();
		$inline_styles = ob_get_clean();

		if ( ! $should_print && false !== stripos($inline_styles, '@font-face') ) {
			$should_print = true;
		}

		if ( ! $should_print ) {
			return;
		}

		$inline_styles_id = apply_filters( 'thim_customizer_inline_styles_id', self::$inline_styles_id );

		echo '<style id="' . esc_attr( $inline_styles_id ) . '">';
		echo $inline_styles;
		echo '</style>';

	}

	public function enqueue_styles() {
		$args = array(
			'action' => apply_filters( 'thim_customizer_styles_action_handle', self::$css_handle ),
		);

		if ( is_admin() ) {
			global $current_screen;

			if ( is_object( $current_screen ) && property_exists( $current_screen, 'id' ) && 'customize' === $current_screen->id ) {
				return;
			}

			if ( property_exists( $current_screen, 'is_block_editor' ) && 1 === (int) $current_screen->is_block_editor ) {
				$args['editor'] = '1';
			}
		}

		wp_enqueue_style(
			self::$css_handle,
			add_query_arg( $args, home_url() ),
			array(),
			'4.0'
		);
	}

	public function print_styles() {
		$styles = self::loop_controls();

		if ( ! empty( $styles ) ) {
			echo wp_strip_all_tags( $styles );
		}

		do_action( 'thim_customizer_dynamic_css' );
	}

	public static function loop_controls() {
		Generator::get_instance();

		$fields = self::$fields;
	
		$css = array();
		
		if ( empty( $fields ) ) {
			return;
		}
		
		foreach ( $fields as $field ) {
			if ( ( isset( $field['required'] ) && ! empty( $field['required'] ) ) || ( isset( $field['active_callback'] ) && ! empty( $field['active_callback'] ) ) ) {
				$valid = true;

				if ( ! isset( $field['required'] ) || empty( $field['required'] ) ) {
					if ( isset( $field['active_callback'] ) && ! empty( $field['active_callback'] ) ) {
						if ( is_array( $field['active_callback'] ) || is_callable( $field['active_callback'] ) ) {
							$field['required'] = $field['active_callback'];
						}
					}
				}

				if ( is_string( $field['required'] ) ) {
					$valid = '__return_true' === $field['required'] ? true : false;
				} elseif ( is_callable( $field['required'] ) ) {
					$valid = call_user_func( $field['required'] );
				}

				if ( ! $valid ) {
					continue;
				}
			}

			if ( isset( $field['output'] ) && ! empty( $field['output'] ) ) {
				$css = Helper::array_replace_recursive( $css, Generator::css( $field ) );
			}
		}

		if ( is_array( $css ) ) {
			return Generator::styles_parse( Generator::add_prefixes( $css ) );
		}
	}
}
