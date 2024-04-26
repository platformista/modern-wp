<?php
/**
 * Thim_Builder Single Images config class
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

if ( ! class_exists( 'Thim_Builder_Config_Single_Images' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Single_Images extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Single_Images constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'single-images';
			self::$name = esc_html__( 'Thim: Single Image', 'eduma' );
			self::$desc = esc_html__( 'Display single images.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-single-images';
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
						esc_html__( 'Default', 'eduma' )  => 'base',
						esc_html__( 'Layout 2', 'eduma' ) => 'layout-2',
					),
					'std'         => 'base'
				),

				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image', 'eduma' ),
					'param_name'  => 'image',
					'description' => esc_html__( 'Select image from media library.', 'eduma' )
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image Title', 'eduma' ),
					'param_name'  => 'image_title',
					'description' => esc_html__( 'Enter image title.', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'layout-2',
					),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image size', 'eduma' ),
					'param_name'  => 'image_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'On click action', 'eduma' ),
					'param_name'  => 'on_click_action',
					'value'       => array(
						esc_html__( 'None', 'eduma' )             => 'none',
						esc_html__( 'Open custom link', 'eduma' ) => 'custom-link',
						esc_html__( 'Open popup', 'eduma' )       => 'popup',
					),
					'std'         => 'none',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Image Link', 'eduma' ),
					'param_name'  => 'image_link',
					'description' => esc_html__( 'Enter URL if you want this image to have a link.', 'eduma' ),
					'dependency'  => array(
						'element' => 'on_click_action',
						'value'   => 'custom-link',
					),
				),

				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Link Target', 'eduma' ),
					'param_name' => 'link_target',
					'value'      => array(
						esc_html__( 'Same window', 'eduma' ) => '_self',
						esc_html__( 'New window', 'eduma' )  => '_blank',
					),
					'dependency' => array(
						'element' => 'on_click_action',
						'value'   => 'custom-link',
					),
					'std'        => '_self',
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Image alignment', 'eduma' ),
					'param_name'  => 'image_alignment',
					'description' => esc_html__( 'Select image alignment.', 'eduma' ),
					'value'       => array(
						esc_html__( 'Align Left', 'eduma' )   => 'left',
						esc_html__( 'Align Center', 'eduma' ) => 'center',
						esc_html__( 'Align Right', 'eduma' )  => 'right',
					),
					'std'         => 'left',
				)

			);
		}
	}
}