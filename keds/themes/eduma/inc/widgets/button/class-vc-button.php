<?php
/**
 * Thim_Builder Visual Composer Button shortcode
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_VC_Button' ) ) {
	/**
	 * Class Thim_Builder_VC_Button
	 */
	class Thim_Builder_VC_Button extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Button constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Button';

			parent::__construct();
		}
		function thim_convert_setting( $settings ) {
			$settings = array(
				'title'         => $settings['title'],
				'url'           => $settings['url'],
				'new_window'    => $settings['new_window'],
				'custom_style'  => $settings['custom_style'],
				'style_options' => array(
					'font_size'          => $settings['font_size'],
					'font_weight'        => $settings['font_weight'],
					'border_width'       => $settings['border_width'],
					'color'              => $settings['color'],
					'border_color'       => $settings['border_color'],
					'bg_color'           => $settings['bg_color'],
					'hover_color'        => $settings['hover_color'],
					'hover_border_color' => $settings['hover_border_color'],
					'hover_bg_color'     => $settings['hover_bg_color'],
				),
				'icon'          => array(
					'icon'          => $settings['icon'],
					'icon_size'     => $settings['icon_size'],
					'icon_position' => $settings['icon_position'],
				),
				'layout'        => array(
					'button_size' => $settings['button_size'],
					'rounding'    => $settings['rounding'],
				),
			);

			return $settings;
		}
	}
}

new Thim_Builder_VC_Button();