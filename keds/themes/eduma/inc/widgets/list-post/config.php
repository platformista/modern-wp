<?php
/**
 * Thim_Builder List Post config class
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

if ( ! class_exists( 'Thim_Builder_Config_List_Post' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_List_Post extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_List_Post constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'list-post';
			self::$name = esc_html__( 'Thim: List Posts', 'eduma' );
			self::$desc = esc_html__( 'Display list posts.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-list-post';
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
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Number posts', 'eduma' ),
					'param_name'  => 'number_posts',
					'std'         => '4',
				),

				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Select Category', 'eduma' ),
					'param_name' => 'cat_id',
					'value'      => thim_get_cat_taxonomy( 'category', array( esc_html__( 'All', 'eduma' ) => 'all' ), true ),
					'std'        => 'all'
				),

				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Show Description', 'eduma' ),
					'param_name'  => 'show_description',
					'value'       => array(
						esc_html__( 'Yes', 'eduma' ) => true,
					),
					'std'         => true,
					'save_always' => true,
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
					'std'         => 'popular'
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
					'std'         => 'asc'
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => 'base',
						esc_html__( 'Grid', 'eduma' )    => 'grid',
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Style', 'eduma' ),
					'param_name'  => 'style',
					'value'       => array(
						esc_html__( 'Style 01 -Home Page', 'eduma' ) => 'homepage',
						esc_html__( 'Style 02', 'eduma' )            => 'style_2',
						esc_html__( 'Style 03 - Sidebar', 'eduma' )  => 'sidebar',
						esc_html__( 'Style 04 -Home Grad', 'eduma' ) => 'home-new',
					),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Sub Title', 'eduma' ),
					'param_name' => 'sub_title',
					'dependency' => array(
						'element' => 'style',
						'value'   => 'style_2',
					),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Select Image Size', 'eduma' ),
					'param_name' => 'image_size',
					'value'      => thim_sc_get_list_image_size(),
				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Image width', 'eduma' ),
					'param_name'    => 'img_w',
					'value'         => '',
					'group'         => esc_html__( 'Grid Settings', 'eduma' ),
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'grid',
					),
					'start_section' => 'grid_settings'
				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Image height', 'eduma' ),
					'param_name'    => 'img_h',
					'value'         => '',
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'grid',
					),
					'group'         => esc_html__( 'Grid Settings', 'eduma' ),
 				),

				array(
					'type'          => 'checkbox',
					'heading'       => esc_html__( 'Show feature posts', 'eduma' ),
					'param_name'    => 'display_feature',
					'value'         => array(
						esc_html__( 'Yes', 'eduma' ) => 'yes',
					),
					'group'         => esc_html__( 'Grid Settings', 'eduma' ),
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'grid',
					),
 				),

				array(
					'type'          => 'number',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Items vertical', 'eduma' ),
					'param_name'    => 'item_vertical',
					'std'           => '0',
					'group'         => esc_html__( 'Grid Settings', 'eduma' ),
					'dependency'    => array(
						'element' => 'layout',
						'value'   => 'grid',
					),
 				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Link All Posts', 'eduma' ),
					'param_name'    => 'link',
					'value'         => '',
					'start_section' => 'link_group',
					'section_name'  => esc_html__( 'Link', 'eduma' ),

				),

				array(
					'type'          => 'textfield',
					'admin_label'   => true,
					'heading'       => esc_html__( 'Text All Posts', 'eduma' ),
					'param_name'    => 'text_link',
					'value'         => '',
 					'section_name'  => esc_html__( 'Link', 'eduma' )
				),


			);
		}

	}
}