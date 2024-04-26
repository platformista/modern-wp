<?php
/**
 * Section Course Collection
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'collection_single',
		'panel'    => 'course',
		'title'    => esc_html__( 'Collection Pages', 'eduma' ),
		'priority' => 20,
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'thim_collection_single_layout',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Layout', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows you to choose a layout to display for all single course pages.', 'eduma' ),
		'section'  => 'collection_single',
		'priority' => 12,
		'default'  => 'sidebar-right',
		'choices'  => array(
			'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
			'full-content'    => THIM_URI . 'images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3'
		)
	)
);

// Enable or disable breadcrumbs
thim_customizer()->add_field(
	array(
		'id'       => 'thim_collection_single_hide_breadcrumbs',
		'type'     => 'switch',
		'label'    => esc_html__( 'Hide Breadcrumbs?', 'eduma' ),
		'tooltip'  => esc_html__( 'Check this box to hide/show breadcrumbs.', 'eduma' ),
		'section'  => 'collection_single',
		'default'  => false,
		'priority' => 15,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);

// Enable or disable title
thim_customizer()->add_field(
	array(
		'id'       => 'thim_collection_single_hide_title',
		'type'     => 'switch',
		'label'    => esc_html__( 'Hide Title', 'eduma' ),
		'tooltip'  => esc_html__( 'Check this box to hide/show title.', 'eduma' ),
		'section'  => 'collection_single',
		'default'  => false,
		'priority' => 18,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);

thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_collection_single_sub_title',
		'label'    => esc_html__( 'Sub Heading', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows you can setup sub heading.', 'eduma' ),
		'section'  => 'collection_single',
		'priority' => 20,
	)
);

thim_customizer()->add_field(
	array(
		'type'      => 'image',
		'id'        => 'thim_collection_single_top_image',
		'label'     => esc_html__( 'Top Image', 'eduma' ),
		'priority'  => 30,
		'transport' => 'postMessage',
		'section'  => 'collection_single',
		'default'     => THIM_URI . "images/bg-page.jpg",
	)
);

// Page Title Background Color
thim_customizer()->add_field(
	array(
		'id'          => 'thim_collection_single_bg_color',
		'type'        => 'color',
		'label'       => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'     => esc_html__( 'If you do not use background image, then can use background color for page title on heading top. ', 'eduma' ),
		'section'     => 'collection_single',
		'default'     => 'rgba(0,0,0,0.5)',
		'priority'    => 35,
		'choices' => array ('alpha'     => true),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.top_site_main>.overlay-top-header',
				'property' => 'background',
			)
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'          => 'thim_collection_single_title_color',
		'type'        => 'color',
		'label'       => esc_html__( 'Title Color', 'eduma' ),
		'tooltip'     => esc_html__( 'Allows you can select a color make text color for title.', 'eduma' ),
		'section'     => 'collection_single',
		'default'     => '#ffffff',
		'priority'    => 40,
		'choices' => array ('alpha'     => true),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.top_site_main h1, .top_site_main h2',
				'property' => 'color',
			)
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'          => 'thim_collection_single_sub_title_color',
		'type'        => 'color',
		'label'       => esc_html__( 'Sub Title Color', 'eduma' ),
		'tooltip'     => esc_html__( 'Allows you can select a color make sub title color page title.', 'eduma' ),
		'section'     => 'collection_single',
		'default'     => '#999',
		'priority'    => 45,
		'choices' => array ('alpha'     => true),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'color',
				'element'  => '.top_site_main .banner-description',
				'property' => 'color',
			)
		)
	)
);