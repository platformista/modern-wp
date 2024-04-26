<?php
global $post;
$number_posts = ( isset( $instance['number_posts'] ) && $instance['number_posts'] ) ? $instance['number_posts'] : 2;

$style = $html_image = $html_des = $html_link = $ex_class = '';

if ( $instance['style'] != '' ) {
	$style = $instance['style'];
}

$show_feature_image = ( isset( $instance['show_feature_image'] )  ) ? $instance['show_feature_image'] : 'yes';
$length_desc        = ( isset( $instance['length_desc'] ) && $instance['length_desc'] ) ? $instance['length_desc'] : 50;
// old Data
$image_size = ( isset( $instance['image_size'] ) && $instance['image_size'] ) ? $instance['image_size'] : 'full';
if ( $image_size == 'none' ) {
	$show_feature_image = 'no';
}

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


switch ( $number_posts ) {
	case 1:
		$class = 'item-post col-sm-12';
		break;
	case 2:
		$class = 'item-post col-sm-6';
		break;
	case 3:
		$class = 'item-post col-sm-4';
		break;
	case 4:
		$class = 'item-post col-sm-3';
		break;
	case 5:
		$class = 'item-post thim_col_custom';
		break;
	case 6:
		$class = 'item-post col-sm-2';
		break;
}

$posts_display = new WP_Query( $query_args );
if ( $posts_display->have_posts() ) {

	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	if ( $style == 'style_2' && $instance['sub_title'] ) {
		echo '<div class="sub_title">' . $instance['sub_title'] . '</div>';
	}

	if ( $style == 'homepage' ) {
		$ex_class .= ' thim-owl-carousel-post row';
	}
	$ex_class .= ' ' . $style;

	echo '<div class="sc-list-post thim-list-posts' . $ex_class . '" >';
	while ( $posts_display->have_posts() ) {
		$posts_display->the_post();
		if ( $style == 'home-new' || $style == 'sidebar' ) {
			$class = 'item-post';
		}
		if ( has_post_thumbnail() && $show_feature_image == 'yes' ) {
			$html_img   = '';
			$class      .= ' has_thumb';
			$html_img   .= '<div class="article-image image"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">';
			$html_img   .= get_the_post_thumbnail( get_the_ID(), $image_size );
			$html_img   .= '</a></div>';
			$html_image = $html_img;
		}

		if ( $instance['show_description'] && $instance['show_description'] != 'no' ) {
			$html_des = '<div class="description">' . thim_excerpt( $length_desc ) . '</div>';
		}

		?>

	<div <?php post_class( $class ); ?>>
		<?php if ( $style == 'homepage' ) {
			echo ent2ncr( $html_image );
			echo '<div class="content">';
			echo '<div class="info">
						<div class="author"><span>' . esc_html( get_the_author() ) . '</span></div>
						<div class="date">' . get_the_date( get_option( 'date_format' ) ) . '</div>
					</div>';// end info
			echo '<h4 class="title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h4>'; //end title
			echo ent2ncr( $html_des );
			echo '<a class="read-more list-post-read-more-homepage" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . esc_html__( 'Read More', 'eduma' ) . '</a>';
			echo '</div>'; // end content
		} elseif ( $style == 'home-new' ) {
			echo ent2ncr( $html_image );
			echo '<div class="article-title-wrapper">';
			echo '<h5 class="title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="article-title">' . get_the_title() . '</a></h5>';
			echo '<div class="article-date"><i class="tk tk-calendar-with-week-focus"></i> <span class="month">' . get_the_date( 'F' ) . '</span> <span class="day">' . get_the_date( 'd' ) . '</span>, <span class="year">' . get_the_date( 'Y' ) . '</span></div>';
			echo ent2ncr( $html_des );
			echo '</div>';
		} elseif ( $style == 'style_2' ) {
			echo '<div class="block-article-image">';
			echo '<div class="date">' . get_the_date( get_option( 'date_format' ) ) . '</div>';
			echo ent2ncr( $html_image );
			echo '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="icon-post_format"></a>';
			echo '</div>';
			echo '<div class="block-content">';
			echo '<h5 class="title article-title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . get_the_title() . '</a></h5>';
			// info author and comment
			echo '<div class="info">';
			echo '<div class="author"><i class="tk tk-user"></i> ' . esc_html__( 'By', 'eduma' );
			printf( '<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) );
			echo '</div>';
			echo '<div class="comments"><i class="tk tk-comment"></i>';
			comments_popup_link( esc_html__( '0 comments', 'eduma' ), esc_html__( '1 comment', 'eduma' ), '% ' . esc_html__( 'comments', 'eduma' ) );
			echo '</div>';
			echo '</div>';
			// end
			echo '</div>';//end block content
		} else {
			echo ent2ncr( $html_image );
			echo '<div class="article-title-wrapper">';
			echo '<h5 class="title"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="article-title">' . get_the_title() . '</a></h5>';
			echo '<div class="article-date"><span class="day">' . get_the_date( 'd' ) . '</span><span class="month">' . get_the_date( 'M' ) . '</span><span class="year">' . get_the_date( 'Y' ) . '</span></div>';
			echo ent2ncr( $html_des );
			echo '</div>';
		}
		echo '</div>';// end post_class

	}
	echo '</div>';

	if ( $instance['text_link'] && $instance['text_link'] != '' ) {
		echo '<div class="block-read-more link_read_more"><a class="list-post-read-more-' . $style . '" href="' . esc_url( $instance['link'] ) . '">' . $instance['text_link'] . '</a></div>';
	}

}
wp_reset_postdata();

?>