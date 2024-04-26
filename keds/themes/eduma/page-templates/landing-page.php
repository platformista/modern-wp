<?php
/**
 * Template Name: Landing Page
 *
 **/
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
	<div id="main-home-content" class="home-content home-page container" role="main">
		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>
	</div><!-- #main-content -->
</div></div></div>
<?php
/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );
wp_footer();
