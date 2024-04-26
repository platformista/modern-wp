<?php
/**
 * Thim_Builder Siteorigin Twitter widget
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

if ( ! class_exists( 'Thim_Twitter_Widget' ) ) {
	/**
	 * Class Thim_Twitter_Widget
	 */
	class Thim_Twitter_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Twitter_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Twitter';

			parent::__construct();
		}
	}
}

