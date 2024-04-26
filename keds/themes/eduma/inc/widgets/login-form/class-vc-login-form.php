<?php
/**
 * Thim_Builder Visual Composer Login Form shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Login_Form' ) ) {
	/**
	 * Class Thim_Builder_VC_Login_Form
	 */
	class Thim_Builder_VC_Login_Form extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Login_Form constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Login_Form';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Login_Form();