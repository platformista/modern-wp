<?php
/**
 * Template for displaying content of landing course
 *
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php //do_action( 'learn_press_before_content_landing' ); ?>

<div id="course-landing">

	<div class="course-tabs">
		<div id="tab-course-description">
			<?php do_action( 'learn_press_begin_course_content_course_description' ); ?>
			<div class="thim-course-content">
				<?php the_content(); ?>
			</div>
			<?php thim_course_info(); ?>
			<?php //do_action( 'learn_press_end_course_content_course_description' ); ?>
			<?php do_action( 'thim_social_share' ); ?>
		</div>
	</div>

</div>

<?php //do_action( 'learn_press_after_content_landing' ); ?>
