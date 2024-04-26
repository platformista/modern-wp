<?php
/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/tabs.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$tabs = learn_press_get_course_tabs();
?>

<?php foreach ( $tabs as $key => $tab ) { ?>
	<div id="<?php echo esc_attr( $tab['id'] ); ?>" class="row_content_course">
		<?php if ( thim_lp_style_single_course() == 'new-1' ) { ?>
			<div class="sc_heading clone_title text-left">
				<h2 class="title"><?php echo $tab['title']; ?></h2>
				<div class="clone"><?php echo $tab['title']; ?></div>
			</div>
		<?php } elseif ( thim_lp_style_single_course() == 'layout_style_3' ) {
			if ( $key != 'reviews' ) {
				echo '<h2 class="title">' . $tab['title'] . '</h2>';
			}
		}

		?>
		<?php
		if ( apply_filters( 'learn_press_allow_display_tab_section', true, $key, $tab ) ) {
			if ( isset( $tab['callback'] ) && is_callable( $tab['callback'] ) ) {
				if ( 'faqs' == $key ) {
					echo '<div class="course-tab-panel-' . $key . '">';
					call_user_func( $tab['callback'], $key, $tab );
					echo '</div>';
				} else {
					call_user_func( $tab['callback'], $key, $tab );
				}

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

<?php do_action( 'theme_course_extra_boxes' ); ?>
