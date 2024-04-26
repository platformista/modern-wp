<?php
/**
 * Template for displaying progress of single course.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.2
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $user ) || ! isset( $course ) || ! isset( $course_data ) || ! isset( $course_results ) ) {
	return;
}

$passing_condition = $course->get_passing_condition();

$graduation = $course_data->get_graduation();
$classes    = array(
	'lp-course-graduation',
	$graduation,
	$graduation === 'passed' ? 'success' : ( $graduation === 'failed' ? 'error' : '' ),
);
?>

<div class="course-results-progress">
	<?php do_action( 'learn-press/user-item-progress', $course_results, $course_data, $user, $course ); ?>

	<div class="course-progress">
		<?php
		$heading = apply_filters( 'learn-press/course/result-heading', __( 'Course results', 'eduma' ) );
		if ( false !== $heading ) {
			?>
			<label class="lp-course-progress-heading"><?php echo $heading; ?>
				<span class="value result"><b class="number">
						<?php echo round( $course_results['result'], 2 ); ?></b>%
				</span>
			</label>
		<?php } ?>
		<div class="learn-press-progress lp-course-progress <?php echo $course_data->is_passed() ? ' passed' : ''; ?>"
			 data-value="<?php echo $course_results['result']; ?>"
			 data-passing-condition="<?php echo $passing_condition; ?>"
			 title="<?php echo esc_attr( learn_press_translate_course_result_required( $course ) ); ?>">
			<div class="progress-bg">
				<div class="progress-active lp-progress-value" style="left: <?php echo $course_results['result']; ?>%;">
				</div>
			</div>
			<div class="lp-passing-conditional"
				 data-content="<?php printf( esc_html__( 'Passing condition: %s%%', 'learnpress' ), $passing_condition ); ?>"
				 style="left: <?php echo $passing_condition; ?>%;">
			</div>
		</div>
	</div>
	<?php if ( $graduation ) : ?>
		<div
			class="<?php echo implode( ' ', $classes ); ?>"><?php learn_press_course_grade_html( $graduation ); ?></div>
	<?PHP endif; ?>
</div>
