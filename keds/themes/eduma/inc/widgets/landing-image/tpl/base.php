<?php

$title  = $instance['title'] ? $instance['title'] : '';
$link   = $instance['link'] ? $instance['link'] : '';
$target = $instance['link_target'] ? $instance['link_target'] : '_blank';

$src = wp_get_attachment_image_src( $instance['image'], 'full' );

if ( empty( $src ) ) {
	return;
}

?>
<div class="landing-image">
	<?php if ( $link != '' ): ?>
	<a class="image-link" href="<?php echo esc_attr( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
		<?php endif; ?>
		<div class="image" style="background-image: url('<?php echo esc_attr( $src[0] ); ?>')"></div>

		<?php if ( $link != '' ): ?>
	</a>
<?php endif; ?>
	<?php if ( $title != '' ): ?>
		<h3 class="title">
			<?php if ( $link != '' ): ?>
			<a href="<?php echo esc_attr( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
				<?php endif; ?>
				<?php echo esc_html( $title ); ?>
				<?php if ( $link != '' ): ?>
			</a>
		<?php endif; ?>
		</h3>
	<?php endif; ?>
</div>
