<?php
/**
 * Section Footer Settings
 *
 */

// Add Section Footer Options
thim_customizer()->add_section(
	array(
		'id'       => 'footer_options',
		'title'    => esc_html__( 'Settings', 'eduma' ),
		'panel'    => 'footer',
		'priority' => 10,
	)
);

thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_footer_options_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This Footer is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=footer' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) .'</a>' ),
		'section'       => 'footer_options',
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Feature: Body custom class
thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_footer_custom_class',
		'label'    => esc_html__( 'Footer Custom Class', 'eduma' ),
		'tooltip'  => esc_html__( 'Enter footer custom class.', 'eduma' ),
		'section'  => 'footer_options',
		'priority' => 10,
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Footer Background Color
thim_customizer()->add_field(
	array(
		'type'      => 'color',
		'id'        => 'thim_footer_bg_color',
		'label'     => esc_html__( 'Background Color', 'eduma' ),
		'section'   => 'footer_options',
		'default'   => '#111111',
		'priority'  => 40,
		'choices'   => array( 'alpha' => true ),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => 'footer#colophon .footer',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Footer Text Color
thim_customizer()->add_field(
	array(
		'type'      => 'multicolor',
		'id'        => 'thim_footer_color',
		'label'     => esc_html__( 'Colors', 'eduma' ),
		'section'   => 'footer_options',
		'priority'  => 50,
		'choices'   => array(
			'title' => esc_html__( 'Title', 'eduma' ),
			'text'  => esc_html__( 'Text', 'eduma' ),
			'link'  => esc_html__( 'Link', 'eduma' ),
			'hover' => esc_html__( 'Hover', 'eduma' ),
		),
		'default'   => array(
			'title' => '#ffffff',
			'text'  => '#ffffff',
			'link'  => '#ffffff',
			'hover' => '#ffb606',
		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'title',
				'function' => 'css',
				'element'  => 'footer#colophon .footer .widget-title',
				'property' => 'color',
			),
			array(
				'choice'   => 'text',
				'function' => 'css',
				'element'  => '
								footer#colophon .footer .thim-footer-location .social a,
								footer#colophon .footer,
								footer#colophon .footer .thim-footer-location .info .fa,
								footer#colophon .footer a,
								.thim-social li a
								',
				'property' => 'color',
			),
			array(
				'choice'   => 'link',
				'function' => 'css',
				'element'  => 'footer#colophon .footer .thim-footer-location .info a',
				'property' => 'color',
			),
			array(
				'choice'   => 'hover',
				'function' => 'style',
				'element'  => 'footer#colophon .footer a:hover',
				'property' => 'color',
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Footer Font title
thim_customizer()->add_field(
	array(
		'id'        => 'thim_footer_font_title',
		'label'     => esc_html__( 'Font Title', 'eduma' ),
		'type'      => 'typography',
		'priority'  => 50,
		'section'   => 'footer_options',
		'default'   => array(
			'variant'        => get_theme_mod( 'thim_footer_font_title_font_weight', 700 ),
			'font-size'      => '14px',
			'line-height'    => '40px',
			'text-transform' => 'uppercase',
		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'font-size',
				'element'  => '#main-content footer#colophon .footer .widget-title',
				'property' => 'font-size',
			),
			array(
				'choice'   => 'line-height',
				'element'  => '#main-content footer#colophon .footer .widget-title',
				'property' => 'line-height',
			),
			array(
				'choice'   => 'text-transform',
				'element'  => '#main-content footer#colophon .footer .widget-title',
				'property' => 'text-transform',
			),

		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

//thim_customizer()->add_field(
//	array(
//		'type'      => 'select',
//		'id'        => 'thim_footer_font_title_font_weight',
//		'section'   => 'footer_options',
//		'label'     => esc_html__( 'Title Font Weight', 'eduma' ),
//		'default'   => '700',
//		'priority'  => 51,
//		'choices'   => array(
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
//		'transport' => 'postMessage',
//		'js_vars'   => array(
//			array(
//				'element'  => '#main-content footer#colophon .footer .widget-title',
//				'function' => 'css',
//				'property' => 'font-weight',
//			),
//		),
//		'wrapper_attrs' => array(
//			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
//		)
//	)
//);


thim_customizer()->add_field(
	array(
		'type'     => 'text',
		'id'       => 'thim_footer_font_size',
		'label'    => esc_html__( 'Footer Font Size Text', 'eduma' ),
 		'section'  => 'footer_options',
		'tooltip'  => esc_html__( 'Enter font-size text footer ex: 14px', 'eduma' ),
		'priority' => 52,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => 'footer#colophon',
				'function' => 'css',
				'property' => 'font-size',
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Body Background Group
thim_customizer()->add_group(
	array(
		'id'       => 'footer_background_group',
		'section'  => 'footer_options',
		'priority' => 150,
		'groups'   => array(
			array(
				'id'     => 'thim_footer_background_group',
				'label'  => esc_html__( 'Footer Background Image', 'eduma' ),
				'fields' => array(

					array(
						'type'      => 'image',
						'id'        => 'thim_footer_background_img',
						'label'     => esc_html__( 'Background image', 'eduma' ),
						'priority'  => 30,
						'transport' => 'postMessage',
						'js_vars'   => array(
							array(
								'element'  => 'footer#colophon',
								'function' => 'css',
								'property' => 'background-image',
							),
						),
						'wrapper_attrs' => array(
							'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
						)
					),
					array(
						'type'      => 'select',
						'id'        => 'thim_footer_bg_repeat',
						'label'     => esc_html__( 'Background Repeat', 'eduma' ),
						'default'   => 'no-repeat',
						'priority'  => 40,
						'choices'   => array(
							'repeat'    => esc_html__( 'Repeat', 'eduma' ),
							'repeat-x'  => esc_html__( 'Repeat X', 'eduma' ),
							'repeat-y'  => esc_html__( 'Repeat Y', 'eduma' ),
							'no-repeat' => esc_html__( 'No Repeat', 'eduma' ),
						),
						'transport' => 'postMessage',
						'js_vars'   => array(
							array(
								'element'  => 'footer#colophon',
								'function' => 'css',
								'property' => 'background-repeat',
							),
						),
						'active_callback' => array(
							array(
							   'setting'  => 'thim_footer_background_img',
							   'operator' => '!=',
							   'value'    => '',
						   ),
					   ),
						'wrapper_attrs' => array(
							'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
						)
					),

					array(
						'type'      => 'select',
						'id'        => 'thim_footer_bg_position',
						'label'     => esc_html__( 'Background Position', 'eduma' ),
						'default'   => 'center',
						'priority'  => 50,
						'choices'   => array(
							'left'   => esc_html__( 'Left', 'eduma' ),
							'center' => esc_html__( 'Center', 'eduma' ),
							'right'  => esc_html__( 'Right', 'eduma' ),
							'top'    => esc_html__( 'Top', 'eduma' ),
							'bottom' => esc_html__( 'Bottom', 'eduma' ),
						),
						'transport' => 'postMessage',
						'js_vars'   => array(
							array(
								'element'  => 'footer#colophon',
								'function' => 'css',
								'property' => 'background-position',
							),
						),
						'active_callback' => array(
 							array(
								'setting'  => 'thim_footer_background_img',
								'operator' => '!=',
								'value'    => '',
							),
						),
						'wrapper_attrs' => array(
							'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
						)
					),

					array(
						'type'      => 'select',
						'id'        => 'thim_footer_bg_attachment',
						'label'     => esc_html__( 'Background Attachment', 'eduma' ),
						'default'   => 'inherit',
						'priority'  => 60,
						'choices'   => array(
							'scroll'  => esc_html__( 'Scroll', 'eduma' ),
							'fixed'   => esc_html__( 'Fixed', 'eduma' ),
							'inherit' => esc_html__( 'Inherit', 'eduma' ),
							'initial' => esc_html__( 'Initial', 'eduma' ),
						),
						'transport' => 'postMessage',
						'js_vars'   => array(
							array(
								'element'  => 'footer#colophon',
								'function' => 'css',
								'property' => 'background-attachment',
							),
						),
						'active_callback' => array(
							array(
							   'setting'  => 'thim_footer_background_img',
							   'operator' => '!=',
							   'value'    => '',
						   ),
					   ),
						'wrapper_attrs' => array(
							'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
						)
					),

					array(
						'type'      => 'select',
						'id'        => 'thim_footer_bg_size',
						'label'     => esc_html__( 'Background Size', 'eduma' ),
						'default'   => 'inherit',
						'priority'  => 60,
						'choices'   => array(
							'contain' => esc_html__( 'Contain', 'eduma' ),
							'cover'   => esc_html__( 'Cover', 'eduma' ),
							'initial' => esc_html__( 'Initial', 'eduma' ),
							'inherit' => esc_html__( 'Inherit', 'eduma' ),
						),
						'transport' => 'postMessage',
						'js_vars'   => array(
							array(
								'element'  => 'footer#colophon',
								'function' => 'css',
								'property' => 'background-size',
							),
						),
						'active_callback' => array(
 							array(
								'setting'  => 'thim_footer_background_img',
								'operator' => '!=',
								'value'    => '',
							),
						),
						'wrapper_attrs' => array(
							'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
						)
					),
				),
			),
		)
	)
);
