<?php
$hidden_author     = 'no';
$columns           = $instance['grid-options']['columns'];
$view_all_course   = ( $instance['view_all_courses'] && '' != $instance['view_all_courses'] ) ? $instance['view_all_courses'] : false;
$view_all_position = ( $instance['view_all_position'] && '' != $instance['view_all_position'] ) ? $instance['view_all_position'] : 'top';
$thumb_w           = ( ! empty( $instance['thumbnail_width'] ) && '' != $instance['thumbnail_width'] ) ? $instance['thumbnail_width'] : apply_filters( 'thim_course_thumbnail_width', 450 );
$thumb_h           = ( ! empty( $instance['thumbnail_width'] ) && '' != $instance['thumbnail_height'] ) ? $instance['thumbnail_height'] : apply_filters( 'thim_course_thumbnail_height', 400 );
if ( isset( $instance['grid_hide_author'] ) && $instance['grid_hide_author'] == 'yes' ) {
	$extra_class   = ' thim-widget-grid-courses-new';
	$hidden_author = 'yes';
} else {
	$extra_class = '';
}


$the_query    = new WP_Query( $args['condition'] );
$coursesCount = $the_query->found_posts;
if ( $the_query->have_posts() ) :
	?>
	<div class="thim-widget-courses-wrapper<?php echo esc_attr( $extra_class ) ?>">
		<?php
		if ( $instance['title'] ) {
			echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
		}
		if ( $view_all_course && 'top' == $view_all_position ) {
			echo '<a class="view-all-courses position-top" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . '</a>';
		}
		?>
		<div class="thim-course-grid thim-course-grid-instructor">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<?php
				$course_rate = '';
				$course      = learn_press_get_course( get_the_ID() );
				if ( class_exists( 'LP_Addon_Course_Review' ) ) {
					$course_rate = learn_press_get_course_rate( get_the_ID() );
				}
				?>
				<div class="lpr_course <?php echo 'course-grid-' . $columns; ?>">
					<div class="course-item">
						<div class="course-thumbnail">
							<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
								<?php echo thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', $thumb_w, $thumb_h, get_the_title() ); ?>
							</a>

							<?php
							do_action( 'thim_inner_thumbnail_course' );
							// only button read more
							do_action( 'thim-lp-course-button-read-more' );
							?>
							<?php do_action('learnpress_loop_item_price'); ?>
						</div>

						<div class="thim-course-content">
							<?php
							if ( $hidden_author == 'no' ) {
								learn_press_courses_loop_item_instructor();
							}

							the_title( sprintf( '<h2 class="course-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

							if ( class_exists( 'LP_Addon_Coming_Soon_Courses' ) && learn_press_is_coming_soon( get_the_ID() ) ): ?>
								<div class="message message-warning learn-press-message coming-soon-message">
									<?php esc_html_e( 'Coming soon', 'eduma' ) ?>
								</div>
							<?php else: ?>
								<div class="course-meta">
									<?php
									$student_text = $total_lessson='';
									if ( $hidden_author == 'yes' ) {
  										$total_lessson = $course->count_items( 'lp_lesson' );
										echo '<span class="item-info"><i class="tk tk-file"></i> ';
										echo sprintf( _n( '%s Lesson', '%s Lessons', $total_lessson, 'eduma' ), $total_lessson );
										echo '</span>';
										$student_text = ' ' . esc_html__( 'Students','eduma' );
									}

									echo '<span><i class="tk tk-users"></i> ' . intval( $course->count_students() ) . $student_text . '</span>';
									if ( $hidden_author == 'no' ) { ?>
										<?php
										if( $course ){
											$courses_tag = get_the_terms( $course->get_id(), 'course_category' );
											if ( $courses_tag ) {
												echo '<a href="' . esc_url( get_term_link( $courses_tag[0]->term_id ) ) . '">';
												echo ' <i class="tk tk-tag1"></i> ' . $courses_tag[0]->name . '</a>';
											}
										}

										if ( $course_rate ) {
											echo '<span class="star"><i class="tk tk-star1"></i> ' . intval( $course_rate ) . '</span>';
										} ?>
									<?php } ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php
			endwhile;
			?>
		</div>
		<div class="number-courses">
			<span class="course-text">
				<?php
				echo esc_html__( 'There are', 'eduma' ) . ' ' . esc_html( $limit ) . ' ' . esc_html__( 'courses of', 'eduma' ) . ' ' . esc_html( $coursesCount );
				?>
			</span>

		</div>
		<?php
		if ( $hidden_author == 'yes' ) {
			echo '<div class="line-button"></div>';
		}
		if ( $view_all_course && 'bottom' == $view_all_position ) {
			echo '<div class="wrapper-bottom-view-courses"><a class="view-all-courses position-bottom" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . '</a></div>';
		}
		?>
	</div>
<?php
endif;

wp_reset_postdata();
