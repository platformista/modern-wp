<?php
require_once THIM_DIR . 'inc/widgets/form-login-register.php';

add_filter( 'thim_register_shortcode', 'thim_register_elements' );

if ( ! function_exists( 'thim_register_elements' ) ) {
	/**
	 * @param $elements
	 *
	 * @return mixed
	 */
	function thim_register_elements() {

		// elements want to add
		$elements = array(
			'general'                      => array(
				'button',
				'accordion',
				'carousel-categories',
				'carousel-post',
				'countdown-box',
				'counters-box',
				'empty-space',
				'gallery-images',
				'gallery-posts',
				'google-map',
				'heading',
				'icon-box',
				'image-box',
				'landing-image',
				'link',
				'list-post',
				'login-form',
				'multiple-images',
				'single-images',
				'social',
				'tab',
				'testimonials',
				'timetable',
				'twitter',
				'video',
				'navigation-menu',
			),
			'LearnPress'                   => array(
				'course-categories',
				'courses',
				'courses-searching',
				'list-instructors',
				//				'one-course-instructors',
			),
			'LP_Co_Instructor_Preload'     => array(
				'one-course-instructors',
			),
			'LP_Addon_Collections_Preload' => array(
				'courses-collection',
			),
			'THIM_Our_Team'                => array(
				'our-team',
			),
			'Thim_Portfolio'               => array(
				'portfolio',
			),
			'WPEMS'                        => array(
				'tab-event',
				'list-event',
			),
		);

		return $elements;
	}
}

add_filter( 'thim_shortcode_group_name', 'thim_shortcode_group_name' );

if ( ! function_exists( 'thim_shortcode_group_name' ) ) {
	function thim_shortcode_group_name() {
		return esc_html__( 'Thim Shortcodes', 'eduma' );
	}
}

// change folder shortcodes to widgets
if ( ! function_exists( 'thim_custom_folder_shortcodes' ) ) {
	function thim_custom_folder_shortcodes() {
		return 'widgets';
	}
}
add_filter( 'thim_custom_folder_shortcodes', 'thim_custom_folder_shortcodes' );

// don't support folder groups
add_filter( 'thim_support_folder_groups', '__return_false' );

if ( ! function_exists( 'thim_ekit_get_widget_template' ) ) {
	function thim_ekit_get_widget_template( $widget_base, $args = array(), $template_name = 'base' ) {
		if ( is_array( $args ) && isset( $args ) ) {
			extract( $args );
		}

		if ( false === strpos( $template_name, '.php' ) ) {
			$template_name .= '.php';
		}

		$parent_path = get_template_directory() . '/inc/widgets/' . $widget_base . '/tpl/' . $template_name;
		$child_path  = get_stylesheet_directory() . '/inc/widgets/' . $widget_base . '/' . $template_name;

		if ( file_exists( $child_path ) ) {
			$template_path = $child_path;
		} elseif ( file_exists( $parent_path ) ) {
			$template_path = $parent_path;
		} else {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_name ), '1.0.0' );

			return;
		}

		require $template_path;
	}
}

// disable mega menu in thim-core
if ( class_exists( 'Thim_EL_Kit' ) ) {
	$ekits_module_settings = get_option( 'thim_ekits_module_settings' );
	if ( ( ! $ekits_module_settings || ! empty( $ekits_module_settings['megamenu'] ) ) ) {
		add_filter( 'thim-support-mega-menu', '__return_false' );
	}
}
