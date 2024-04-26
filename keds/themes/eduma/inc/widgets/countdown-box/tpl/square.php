<?php
$random       = rand( 1, 99 );
$text_days    = ( isset( $instance['text_days'] ) && '' != $instance['text_days'] ) ? $instance['text_days'] : 'days';
$text_hours   = ( isset( $instance['text_hours'] ) && '' != $instance['text_hours'] ) ? $instance['text_hours'] : 'hours';
$text_minutes = ( isset( $instance['text_minutes'] ) && '' != $instance['text_minutes'] ) ? $instance['text_minutes'] : 'minutes';
$text_seconds = ( isset( $instance['text_seconds'] ) && '' != $instance['text_seconds'] ) ? $instance['text_seconds'] : 'seconds';

$year  = ! empty( $instance['time_year'] ) ? (int) ( $instance['time_year'] ) : date( "Y", time() );
$month = ! empty( $instance['time_month'] ) ? (int) ( $instance['time_month'] ) : date( "m", time() );
$day   = ! empty( $instance['time_hour'] ) ? (int) ( $instance['time_day'] ) : date( "d", time() );
$hour  = ! empty( $instance['time_hour'] ) ? (int) ( $instance['time_hour'] ) : date( "G", time() );

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

wp_enqueue_script( 'jquery-classycountdown', THIM_URI . 'inc/widgets/countdown-box/js/jquery.classycountdown.js', array( 'jquery' ), '1.2' );
wp_enqueue_script( 'jquery-throttle', THIM_URI . 'inc/widgets/countdown-box/js/jquery.throttle.js', array( 'jquery' ), null );
wp_enqueue_script( 'jquery-knob', THIM_URI . 'inc/widgets/countdown-box/js/jquery.knob.js', array( 'jquery' ), null );
?>

<div id="countdown<?php echo esc_attr( $random ); ?>" class="thim_countdown_square style_white_wide"></div>
<script type="text/javascript">
    (function($) {
        'use strict';
        $(document).ready(function() {

            $('#countdown<?php echo $random;?>').ClassyCountdown({
                theme        : 'white-wide',
                labels       : true,
                labelsOptions: {
                    lang : {
                        days   : "<?php echo esc_js( $text_days ); ?>",
                        hours  : "<?php echo esc_js( $text_hours ); ?>",
                        minutes: "<?php echo esc_js( $text_minutes ); ?>",
                        seconds: "<?php echo esc_js( $text_seconds ); ?>",
                    },
                    style: 'font-size: 0.5em;',
                },
                now          : '<?php echo strtotime( "now" );?>',
                end          : '<?php echo strtotime( $due_time );?>',
            });
        });
    })(jQuery);
</script>
