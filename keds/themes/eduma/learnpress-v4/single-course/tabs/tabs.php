<?php
/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/tabs.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php $tabs = learn_press_get_course_tabs(); ?>

<?php
if ( empty( $tabs ) ) {
	return;
}
// Show status course
$lp_user = learn_press_get_current_user();

if ( $lp_user && ! $lp_user instanceof LP_User_Guest ) {
	$can_view_course = $lp_user->can_view_content_course( get_the_ID() );

	if ( ! $can_view_course->flag ) {
		if ( LP_BLOCK_COURSE_FINISHED === $can_view_course->key ) {
			learn_press_display_message(
				esc_html__( 'You finished this course. This course has been blocked', 'learnpress' ),
				'warning'
			);
		} elseif ( LP_BLOCK_COURSE_DURATION_EXPIRE === $can_view_course->key ) {
			learn_press_display_message(
				esc_html__( 'This course has been blocked reason by expire', 'eduma' ),
				'warning'
			);
		}
	}
}
?>

<div id="learn-press-course-tabs" class="course-tabs">

	<ul class="nav nav-tabs">
		<?php
		$tab_default = get_option( 'learnpress_tab_course_default' );
		$i           = 0;

		foreach ( $tabs as $key => $tab ) {
			?>
			<?php
			$classes = array( 'course-nav-tab-' . esc_attr( $key ) );

			if ( ! empty( $tab['active'] ) && $tab['active'] ) {
				$classes[] = 'active';
			}

			?>
			<li role="presentation" class="<?php echo join( ' ', $classes ); ?>">
				<a href="#<?php echo esc_attr( $tab['id'] ); ?>" data-toggle="tab">
					<?php
					if ( ! isset( $tab['custom'] ) ) {
						?>
						<i class="fa <?php echo $tab['icon']; ?>"></i>
						<span><?php echo $tab['title']; ?></span>
						<?php
					} else {
						do_action( 'learn-press/course-tab-nav', $tab, $key );
					}
					?>

				</a>
			</li>
			<?php

		}
		?>
	</ul>

	<div class="tab-content">
		<?php foreach ( $tabs as $key => $tab ) { ?>
			<div
				class="tab-pane course-tab-panel-<?php echo esc_attr( $key ); ?> course-tab-panel<?php echo ! empty( $tab['active'] ) && $tab['active'] ? ' active' : ''; ?>"
				id="<?php echo esc_attr( $tab['id'] ); ?>">
				<?php
				if ( apply_filters( 'learn_press_allow_display_tab_section', true, $key, $tab ) ) {
					if ( is_callable( $tab['callback'] ) ) {
						call_user_func( $tab['callback'], $key, $tab );
					} else {
						/**
						 * @since 4.0.0
						 */
						do_action( 'learn-press/course-tab-content', $key, $tab );
					}
				}
				?>
			</div>
		<?php } ?>

	</div>

</div>
