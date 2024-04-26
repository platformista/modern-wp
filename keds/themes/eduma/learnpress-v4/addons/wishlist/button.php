<?php
/**
 * Template for displaying button to toggle course wishlist on/off.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/wishlist/button.php.
 *
 * @author ThimPress
 * @package LearnPress/Wishlist/Templates
 * @version 3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
if (!isset($classes) || !isset($course_id) || !isset($title) || !isset($state)) {
	return;
}
if ( version_compare( LEARNPRESS_VERSION, '4.0.0-beta-0', '>=' ) ) {
	$lp_version = 'lp4';
} else {
	$lp_version = 'lp3';
}

echo '<div class="course-wishlist-box">';
printf(
	'<button class="'.$lp_version.' learn-press-course-wishlist lp-button gray learn-press-course-wishlist-button-%2$d wishlist-button %s" data-id="%s" data-nonce="%s" title="%s" data-text="%s">%s</button>',
	join( " ", $classes ),
	$course_id,
	wp_create_nonce( 'course-toggle-wishlist' ),
	$title,
	__( 'Processing...', 'learnpress-wishlist' ),
	$state == 'on' ? __( 'Remove from Wishlist', 'learnpress-wishlist' ) : __( 'Add to Wishlist', 'learnpress-wishlist' )
);
echo '</div>';
?>
