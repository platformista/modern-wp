<?php
/**
 * Thim_Builder Visual Composer Gallery Posts shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Gallery_Posts' ) ) {
	/**
	 * Class Thim_Builder_VC_Gallery_Posts
	 */
	class Thim_Builder_VC_Gallery_Posts extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Gallery_Posts constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Gallery_Posts';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Gallery_Posts();