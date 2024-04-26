<?php
/**
 * Template for displaying default template .
 *
 *
 * @author      ThimPress
 * @package     Thim_Builder/Templates
 * @version     1.0.0
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

$template_path = 'google-map/tpl/';
$layout        = 'base';

$args                 = array();
$args['before_title'] = '<h3 class="widget-title">';
$args['after_title']  = '</h3>';

$settings = $instance['settings'];

$markers  = $instance['markers'];

$mrkr_src = wp_get_attachment_image_src( $instance['markers']['marker_icon'] );
$api_key  = ( ! empty( $instance['api_key'] ) ) ? $instance['api_key'] : '';

$map_id   = md5( $instance['map_center'] );
$height   = $settings['height'];
$map_data = array(
	'display_by'       => ( isset( $instance['display_by'] ) && $instance['display_by'] != 'address' ) ? $instance['display_by'] : 'address',
	'lat'              => isset( $instance['location']['lat'] ) ? $instance['location']['lat'] : 41.956750,
	'lng'              => isset( $instance['location']['lng'] ) ? $instance['location']['lng'] : - 74.545448,
	'address'          => $instance['map_center'],
	'zoom'             => $settings['zoom'],
	'scroll-zoom'      => $settings['scroll_zoom'],
	'draggable'        => $settings['draggable'],
	'marker-icon'      => ! empty( $mrkr_src ) ? $mrkr_src[0] : '',
	'marker-at-center' => $markers['marker_at_center'],
 	'api-key'          => $api_key
);

thim_builder_get_template(
	$layout, array(
	'instance' => $instance,
	'map_id'   => $map_id,
	'height'   => $height,
	'map_data' => $map_data,
	'args'     => $args
), $template_path
);
?>