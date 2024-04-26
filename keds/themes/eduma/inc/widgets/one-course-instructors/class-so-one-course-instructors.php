<?php
/**
 * Thim_Builder Siteorigin Button widget
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

if ( ! class_exists( 'Thim_One_Course_Instructors_Widget' ) ) {
	/**
	 * Class Thim_One_Course_Instructors_Widget
	 */
	class Thim_One_Course_Instructors_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_One_Course_Instructors_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_One_Course_Instructors';

			parent::__construct();
		}
	}
}

