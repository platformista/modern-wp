<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
global $product;
 ?>
<div id="content" class="quickview woocommerce">
	<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" class="product-info">
		<script type="text/javascript">
			jQuery(document).ready(function () {
				if (jQuery().flexslider) {
					jQuery('#slider').flexslider({
						animation    : "slide",
						controlNav   : false,
						animationLoop: false,
						slideshow    : false,
						directionNav : true,
						prevText     : "",
						start        : function (slider) {
							jQuery('body').removeClass('loading');
						}
					});
				}
			});
		</script>
		<div class="left col-sm-6">
			<div id="slider" class="flexslider">
				<ul class="slides">
					<?php
					if ( has_post_thumbnail() ) {
						$image            = get_the_post_thumbnail( $product->get_id(), apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
						$image_title      = esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
						$attachment_count = count( $product->get_gallery_image_ids() );
						echo '<li>';
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $product->get_id() );
						echo '</li>';
					}
					$attachment_ids = $product->get_gallery_image_ids();
					?>
					<?php
					$loop = 0;
					foreach ( $attachment_ids as $attachment_id ) {
						$image_link = wp_get_attachment_url( $attachment_id );
						if ( !$image_link ) {
							continue;
						}
						$classes[]   = 'image-' . $attachment_id;
						$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image_title = esc_attr( get_the_title( $attachment_id ) );
						echo '<li>';
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $product->get_id() );
						echo '</li>';
						$loop ++;
					}
					?>
				</ul>
			</div>
		</div>
		<div class="right col-sm-6">
			<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary_quick' );
			?>

		</div>
		<div class="clear"></div>
		<?php echo '<a href="' . esc_attr( get_the_permalink( $product->get_id() ) ) . '" target="_top" class="quick-view-detail">' . esc_html__( 'View Detail', 'eduma' ) . '</a><div class="clear"></div>'; ?>
	</div>
	<!-- #product-<?php the_ID(); ?> -->
</div>
