<?php
/**
 * Section Header Toolbar
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_toolbar',
		'title'    => esc_html__( 'Toolbar', 'eduma' ),
		'panel'    => 'header',
		'priority' => 25,
	)
);
thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_header_toolbar_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This header is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=header' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'header_toolbar',
		'priority'      => 11,
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'header' )
		)
	)
);
// Enable or disable top bar
thim_customizer()->add_field(
	array(
		'id'            => 'thim_toolbar_show',
		'type'          => 'switch',
		'label'         => esc_html__( 'Show Toolbar', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to enable or disable Toolbar.', 'eduma' ),
		'section'       => 'header_toolbar',
		'default'       => true,
		'priority'      => 10,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_toolbar',
		'type'            => 'typography',
		'label'           => esc_html__( 'Font size', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to select font size for toolbar. ', 'eduma' ),
		'section'         => 'header_toolbar',
		'priority'        => 20,
		'default'         => array(
			'variant'        => get_theme_mod( 'thim_toolbar_font_weight', 600 ),
			'font-size'      => '12px',
			'line-height'    => '30px',
			'text-transform' => 'none',
		),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'line-height',
				'element'  => '#toolbar',
				'property' => 'line-height',
			),
			array(
				'choice'   => 'text-transform',
				'element'  => '#toolbar',
				'property' => 'text-transform',
			),
			array(
				'choice'   => 'font-size',
				'element'  => '#toolbar',
				'property' => 'font-size',
			),
			array(
				'choice'   => 'variant',
				'element'  => '#toolbar',
				'property' => 'font-weight',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

//thim_customizer()->add_field(
//	array(
//		'type'            => 'select',
//		'id'              => 'thim_toolbar_font_weight',
//		'section'         => 'header_toolbar',
//		'label'           => esc_html__( 'Fonts Weight', 'eduma' ),
//		'default'         => '600',
//		'priority'        => 20,
//		'choices'         => array(
//			'100' => '100',
//			'200' => '200',
//			'300' => '300',
//			'400' => '400',
//			'500' => '500',
//			'600' => '600',
//			'700' => '700',
//			'800' => '800',
//			'900' => '900',
//		),
//		'transport'       => 'postMessage',
//		'js_vars'         => array(
//			array(
//				'element'  => '#toolbar',
//				'function' => 'css',
//				'property' => 'font-weight',
//			),
//		),
//		'active_callback' => array(
//			array(
//				'setting'  => 'thim_toolbar_show',
//				'operator' => '===',
//				'value'    => true,
//			),
//		),
//		'wrapper_attrs'   => array(
//			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
//		)
//	)
//);

// Topbar background color
thim_customizer()->add_field(
	array(
		'id'              => 'thim_bg_color_toolbar',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose a background color for widget on toolbar. ', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => '#111',
		'priority'        => 20,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '
							#toolbar,
							.site-header.header_v2,
							.site-header.bg-custom-sticky.affix.header_v2
							',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_text_color_toolbar',
		'type'            => 'color',
		'label'           => esc_html__( 'Text Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose a color for widget on toolbar. ', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => '#ababab',
		'priority'        => 25,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '#toolbar',
				'property' => 'color',
			),
			array(
				'element'  => '#toolbar .widget_form-login .thim-link-login a:first-child:not(:last-child)',
				'property' => 'border-right-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_link_color_toolbar',
		'type'            => 'color',
		'label'           => esc_html__( 'Link Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose a link color for widget on toolbar. ', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => '#fff',
		'priority'        => 25,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '#toolbar a, #toolbar span.value',
				'property' => 'color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_link_hover_color_toolbar',
		'type'            => 'color',
		'label'           => esc_html__( 'Link Hover Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose a link hover color for widget on toolbar. ', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => '#fff',
		'priority'        => 30,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => '#toolbar a:hover, #toolbar .widget_nav_menu .menu > li > a:hover',
				'property' => 'color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_toolbar_show_border',
		'type'            => 'switch',
		'label'           => esc_html__( 'Enable border button', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => false,
		'priority'        => 35,
		'choices'         => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_toolbar_border_type',
		'type'            => 'select',
		'label'           => esc_html__( 'Select border type', 'eduma' ),
		'section'         => 'header_toolbar',
		'priority'        => 40,
		'default'         => 'dashed',
		'choices'         => array(
			'dotted '  => esc_html__( 'Dotted ', 'eduma' ),
			'dashed '  => esc_html__( 'Dashed ', 'eduma' ),
			'solid '   => esc_html__( 'Solid ', 'eduma' ),
			'double  ' => esc_html__( 'Double  ', 'eduma' ),
		),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show_border',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);
thim_customizer()->add_field(
	array(
		'id'              => 'thim_toolbar_border_size',
		'type'            => 'dimension',
		'label'           => esc_html__( 'Border size', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to enter border size. Example: 1px', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => '1px',
		'priority'        => 40,
		'choices'         => array(
			'min'  => 1,
			'max'  => 5,
			'step' => 1,
		),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show_border',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);
thim_customizer()->add_field(
	array(
		'id'              => 'thim_link_color_toolbar_border_button',
		'type'            => 'color',
		'label'           => esc_html__( 'Border Color', 'eduma' ),
		'section'         => 'header_toolbar',
		'default'         => '#ddd',
		'priority'        => 40,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_toolbar_show_border',
				'operator' => '===',
				'value'    => true,
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);
