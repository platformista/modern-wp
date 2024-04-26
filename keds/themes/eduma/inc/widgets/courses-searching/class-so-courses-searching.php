<?php
/**
 * Thim_Builder Siteorigin Courses Searching widget
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

if ( ! class_exists( 'Thim_Courses_Searching_Widget' ) ) {
	/**
	 * Class Thim_Accordion_Widget
	 */
	class Thim_Courses_Searching_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Accordion_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Courses_Searching';

			parent::__construct();
		}
	}
}

