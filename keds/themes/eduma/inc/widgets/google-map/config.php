<?php
/**
 * Thim_Builder Google Map config class
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

if ( ! class_exists( 'Thim_Builder_Config_Google_Map' ) ) {
	/**
	 * Class Thim_Builder_Config_Google_Map
	 */
	class Thim_Builder_Config_Google_Map extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Google_Map constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'google-map';
			self::$name = esc_html__( 'Thim: Google Map', 'eduma' );
			self::$desc = esc_html__( 'Display Google Map.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-google-map';

			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'value'       => '',
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Google map Options', 'eduma' ),
					'param_name'  => 'map_options',
					'value'       => array(
						esc_html__( 'Use API', 'eduma' )        => 'api',
						esc_html__( 'Use Map Iframe', 'eduma' ) => 'iframe',
					),
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Get Map By', 'eduma' ),
					'param_name'  => 'display_by',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )      => '',
						esc_html__( 'Address', 'eduma' )     => 'address',
						esc_html__( 'Coordinates', 'eduma' ) => 'location',
					),
					'dependency'  => array(
						'element' => 'map_options',
						'value'   => 'api',
					),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Lat', 'eduma' ),
					'param_name'  => 'location_lat',
					'std'         => '41.868626',
					'dependency'  => array(
						'element' => 'display_by',
						'value'   => 'location',
					),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Lng', 'eduma' ),
					'param_name'  => 'location_lng',
					'std'         => '-74.104301',
					'dependency'  => array(
						'element' => 'display_by',
						'value'   => 'location',
					),
				),

				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_attr__( 'Map center', 'eduma' ),
					'description' => esc_attr__( 'The name of a place, town, city, or even a country. Can be an exact address too.', 'eduma' ),
					'param_name'  => 'map_center',
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Height', 'eduma' ),
					'param_name'  => 'settings_height',
					'std'         => '480',
				),

				array(
					'type'        => 'number',
					'type_el'     => 'slider',
					'admin_label' => true,
					'heading'     => esc_html__( 'Zoom level', 'eduma' ),
					'param_name'  => 'settings_zoom',
					'std'         => '12',
					'min'         => '0',
					'max'         => '21',
					'range'       => array(
						'px' => array(
							'min'  => 0,
							'max'  => 21,
							'step' => 1
						),
					),
					'el_default'  => array(
						'unit' => 'px',
						'size' => 12,
					),
				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Google Map API Key', 'eduma' ),
					'param_name'    => 'api_key',
					'dependency'    => array(
						'element' => 'map_options',
						'value'   => 'api',
					),
					'description'   => esc_html__( 'Enter your Google Map API Key. Refer on https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key', 'eduma' ),
					'group'         => esc_html__( 'Settings', 'eduma' ),
					'start_section' => 'settings'
				),
				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Scroll to zoom', 'eduma' ),
					'description' => esc_html__( 'Allow scrolling over the map to zoom in or out.', 'eduma' ),
					'param_name'  => 'settings_scroll_zoom',
					'dependency'  => array(
						'element' => 'map_options',
						'value'   => 'api',
					),
					'std'         => true,
					'group'       => esc_html__( 'Settings', 'eduma' )
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Draggable', 'eduma' ),
					'description' => esc_html__( 'Allow dragging the map to move it around.', 'eduma' ),
					'param_name'  => 'settings_draggable',
					'dependency'  => array(
						'element' => 'map_options',
						'value'   => 'api',
					),
					'std'         => true,
					'group'       => esc_html__( 'Settings', 'eduma' )
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show marker at map center', 'eduma' ),
					'param_name'  => 'marker_at_center',
					'dependency'  => array(
						'element' => 'map_options',
						'value'   => 'api',
					),
					'std'         => true,
					'group'       => esc_html__( 'Settings', 'eduma' )
				),

				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__( 'Marker Icon', 'eduma' ),
					'param_name'  => 'marker_icon',
					'dependency'  => array(
						'element' => 'map_options',
						'value'   => 'api',
					),
					'group'       => esc_html__( 'Settings', 'eduma' )
				),
			);
		}
	}
}