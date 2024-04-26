<?php
/**
 * Thim_Builder Visual Composer Carousel Categories shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Carousel_Categories' ) ) {
	/**
	 * Class Thim_Builder_VC_Carousel_Categories
	 */
	class Thim_Builder_VC_Carousel_Categories extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Carousel_Categories constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Carousel_Categories';

			parent::__construct();
		}
	}
}

new Thim_Builder_VC_Carousel_Categories();