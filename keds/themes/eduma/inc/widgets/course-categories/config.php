<?php
/**
 * Thim_Builder Carousel Categories config class
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

if ( ! class_exists( 'Thim_Builder_Config_Course-Categories' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Course_Categories extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Carousel_Categories constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'course-categories';
			self::$name = esc_html__( 'Thim: Course Categories', 'eduma' );
			self::$desc = esc_html__( 'Show course categories', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-course-categories';
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
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Slider', 'eduma' )          => 'slider',
						esc_html__( 'List Categories', 'eduma' ) => 'base',
						esc_html__( 'Tab Slider', 'eduma' )      => 'tab-slider',
						esc_html__( 'Grid', 'eduma' )            => 'grid',
					),
					'std'         => 'base'
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Limit categories', 'eduma' ),
					'param_name'  => 'grid_limit',
					'std'         => '6',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'grid' ),
					),
					'group'       => esc_html__( 'Grid Layout Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Number Column', 'eduma' ),
					'param_name'  => 'grid_column',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
					),
					'std'         => '3',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'grid' ),
					),
					'group'       => esc_html__( 'Grid Layout Settings', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Limit categories', 'eduma' ),
					'param_name'  => 'slider_limit',
					'std'         => '15',
					'min'         => 0,
					'max'         => 25,
					'step'        => 1,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),

					'group' => esc_html__( 'Slider Settings', 'eduma' ),
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image size', 'eduma' ),
					'param_name'  => 'image_size',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'grid' ),
					),
					'description' => esc_html__( 'Enter image size. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use default size.', 'eduma' ),
				),
				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'  => 'slider_show_pagination',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Navigation', 'eduma' ),
					'param_name'  => 'slider_show_navigation',
					'std'         => true,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name'  => 'slider_auto_play',
					'std'         => '0',
					'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'type_el'     => 'slider',
					'admin_label' => true,
					'heading'     => esc_html__( 'Items visible', 'eduma' ),
					'param_name'  => 'slider_item_visible',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
						esc_html__( '5', 'eduma' )      => '5',
						esc_html__( '6', 'eduma' )      => '6',
						esc_html__( '7', 'eduma' )      => '7',
						esc_html__( '8', 'eduma' )      => '8',
					),
					'range'       => array(
						'px' => array(
							'min'  => 1,
							'max'  => 8,
							'step' => 1
						),
					),
					'el_default'  => array(
						'unit' => 'px',
						'size' => 7,
					),
					'std'         => '7',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Responsive Options', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Items Small Desktop Visible', 'eduma' ),
					'param_name'  => 'slider_item_small_desktop_visible',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
						esc_html__( '5', 'eduma' )      => '5',
						esc_html__( '6', 'eduma' )      => '6',
						esc_html__( '7', 'eduma' )      => '7',
						esc_html__( '8', 'eduma' )      => '8',
					),
					'std'         => '6',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Responsive Options', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Items Tablet Visible', 'eduma' ),
					'param_name'  => 'slider_item_tablet_visible',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
						esc_html__( '5', 'eduma' )      => '5',
						esc_html__( '6', 'eduma' )      => '6',
						esc_html__( '7', 'eduma' )      => '7',
						esc_html__( '8', 'eduma' )      => '8',
					),
					'std'         => '4',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Responsive Options', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Items Mobile Visible', 'eduma' ),
					'param_name'  => 'slider_item_mobile_visible',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
						esc_html__( '5', 'eduma' )      => '5',
						esc_html__( '6', 'eduma' )      => '6',
						esc_html__( '7', 'eduma' )      => '7',
						esc_html__( '8', 'eduma' )      => '8',
					),
					'std'         => '2',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
					'group'       => esc_html__( 'Responsive Options', 'eduma' ),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show sub categories', 'eduma' ),
					'param_name'  => 'sub_categories',
					'std'         => true,
				),
				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show course count', 'eduma' ),
					'param_name'  => 'list_show_counts',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show hierarchy', 'eduma' ),
					'param_name'  => 'list_hierarchical',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
				),
			);
		}
	}
}