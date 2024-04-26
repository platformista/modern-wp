<?php
$the_query = new WP_Query( $args['condition'] );
if ( $the_query->have_posts() ) :
	echo '<div class="thim-course-megamenu">';
	while ( $the_query->have_posts() ) : $the_query->the_post();
		?>
		<div class="lpr_course <?php echo 'course-grid-1'; ?>">
			<div class="course-item">
				<?php
				echo '<div class="course-thumbnail">';
				echo '<a class="thumb" href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '" >';
				echo thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', apply_filters( 'thim_course_megamenu_thumbnail_width', 450 ), apply_filters( 'thim_course_megamenu_thumbnail_height', 450 ), get_the_title( get_the_ID() ) );
				echo '</a>';
				echo '</div>';
				?>
				<div class="thim-course-content">
					<h2 class="course-title">
						<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>"> <?php echo get_the_title( get_the_ID() ); ?></a>
					</h2>

					<div class="course-meta">
						<?php do_action( 'learnpress_loop_item_price' ); ?>
					</div>
					<?php
					echo '<a class="course-readmore" href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'Read More', 'eduma' ) . '</a>';
					?>
				</div>
			</div>
		</div>
	<?php
	endwhile;
	echo '</div>';
endif;

wp_reset_postdata();
