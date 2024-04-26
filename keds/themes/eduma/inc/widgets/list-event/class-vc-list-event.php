<?php
/**
 * Thim_Builder Visual Composer List Event shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_List_Event' ) ) {
	/**
	 * Class Thim_Builder_VC_List_Event
	 */
	class Thim_Builder_VC_List_Event extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_List_Event constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_List_Event';

			parent::__construct();
		}
		function thim_overwriter_base(){
			return 'list-events';
		}
	}
}

new Thim_Builder_VC_List_Event();