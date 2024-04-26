<?php
$number_posts       = ( isset( $instance['number_posts'] ) && $instance['number_posts'] ) ? $instance['number_posts'] : 3;
$length_desc        = ( isset( $instance['length_desc'] ) && $instance['length_desc'] ) ? $instance['length_desc'] : 13;
$items_vertical     = ( ! empty( $instance['item_vertical'] ) && $instance['item_vertical'] > 0 ) ? $instance['item_vertical'] : 0;
$show_feature_image = ( isset( $instance['show_feature_image'] )  ) ? $instance['show_feature_image'] : 'yes';
// old Data
$image_size = ( isset( $instance['image_size'] ) && $instance['image_size'] ) ? $instance['image_size'] : 'full';
if ( $image_size == 'none' ) {
	$show_feature_image = 'no';
}
$feature_html = '';

$query_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => $number_posts,
	'order'               => ( 'asc' == $instance['order'] ) ? 'asc' : 'desc',
	'ignore_sticky_posts' => true
);
if ( $instance['cat_id'] && $instance['cat_id'] != 'all' ) {
	$query_args['cat'] = $instance['cat_id'];
}
switch ( $instance['orderby'] ) {
	case 'recent' :
		$query_args['orderby'] = 'post_date';
		break;
	case 'title' :
		$query_args['orderby'] = 'post_title';
		break;
	case 'popular' :
		$query_args['orderby'] = 'comment_count';
		break;
	default : //random
		$query_args['orderby'] = 'rand';
}

$posts_display = new WP_Query( $query_args );
$box_class     = $items_vertical < $number_posts ? ' has-horizontal' : '';
$box_class     .= $items_vertical > 0 ? ' has-vertical' : '';
$feature_post  = ( ! empty( $instance['display_feature'] ) && $instance['display_feature'] == 'yes' ) ? $instance['display_feature'] : false;

if ( count( $posts_display->posts ) < $number_posts ) {
	$number_posts = count( $posts_display->posts );
}

if ( $posts_display->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	$index       = 1;
	$inner_class = '';
	if ( $feature_post ) {
		$index        = 0;
		$number_posts = $number_posts - 1;
		$inner_class  = ' has-feature';
	}

	echo '<div class="thim-list-post-inner' . $inner_class . '">';
	echo '<div class="sc-list-post thim-grid-posts' . $box_class . '">';
	while ( $posts_display->have_posts() ) {
		$posts_display->the_post();
		$class = 'item-post';
		// start html_blog
		$html_blog = '';
		if ( $index == 0 ) {
			$image_size = 'full';
		} else {
			$image_size = ( isset( $instance['image_size'] ) && $instance['image_size'] ) ? $instance['image_size'] : 'full';
		}

		$html_blog .= '<div class="' . join( ' ', get_post_class( $class, get_the_ID() ) ) . '">';
		if ( has_post_thumbnail() && $show_feature_image == 'yes' ) {
			$html_blog .= '<div class="article-image">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</div>';
		}
		$html_blog .= '<div class="article-wrapper">';
		$html_blog .= '<div class="date">' . get_the_date( get_option( 'date_format' ) ) . '</div>';
		$html_blog .= '<h5 class="title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="article-title">' . esc_attr( get_the_title() ) . '</a></h5>';
		if ( $instance['show_description'] && $instance['show_description'] <> 'no' ) {
			$html_blog .= '<div class="desc description">' . thim_excerpt( $length_desc ) . '</div>';
		}
		$html_blog .= '<a class="read-more" href="' . get_the_permalink() . '" >' . esc_html__( 'Read More', 'eduma' ) . '<i class="fa fa-long-arrow-right"></i></a>';
		$html_blog .= '</div>';
		$html_blog .= '</div>';
		// end html_blog

		if ( $index == 0 ) {
			$feature_html .= '<div class="feature-item">';
			$feature_html .= $html_blog;
			$feature_html .= '</div>';
		} else {
			if ( $index == 1 && ( $items_vertical < $number_posts ) ) {
				//Open div grid-horizontal
				echo '<div class="grid-horizontal">';
			}
			if ( ( ( $index - 1 == $number_posts - $items_vertical ) && $items_vertical > 0 ) || ( $items_vertical >= $number_posts && $index == 1 ) ) {
				//Open div grid-vertical
				echo '<div class="grid-vertical">';
			}

			echo $html_blog;

			if ( ( $index == $number_posts - $items_vertical ) || ( $index == $number_posts && $items_vertical > 0 ) ) {
				//Close div grid-horizontal and grid-vertical
				echo '</div>';
			}
		}
		$index ++;
	}

	echo '</div>';

	//Link All Posts
	if ( $instance['link'] <> '' && $instance['text_link'] ) {
		echo '<div class="link_read_more"><a href="' . $instance['link'] . '" title="' . $instance['text_link'] . '" >' . $instance['text_link'] . '</a></div>';
	}

	echo ent2ncr( $feature_html );

	echo '</div>';
}
wp_reset_postdata();
