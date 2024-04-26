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
	'ignore_sticky_posts' => true,
);

if ( $list_cat && $list_cat != 'all' ) {
	$list_cat_arr            = explode( ',', $list_cat );
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'tp_event_category',
			'field'    => 'term_id',
			'terms'    => $list_cat_arr,
		),
	);
}

$events = new WP_Query( $query_args );

wp_enqueue_script( 'thim_simple_slider' );
if ( $events->have_posts() ) {
	echo '<div class="list-event-slider">';
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	
 	echo '<div class="thim-event-simple-slider ' . $instance['layout'] . '" data-visible="1" data-pagination="false">';

	while ( $events->have_posts() ) {

		$events->the_post(); 
		?>
		<div <?php post_class( 'item-event' ); ?>>
			<div class="image">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
			</div>
			<div class="event-wrapper">
				<div class="box-time">
					<div class="time-from">
						<div class="date">
							<?php echo esc_html( wpems_get_time( 'd' ) ); ?>
						</div>
						<div class="month">
							<?php echo esc_html( wpems_get_time( 'M' ) ); ?>
						</div>
					</div>
				</div>

				<?php the_title( sprintf( '<h5 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>

				<div class="desc">
					<?php echo thim_excerpt( 15 ); ?>
				</div>
				<a class="read-more" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php esc_html_e( 'Read More', 'eduma' ); ?>
					<i class="fa fa-long-arrow-right"></i>
				</a>
			</div>
		</div>
		<?php

	}

	echo '</div>';

	if ( $instance['text_link'] != '' ) {
		echo '<a class="view-all" href=' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '">' . $instance['text_link'] . '</a>';
	}

	echo '</div>'; //End div list-event-slider
	?>
	<script type="text/javascript">
		jQuery(document).ready(function () {
			"use strict";
			jQuery('.thim-event-simple-slider').thim_simple_slider({
				item        : 3,
				itemActive  : 1,
				itemSelector: '.item-event',
				align       : 'right',
				pagination  : true,
				navigation  : true,
				height      : 392,
				activeWidth : 1170,
				itemWidth   : 800,
				prev_text   : '<i class="fa fa-long-arrow-left"></i>',
				next_text   : '<i class="fa fa-long-arrow-right"></i>',
			});
		});
	</script>
	<?php
}
wp_reset_postdata();

?>
