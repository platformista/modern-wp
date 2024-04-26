<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop, $theme_options_data, $wp_query;

// color theme options
$cat_obj = $wp_query->get_queried_object();

if ( isset( $cat_obj->term_id ) ) {
	$cat_id = $cat_obj->term_id;
} else {
	$cat_id = '';
}
$thim_custom_column = get_term_meta( $cat_id, 'thim_custom_column', true );

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
// if ( empty( $woocommerce_loop['columns'] ) ) {
// 	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
// }

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	//return;
}

// Increase loop count
$woocommerce_loop['loop'] ++;
$column_product = 4;
 
if ( '' != $thim_custom_column ) {
	$column_product = 12 / $thim_custom_column;
} elseif ( ! empty( $theme_options_data['thim_woo_product_column'] ) ) {
			$thim_custom_column = $theme_options_data['thim_woo_product_column'];
			$column_product     = 12 / $theme_options_data['thim_woo_product_column'];
} 
?>
<li <?php wc_product_cat_class( 'col-md-' . $column_product . ' col-sm-6 col-xs-6', $category ); ?>>
    <div class="content__product">
		<?php
		/**
		 * woocommerce_before_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_open - 10
		 */
		do_action( 'woocommerce_before_subcategory', $category );

		/**
		 * woocommerce_before_subcategory_title hook.
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		do_action( 'woocommerce_before_subcategory_title', $category );

		/**
		 * woocommerce_shop_loop_subcategory_title hook.
		 *
		 * @hooked woocommerce_template_loop_category_title - 10
		 */
		do_action( 'woocommerce_shop_loop_subcategory_title', $category );

		/**
		 * woocommerce_after_subcategory_title hook.
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );

		/**
		 * woocommerce_after_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_close - 10
		 */
		do_action( 'woocommerce_after_subcategory', $category );
		?>
    </div>
</li>
