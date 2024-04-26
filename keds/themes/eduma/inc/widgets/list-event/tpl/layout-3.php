<?php
$number_posts = $instance['number_posts'] ? $instance['number_posts'] : 10;
$list_status  = $instance['status'] ? $instance['status'] : array( 'happening', 'upcoming' );
$list_cat     = $instance['cat_id'] ? $instance['cat_id'] : '';
$query_args   = array(
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
	echo '<div class="list-event-layout-3">';
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	echo '<div class="thim-list-event ' . $instance['layout'] . '">';

	while ( $events->have_posts() ) {
		$events->the_post();
		?>
		<div <?php post_class( 'item-event thim-col-2' ); ?>>
			<div class="time-from">
				<?php do_action( 'thim_before_event_time' ); ?>
				<div class="date">
					<?php echo esc_html( wpems_get_time( 'd' ) ); ?>
				</div>
				<div class="month">
					<?php echo esc_html( wpems_get_time( 'M' ) ); ?>
				</div>
				<?php do_action( 'thim_after_event_time' ); ?>
			</div>
			<div class="event-wrapper">
				<?php the_title( sprintf( '<h5 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
				<div class="location meta">
					<?php echo ent2ncr( wpems_event_location() ); ?>
				</div>
				<a class="read-more" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><i
						class="fa fa-long-arrow-right"></i></a>
			</div>
		</div>
		<?php
	}

	if ( $instance['text_link'] != '' ) {
		echo '<a class="view-all" href="' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '">' . $instance['text_link'] . '</a>';
	}
	echo '</div>';
	echo '</div>'; //End div list-event-layout-3
}
wp_reset_postdata();
