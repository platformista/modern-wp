<?php
/**
 * Template for displaying the list of course is in wishlist
 *
 * @author ThimPress
 */

defined( 'ABSPATH' ) || exit();

global $post;

$has_courses = $wishlist ? true : false;
?>
<div id="learn-press-profile-tab-course-wishlist" class="<?php echo $has_courses ? 'has-courses' : '';?>">

<?php if ( $has_courses ) : ?>

	<h3 class="box-title"><?php esc_html_e( 'Favorite Courses', 'eduma' ); ?></h3>

	<div class="thim-carousel-wrapper thim-course-carousel thim-course-grid" data-visible="3" data-pagination="0" data-navigation="1">

		<?php foreach( $wishlist as $post ) { ?>

			<?php LP_Addon_Wishlist_Preload::$addon->get_template( 'wishlist-content.php' ); ?>

		<?php } ?>
	</div>

<?php else: ?>

	<?php learn_press_display_message( apply_filters( 'learn_press_wishlist_empty_course', esc_html__( 'No records.', 'eduma' ) ), 'notice' ); ?>

<?php endif; ?>

</div>

<?php
wp_reset_postdata();
