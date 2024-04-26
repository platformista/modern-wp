<?php
/**
 * Thim_Builder Image Box config class
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

if ( ! class_exists( 'Thim_Builder_Config_Image_Box' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Image_Box extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Image_Box constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'image-box';
			self::$name = esc_html__( 'Thim: Image Box', 'eduma' );
			self::$desc = esc_html__( 'Add Image box', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-icon-box';
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
						esc_html__( 'Layout 2', 'eduma' )        => 'layout-2',
					),
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Provide the title for this box.', 'eduma' ),
				),
				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description', 'eduma' ),
					'param_name'  => 'description',
					'allow_html_formatting' => true,
					'value'       => '',
					'description' => esc_html__( 'Provide the description for this box.', 'eduma' ),
					'dependency' => array(
						'element_el' => 'style',
						'element' => 'layout',
						'value'   => 'layout-2',
					),
				),
				array(
					'type'        => 'attach_image',
					'admin_label' => false,
					'heading'     => esc_html__( 'Image Of Box', 'eduma' ),
					'description' => esc_html__( 'Select image from media library.', 'eduma' ),
					'param_name'  => 'image',
				),
				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title Background Color', 'eduma' ),
					'param_name'  => 'title_bg_color',
					'dependency' => array(
						'element_el' => 'style',
						'element' => 'layout',
						'value'   => 'layout-2',
					),
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link', 'eduma' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Provide the title for this box.', 'eduma' ),
				),
			);
		}
	}
}