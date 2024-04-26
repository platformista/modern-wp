<?php
/**
 * Thim_Builder Visual Composer Gallery Images shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Gallery_Images' ) ) {
	/**
	 * Class Thim_Builder_VC_Gallery_Images
	 */
	class Thim_Builder_VC_Gallery_Images extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Gallery_Images constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Gallery_Images';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Gallery_Images();