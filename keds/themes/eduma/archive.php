<?php
/**
 * The template for displaying archive pages
 *
 * @link       https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package    WordPress
 * @subpackage Eduma
 * @since      Eduma
 */

get_header();
/**
 * thim_wrapper_loop_start hook
 *
 * @hooked thim_wrapper_loop_end - 1
 * @hooked thim_wapper_page_title - 5
 * @hooked thim_wrapper_loop_start - 30
 */

do_action( 'thim_wrapper_loop_start' );
// check layout style
$archive_layout = get_theme_mod( 'thim_archive_cate_display_layout', false );
if ( $archive_layout ) {
	$layout_type   = ! empty( $archive_layout ) ? 'grid' : '';
	$id            = 'blog-archive';
	$class_archive = $layout_type == 'grid' ? ' blog-switch-layout blog-list' : '';
} else {
	$layout_type   = '';
	$id            = 'blog-archive-layout';
	$template      = get_theme_mod( 'thim_archive_cate_template', 'default' );
	$class_archive = ' blog-switch-layout blog-' . $template;
	if ( $template == 'grid' ) {
		$layout_type = 'grid';
	}
}


if ( have_posts() ) :?>
	<div id="<?php echo esc_attr( $id ); ?>" class="blog-content<?php echo esc_attr( $class_archive ); ?>">
		<?php
		/**
		 * thim_blog_before_main_content hook
		 *
		 * @hooked thim_blog_switch_layout - 10
		 * @hooked thim_blog_show_decription - 20
		 */
		do_action( 'thim_blog_before_main_content' ); ?>

		<div class="row">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				get_template_part( 'content', $layout_type );
			endwhile;
			?>
		</div>
	</div>
	<?php
	thim_paging_nav();
else :
	get_template_part( 'content', 'none' );
endif;
/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );

get_footer();
