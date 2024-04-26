<?php
/**
 * Thim_Builder Our Team config class
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

if ( ! class_exists( 'Thim_Builder_Config_Our_Team' ) ) {
	/**
	 * Class Thim_Builder_Config_Our_Team
	 */
	class Thim_Builder_Config_Our_Team extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Our_Team constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'our-team';
			self::$name = esc_html__( 'Thim: Our Team', 'eduma' );
			self::$desc = esc_html__( 'Display Our Team.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-our-team';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {
			// options
			return array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Select Category', 'eduma' ),
					'param_name'  => 'cat_id',
					'value'       => thim_get_cat_taxonomy( 'our_team_category', array( esc_html__( 'All', 'eduma' ) => 'all' ), true ),
					'std'         => 'all'
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Number Posts', 'eduma' ),
					'param_name'  => 'number_post',
					'std'         => '5',
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => 'base',
						esc_html__( 'Slider', 'eduma' )  => 'slider',
					),
					'std'         => 'base'
				),

                array(
                    'type'        => 'checkbox',
                    'heading'     => esc_html__( 'Icon Hover', 'eduma' ),
                    'param_name'  => 'layout_demo_elegant',
                    'value'       => array(
                        esc_html__( 'Yes', 'eduma' ) => true,
                    ),
                    'std'         => true,
                    'save_always' => true
                ),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Columns', 'eduma' ),
					'param_name'  => 'columns',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )    => '',
						esc_html__( '1 Column', 'eduma' )  => '1',
						esc_html__( '2 Columns', 'eduma' ) => '2',
						esc_html__( '3 Columns', 'eduma' ) => '3',
						esc_html__( '4 Columns', 'eduma' ) => '4',
					),
					'std'=>'4'
				),

				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'  => 'show_pagination',
					'value'       => array(
						esc_html__( 'Yes', 'eduma' ) => true,
					),
					'std'         => true,
					'save_always' => true,
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'slider',
					),
				),


				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text Link', 'eduma' ),
					'param_name'  => 'text_link',
					'value'       => '',
					'description' => esc_html__( 'Provide the text link that will be applied to box our team.', 'eduma' ),
					'std'         => '',
				),

				array(
					'type'        => 'textfield',
					'type_el'        => 'vc_link',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link Join Team', 'eduma' ),
					'param_name'  => 'link',
					'value'       => '',
					'description' => esc_html__( 'Provide the link that will be applied to box our team', 'eduma' ),
					'std'         => '',
				),

				array(
					'type'       => 'checkbox',
					'type_el'        => 'bp_hidden',
					'heading'    => esc_html__( 'Open in new window', 'eduma' ),
					'param_name' => 'is_external',
					'std'        => false,
				),
				array(
					'type'       => 'checkbox',
					'type_el'        => 'bp_hidden',
					'heading'    => esc_html__( 'Add nofollow', 'eduma' ),
					'param_name' => 'nofollow',
					'std'        => false,
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Enable Link To Member', 'eduma' ),
					'param_name'  => 'link_member',
 					'std'         => false,
				),

			);
		}
	}
}