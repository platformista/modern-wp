<?php
/**
 * Thim_Builder Button config class
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

if ( ! class_exists( 'Thim_Builder_Config_Carousel_Post' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Carousel_Post extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Carousel_Post constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'carousel-post';
			self::$name = esc_html__( 'Thim: Carousel Posts', 'eduma' );
			self::$desc = esc_html__( 'Display posts with carousel.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-carousel-posts';

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
					'allow_html_formatting' => true,
					'value'       => '',
				),

				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Select Category', 'eduma' ),
					'param_name' => 'cat_id',
					'std'        => 'all',
					'value'      => thim_get_cat_taxonomy( 'category', array( esc_html__( 'All', 'eduma' ) => 'all' ), true ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' )  => 'base',
						esc_html__( 'Layout 2', 'eduma' ) => 'layout-2',
						esc_html__( 'Layout 3', 'eduma' ) => 'layout-3',
					),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Posts visible', 'eduma' ),
					'param_name'  => 'visible_post',
					'std'         => '3',
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Number posts', 'eduma' ),
					'param_name'  => 'number_posts',
					'std'         => '6',
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Navigation', 'eduma' ),
					'param_name'  => 'show_nav',
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
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name'  => 'auto_play',
					'value'       => '',
					'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'std'         => '0',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Order by', 'eduma' ),
					'param_name'  => 'orderby',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )  => '',
						esc_html__( 'Popular', 'eduma' ) => 'popular',
						esc_html__( 'Recent', 'eduma' )  => 'recent',
						esc_html__( 'Title', 'eduma' )   => 'title',
						esc_html__( 'Random', 'eduma' )  => 'random',
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Order', 'eduma' ),
					'param_name'  => 'order',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'ASC', 'eduma' )    => 'asc',
						esc_html__( 'DESC', 'eduma' )   => 'desc',
					),
				),
			);
		}

//		public function get_template_name() {
//			return 'base';
//		}
	}
}