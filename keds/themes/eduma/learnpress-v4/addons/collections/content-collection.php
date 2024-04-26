<?php
/**
 * Template for displaying collection content within the loop
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$class = ' collection-item col-xs-6'
?>
<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>

	<?php do_action( 'learn_press_collections_before_loop_item' ); ?>

	<div class="item">
		<div class="thumbnail">
			<?php
			echo '<a href="' . esc_url( get_the_permalink() ) . '" >';
			echo thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', apply_filters( 'thim_collection_item_thumbnail_width', 450 ), apply_filters('thim_collection_item_thumbnail_height', 450), get_the_title() );
			echo '</a>';
			?>
			<a class="title" href="<?php echo esc_url( get_the_permalink() ); ?>"> <?php echo get_the_title(); ?></a>
		</div>
	</div>

	<?php //do_action( 'learn_press_collections_after_loop_item' ); ?>

</div>