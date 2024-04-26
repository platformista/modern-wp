<?php
/**
 * The template for displaying single collection
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
/**
 * thim_wrapper_loop_start hook
 *
 * @hooked thim_wrapper_loop_end - 1
 * @hooked thim_wapper_page_title - 5
 * @hooked thim_wrapper_loop_start - 30
 */

do_action( 'thim_wrapper_loop_start' );
?>

<?php //do_action( 'learn_press_before_main_content' ); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php learn_press_collections_get_template( 'content-single-collection.php' ); ?>

<?php endwhile; ?>

<?php //do_action( 'learn_press_after_main_content' ); ?>

<?php
/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );

get_footer(); ?>
