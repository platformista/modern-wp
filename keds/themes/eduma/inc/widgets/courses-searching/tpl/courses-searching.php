<?php
/**
 * Template for displaying default element.
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

$template_path = 'courses-searching/tpl/';
if ( isset( $instance['layout'] ) && 'overlay' == $instance['layout'] ) {
	$layout = $instance['layout'];
} else {
	$layout = 'base';
}

$layout .= '-v3';

?>

<?php
thim_builder_get_template(
	$layout, array(
		'instance' => $instance,
	), $template_path
);
?>
