<?php
/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/tabs.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$tabs = learn_press_get_course_tabs();
?>

<?php foreach ( $tabs as $key => $tab ) { ?>
	<div class="udemy_content_course">
		<?php
		if ( apply_filters( 'learn_press_allow_display_tab_section', true, $key, $tab ) ) {
			if ( is_callable( $tab['callback'] ) ) {
				echo '<div class="course-tab-panel-'.$key.'" id="tab-'.$key.'">';

//				if ( 'reviews' == $key ) {
//					$tab['callback'] = 'thim_udemy_course_review';
//				}
				if ( 'faqs' == $key ) {
					 echo '<h3 class="title-faq">'.esc_html__('FAQs','learnpress').'</h3>';
 				}
				call_user_func( $tab['callback'], $key, $tab );

				echo '</div>';
 			} else {
				/**
				 * @since 3.0.0
				 */
				do_action( 'learn-press/course-tab-content', $key, $tab );
			}
		}
		?>
	</div>
<?php } ?>