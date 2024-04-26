<?php
/**
 * Section Blog Front Page
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'blog_front',
		'panel'    => 'blog',
		'title'    => esc_html__( 'Blog Page', 'eduma' ),
		'priority' => 5,
	)
);
//die;
thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_front_page_cate_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This page is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=archive-post' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'blog_front',
		'priority'      => 11,
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_cate_layout',
		'type'          => 'radio-image',
		'label'         => esc_html__( 'Layout', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to choose a layout for the blog page.', 'eduma' ),
		'section'       => 'blog_front',
		'default'       => 'sidebar-right',
		'priority'      => 12,
		'choices'       => array(
			'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
			'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

//thim_customizer()->add_field(
//	array(
//		'type'     => 'select',
//		'id'       => 'thim_front_page_style_heading_title',
//		'label'    => esc_html__( 'Style Heading title', 'eduma' ),
//		'tooltip'  => esc_html__( 'Select style for Heading title.', 'eduma' ),
//		'default'  => '',
//		'priority' => 14,
//		'multiple' => 0,
//		'section'  => 'blog_front',
//		'choices'  => array(
//			'style_heading_1' => esc_html__( 'Style Heading 1', 'eduma' ),
//			'style_heading_2' => esc_html__( 'Style Heading 2', 'eduma' ),
// 		),
//	)
//);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_cate_display_layout',
		'type'          => 'switch',
		'label'         => esc_html__( 'Show Switch Layout Grid/List', 'eduma' ),
		'section'       => 'blog_front',
		'default'       => false,
		'priority'      => 15,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

// Number columns
thim_customizer()->add_field(
	array(
		'type'          => 'select',
		'id'            => 'thim_front_page_template',
		'label'         => esc_html__( 'Template Default', 'eduma' ),
 		'priority'      => 15,
		'default'       => 'default',
		'multiple'      => 0,
		'section'       => 'blog_front',
		'choices'       => array(
			'default' => esc_html__( 'Default', 'eduma' ),
			'list' => esc_html__( 'List', 'eduma' ),
			'grid' => esc_html__( 'Grid', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_front_page_cate_display_layout',
				'operator' => '!==',
				'value'    => true,
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);
thim_customizer()->add_field(
	array(
		'type'          => 'select',
		'id'            => 'thim_front_page_cate_columns_grid',
		'label'         => esc_html__( 'Column Grid', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows select column grid.', 'eduma' ),
		'priority'      => 20,
		'default'       => '3',
		'multiple'      => 0,
		'section'       => 'blog_front',
		'choices'       => array(
			'2' => esc_html__( '2', 'eduma' ),
			'3' => esc_html__( '3', 'eduma' ),
			'4' => esc_html__( '4', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_hide_title',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hidden Page Title', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can hidden or show page title on heading top.', 'eduma' ),
		'section'       => 'blog_front',
		'default'       => false,
		'priority'      => 23,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_hide_breadcrumbs',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hidden Breadcrumb', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can hidden breadcrumbs on page title.', 'eduma' ),
		'section'       => 'blog_front',
		'default'       => false,
		'priority'      => 24,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'text',
		'id'            => 'thim_front_page_sub_title',
		'label'         => esc_html__( 'Sub Heading', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can setup sub heading.', 'eduma' ),
		'section'       => 'blog_front',
		'priority'      => 25,
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'image',
		'id'            => 'thim_front_page_top_image',
		'label'         => esc_html__( 'Top Image', 'eduma' ),
		'priority'      => 30,
		'transport'     => 'postMessage',
		'section'       => 'blog_front',
		'default'       => THIM_URI . "images/bg-page.jpg",
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

// Page Title Background Color
thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_bg_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'       => esc_html__( 'If you do not use background image, then can use background color for page title on heading top. ', 'eduma' ),
		'section'       => 'blog_front',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make text color for title.', 'eduma' ),
		'section'       => 'blog_front',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_front_page_sub_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Sub Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make sub title color page title.', 'eduma' ),
		'section'       => 'blog_front',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post', array( 'all', 'post_page' ) )
		)
	)
);
