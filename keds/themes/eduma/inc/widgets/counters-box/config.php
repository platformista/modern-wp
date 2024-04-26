<?php
/**
 * Thim_Builder Counters Box config class
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

if ( ! class_exists( 'Thim_Builder_Config_Counters_Box' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Counters_Box extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Counters_Box constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'counters-box';
			self::$name = esc_html__( 'Thim: Counters Box', 'eduma');
			self::$desc = esc_html__('Display Counters Box.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-counters-box';
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
					'heading'     => esc_html__( 'Counters Label', 'eduma' ),
					'param_name'  => 'counters_label',
					'std'         => '',
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Counters Value', 'eduma' ),
					'param_name'  => 'counters_value',
					'std'         => '20',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text Number', 'eduma' ),
					'param_name'  => 'text_number',
					'std'         => '',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'View More Text', 'eduma' ),
					'param_name'  => 'view_more_text',
					'std'         => '',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'View More Link', 'eduma' ),
					'param_name'  => 'view_more_link',
					'std'         => '',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Counter Color', 'eduma' ),
					'param_name'  => 'counter_value_color',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Background Color', 'eduma' ),
					'param_name'  => 'background_color',
				),
				/* start */
				array(
					'type'        => 'dropdown',
					'admin_label' => false,
					'heading'     => esc_html__( 'Icon type', 'eduma' ),
					'param_name'  => 'icon_type',
					'description' => esc_html__( 'Select icon type to display', 'eduma' ),
					'value'       => array(
						esc_html__( 'Font Awesome', 'eduma' ) => 'font-awesome',
						esc_html__( 'Custom Image', 'eduma' ) => 'custom',
  						esc_attr__( "Font 7 stroke Icon", 'eduma' ) => "font-7-stroke",
						esc_attr__( "Font Flat Icon", 'eduma' )     => "font-flaticon",
 					),
  					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
				),

				array(
					'type'        => 'iconpicker',
					'admin_label' => false,
					'heading'     => esc_html__( 'Font Awesome Icon', 'eduma' ),
					'param_name'  => 'icon',
					'value'       => '',
					'description' => esc_html__( 'Select icon', 'eduma' ),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'font-awesome',
					),
 					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
				),
				array(
					"type"       => "iconpicker",
					"heading"    => esc_attr__( "Font 7 stroke Icon", 'eduma' ),
					"param_name" => "icon_stroke",
					"settings"   => array(
						'emptyIcon'     => true,
						'type'          => 'stroke_icon',
						'enqueue_style' => 'thim-admin-font-icon7',
						'prefix_icon' => 'pe-7s-',
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'font-7-stroke',
					),
 				),
				array(
					"type"       => "iconpicker",
					"heading"    => esc_attr__( "Font Flat Icon", 'eduma' ),
					"param_name" => "icon_flat",
					"settings"   => array(
						'emptyIcon'     => true,
						'type'          => 'flat_icon',
 						'prefix_icon' => 'flaticon-',
						'enqueue_style' => 'thim-admin-font-flaticon',
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'font-flaticon',
					),
 				),
				array(
					'type'        => 'attach_image',
					'admin_label' => false,
					'heading'     => esc_html__( 'Image Icon', 'eduma' ),
					'param_name'  => 'icon_img',
					'std'         => '14',
					'description' => esc_html__( 'Select custom image icon', 'eduma' ),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'custom',
					),
 					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
				),
				/* end */

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Border Color Icon', 'eduma' ),
					'param_name'  => 'border_color',
					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Counters Icon Color', 'eduma' ),
					'param_name'  => 'counter_color',
					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
				),

				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Counters Label Color', 'eduma' ),
					'param_name'  => 'counter_label_color',
 				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Style', 'eduma' ),
					'param_name'  => 'style',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )        => '',
						esc_html__( 'Home Page', 'eduma' )     => 'home-page',
						esc_html__( 'Page About Us', 'eduma' ) => 'about-us',
						esc_html__( 'Number Left', 'eduma' )   => 'number-left',
						esc_html__( 'Text Gradient', 'eduma' )   => 'text-gradient',
                        esc_html__( 'Demo Eduma Elegant', 'eduma' )   => 'demo-elegant',
					),
				),


			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}