<?php

$condition = apply_filters( 'eduma/inc/widgets/courses/list-sidebar-v3/query_args', $args['condition'] );

$the_query = new WP_Query( $condition );

if ( $the_query->have_posts() ) :
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	?>
	<div class="thim-course-list-sidebar">
		<?php
		while ( $the_query->have_posts() ) : $the_query->the_post();
			?>
			<div class="lpr_course <?php echo has_post_thumbnail() ? 'has-post-thumbnail' : ''; ?>">
				<?php
				if ( has_post_thumbnail() ) {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
					echo '<div class="course-thumbnail">';
					echo '<img src="' . esc_url( $src[0] ) . '" alt="' . get_the_title() . '"/>';
					echo '</div>';
				}
				?>
				<div class="thim-course-content">
					<h3 class="course-title">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>"> <?php echo get_the_title(); ?></a>
					</h3>
					<?php if ( class_exists( 'LP_Addon_Coming_Soon_Courses_Preload' ) && learn_press_is_coming_soon( get_the_ID() ) ): ?>
						<div class="message message-warning learn-press-message coming-soon-message">
							<?php esc_html_e( 'Coming soon', 'eduma' ) ?>
						</div>
					<?php else: ?>
						<?php do_action( 'learnpress_loop_item_price' ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php
		endwhile;
		?>
	</div>
<?php
endif;
wp_reset_postdata();
