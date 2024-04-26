<?php
/**
 * Thim_Builder Multiple Images config class
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

if ( ! class_exists( 'Thim_Builder_Config_Multiple_Images' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Multiple_Images extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Multiple_Images constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'multiple-images';
			self::$name = esc_html__( 'Thim: Multiple Images', 'eduma' );
			self::$desc = esc_html__( 'Add Multiple Images', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-multiple-images';
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
					'heading'     => esc_html__( 'Heading', 'eduma' ),
					'param_name'  => 'title',
				),

				array(
					'type'        => 'attach_images',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image', 'eduma' ),
					'description' => esc_html__( 'Select image from media library.', 'eduma' ),
					'param_name'  => 'image',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image size', 'eduma' ),
					'param_name'  => 'image_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full"', 'eduma' ),
				),

				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Images url', 'eduma' ),
					'param_name'  => 'image_link',
					'description' => esc_html__( 'Enter URL if you want this image to have a link. These links are separated by comma (Ex: #,#,#,#)', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Column', 'eduma' ),
					'param_name'  => 'column',
					'description' => esc_html__( 'Number of columns display', 'eduma' ),
					'value'       => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
					),
					'std'         => '1'
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link Target', 'eduma' ),
					'param_name'  => 'link_target',
					'description' => esc_html__( 'Select Custom Font Weight', 'eduma' ),
					'value'       => array(
						esc_html__( 'Select','eduma' )               => '',
						esc_html__( 'Same window', 'eduma' ) => '_self',
						esc_html__( 'New window', 'eduma' )  => '_blank',
					),
					'std'      => '_self'
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}
