<?php
/**
 * Section Blog Singular
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'blog_singular',
		'panel'    => 'blog',
		'title'    => esc_html__( 'Singular Pages', 'eduma' ),
		'priority' => 10,
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_archive_single_tpl',
		'type'          => 'tp_notice',
 		'description'   => sprintf( __( 'This page is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=single-post' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'blog_singular',
		'priority'      => 11,
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'single-post' )
		)
	)
);
thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_single_layout',
		'type'          => 'radio-image',
		'label'         => esc_html__( 'Layout', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to choose a layout to display for all single post pages.', 'eduma' ),
		'section'       => 'blog_singular',
		'priority'      => 12,
		'default'       => 'sidebar-right',
		'choices'       => array(
			'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
			'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3' . thim_customizer_extral_class( 'single-post' )
		)
	)
);
// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_single_hide_title',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hidden Title', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can hidden or show title of post on heading top.', 'eduma' ),
		'section'       => 'blog_singular',
		'default'       => false,
		'priority'      => 12,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);
thim_customizer()->add_field(
	array(
		'type'          => 'text',
		'id'            => 'thim_archive_single_sub_title',
		'label'         => esc_html__( 'Sub Heading', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can setup sub heading for single.', 'eduma' ),
		'section'       => 'blog_singular',
		'priority'      => 15,
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_single_hide_breadcrumbs',
		'type'          => 'switch',
		'label'         => esc_html__( 'Hidden Breadcrumb', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can hidden breadcrumbs on page title.', 'eduma' ),
		'section'       => 'blog_singular',
		'default'       => false,
		'priority'      => 20,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'image',
		'id'            => 'thim_archive_single_top_image',
		'label'         => esc_html__( 'Top Image', 'eduma' ),
		'priority'      => 20,
		'transport'     => 'postMessage',
		'section'       => 'blog_singular',
		'default'       => THIM_URI . "images/bg-page.jpg",
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);

// Page Title Background Color
thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_single_bg_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'       => esc_html__( 'If you do not use background image, then can use background color for page title on heading top. ', 'eduma' ),
		'section'       => 'blog_singular',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_single_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make text color for title.', 'eduma' ),
		'section'       => 'blog_singular',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_archive_single_sub_title_color',
		'type'          => 'color',
		'label'         => esc_html__( 'Sub Title Color', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you can select a color make sub title color page title.', 'eduma' ),
		'section'       => 'blog_singular',
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
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'switch',
		'id'            => 'thim_archive_single_related_post',
		'label'         => esc_html__( 'Related Posts', 'eduma' ),
		'tooltip'       => esc_html__( 'Turn on to display related posts.', 'eduma' ),
		'default'       => true,
		'priority'      => 100,
		'section'       => 'blog_singular',
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'single-post' )
		)
	)
);
