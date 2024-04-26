<?php
/**
 * Section Blog Archive
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'blog_archive',
		'panel'    => 'blog',
		'title'    => esc_html__( 'Archive Pages', 'eduma' ),
		'priority' => 10,
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_archive_cate_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This page is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=archive-post' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'blog_archive',
		'priority'      => 11,
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_cate_layout',
		'type'          => 'radio-image',
		'label'         => esc_html__( 'Layout', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to choose a layout for all archive pages.', 'eduma' ),
		'section'       => 'blog_archive',
		'priority'      => 12,
		'default'       => 'sidebar-right',
		'choices'       => array(
			'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
			'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

//thim_customizer()->add_field(
//	array(
//		'type'          => 'select',
//		'id'            => 'thim_archive_cate_display_layout',
//		'label'         => esc_html__( 'Layout Type', 'eduma' ),
//		'tooltip'       => esc_html__( 'Choose the layout type for archive blog.', 'eduma' ),
//		'default'       => 'list',
//		'priority'      => 13,
//		'multiple'      => 0,
//		'section'       => 'blog_archive',
//		'choices'       => array(
//			'default' => esc_html__( 'Default', 'eduma' ),
//			'grid'    => esc_html__( 'Grid/List', 'eduma' ),
//		),
//		'wrapper_attrs' => array(
//			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
//		)
//	)
//);

thim_customizer()->add_field(
	array(
 		'id'            => 'thim_archive_cate_display_layout',
		'type'          => 'switch',
		'label'         => esc_html__( 'Show Switch Layout Grid/List', 'eduma' ),
		'section'       => 'blog_archive',
		'default'       => false,
		'priority'      => 20,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);
thim_customizer()->add_field(
	array(
		'type'          => 'select',
		'id'            => 'thim_archive_cate_template',
		'label'         => esc_html__( 'Template Default', 'eduma' ),
		'priority'      => 20,
		'default'       => 'default',
		'multiple'      => 0,
		'section'       => 'blog_archive',
		'choices'       => array(
			'default' => esc_html__( 'Default', 'eduma' ),
			'list' => esc_html__( 'List', 'eduma' ),
			'grid' => esc_html__( 'Grid', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_archive_cate_display_layout',
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
		'id'            => 'thim_archive_cate_columns_grid',
		'label'         => esc_html__( 'Column Grid', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows select column grid.', 'eduma' ),
		'priority'      => 20,
		'default'       => '3',
		'multiple'      => 0,
		'section'       => 'blog_archive',
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
		'id'            => 'thim_archive_cate_hide_title',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hidden Page Title', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can hidden or show page title on heading top.', 'eduma' ),
		'section'       => 'blog_archive',
		'default'       => false,
		'priority'      => 20,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_cate_hide_breadcrumbs',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hidden Breadcrumb', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can hidden breadcrumbs on page title.', 'eduma' ),
		'section'       => 'blog_archive',
		'default'       => false,
		'priority'      => 20,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'text',
		'id'            => 'thim_archive_cate_sub_title',
		'label'         => esc_html__( 'Sub Heading', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can setup sub heading.', 'eduma' ),
		'section'       => 'blog_archive',
		'priority'      => 25,
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_cate_show_description',
		'type'          => 'switch',
		'label'         => esc_html__( 'Show Description', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can show description on archive blog.', 'eduma' ),
		'section'       => 'blog_archive',
		'default'       => false,
		'priority'      => 26,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

// Excerpt Content
thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_excerpt_length',
		'type'          => 'slider',
		'label'         => esc_html__( 'Excerpt Length', 'eduma' ),
		'tooltip'       => esc_html__( 'Choose the number of words you want to cut from the content to be the excerpt of search and archive', 'eduma' ),
		'priority'      => 30,
		'default'       => 30,
		'section'       => 'blog_archive',
		'choices'       => array(
			'min'  => '10',
			'max'  => '100',
			'step' => '5',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'image',
		'id'            => 'thim_archive_cate_top_image',
		'label'         => esc_html__( 'Top Image', 'eduma' ),
		'priority'      => 30,
		'transport'     => 'postMessage',
		'section'       => 'blog_archive',
		'default'       => THIM_URI . "images/bg-page.jpg",
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

// Page Title Background Color
thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_cate_bg_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'       => esc_html__( 'If you do not use background image, then can use background color for page title on heading top. ', 'eduma' ),
		'section'       => 'blog_archive',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_cate_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make text color for title.', 'eduma' ),
		'section'       => 'blog_archive',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_cate_sub_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Sub Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make sub title color page title.', 'eduma' ),
		'section'       => 'blog_archive',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'archive-post' )
		)
	)
);
