<?php
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'thim-CountTo' );
$border_elegant = $border_not_elegant = $counter_description_color = $counters_icon_value = $counters_value = $counter_value_color = $counters_label = $jugas_animation = $icon = $label = $box_style = $text_number = $border_color = $counter_style = $view_more_button = $view_more_text = $view_more_link = '';

if ( ! empty( $instance['text_number'] ) ) {
	$text_number = $instance['text_number'];
}
if ( ! empty ( $instance['view_more_text'] ) ) {
	$view_more_text = $instance['view_more_text'];
}

if ( ! empty ( $instance['view_more_link'] ) ) {
	$view_more_link = $instance['view_more_link'];
}

if ( $instance['counters_label'] <> '' ) {
	$counters_label = $instance['counters_label'];
}

if ( $instance['counter_value_color'] <> '' ) {
	$counter_value_color = 'style="color:' . $instance['counter_value_color'] . '"';
}

if ( $instance['border_color'] <> '' ) {
	$border_color = 'border-color:' . $instance['border_color'] . ';';
}

if ( $instance['counter_color'] <> '' ) {
	$counters_icon_value = 'color:' . $instance['counter_color'] . ';';
}

if ( $instance['counter_label_color'] <> '' ) {
	$counter_description_color = 'color:' . $instance['counter_label_color'] . ';';
}

if ( $instance['background_color'] <> '' ) {
	$box_style .= ' background-color:' . $instance['background_color'] . ';';
}

if ( $instance['counters_value'] <> '' ) {
	$counters_value = $instance['counters_value'];
}

/* show icon or custom icon */
$html_icon = '';
if ( $instance['icon_type'] == 'font-awesome' ) {
	if ( $instance['icon'] == '' ) {
		$instance['icon'] = 'none';
	}
	if ( $instance['icon'] != 'none' ) {
		if ( strpos( $icon, 'fa' ) !== false ) {
			$icon = '<i class="' . $instance['icon'] . '"></i>';
		} else {
			$icon = '<i class="fa fa-' . $instance['icon'] . '"></i>';
		}
	}
} else {
	if ( $instance['icon_type'] == 'font-7-stroke' ) {
		wp_enqueue_style('font-pe-icon-7');
		if ( $instance['icon_stroke'] == '' ) {
			$instance['icon_stroke'] = 'none';
		}
		if ( $instance['icon_stroke'] != 'none' ) {
			if ( strpos( $instance['icon_stroke'], 'pe-7s' ) !== false ) {
				$class = $instance['icon_stroke'];
			} else {
				$class = 'pe-7s-' . $instance['icon_stroke'];
			}

			$icon = '<i class="' . $class . '"></i>';
		}
	} else if ( $instance['icon_type'] == 'font-flaticon' ) {
		wp_enqueue_style('flaticon');
		if ( $instance['icon_flat'] == '' ) {
			$instance['icon_flat'] = 'none';
		}
		if ( $instance['icon_flat'] != 'none' ) {
			if ( strpos( $instance['icon_flat'], 'flaticon' ) !== false ) {
				$class = $instance['icon_flat'];
			} else {
				$class = 'flaticon-' . $instance['icon_flat'];
			}

			$icon = '<i class="' . $class . '"></i>';
		}
	} else {
		$icon .= '<span class="icon icon-images">' . thim_get_feature_image( $instance['icon_img'] ) . '</span>';
	}
}
/* end show icon or custom icon */

if ( $instance['style'] <> '' ) {
	$counter_style = $instance['style'];
}
if( $counter_style != 'demo-elegant' ) {
    $border_not_elegant = $border_color;
} else {
    $border_elegant = $border_color;
}
echo '<div class="counter-box ' . $counter_style . '" style="'. $border_elegant . $box_style . '">';
if ( $icon ) {
	echo '<div class="icon-counter-box" style="' . $border_not_elegant . $counters_icon_value . '">' . $icon . '</div>';
}
if ( $counters_label != '' ) {
	$label = '<div class="counter-box-content" style="' . $counter_description_color . '">' . $counters_label . '</div>';
}
if ( '' != $view_more_text && '' != $view_more_link ) {
	if ( isset( $view_more_link['url'] ) ) {
		$view_more_button = '<a class="view-more" href="' . $view_more_link['url'] . '">' . $view_more_text . '<i class="fa fa-chevron-right"></i></a>';
	} else {
		$view_more_button = '<a class="view-more" href="' . $view_more_link . '">' . $view_more_text . '<i class="fa fa-chevron-right"></i></a>';
	}
}

if ( $counters_value != '' ) {
	echo '<div class="content-box-percentage">
		<div class="wrap-percentage">
		<div class="display-percentage" data-percentage="' . $counters_value . '" ' . $counter_value_color . '>'
		. $counters_value . '</div><div class="text_number">' . $text_number . '</div></div>';
	echo '<div class="counter-content-container">' . $label . $view_more_button . '</div></div>';
}

echo '</div>';


?>