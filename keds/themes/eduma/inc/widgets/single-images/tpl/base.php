<?php
$link_before = $after_link = $image = $images_size = '';
$src         = wp_get_attachment_image_src( $instance['image'], $instance['image_size'] );
$on_click_action = ( isset( $instance['on_click_action'] ) && $instance['on_click_action'] != '' ) ? $instance['on_click_action'] : 'none';
$target         = isset($instance['link_target']) ? $instance['link_target'] : '_self';

$text_align = ( isset($instance['image_alignment']) && '' != $instance['image_alignment'] ) ? 'text-'.$instance['image_alignment'] : '';

if($on_click_action == 'custom-link'){
	if ( $instance['image_link'] ) {
		$link_before = '<a target="' . $target . '" href="' . $instance['image_link'] . '">';
		$after_link  = "</a>";
	}
}elseif($on_click_action == 'popup'){
	wp_enqueue_script( 'magnific-popup');
	$link_before = '<a class="thim-single-image-popup" href="' . $src[0] . '">';
	$after_link  = "</a>";
}

echo '<div class="single-image ' . $text_align . '">' . $link_before;

if ( $src ) {
     if(strpos($instance['image_size'],'x')) {
        $size = explode('x', $instance['image_size']);
		echo thim_get_feature_image( $instance['image'], 'full', $size[0], $size[1] );
	} else {
		$alt = get_post_meta( $instance['image'], '_wp_attachment_image_alt', true ) ? get_post_meta( $instance['image'], '_wp_attachment_image_alt', true ) : '';
 	    echo '<img src ="' . $src['0'] . '" width="' . $src[1] . '" height="' . $src[2] . '" alt="'.$alt.'"/>';
	}
}

echo $after_link . '</div>';