<?php
/**
 * Section Single
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'product_single',
		'panel'    => 'woocommerce',
		'title'    => esc_html__( 'Single Pages', 'eduma' ),
		'priority' => 10,
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_woo_single_tpl',
		'type'          => 'tp_notice',
 		'description'   => sprintf( __( 'This page is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=single-product' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'product_single',
		'priority'      => 11,
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_woo_single_layout',
		'type'          => 'radio-image',
		'label'         => esc_html__( 'Single Layouts', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to choose a layout for all product single pages.', 'eduma' ),
		'section'       => 'product_single',
		'priority'      => 12,
		'default'       => 'sidebar-right',
		'choices'       => array(
			'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
			'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

// Enable or disable breadcrumbs
thim_customizer()->add_field(
	array(
		'id'            => 'thim_woo_single_hide_breadcrumbs',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hide Breadcrumbs?', 'eduma' ),
		'tooltip'       => esc_html__( 'Check this box to hide/show breadcrumbs.', 'eduma' ),
		'section'       => 'product_single',
		'default'       => false,
		'priority'      => 15,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

// Enable or disable title
thim_customizer()->add_field(
	array(
		'id'            => 'thim_woo_single_hide_title',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hide Title', 'eduma' ),
		'tooltip'       => esc_html__( 'Check this box to hide/show title.', 'eduma' ),
		'section'       => 'product_single',
		'default'       => false,
		'priority'      => 18,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'text',
		'id'            => 'thim_woo_single_sub_title',
		'label'         => esc_html__( 'Sub Heading', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can setup sub heading.', 'eduma' ),
		'section'       => 'product_single',
		'priority'      => 20,
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'image',
		'id'            => 'thim_woo_single_top_image',
		'label'         => esc_html__( 'Top Image', 'eduma' ),
		'priority'      => 30,
		'transport'     => 'postMessage',
		'section'       => 'product_single',
		'default'       => THIM_URI . "images/bg-page.jpg",
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

// Page Title Background Color
thim_customizer()->add_field(
	array(
		'id'            => 'thim_woo_single_bg_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'       => esc_html__( 'If you do not use background image, then can use background color for page title on heading top. ', 'eduma' ),
		'section'       => 'product_single',
		'default'       => 'rgba(0,0,0,0.5)',
		'priority'      => 35,
		'choices'       => array( 'alpha' => true ),
		'transport'     => 'postMessage',
		'js_vars'       => array(
			array(
				'choice'   => 'color',
				'element'  => '.top_site_main>.overlay-top-header',
				'property' => 'background',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_woo_single_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make text color for title.', 'eduma' ),
		'section'       => 'product_single',
		'default'       => '#ffffff',
		'priority'      => 40,
		'choices'       => array( 'alpha' => true ),
		'transport'     => 'postMessage',
		'js_vars'       => array(
			array(
				'choice'   => 'color',
				'element'  => '.top_site_main h1, .top_site_main h2',
				'property' => 'color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_woo_single_sub_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Sub Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make sub title color page title.', 'eduma' ),
		'section'       => 'product_single',
		'default'       => '#999',
		'priority'      => 45,
		'choices'       => array( 'alpha' => true ),
		'transport'     => 'postMessage',
		'js_vars'       => array(
			array(
				'choice'   => 'color',
				'element'  => '.top_site_main .banner-description',
				'property' => 'color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'select',
		'id'            => 'thim_woo_related_column',
		'label'         => esc_html__( 'Related & Upsell Columns', 'eduma' ),
		'default'       => '3',
		'priority'      => 50,
		'multiple'      => 0,
		'section'       => 'product_single',
		'choices'       => array(
			'2' => esc_html__( '2', 'eduma' ),
			'3' => esc_html__( '3', 'eduma' ),
			'4' => esc_html__( '4', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-product' )
		)
	)
);
