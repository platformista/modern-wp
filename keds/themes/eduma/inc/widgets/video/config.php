<?php
/**
 * Thim_Builder Video config class
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

if ( ! class_exists( 'Thim_Builder_Config_Video' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Video extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Video constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'video';
			self::$name = esc_html__( 'Thim: Video', 'eduma' );
			self::$desc = esc_html__( 'Display video youtube or vimeo.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-video';
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
						esc_html__( 'Basic', 'eduma' ) => 'base',
						esc_html__( 'Popup', 'eduma' ) => 'popup',
						esc_html__( 'Image Popup', 'eduma' ) => 'image-popup',
					),
					'std' => 'base'
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Width video', 'eduma' ),
					'param_name'  => 'video_width',
					'value'       => '',
					'description' => esc_html__( 'Enter width of video. Example 100% or 600. ', 'eduma' )
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Height video', 'eduma' ),
					'param_name'  => 'video_height',
					'value'       => '',
					'description' => esc_html__( 'Enter height of video. Example 100% or 600.', 'eduma' )
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Video Source', 'eduma' ),
					'param_name'  => 'video_type',
					'value'       => array(
						esc_html__( 'Vimeo', 'eduma' )   => 'vimeo',
						esc_html__( 'Youtube', 'eduma' ) => 'youtube',
					),
					'std' => 'vimeo'
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Vimeo Video ID', 'eduma' ),
					'param_name'  => 'external_video',
					'std'         => '61389324',
					'description' => esc_html__( 'Enter vimeo video ID . Example if link video https://player.vimeo.com/video/61389324 then video ID is 61389324 ', 'eduma' ),
					'dependency'  => array(
						'element' => 'video_type',
						'value'   => 'vimeo',
					),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Youtube Video ID', 'eduma' ),
					'param_name'  => 'youtube_id',
					'std'         => 'orl1nVy4I6s',
					'description' => esc_html__( 'Enter Youtube video ID . Example if link video https://www.youtube.com/watch?v=orl1nVy4I6s then video ID is orl1nVy4I6s ', 'eduma' ),
					'dependency'  => array(
						'element' => 'video_type',
						'value'   => 'youtube',
					),
				),

				array(
					'type'        => 'attach_image',
					'admin_label' => true,
					'heading'     => esc_html__( 'Poster', 'eduma' ),
					'param_name'  => 'poster',
					'description' => esc_html__( 'Poster background display on popup video.', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array('image-popup','popup'),
					),
					'group'       => esc_html__( 'Popup Settings', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'value'       => '',
					'description' => esc_html__( 'Title display on popup video', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array('image-popup','popup'),
					),
					'group'       => esc_html__( 'Popup Settings', 'eduma' ),
				),

				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Description', 'eduma' ),
					'param_name'  => 'description',
					'description' => esc_html__( 'Description display on popup video', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array('image-popup','popup'),
					),
					'group'       => esc_html__( 'Popup Settings', 'eduma' ),
				),
			);
		}
	}
}