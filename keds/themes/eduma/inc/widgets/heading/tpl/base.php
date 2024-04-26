<?php

$title_uppercase = isset( $instance['title_uppercase'] ) ? $instance['title_uppercase'] : '';
$title_main      = ( isset( $instance['main_title'] ) && $instance['main_title'] != '' ) ? ' <span class="thim-color">' . $instance['main_title'] . '</span>' : '';
$sub_heading     = $sub_heading_css = $html = $css = $color_clone = $line = $clone_title = $line_css = '';

if ( $title_uppercase ) {
	$css .= 'text-transform: uppercase;';
}

if ( isset( $instance['textcolor'] ) && $instance['textcolor'] ) {
	$css         .= 'color:' . $instance['textcolor'] . ';';
	$color_clone = 'style="color:' . $instance['textcolor'] . ';"';
}

//foreach ( $instance['custom_font_heading'] as $i => $feature ) :
if ( isset( $instance['font_heading'] ) && $instance['font_heading'] == 'custom' ) {
	if ( isset( $instance['custom_font_heading']['custom_font_size'] ) && $instance['custom_font_heading']['custom_font_size'] <> '' ) {
		$css .= 'font-size:' . $instance['custom_font_heading']['custom_font_size'] . 'px;';
	}
	if ( isset( $instance['custom_font_heading']['custom_font_weight'] ) && $instance['custom_font_heading']['custom_font_weight'] <> '' ) {
		$css .= 'font-weight:' . $instance['custom_font_heading']['custom_font_weight'] . ';';
	}
	if ( isset( $instance['custom_font_heading']['custom_font_style'] ) && $instance['custom_font_heading']['custom_font_style'] <> '' ) {
		$css .= 'font-style:' . $instance['custom_font_heading']['custom_font_style'] . ';';
	}
}

//endforeach;

if ( $css ) {
	$css = ' style="' . $css . '"';
}

if ( isset( $instance['sub_heading'] ) && $instance['sub_heading'] <> '' ) {
	if ( isset( $instance['sub_heading_color'] ) && $instance['sub_heading_color'] ) {
		$sub_heading_css = 'color:' . $instance['sub_heading_color'] . ';';
	}

	$sub_heading = '<p class="sub-heading" style="' . $sub_heading_css . '">' . $instance['sub_heading'] . '</p>';
}

if ( isset( $instance['line'] ) && $instance['line'] <> '' ) {
	if ( isset( $instance['bg_line'] ) && $instance['bg_line'] ) {
		$line_css = ' style="background-color:' . $instance['bg_line'] . '"';
	}
	$line = '<span' . $line_css . ' class="line"></span>';
}

$clone_title = ! empty( $instance['clone_title'] ) ? 'clone_title' : '';

$text_align = '';
if ( isset( $instance['text_align'] ) && $instance['text_align'] <> '' ) {
	$text_align = $instance['text_align'];
}
if ( isset( $instance['size'] ) && !empty($instance['size'])) {
	$instance['size'] = $instance['size'];
} else {
	$instance['size'] = 'div';
}
$html .= '<div class="sc_heading ' . $clone_title . ' ' . $text_align . '">';

if ( isset( $instance['title'] ) ) {
	$html .= '<' . $instance['size'] . $css . ' class="title">' . $instance['title'] . $title_main . '</' . $instance['size'] . '>';
}

if ( $clone_title && isset( $instance['title'] ) ) {
	$html .= '<div class="clone" ' . $color_clone . '>' . $instance['title'] . '</div>';
}
$html .= $sub_heading;
$html .= $line;
$html .= '</div>';

echo ent2ncr( $html );
