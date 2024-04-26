<?php
wp_enqueue_script( 'mb-commingsoon' );
$text_days    = ( isset( $instance['text_days'] ) && '' != $instance['text_days'] ) ? $instance['text_days'] : 'days';
$text_hours   = ( isset( $instance['text_hours'] ) && '' != $instance['text_hours'] ) ? $instance['text_hours'] : 'hours';
$text_minutes = ( isset( $instance['text_minutes'] ) && '' != $instance['text_minutes'] ) ? $instance['text_minutes'] : 'minutes';
$text_seconds = ( isset( $instance['text_seconds'] ) && '' != $instance['text_seconds'] ) ? $instance['text_seconds'] : 'seconds';

$year  = !empty( $instance['time_year'] ) ? (int) ( $instance['time_year'] ) : date( "Y", time() );
$month = !empty( $instance['time_month'] ) ? (int) ( $instance['time_month'] ) : date( "m", time() );
$day   = !empty( $instance['time_hour'] ) ? (int) ( $instance['time_day'] ) : date( "d", time() );
$hour  = !empty( $instance['time_hour'] ) ? (int) ( $instance['time_hour'] ) : date( "G", time() );

$due_time = isset( $instance['due-time'] ) ? $instance['due-time'] : ( $year . '/' . $month . '/' . $day . ' ' . $hour . ':00' );
$due_time = date_format( date_create( $due_time ), "Y/m/d H:i" );

$style_color = 'color-white';
if ( $instance['style_color'] != '' ) {
	$style_color = 'color-' . $instance['style_color'];
}

$text_align = '';
if ( $instance['text_align'] != '' ) {
	$text_align = $instance['text_align'];
}
if ( $instance['layout'] != '' ) {
	$text_align .= ' countdown-'.$instance['layout'];
}

$id = uniqid();
echo '<div class="' . $text_align . ' ' . $style_color . '" id="coming-soon-counter' . $id . '"></div>';

?>
<script data-cfasync="true" type="text/javascript">
	(function ($) {
		'use strict';
		$(document).ready(function () {
			if (jQuery().mbComingsoon) {
				$("#coming-soon-counter<?php echo esc_js( $id ); ?>").mbComingsoon({
					expiryDate  : new Date('<?php echo( $due_time ); ?>'),
					localization: {
						days   : "<?php echo esc_js( $text_days ); ?>",
						hours  : "<?php echo esc_js( $text_hours ); ?>",
						minutes: "<?php echo esc_js( $text_minutes ); ?>",
						seconds: "<?php echo esc_js( $text_seconds ); ?>",
					},
					speed       : 100,
				});
				setTimeout(function () {
					jQuery(window).resize();
				}, 200);
			}
		});
	})(jQuery);
</script>