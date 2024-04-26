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

$template_path = 'course-categories/tpl/';
$layout        = (isset( $instance['layout'] ) && $instance['layout'] !='') ? $instance['layout'] : 'base';
if ( thim_is_new_learnpress( '3.0' ) ) {
	$layout .= '-v3';
} else if ( thim_is_new_learnpress( '2.0' ) ) {
	$layout .= '-v2';
} else {
	$layout .= '-v1';
}
$args                 = array();
$args['before_title'] = '<h3 class="widget-title">';
$args['after_title']  = '</h3>';

?>

<?php thim_builder_get_template(
	$layout, array(
	'instance' => $instance,
	'args'     => $args
), $template_path
); ?>
