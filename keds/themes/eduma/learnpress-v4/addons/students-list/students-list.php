<?php
/**
 * Template for displaying students list tab in single course page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/students-list/student-list.php.
 *
 * @author  ThimPress
 * @package LearnPress/Students-List/Templates
 * @version 3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
?>

<?php if ( isset( $course ) ) { ?>
	<?php do_action( 'learn_press_before_students_list' ); ?>

	<div class="course-students-list">

		<?php
		$curd     = new LP_Course_CURD();
		$limit    = $limit ?? - 1;
		$students = $curd->get_user_enrolled( $course->get_ID(), $limit );
		?>
		<?php if ( $students ) { ?>
			<?php
			$students_list_heading     = apply_filters( 'learn_press_students_list_heading', __( 'Students List', 'eduma' ) );
			$show_avatar               = apply_filters( 'learn_press_students_list_avatar', true );
			$students_list_avatar_size = apply_filters( 'learn_press_students_list_avatar_size', 70 );
			$passing_condition         = $course->get_passing_condition();

			$filter  = $filter ?? 'all';
			$filters = apply_filters(
				'learn_press_get_students_list_filter',
				array(
					'all'         => esc_html__( 'All', 'eduma' ),
					'in-progress' => esc_html__( 'In Progress', 'eduma' ),
					'finished'    => esc_html__( 'Finished', 'eduma' ),
				)
			);

			?>
			<div class="student-list-top clearfix">
				<?php if ( $students_list_heading ) : ?>
					<h3 class="students-list-title"><?php echo $students_list_heading; ?></h3>
				<?php endif; ?>
				<div class="filter-students">
					<label for="students-list-filter"><?php esc_html_e( 'Student filter', 'eduma' ); ?></label>
					<select class="students-list-filter">
						<?php
						foreach ( $filters as $key => $_filter ) {
							echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $_filter ) . '</option>';
						}
						?>
					</select>
				</div>
			</div>

			<ul class="students clearfix">
				<?php
				foreach ( $students as $student ) {
					$result  = $process = '';
					$student = learn_press_get_user( $student->ID );

					$course_data       = $student->get_course_data( $course->get_id() );
					$passing_condition = $course->get_passing_condition();

					if ( $course_data ) {
						$course_results = $course_data->get_result();
						$result         = $course_results['result'];
						$process       .= ( $result == 100 ) ? 'finished' : 'in-progress';
					}
					?>
					<?php if ( $filter == $process || $filter == 'all' ) { ?>
						<li class="students-enrolled <?php echo ( isset( $result ) ) ? 'user-login ' . $process : ''; ?>">
							<div class="user-info">
								<div class="avatar">
									<?php if ( $show_avatar ) : ?>
										<?php echo get_avatar( $student->get_id(), $students_list_avatar_size, '', $student->get_data( 'display_name' ), array( 'class' => 'students_list_avatar' ) ); ?>
									<?php endif; ?>
								</div>
								<div class="right-info">
									<a class="name"
										href="<?php echo learn_press_user_profile_link( $student->get_id() ); ?>"
										title="<?php echo $student->get_data( 'display_name' ) . ' profile'; ?>">
										<?php echo $student->get_data( 'display_name' ); ?>
									</a>
									<div class="course-progress">
										<span
											class="course-result"><?php echo esc_html__( 'Learning', 'eduma' ); ?></span><?php echo round( $result ?? 0, 2 ); ?>
										%
									</div>
								</div>
							</div>
						</li>
					<?php } ?>
				<?php } ?>
			</ul>
			<?php
			$other_student = $course->get_data( 'fake_students' );
			if ( $other_student && $limit == - 1 ) {
				echo '<p class="additional-students">and ' . sprintf( _n( 'one student enrolled.', '%s students enrolled.', $other_student, 'eduma' ), $other_student ) . '</p>';
			}
			?>
		<?php } else { ?>
			<div class="students empty">
				<?php
				if ( $course->get_users_enrolled() ) {
					echo apply_filters( 'learn_press_course_count_student', sprintf( _n( 'One student enrolled.', '%s students enrolled.', $course->get_users_enrolled(), 'eduma' ), $course->get_users_enrolled() ) );
				} else {
					echo apply_filters( 'learn_press_course_no_student', __( 'No student enrolled.', 'eduma' ) );
				}
				?>
			</div>
		<?php } ?>
	</div>
	<?php
	do_action( 'learn_press_after_students_list' );
} else {
	echo __( 'Course ID invalid, please check it again.', 'eduma' );
}
