<?php
/**
 * Thim_Builder Siteorigin Portfolio widget
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

if ( ! class_exists( 'Thim_Portfolio_Widget' ) ) {
	/**
	 * Class Thim_Portfolio_Widget
	 */
	class Thim_Portfolio_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Portfolio_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Portfolio';

			parent::__construct();
		}
	}
}

