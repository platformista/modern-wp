<?php
/**
 * Template for displaying instructor tab in profile page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/co-instructor/profile-tab.php.
 *
 * @author ThimPress
 * @package LearnPress/Co-Instructor/Templates
 * @version 3.0.4
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

global $post;
$user_id   = get_current_user_id();
$user      = new LP_User( $user_id );
$limit     = apply_filters( 'learn_press_profile_tab_courses_all_limit', LP_Settings::instance()->get( 'profile_courses_limit', 10 ) );
$courses   = learn_press_get_course_of_user_instructor( array( 'limit' => $limit, 'user_id' => $user_id ) );
$num_pages = learn_press_get_num_pages( $courses['count'], $limit );
?>

<?php if ( $courses['rows'] ) { ?>
	<div class="learn-press-subtab-content" style="display: block">
		<ul class="thim-course-grid learn-press-courses profile-courses courses-list">
			<?php foreach ( $courses['rows'] as $post ) {
				setup_postdata( $post );
				learn_press_get_template( 'content-course.php' );
				wp_reset_postdata();
			} ?>
		</ul>
		<?php learn_press_paging_nav( array( 'num_pages' => $num_pages ) ); ?>
	</div>
	<?php
} else { ?>
	<?php learn_press_display_message( __( 'There isn\'t any courses created by you as an instructor.', 'learnpress-co-instructor' ) ); ?>
<?php } ?>
