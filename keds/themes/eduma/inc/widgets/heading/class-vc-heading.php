<?php
/**
 * Thim_Builder Visual Composer Heading shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Heading' ) ) {
	/**
	 * Class Thim_Builder_VC_Heading
	 */
	class Thim_Builder_VC_Heading extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Heading constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Heading';

			parent::__construct();
		}
		// convert variables
		function thim_convert_setting( $settings ) {
			$settings['font_heading'] = $settings['title_custom'];
			$settings['custom_font_heading'] = array(
				'custom_font_size' => $settings['font_size'],
				'custom_font_weight' => $settings['font_weight'],
				'custom_font_style' => $settings['font_style'],
			);

			return $settings;
		}
 	}
}

new Thim_Builder_VC_Heading();

