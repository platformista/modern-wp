<?php
/**
 * Thim_Builder Accordion config class
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

if ( ! class_exists( 'Thim_Builder_Config_Accordion' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Accordion extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Accordion constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'accordion';
			self::$name = esc_html__( 'Thim: Accordion', 'eduma' );
			self::$desc = esc_html__( 'Add Accordion', 'eduma' );
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
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'value'       => '',
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Style', 'eduma' ),
					'param_name'  => 'style',
					'value'       => array(
						esc_html__( 'Default', 'eduma' )   => 'default',
						esc_html__( 'New Style', 'eduma' ) => 'new-style',
					),
					'std'         => 'default'
				),
				array(
					'type'        => 'param_group',
					'admin_label' => false,
					'heading'     => esc_html__( 'Accordion Items', 'eduma' ),
					'param_name'  => 'panel',
					'params'      => array(
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'value'       => '',
							'heading'     => esc_html__( 'Title', 'eduma' ),
							'std'         => esc_html__( 'Title', 'eduma' ),
							'param_name'  => 'panel_title',
						),
						array(
							'type'                  => 'textarea',
							'admin_label'           => false,
							'allow_html_formatting' => true,
							'heading'               => esc_html__( 'Content', 'eduma' ),
							'param_name'            => 'panel_body',
							'std'                   => esc_html__( 'Write a short description, that will describe the title or something informational and useful.', 'eduma' ),
						),

					)
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}