<?php
/**
 * Thim_Builder Siteorigin Counters Box widget
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

if ( ! class_exists( 'Thim_Counters_Box_Widget' ) ) {
	/**
	 * Class Thim_Accordion_Widget
	 */
	class Thim_Counters_Box_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Accordion_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Counters_Box';

			parent::__construct();
		}
	}
}

