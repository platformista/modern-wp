<?php
/**
 * Thim_Builder Landing Image config class
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

if ( ! class_exists( 'Thim_Builder_Config_Landing_Image' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Landing_Image extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Landing_Image constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'landing-image';
			self::$name = esc_html__( 'Thim: Landing Image', 'eduma' );
			self::$desc = esc_html__( 'Add heading text', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-landing-image';
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
					'std'         => '',
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Image', 'eduma' ),
					'description' => esc_html__( 'Select image from media library.', 'eduma' ),
					'param_name'  => 'image',
				),
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link', 'eduma' ),
					'param_name'  => 'link',
					'std'         => '#',
				),
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link Target', 'eduma' ),
					'param_name'  => 'link_target',
					'value'       => array(
						esc_html__( 'Same window', 'eduma' ) => '_self',
						esc_html__( 'New window', 'eduma' )  => '_blank',
					),
					'std'         => '_self'
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}