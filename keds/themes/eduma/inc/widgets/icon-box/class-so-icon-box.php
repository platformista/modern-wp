<?php
/**
 * Thim_Builder Siteorigin Icon Box widget
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

if ( ! class_exists( 'Thim_Icon_Box_Widget' ) ) {
	/**
	 * Class Thim_Icon_Box_Widget
	 */
	class Thim_Icon_Box_Widget extends Thim_Builder_SO_Widget {

		/**
		 * Thim_Icon_Box_Widget constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Icon_Box';

			parent::__construct();
		}

		// overwriter param in file config
		function get_config_options() {
			// options
			return array(
				array(
					'type'       => 'section',
					'heading'    => __( 'Title Options', 'eduma' ),
					'param_name' => 'title_group',
					'hide'       => true,
					'params'     => array(
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Heading', 'eduma' ),
							'param_name'  => 'title',
							'allow_html_formatting' => true,
							'description' => esc_html__( 'Provide the title for this icon box.', 'eduma' ),
						),
						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Heading color', 'eduma' ),
							'param_name'  => 'color_title',
							'value'       => '',
							'description' => esc_html__( 'Select the title color.', 'eduma' ),
						),
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Size heading', 'eduma' ),
							'param_name'  => 'size',
							'value'       => array(
								esc_html__( 'Select tag', 'eduma' ) => '',
								esc_html__( 'h2', 'eduma' )         => 'h2',
								esc_html__( 'h3', 'eduma' )         => 'h3',
								esc_html__( 'h4', 'eduma' )         => 'h4',
								esc_html__( 'h5', 'eduma' )         => 'h5',
								esc_html__( 'h6', 'eduma' )         => 'h6',
							),
							'std'         => 'h3'
						),
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Custom heading', 'eduma' ),
							'param_name'  => 'font_heading',
							'value'       => array(
								esc_html__( 'Default', 'eduma' ) => 'default',
								esc_html__( 'Custom', 'eduma' )  => 'custom',
							),
						),
						array(
							'type'       => 'section',
							'hide'       => true,
							'heading'    => __( 'Heading Settings', 'eduma' ),
							'param_name' => 'custom_heading',
							'params'     => array(
								array(
									'type'        => 'number',
									'admin_label' => false,
									'heading'     => esc_html__( 'Font size', 'eduma' ),
									'param_name'  => 'custom_font_size',
									'std'         => '14',
									'description' => esc_html__( 'Custom title font size. Unit is pixel', 'eduma' ),
								),
								array(
									'type'        => 'dropdown',
									'admin_label' => false,
									'heading'     => esc_html__( 'Font Weight', 'eduma' ),
									'param_name'  => 'custom_font_weight',
									'description' => esc_html__( 'Select Custom Title Font Weight', 'eduma' ),
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
								),

								array(
									'type'        => 'number',
									'admin_label' => false,
									'heading'     => esc_html__( 'Margin Top', 'eduma' ),
									'param_name'  => 'custom_mg_bt',
									'std'         => '0',
								),

								array(
									'type'        => 'number',
									'admin_label' => false,
									'heading'     => esc_html__( 'Margin Bottom', 'eduma' ),
									'param_name'  => 'custom_mg_top',
									'std'         => '0',
								),
							),
							'dependency' => array(
								'element' => 'font_heading',
								'value'   => 'custom',
							),
						),
						array(
							'type'        => 'checkbox',
							'admin_label' => false,
							'heading'     => esc_html__( 'Show separator', 'eduma' ),
							'param_name'  => 'line_after_title',
							'std'         => false,
						),
					)
				),

				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Description', 'eduma' ),
					'param_name' => 'desc_group',
					'params'     => array(
						array(
							'type'        => 'textarea',
							'admin_label' => false,
							'heading'     => esc_html__( 'Description', 'eduma' ),
							'param_name'  => 'content',
							'allow_html_formatting' => true,
							'std'         => esc_html__( 'Write a short description that will describe the title or something informational and useful.', 'eduma' ),
						),
						array(
							'type'        => 'number',
							'admin_label' => false,
							'heading'     => esc_html__( 'Description size', 'eduma' ),
							'param_name'  => 'custom_font_size_des',
							'description' => esc_html__( 'Custom description font size. Unit is pixel', 'eduma' ),
							'std'         => '14'
						),

						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Description font weight', 'eduma' ),
							'param_name'  => 'custom_font_weight',
							'description' => esc_html__( 'Select custom description font weight', 'eduma' ),
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
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Description color', 'eduma' ),
							'param_name'  => 'color_description',
							'description' => esc_html__( 'Select the description color.', 'eduma' ),
						),
					)
				),
				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Link Icon Box', 'eduma' ),
					'param_name' => 'read_more_group',
					'params'     => array(
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Link', 'eduma' ),
							'param_name'  => 'link',
							'value'       => '',
							'description' => esc_html__( 'Provide the link that will be applied to this icon box.', 'eduma' ),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Target link', 'eduma' ),
							'param_name' => 'target',
							'value'      => array(
								esc_html__( 'Select', 'eduma' ) => '',
								esc_html__( 'Blank', 'eduma' )  => '_blank',
								esc_html__( 'Self', 'eduma' )   => '_self',
								esc_html__( 'Parent', 'eduma' ) => '_parent',
							),
							'std'        => '_self'
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Apply read more link to:', 'eduma' ),
							'param_name'  => 'read_more',
							'description' => esc_html__( 'Select Custom Title Font Weight', 'eduma' ),
							'value'       => array(
								esc_html__( 'Select', 'eduma' )            => '',
								esc_html__( 'Complete Box', 'eduma' )      => 'complete_box',
								esc_html__( 'Box Title', 'eduma' )         => 'title',
								esc_html__( 'Display Read More', 'eduma' ) => 'more',
							),
						),
						array(
							'type'        => 'checkbox',
							'admin_label' => false,
							'heading'     => esc_html__( 'Show Link To Icon', 'eduma' ),
							'param_name'  => 'link_to_icon',
							'std'         => false,
						),
						array(
							'type'       => 'section',
							'hide'       => true,
							'heading'    => __( 'Option Button Read More', 'eduma' ),
							'param_name' => 'button_read_more_group',
							'params'     => array(
								array(
									'type'        => 'textfield',
									'admin_label' => false,
									'heading'     => esc_html__( 'Read more text', 'eduma' ),
									'param_name'  => 'read_text',
									'value'       => '',
									'description' => esc_html__( 'Provide text read more text.', 'eduma' ),
								),

								array(
									'type'        => 'colorpicker',
									'admin_label' => false,
									'heading'     => esc_html__( 'Text color', 'eduma' ),
									'param_name'  => 'read_more_text_color',
									'value'       => '',
									'description' => esc_html__( 'Select the read more text color.', 'eduma' ),
								),

								array(
									'type'        => 'colorpicker',
									'admin_label' => false,
									'heading'     => esc_html__( 'Border color', 'eduma' ),
									'param_name'  => 'border_read_more_text',
									'value'       => '',
									'description' => esc_html__( 'Select the read more border color.', 'eduma' ),
								),

								array(
									'type'        => 'colorpicker',
									'admin_label' => false,
									'heading'     => esc_html__( 'Background color', 'eduma' ),
									'param_name'  => 'bg_read_more_text',
									'value'       => '',
									'description' => esc_html__( 'Select the read more background color.', 'eduma' ),
								),

								array(
									'type'        => 'colorpicker',
									'admin_label' => false,
									'heading'     => esc_html__( 'Text hover color', 'eduma' ),
									'param_name'  => 'read_more_text_color_hover',
									'value'       => '',
									'description' => esc_html__( 'Select the read more text hover color.', 'eduma' ),
								),

								array(
									'type'        => 'colorpicker',
									'heading'     => esc_html__( 'Background hover color', 'eduma' ),
									'param_name'  => 'bg_read_more_text_hover',
									'value'       => '',
									'description' => esc_html__( 'Select the read more background hover color.', 'eduma' ),
								),
							),
							'dependency' => array(
								'element' => 'more',
								'value'   => 'font-awesome',
							),
						),
					)
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => false,
					'heading'     => esc_html__( 'Icon type', 'eduma' ),
					'param_name'  => 'icon_type',
					'description' => esc_html__( 'Select icon type to display', 'eduma' ),
					'value'       => array(
						esc_html__( 'Select', 'eduma' )             => '',
						esc_html__( 'Font Awesome Icon', 'eduma' )  => 'font-awesome',
						esc_attr__( "Ionicons", 'eduma' )           => "font_ionicons",
						esc_attr__( "Font 7 stroke Icon", 'eduma' ) => "font-7-stroke",
						esc_attr__( "Font Flat Icon", 'eduma' )     => "font-flaticon",
						esc_html__( 'Custom Image', 'eduma' )       => 'custom',
					),
					'std'         => 'font-awesome'
				),

				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Font Awesome Icon', 'eduma' ),
					'param_name' => 'font_awesome_group',
					'params'     => array(
						array(
							'type'        => 'iconpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Font Awesome Icon', 'eduma' ),
							'param_name'  => 'icon',
							'value'       => '',
							'description' => esc_html__( 'Select icon', 'eduma' ),
						),
						array(
							'type'        => 'number',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon Font Size (px)', 'eduma' ),
							'param_name'  => 'icon_size',
							'std'         => '14',
							'description' => esc_html__( 'Custom icon font size. Unit is pixel', 'eduma' ),
						),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'font-awesome',
					),
				),

				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Font 7 stroke Icon', 'eduma' ),
					'param_name' => 'font_7_stroke_group',
					'params'     => array(
						array(
							"type"       => "iconpicker",
							"heading"    => esc_attr__( "Font 7 stroke Icon", 'eduma' ),
							"param_name" => "icon",
							"settings"   => array(
								'emptyIcon'     => true,
								'type'          => 'stroke_icon',
								'enqueue_style' => 'thim-admin-font-icon7',
								'prefix_icon'   => 'pe-7s-',
							),
							'dependency' => array(
								'element' => 'icon_type',
								'value'   => 'font-7-stroke',
							),
						),
						array(
							'type'        => 'number',
							'heading'     => esc_html__( 'Icon Font Size (px)', 'eduma' ),
							'param_name'  => 'icon_size',
							'std'         => '14',
							'description' => esc_html__( 'Custom icon font size. Unit is pixel', 'eduma' ),
						),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'font-7-stroke',
					),
				),
				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Font Flat Icon', 'eduma' ),
					'param_name' => 'font_flaticon_group',
					'params'     => array(
						array(
							"type"       => "iconpicker",
							"heading"    => esc_attr__( "Font Flat Icon", 'eduma' ),
							"param_name" => "icon",
							"settings"   => array(
								'emptyIcon'     => true,
								'type'          => 'flat_icon',
								'enqueue_style' => 'thim-admin-font-flaticon',
								'prefix_icon' => 'flaticon-',
							),
						),
						array(
							'type'        => 'number',
							'heading'     => esc_html__( 'Icon Font Size (px)', 'eduma' ),
							'param_name'  => 'icon_size',
							'std'         => '14',
							'description' => esc_html__( 'Custom icon font size. Unit is pixel', 'eduma' ),
						),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'font-flaticon',
					),
				),

				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Font Ionicons Icon', 'eduma' ),
					'param_name' => 'font_ionicons_group',
					'params'     => array(
						array(
							"type"       => "iconpicker",
							"heading"    => esc_attr__( "Font Ionicons Icon", 'eduma' ),
							"param_name" => "icon",
							"settings"   => array(
								'emptyIcon'     => true,
								'type'          => 'ionicons',
								'enqueue_style' => 'thim-admin-ionicons',
							),

						),
						array(
							'type'        => 'number',
							'heading'     => esc_html__( 'Icon Font Size (px)', 'eduma' ),
							'param_name'  => 'icon_size',
							'std'         => '14',
							'description' => esc_html__( 'Custom icon font size. Unit is pixel', 'eduma' ),

						),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'font_ionicons',
					),
				),
				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Custom Image Icon', 'eduma' ),
					'param_name' => 'font_image_group',
					'params'     => array(
						array(
							'type'        => 'attach_image',
							'admin_label' => false,
							'heading'     => esc_html__( 'Image Icon', 'eduma' ),
							'param_name'  => 'icon_img',
							'description' => esc_html__( 'Select custom image icon', 'eduma' ),
						),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'custom',
					),
				),
				array(
					'type'        => 'number',
					'admin_label' => false,
					'heading'     => esc_html__( 'Width box icon', 'eduma' ),
					'param_name'  => 'width_icon_box',
//					'std'         => '100',
					'description' => esc_html__( 'Custom width box icon. Unit is pixel', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => false,
					'heading'     => esc_html__( 'Height box icon', 'eduma' ),
					'param_name'  => 'height_icon_box',
//					'std'         => '100',
					'description' => esc_html__( 'Custom height box icon. Unit is pixel', 'eduma' ),
				),

				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Color Options', 'eduma' ),
					'param_name' => 'color_group',
					'params'     => array(
						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon color', 'eduma' ),
							'param_name'  => 'icon_color',
							'value'       => '',
							'description' => esc_html__( 'Select the icon color.', 'eduma' ),
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon border color', 'eduma' ),
							'param_name'  => 'icon_border_color',
							'value'       => '',
							'description' => esc_html__( 'Select the icon border color.', 'eduma' ),
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon background color', 'eduma' ),
							'param_name'  => 'icon_bg_color',
							'value'       => '',
							'description' => esc_html__( 'Select the icon background color.', 'eduma' ),
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon hover color', 'eduma' ),
							'param_name'  => 'icon_hover_color',
							'value'       => '',
							'description' => esc_html__( 'Select the icon hover color.', 'eduma' ),
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon border hover color', 'eduma' ),
							'param_name'  => 'icon_border_color_hover',
							'value'       => '',
							'description' => esc_html__( 'Select icon border hover color.', 'eduma' ),
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon background hover color', 'eduma' ),
							'param_name'  => 'icon_bg_color_hover',
							'value'       => '',
							'description' => esc_html__( 'Select the icon background hover color.', 'eduma' ),
						),
					),

				),
				array(
					'type'       => 'section',
					'hide'       => true,
					'heading'    => __( 'Layout Options', 'eduma' ),
					'param_name' => 'layout_group',
					'params'     => array(
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Icon shape', 'eduma' ),
							'param_name'  => 'box_icon_style',
							'value'       => array(
								esc_html__( 'None', 'eduma' )   => '',
								esc_html__( 'Circle', 'eduma' ) => 'circle',
							),
							'std'         => 'circle'
						),
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Box style', 'eduma' ),
							'param_name'  => 'pos',
							'value'       => array(
								esc_html__( 'Icon at Left', 'eduma' )  => 'left',
								esc_html__( 'Icon at Right', 'eduma' ) => 'right',
								esc_html__( 'Icon at Top', 'eduma' )   => 'top',
							),
							'std'         => 'top'
						),
						array(
							'type'          => 'dropdown',
							'admin_label'   => false,
							'heading'       => esc_html__( 'Text alignment', 'eduma' ),
							'param_name' => 'text_align_sc',
							'value'         => array(
								esc_html__( 'Text at left', 'eduma' )   => 'text-left',
								esc_html__( 'Text at center', 'eduma' ) => 'text-center',
								esc_html__( 'Text at right', 'eduma' )  => 'text-right',
							),
						),
						array(
							'type'        => 'dropdown',
							'admin_label' => false,
							'heading'     => esc_html__( 'Type icon box', 'eduma' ),
							'param_name'  => 'style_box',
							'value'       => array(
								esc_html__( 'Default', 'eduma' )      => '',
								esc_html__( 'Overlay', 'eduma' )      => 'overlay',
								esc_html__( 'Contact Info', 'eduma' ) => 'contact_info',
								esc_html__( 'Image Box', 'eduma' )    => 'image_box',
							),
						),

						array(
							'type'        => 'checkbox',
							'heading'    => esc_html__( "Dot - Line Top Button", 'eduma' ),
							'param_name' => 'dot_line',
							'description' => esc_html__( 'Show line center of the dot from top page to bottom page', 'eduma' ),
							'dependency' => array(
								'element' => 'style_box',
								'value'      => 'contact_info',
							),
							'std'         => false,
 						),
						array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( "Select background image", 'eduma' ),
							'param_name' => 'bg_image_box',
							'dependency' => array(
								'element' => 'style_box',
								'value'      => 'image_box',
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Background Position', 'eduma' ),
							'param_name'  => 'bg_image_pos',
							'std'         => '',
							'description' => esc_html__( 'input position of background image.Ex: top left', 'eduma' ),
							'dependency'  => array(
								'element' => 'style_box',
								'value'      => 'image_box',
							),
						),
					),

				),

				array(
					'type'          => 'dropdown',
					'admin_label'   => false,
					'heading'       => esc_html__( 'Widget Background', 'eduma' ),
					'param_name'    => 'widget_background',
					'value'         => array(
						esc_html__( 'None', 'eduma' )             => 'none',
						esc_html__( 'Background Color', 'eduma' ) => 'bg_color',
						esc_html__( 'Video Background', 'eduma' ) => 'bg_video',
					),
					'group'         => esc_html__( 'Layout Settings', 'eduma' ),
					'start_section' => 'layout_setting'
				),
				array(
					'type'        => 'colorpicker',
					'admin_label' => false,
					'param_name'  => 'bg_box_color',
					'heading'     => esc_html__( 'Background Color:', 'eduma' ),
					'description' => esc_html__( 'Select the color background for box.', 'eduma' ),
					'std'         => '',
					'dependency'  => array(
						'element' => 'widget_background',
						'value'   => 'bg_color',
					),
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Select video', 'eduma' ),
					'description' => esc_html__( "Select an uploaded video in mp4 format. Other formats, such as webm and ogv will work in some browsers. You can use an online service such as <a href='http://video.online-convert.com/convert-to-mp4' target='_blank'>online-convert.com</a> to convert your videos to mp4.", 'eduma' ),
					'param_name'  => 'self_video',
					'dependency'  => array(
						'element' => 'widget_background',
						'value'   => 'bg_video',
					),

				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( "Upload Image Icon:", 'eduma' ),
					'param_name'  => 'self_poster',
					'description' => esc_html__( "Upload the custom image icon.", 'eduma' ),
					'dependency'  => array(
						'element' => 'widget_background',
						'value'   => 'bg_video',
					),
				)
			);
		}
	}
}

