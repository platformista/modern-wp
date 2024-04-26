<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-single-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

/**
 * @deprecated
 */


/**
 * @since 4.0.0
 */

do_action( 'learn-press/before-single-course' );

if ( thim_lp_style_single_course() == 'new-1'){
	$width_sidebar = '9';
}else{
	$width_sidebar = '8';
}
?>

<?php if (thim_lp_style_single_course() =='new-1' || thim_lp_style_single_course() =='layout_style_3') { ?>

	<div class="content_course_2">

		<div class="row">

			<div class="col-md-<?php echo esc_attr($width_sidebar); ?> content-single">
					<?php if (thim_lp_style_single_course() == 'new-1'){?>
					<div class="learnpress-content learn-press">

						<div class="header_single_content">
							<?php
 								do_action( 'thim_single_course_before_meta' );
								if (thim_show_meta_course_coming_soon() ) { ?>
									<div class="course-meta course-meta-single">
										<?php do_action( 'thim_single_course_meta' ); ?>
									</div>
								<?php }
 							?>
						</div>
					</div>
					<?php } ?>
				<div class="course-summary">
					<?php
					/**
					 * @since 4.0.0
					 *
					 * @see   learn_press_single_course_summary()
					 */
					do_action( 'thim_lp_before_single_course_summary' );

					learn_press_get_template( 'single-course/tabs/tabs-2.php' );

					thim_landing_tabs();

					?>
				</div>

				<?php
					/**
					 * @since 4.0.0
					 *
					 * @see   thim_learn_press_related_courses()
					 */
					do_action( 'thim_lp_after_single_course_summary' );
				?>

			</div>

			<div id="sidebar" class="col-md-<?php echo esc_attr(12 - $width_sidebar); ?> sticky-sidebar">

				<div class="course_right">

					<?php
					if ( thim_lp_style_single_course() == 'layout_style_3'){
						do_action( 'thim_single_course_before_meta' );
					}

					LearnPress::instance()->template( 'course' )->func( 'user_progress' ); ?>

					<div class="course-payment">

						<?php
						do_action( 'thim_single_course_payment' );

						?>

					</div>

					<?php do_action( 'thim_begin_curriculum_button' ); ?>

					<?php do_action( 'thim_sidebar_menu_info_course' ); ?>


					<?php //thim_course_forum_link(); ?>


					<div class="social_share">
						<?php do_action( 'thim_social_share' ); ?>
					</div>

				</div>

			</div>

		</div>

	</div>

<?php } else { ?>

	<div id="learn-press-course" class="course-summary learn-press">
		<div class="course-info">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>

			<?php if ( thim_show_meta_course_coming_soon() ) { ?>
				<div class="course-meta course-meta-single">
					<?php do_action( 'thim_single_course_meta' ); ?>
				</div>
				<div class="course-payment">
					<?php
					do_action( 'thim_single_course_payment' );
					?>
				</div>
			<?php } ?>

			<?php //thim_course_forum_link(); ?>

			<?php do_action( 'thim_single_course_featured_review' ); ?>

			<div class="course-summary">
				<?php
				/**
				 * @since 4.0.0
				 *
				 * @see   learn_press_single_course_summary()
				 */
				do_action( 'learn-press/single-course-summary' );
				?>

				<div class="social_share">
					<?php do_action( 'thim_social_share' ); ?>
				</div>
			</div>
		</div>
		<?php

		/**
		 * @since 4.0.0
		 *
		 * @see   thim_learn_press_related_courses()
		 */
		do_action( 'thim_lp_after_single_course_summary' );

		?>
	</div>

<?php } ?>

<?php

/**
 * @since 4.0.0
 */


do_action( 'learn-press/after-single-course' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_single_course_summary' );
do_action( 'learn_press_after_single_course' );
do_action( 'learn_press_after_main_content' );
?>
