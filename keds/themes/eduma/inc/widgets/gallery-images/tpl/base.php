<?php

$link_before = $after_link = $image =  $data_slider = $alt_title = '';
 
$have_color  = ( isset( $instance['have_color'] ) && $instance['have_color'] == 'yes' ) ? '' : ' not_have_color';

// slider options
if(isset($instance['item'] )){
	$instance['number'] = $instance['item']; 
 }
if ( isset($instance['number']) ) {
	$data_slider = ' data-visible="' . $instance['number'] . '"'; 
}
$data_slider .= isset($instance['item_tablet']) ? ' data-itemtablet="' . $instance['item_tablet'] . '"' : '';
$data_slider .= isset($instance['item_mobile']) ? ' data-itemmobile="' . $instance['item_mobile'] . '"' : '';
$data_slider .= ( isset( $instance['auto_play'] ) && $instance['auto_play'] == 'yes' ) ? ' data-autoplay="1"' : ' data-autoplay="0"';
$data_slider .= ( isset( $instance['show_navigation'] ) && $instance['show_navigation'] == 'yes' ) ? ' data-navigation="1"' : ' data-navigation="0"';
$data_slider .= ( isset( $instance['show_pagination'] ) && $instance['show_pagination'] == 'yes' ) ? ' data-pagination="1"' : ' data-pagination="0"';
$data_slider .= ' data-loop="true"';


if ( ! empty( $instance['title'] ) ) {
	echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
}
if ( $instance['image'] ) {
 	$t = isset($instance['link_target'])?'target=' . $instance['link_target'] : '';
 
	 
	if ( ! is_array( $instance['image'] ) ) {
		$img_id = explode( ",", $instance['image'] );
	} else {
		$img_id = $instance['image'];
	}

	if ( $instance['image_link'] ) {
		$img_url = explode( ",", $instance['image_link'] );
	}
	echo '<div class="thim-carousel-wrapper gallery-img' . $have_color . '"' . $data_slider . '>';
	$i = 0;
	
	foreach ( $img_id as $id ) {
 		if ( $instance['image_link'] && isset( $img_url[ $i ] ) ) {
			$link_before = '<a ' . $t . ' href="' . esc_url( $img_url[ $i ] ) . '">';
			$after_link  = "</a>";
		}
		if(isset($instance['show_alt_title']) && $instance['show_alt_title'] == 'yes'){
			$alt_title = '<h4>'.get_the_title($id).'</h4>';
		}
		echo '<div class="item">' . $link_before . wp_get_attachment_image($id, $instance['image_size']). $alt_title. $after_link . "</div>";
		$i ++;
	}
	echo "</div>";
}