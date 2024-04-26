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

$events      = new WP_Query( $query_args );
$event_class = $instance['layout'] . ' has-year';
if ( $events->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	echo '<div class="thim-list-event layout-2 ' . $event_class . '">';

	while ( $events->have_posts() ) {
		$events->the_post();
		?>
		<div <?php post_class( 'item-event' ); ?>>
			<div class="time-from">
				<?php do_action( 'thim_before_event_time' ); ?>
				<div class="date">
					<?php echo esc_html( wpems_get_time( 'd' ) ); ?>
				</div>
				<div class="month">
					<?php echo esc_html( wpems_get_time( 'M, Y' ) ); ?>
				</div>
				<?php do_action( 'thim_after_event_time' ); ?>
			</div>
			<div class="event-wrapper">
				<?php the_title( sprintf( '<h5 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>

				<div class="meta">
					<div class="time">
						<i class="tk tk-clock"></i>
						<?php echo esc_html( wpems_event_start( get_option( 'time_format' ) ) ) . ' - ' . esc_html( wpems_event_end( get_option( 'time_format' ) ) ); ?>
					</div>
					<div class="location">
						<i class="tk tk-map-marker"></i>
						<?php echo ent2ncr( wpems_event_location() ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php

	}
	if ( $instance['text_link'] != '' ) {
		echo '<a class="view-all" href="' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '">' . $instance['text_link'] . '</a>';
	}
	echo '</div>';
}
wp_reset_postdata();
