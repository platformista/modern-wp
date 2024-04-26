<?php
$query_args = array(
	'post_type'           => 'tp_event',
	'posts_per_page'      => - 1,
	'meta_query'          => array(
		array(
			'key'     => 'tp_event_status',
			'value'   => array( 'happening', 'upcoming', 'expired' ),
			'compare' => 'IN',
		),
	),
	'ignore_sticky_posts' => true
);
$events     = new WP_Query( $query_args );

$happening = $expired = $upcoming = '';
if ( $events->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	while ( $events->have_posts() ) {

		$events->the_post();
		$event_status = get_post_meta( get_the_ID(), 'tp_event_status', true );
		ob_start();
		get_template_part( 'wp-events-manager/content', 'event' );
		switch ( $event_status ) {
			case 'happening':
				$happening .= ob_get_contents();
				ob_end_clean();
				break;
			case 'expired':
				$expired .= ob_get_contents();
				ob_end_clean();
				break;
			case 'upcoming':
				$upcoming .= ob_get_contents();
				ob_end_clean();
				break;
		}
	}
}
wp_reset_postdata();


?>
<div class="list-tab-event">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-happening" data-toggle="tab"><?php esc_html_e( 'Happening', 'eduma' ); ?></a></li>
		<li><a href="#tab-upcoming" data-toggle="tab"><?php esc_html_e( 'Upcoming', 'eduma' ); ?></a></li>
		<li><a href="#tab-expired" data-toggle="tab"><?php esc_html_e( 'Expired', 'eduma' ); ?></a></li>
	</ul>
	<div class="tab-content thim-list-event">
		<div role="tabpanel" class="tab-pane fade in active" id="tab-happening">
			<?php
			echo ent2ncr( $happening );
			?>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="tab-upcoming">
			<?php
			echo ent2ncr( $upcoming );
			?>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="tab-expired">
			<?php
			echo ent2ncr( $expired );
			?>
		</div>
	</div>
</div>
