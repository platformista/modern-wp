<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       8.6.0
 */

$shop_layout = get_theme_mod( 'thim_woo_cate_display_layout', 'grid' );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

/**
 * thim_wrapper_loop_start hook
 *
 * @hooked thim_wrapper_loop_end - 1
 * @hooked thim_wapper_page_title - 5
 * @hooked thim_wrapper_loop_start - 30
 */

do_action( 'thim_wrapper_loop_start' );
?>
<?php
/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>

<?php if ( have_posts() ) : ?>


	<?php
	if ( 'grid' != $shop_layout ) {

		$terms        = get_terms( 'product_cat' );
		$current_term = get_queried_object();
		if ( ! empty( $terms ) ) {
			// create a link which should link to the shop
			$all_link = get_post_type_archive_link( 'product' );
			echo '<div class="list-product-cat"><ul class="product-cat">';
			// display the shop link first if there is one
			if ( ! empty( $all_link ) ) {
				// also if the current_term doesn't have a term_id it means we are quering the shop and the "all categories" should be active
				echo '<li><a href="', $all_link, '"', ( ! isset( $current_term->term_id ) ) ? ' class="active"' : ' class="inactive"', '>', esc_html__( 'All', 'eduma' ), '</a></li>';
			}
			// display a link for each product category
			foreach ( $terms as $key => $term ) {
				$link = get_term_link( $term, 'product_cat' );
				if ( ! is_wp_error( $link ) ) {
					// if the current category is queried add the "active class" to the link
					$class_string = '';
					if ( ! empty( $current_term->name ) && $current_term->name === $term->name ) {
						$class_string = ' class="active"';
					} else {
						$class_string = ' class="inactive"';
					}

					echo '<li><a href="', $link, '"', $class_string, '>', $term->name, '</a></li>';
				}
			}
			echo '</ul></div>';
		}
	}
	?>
	<?php
	if ( 'grid' == $shop_layout ) {
 		echo '<div id="thim-product-archive" class="thim-product-grid">';
		/**
		 * woocommerce_before_shop_loop hook
		 *
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );
	}

	?>
	<?php woocommerce_product_loop_start(); ?>

	<?php //woocommerce_product_subcategories(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<?php wc_get_template_part( 'content', 'product' ); ?>

	<?php
	endwhile; // end of the loop.
	?>

	<?php woocommerce_product_loop_end(); ?>

	<?php
	/**
	 * woocommerce_after_shop_loop hook
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );

	if ( 'grid' == $shop_layout ) {

		echo '</div>';

	}

	?>


<?php
else:
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
endif; ?>

<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php
/**
 * woocommerce_sidebar hook
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );

get_footer( 'shop' );
