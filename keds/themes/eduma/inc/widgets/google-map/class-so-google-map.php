<?php
/**
 * Thim_Builder Siteorigin Google Map widget
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

if ( ! class_exists( 'Thim_Google_Map_Widget' ) ) {
	/**
	 * Class Thim_Google_Map_Widget
	 */
	class Thim_Google_Map_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Google_Map_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Google_Map';

			parent::__construct();
		}

		// overwriter all options for widget
		function get_config_options() {
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
							esc_html__( 'Address', 'eduma' )     => 'address',
							esc_html__( 'Coordinates', 'eduma' ) => 'location',
						),
						'dependency'  => array(
							'element' => 'map_options',
							'value'   => 'api',
						),
						'std'         => 'address'
					),
					array(
						'type'       => 'section',
						'hide'       => true,
						'heading'    => __( 'Coordinates', 'eduma' ),
						'param_name' => 'location',
						'params'     => array(
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Lat', 'eduma' ),
								'param_name' => 'lat',
								'std'        => '41.868626'
							),

							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Lng', 'eduma' ),
								'param_name' => 'lng',
								'std'        => '-74.104301'
							),
						),
						'dependency' => array(
							'element' => 'display_by',
							'value'   => 'address',
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
						'heading'     => esc_html__( 'Google Map API Key', 'eduma' ),
						'param_name'  => 'api_key',
						'dependency'  => array(
							'element' => 'map_options',
							'value'   => 'api',
						),
						'description' => esc_html__( 'Enter your Google Map API Key. Refer on https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key', 'eduma' )
					),

					array(
						'type'        => 'section',
						'heading'     => __( 'Settings', 'eduma' ),
						'description' => esc_html__( 'Set map display options.', 'eduma' ),
						'param_name'  => 'settings',
						'params'      => array(
							array(
								'type'        => 'textfield',
								'admin_label' => true,
								'heading'     => esc_html__( 'Height', 'eduma' ),
								'param_name'  => 'height',
								'std'         => '480',
							),
							array(
								'type'        => 'number',
								'admin_label' => true,
								'heading'     => esc_html__( 'Zoom level', 'eduma' ),
								'param_name'  => 'zoom',
								'std'         => '12',
								'min'         => '0',
								'max'         => '21'
							),

							array(
								'type'        => 'checkbox',
								'admin_label' => true,
								'heading'     => esc_html__( 'Scroll to zoom', 'eduma' ),
								'description' => esc_html__( 'Allow scrolling over the map to zoom in or out.', 'eduma' ),
								'param_name'  => 'scroll_zoom',
								'dependency'  => array(
									'element' => 'map_options',
									'value'   => 'api',
								),
								'std'         => true,
							),

							array(
								'type'        => 'checkbox',
								'admin_label' => true,
								'heading'     => esc_html__( 'Draggable', 'eduma' ),
								'description' => esc_html__( 'Allow dragging the map to move it around.', 'eduma' ),
								'param_name'  => 'draggable',
								'dependency'  => array(
									'element' => 'map_options',
									'value'   => 'api',
								),
								'std'         => true,
							),

						)
					),
					array(
						'type'        => 'section',
						'heading'     => __( 'Markers', 'eduma' ),
						'description' => esc_html__( 'Use markers to identify points of interest on the map.', 'eduma' ),
						'param_name'  => 'markers',
						'params'      => array(
							array(
								'type'        => 'checkbox',
								'admin_label' => true,
								'heading'     => esc_html__( 'Show marker at map center', 'eduma' ),
								'param_name'  => 'marker_at_center',
								'std'         => true,
							),
							array(
								'type'        => 'attach_image',
								'admin_label' => true,
								'heading'     => esc_html__( 'Marker Icon', 'eduma' ),
								'param_name'  => 'marker_icon'
							)
						),
						'dependency'  => array(
							'element' => 'map_options',
							'value'   => 'api',
						),
					),
				);
 		}
	}
}

