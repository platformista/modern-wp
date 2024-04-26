<?php
 if ( $instance['title'] <> '' ) {
	echo '<h3 class="widget-title">' . esc_attr( $instance['title'] ) . '</h3>';
}
if ( $instance['map_options'] == 'api' ) {
	wp_register_script( 'thim-google-map', THIM_URI . 'inc/widgets/google-map/js/js-google-map.js', array( 'jquery' ), true );
	wp_enqueue_script( 'thim-google-map' );
	?>
    <div class="kcf-module">
        <div class="ob-google-map-canvas"
                style="height:<?php echo intval( $height ) ?>px;"
                id="ob-map-canvas-<?php echo esc_attr( $map_id ) ?>"
			<?php foreach ( $map_data as $key => $val ) : ?>
				<?php if ( ! empty( $val ) ) : ?>
                    data-<?php echo esc_attr( $key ) . '="' . esc_attr( $val ) . '"' ?>
				<?php endif ?>
			<?php endforeach; ?>
        ></div>
    </div>
<?php } else {
	if(isset($instance['settings_height'])){
		$instance['settings']['height']  = $instance['settings_height'];
	}
	if(isset($instance['settings_zoom'])){
		$instance['settings']['zoom']  = $instance['settings_zoom'];
	}
	$style_height = $instance['settings']['height'] ? ' style ="height: ' . $instance['settings']['height'] . 'px"' : '';
  	printf(
		'<div class="thim-map-iframe"' . $style_height . '><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near" title="%3$s" aria-label="%3$s"></iframe></div>',
		rawurlencode( $instance['map_center'] ),
		absint( $instance['settings']['zoom'] ),
		esc_attr( $instance['map_center'] )
	);
}
?>

