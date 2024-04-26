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

if ( empty( $tabs ) ) {
	return;
}
?>

<div class="thim-course-menu-landing">
	<div class="container">
		<ul class="thim-course-landing-tab">
			<?php foreach ( $tabs as $key => $tab ) { ?>
				<?php
				$classes = array( 'course-nav-tab-' . esc_attr( $key ) );
				if ( ! empty( $tab['current'] ) && $tab['current'] ) {
					$classes[] = 'active';
				}
				?>
				<li role="presentation" class="<?php echo join( ' ', $classes ); ?>">
					<a href="#<?php echo esc_attr( $tab['id'] ); ?>"><?php echo $tab['title']; ?></a>
				</li>
			<?php } ?>
		</ul>

		<?php if ( thim_show_meta_course_coming_soon() ) {
			echo '<div class="thim-course-landing-button">';
			do_action( 'thim_single_course_payment' );
			echo '</div>';
		} ?>
	</div>
</div>
