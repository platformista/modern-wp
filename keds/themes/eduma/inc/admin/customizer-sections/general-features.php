<?php
/**
 * Section Advance features
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'advanced',
		'panel'    => 'general',
		'priority' => 90,
		'title'    => esc_html__( 'Extra Features', 'eduma' ),
	)
);

// Feature: RTL

// Feature: Auto Login
//thim_customizer()->add_field(
//    array(
//        'type'     => 'switch',
//        'id'       => 'thim_form_lp_register',
//        'label'    => esc_html__( 'Form Register of LearnPress', 'eduma' ),
//		'tooltip'  => esc_html__( 'Show form register of LearnPress 4.x  in widget Thim: Login Popup, Thim: Login Form', 'eduma' ),
//        'section'  => 'advanced',
//        'default'  => false,
//        'priority' => 15,
//        'choices'  => array(
//            true  => esc_html__( 'Enable', 'eduma' ),
//            false => esc_html__( 'Disable', 'eduma' ),
//        ),
//     )
//);
// Feature: Auto Login
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'thim_auto_login',
		'label'    => esc_html__( 'Auto Login', 'eduma' ),
		'section'  => 'advanced',
		'default'  => true,
		'priority' => 15,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);
//thim_customizer()->add_field(
//	array(
//		'type'     => 'switch',
//		'id'       => 'thim_disable_el_google_font',
//		'label'    => esc_html__( 'Disable Google Fonts of Elementor', 'eduma' ),
//		'tooltip'  => esc_html__( 'disable auto load google font of elementor', 'eduma' ),
//		'section'  => 'advanced',
//		'default'  => true,
//		'priority' => 20,
//		'choices'  => array(
//			true  => esc_html__( 'On', 'eduma' ),
//			false => esc_html__( 'Off', 'eduma' ),
//		),
//	)
//);
//thim_customizer()->add_field(
//	array(
//		'type'     => 'switch',
//		'id'       => 'thim_disable_style_blocks_woo',
//		'label'    => esc_html__( 'Disable Styles for WooCommerce blocks', 'eduma' ),
//		'tooltip'  => esc_html__( 'disable block editor styles for WooCommerce blocks', 'eduma' ),
//		'section'  => 'advanced',
//		'default'  => true,
//		'priority' => 20,
//		'choices'  => array(
//			true  => esc_html__( 'On', 'eduma' ),
//			false => esc_html__( 'Off', 'eduma' ),
//		),
//	)
//);

// Feature: Smoothscroll
//thim_customizer()->add_field(
//	array(
//		'type'     => 'switch',
//		'id'       => 'thim_smooth_scroll',
//		'label'    => esc_html__( 'Smooth Scrolling', 'eduma' ),
//		'tooltip'  => esc_html__( 'Turn on to enable smooth scrolling.', 'eduma' ),
//		'section'  => 'advanced',
//		'default'  => false,
//		'priority' => 20,
//		'choices'  => array(
//			true  => esc_html__( 'On', 'eduma' ),
//			false => esc_html__( 'Off', 'eduma' ),
//		),
//	)
//);

// Feature: Back To Top
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'thim_show_to_top',
		'label'    => esc_html__( 'Back To Top', 'eduma' ),
		'tooltip'  => esc_html__( 'Turn on to enable the Back To Top script which adds the scrolling to top functionality.', 'eduma' ),
		'section'  => 'advanced',
		'default'  => true,
		'priority' => 40,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);
// Feature: Preload
thim_customizer()->add_field( array(
	'type'          => 'radio-image',
	'id'            => 'thim_to_top_style',
	'section'       => 'advanced',
	'label'         => '',
	'default'       => '',
	'priority'      => 40,
	'choices'       => array(
		''                => THIM_URI . 'images/backtotop/totop1.jpg',
		'circle'         => THIM_URI . 'images/backtotop/totop2.jpg',
 	),
	'wrapper_attrs' => array(
		'class' => '{default_class} thim-col-5'
	),
	'active_callback' => array(
		array(
			'setting'  => 'thim_show_to_top',
			'operator' => '===',
			'value'    => true,
		),
	),
) );

// Border Radius
thim_customizer()->add_field(
	array(
		'id'       => 'thim_content_course_border',
		'type'     => 'switch',
		'label'    => esc_html__( 'Border Radius', 'eduma' ),
		'section'  => 'advanced',
		'default'  => false,
		'priority' => 40,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'tooltip'  => esc_html__( 'Enable border radius in some places (List Course, Button, Shop, Blog .....)', 'eduma' ),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_border_radius',
		'type'            => 'dimensions',
		'label'           => esc_html__( 'Border Radius Size','eduma' ),
		'section'         => 'advanced',
		'priority'        => 40,
		'default'         => [
			'item'     => '4px',
			'item-big' => '10px',
			'button'     => '4px',
		],
		'choices'         => [
			'labels' => [
				'item'     => esc_html__( 'Global - Default', 'eduma' ),
				'item-big' => esc_html__( 'Global - Big', 'eduma' ),
				'button'     => esc_html__( 'Input & Button', 'eduma' ),
			],
		],
		'active_callback' => array(
			array(
				'setting'  => 'thim_content_course_border',
				'operator' => '===',
				'value'    => true,
			),
		),
	)
);


//thim_customizer()->add_field(
//	array(
//		'id'              => 'thim_to_top_position',
//		'type'            => 'select',
//		'label'           => esc_html__( 'Icon To Top Position', 'eduma' ),
//		'priority'        => 41,
//		'multiple'        => 0,
//		'section'         => 'advanced',
//		'choices'         => array(
//			''                  => esc_html__( 'Default', 'eduma' ),
//			'show_in_copyright' => esc_html__( 'Show in copyright', 'eduma' ),
//		),
//		'active_callback' => array(
//			array(
//				'setting'  => 'thim_show_to_top',
//				'operator' => '===',
//				'value'    => true,
//			),
//		),
//	)
//);

// Feature: Preload
thim_customizer()->add_field( array(
	'type'          => 'radio-image',
	'id'            => 'thim_preload',
	'section'       => 'advanced',
	'label'         => esc_html__( 'Preloading', 'eduma' ),
	'default'       => '',
	'priority'      => 70,
	'choices'       => array(
		''                => THIM_URI . 'images/preloading/off.jpg',
		'style_1'         => THIM_URI . 'images/preloading/style-1.gif',
		'style_2'         => THIM_URI . 'images/preloading/style-2.gif',
		'style_3'         => THIM_URI . 'images/preloading/style-3.gif',
		'wave'            => THIM_URI . 'images/preloading/wave.gif',
		'rotating-plane'  => THIM_URI . 'images/preloading/rotating-plane.gif',
		'double-bounce'   => THIM_URI . 'images/preloading/double-bounce.gif',
		'wandering-cubes' => THIM_URI . 'images/preloading/wandering-cubes.gif',
		'spinner-pulse'   => THIM_URI . 'images/preloading/spinner-pulse.gif',
		'chasing-dots'    => THIM_URI . 'images/preloading/chasing-dots.gif',
		'three-bounce'    => THIM_URI . 'images/preloading/three-bounce.gif',
		'cube-grid'       => THIM_URI . 'images/preloading/cube-grid.gif',
		'image'           => THIM_URI . 'images/preloading/custom-image.jpg',
	),
	'wrapper_attrs' => array(
		'class' => '{default_class} thim-col-4'
	)
) );

// Feature: Preload Image Upload
thim_customizer()->add_field( array(
	'type'            => 'image',
	'id'              => 'thim_preload_image',
	'label'           => esc_html__( 'Preloading Custom Image', 'eduma' ),
	'section'         => 'advanced',
	'priority'        => 80,
	'active_callback' => array(
		array(
			'setting'  => 'thim_preload',
			'operator' => '===',
			'value'    => 'image',
		),
	),
) );

// Feature: Preload Colors
thim_customizer()->add_field( array(
	'type'            => 'multicolor',
	'id'              => 'thim_preload_style',
	'label'           => esc_html__( 'Preloading Color', 'eduma' ),
	'section'         => 'advanced',
	'priority'        => 90,
	'choices'         => array(
		'background' => esc_html__( 'Background color', 'eduma' ),
		'color'      => esc_html__( 'Icon color', 'eduma' ),
	),
	'default'         => array(
		'background' => '#ffffff',
		'color'      => '#ffb606',
	),
	'active_callback' => array(
		array(
			'setting'  => 'thim_preload',
			'operator' => '!=',
			'value'    => '',
		),
	),
) );

