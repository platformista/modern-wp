<?php
/**
 * Thim_Builder Visual Composer Carousel Post shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Carousel_Post' ) ) {
	/**
	 * Class Thim_Builder_VC_Carousel_Post
	 */
	class Thim_Builder_VC_Carousel_Post extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Carousel_Post constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Carousel_Post';

			parent::__construct();
		}
		function thim_overwriter_base(){
			return 'carousel-posts';
		}
	}
}

new Thim_Builder_VC_Carousel_Post();