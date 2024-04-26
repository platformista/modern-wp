<?php
$random            = rand( 1, 99 );
$limit_tab         = $instance['tabs-options']['limit_tab'] ? $instance['tabs-options']['limit_tab'] : 4;
$cat_id_tab        = $instance['tabs-options']['cat_id_tab'] ? $instance['tabs-options']['cat_id_tab'] : array();
$view_all_course   = ( $instance['view_all_courses'] && '' != $instance['view_all_courses'] ) ? $instance['view_all_courses'] : false;
$view_all_position = ( $instance['view_all_position'] && '' != $instance['view_all_position'] ) ? $instance['view_all_position'] : 'top';
$limit             = $instance['limit'];
$featured          = ! empty( $instance['featured'] ) ? true : false;
$sort              = $instance['order'];
$thumb_w           = ( ! empty( $instance['thumbnail_width'] ) && '' != $instance['thumbnail_width'] ) ? $instance['thumbnail_width'] : apply_filters( 'thim_course_thumbnail_width', 450 );
$thumb_h           = ( ! empty( $instance['thumbnail_height'] ) && '' != $instance['thumbnail_height'] ) ? $instance['thumbnail_height'] : apply_filters( 'thim_course_thumbnail_height', 400 );

array_unshift( $cat_id_tab, "0" );


if ( ! empty( $cat_id_tab ) ) {
	foreach ( $cat_id_tab as $value ) {
		$array[$value] = 1;
		$html[$value]  = '';

		$condition[$value] = array(
			'post_type'           => 'lp_course',
			'posts_per_page'      => $limit_tab,
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

			$post_in = eduma_lp_get_popular_courses( $limit );

			$condition[$value]['post__in'] = $post_in;
			$condition[$value]['orderby']  = 'post__in';
		}

		$the_query[$value] = new WP_Query( $condition[$value] );

		if ( $the_query[$value]->have_posts() ) :
			?>
			<?php
			ob_start();
			$i = 0;
			while ( $the_query[$value]->have_posts() ) : $the_query[$value]->the_post(); ?>
				<?php
  				$cls_col = ( $i == 0 ) ? 'course-feature course-grid-2' : 'course-grid-4';
				?>
				<div class="lpr_course <?php echo $cls_col; ?>">
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
						</div>
						<div class="thim-course-content">
							<?php
							learn_press_courses_loop_item_instructor();
							the_title( sprintf( '<h2 class="course-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
							?>

							<?php if ( $i == 0 ) {
								thim_course_info( false );
							}

							do_action( 'learnpress_loop_item_course_meta' );
							?>
						</div>
					</div>
				</div>
				<?php
				$i ++;
			endwhile;
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
			root.find('.thim_content_item').css('width', contentItem.width() + '');
			root.find('.thim_content_tabs').css('width', parseInt(contentItem.width() * items) + 'px');
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
<div class="thim_tabs_slider thim-course-grid grid-1">
	<div class="sc_heading clone_title text-left">
		<?php if ( $instance['title'] ) { ?>
			<h2 class="title"><?php echo esc_html( $instance['title'] ); ?></h2>
			<div class="clone"><?php echo esc_html( $instance['title'] ); ?></div>
		<?php } ?>
		<ul>
			<?php echo ent2ncr( $list_tab ); ?>
		</ul>
	</div>
	<?php
	if ( $view_all_course && 'top' == $view_all_position ) {
		echo '<a class="view-all-courses position-top" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . ' <i class="tk tk-arrow-right"></i></a>';
	}
	?>
	<div class="thim_content_tabs row">
		<?php echo ent2ncr( $content_tab ); ?>
	</div>
	<?php
	if ( $view_all_course && 'bottom' == $view_all_position ) {
		echo '<div class="wrapper-bottom-view-courses"><a class="view-all-courses position-bottom" href="' . get_post_type_archive_link( 'lp_course' ) . '">' . esc_attr( $view_all_course ) . ' <i class="tk tk-arrow-right"></i></a></div>';
	}

	?>
</div>

