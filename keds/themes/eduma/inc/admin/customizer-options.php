<?php
/**
 * Create Thim_Startertheme_Customize
 *
 */

/**
 * Class Thim_Customize_Options
 */
class Thim_Customize_Options {
	/**
	 * Thim_Customize_Options constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'thim_deregister' ) );
		add_action( 'thim_customizer_register', array( $this, 'thim_create_customize_options' ) );
	}

	/**
	 * Deregister customize default unnecessary
	 *
	 * @param $wp_customize
	 */
	public function thim_deregister( $wp_customize ) {
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'header_image' );
		$wp_customize->remove_control( 'blogdescription' );
		$wp_customize->remove_control( 'blogname' );
		$wp_customize->remove_control( 'display_header_text' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'custom_css' );
//		$wp_customize->remove_section( 'woocommerce_catalog_columns' );
		// Rename existing section
		$wp_customize->add_section( 'title_tagline', array(
			'title'    => esc_html__( 'Logo', 'eduma' ),
			'panel'    => 'general',
			'priority' => 20,
		) );


	}

	/**
	 * Create customize
	 *
	 * @param $wp_customize
	 */
	public function thim_create_customize_options( $wp_customize ) {

		$DIR = THIM_DIR . "inc/admin/customizer-sections/";

		include $DIR . 'blog.php';
		include $DIR . 'blog-archive.php';
		include $DIR . 'blog-front.php';
		include $DIR . 'blog-meta.php';
		include $DIR . 'blog-singular.php';
		include $DIR . 'footer.php';
		include $DIR . 'footer-copyright.php';
		include $DIR . 'footer-options.php';
		include $DIR . 'general.php';
		include $DIR . 'general-404-page.php';
		include $DIR . 'general-custom-css.php';
		include $DIR . 'general-features.php';
		include $DIR . 'general-layouts.php';
		include $DIR . 'general-logo.php';
		include $DIR . 'general-sharing.php';
		include $DIR . 'general-sidebar.php';
		include $DIR . 'general-styling.php';
		include $DIR . 'general-styling-boxed-bg.php';
		include $DIR . 'general-typography.php';
		include $DIR . 'general-typography-heading.php';
		include $DIR . 'general-utilities.php';
		include $DIR . 'header.php';
		include $DIR . 'header-layouts.php';
		include $DIR . 'header-main-menu.php';
		include $DIR . 'header-mobile-menu.php';
		include $DIR . 'header-sticky-menu.php';
		include $DIR . 'header-sub-menu.php';
		include $DIR . 'header-toolbar.php';
		include $DIR . 'nav-menus.php';
		include $DIR . 'widgets.php';

		if ( class_exists( 'LearnPress' ) ) {
			include $DIR . 'course.php';
			include $DIR . 'course-archive.php';
            include $DIR . 'course-collection.php';
			include $DIR . 'course-features.php';
			include $DIR . 'course-single.php';
		}

		if ( class_exists( 'WPEMS' ) ) {
			include $DIR . 'event.php';
			include $DIR . 'event-archive.php';
			include $DIR . 'event-settings.php';
			include $DIR . 'event-single.php';
		}

		if ( class_exists( 'LP_Addon_bbPress' ) && class_exists( 'bbPress' ) ) {
			include $DIR . 'forum.php';
			include $DIR . 'forum-archive.php';
		}

		if ( class_exists( 'LP_Addon_Collections_Preload' ) ) {
			include $DIR . 'course-collection.php';
		}

		if ( class_exists( 'LP_Addon_Upsell_Preload' ) ) {
			include $DIR . 'course-package.php';
		}

		if ( class_exists( 'Thim_Portfolio' ) ) {
			include $DIR . 'portfolio.php';
			include $DIR . 'portfolio-archive.php';
			include $DIR . 'portfolio-single.php';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			include $DIR . 'product.php';
			include $DIR . 'product-archive.php';
			include $DIR . 'product-settings.php';
			include $DIR . 'product-single.php';
		}

		if ( class_exists( 'THIM_Our_Team' ) ) {
			include $DIR . 'team.php';
			include $DIR . 'team-archive.php';
			include $DIR . 'team-single.php';
		}

		if ( class_exists( 'THIM_Testimonials' ) ) {
			include $DIR . 'testimonials.php';
			include $DIR . 'testimonials-archive.php';
			include $DIR . 'testimonials-single.php';
		}
//		include $DIR . 'dark-mode-settings.php';
	}
}

$thim_customize = new Thim_Customize_Options();
