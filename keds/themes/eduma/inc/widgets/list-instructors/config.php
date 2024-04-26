<?php
/**
 * Thim_Builder List Instructors config class
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

if ( ! class_exists( 'Thim_Builder_Config_List_Instructors' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_List_Instructors extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_List_Instructors constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'list-instructors';
			self::$name = esc_html__( 'Thim: List Instructors', 'eduma' );
			self::$desc = esc_html__( 'Display List Instructors', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-one-course-instructors';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => 'base',
						esc_html__( 'New', 'eduma' )     => 'new',
					),
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Heading', 'eduma' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Write the heading.', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'new',
					),
				),

				array(
					'type'        => 'param_group',
					'admin_label' => false,
					'heading'     => esc_html__( 'Tab Items', 'eduma' ),
					'param_name'  => 'panel',
					'params'      => array(
						array(
							'type'        => 'attach_image',
							'admin_label' => false,
							'heading'     => esc_html__( 'Image', 'eduma' ),
							'param_name'  => 'panel_img',
							'std'         => '14',
							'description' => esc_html__( 'Select image', 'eduma' ),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Select Instructor', 'eduma' ),
							'param_name' => 'panel_id',
							'value'      => thim_get_instructors( array( esc_html__( 'Select', 'eduma' ) => '' ), true ),
						),
					),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'new',
					),
					'group'       => esc_html__( 'Tab Settings', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => false,
					'heading'     => esc_html__( 'Limit', 'eduma' ),
					'param_name'  => 'limit_instructor',
					'std'         => '4',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),
				array(
					'type'        => 'number',
					'admin_label' => false,
					'heading'     => esc_html__( 'Visible Items', 'eduma' ),
					'param_name'  => 'visible_item',
					'std'         => '4',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => false,
					'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'  => 'show_pagination',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'Yes', 'eduma' )    => 'yes',
						esc_html__( 'No', 'eduma' )     => 'no',
					),
					'std'         => 'yes',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),
				array(
					'type'        => 'number',
					'admin_label' => false,
					'label'       => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'param_name'  => 'auto_play',
					'std'         => '0',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),
			);
		}

	}
}