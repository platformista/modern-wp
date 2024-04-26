<?php
/**
 * Template for displaying content of archive courses page.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.2
 */

defined( 'ABSPATH' ) || exit;

global $post, $wp_query, $lp_tax_query;

$show_description = get_theme_mod( 'thim_learnpress_cate_show_description' );
$show_desc        = ! empty( $show_description ) ? $show_description : '';
$cat_desc         = term_description();

$total   = $wp_query->found_posts;
$message = '';

if ( $total == 0 ) {
	$message = '<p class="message message-error">' . esc_html__( 'No courses found!', 'eduma' ) . '</p>';
	$index   = esc_html__( 'There are no available courses!', 'eduma' );
} elseif ( $total == 1 ) {
	$index = esc_html__( 'Showing only one result', 'eduma' );
} else {
	$courses_per_page = absint( LP_Settings::get_option( 'archive_course_limit', 6 ) );
	$paged            = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	$from = 1 + ( $paged - 1 ) * $courses_per_page;
	$to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;

	if ( $from == $to ) {
		$index = sprintf(
			esc_html__( 'Showing last course of %s results', 'eduma' ),
			$total
		);
	} else {
		$index = sprintf(
			esc_html__( 'Showing %1$s-%2$s of %3$s results', 'eduma' ),
			$from,
			$to,
			$total
		);
	}
}

$layout_setting = get_theme_mod( 'thim_learnpress_cate_layout_grid', true );
if ( $layout_setting == 'list_courses' ) {
	$set_layout = 'thim-course-list';
} else {
	$set_layout = 'thim-course-grid';
}

$default_order = apply_filters(
	'thim_default_order_course_option',
	array(
		'post_date'  => esc_html__( 'Newly published', 'eduma' ),
		'post_title' => esc_html__( 'Alphabetical', 'eduma' ),
		'popular'    => esc_html__( 'Most members', 'eduma' ),
	)
);

/**
 * @since 4.0.0
 *
 * @see   LP_Template_General::template_header()
 */
do_action( 'learn-press/template-header' );

/**
 * thim_wrapper_loop_start hook
 *
 * @hooked thim_wrapper_loop_end - 1
 * @hooked thim_wapper_page_title - 5
 * @hooked thim_wrapper_loop_start - 30
 */

do_action( 'thim_wrapper_loop_start' );
/**
 * LP Hook
 */
do_action( 'learn-press/before-main-content' );

do_action( 'lp/template/archive-course/description' );

$thim_course_sort = LP_Helper::sanitize_params_submitted( $_REQUEST['order_by'] ?? '' );
?>
	<div class="lp-content-area">
		<?php if ( get_theme_mod( 'thim_display_course_filter', false ) ) { ?>
			<button class="filter-courses-effect"><?php echo esc_html__( 'Filter', 'eduma' ) ?></button>
		<?php } ?>
		<div class="thim-course-top switch-layout-container<?php
		if ( $show_desc && $cat_desc ) {
			echo ' has_desc';
		}
		?>">
			<div class="thim-course-switch-layout switch-layout">
				<a href="javascript:;"
				   class="list switchToGrid<?php echo ( $set_layout == 'thim-course-grid' ) ? ' switch-active' : ''; ?>">
					<i class="fa fa-th-large"></i></a>
				<a href="javascript:;"
				   class="grid switchToList<?php echo ( $set_layout == 'thim-course-list' ) ? ' switch-active' : ''; ?>"><i
						class="fa fa-list-ul"></i></a>
			</div>
			<div class="course-index">
				<span class="courses-page-result"><?php echo( $index ); ?></span>
			</div>
			<?php if ( get_theme_mod( 'thim_display_course_sort', true ) ) : ?>
				<div class="thim-course-order">
					<select name="orderby">
						<?php
						foreach ( $default_order as $k => $v ) {
							$selected = '';
							if ( $k === $thim_course_sort ) {
								$selected = 'selected';
							}
							echo '<option value="' . esc_attr( $k ) . '" ' . $selected . '>' . ( $v ) . '</option>';
						}
						?>
					</select>
				</div>
			<?php endif; ?>
			<div class="courses-searching">
				<form class="search-courses" method="get"
					  action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
					<input type="text" value="<?php echo esc_attr( LP_Request::get( 'c_search' ) ); ?>" name="c_search"
						   placeholder="<?php esc_attr_e( 'Search our courses', 'eduma' ); ?>"
						   class="form-control course-search-filter" autocomplete="off"/>
					<input type="hidden" value="course" name="ref"/>
					<input type="hidden" name="post_type" value="lp_course">
					<input type="hidden" name="taxonomy"
						   value="<?php echo esc_attr( get_queried_object()->taxonomy ?? $_GET['taxonomy'] ?? '' ); ?>">
					<input type="hidden" name="term_id"
						   value="<?php echo esc_attr( get_queried_object()->term_id ?? $_GET['term_id'] ?? '' ); ?>">
					<input type="hidden" name="term"
						   value="<?php echo esc_attr( get_queried_object()->slug ?? $_GET['term'] ?? '' ); ?>">
					<button type="submit" aria-label="search"><i class="fa fa-search"></i></button>
					<span class="widget-search-close"></span>
				</form>
			</div>
		</div>

		<?php
		/**
		 * LP Hook
		 */
		// do_action( 'learn-press/before-courses-loop' );

		LearnPress::instance()->template( 'course' )->begin_courses_loop();
		?>
		<?php if ( $show_desc && $cat_desc ) { ?>
			<div class="desc_cat">
				<?php echo $cat_desc; ?>
			</div>
		<?php } ?>

		<div id="thim-course-archive" class="<?php echo $set_layout; ?>">
			<ul class="learn-press-courses">
				<?php
				if ( version_compare( LEARNPRESS_VERSION, '4.1.6.5', '=' )
					|| ( version_compare( LEARNPRESS_VERSION, '4.1.6.6-beta-1', '>=' )
						&& LP_Settings_Courses::is_ajax_load_courses()
						&& ! LP_Settings_Courses::is_no_load_ajax_first_courses() )
				) {
					echo '<div class="lp-archive-course-skeleton" style="width:100%">';
					echo lp_skeleton_animation_html( 10, '100%', 'height:20px', 'width:100%' );
					echo '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>';
					echo '</div>';
				} else {
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							learn_press_get_template_part( 'content', 'course' );
						endwhile;
						wp_reset_postdata();
					else :
						echo $message;
					endif;

					if ( version_compare( LEARNPRESS_VERSION, '4.1.6.6-beta-1', '>=' ) && LP_Settings_Courses::is_ajax_load_courses() ) {
						echo '<div class="lp-archive-course-skeleton no-first-load-ajax" style="width:100%; display: none">';
						echo lp_skeleton_animation_html( 10, 'random', 'height:20px', 'width:100%' );
						echo '<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>';
						echo '</div>';
					}
				}
				?>
			</ul>
		</div>

		<?php
		LearnPress::instance()->template( 'course' )->end_courses_loop();

		/**
		 * @since 4.0.0
		 */
		do_action( 'learn-press/after-courses-loop' );

		wp_reset_postdata();
		/**
		 * LP Hook
		 *
		 * @since 4.0.0
		 */
		// do_action( 'learn-press/sidebar' );
		?>

		<?php
		/**
		 * LP Hook
		 */
		do_action( 'learn-press/after-main-content' );

		/**
		 * thim_wrapper_loop_end hook
		 *
		 * @hooked thim_wrapper_loop_end - 10
		 * @hooked thim_wrapper_div_close - 30
		 */
		do_action( 'thim_wrapper_loop_end' );
		?>
	</div>
<?php

/**
 * @since 4.0.0
 *
 * @see   LP_Template_General::template_footer()
 */
do_action( 'learn-press/template-footer' );
