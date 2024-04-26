<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product,$theme_options_data;
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$check_loop_item = false;
if ( class_exists( '\Thim_EL_Kit\Functions' ) && is_cart() ) {
	$loop_item = get_post_meta( get_option( 'woocommerce_cart_page_id' ), 'thim_loop_item_content_product', true );
 	if ( $loop_item ) {
		$check_loop_item = get_post( $loop_item );
	}
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php
	if ( $check_loop_item ) {
		\Thim_EL_Kit\Utilities\Elementor::instance()->render_loop_item_content( $loop_item );
	} else { ?>
		<div class="content__product">
			<?php
			do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<div class="product_thumb">
				<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
				<?php
				if ( isset( $theme_options_data['thim_woo_set_show_qv'] ) && '1' == $theme_options_data['thim_woo_set_show_qv'] ) {
					wp_enqueue_script( 'magnific-popup' );
					wp_enqueue_script( 'flexslider' );
					wp_enqueue_script( 'wc-add-to-cart-variation' );
					echo '<div class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="tk tk-eye fa-fw"></i></a></div>';
				}
				?>
				<a href="<?php
				echo get_the_permalink(); ?>" class="link-images-product"></a>
			</div>
			<div class="product__title">
				<a href="<?php
				echo get_the_permalink(); ?>" class="title"><?php
					the_title(); ?></a>

				<div class="block-after-title">
					<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
				</div>
				<div class="description">
					<?php
					echo apply_filters( 'woocommerce_short_description', thim_excerpt( 30 ) ); ?>
				</div>
				<?php

				/**
				 * woocommerce_after_shop_loop_item hook
				 *
				 * @hooked woocommerce_template_loop_add_to_cart - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item' );
				?>
			</div>
		</div>
	<?php } ?>
</li>
