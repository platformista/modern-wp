<?php
/**
 * Template for displaying instructor of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/instructor.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}

$author_id  = $course->get_author( 'id' );
$instructor = learn_press_get_user( $author_id );

if ( ! $instructor ) {
	return;
}

if ( thim_is_new_learnpress( '4.2.3' ) ) {
	$link_author = $instructor->get_url_instructor();
} else {
	$link_author = learn_press_user_profile_link( $author_id );
}
?>

<div class="course-author" itemscope itemtype="http://schema.org/Person">
	<?php echo '<a href="' . $link_author . '">' . $instructor->get_profile_picture( '', 50 ) . '</a>'; ?>
	<div class="author-contain">
		<div class="value" itemprop="name">
			<?php
			echo wp_kses_post( sprintf( '<a href="%s">%s</a>', $link_author, $instructor->get_display_name() ) );
			?>
		</div>
	</div>
</div>
