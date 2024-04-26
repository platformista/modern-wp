<?php
/**
 * Thim_Builder Courses config class
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

if ( ! class_exists( 'Thim_Builder_Config_Courses' ) ) {
	/**
	 * Class Thim_Builder_Config_Courses
	 */
	class Thim_Builder_Config_Courses extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Courses constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'courses';
			self::$name = esc_html__( 'Thim: Courses', 'eduma' );
			self::$desc = esc_html__( 'Display courses.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-courses';

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
					'heading'     => esc_html__( 'Heading text', 'eduma' ),
					'param_name'  => 'title',
					'allow_html_formatting' => true,
					'value'       => '',
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Limit', 'eduma' ),
					'param_name'  => 'limit',
					'min'         => 1,
					'max'         => 20,
					'std'         => '8',
					'description' => esc_html__( 'Limit number courses.', 'eduma' )
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Featured', 'eduma' ),
					'param_name'  => 'featured',
					'description' => esc_html__( 'Only display featured courses', 'eduma' ),
					'std'         => false,
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Order By', 'eduma' ),
					'param_name'  => 'order',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )   => '',
						esc_html__( 'Popular', 'eduma' )  => 'popular',
						esc_html__( 'Latest', 'eduma' )   => 'latest',
						esc_html__( 'Category', 'eduma' ) => 'category',
					),
					'description' => esc_html__( 'Select order by.', 'eduma' ),
				),

				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Select Category', 'eduma' ),
					'param_name' => 'cat_id',
					'value'      => thim_get_cat_taxonomy( 'course_category', array( esc_html__( 'All', 'eduma' ) => 'all' ), true ),
					'dependency' => array(
						'element' => 'order',
						'value'   => 'category',
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Slider', 'eduma' )                     => 'slider',
						esc_html__( 'Grid', 'eduma' )                       => 'grid',
						esc_html__( 'Grid 1', 'eduma' )                     => 'grid1',
						esc_html__( 'Category Tabs', 'eduma' )              => 'tabs',
						esc_html__( 'Mega Menu', 'eduma' )                  => 'megamenu',
						esc_html__( 'List Sidebar', 'eduma' )               => 'list-sidebar',
						esc_html__( 'Category Click Tabs Slider', 'eduma' ) => 'tabs-slider',
						esc_html__( 'Slider - Home Instructor', 'eduma' )   => 'slider-instructor',
						esc_html__( 'Grid - Home New', 'eduma' )     => 'grid-instructor',
						esc_html__( 'Category Item Tabs Slider', 'eduma' )  => 'item-tabs-slider',
					),
					'std'         => 'slider'
				),

				array(
					'type'          => 'checkbox',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Hide Author', 'eduma' ),
					'param_name'    => 'grid_hide_author',
 					'std'           => false,
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'grid-instructor',
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Tabs Slider Style', 'eduma' ),
					'param_name'  => 'item_tab_slider_style',
					'value'       => array(
						esc_html__( 'Style 01', 'eduma' ) => 'style_1',
						esc_html__( 'Style 02', 'eduma' ) => 'style_2',
					),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'item-tabs-slider',
					),
					'std'         => 'style_1'
				),
				array(
					'type'          => 'textfield',
 					'heading'       => esc_html__( 'Before Heading', 'eduma' ),
 					'param_name'    => 'before_heading',
  					'dependency'    => array(
						'element' => 'item_tab_slider_style',
						'value'   => 'style_1',
					),
 				),

				array(
					'type'        => 'number',
					'type_el'     => 'slider',
					'admin_label' => true,
					'heading'     => esc_html__( 'Thumbnail Width', 'eduma' ),
					'param_name'  => 'thumbnail_width',
					'min'         => 100,
					'max'         => 800,
					'std'         => 400,
					'description' => esc_html__( 'Set width for thumbnail course.', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'grid', 'grid1', 'tabs', 'tabs-slider', 'slider-instructor', 'grid-instructor' ),
					),
					'range'       => array(
						'px' => array(
							'min'  => 100,
							'max'  => 800,
							'step' => 1
						),
					),
					'el_default'  => array(
						'unit' => 'px',
						'size' => 400,
					),
				),

				array(
					'type'        => 'number',
					'type_el'     => 'slider',
					'admin_label' => true,
					'heading'     => esc_html__( 'Thumbnail Height', 'eduma' ),
					'param_name'  => 'thumbnail_height',
					'min'         => 100,
					'max'         => 800,
					'std'         => 300,
					'description' => esc_html__( 'Set height for thumbnail course.', 'eduma' ),
					'range'       => array(
						'px' => array(
							'min'  => 100,
							'max'  => 800,
							'step' => 1
						),
					),
					'el_default'  => array(
						'unit' => 'px',
						'size' => 300,
					),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'grid', 'grid1', 'tabs', 'tabs-slider', 'slider-instructor', 'grid-instructor' ),
					),
				),

				//Slider Options
				array(
					'type'          => 'number',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Items Visible', 'eduma' ),
					'param_name_so' => 'item_visible',
					'param_name'    => 'slider_item_visible',
					'min'           => 1,
					'max'           => 20,
					'std'           => '4',
					'dependency'    => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'slider-instructor', 'item-tabs-slider' ),
					),
					'group'         => esc_html__( 'Slider Settings', 'eduma' ),
					'group_id'      => 'slider-options',
					'start_section' => 'slider-options'
				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name_so' => 'auto_play',
					'param_name'    => 'slider_auto_play',
					'std'           => '0',
					'description'   => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'dependency'    => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'slider-instructor', 'item-tabs-slider' ),
					),
					'group'         => esc_html__( 'Slider Settings', 'eduma' ),
					'group_id'      => 'slider-options',
				),

				array(
					'type'          => 'checkbox',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'    => 'slider_pagination',
					'param_name_so' => 'show_pagination',
					'std'           => false,
					'dependency'    => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'slider-instructor', 'item-tabs-slider' ),
					),
					'group'         => esc_html__( 'Slider Settings', 'eduma' ),
					'group_id'      => 'slider-options',
				),

				array(
					'type'          => 'checkbox',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Show Navigation', 'eduma' ),
					'param_name_so' => 'show_navigation',
					'param_name'    => 'slider_navigation',
					'std'           => true,
					'dependency'    => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'slider-instructor', 'item-tabs-slider' ),
					),
					'group'         => esc_html__( 'Slider Settings', 'eduma' ),
					'group_id'      => 'slider-options',
				),

				//Grid options
				array(
					'type'          => 'number',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Grid Columns', 'eduma' ),
					'param_name'    => 'grid_columns',
					'param_name_so' => 'columns',
					'min'           => 1,
					'max'           => 20,
					'std'           => '4',
					'dependency'    => array(
						'element' => 'layout',
						'value'   => array( 'grid', 'grid1', 'grid-instructor' ),
					),
					'group'         => esc_html__( 'Grid Settings', 'eduma' ),
					'group_id'      => 'grid-options',
					'start_section' => 'grid-options'
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text View All Courses', 'eduma' ),
					'param_name'  => 'view_all_courses',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'grid', 'grid1', 'tabs-slider', 'grid-instructor' ),
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'View All Position', 'eduma' ),
					'param_name'  => 'view_all_position',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'Top', 'eduma' )    => 'top',
						esc_html__( 'Bottom', 'eduma' ) => 'bottom',
					),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'grid', 'grid1', 'tabs-slider', 'grid-instructor' ),
					),
				),

				//Tabs options
				array(
					'type'          => 'number',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Limit Tab', 'eduma' ),
					'param_name'    => 'limit_tab',
					'min'           => 1,
					'max'           => 20,
					'std'           => '4',
					'dependency'    => array(
						'element' => 'layout',
						'value'   => array( 'tabs', 'tabs-slider' ),
					),
					'group'         => esc_html__( 'Tabs Settings', 'eduma' ),
					'group_id'      => 'tabs-options',
					'start_section' => 'tabs-options'
				),

				array(
					'type'       => 'dropdown_multiple',
					'heading'    => esc_html__( 'Select Category Tabs', 'eduma' ),
					'param_name' => 'cat_id_tab',
					'std'        => 'all',
					'value'      => thim_sc_get_course_categories(),
					'dependency' => array(
						'element' => 'layout',
						'value'   => array( 'tabs', 'tabs-slider','item-tabs-slider' ),
					),
					'group'      => esc_html__( 'Tabs Settings', 'eduma' ),
					'group_id'   => 'tabs-options',
				),

			);
		}
	}
}