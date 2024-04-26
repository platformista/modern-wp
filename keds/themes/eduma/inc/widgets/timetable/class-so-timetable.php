<?php
/**
 * Thim_Builder Siteorigin Timetable widget
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

if ( ! class_exists( 'Thim_Timetable_Widget' ) ) {
	/**
	 * Class Thim_Timetable_Widget
	 */
	class Thim_Timetable_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Timetable_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Timetable';

			parent::__construct();
		}
	}
}

