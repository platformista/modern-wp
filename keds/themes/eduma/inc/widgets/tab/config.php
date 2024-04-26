<?php
/**
 * Thim_Builder Tab config class
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

if ( ! class_exists( 'Thim_Builder_Config_Tab' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Tab extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Tab constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'tab';
			self::$name = esc_html__( 'Thim: Tab', 'eduma' );
			self::$desc = esc_html__( 'Display Tab.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-timetable';
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
						esc_html__( 'Default', 'eduma' )        => 'base',
						esc_html__( 'Step', 'eduma' )        => 'step',
					),
					'std'=>''
				),

				array(
					'type'        => 'param_group',
					'admin_label' => false,
					'heading'     => esc_html__( 'Tab Items', 'eduma' ),
					'param_name'  => 'tab',
					'params'      => array(
						array(
							'type'       => 'textfield',
							'admin_label' => true,
							'value'      => '',
							'heading'    => esc_html__( 'Title', 'eduma' ),
							'std'        => esc_html__( 'Title', 'eduma' ),
							'param_name' => 'title',
							'allow_html_formatting' => true,
						),

						array(
							'type'        => 'textarea',
							'admin_label' => false,
							'heading'     => esc_html__( 'Content', 'eduma' ),
							'param_name'  => 'content',
							'std'         => esc_html__( 'Write a short description, that will describe the title or something informational and useful.', 'eduma' ),
						),
						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Background Title', 'eduma' ),
							'param_name'  => 'bg_title',
							'value'       => '',
							'description' => esc_html__( 'Select the color background for title. (for Layout Step)', 'eduma' ),
						),
						array(
							'type'       => 'textfield',
 							'value'      => '',
							'heading'    => esc_html__( 'Text Button', 'eduma' ),
 							'param_name' => 'text_button',
 						),
						array(
							'type'        => 'textfield',
							'type_el'        => 'vc_link',
							'admin_label' => false,
							'heading'     => esc_html__( 'Link', 'eduma' ),
							'param_name'  => 'link',
							'value'       => '',
							'description' => '',
						),
						array(
							'type'       => 'checkbox',
							'type_el'        => 'bp_hidden',
							'heading'    => esc_html__( 'Open in new window', 'eduma' ),
							'param_name' => 'is_external',
							'std'        => false,
 						),
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Add nofollow', 'eduma' ),
							'param_name' => 'nofollow',
							'std'        => false,
							'type_el'        => 'bp_hidden',
						),
					)
				),
			);
		}

	}
}