<?php
$number_posts = $instance['number_posts'] ? $instance['number_posts'] : 10;
$list_status  = $instance['status'] ? $instance['status'] : array( 'happening', 'upcoming' );
$list_cat     = $instance['cat_id'] ? $instance['cat_id'] : '';

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

if ( $events->have_posts() ) {
	echo '<div class="thim-list-event list-event-' . $instance['layout'] . '">';
	if ( $instance['title'] || $instance['sub_title'] ) {
		echo '<div class="event-widget-title">';
		if ( $instance['title'] ) {
			echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
		}
		if ( $instance['sub_title'] ) {
			echo '<div class="sub_title">' . $instance['sub_title'] . '</div>';
		}
		echo '</div>';
	}
	echo '<div class="thim_full_right thim-event-' . $instance['layout'] . '"><div class="inner-content-thim-event">';
	echo '<div class="thim-carousel-wrapper"  data-visible="' . esc_attr( $instance['number_posts_slider'] ) . '" data-itemtablet="2" data-itemmobile="1" data-pagination="0" data-navigation="1" data-autoplay="0">';
	while ( $events->have_posts() ) {
		$events->the_post();
		$time_from = wpems_event_start( get_option( 'time_format' ) );
		$time_end  = wpems_event_end( get_option( 'time_format' ) );
		?>
		<div class="item-slider">
			<div class="image">
				<?php echo get_the_post_thumbnail( get_the_ID(), array( 475, 350 ) ); ?>
				<div class="date">
					<?php echo esc_attr( wpems_get_time( 'd' ) ); ?>
				</div>
			</div>
			<div class="event-wrapper">
				<?php

				the_title( sprintf( '<h5 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h5>' );

				echo '<div class="meta">';
				if ( $time_from || $time_end ) {
					echo '<span class="time-from-end"><i class="tk tk-clock"></i>' . $time_from . ' - ' . $time_end . '</span>';
				}
				if ( wpems_event_location() ) {
					echo '<span class="location"><i class="tk tk-map-marker"></i>' . wpems_event_location() . '</span>';
				}
				echo '</div>';
				?>
				<div class="description">
					<?php echo thim_excerpt( 15 ); ?>
				</div>
				<a class="link-event"
				   href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php esc_html_e( 'View Details', 'eduma' ); ?>
				</a>
			</div>
		</div>
		<?php
	}
	echo '</div>';
	echo '</div></div>';

	echo '</div>';
}
wp_reset_postdata();
?>
