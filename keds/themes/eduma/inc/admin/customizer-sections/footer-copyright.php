<?php
/**
 * Section Copyright
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'copyright',
		'title'    => esc_html__( 'Copyright', 'eduma' ),
		'panel'    => 'footer',
		'priority' => 50,
	)
);
thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_copyright_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This Footer is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=footer' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) .'</a>' ),
		'section'       => 'copyright',
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Enable or disable top bar
thim_customizer()->add_field(
	array(
		'id'            => 'thim_copyright_show',
		'type'          => 'switch',
		'label'         => esc_html__( 'Show Copyright', 'eduma' ),
		'tooltip'       => esc_html__( 'Allows you to enable or disable Copyright.', 'eduma' ),
		'section'       => 'copyright',
		'default'       => true,
		'priority'      => 10,
		'choices'       => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);
// Copyright Background Color
thim_customizer()->add_field(
	array(
		'id'              => 'thim_copyright_bg_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose background color for your copyright area. ', 'eduma' ),
		'section'         => 'copyright',
		'default'         => '#111',
		'priority'        => 15,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_copyright_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'function' => 'css',
				'element'  => 'footer#colophon .copyright-area',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_copyright_text_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose color for your copyright area. ', 'eduma' ),
		'section'         => 'copyright',
		'default'         => '#999',
		'priority'        => 20,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_copyright_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'function' => 'css',
				'element'  => 'footer#colophon .copyright-area,footer#colophon .copyright-area ul li a',
				'property' => 'color',
			)
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'              => 'thim_copyright_border_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Border Color', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to choose border color for your copyright area. ', 'eduma' ),
		'section'         => 'copyright',
		'default'         => '#222',
		'priority'        => 20,
		'choices'         => array( 'alpha' => true ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_copyright_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'function' => 'css',
				'element'  => 'footer#colophon .copyright-area .copyright-content',
				'property' => 'border-top-color',
			)
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);

// Enter Text For Copyright
thim_customizer()->add_field(
	array(
		'type'            => 'textarea',
		'id'              => 'thim_copyright_text',
		'label'           => esc_html__( 'Copyright Text', 'eduma' ),
		'tooltip'         => esc_html__( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'eduma' ),
		'section'         => 'copyright',
		'default'         => '<a href="' . esc_url( 'https://1.envato.market/G5Ook' ) . '" target="_blank">Education WordPress Theme</a> by <a href="' . esc_url( 'thimpress.com' ) . '" target="_blank">ThimPress.</a> Powered by WordPress.',
		'priority'        => 100,
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'thim_copyright_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => 'footer#colophon .text-copyright',
				'function' => 'html',
			),
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);


thim_customizer()->add_field(
	array(
		'type'            => 'select',
		'id'              => 'thim_copyright_column',
		'label'           => esc_html__( 'Width Column Copyright Text', 'eduma' ),
		'default'         => '6',
		'priority'        => 101,
		'active_callback' => array(
			array(
				'setting'  => 'thim_copyright_show',
				'operator' => '===',
				'value'    => true,
			),
		),
		'section'         => 'copyright',
		'choices'         => array(
			'5' => '20%',
			'4' => '33%',
			'6' => '50%',
			'8' => '75%',
		),
		'wrapper_attrs'   => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'footer' )
		)
	)
);
