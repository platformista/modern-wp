<?php
$html     = $class = '';
$group_id = 'accordion_' . uniqid();
$title    = $instance['title'] ? $instance['title'] : '';
if ( isset( $instance['style'] ) && $instance['style'] == 'new-style' ) {
	$class = ' accordion-new-style';
}
$panel_list = $instance['panel'] ? $instance['panel'] : '';
echo '<div class="thim-widget-accordion' . $class . '">';
if ( $title != '' ) {
	echo '<h3 class="widget-title">' . $title . '</h3>';
}
?>
<div id="<?php echo esc_attr( $group_id ); ?>" class="panel-group" role="tablist" aria-multiselectable="true">
	<!-- List Panel -->
	<?php foreach ( $panel_list as $key => $panel ) : ?>

		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="<?php echo esc_attr( 'heading_' . $group_id . '_' . $key ); ?>">
				<h4 class="panel-title">
					<a role="button" class="collapsed" data-toggle="collapse"
					   data-parent="#<?php echo esc_attr( $group_id ); ?>"
					   href="<?php echo esc_attr( '#collapse_' . $group_id . '_' . $key ); ?>" aria-expanded="false"
					   aria-controls="<?php echo esc_attr( 'collapse_' . $group_id . '_' . $key ); ?>">
						<?php echo esc_html( $panel['panel_title'] ); ?>
					</a>
				</h4>
			</div>
			<div id="<?php echo esc_attr( 'collapse_' . $group_id . '_' . $key ); ?>" class="panel-collapse collapse"
				 role="tabpanel" aria-labelledby="<?php echo esc_attr( 'heading_' . $group_id . '_' . $key ); ?>">
				<div class="panel-body">
					<?php echo ent2ncr( $panel['panel_body'] ); ?>
				</div>
			</div>
		</div>

	<?php endforeach; ?>
	<!-- End: List Panel -->
</div>
</div>
