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

$template_path = 'courses/tpl/';
$layout        = ( isset( $instance['layout'] ) && $instance['layout'] != '' ) ? $instance['layout'] : 'slider';
$layout        .= '-v3';

$args                 = array();
$args['before_title'] = '<h3 class="widget-title">';
$args['after_title']  = '</h3>';

// query
$limit   = $instance['limit'];
$sort    = $instance['order'];
$feature = ! empty( $instance['featured'] ) ? true : false;
$condition = array(
	'post_type'           => 'lp_course',
	'posts_per_page'      => $limit,
	'ignore_sticky_posts' => true,
);
if ( $sort == 'category' && $instance['cat_id'] && $instance['cat_id'] != 'all' ) {
	if ( get_term( $instance['cat_id'], 'course_category' ) ) {
		$condition['tax_query'] = array(
			array(
				'taxonomy' => 'course_category',
				'field'    => 'term_id',
				'terms'    => $instance['cat_id']
			),
		);
	}
}
if ( $sort == 'popular' ) {
	$post_in               = eduma_lp_get_popular_courses( $limit );
	$condition['post__in'] = $post_in;
	$condition['orderby']  = 'post__in';
}

if ( $feature ) {
	$condition['meta_query'] = array(
		array(
			'key'   => '_lp_featured',
			'value' => 'yes',
		)
	);
}

$args['condition']  = $condition;

thim_builder_get_template(
	$layout, array(
	'instance' => $instance,
	'args'     => $args
), $template_path
);

?>
