<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();
wp_enqueue_script( 'flexslider' );
if ( $attachment_ids ) {
	?>
     <div id="carousel" class="flexslider">
        <ul class="slides flex-control-nav">
            <!-- items mirrored twice, total of 12 -->
			<?php
			if ( $product->get_image_id() ) {
				$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) );
 				$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
 				$attachment_count = count( $product->get_gallery_image_ids() );
				if ( $attachment_count > 0 ) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<li>%s</li>', $image ), $post->ID );
			}
			?>
			<?php
			$loop = 0;
			//$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
			foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
				if ( ! $image_link ) {
					continue;
				}
				$classes[]   = 'image-' . $attachment_id;
				$image       = wp_get_attachment_image( $attachment_id, 'thumbnail' );
				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) );

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li>%s</li>', $image ), $attachment_id, $post->ID, $image_class );
				$loop ++;
			}
			?>
        </ul><!-- .slides -->
    </div><!-- #carousel -->
	<?php
}
