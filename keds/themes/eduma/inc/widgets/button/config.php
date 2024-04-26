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

if ( ! class_exists( 'Thim_Builder_Config_Button' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Button extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Button constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'button';
			self::$name = esc_html__( 'Thim: Button', 'eduma' );
			self::$desc = esc_html__( 'Add Button', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-button';
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
					'heading'     => esc_html__( 'Button Text', 'eduma' ),
					'param_name'  => 'title',
					'std'         => esc_html__( 'READ MORE', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Destination URL', 'eduma' ),
					'param_name'  => 'url',
					'allow_html_formatting' => true,
					'std'         => '#',
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Open in New Window', 'eduma' ),
					'param_name'  => 'new_window',
					'std'         => false,
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Style', 'eduma' ),
					'param_name'  => 'custom_style',
					'value'       => array(
						esc_html__( 'Default', 'eduma' )      => 'default',
						esc_html__( 'Custom Style', 'eduma' ) => 'custom_style',
					),
					'std'         => 'default'
				),

                //Alignment
                array(
                    'type'        => 'dropdown',
                    'admin_label' => false,
                    'heading'     => esc_html__( 'Text alignment', 'eduma' ),
                    'param_name'  => 'text_align',
                    'value'       => array(
                        'Choose the text alignment'     => '',
                        __( 'Text at left', 'eduma' )   => 'text-left',
                        __( 'Text at center', 'eduma' ) => 'text-center',
                        __( 'Text at right', 'eduma' )  => 'text-right',
                    ),
                ),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Font Size', 'eduma' ),
					'param_name'  => 'font_size',
					'description' => esc_html__( 'Select font size. Unit is px', 'eduma' ),
					'std'         => '14',
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Font Weight', 'eduma' ),
					'param_name'  => 'font_weight',
					'description' => esc_html__( 'Select Custom Font Weight', 'eduma' ),
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'Normal', 'eduma' ) => 'normal',
						esc_html__( 'Bold', 'eduma' )   => 'bold',
						esc_html__( '100', 'eduma' )    => '100',
						esc_html__( '200', 'eduma' )    => '200',
						esc_html__( '300', 'eduma' )    => '300',
						esc_html__( '400', 'eduma' )    => '400',
						esc_html__( '500', 'eduma' )    => '500',
						esc_html__( '600', 'eduma' )    => '600',
						esc_html__( '700', 'eduma' )    => '700',
						esc_html__( '800', 'eduma' )    => '800',
						esc_html__( '900', 'eduma' )    => '900',
					),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
 					'group_id'       => 'style_options',
					'std'         => ''
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Border Width', 'eduma' ),
					'description' => esc_html__( 'Enter border width.', 'eduma' ),
					'param_name'  => 'border_width',
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
					'std'         => '0'
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Color', 'eduma' ),
					'param_name'  => 'color',
					'description' => esc_html__( 'Select the text color.', 'eduma' ),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Border color', 'eduma' ),
					'param_name'  => 'border_color',
					'description' => esc_html__( 'Select the border color.', 'eduma' ),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Select background color', 'eduma' ),
					'param_name'  => 'bg_color',
					'description' => esc_html__( 'Select the background color.', 'eduma' ),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Hover color', 'eduma' ),
					'param_name'  => 'hover_color',
					'description' => esc_html__( 'Select the hover text color.', 'eduma' ),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Hover border color', 'eduma' ),
					'param_name'  => 'hover_border_color',
					'description' => esc_html__( 'Select the hover border color.', 'eduma' ),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'colorpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Hover background color', 'eduma' ),
					'param_name'  => 'hover_bg_color',
					'description' => esc_html__( 'Select the hover background color.', 'eduma' ),
					'dependency'  => array(
						'element' => 'custom_style',
						'value'   => 'custom_style',
					),
					'group'       => esc_html__( 'Custom Settings', 'eduma' ),
					'group_id'       => 'style_options',
				),

				array(
					'type'        => 'iconpicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Select icon', 'eduma' ),
					'param_name'  => 'icon',
					'value'       => '',
					'description' => esc_html__( 'Select the icon', 'eduma' ),
					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
					'group_id'       => 'icon',
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon size.', 'eduma' ),
					'param_name'  => 'icon_size',
					'description' => esc_html__( 'Select the icon font size. Unit is px', 'eduma' ),
					'std'         => '14',
					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
					'group_id'       => 'icon',
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Icon Position', 'eduma' ),
					'param_name'  => 'icon_position',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )      => '',
						esc_html__( 'Before text', 'eduma' ) => 'before',
						esc_html__( 'After text', 'eduma' )  => 'after',
					),
					'std'         => '',
					'group'       => esc_html__( 'Icon Settings', 'eduma' ),
					'group_id'       => 'icon',
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Button size', 'eduma' ),
					'param_name'  => 'button_size',
					'value'       => array(
						esc_html__( 'Normal', 'eduma' ) => 'normal',
						esc_html__( 'Small', 'eduma' )  => 'small',
						esc_html__( 'Medium', 'eduma' ) => 'medium',
						esc_html__( 'Large', 'eduma' )  => 'large',
					),
					'std'         => 'normal',
					'group'       => esc_html__( 'Layout Settings', 'eduma' ),
					'group_id'       => 'layout',

				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Rounding', 'eduma' ),
					'param_name'  => 'rounding',
					'value'       => array(
						esc_html__( 'None', 'eduma' )         => '',
						esc_html__( 'Tiny Rounded', 'eduma' ) => 'tiny-rounded',
						esc_html__( 'Very Rounded', 'eduma' ) => 'very-rounded',
					),
					'std'         =>'',
					'group'       => esc_html__( 'Layout Settings', 'eduma' ),
					'group_id'       => 'layout',
				),

			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}