<?php
/**
 * Thim_Builder List Event config class
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

if ( ! class_exists( 'Thim_Builder_Config_List_Event' ) ) {
	/**
	 * Class Thim_Builder_Config_List_Event
	 */
	class Thim_Builder_Config_List_Event extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_List_Event constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'list-event';
			self::$name = esc_html__( 'Thim: List Events', 'eduma' );
			self::$desc = esc_html__( 'Display List Events.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-list-event';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'                  => 'textfield',
					'admin_label'           => true,
					'heading'               => esc_html__( 'Title', 'eduma' ),
					'param_name'            => 'title',
					'allow_html_formatting' => true,
					'value'                 => '',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Sub Title', 'eduma' ),
					'param_name' => 'sub_title',
					'dependency' => array(
						'element' => 'layout',
						'value'   => 'layout-6',
					),
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' )  => 'base',
						esc_html__( 'Slider', 'eduma' )   => 'slider',
						esc_html__( 'Layout 2', 'eduma' ) => 'layout-2',
						esc_html__( 'Layout 3', 'eduma' ) => 'layout-3',
						esc_html__( 'Layout 4', 'eduma' ) => 'layout-4',
						esc_html__( 'Layout 5', 'eduma' ) => 'layout-5',
						esc_html__( 'Layout 6', 'eduma' ) => 'layout-6',
					),
					'std'         => 'base'
				),

				array(
					'type'       => 'dropdown_multiple',
					'heading'    => esc_html__( 'Select Category', 'eduma' ),
					'param_name' => 'cat_id',
					'value'      => thim_get_cat_taxonomy( 'tp_event_category', array( esc_html__( 'All', 'eduma' ) => 'all' ), true ),
					'std'        => '',
				),

				array(
					'type'       => 'dropdown_multiple',
					'heading'    => esc_html__( 'Select Status', 'eduma' ),
					'param_name' => 'status',
					'std'        => '',
					'value'      => array(
						esc_html__( 'Upcoming', 'eduma' )  => 'upcoming',
						esc_html__( 'Happening', 'eduma' ) => 'happening',
						esc_html__( 'Expired', 'eduma' )   => 'expired',
					),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Number events display', 'eduma' ),
					'param_name'  => 'number_posts',
					'std'         => '2',
				),

				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Number events slider', 'eduma' ),
					'param_name' => 'number_posts_slider',
					'std'        => '2',
					'dependency' => array(
						'element' => 'layout',
						'value'   => array( 'layout-5', 'layout-6' ),
					),
				),

				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__( 'Background Image Bottom', 'eduma' ),
					'param_name'  => 'background_image',
					'description' => esc_html__( 'Select image from media library.', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'layout-5',
					),
				),

				array(
					'type'                  => 'textfield',
					'admin_label'           => true,
					'heading'               => esc_html__( 'Text View All', 'eduma' ),
					'param_name'            => 'text_link',
					'allow_html_formatting' => true,
					'std'                   => esc_html__( 'View All', 'eduma' ),
					'dependency'            => array(
						'element' => 'layout',
						'value'   => array( 'base', 'layout-2', 'layout-3', 'layout-4' ),
					),
				),
			);
		}

	}
}