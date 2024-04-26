<?php
/**
 * Thim_Builder Visual Composer Course Categories shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Course_Categories' ) ) {
	/**
	 * Class Thim_Builder_VC_Carousel_Categories
	 */
	class Thim_Builder_VC_Course_Categories extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Course_Categories constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Course_Categories';

			parent::__construct();
		}
		// convert setting course_categories
		function thim_convert_setting( $settings ) {
			$settings = array(
				'title'          => $settings['title'],
				'layout'         => $settings['layout'],
				'image_size'         => $settings['image_size'],
 				'slider-options' => array(
					'limit'              => $settings['slider_limit'],
					'show_navigation'    => $settings['slider_show_navigation'],
					'auto_play'          => $settings['slider_auto_play'],
					'show_pagination'    => $settings['slider_show_pagination'],

					'responsive-options' => array(
						'item_visible'               => $settings['slider_item_visible'],
						'item_small_desktop_visible' => $settings['slider_item_small_desktop_visible'],
						'item_tablet_visible'        => $settings['slider_item_tablet_visible'],
						'item_mobile_visible'        => $settings['slider_item_mobile_visible']
					)
				),
				'list-options'   => array(
					'show_counts'  => $settings['list_show_counts'],
					'hierarchical' => $settings['list_hierarchical']
				),
				'grid-options'   => array(
					'grid_limit'  => $settings['grid_limit'],
					'grid_column' => $settings['grid_column']
				),
				'sub_categories' => ( $settings['sub_categories'] == true ) ? 'yes' : '',
			);

			return $settings;
		}
	}
}

new Thim_Builder_VC_Course_Categories();
