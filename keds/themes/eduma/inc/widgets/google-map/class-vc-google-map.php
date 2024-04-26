<?php
/**
 * Thim_Builder Visual Composer Google Map shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Google_Map' ) ) {
	/**
	 * Class Thim_Builder_VC_Google_Map
	 */
	class Thim_Builder_VC_Google_Map extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Google_Map constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Google_Map';

			parent::__construct();
		}
		// convert setting
		function thim_convert_setting( $settings ) {
			$settings = array(
				'title'       => $settings['title'],
				'display_by'  => $settings['display_by'],
				'map_options' => $settings['map_options'],
				'location'    => array(
					'lat' => $settings['location_lat'],
					'lng' => $settings['location_lng']
				),
				'map_center'  => $settings['map_center'],
				'api_key'     => $settings['api_key'],
				'settings'    => array(
					'height'      => $settings['settings_height'],
					'zoom'        => isset( $settings['settings_zoom'] ) ? $settings['settings_zoom'] : '12',
					'draggable'   => $settings['settings_draggable'],
					'scroll_zoom' => $settings['settings_scroll_zoom']
				),
				'markers'     => array(
					'marker_at_center' => $settings['marker_at_center'],
					'marker_icon'      => $settings['marker_icon'],
				)
			);

			return $settings;
		}
	}
}

new Thim_Builder_VC_Google_Map();