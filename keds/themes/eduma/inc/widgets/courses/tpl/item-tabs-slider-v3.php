<?php
$random                     = rand( 1, 99 );
$course_item_excerpt_length = intval( get_theme_mod( 'thim_learnpress_excerpt_length', 25 ) );
$style                      = isset( $instance['item_tab_slider_style'] ) ? $instance['item_tab_slider_style'] : 'style_1';
$cat_id_tab                 = $instance['tabs-options']['cat_id_tab'] ? $instance['tabs-options']['cat_id_tab'] : array();
$limit                      = $instance['limit'];

$item_visible = $instance['slider-options']['item_visible'];
$pagination   = $instance['slider-options']['show_pagination'] ? $instance['slider-options']['show_pagination'] : 0;
$navigation   = $instance['slider-options']['show_navigation'] ? $instance['slider-options']['show_navigation'] : 0;
$autoplay     = isset( $instance['slider-options']['auto_play'] ) ? $instance['slider-options']['auto_play'] : 0;

$featured = ! empty( $instance['featured'] ) ? true : false;
$sort     = $instance['order'];
 if ( $style == 'style_2' ) {
	$w = 450;
	$h = 270;
}else{
	$w = 430;
	$h = 270;
}
$thumb_w  = ( ! empty( $instance['thumbnail_width'] ) && '' != $instance['thumbnail_width'] ) ? $instance['thumbnail_width'] : apply_filters( 'thim_course_thumbnail_width', $w );
$thumb_h  = ( ! empty( $instance['thumbnail_height'] ) && '' != $instance['thumbnail_height'] ) ? $instance['thumbnail_height'] : apply_filters( 'thim_course_thumbnail_height', $h );
array_unshift( $cat_id_tab, "0" );
$count_course = '';
if ( ! empty( $cat_id_tab ) ) {
	foreach ( $cat_id_tab as $value ) {
		$array[$value] = 1;
		$html[$value]  = '';

		$condition[$value] = array(
			'post_type'           => 'lp_course',
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
		);

		if ( $value ) {
			$condition[$value]['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'term_id',
					'terms'    => $value
				),
			);
		}

		if ( $featured ) {
			$condition[$value]['meta_query'] = array(
				array(
					'key'   => '_lp_featured',
					'value' => 'yes',
				)
			);
		}

		if ( $sort == 'popular' ) {
			$post_in                       = eduma_lp_get_popular_courses( $limit );
			$condition[$value]['post__in'] = $post_in;
			$condition[$value]['orderby']  = 'post__in';
		}

		$the_query[$value] = new WP_Query( $condition[$value] );
		$count_course      = $the_query[0]->found_posts;
		if ( $the_query[$value]->have_posts() ) :
			ob_start();
			$data = ' data-visible="' . esc_attr( $item_visible ) . '" data-pagination="' . esc_attr( $pagination ) . '" data-navigation="' . esc_attr( $navigation ) . '" data-autoplay="' . esc_attr( $autoplay ) . '"';
			echo '<div class="thim-carousel-wrapper thim-course-carousel thim-course-grid"' . $data . '>';
			while ( $the_query[$value]->have_posts() ) : $the_query[$value]->the_post(); ?>
				<div class="course-item">
					<div class="course-item">
						<div class="course-thumbnail">
							<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
								<?php echo thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', $thumb_w, $thumb_h, get_the_title() ); ?>
								<?php
								if ( $style == 'style_1' ) {
									echo '<i class="tk tk-arrow-right"></i>';
								}
								?>
							</a>

							<?php
							if ( $style == 'style_2' ) {
								do_action('learnpress_loop_item_price');
								echo '<div class="block-cat-author">';
								list_item_course_cat( get_the_ID() );
								learn_press_courses_loop_item_instructor();
								echo '</div>';
							}
							?>
						</div>
						<?php ?>
						<div class="thim-course-content">

							<?php
							if ( $style == 'style_1' ) {
								do_action('learnpress_loop_item_price');
								list_item_course_cat( get_the_ID() );
							}


							the_title( sprintf( '<h2 class="course-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
							if ( $style == 'style_1' ) {
								learn_press_courses_loop_item_instructor();
							}
							echo '<div class="block-desc-course-meta">';
							if ( $course_item_excerpt_length && $style != 'style_1' ) {
								echo '<div class="course-description">' . thim_excerpt( $course_item_excerpt_length ) . '</div>';
							}
							?>

							<?php if ( class_exists( 'LP_Addon_Coming_Soon_Courses_Preload' ) && learn_press_is_coming_soon( get_the_ID() ) ): ?>
								<div class="message message-warning learn-press-message coming-soon-message">
									<?php esc_html_e( 'Coming soon', 'eduma' ) ?>
								</div>
							<?php else: ?>

								<div class="course-meta">
									<?php learn_press_get_template( 'loop/course/students.php' ); ?>
									<?php thim_course_ratings_count(); ?>

									<?php thim_course_ratings(); ?>
								</div>

							<?php endif; ?>
						</div>

					</div>
				</div>
				<?php
				if ( $instance['item_tab_slider_style'] == 'style_2' ) {
					echo '<div class="course-readmore-wrapper">';
					// only button read more
					do_action( 'thim-lp-course-button-read-more' );

					echo '</div>';
				}
				?>
				</div>
			<?php
			endwhile;
			echo '</div>';
			$html[$value] .= ob_get_contents();
			ob_end_clean();
			?>

		<?php

		endif;
		wp_reset_postdata();
	}
} else {
	return;
}

$list_tab = $content_tab = '';
if ( ! empty( $cat_id_tab ) ) {
	foreach ( $cat_id_tab as $k => $tab ) {
		$term = get_term_by( 'id', $tab, 'course_category' );
		if ( $k == 0 ) {
			$list_tab    .= '<li class="active"><a href="#tab-course-' . $random . '-' . $tab . '">' . esc_html__( 'All', 'eduma' ) . '</a></li>';
			$content_tab .= '<div class="thim_content_item" id="tab-course-' . $random . '-' . $tab . '">';
			$content_tab .= $html[$tab];
			$content_tab .= '</div>';
		} else {
			if ( $term ) {
				$list_tab    .= '<li><a href="#tab-course-' . $random . '-' . $tab . '">' . $term->name . '</a></li>';
				$content_tab .= '<div class="thim_content_item" id="tab-course-' . $random . '-' . $tab . '">';
				$content_tab .= $html[$tab];
				$content_tab .= '</div>';
			}
		}
	}
}

?>
<script type="text/javascript">
	(function ($) {
		'use strict';
		$(document).ready(function () {
			var root = $('.thim_tabs_slider');
			var contentItem = root.find('.thim_content_item');
			var items = root.find('.thim_content_item').length;
			root.find('.thim_content_item').css('width', contentItem.width() + 30 + '');
			root.find('.thim_content_tabs').css('width', parseInt(contentItem.width() * items) + 30);
			$(document).on('click', '.thim_tabs_slider ul li a', function (e) {
				$(this).parent().parent().find('.active').removeClass('active');
				$(this).parent().addClass('active');
				e.preventDefault();

				let index = $(this).parent().index(),
					trans = contentItem.width() * index;

				if (!$('body').hasClass('rtl')) {
					trans = -1 * trans;
				}

				var $contentTab = $(this).parent().parent().parent().parent().find('.thim_content_tabs');

				$contentTab.css('transform', 'translateX(' + trans + 'px)');
			});
		});
	})(jQuery);
</script>
<div
	class="thim_tabs_slider thim-course-grid thim_item_tabs_<?php echo $style; ?>">
	<div class="sc_heading">
		<div class="heading-left">
			<?php if ( isset( $instance['before_heading'] ) && $style == 'style_1' ) { ?>
				<div class="before_heading"><?php echo esc_html( $instance['before_heading'] ); ?></div>
			<?php } ?>
			<?php if ( $instance['title'] ) { ?>
				<h2 class="title"><?php echo esc_html( $instance['title'] ); ?>
					<?php if ( $count_course ) {
						echo '<span class="total-course">' . $count_course . '</span>';
					} ?>
				</h2>
			<?php } ?>
		</div>

		<ul class="heading-right">
			<?php echo ent2ncr( $list_tab ); ?>
		</ul>
	</div>
	<div class="thim_content_tabs row">
		<?php echo ent2ncr( $content_tab ); ?>
	</div>
</div>

