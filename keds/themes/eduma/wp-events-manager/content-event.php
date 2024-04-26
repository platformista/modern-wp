<?php
$display_year = get_theme_mod( 'thim_event_display_year', false );
$time_format  = get_option( 'time_format' );

$month_show = wpems_get_time( 'F' );
if ( $display_year ) {
	$month_show .= ', ' . wpems_get_time( 'Y' );
}
?>
<div <?php post_class( 'item-event' ); ?>>
	<div class="time-from">
		<?php do_action( 'thim_before_event_time' ); ?>
		<div class="date">
			<?php echo esc_html( wpems_get_time( 'd' ) ); ?>
		</div>
		<div class="month">
			<?php echo esc_html( $month_show ); ?>
		</div>
		<?php do_action( 'thim_after_event_time' ); ?>
	</div>
	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="image">';
		echo thim_get_feature_image( get_post_thumbnail_id(), 'full', apply_filters( 'thim_event_thumbnail_width', 450 ), apply_filters( 'thim_event_thumbnail_height', 233 ) );
		echo '</div>';
	}
	?>
	<div class="event-wrapper">
		<?php the_title( sprintf( '<h5 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>

		<div class="meta">
			<div class="time">
				<i class="tk tk-clock"></i>
				<?php echo esc_html( wpems_event_start( $time_format ) ) . ' - ' . esc_html( wpems_event_end( $time_format ) ); ?>
			</div>
			<?php if ( wpems_event_location() ): ?>
				<div class="location">
					<i class="tk tk-map-marker"></i>
					<?php echo ent2ncr( wpems_event_location() ); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="description">
			<?php echo thim_excerpt( 25 ); ?>
		</div>
	</div>

</div>
