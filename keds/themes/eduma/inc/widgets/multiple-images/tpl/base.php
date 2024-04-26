<?php
$link_before = $after_link = $image = $class = '';
if ( ! empty( $instance['image'] ) ) {
	if ( ! empty( $instance['link_target'] ) ) {
		$t = 'target="' . $instance['link_target'] . '"';
	} else {
		$t = '';
	}

	$columns = ! empty( $instance['column'] ) ? $instance['column'] : 1;

	switch ( $columns ) {
		case 1:
			$class = 'col-sm-12';
			break;
		case 2:
			$class = 'col-sm-6';
			break;
		case 3:
			$class = 'col-sm-4';
			break;
		case 4:
			$class = 'col-sm-3';
			break;
		case 5:
			$class = 'thim-col-5';
			break;

		default:
			$class = 'col-sm-12';
	}
 	if ( ! is_array( $instance['image'] ) ) {
		$img_id = explode( ",", $instance['image'] );
	} else {
		$img_id = $instance['image'];
	}
  	if ( $instance['image_link'] ) {
		$img_url = explode( ",", $instance['image_link'] );
	}
 	if ( ! empty( $instance['title'] ) ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}

	echo '<div class="thim-multiple-images-wrapper row">';
	$i = 0;
	foreach ( $img_id as $id ) {
		$src = wp_get_attachment_image_src( $id, $instance['image_size'] );
		$alt = get_post_meta( $id, '_wp_attachment_image_alt', true ) ? get_post_meta( $id, '_wp_attachment_image_alt', true ) : '';

		if ( $src ) {
			$image = '<img src ="' . esc_url( $src['0'] ) . '" width="' . $src[1] . '"  height="' . $src[2] . '" alt="' . $alt . '"/>';
		}
		if ( $instance['image_link'] && isset( $img_url[ $i ] ) ) {
 			$link_before = '<a ' . $t . ' href="' . esc_url( $img_url[ $i ] ) . '">';
			$after_link  = "</a>";
		}
		echo '<div class="' . $class . '">' . $link_before . $image . $after_link . "</div>";
		$i ++;
	}
	echo "</div>";
}