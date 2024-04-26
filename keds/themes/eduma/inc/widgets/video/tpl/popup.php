<?php
$videos = '';

$width = $height = '100%';
if ( isset( $instance['video_width'] ) && '' != $instance['video_width'] ) {
	$width = $instance['video_width'];
}
if ( isset( $instance['video_height'] ) && '' != $instance['video_height'] ) {
	$height = $instance['video_height'];
}
$poster = !empty( $instance['poster'] ) ? wp_get_attachment_image_src( $instance['poster'], 'full' ) : false;
if ( !empty( $poster ) ) {
	$style = 'style="background: url(' . $poster[0] . ');"';
}

$popup_id = 'popup-id'.rand(0, 9999);
wp_enqueue_script( 'magnific-popup');
?>

<div class="thim-video-popup" <?php echo !empty( $style ) ?  $style : ''; ?>>
	<div class="video-info">
		<a class="button-popup" href="#<?php echo esc_attr($popup_id); ?>"><i class="tk tk-play"></i></a>
		<?php
		if ( !empty( $instance['title'] ) ) {
			echo '<h4 class="video-title">' . $instance['title'] . '</h4>';
		}
		if ( !empty( $instance['description'] ) ) {
			echo '<div class="video-description">' . $instance['description'] . '</div>';
		}
		?>
	</div>
	<div class="video-content mfp-hide" id="<?php echo esc_attr($popup_id); ?>">
		<?php

		if ( isset( $instance['video_type'] ) && $instance['video_type'] == 'youtube' ) {
			echo '<div class="video"><iframe id="thim-video" width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . esc_attr( $instance['youtube_id'] ) . '" allowfullscreen style="border: 0;"></iframe></div>';
		} else {
			echo '<div class="video"><iframe id="thim-video" width="' . $width . '" height="' . $height . '" src="https://player.vimeo.com/video/' . esc_attr( $instance['external_video'] ) . '?portrait=0&title=0&byline=0&badge=0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="border: 0px;"></iframe></div>';
		}

		?>
	</div>
</div>