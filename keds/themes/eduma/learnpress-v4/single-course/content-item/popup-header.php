<?php
/**
 * Template for displaying header of single course popup.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/header.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.3
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $user ) ) {
	$user = learn_press_get_current_user();
}

if ( ! isset( $course ) ) {
	$course = learn_press_get_course();
}

if ( ! $course ) {
	return;
}

if ( ! isset( $percentage ) && ! isset( $completed_items ) ) {
	$percentage      = 0;
	$completed_items = 0;
	$course_data     = $user->get_course_data( $course->get_id() );

	if ( $course_data ) {
		$course_results  = $course_data->get_result();
		$completed_items = $course_results['completed_items'];
		$percentage      = $course_results['count_items'] ? round( $course_results['completed_items'] * 100 / $course_results['count_items'], 2 ) : 0;
	}
}
?>

<div id="popup-header">
	<div class="popup-header__inner">
		<?php if ( $user->has_enrolled_course( $course->get_id() ) ) : ?>
			<div class="items-progress">
				<span>
					<?php
					echo
					wp_sprintf(
						__(
							'<span class="items-completed">%1$s</span> of %2$d items',
							'learnpress'
						),
						esc_html( $completed_items ),
						esc_html( $course->count_items() )
					);
					?>
 				</span>
				<div class="learn-press-progress">
					<div class="learn-press-progress__active" data-value="<?php echo $percentage; ?>%;">
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="thim-course-item-popup-right">
			<input type="checkbox" id="sidebar-toggle" class="toggle-content-item"/>
			<a href="<?php echo $course->get_permalink(); ?>" class="back_course"><i class="fa fa-close"></i></a>
		</div>
	</div>
 </div>
