<?php
/**
 * Thim_Builder Visual Composer Our Team shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Our_Team' ) ) {
	/**
	 * Class Thim_Builder_VC_Our_Team
	 */
	class Thim_Builder_VC_Our_Team extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Our_Team constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Our_Team';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Our_Team();