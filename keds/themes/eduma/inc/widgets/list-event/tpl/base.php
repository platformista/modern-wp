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
		'relation' => 'OR',
		array(
			'taxonomy' => 'tp_event_category',
			'field'    => 'term_id',
			'terms'    => $list_cat_arr,
		),
	);
}

$events = new WP_Query( $query_args );


$display_year = get_theme_mod( 'thim_event_display_year', false );

if ( $events->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	echo '<div class="thim-list-event">';
	if ( $instance['text_link'] <> '' ) {
		echo '<a class="view-all" href="' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '">' . $instance['text_link'] . '</a>';
	}

	while ( $events->have_posts() ) {
		$events->the_post();

		get_template_part( 'wp-events-manager/content', 'event' );

	}
	echo '</div>';
}

wp_reset_postdata();
