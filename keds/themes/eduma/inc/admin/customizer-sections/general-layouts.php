<?php
/**
 * Section Layout
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
	array(
		'id'       => 'content_layout',
		'panel'    => 'general',
		'title'    => esc_html__( 'Layouts', 'eduma' ),
		'priority' => 20,
	)
);

//---------------------------------------------Site-Content---------------------------------------------//

// Select Theme Content Layout
thim_customizer()->add_field(
	array(
		'id'            => 'thim_box_layout',
		'type'          => 'radio-image',
		'label'         => esc_html__( 'Site Layout', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to choose a layout for your site.', 'eduma' ),
		'section'       => 'content_layout',
		'priority'      => 10,
		'default'       => 'wide',
		'choices'       => array(
			'wide'  => THIM_URI . 'images/layout/content-full.jpg',
			'boxed' => THIM_URI . 'images/layout/content-boxed.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3'
		)
	)
);

//------------------------------------------------Page---------------------------------------------//

// Select All Page Layout
thim_customizer()->add_field(
	array(
		'id'            => 'thim_page_layout',
		'type'          => 'radio-image',
		'label'         => esc_html__( 'Page Layouts', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to choose a layout to display for all pages on your site.', 'eduma' ),
		'section'       => 'content_layout',
		'priority'      => 20,
		'default'       => 'full-content',
		'choices'       => array(
			'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
			'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
			'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-3'
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'thim_padding_content',
		'type'     => 'dimensions',
		'label'    => esc_html__( 'Padding Body', 'eduma' ),
		'section'  => 'content_layout',
		'tooltip'  => esc_html__( 'Change padding top, bottom of box content for site', 'eduma' ),
		'priority' => 25,
		'default'  => [
			'pdtop-desktop'    => '60px',
			'pdbottom-desktop' => '60px',
			'pdtop-mobile'     => '45px',
			'pdbottom-mobile'  => '45px',
		],
		'choices'  => [
			'labels' => [
				'pdtop-desktop'    => esc_html__( 'Top (Desktop)', 'eduma' ),
				'pdbottom-desktop' => esc_html__( 'Bottom (Desktop)', 'eduma' ),
				'pdtop-mobile'     => esc_html__( 'Top (Mobile)', 'eduma' ),
				'pdbottom-mobile'  => esc_html__( 'Bottom (Mobile)', 'eduma' ),
			],
		],
		'js_vars'  => array(
			array(
				'function' => 'css',
				'choice'   => 'pdtop-desktop',
				'element'  => '.site-content',
				'property' => 'padding-top',
			),
			array(
				'function' => 'css',
				'choice'   => 'pdbottom-desktop',
				'element'  => '.site-content',
				'property' => 'padding-bottom',
			),

		)
	)
);
// Select All Page Layout
thim_customizer()->add_field(
	array(
		'type'     => 'select',
		'id'       => 'thim_size_body',
		'label'    => esc_html__( 'Size Body', 'eduma' ),
		'default'  => 'normal',
		'section'  => 'content_layout',
		'priority' => 70,
		'choices'  => array(
			'normal' => esc_html__( 'Normal', 'eduma' ),
			'wide'   => esc_html__( 'Wide', 'eduma' ),
		),
	)
);

thim_customizer()->add_field(
	array(
		'type'          => 'radio-image',
		'id'            => 'thim_switch_layout_style',
		'label'         => esc_html__( 'Switch Layout Style', 'eduma' ),
		'default'       => 'normal',
		'section'       => 'content_layout',
		'tooltip'       => esc_html__( 'Layout Switch List and Grid for product, course', 'eduma' ),
		'priority'      => 70,
		'choices'       => array(
			'normal'  => THIM_URI . 'images/customizer/switch-1.svg',
			'style_1' => THIM_URI . 'images/customizer/switch-2.svg',
			'style_2' => THIM_URI . 'images/customizer/switch-3.svg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-2'
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_bg_switch_layout_style',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Switch Layout', 'eduma' ),
		'section'         => 'content_layout',
		'priority'        => 70,
		'choices'         => array( 'alpha' => true ),
		'default'         => '#f5f5f5',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_switch_layout_style',
				'operator' => '===',
				'value'    => 'normal',
			)
		),
	)
);
thim_customizer()->add_field(
	array(
		'type'            => 'text',
		'id'              => 'thim_padding_switch_layout_style',
		'label'           => esc_html__( 'Padding Switch Layout', 'eduma' ),
		'section'         => 'content_layout',
		'tooltip'         => esc_html__( 'input padding block switch layout Ex: 10px', 'eduma' ),
		'priority'        => 70,
		'default'         => '10px',
		'active_callback' => array(
			array(
				'setting'  => 'thim_switch_layout_style',
				'operator' => '===',
				'value'    => 'normal',
			)
		),
	)
);

thim_customizer()->add_section(
	array(
		'id'       => 'top_heading_options',
		'panel'    => 'general',
		'title'    => esc_html__( 'Page Title Layout', 'eduma' ),
		'priority' => 20,
	)
);

// Select All Page Layout
thim_customizer()->add_field(
	array(
		'type'          => 'radio-image',
		'id'            => 'thim_top_heading',
		'label'         => esc_html__( 'Layout', 'eduma' ),
		'default'       => '',
		'section'       => 'top_heading_options',
		'priority'      => 75,
		'choices'       => array(
			'normal'  => THIM_URI . 'images/customizer/page-title-1.svg',
			'style_2' => THIM_URI . 'images/customizer/page-title-2.jpg',
			'style_3' => THIM_URI . 'images/customizer/page-title-3.svg',
		),
		'wrapper_attrs' => array(
			'class' => '{default_class} thim-col-2'
		)
	)
);
thim_customizer()->add_field(
	array(
		'type'            => 'select',
		'id'              => 'thim_top_heading_title_align',
		'label'           => esc_html__( 'Text Align Title', 'eduma' ),
		'default'         => 'left',
		'section'         => 'top_heading_options',
		'priority'        => 75,
		'choices'         => array(
			'left'   => esc_html__( 'Left', 'eduma' ),
			'center' => esc_html__( 'Center', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '===',
				'value'    => 'normal',
			)
		),
		'js_vars'         => array(
			array(
				'function' => 'css',
				'element'  => '.top_site_main .page-title-wrapper',
				'property' => 'text-align',
			)
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_top_heading_line_title',
		'type'            => 'switch',
		'label'           => esc_html__( 'Line Title', 'eduma' ),
		'section'         => 'top_heading_options',
		'default'         => true,
		'priority'        => 75,
		'choices'         => array(
			true  => esc_html__( 'Yes', 'eduma' ),
			false => esc_html__( 'No', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '===',
				'value'    => 'normal',
			)
		),
	)
);


thim_customizer()->add_field(
	array(
		'id'              => 'thim_image_offset_bottom',
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Vertical Orientation (px)', 'eduma' ),
		'default'         => - 270,
		'section'         => 'top_heading_options',
		'choices'         => array(
			'min'  => '-500',
			'max'  => '0',
			'step' => '1',
		),
		'priority'        => 80,
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '===',
				'value'    => 'style_3',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_top_bg_gradient',
		'type'            => 'switch',
		'label'           => esc_html__( 'Background gradient', 'eduma' ),
		'section'         => 'top_heading_options',
		'default'         => true,
		'priority'        => 80,
		'choices'         => array(
			true  => esc_html__( 'Yes', 'eduma' ),
			false => esc_html__( 'No', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '===',
				'value'    => 'style_3',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'thim_top_heading_padding',
		'type'     => 'dimensions',
		'label'    => esc_html__( 'Padding Title','eduma' ),
		'section'  => 'top_heading_options',
		'priority' => 80,
		'default'  => [
			'top'           => '90px',
			'bottom'        => '90px',
			'top-mobile'    => '50px',
			'bottom-mobile' => '50px',
		],
		'choices'  => [
			'labels' => [
				'top'           => esc_html__( 'Top Desktop', 'eduma' ),
				'bottom'        => esc_html__( 'Bottom Desktop', 'eduma' ),
				'top-mobile'    => esc_html__( 'Top Mobile', 'eduma' ),
				'bottom-mobile' => esc_html__( 'Bottom Mobile', 'eduma' ),
			],
		],
	)
);

thim_customizer()->add_field(
	array(
		'id'          => 'thim_top_heading_title_font',
		'type'        => 'dimensions',
		'label'       => esc_html__( 'Title Font Size', 'eduma' ),
		'section'     => 'top_heading_options',
		'description' => esc_html__(
			'Text Transform you can use "none, uppercase, capitalize, lowercase ..." ---
									Font Weight you can use "normal, bold, 600 ..."', 'eduma'
		),
		'priority'    => 80,
		'default'     => [
			'size-desktop'   => '48px',
			'size-mobile'    => '35px',
			'text-transform' => 'uppercase',
			'weight'         => 'bold',
		],
		'choices'     => [
			'labels' => [
				'size-desktop'   => esc_html__( 'Desktop', 'eduma' ),
				'size-mobile'    => esc_html__( 'Mobile', 'eduma' ),
				'text-transform' => esc_html__( 'Text Transform', 'eduma' ),
				'weight'         => esc_html__( 'Font Weight', 'eduma' ),
			],
		],
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_breadcrumb_position',
		'type'            => 'select',
		'label'           => esc_html__( 'Breadcrumb Position', 'eduma' ),
		'section'         => 'top_heading_options',
		'default'         => 'default',
		'priority'        => 80,
		'choices'         => array(
			'default'     => esc_html__( 'Default', 'eduma' ),
			'above-title' => esc_html__( 'Above Title', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '===',
				'value'    => 'normal',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'          => 'thim_breacrumb_font_size',
		'type'        => 'dimension',
		'label'       => esc_html__( 'Breadcrumb Font Size', 'eduma' ),
		'section'     => 'top_heading_options',
		'description' => esc_html__( 'input font size breacrumb ex: 13px, 100%, 1em, 1rem', 'eduma' ),
		'priority'    => 80,
		'default'     => '1em',
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_breacrumb_bg_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Breadcrumb Background Color', 'eduma' ),
		'section'         => 'top_heading_options',
		'priority'        => 80,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '==',
				'value'    => 'normal',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_breacrumb_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Breadcrumb Color', 'eduma' ),
		'section'         => 'top_heading_options',
		'priority'        => 80,
		'choices'         => array( 'alpha' => true ),
		'default'         => '#666',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '!=',
				'value'    => 'style_3',
			)
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_breacrumb_border_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Breadcrumb Border Color', 'eduma' ),
		'section'         => 'top_heading_options',
		'priority'        => 80,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_top_heading',
				'operator' => '!=',
				'value'    => 'style_3',
			)
		),
	)
);
