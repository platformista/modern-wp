<?php
/**
 * Thim_Builder Gallery Posts config class
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

if ( ! class_exists( 'Thim_Builder_Config_Gallery_Posts' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Gallery_Posts extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Gallery_Posts constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'gallery-posts';
			self::$name = esc_html__( 'Thim: Gallery Posts', 'eduma' );
			self::$desc = esc_html__( 'Display Gallery Posts.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-gallery-posts';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Select Category', 'eduma' ),
					'param_name' => 'cat',
					'value'      => thim_get_cat_taxonomy( 'category', array( esc_html__( 'All', 'eduma' ) => 'all' ), true ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => '',
						esc_html__( 'Isotope', 'eduma' )      => 'isotope',
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Columns', 'eduma' ),
					'param_name'  => 'columns',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
						esc_html__( '5', 'eduma' )      => '5',
						esc_html__( '6', 'eduma' )      => '6',
					),
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Filter', 'eduma' ),
					'param_name'  => 'filter',
					'std'         => true,
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Limit', 'eduma' ),
					'param_name'  => 'limit',
					'std'         => '8',
				),
			);
		}
	}
}