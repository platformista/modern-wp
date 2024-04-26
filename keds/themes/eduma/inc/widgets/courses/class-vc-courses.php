<?php
/**
 * Thim_Builder Visual Composer Courses shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Courses' ) ) {
	/**
	 * Class Thim_Builder_VC_Courses
	 */
	class Thim_Builder_VC_Courses extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Courses constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Courses';

			parent::__construct();
		}
		// convert setting
		function thim_convert_setting( $settings ) {
			$settings['slider-options']['show_pagination'] = $settings['slider_pagination'];
			$settings['slider-options']['show_navigation'] = $settings['slider_navigation'];
			$settings['slider-options']['item_visible']    = $settings['slider_item_visible'];
			$settings['slider-options']['auto_play']       = $settings['slider_auto_play'];
			$settings['grid-options']['columns']           = $settings['grid_columns'];
			$settings['tabs-options']['limit_tab']         = $settings['limit_tab'];
			if ( $settings['cat_id_tab'] ) {
				$settings['tabs-options']['cat_id_tab'] = explode( ',', $settings['cat_id_tab'] );
			} else {
				$settings['tabs-options']['cat_id_tab'] = '';
			}

			return $settings;
		}
	}
}

new Thim_Builder_VC_Courses();