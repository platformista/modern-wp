<?php
/**
 * Thim_Builder handler class
 *
 * @version     1.0.0
 * @author      Thim_Builder
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_VC' ) ) {
	/**
	 * Class Thim_Builder_VC
	 */
	class Thim_Builder_VC {
		/**
		 * Thim_Builder_VC constructor.
		 */
		public function __construct() {

			require_once( THIM_CORE_INC_PATH . '/builders/visual-composer/class-vc-shortcode.php' );
			// init
			add_action( 'init', array( $this, 'init' ) );

			// register extra params
			add_action( 'vc_before_init', array( $this, 'register_extra_params' ) );

			// load shortcodes
			add_action( 'vc_before_init', array( $this, 'load_shortcodes' ) );

		}

		/**
		 * Add custom attributes to vc_row, vc_column
		 */
		public function init() {
			if ( ! class_exists( 'Vc_Manager' ) ) {
				return;
			}
		}


		/**
		 * Load shortcodes
		 */
		public function load_shortcodes() {

			$shortcodes = thim_builder_get_elements();
			foreach ( $shortcodes as $group => $_shortcodes ) {
				foreach ( $_shortcodes as $shortcode ) {
					if ( $group != 'widgets' ) {
						$folder = $shortcode;
						if ( thim_builder_folder_group() ) {
							$folder = $group . '/' . $shortcode;
						}
						$file = apply_filters( 'thim-builder/vc-shortcode-file', TP_THEME_ELEMENTS_THIM_DIR . "$folder/class-vc-$shortcode.php", $shortcode );
						if ( file_exists( $file ) ) {
							include_once $file;
						}
					}
				}
			}
		}

		/**
		 * Register VC extra params.
		 * Register VC extra params.
		 */
		public function register_extra_params() {
			if ( function_exists( 'vc_add_shortcode_param' ) ) {
				vc_add_shortcode_param( 'number', array( $this, '_number_param' ) );
				vc_add_shortcode_param( 'radio_image', array( $this, '_radio_image_param' ) );
				vc_add_shortcode_param( 'datetimepicker', array( $this, '_datetimepicker_param' ) );
				vc_add_shortcode_param( 'dropdown_multiple', array( $this, '_dropdown_multiple_param' ) );

				do_action( 'thim-builder/register-extra-params' );
			}
		}

		/**
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function _datetimepicker_param( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$value      = isset( $value ) ? $value : $settings['value'];
			$output     = '<input type="text" name="' . $param_name . '" class="bp-datetimepicker wpb_vc_param_value ' . $param_name . ' ' . $type . '_field ' . $class . '" value="' . $value . '"  />';
			$output     .= '<script>jQuery(\'.bp-datetimepicker\').datetimepicker();</script>';
			$output     .= '';

			return $output;
		}

		/**
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function _number_param( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$value      = isset( $value ) ? $value : $settings['value'];
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;

			return $output;
		}

		/**
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function _radio_image_param( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$radios     = isset( $settings['options'] ) ? $settings['options'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '_field ' . $class . '" value="' . $value . '"  ' . ' />';
			$output     .= '<div id="' . $param_name . '_wrap" class="icon_style_wrap ' . $class . '" >';
			if ( $radios != '' && is_array( $radios ) ) {
				$i = 0;
				foreach ( $radios as $key => $image_url ) {
					$class   = ( $key == $value ) ? ' class="selected" ' : '';
					$image   = '<img id="' . $param_name . $i . '_img' . $key . '" src="' . $image_url . '" ' . $class . '/>';
					$checked = ( $key == $value ) ? ' checked="checked" ' : '';
					$output  .= '<input name="' . $param_name . '_option" id="' . $param_name . $i . '" value="' . $key . '" type="radio" '
						. 'onchange="document.getElementById(\'' . $param_name . '\').value=this.value;'
						. 'jQuery(\'#' . $param_name . '_wrap img\').removeClass(\'selected\');'
						. 'jQuery(\'#' . $param_name . $i . '_img' . $key . '\').addClass(\'selected\');'
						. 'jQuery(\'#' . $param_name . '\').trigger(\'change\');" '
						. $checked . ' style="display:none;" />';
					$output  .= '<label for="' . $param_name . $i . '">' . $image . '</label>';
					$i ++;
				}
			}
			$output .= '</div>';

			return $output;
		}

		/**
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function _dropdown_multiple_param( $param, $value ) {
			if ( ! is_array( $value ) ) {
				$param_value_arr = explode( ',', $value );
			} else {
				$param_value_arr = $value;
			}

			$param_line = '';
			$param_line .= '<select multiple name="' . esc_attr( $param['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $param['param_name'] ) . ' ' . esc_attr( $param['type'] ) . '">';
			foreach ( $param['value'] as $text_val => $val ) {
				if ( is_numeric( $text_val ) && ( is_string( $val ) || is_numeric( $val ) ) ) {
					$text_val = $val;
				}
				$selected = '';
				if ( ! empty( $param_value_arr ) && in_array( $val, $param_value_arr ) ) {
					$selected = ' selected="selected"';
				}
				$param_line .= '<option class="' . $val . '" value="' . $val . '"' . $selected . '>' . $text_val . '</option>';
			}
			$param_line .= '</select>';

			return $param_line;
		}
	}
}

new Thim_Builder_VC();
