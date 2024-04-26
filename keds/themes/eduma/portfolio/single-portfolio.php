<?php
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
    <session class="portfolio-content">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php
			if ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_sidebar_slider' ) {
				tp_portfolio_get_template_type( 'sidebar-slider' );
			} elseif ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_left_floating_sidebar' ) {
				tp_portfolio_get_template_type( 'left-floating-sidebar' );
			} elseif ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_right_floating_sidebar' ) {
				tp_portfolio_get_template_type( 'right-floating-sidebar' );
			} elseif ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_gallery' ) {
				tp_portfolio_get_template_type( 'gallery' );
			} elseif ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_vertical_stacked' ) {
				tp_portfolio_get_template_type( 'vertical-stacked' );
			} elseif ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_page_builder' ) {
				tp_portfolio_get_template_type( 'page-builder' );
			} elseif ( get_post_meta( get_the_ID(), 'selectPortfolio', true ) == 'portfolio_type_video' ) {
				tp_portfolio_get_template_type( 'video' );
			} else {
				tp_portfolio_get_template_type( 'content-portfolio' );
			}
			?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() ) :
				comments_template();
			endif;
			?>
		<?php
		endwhile; // end of the loop.
		?>
    </session>
<?php
/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );

get_footer();
?>