<?php
$title  = !empty( $instance['title'] ) ? $instance['title'] : '';
$description  = !empty( $instance['description'] ) ? $instance['description'] : '';
$title_bg_color = !empty( $instance['title_bg_color'] ) ? $instance['title_bg_color'] : '';
$link   = !empty( $instance['link'] ) ? $instance['link'] : '';
$image  = !empty( $instance['image'] ) ? $instance['image'] : '';
$layout = !empty( $instance['layout'] ) ? ' template-' . $instance['layout'] : '';

$style_bg = '';
if($title_bg_color != ''){
	$style_bg = 'style=background:'.$title_bg_color;
}

?>
<?php if ( $image ) { ?>
	<div class="thim-image-box<?php echo esc_attr( $layout ); ?>">
		<?php echo thim_get_feature_image( $image ); ?>

		<div class="thim-image-info">
			<div class="title" <?php echo esc_attr($style_bg);?>>
				<h3><?php echo $link ? '<a href="' . $link . '">' . esc_html( $title ) . '</a>' : esc_html( $title ); ?></h3>
			</div>
			<div class="description">
				<?php echo esc_html($description); ?>
			</div>
		</div>
	</div>
<?php } ?>
