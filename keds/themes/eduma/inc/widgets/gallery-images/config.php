<?php
/**
 * Thim_Builder Gallery Images config class
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

if ( ! class_exists( 'Thim_Builder_Config_Gallery_Images' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Gallery_Images extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Gallery_Images constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'gallery-images';
			self::$name = esc_html__( 'Thim: Gallery Images', 'eduma' );
			self::$desc = esc_html__( 'Display Gallery Images.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-gallery-images';
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
					'allow_html_formatting' => true,
					'description' => esc_html__( 'Write the heading.', 'eduma' )
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
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full"', 'eduma' )
				),

				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image Link', 'eduma' ),
					'param_name'  => 'image_link',
					'description' => esc_html__( 'Enter URL if you want this image to have a link. These links are separated by comma (Ex: #,#,#,#)', 'eduma' )
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Have Color?', 'eduma' ),
					'param_name'  => 'have_color',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'Yes', 'eduma' )    => 'yes',
						esc_html__( 'No', 'eduma' )     => 'no',
					),
					'std'         => 'yes',
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Visible Items', 'eduma' ),
					'param_name'  => 'number',
					'std'         => '4',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Tablet Items', 'eduma' ),
					'param_name'  => 'item_tablet',
					'std'         => '2',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Mobile Items', 'eduma' ),
					'param_name'  => 'item_mobile',
					'std'         => '1',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'  => 'show_pagination',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'Yes', 'eduma' )    => 'yes',
						esc_html__( 'No', 'eduma' )     => 'no',
					),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Navigation', 'eduma' ),
					'param_name'  => 'show_navigation',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'Yes', 'eduma' )    => 'yes',
						esc_html__( 'No', 'eduma' )     => 'no',
					),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name'  => 'auto_play',
					'std'         => '0',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
					'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' )
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link Target', 'eduma' ),
					'param_name'  => 'link_target',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )      => '',
						esc_html__( 'Same window', 'eduma' ) => '_self',
						esc_html__( 'New window', 'eduma' )  => '_blank',
					),
				)
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}