<?php
$title  = !empty( $instance['title'] ) ? $instance['title'] : '';
$link   = !empty( $instance['link'] ) ? $instance['link'] : '';
$image  = !empty( $instance['image'] ) ? $instance['image'] : '';
$layout = !empty( $instance['layout'] ) ? ' layout-' . $instance['layout'] : '';

?>
<?php if ( $image ) { ?>
	<div class="thim-image-box<?php echo esc_attr( $layout ); ?>">
		<?php echo thim_get_feature_image( $image ); ?>
		<div class="title">
			<h3><?php echo $link ? '<a href="' . $link . '">' . esc_html( $title ) . '</a>' : esc_html( $title ); ?></h3>
		</div>
	</div>
<?php } ?>
