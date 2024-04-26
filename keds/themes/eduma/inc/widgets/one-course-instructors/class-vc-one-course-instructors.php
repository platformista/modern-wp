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

if ( ! class_exists( 'Thim_Builder_VC_One_Course_Instructors' ) ) {
	/**
	 * Class Thim_Builder_VC_One_Course_Instructors
	 */
	class Thim_Builder_VC_One_Course_Instructors extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_One_Course_Instructors constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_One_Course_Instructors';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_One_Course_Instructors();