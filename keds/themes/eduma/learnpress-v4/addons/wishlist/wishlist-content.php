<?php
/**
 * Template for displaying the list of course is in wishlist
 *
 * @author ThimPress
 */

defined( 'ABSPATH' ) || exit();
global $post;
$course_thumbnail_dimensions = get_option( 'learn_press_course_thumbnail_dimensions' );
if (  isset($course_thumbnail_dimensions['width']) ) {
	$width  = $course_thumbnail_dimensions['width'];
	$height = $course_thumbnail_dimensions['height'];
} else {
	$width  = 450;
	$height = 450;
}
?>
<div class="course-item">
	<?php
	$loop_item       = get_theme_mod( 'loop_course_item', '' );
	$check_loop_item = false;
	if ( $loop_item ) {
		$check_loop_item = get_post( $loop_item );
	}
 	if ( class_exists( '\Thim_EL_Kit\Functions' ) && $check_loop_item ) {
		\Thim_EL_Kit\Utilities\Elementor::instance()->render_loop_item_content( $loop_item );
	} else {
		?>
		<?php
		// @thim
		do_action( 'thim_courses_loop_item_thumb' );
		?>

		<div class="thim-course-content">
			<?php
			/**
			 * @hooked thim_learnpress_loop_item_title - 10
			 * @hooked learn_press_courses_loop_item_instructor - 5
			 */
			do_action( 'learnpress_loop_item_title' );

			do_action( 'learnpress_loop_item_desc' );

			do_action( 'learnpress_loop_item_course_meta' );

			?>
		</div>

		<?php
		// @since 4.0.0
		//do_action( 'learn-press/after-courses-loop-item' );
		?>
	<?php } ?>
</div>
