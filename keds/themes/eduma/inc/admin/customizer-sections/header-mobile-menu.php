<?php
/**
 * Section Header Mobile Menu
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_mobile_menu',
		'title'    => esc_html__( 'Mobile Menu', 'eduma' ),
		'panel'    => 'header',
		'priority' => 50,
	)
);
thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_header_mobile_menu_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This header is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=header' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'header_mobile_menu',
		'priority'      => 11,
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'header' )
		)
	)
);
// Topbar background color
thim_customizer()->add_field(
	array(
		'id'        => 'thim_bg_mobile_menu_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a background color for mobile menu.', 'eduma' ),
		'section'   => 'header_mobile_menu',
		'default'   => '#232323',
		'priority'  => 20,
		'choices' => array ('alpha'     => true),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'css',
				'element'  => '.mobile-menu-container',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'thim_mobile_menu_text_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Text Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a text color.', 'eduma' ),
		'section'   => 'header_mobile_menu',
		'default'   => '#777',
		'priority'  => 25,
//		'choices' => array ('alpha'     => true),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'css',
				'element'  => '
								.mobile-menu-container ul li > a,
								.mobile-menu-container ul li > span
								',
				'property' => 'color',
			),
			array(
				'function' => 'css',
				'element'  => '
								.menu-mobile-effect span,
								.mobile-menu-container .navbar-nav .sub-menu:before,
								.mobile-menu-container .navbar-nav .sub-menu li:before
								',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'thim_mobile_menu_text_hover_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Text Hover Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a text hover color.', 'eduma' ),
		'section'   => 'header_mobile_menu',
		'default'   => '#fff',
		'priority'  => 25,
		'choices' => array ('alpha'     => true),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => '
								.mobile-menu-container ul li > a:hover,
								.mobile-menu-container ul li > span:hover,
								.mobile-menu-container ul li.current-menu-item > a,
								.mobile-menu-container ul li.current-menu-item > span
								',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

// Select Style
thim_customizer()->add_field(
	array(
		'id'       => 'thim_config_logo_mobile',
		'type'     => 'select',
		'label'    => esc_html__( 'Config Logo', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows you can config logo mobile menu.', 'eduma' ),
		'section'  => 'header_mobile_menu',
		'default'  => 'same',
		'priority' => 40,
		'multiple' => 0,
		'choices'  => array(
			'default_logo' => esc_html__( 'Default', 'eduma' ),
			'custom_logo'  => esc_html__( 'Custom', 'eduma' )
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

// Header Logo
thim_customizer()->add_field(
	array(
		'id'              => 'thim_logo_mobile',
		'type'            => 'image',
		'section'         => 'header_mobile_menu',
		'label'           => esc_html__( 'Mobile Logo', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to add, remove, change mobile logo on your site.', 'eduma' ),
		'priority'        => 45,
		'default'         => THIM_URI . "images/logo.png",
		'active_callback' => array(
			array(
				'setting'  => 'thim_config_logo_mobile',
				'operator' => '===',
				'value'    => 'custom_logo',
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

// Header Sticky Logo
thim_customizer()->add_field(
	array(
		'id'              => 'thim_sticky_logo_mobile',
		'type'            => 'image',
		'section'         => 'header_mobile_menu',
		'label'           => esc_html__( 'Mobile Sticky Logo', 'eduma' ),
		'tooltip'         => esc_html__( 'Allows you to add, remove, change mobile sticky logo on your site.', 'eduma' ),
		'priority'        => 50,
		'default'         => THIM_URI . "images/sticky-logo.png",
		'active_callback' => array(
			array(
				'setting'  => 'thim_config_logo_mobile',
				'operator' => '===',
				'value'    => 'custom_logo',
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

// Enable or disable top bar
//thim_customizer()->add_field(
//	array(
//		'id'       => 'thim_display_login_menu_mobile',
//		'type'     => 'switch',
//		'label'    => esc_html__( 'Enable Login/Logout.', 'eduma' ),
//		'tooltip'  => esc_html__( 'Allows you to enable or disable login/logout link on mobile menu.', 'eduma' ),
//		'section'  => 'header_mobile_menu',
//		'default'  => true,
//		'priority' => 55,
//		'choices'  => array(
//			true  => esc_html__( 'On', 'eduma' ),
//			false => esc_html__( 'Off', 'eduma' ),
//		),
//	)
//);
