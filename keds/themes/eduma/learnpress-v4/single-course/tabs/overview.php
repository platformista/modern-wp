<?php
/**
 * Template for displaying overview tab of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/overview.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}
?>

<div class="course-description" id="learn-press-course-description">

	<?php
	/**
	 * @deprecated
	 */
	do_action( 'learn_press_begin_single_course_description' );

	/**
	 * @since 4.0.0
	 */
	do_action( 'learn-press/before-single-course-description' );

	?>

	<div class="thim-course-content">
		<?php the_content(); ?>
	</div>

	<?php
	/**
	 * @since  4.5.6
	 *         thim_course_info
	 */
	do_action( 'thim_course_info_right' );

	/**
	 * @since 4.0.0
	 */
	do_action( 'learn-press/after-single-course-description' );

	/**
	 * @deprecated
	 */
	do_action( 'learn_press_end_single_course_description' );
	?>

</div>
