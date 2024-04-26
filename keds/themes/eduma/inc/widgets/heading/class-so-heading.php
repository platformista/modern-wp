<?php
/**
 * Thim_Builder Siteorigin Heading widget
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

if ( ! class_exists( 'Thim_Heading_Widget' ) ) {
	/**
	 * Class Thim_Heading_Widget
	 */
	class Thim_Heading_Widget extends Thim_Builder_SO_Widget { 

		/**
		 * Thim_Heading_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Heading';

			parent::__construct();
		}
		// over writer config
		function get_config_options() {
			return array(
				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'value'       => '',
					'allow_html_formatting' => true,
					'description' => esc_html__( 'Write the title for the heading.', 'eduma' )
				),
				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Main Title', 'eduma' ),
					'param_name'  => 'main_title',
					'value'       => '',
					'description' => esc_html__( 'Write the Main title for the heading.', 'eduma' )
				),
				array(
					'type'        => 'checkbox',
					'admin_label' => false,
					'heading'     => esc_html__( 'Title Uppercase?', 'eduma' ),
					'param_name'  => 'title_uppercase',
					'std'         => true,
					//				'description' => esc_html__( 'Title Uppercase?', 'eduma' ),
				),
				//Title color
				array(
					'type'        => 'colorpicker',
					'admin_label' => false,
					'heading'     => esc_html__( 'Heading color ', 'eduma' ),
					'param_name'  => 'textcolor',
					'value'       => '',
					'description' => esc_html__( 'Select the title color.', 'eduma' ),
					'group'       => esc_html__( 'Heading Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => false,
					'heading'     => esc_html__( 'Heading tag', 'eduma' ),
					'param_name'  => 'size',
					'value'       => array(
						__( 'Select tag', 'eduma' ) => '',
						'h2' => 'h2',
						'h3' => 'h3',
						'h4' => 'h4',
						'h5' => 'h5',
						'h6' => 'h6',
					),
					'std'         => 'h3',
					'description' => esc_html__( 'Choose heading element.', 'eduma' ),
					'group'       => esc_html__( 'Heading Settings', 'eduma' ),
				),

				// Description
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Sub heading', 'eduma' ),
					'param_name'  => 'sub_heading',
					'value'       => '',
					'allow_html_formatting' => true,
					'description' => esc_html__( 'Enter sub heading.', 'eduma' )
				),
				//Description color
				array(
					'type'        => 'colorpicker',
					'admin_label' => false,
					'heading'     => esc_html__( 'Sub heading color ', 'eduma' ),
					'param_name'  => 'sub_heading_color',
					'value'       => '',
					'description' => esc_html__( 'Select the sub heading color.', 'eduma' ),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => false,
					'heading'     => esc_html__( 'Clone Title?', 'eduma' ),
					'param_name'  => 'clone_title',
					'std'         => false,
					'description' => esc_html__( 'Clone Title.', 'eduma' ),
				),
				//Use custom or default title?
				array(
					'type'        => 'dropdown',
					'admin_label' => false,
					'heading'     => esc_html__( 'Use custom or default title?', 'eduma' ),
					'param_name'  => 'font_heading',
					'value'       => array(
						__( 'Default', 'eduma' ) => 'default',
						__( 'Custom', 'eduma' )  => 'custom',
					),
					'description' => esc_html__( 'If you select default you will use default title which customized in typography.', 'eduma' ),
				),
				array(
					'type'       => 'section',
					'value'      => '',
					'heading'    => __( 'Heading Settings', 'eduma' ),
					'param_name' => 'custom_font_heading',
					'params'     => array(
						array(
							'type'        => 'number',
							'admin_label' => false,
							'heading'     => esc_html__( 'Font size ', 'eduma' ),
							'param_name'  => 'font_size',
							'min'         => 0,
							'value'       => '',
							'suffix'      => 'px',
							'description' => esc_html__( 'Custom title font size.', 'eduma' ),
							'std'         => '14',
							"class"       => "color-mini",
						),
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Font Weight ', 'eduma' ),
							'param_name'  => 'font_weight',
							"class"       => "color-mini",
							'value'       => array(
								__( 'Custom font weight', 'eduma' ) => '',
								__( 'Normal', 'eduma' )             => 'normal',
								__( 'Bold', 'eduma' )               => 'bold',
								__( '100', 'eduma' )                => '100',
								__( '200', 'eduma' )                => '200',
								__( '300', 'eduma' )                => '300',
								__( '400', 'eduma' )                => '400',
								__( '500', 'eduma' )                => '500',
								__( '600', 'eduma' )                => '600',
								__( '700', 'eduma' )                => '700',
								__( '800', 'eduma' )                => '800',
								__( '900', 'eduma' )                => '900',
							),
							'description' => esc_html__( 'Custom title font weight.', 'eduma' ),
						),
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Font style ', 'eduma' ),
							'param_name'  => 'font_style',
							'value'       => array(
								__( 'Choose the title font style', 'eduma' ) => '',
								__( 'Italic', 'eduma' )                      => 'italic',
								__( 'Oblique', 'eduma' )                     => 'oblique',
								__( 'Initial', 'eduma' )                     => 'initial',
								__( 'Inherit', 'eduma' )                     => 'inherit',
								__( 'Normal', 'eduma' )                      => 'normal',
							),
							"class"       => "color-mini",
							'description' => esc_html__( 'Custom title font style.', 'eduma' ),
						),
					),
					'dependency' => array(
						'element' => 'font_heading',
						'value'   => 'custom',
					),
				),
				//Show separator?
				array(
					'type'        => 'checkbox',
					'admin_label' => false,
					'heading'     => esc_html__( 'Show Separator?', 'eduma' ),
					'param_name'  => 'line',
					'std'         => true,
					'description' => esc_html__( 'Tick it to show the separator between title and description.', 'eduma' ),
				),
				//Separator color
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Separator color', 'eduma' ),
					'param_name'  => 'bg_line',
					'value'       => '',
					'description' => esc_html__( 'Choose the separator color.', 'eduma' ),
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
				)
			);
		}
	}
}

