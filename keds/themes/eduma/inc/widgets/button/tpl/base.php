<?php
// Title
$icon         = $icon_size = $icon_position = '';
$title        = isset( $instance['title'] ) ? $instance['title'] : '';
$url          = isset( $instance['url'] ) ? $instance['url'] : '';
$new_window   = isset( $instance['new_window'] ) ? $instance['new_window'] : '';
$custom_style = isset( $instance['custom_style'] ) && $instance['custom_style'] != 'default' ? ' custom_style' : '';

if ( isset( $instance['icon'] ) && ! empty( $instance['icon']['icon'] ) ) {
	$icon = $instance['icon']['icon'];
}
// Icon Size
if ( isset( $instance['icon']['icon_size'] ) && ! empty( $instance['icon']['icon_size'] ) ) {
	$icon_size = $instance['icon']['icon_size'] ? ' style="font-size: ' . $instance['icon']['icon_size'] . 'px;"' : '';
}

if ( isset( $instance['icon']['icon_position'] ) && ! empty( $instance['icon']['icon_position'] ) ) {
	$icon_position = $instance['icon']['icon_position'];
}

$button_size = $instance['layout']['button_size'];
$rounding    = $instance['layout']['rounding'];

// Open New Window
$style = $attr_btn = '';

if ( $new_window ) {
	$attr_btn = ' target="_blank"';
}

if ( ! empty( $custom_style ) ) {
	if ( ! empty( $instance['style_options']['font_size'] ) ) {
		$style .= "--widget-button-font-size: " . $instance['style_options']['font_size'] . "px;";
		//		$style .= "--widget-button-font-size-hover: " . $instance['style_options']['font_size'] . "px;";
	}
	if ( ! empty( $instance['style_options']['font_weight'] ) ) {
		$style .= "--widget-button-font-weight: " . $instance['style_options']['font_weight'] . ";";
		//		$style_hover .= "font-weight: " . $instance['style_options']['font_weight'] . ";";
	}
	if ( ! empty( $instance['style_options']['border_width'] ) ) {
		$style .= "--widget-button-border-width: " . $instance['style_options']['border_width'] . ";";
		//		$style_hover .= "border-width: " . $instance['style_options']['border_width'] . ";";
	} else {
		$rounding .= ' no-border';
	}
	if ( ! empty( $instance['style_options']['color'] ) ) {
		$style .= "--widget-button-color: " . $instance['style_options']['color'] . ";";
	}
	if ( ! empty( $instance['style_options']['border_color'] ) ) {
		$style .= "--widget-button-border-color: " . $instance['style_options']['border_color'] . ";";
	}
	if ( ! empty( $instance['style_options']['bg_color'] ) ) {
		$style .= "--widget-button-background-color: " . $instance['style_options']['bg_color'] . ";";
	}

	if ( ! empty( $instance['style_options']['hover_color'] ) ) {
		$style .= "--widget-button-color-hover: " . $instance['style_options']['hover_color'] . ";";
	}
	if ( ! empty( $instance['style_options']['hover_border_color'] ) ) {
		$style .= "--widget-button-border-color-hover: " . $instance['style_options']['hover_border_color'] . ";";
	}
	if ( ! empty( $instance['style_options']['hover_bg_color'] ) ) {
		$style .= "--widget-button-background-color-hover: " . $instance['style_options']['hover_bg_color'] . ";";
	}
	$attr_btn = $style ? ' style="' . $style . '"' : '';
}

// Icon
if ( $icon ) {
	if ( strpos( $icon, 'fa' ) !== false ) {
		$icon = '<i class="' . $icon . '"' . $icon_size . '></i> ';
	} else {
		$icon = '<i class="fa fa-' . $icon . '"' . $icon_size . '></i> ';
	}
}


if ( $icon_position == 'after' ) {
	$content_button = $title . $icon;
	$custom_style   .= ' position-after';
} else {
	$content_button = $icon . $title;
}

echo '<a class="widget-button ' . $rounding . ' ' . $button_size . $custom_style . '" href="' . $url . '"' . $attr_btn . '>' . $content_button . '</a>';

