<?php
$display_year          = get_theme_mod( 'thim_event_display_year', false );
$number_posts          = $instance['number_posts'] ? $instance['number_posts'] : 10;
$number_posts_slider   = $instance['number_posts_slider'] ? $instance['number_posts_slider'] : 3;
$list_status           = $instance['status'] ? $instance['status'] : array( 'happening', 'upcoming' );
$list_cat              = $instance['cat_id'] ? $instance['cat_id'] : '';
$background_image      = $instance['background_image'] ? $instance['background_image'] : '';
$background_image_info = wp_get_attachment_image_src( $background_image, 'full' );

$query_args = array(
	'post_type'           => 'tp_event',
	'posts_per_page'      => $number_posts,
	'meta_query'          => array(
		array(
			'key'     => 'tp_event_status',
			'value'   => $list_status,
			'compare' => 'IN',
		),
	),
	'ignore_sticky_posts' => true
);

if ( $list_cat && $list_cat != 'all' ) {
	$list_cat_arr            = explode( ',', $list_cat );
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'tp_event_category',
			'field'    => 'term_id',
			'terms'    => $list_cat_arr
		),
	);
}

$events = new WP_Query( $query_args );

$event_class = $instance['layout'];
if ( $display_year ) {
	$event_class .= ' has-year';
}

if ( $events->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	echo '<div class="thim-list-event ' . $event_class . '">';

	echo '<div class="thim-column-slider thim-carousel-wrapper" data-visible="1" data-itemtablet="1" data-pagination="0" data-navigation="1" data-autoplay="0">';
	$i = 1;
	while ( $events->have_posts() ) {
		$events->the_post();

		$time_from = '<div class="time-from">';
		$time_from .= '<div class="date"> ' . wpems_get_time( 'd' ) . '</div>';
		$time_from .= '<div class="month"> ' . wpems_get_time( 'M, Y' ) . '</div>';
		$time_from .= '	</div>';

		$event_content = '<div class="event-wrapper">';
		$event_content .= sprintf( '<h5 class="title"><a href="%s" rel="bookmark">%s</a></h5>', esc_url( get_permalink() ), esc_attr( get_the_title() ) );
		$event_content .= '<div class="meta">' . wpems_event_location() . ' - ' . wpems_event_start( get_option( 'time_format' ) ) . '</div>';
		$event_content .= '</div>';

		if ( $i <= $number_posts_slider ) {
			?>
			<div <?php post_class( 'item-event' ); ?>>
				<?php
				echo '<div class="event-image">' . thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', '590', '615', get_the_title() ) . '</div>';
				echo '<div class="event-info">';
				echo $time_from;
				echo $event_content;
				echo '</div>';
				?>
			</div>
			<?php
		}

		if ( $i == $number_posts_slider ) {
			echo '</div><div class="thim-column-list">';
		}

		if ( $i > $number_posts_slider ) {
			?>
			<div <?php post_class( 'item-event' ); ?>>
				<?php
				echo $time_from;
				echo '<div class="event-image">' . thim_get_feature_image( get_post_thumbnail_id( get_the_ID() ), 'full', '590', '615', get_the_title() ) . '</div>';
				echo $event_content;
				?>
			</div>
			<?php
		}

		if ( $i == $number_posts_slider && $background_image_info ) {
			echo '<div class="background-image">';
			echo '<img src="' . $background_image_info[0] . '" width="' . $background_image_info[1] . '" height="' . $background_image_info[2] . '" alt="background image"/>';
			echo '</div>';
		}
		$i ++;
	}
	echo '</div>';
	echo '</div>';
}
wp_reset_postdata();
