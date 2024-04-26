<?php
/**
 * Thim_Builder Visual Composer Icon Box shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Icon_Box' ) ) {
	/**
	 * Class Thim_Builder_VC_Icon_Box
	 */
	class Thim_Builder_VC_Icon_Box extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Icon_Box constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Icon_Box';

			parent::__construct();
		}

		// convert setting
		function thim_convert_setting( $settings ) {
			$settings['title_group']         = array(
				'title'            => $settings['title'],
				'color_title'      => $settings['title_color'],
				'size'             => $settings['title_size'],
				'font_heading'     => $settings['title_font_heading'],
				'custom_heading'   => array(
					'custom_font_size'   => $settings['title_custom_font_size'],
					'custom_font_weight' => $settings['title_custom_font_weight'],
					'custom_mg_top'      => $settings['title_custom_mg_top'],
					'custom_mg_bt'       => $settings['title_custom_mg_bt'],
				),
				'line_after_title' => $settings['line_after_title'] ? 1 : '',
			);
			$settings['desc_group']          = array(
				'content'              => $settings['desc_content'],
				'custom_font_size_des' => $settings['custom_font_size_desc'],
				'custom_font_weight'   => $settings['custom_font_weight_desc'],
				'color_description'    => $settings['color_desc'],
			);
			$settings['read_more_group']     = array(
				'link'                   => $settings['read_more_link'],
				'read_more'              => $settings['read_more_link_to'],
				'target'                 => $settings['read_more_target'],
				'link_to_icon'           => $settings['link_to_icon'],
				'button_read_more_group' => array(
					'read_text'                  => $settings['read_more_text'],
					'read_more_text_color'       => $settings['read_more_text_color'],
					'border_read_more_text'      => $settings['read_more_border_color'],
					'bg_read_more_text'          => $settings['read_more_bg_color'],
					'read_more_text_color_hover' => $settings['read_more_text_hover_color'],
					'bg_read_more_text_hover'    => $settings['read_more_bg_hover_color'],
				),
			);
			$settings['font_awesome_group']  = array(
				'icon'      => str_replace( 'fa fa-', '', $settings['font_awesome_icon'] ),
				'icon_size' => $settings['font_awesome_icon_size'],
			);
			$settings['font_ionicons_group'] = array(
				'icon'      => $settings['font_ionicons'],
				'icon_size' => $settings['font_awesome_icon_size'],
			);
			$settings['font_7_stroke_group']          = array(
				'icon'      => $settings['stroke_icon'],
				'icon_size' => $settings['font_awesome_icon_size']
			);
			$settings['font_flaticon_group'] = array(
				'icon'      => $settings['flat_icon'],
				'icon_size' => $settings['font_awesome_icon_size'],
			);
			$settings['font_image_group']    = array(
				'icon_img' => $settings['custom_image_icon'],
			);
			$settings['color_group']         = array(
				'icon_color'              => $settings['icon_color'],
				'icon_border_color'       => $settings['icon_border_color'],
				'icon_bg_color'           => $settings['icon_bg_color'],
				'icon_hover_color'        => $settings['icon_hover_color'],
				'icon_border_color_hover' => $settings['icon_border_hover_color'],
				'icon_bg_color_hover'     => $settings['icon_bg_hover_color'],
			);
			$settings['layout_group']        = array(
				'box_icon_style' => $settings['layout_box_icon_style'],
				'pos'            => $settings['layout_pos'],
				'text_align_sc'  => $settings['layout_text_align_sc'],
				'style_box'      => $settings['layout_style_box'],
				'dot_line'      => $settings['dot_line'],
				'bg_image_box'      => $settings['bg_image_box'],
				'bg_image_pos'      => $settings['bg_image_pos'],
			);
			return $settings;
		}
	}
}

new Thim_Builder_VC_Icon_Box();

