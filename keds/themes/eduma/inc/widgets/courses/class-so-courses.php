<?php
/**
 * Thim_Builder Siteorigin Courses widget
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

if ( ! class_exists( 'Thim_Courses_Widget' ) ) {
	/**
	 * Class Thim_Courses_Widget
	 */
	class Thim_Courses_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Courses_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Courses';

			parent::__construct();
		}
	}
}

