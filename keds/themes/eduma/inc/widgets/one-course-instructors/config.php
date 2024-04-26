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

if ( ! class_exists( 'Thim_Builder_Config_One_Course_Instructors' ) ) {
	/**
	 * Class Thim_Builder_Config_One_Course_Instructors
	 */
	class Thim_Builder_Config_One_Course_Instructors extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_One_Course_Instructors constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'one-course-instructors';
			self::$name = esc_html__( 'Thim: One Course Instructors', 'eduma' );
			self::$desc = esc_html__( 'Display course instructors.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-one-course-instructors';
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
					'heading'     => esc_html__( 'Course ID', 'eduma' ),
					'description' => esc_html__( 'Set course id to show all instructors of a course', 'eduma' ),
					'param_name'  => 'courses_id',
					'std'         => ! empty( get_theme_mod( 'thim_learnpress_one_course_id' ) ) ? get_theme_mod( 'thim_learnpress_one_course_id' ) : ''
				),
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Visible instructors', 'eduma' ),
					'param_name'  => 'visible_item',
					'std'         => '3',
				),

				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'  => 'show_pagination',
					'std'         => true,
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name'  => 'auto_play',
					'value'       => '',
					'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'std'         => '0',
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}