<?php
/**
 * Thim_Builder Visual Composer Testimonials shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Testimonials' ) ) {
	/**
	 * Class Thim_Builder_VC_Testimonials
	 */
	class Thim_Builder_VC_Testimonials extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Testimonials constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Testimonials';

			parent::__construct();
		}
		// convert setting
		function thim_convert_setting( $settings ) {
			$settings['carousel-options']['auto_play']       = $settings['carousel_autoplay'];
			$settings['carousel-options']['show_pagination'] = $settings['show_pagination'];
			$settings['carousel-options']['show_navigation'] = $settings['show_navigation'];
			return $settings;
		}
	}
}

new Thim_Builder_VC_Testimonials();