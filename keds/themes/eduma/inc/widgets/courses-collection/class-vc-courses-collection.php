<?php
/**
 * Thim_Builder Visual Composer Courses Collection shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Courses_Collection' ) ) {
	/**
	 * Class Thim_Builder_VC_Courses_Collection
	 */
	class Thim_Builder_VC_Courses_Collection extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Courses_Collection constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Courses_Collection';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Courses_Collection();