<?php
/**
 * Thim_Builder Testimonials config class
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

if ( ! class_exists( 'Thim_Builder_Config_Testimonials' ) ) {
	/**
	 * Class Thim_Builder_Config_Testimonials
	 */
	class Thim_Builder_Config_Testimonials extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Testimonials constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'testimonials';
			self::$name = esc_html__( 'Thim: Testimonials', 'eduma' );
			self::$desc = esc_html__( 'Display testimonials.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-testimonials';

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
					'allow_html_formatting' => true,
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' )  => 'default',
						esc_html__( 'Slider', 'eduma' )   => 'slider',
						esc_html__( 'Slider 2', 'eduma' ) => 'slider-2',
						esc_html__( 'Carousel', 'eduma' ) => 'carousel',
					),
					'std'         => 'default',
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Carousel Style', 'eduma' ),
					'param_name'  => 'carousel_style',
					'value'       => array(
						esc_html__( 'Carousel Style 1', 'eduma' ) => 'style_1',
						esc_html__( 'Carousel Style 2', 'eduma' ) => 'style_2',
						esc_html__( 'Carousel Style 3', 'eduma' ) => 'style_3',
					),
					'std'         => 'style_1',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'carousel',
					),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Limit Posts', 'eduma' ),
					'param_name'  => 'limit',
					'std'         => '7',
				),

				array(
					'type'        => 'number',
					'admin_label' => false,
					'heading'     => esc_html__( 'Items padding', 'eduma' ),
					'param_name'  => 'activepadding',
					'std'         => '0',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'slider', 'slider-2' ),
					),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Items visible', 'eduma' ),
					'param_name'  => 'item_visible',
					'std'         => '5',
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Time', 'eduma' ),
					'param_name'  => 'pause_time',
					'std'         => 5000,
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Auto play', 'eduma' ),
					'param_name'  => 'autoplay',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'default', 'slider', 'slider-2' ),
					),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Mousewheel Scroll', 'eduma' ),
					'param_name'  => 'mousewheel',
					'std'         => false,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'default', 'slider', 'slider-2' ),
					),
				),
				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link To Single', 'eduma' ),
					'param_name'  => 'link_to_single',
					'std'         => false,
				),

				array(
					'type'          => 'checkbox',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'    => 'show_pagination',
					'std'           => false,
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'carousel',
					),
					'group'         => esc_html__( 'Carousel Options', 'eduma' ),
					'group_id'      => 'carousel-options',
					'start_section' => 'carousel-options',
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Navigation', 'eduma' ),
					'param_name'  => 'show_navigation',
					'std'         => true,

					'dependency' => array(
						'element' => 'layout',
						'value'   => 'carousel',
					),
					'group'      => esc_html__( 'Carousel Options', 'eduma' ),
					'group_id'   => 'carousel-options',
				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name'    => 'carousel_autoplay',
					'param_name_so' => 'autoplay',
					'description'   => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'std'           => 0,
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'carousel',
					),
					'group'         => esc_html__( 'Carousel Options', 'eduma' ),
					'group_id'      => 'carousel-options',
				),


			);
		}

		//		public function get_template_name(){
		//			return 'base';
		//		}
	}
}