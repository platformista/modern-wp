<?php
/**
 * Template for displaying forum link in single course page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/bbpress/forum-link.php.
 *
 * @author  ThimPress
 * @package LearnPress/bbPress/Templates
 * @version 3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! isset( $forum_id ) ) {
	return;
}
?>

<div class="forum-link"><label><?php esc_html_e( 'Connect', 'eduma' ); ?></label>
	<div class="value">
		<?php
		$lpbb_post_status = get_post_status( get_the_ID() );
		if ( $lpbb_post_status == 'publish' ) {
			?>
 			<a class="learn-press-course-forum-link"
			   href="<?php echo get_permalink( $forum_id ); ?>"><?php echo get_the_title( $forum_id ); ?></a>
			<?php
		} else {
			?>
			<span class="learn-press-course-forum-link"><?php echo get_the_title( $forum_id ); ?></span>
		<?php } ?>
	</div>
</div>