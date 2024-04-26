<?php
/**
 * Section Utilities
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'utilities',
		'panel'    => 'general',
		'priority' => 100,
		'title'    => esc_html__( 'Utilities', 'eduma' ),
	)
);

// Feature: Google Analytics
thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_google_analytics',
		'label'    => esc_html__( 'Google Analytics', 'eduma' ),
		'tooltip'  => esc_html__( 'Enter your ID Google Analytics.', 'eduma' ),
		'section'  => 'utilities',
		'priority' => 10,
	)
);

// Feature: Facebook Pixel
thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_facebook_pixel',
		'label'    => esc_html__( 'Facebook Pixel', 'eduma' ),
		'tooltip'  => esc_html__( 'Enter your ID Facebook Pixel.', 'eduma' ),
		'section'  => 'utilities',
		'priority' => 20,
	)
);

// Feature: Body custom class
thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_body_custom_class',
		'label'    => esc_html__( 'Body Custom Class', 'eduma' ),
		'tooltip'  => esc_html__( 'Enter body custom class.', 'eduma' ),
		'section'  => 'utilities',
		'priority' => 30,
	)
);

// Feature: Body custom class
thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_register_redirect',
		'label'    => esc_html__( 'Register Redirect', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows register redirect url. Blank will redirect to home page.', 'eduma' ),
		'section'  => 'utilities',
		'priority' => 40,
	)
);

// Feature: Body custom class
thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_login_redirect',
		'label'    => esc_html__( 'Login Redirect', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows login redirect url. Blank will redirect to home page.', 'eduma' ),
		'section'  => 'utilities',
		'priority' => 50,
	)
);

thim_customizer()->add_field(
	array(
		'type'     => 'select',
		'id'       => 'thim_page_builder_chosen',
		'label'    => esc_html__( 'Page Builder', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows select page builder which you want to using.', 'eduma' ),
		'priority' => 55,
		'multiple' => 0,
		'section'  => 'utilities',
		'choices'  => array(
			''                => esc_html__( 'Select', 'eduma' ),
			'site_origin'     => esc_html__( 'Site Origin', 'eduma' ),
			'visual_composer' => esc_html__( 'Visual Composer', 'eduma' ),
			'elementor'       => esc_html__( 'Elementor', 'eduma' ),
		),
	)
);
