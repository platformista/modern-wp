<?php

// remove action LP3 in child theme
remove_action( 'thim-udemy-course-buttons', 'learn_press_course_external_button', 5 );
remove_action( 'thim-udemy-course-buttons', 'learn_press_course_purchase_button', 10 );
remove_action( 'thim-udemy-course-buttons', 'learn_press_course_enroll_button', 15 );

add_action( 'thim-udemy-course-buttons', 'thim_udemy_button_redmore_course', 5 );
function thim_udemy_button_redmore_course(){
	echo '<a href="'.esc_url( get_the_permalink( get_the_ID() ) ).'" class="read-more-course">'.esc_html__('Read More','eduma').'</a>';
}

// add cusom field for course
remove_action( 'learn-press/course-info-right', 'thim_udemy_course_payment', 20 );
add_action( 'learn-press/course-info-right', 'thim_udemy_course_payment_v4', 20 );
remove_action( 'learn-press/course-info-right', 'thim_udemy_course_wishlist', 25 );


if ( ! function_exists( 'thim_remove_learnpress_hooks_udemy_child' ) ) {
	function thim_remove_learnpress_hooks_udemy_child() {
		add_action( 'learn-press/course-info-right', LearnPress::instance()->template( 'course' )->func( 'user_progress' ), 19 );
		remove_action( 'thim_single_course_meta', LearnPress::instance()->template( 'course' )->func( 'user_progress' ), 30 );
	}
}
add_action( 'after_setup_theme', 'thim_remove_learnpress_hooks_udemy_child', 20 );

if ( ! function_exists( 'thim_udemy_course_payment_v4' ) ) {
	function thim_udemy_course_payment_v4() {
		?>
		<div class="course-payment">
			<?php
			LearnPress::instance()->template( 'course' )->course_pricing() ;
			LearnPress::instance()->template( 'course' )->course_buttons(); ?>
		</div>
		<?php
	}
}

if ( get_theme_mod( 'thim_layout_content_page', 'normal' ) != 'new-1' ) {
	if ( ! function_exists( 'thim_course_content_lp4' ) ) {
		function thim_course_content_lp4() {
			learn_press_get_template( 'single-course/tabs/tabs-2.php' );
		}
	}

 	add_action( 'learn-press/course-content-summary', 'thim_course_content_lp4', 40 );
	remove_action( 'learn-press/single-course-summary', 'learn_press_course_thumbnail', 2 );
	remove_all_actions( 'learn-press/course-content-summary', 60 );
}

/**
 * About the author
 */
if ( ! function_exists( 'thim_udemy_about_author' ) ) {
	function thim_udemy_about_author() {
 		$lp_info = get_the_author_meta( 'lp_info' );
 		$link    = '#';
		if ( get_post_type() == 'lpr_course' ) {
			$link = apply_filters( 'learn_press_instructor_profile_link', '#', $user_id = null, get_the_ID() );
		} elseif ( get_post_type() == 'lp_course' ) {
			$link = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
		} elseif ( is_single() ) {
			$link = get_author_posts_url( get_the_author_meta( 'ID' ) );
		}
		?>
		<div class="thim-about-author">
			<h3><?php echo esc_html__( 'ABOUT INSTRUCTOR', 'eduma' ); ?></h3>
			<div class="author-wrapper lp-course-author">
				<div class="thim-author-item thim-instructor">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 147 ); ?>

						<?php
						if ( function_exists( 'thim_lp_social_user' ) ) {
							thim_lp_social_user();
						}
						?>
					</div>
					<div class="author-bio">
						<div class="author-top">
							<a class="name instructor-display-name" href="<?php echo esc_url( $link ); ?>">
								<?php echo get_the_author(); ?>
							</a>
							<?php if ( isset( $lp_info['major'] ) && $lp_info['major'] ) : ?>
								<p class="job"><?php echo esc_html( $lp_info['major'] ); ?></p>
							<?php endif; ?>
						</div>
						<div class="author-description">
							<?php
							echo wpautop(get_user_meta(  get_the_author_meta( 'ID' ) , 'description', true ));
							?>
						</div>
					</div>
				</div>

				<?php
				if ( class_exists( 'LearnPress' ) && function_exists( 'thim_udemy_co_instructors' ) ) {
					thim_udemy_co_instructors( get_the_ID(), get_the_author_meta( 'ID' ) );
				}
				?>
			</div>
		</div>
		<?php
	}
}

/**
 * Display co instructors
 *
 * @param $course_id
 */
if ( ! function_exists( 'thim_udemy_co_instructors' ) ) {
	function thim_udemy_co_instructors( $course_id, $author_id ) {
		global $post;
		if ( ! $course_id ) {
			return;
		}

		if ( class_exists('LP_Co_Instructor_Preload') && thim_is_version_addons_instructor( '3' ) ) {
			$instructors = get_post_meta( $course_id, '_lp_co_teacher' );
			$instructors = array_diff( $instructors, array( $author_id ) );
			if ( $instructors ) {
				foreach ( $instructors as $instructor ) {

					//Check if instructor not exist
					$user = get_userdata( $instructor );
					if ( $user === false ) {
						break;
					}
					$lp_info = get_the_author_meta( 'lp_info', $instructor );
					$link    = learn_press_user_profile_link( $instructor );
 					?>
					<div class="thim-author-item thim-co-instructor">
						<div class="author-avatar">
							<?php echo get_avatar( $instructor, 147 ); ?>

							<?php
							if ( function_exists( 'thim_lp_social_user' ) ) {
								thim_lp_social_user();
							}
							?>
						</div>
						<div class="author-bio">
							<div class="author-top">
								<a itemprop="url" class="name" href="<?php echo esc_url( $link ); ?>">
									<span
										itemprop="name"><?php echo get_the_author_meta( 'display_name', $instructor ); ?></span>
								</a>
								<?php if ( isset( $lp_info['major'] ) && $lp_info['major'] ) : ?>
									<p class="job"
									   itemprop="jobTitle"><?php echo esc_html( $lp_info['major'] ); ?></p>
								<?php endif; ?>
							</div>
							<div class="author-description" itemprop="description">
								<?php echo get_the_author_meta( 'description', $instructor ); ?>
							</div>
						</div>
					</div>
					<?php
				}
			}
		}
	}
}
