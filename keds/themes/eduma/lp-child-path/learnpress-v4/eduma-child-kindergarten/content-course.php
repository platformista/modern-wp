<?php
/**
 * Template for displaying course content within the loop
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$theme_options_data = get_theme_mods();
$class              = isset( $theme_options_data['thim_learnpress_cate_grid_column'] ) && $theme_options_data['thim_learnpress_cate_grid_column'] ? 'course-grid-' . $theme_options_data['thim_learnpress_cate_grid_column'] : 'course-grid-3';
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$class .= ' lpr_course';

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<?php do_action( 'learn_press_before_courses_loop_item' ); ?>
	<div class="course-item">
		<?php do_action( 'thim_courses_loop_item_thumb' ); ?>
		<div class="thim-course-content">
			<?php
			do_action( 'learn_press_before_the_title' );
			the_title( sprintf( '<h2 class="course-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			do_action( 'learn_press_after_the_title' );
			learn_press_courses_loop_item_instructor();
			?>
			<div class="thim-background-border"></div>
			<div class="course-meta">
				<?php
				if ( function_exists( 'thim_meta_course_kindergarten' ) ) {
					thim_meta_course_kindergarten( get_the_ID() );
				}
				?>
			</div>
			<div class="course-description">
				<?php
				do_action( 'learn_press_before_course_content' );
				echo thim_excerpt( 30 );
				do_action( 'learn_press_after_course_content' );
				?>
			</div>
			<?php
			$price      = get_post_meta( get_the_ID(), 'thim_course_price', true );
			$unit_price = get_post_meta( get_the_ID(), 'thim_course_unit_price', true );
			?>
			<div class="course-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<div class="value " itemprop="price" content="<?php echo esc_attr( $price ); ?>">
					<?php echo esc_html( $price ); ?>
				</div>
				<?php echo ( ! empty( $unit_price ) ) ? '<div class="unit-price">' . $unit_price . '</div>' : ''; ?>
			</div>
			<div class="course-readmore">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read More', 'eduma' ); ?></a>
			</div>
		</div>
	</div>
	<?php do_action( 'learn_press_after_courses_loop_item' ); ?>
</div>
