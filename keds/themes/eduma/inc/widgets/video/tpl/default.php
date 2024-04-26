<?php
$type = $images = $videos = $layout = '';

$images = ( $instance['self_poster'] ) ? explode( ",", $instance['self_poster'] ) : '';

$videos = ( $instance['external_video'] ) ? explode( ",", $instance['external_video'] ) : '';

$layout .= ( $instance['layout_video'] ) ? $instance['layout_video'] : '';

$type .= $instance['type_video'];

if ( $type == 'single' ) {
	?>
	<div class="beauty" style="position: relative;">
		<div class="video-container content-asset">
			<div class="hideClick beauty-intro">
				<?php
				if ( !empty( $instance['title'] ) ) {
					echo '<h2>' . esc_html( $instance['title'] ) . '</h2>';
				}
				if ( !empty( $instance['desc'] ) ) {
					echo '<p>' . esc_html( $instance['desc'] ) . '</p>';
				}
				?>
			</div>
			<?php
			$src_poster = wp_get_attachment_image_src( $instance['self_poster'] );
			if ( $src_poster ) { ?>
				<div class="btns">
					<div class="btn-player"><i class="fa fa-play-circle"></i></div>
					<p class="watch"><?php echo esc_html__( 'Watch the video', 'eduma' ) ?></p>
				</div>
				<?php
				echo ' <img src="' . esc_attr( $src_poster[0] ) . '" class="yt-player beauty-bg" data-parallax-trigger=".beauty" data-video="' . esc_attr( $instance['external_video'] ) . '?enablejsapi=1&amp;autoplay=1&amp;modestbranding=1&amp;rel=0&amp;color=white&amp;theme=light">';
			} else {
				echo '<iframe height="500" src="' . esc_attr( $instance['external_video'] ) . '" allowfullscreen="" style="border: 0px;"></iframe>';
			}
			?>
		</div>
	</div>
<?php } else {
	$arr_img = array();
	$i       = 0;
	foreach ( $images as $image ) {
		$src         = wp_get_attachment_image_src( $image, 'full' );
		$arr_img[$i] = $src[0];
		$i ++;
	}
	wp_enqueue_script( 'flexslider' );
	?>
	<div class="flexslider slide-video <?php echo esc_attr( $layout ) ?>">
		<ul class="slides">
			<?php
			for ( $j = 0;
			$j < $i;
			$j ++ ) { ?>
			<li data-thumb="<?php echo $arr_img[$j] ?>">
				<div class="content">
					<div class="play-button"><i class="fa fa-play"></i></div>

					<iframe id="video-gallery" height="500" src="<?php echo $videos[$j] ?>" allowfullscreen="" style="border: 0px;"></iframe>

					<!--					<video autoplay controls>-->
					<!--						<source src="https://eduma.thimpress.com/wp-content/uploads/2015/12/Eduma-learnling.mp4" type="video/mp4">-->
					<!--					</video>-->
					<img class="bg-gallery-video" src="<?php echo $arr_img[$j] ?>" />
				</div>
				<?php } ?>
		</ul>
	</div>
<?php } ?>
