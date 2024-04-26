<?php
/**
 * Thim_Builder Siteorigin Course Categories widget
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

if ( ! class_exists( 'Thim_Course_Categories_Widget' ) ) {
	/**
	 * Class Thim_Accordion_Widget
	 */
	class Thim_Course_Categories_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Accordion_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Course_Categories';

			parent::__construct();
		}

		// over writer config
		function get_config_options() {
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
					'param_name'  => 'limit',
					'std'         => '8',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array(  'base' ),
					),
					'description' => esc_html__( 'Limit number categories', 'eduma' ),

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
					'group_id'    => 'grid-options',
					'group'       => esc_html__( 'Grid Layout Settings', 'eduma' ),
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image size', 'eduma' ),
					'param_name'  => 'image_size',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'grid','slider' ),
					),
					'description' => esc_html__( 'Enter image size. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use default size.', 'eduma' ),
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
					'group_id'    => 'grid-options',
					'group'       => esc_html__( 'Grid Layout Settings', 'eduma' ),
				),

				array(
					'type'       => 'section',
					'value'      => '',
					'heading'    => __( 'Slider Settings', 'eduma' ),
					'param_name' => 'slider-options',
					'params'     => array(
						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_html__( 'Limit categories', 'eduma' ),
							'param_name'  => 'limit',
							'std'         => '15',
							'min'         => 0,
							'max'         => 25,
							'step'        => 1,
						),

						array(
							'type'        => 'checkbox',
							'admin_label' => true,
							'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
							'param_name'  => 'show_pagination',
							'std'         => false,
							'dependency'  => array(
								'element' => 'layout',
								'value'   => array( 'slider', 'tab-slider' ),
							),
						),

						array(
							'type'        => 'checkbox',
							'admin_label' => true,
							'heading'     => esc_html__( 'Show Navigation', 'eduma' ),
							'param_name'  => 'show_navigation',
							'std'         => true,
						),
						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
							'param_name'  => 'auto_play',
							'std'         => '0',
							'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
						),
						array(
							'type'       => 'section',
							'heading'    => esc_html__( 'Responsive Options', 'eduma' ),
							'param_name' => 'responsive-options',
							'std'        => '7',
							'params'     => array(
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Items visible', 'eduma' ),
									'param_name' => 'item_visible',
									'value'      => array(
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
									'std'        => '7',
								),

								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Items Small Desktop Visible', 'eduma' ),
									'param_name' => 'item_small_desktop_visible',
									'value'      => array(
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
									'std'        => '6',
								),

								array(
									'type'        => 'dropdown',
									'admin_label' => true,
									'heading'     => esc_html__( 'Items Tablet Visible', 'eduma' ),
									'param_name'  => 'item_tablet_visible',
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
								),

								array(
									'type'        => 'dropdown',
									'admin_label' => true,
									'heading'     => esc_html__( 'Items Mobile Visible', 'eduma' ),
									'param_name'  => 'item_mobile_visible',
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
								),

							)
						)
					),
					'dependency' => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'tab-slider' ),
					),
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
					'param_name'  => 'show_counts',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
					'group_id'    => 'list-options',
					'group'       => esc_html__( 'List Options', 'eduma' ),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show hierarchy', 'eduma' ),
					'param_name'  => 'hierarchical',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
					'group_id'    => 'list-options',
					'group'       => esc_html__( 'List Options', 'eduma' ),
				),
			);
		}
	}
}

