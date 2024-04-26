<?php
$html       = '';
$title      = $instance['title'] ? $instance['title'] : '';
$panel_list = $instance['panel'] ? $instance['panel'] : '';
?>

<div class="thim-widget-timetable">
	<?php
	if ( $title != '' ) {
		echo '<h3 class="widget-title">' . $title . '</h3>';
	}
	?>
	<div class="timetable-group">
		<?php foreach ( $panel_list as $key => $panel ) : ?>
			<?php
			$item_style  = '';
			$class_color = ! empty( $panel['panel_color_style'] ) ? $panel['panel_color_style'] : '';

			if ( ! empty( $panel['panel_background'] ) ) {
				$item_style = '--timetable--background: ' . $panel['panel_background'] . ';';
			}

			if ( ! empty( $panel['panel_background_hover'] ) ) {
				$item_style .= '--timetable-background-hover: ' . $panel['panel_background_hover'];
			}
			$item_style = $item_style ? ' style="' . esc_attr( $item_style ) . '"' : '';
			?>
			<div class="timetable-item <?php echo esc_attr( $class_color ); ?>"<?php echo $item_style; ?>>
				<?php

				echo ( ! empty( $panel['panel_title'] ) ) ? '<h5 class="title">' . $panel['panel_title'] . '</h5>' : '';

				echo ( ! empty( $panel['panel_time'] ) ) ? '<div class="time">' . $panel['panel_time'] . '</div>' : '';

				echo ( ! empty( $panel['panel_location'] ) ) ? '<div class="location">' . $panel['panel_location'] . '</div>' : '';

				echo ( ! empty( $panel['panel_teacher'] ) ) ? '<div class="teacher">' . $panel['panel_teacher'] . '</div>' : '';

				?>

			</div>

		<?php endforeach; ?>
	</div>

</div>
