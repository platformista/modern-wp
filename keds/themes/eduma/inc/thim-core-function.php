<?php
require THIM_DIR . 'inc/admin/thim-core-installer/installer.php';

if ( class_exists( 'TP' ) ) {
	require THIM_DIR . 'inc/admin/plugins-require.php';
	require THIM_DIR . 'inc/admin/customizer-options.php';
	require_once( THIM_DIR . 'inc/widgets/login-popup/login-popup.php' );
}

require_once THIM_DIR . 'inc/widgets/shortcodes.php';
require_once THIM_DIR . 'inc/widgets/class-el-extend.php';

require THIM_DIR . 'inc/libs/Tax-meta-class/Tax-meta-class.php';

require THIM_DIR . 'inc/tax-meta.php';
require THIM_DIR . 'inc/admin/meta_boxes.php';


/**
 * List child themes.
 *
 * @return array
 */
function thim_eduma_list_child_themes() {
	return array(
		'eduma-child' => array(
			'name'       => 'Eduma Child',
			'slug'       => 'eduma-child',
			'screenshot' => 'https://plugins.thimpress.com/downloads/images/eduma-child.png',
			'source'     => 'https://github.com/ThimPressWP/demo-data/raw/master/eduma/child-themes/eduma-child/eduma-child.zip',
			'version'    => '1.0.0'
		),
	);
}

add_filter( 'thim_core_list_child_themes', 'thim_eduma_list_child_themes' );

/**
 * @param $settings
 *
 * @return array
 */
if ( ! function_exists( 'thim_import_add_basic_settings' ) ) {
	function thim_import_add_basic_settings( $settings ) {
		$settings[] = 'learn_press_archive_course_limit';
		// $settings[] = 'siteorigin_panels_settings';
		$settings[] = 'thim_enable_mega_menu';
		$settings[] = 'permalink_structure';
		$settings[] = 'learn_press_course_thumbnail_dimensions';
		$settings[] = 'thim_ekits_widget_settings';
		$settings[] = 'elementor_css_print_method';
		$settings[] = 'elementor_experiment-container';
		$settings[] = 'elementor_experiment-nested-elements';
		$settings[]	= 'elementor_google_font';
		$settings[]	= 'elementor_disable_typography_schemes';
		$settings[] = 'elementor_experiment-e_font_icon_svg';
		$settings[] = 'thim_ekits_advanced_settings';
		$settings[] = 'wcbt_option';
		$settings[] = 'medium_size_w';
		$settings[] = 'medium_size_h';
		$settings[] = 'woocommerce_single_image_width';
		$settings[] = 'woocommerce_thumbnail_image_width';
		$settings[]	= 'learn_press_primary_color';
		$settings[] = 'learn_press_secondary_color';
		return $settings;
	}
}
add_filter( 'thim_importer_basic_settings', 'thim_import_add_basic_settings' );
add_filter( 'thim_importer_thim_enable_mega_menu', '__return_true' );

// fix import attribute for demo ecommerce
add_filter( 'thim_import_wcbt_attribute_type', function () {
	return array(
		'pa_color' => 'color',
		'pa_image'  => 'image',
		'pa_size'  => 'text'
	);
} );
/**
 * @param $settings
 *
 * @return array
 */
if ( ! function_exists( 'thim_import_add_page_id_settings' ) ) {
	function thim_import_add_page_id_settings( $settings ) {
		$settings[] = 'learn_press_courses_page_id';
		$settings[] = 'learn_press_profile_page_id';
		$settings[] = 'elementor_active_kit';

		return $settings;
	}
}
add_filter( 'thim_importer_page_id_settings', 'thim_import_add_page_id_settings' );

//Add info for Dashboard Admin
if ( ! function_exists( 'thim_eduma_links_guide_user' ) ) {
	function thim_eduma_links_guide_user() {
		return array(
			'docs'      => 'https://docs.thimpress.com/eduma/',
			'support'   => 'https://thimpress.com/forums/forum/eduma/',
			'knowledge' => 'https://thimpress.com/knowledge-base/',
			'changelog' => 'https://thimpress.com/log/education-wordpress-theme-changelog/',
		);
	}
}
add_filter( 'thim_theme_links_guide_user', 'thim_eduma_links_guide_user' );
add_filter( 'thim_theme_customizer_section', 'thim_eduma_customizer_section' );
if ( ! function_exists( 'thim_eduma_customizer_section' ) ) {
	function thim_eduma_customizer_section() {

		$section = array(
			'panel'   => array( 'general', 'header', 'blog', 'course', 'woocommerce', 'event', 'footer', 'widgets', 'nav_menus' ),
			'section' => array( 'typography', 'styling', 'advanced' )
		);
		if ( ! class_exists( 'LearnPress' ) ) {
			unset( $section['panel']['3'] );
		}
		if ( ! class_exists( 'WooCommerce' ) ) {
			unset( $section['panel']['4'] );
		}
		if ( ! class_exists( 'WPEMS' ) ) {
			unset( $section['panel']['5'] );
		}

		return $section;

	}
}
/**
 * Link purchase theme.
 */
if ( ! function_exists( 'thim_eduma_link_purchase' ) ) {
	function thim_eduma_link_purchase() {
		return 'https://1.envato.market/G5Ook';
	}
}
add_filter( 'thim_envato_link_purchase', 'thim_eduma_link_purchase' );

/**
 * Envato id.
 */
if ( ! function_exists( 'thim_eduma_envato_item_id' ) ) {
	function thim_eduma_envato_item_id() {
		return '14058034';
	}
}
add_filter( 'thim_envato_item_id', 'thim_eduma_envato_item_id' );
