<?php

$thim_uri_screenshot  = THIM_URI . 'inc/data/demos/demo-so/';
$old_demo             = false;
$extral_demo          = array();
$prefix_thumnnail_url = 'https://thimpresswp.github.io/demo-data/eduma/images/';

$plugin_required_all_demo = array(
	'learnpress',
	'mailchimp-for-wp',
	'contact-form-7',
	'woocommerce',
	//	'revslider',
	'wp-events-manager',
	'tp-portfolio',
	'learnpress-course-review',
	'learnpress-wishlist',
);

if ( apply_filters( 'thim-importer-demo-vc', false ) || get_theme_mod( 'thim_page_builder_chosen' ) == 'visual_composer' ) {
	$folder_demo                  = 'demo-vc';
	$plugin_required_page_builder = array( 'js_composer', 'thim-testimonials', 'thim-our-team' );
	$old_demo                     = true;
} elseif ( apply_filters( 'thim-importer-demo-so', false ) || get_theme_mod( 'thim_page_builder_chosen' ) == 'site_origin' ) {
	// support importer with
	$folder_demo                  = 'demo-so';
	$plugin_required_page_builder = array( 'siteorigin-panels', 'classic-editor', 'thim-testimonials', 'thim-our-team' );
	$old_demo                     = true;
} else {
	$folder_demo                  = 'demo-el';
	$plugin_required_page_builder = array( 'elementor', 'thim-elementor-kit' );
	$extral_demo                  = array(
		"demo-el/demo-main"              => array(
			'title'            => esc_html__( 'Demo Main', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-main/',
			'thumbnail_url'    => esc_url( 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-01.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'demo-main.zip'
			),
		),
		"demo-el/demo-classic"           => array(
			'title'            => esc_html__( 'Demo Classic', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-classic/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-classic.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-page.zip'
			),
		),
		"demo-el/demo-learning-platform" => array(
			'title'            => esc_html__( 'Demo Learning Platform', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-learning-platform/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-learning-platform.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
		),
		"demo-el/demo-marketplace"       => array(
			'title'            => esc_html__( 'Demo MarketPlace', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-marketplace/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-marketplace.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
		),
		"demo-el/demo-ecommerce"         => array(
			'title'            => esc_html__( 'Demo Ecommerce', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-ecommerce/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-ecommerce.jpg?v=1' ),
			'plugins_required' => array_merge(
				array(
					'mailchimp-for-wp',
					'contact-form-7',
					'woocommerce',
					'woo-booster-toolkit'
				),
				$plugin_required_page_builder
			),
		),
		"demo-el/demo-coursera"          => array(
			'title'            => esc_html__( 'Demo Coursera', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-coursera/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-coursera.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
		),
		"demo-el/demo-online-school"     => array(
			'title'            => esc_html__( 'Demo Online School', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-online-school/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-online-school.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-page-video.zip'
			),
		),
		"demo-el/demo-modern-university" => array(
			'title'            => esc_html__( 'Demo Modern University', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-modern-university',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-modern-university.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-university-2.zip'
			),
		),

		"demo-el/demo-university-home" => array(
			'title'            => esc_html__( 'Demo University - New', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/university/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-university-home.jpg' ),
			'plugins_required' => array_merge(
				array(
					'mailchimp-for-wp',
					'contact-form-7',
					'wp-events-manager',
					'tp-portfolio',
				),
				$plugin_required_page_builder
			),
		),

		"demo-el/demo-university-home-1" => array(
			'title'            => esc_html__( 'Demo University - Home 1', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/university/home-1/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-university-home-1.jpg' ),
			'plugins_required' => array_merge(
				array(
					'mailchimp-for-wp',
					'contact-form-7',
					'wp-events-manager',
					'tp-portfolio',
				),
				$plugin_required_page_builder
			),
		),
		"demo-el/demo-university-home-2" => array(
			'title'            => esc_html__( 'Demo University - Home 2', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/university/home-2/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-university-home-2.jpg' ),
			'plugins_required' => array_merge(
				array(
					'mailchimp-for-wp',
					'contact-form-7',
					'wp-events-manager',
					'tp-portfolio',
				),
				$plugin_required_page_builder
			),
		),
		"demo-el/demo-university-home-3" => array(
			'title'            => esc_html__( 'Demo University - Home 3', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/university/home-3/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-university-home-3.jpg' ),
			'plugins_required' => array_merge(
				array(
					'mailchimp-for-wp',
					'contact-form-7',
					//'woocommerce',
					'wp-events-manager',
					'tp-portfolio',
				),
				$plugin_required_page_builder
			),
		),

		"demo-el/demo-ivy-league"   => array(
			'title'            => esc_html__( 'Demo Ivy League', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-ivy-league',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-ivy-league.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-university-3.zip'
			),
		),
		"demo-el/demo-stanford"     => array(
			'title'            => esc_html__( 'Demo Stanford', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-stanford',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-stanford.jpg' ),
			'plugins_required' => array_merge(
				array(
					'thim-twitter',
					'revslider'
					//'instagram-feed',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'home-university-4.zip'
			),
		),
		"demo-el/demo-instructor"   => array(
			'title'            => esc_html__( 'Demo New Instructor', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-instructor/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-instructor.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				), $plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'slider-home-instructor.zip'
			),
		),
		"demo-el/demo-crypto"       => array(
			'title'            => esc_html__( 'Demo Crypto', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-crypto/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-crypto.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'slider-home-crypto.zip'
			),
		),
		"demo-el/demo-new-art"      => array(
			'title'            => esc_html__( 'Demo New Art', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-new-art/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-new-art.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'slider-home-new-art.zip'
			),
		),
		"demo-el/demo-kid-art"      => array(
			'title'            => esc_html__( 'Demo Kid Art', 'eduma' ) . ' - Offline',
			'demo_url'         => 'https://eduma.thimpress.com/demo-kid-art/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-kid-art.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
				), $plugin_required_all_demo, $plugin_required_page_builder
			),
		),
		"demo-el/demo-tech-camp"    => array(
			'title'            => esc_html__( 'Demo Tech Camp', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-tech-camp/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-techcamp.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			)
		),
		"demo-el/demo-kindergarten" => array(
			'title'            => esc_html__( 'Demo Kindergarten - Offline', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-kindergarten/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-kindergarten.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-kindergarten.zip'
			),
		),
		"demo-el/demo-elegant"      => array(
			'title'            => esc_html__( 'Demo Elegant', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-elegant/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-elegant.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'eduma-elegant.zip'
			),
		),
		"demo-el/demo-restaurant"   => array(
			'title'            => esc_html__( 'Demo Restaurant', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-restaurant/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-restaurant.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'demo-restaurant.zip'
			),
		),
		"demo-el/demo-udemy"        => array(
			'title'            => esc_html__( 'Demo Udemy', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-udemy/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-udemy.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'slider-home-udemy.zip'
			),
		),
		"demo-el/demo-tutor-lms"    => array(
			'title'            => esc_html__( 'Demo Tutor lms', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-tutor-lms',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-tutor-lms.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),

			'revsliders' => array(
				'slider-new.zip'
			),
		),
		"demo-el/demo-rtl"          => array(
			'title'            => esc_html__( 'Demo RTL', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-rtl',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-rtl.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),

			'revsliders' => array(
				'demo-rtl.zip'
			),
		),
	);
}
// fix old demo for SO and VC
if ( $old_demo ) {
	$extral_demo = array(
		"$folder_demo/demo-01"           => array(
			'title'            => esc_html__( 'Demo Main Demo', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-01.jpg',
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-page.zip'
			),
		),
		"$folder_demo/demo-02"           => array(
			'title'            => esc_html__( 'Demo Course Era', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-2/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-02.jpg',
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
		),
		"$folder_demo/demo-03"           => array(
			'title'            => esc_html__( 'Demo Online School', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-3/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-03.jpg',
			'plugins_required' =>
				array_merge(
					$plugin_required_all_demo,
					$plugin_required_page_builder,
					array( 'revslider' )
				),
			'revsliders'       => array(
				'home-page-video.zip'
			),
		),
		"$folder_demo/demo-university-2" => array(
			'title'            => esc_html__( 'Demo Modern University', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-university-2/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-university-2.jpg',
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-university-2.zip'
			),
		),
		"$folder_demo/demo-university-3" => array(
			'title'            => esc_html__( 'Demo Ivy League', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-university-3/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-university-3.jpg',
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-university-3.zip'
			),
		),
		"$folder_demo/demo-university-4" => array(
			'title'            => esc_html__( 'Demo Stanford', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-university-4/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-university-4.jpg',
			'plugins_required' => array_merge(
				array(
					'thim-twitter',
					'instagram-feed',
					'revslider',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'home-university-4.zip'
			),
		),
		"$folder_demo/demo-edume"        => array(
			'title'                => esc_html__( 'Demo New Edu', 'eduma' ),
			'demo_url'             => 'https://eduma.thimpress.com/demo-edume/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2019/08/eduma-demo-edume.jpg',
			'plugins_required'     => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'child_theme_required' => 'eduma-child-udemy',
			'revsliders'           => array(
				'slider-home-udemy.zip'
			),
		),
		"$folder_demo/demo-instructor"   => array(
			'title'                => esc_html__( 'Demo New Instructor', 'eduma' ),
			'demo_url'             => 'https://eduma.thimpress.com/demo-instructor/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2019/08/eduma-demo-instructor.jpg',
			'plugins_required'     => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'child_theme_required' => 'eduma-child-instructor',
			'revsliders'           => array(
				'slider-home-instructor.zip'
			),
		),
		"$folder_demo/demo-crypto"       => array(
			'title'                => esc_html__( 'Demo Crypto', 'eduma' ),
			'demo_url'             => 'https://eduma.thimpress.com/demo-crypto/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2019/11/eduma-demo-crypto.jpg',
			'plugins_required'     => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'child_theme_required' => 'eduma-child-crypto',
			'revsliders'           => array(
				'slider-home-crypto.zip'
			),
		),
		"$folder_demo/demo-new-art"      => array(
			'title'                => esc_html__( 'Demo New Art', 'eduma' ),
			'demo_url'             => 'https://eduma.thimpress.com/demo-new-art/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2019/11/eduma-demo-new-art.jpg',
			'plugins_required'     => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'child_theme_required' => 'eduma-child-new-art',
			'revsliders'           => array(
				'slider-home-new-art.zip'
			),
		),
		"$folder_demo/demo-kid-art"      => array(
			'title'                => esc_html__( 'Demo Kid Art', 'eduma' ) . ' - Offline',
			'demo_url'             => 'https://eduma.thimpress.com/demo-kid-art/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2019/11/eduma-demo-kid-art.jpg',
			'plugins_required'     => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
				), $plugin_required_all_demo, $plugin_required_page_builder
			),
			'child_theme_required' => 'eduma-child-kid-art',
		),
		"$folder_demo/demo-tech-camp"    => array(
			'title'                => esc_html__( 'Demo Tech Camp', 'eduma' ),
			'demo_url'             => 'https://eduma.thimpress.com/demo-tech-camp/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2019/11/eduma-demo-tech-camp.jpg',
			'plugins_required'     => array_merge(
				array(
					'learnpress-collections',
					'thim-twitter',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'child_theme_required' => 'eduma-child-tech-camps',
		),
		"$folder_demo/demo-kindergarten" => array(
			'title'                => esc_html__( 'Demo Kindergarten - Offline', 'eduma' ),
			'demo_url'             => 'https://eduma.thimpress.com/demo-kindergarten/',
			'thumbnail_url'        => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-kindergarten.jpg',
			'plugins_required'     => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'child_theme_required' => 'eduma-child-kindergarten',
			'revsliders'           => array(
				'home-kindergarten.zip'
			),
		),
		"$folder_demo/demo-rtl"          => array(
			'title'            => esc_html__( 'Demo RTL', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-rtl/',
			'thumbnail_url'    => 'https://updates.thimpress.com/wp-content/uploads/2017/06/eduma-demo-rtl.png',
			'plugins_required' =>
				array_merge(
					$plugin_required_all_demo,
					$plugin_required_page_builder,
					array( 'revslider' )
				),
			'revsliders'       => array(
				'home-page.zip'
			),
		),
	);
}

$demo_datas = array_merge(
	$extral_demo,
	array(
		// Elementor
		"$folder_demo/demo-languages-school" => array(
			'title'            => esc_html__( 'Demo Languages School', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-languages-school/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-languages-school.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-languages-school.zip'
			),
		),
		"$folder_demo/demo-courses-hub"      => array(
			'title'            => esc_html__( 'Demo Courses Hub', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-courses-hub/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-courses-hub.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
		),
		"$folder_demo/demo-university"       => array(
			'title'            => esc_html__( 'Demo University', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-university/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-university.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-university.zip'
			),
		),

		"$folder_demo/demo-one-instructor" => array(
			'title'            => esc_html__( 'Demo One Instructor', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-one-instructor/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-one-instructor.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-one-instructor.zip'
			),
		),
		"$folder_demo/demo-one-course"     => array(
			'title'            => esc_html__( 'Demo One Course', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-one-course/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-one-course.jpg' ),
			'plugins_required' => array_merge(
				$plugin_required_all_demo,
				$plugin_required_page_builder,
				array( 'revslider' )
			),
			'revsliders'       => array(
				'home-one-course.zip'
			),
		),
		"$folder_demo/demo-edtech"         => array(
			'title'            => esc_html__( 'Demo Edtech', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-edtech/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-edtech.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-co-instructor',
					'thim-twitter',
					'revslider'
					//	'instagram-feed',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'home-edtech.zip'
			),
		),
		"$folder_demo/demo-react"          => array(
			'title'            => esc_html__( 'Demo React', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-react/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-react.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-co-instructor',
					'thim-twitter',
					'revslider'
					//'instagram-feed',
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'home-react.zip'
			),
		),
		"$folder_demo/demo-grad-school"    => array(
			'title'            => esc_html__( 'Demo Grad School', 'eduma' ),
			'demo_url'         => 'https://eduma.thimpress.com/demo-grad-school/',
			'thumbnail_url'    => esc_url( $prefix_thumnnail_url . 'demo-grad-school.jpg' ),
			'plugins_required' => array_merge(
				array(
					'learnpress-collections',
					'revslider'
				),
				$plugin_required_all_demo,
				$plugin_required_page_builder
			),
			'revsliders'       => array(
				'home-grad-school.zip'
			),
		),
	)
);

return $demo_datas;
