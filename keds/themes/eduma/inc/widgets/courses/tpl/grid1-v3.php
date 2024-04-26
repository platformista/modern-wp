<?php
$columns           = $instance['grid-options']['columns'];
$view_all_course   = ( $instance['view_all_courses'] && '' != $instance['view_all_courses'] ) ? $instance['view_all_courses'] : false;
$view_all_position = ( $instance['view_all_position'] && '' != $instance['view_all_position'] ) ? $instance['view_all_position'] : 'top';
$thumb_w           = ( ! empty( $instance['thumbnail_width'] ) && '' != $instance['thumbnail_width'] ) ? $instance['thumbnail_width'] : apply_filters( 'thim_course_thumbnail_width', 450 );
$thumb_h           = ( ! empty( $instance['thumbnail_height'] ) && '' != $instance['thumbnail_height'] ) ? $instance['thumbnail_height'] : apply_filters( 'thim_course_thumbnail_height', 400 );

$the_query = new WP_Query( $args['condition'] );

if ( $the_query->have_posts() ) :
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	echo '<div class="grid-1">';
	if ( $view_all_course && 'top' == $view_all_position ) {
		echo '<a class="view-all-courses position-top" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . ' <i class="tk tk-arrow-right"></i></a>';
	}
	?>
	<div class="thim-course-grid">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="lpr_course <?php echo 'course-grid-' . $columns; ?>">
				<div class="course-item">
					<div class="course-thumbnail">
						<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
							<?php echo thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', $thumb_w, $thumb_h, get_the_title() ); ?>
						</a>
						<?php do_action( 'thim_inner_thumbnail_course' ); ?>
						<?php if ( class_exists( 'LP_Addon_Course_Review' ) ) { ?>
							<?php $course_rate = learn_press_get_course_rate( get_the_ID() ); ?>
							<div class="rate">
								<i class="tk tk-star"></i>
								<span
									class="number_rate"><?php echo ( ! empty( $course_rate ) ) ? esc_html( round( $course_rate, 1 ) ) : 0; ?></span>
							</div>
						<?php } ?>
						<?php
						// only button read more
						do_action( 'thim-lp-course-button-read-more' );
						?>
					</div>
					<div class="thim-course-content">
						<?php
						learn_press_courses_loop_item_instructor();
						the_title( sprintf( '<h2 class="course-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

						do_action( 'learnpress_loop_item_course_meta' );
						?>
					</div>
				</div>
			</div>
		<?php
		endwhile;
		?>
	</div>
	<?php
	if ( $view_all_course && 'bottom' == $view_all_position ) {
		echo '<div class="wrapper-bottom-view-courses"><a class="view-all-courses position-bottom" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . ' <i class="tk tk-arrow-right"></i></a></div>';
	}
	echo '</div>';

endif;

wp_reset_postdata();
