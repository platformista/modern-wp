<?php
/**
 * Template for displaying curriculum tab of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/curriculum.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();
$course = learn_press_get_course();
$user   = learn_press_get_current_user();

if ( ! $course || ! $user ) {
	return;
}

$can_view_content_course = $user->can_view_content_course( $course->get_id() );
?>

<?php do_action( 'thim_begin_curriculum_button' ); ?>

	<div class="course-curriculum" id="learn-press-course-curriculum">

		<div class="curriculum-scrollable">


			<div class="curriculum-heading">
				<h3 class="curriculum-title"><?php echo esc_html__( 'Course Curriculum', 'eduma' ); ?></h3>

				<div class="meta-section">
					<!-- Display total learning in landing course page -->
					<?php
					$total_lessson = $course->count_items( 'lp_lesson' );
					$total_quiz    = $course->count_items( 'lp_quiz' );

					if ( $total_lessson || $total_quiz ) {
						echo '<span class="courses-lessons">' . esc_html__( 'Total learning: ', 'eduma' );
						if ( $total_lessson ) {
							echo '<span class="text">' . sprintf( _n( '%d lesson', '%d lessons', $total_lessson, 'eduma' ), $total_lessson ) . '</span>';
						}

						if ( $total_quiz ) {
							echo '<span class="text">' . sprintf( _n( ' / %d quiz', ' / %d quizzes', $total_quiz, 'eduma' ), $total_quiz ) . '</span>';
						}
						echo '</span>';
					}
					?>
					<!-- End -->

					<!-- Display total course time in landing course page -->
					<?php
					$course_duration_text = thim_duration_time_calculator( $course->get_id(), 'lp_course' );
					$course_duration_meta = get_post_meta( $course->get_id(), '_lp_duration', true );
					$course_duration      = explode( ' ', $course_duration_meta );

					if ( ! empty( $course_duration[0] ) && $course_duration[0] != '0' ) {
						?>
						<span class="courses-time"><?php esc_html_e( 'Time: ', 'eduma' ); ?>
					        <span class="text"><?php echo esc_html( $course_duration_text ); ?></span></span>
						<?php
					}
					?>
					<!-- End -->
				</div>
			</div>

			<?php

			/**
			 * @since 3.0.0
			 */
			do_action( 'learn-press/before-single-course-curriculum' );
			?>

			<?php $curriculum = $course->get_curriculum();
			$user_course      = $user->get_course_data( get_the_ID() );
			$user             = learn_press_get_current_user();
			if ( $curriculum ) : ?>

				<ul class="curriculum-sections">
					<?php
					$i = 0;
					foreach ( $curriculum as $section ) {
						$i ++;
						$active = ( $i == 1 ) ? true : false;
						$args   = [
							'section'                 => $section,
							'can_view_content_course' => $can_view_content_course,
							'user_course'             => $user_course,
							'user'                    => $user,
							'active'                  => $active
						];
						learn_press_get_template( 'single-course/loop-section.php', $args );
					}
					?>
				</ul>

			<?php else : ?>

				<?php
				echo wp_kses_post(
					apply_filters(
						'learnpress/course/curriculum/empty',
						esc_html__( 'Curriculum is empty', 'learnpress' )
					)
				);
				?>
			<?php endif ?>

			<?php
			/**
			 * @since 3.0.0
			 */
			do_action( 'learn-press/after-single-course-curriculum' );

			?>

		</div>

	</div>

<?php do_action( 'thim_end_curriculum_button' ); ?>
