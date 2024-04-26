<?php
/**
 * Section Header Main Menu
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_main_menu',
		'title'    => esc_html__( 'Main Menu', 'eduma' ),
		'panel'    => 'header',
		'priority' => 30
	)
);
thim_customizer()->add_field(
	array(
		'id'            => 'thim_desc_header_main_menu_tpl',
		'type'          => 'tp_notice',
		'description'   => sprintf( __( 'This header is built by Thim Elementor Kit, you can edit and configure it in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=header' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'section'       => 'header_main_menu',
		'wrapper_attrs' => array(
			'class' => '{default_class} hide' . thim_customizer_extral_class( 'header' )
		)
	)
);
// Select All Fonts For Main Menu
thim_customizer()->add_field(
	array(
		'id'        => 'thim_main_menu',
		'type'      => 'typography',
		'label'     => esc_html__( 'Fonts Size', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to select all font font properties for header. ', 'eduma' ),
		'section'   => 'header_main_menu',
		'priority'  => 10,
		'default' => array(
			'variant'        => get_theme_mod( 'thim_main_menu_font_weight', 600 ),
			'font-size'      => '14px',
			'line-height'    => '1.3em',
			'text-transform' => 'uppercase',

		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'choice'   => 'text-transform',
				'element'  => '.navigation .width-navigation .navbar-nav > li > a, .navigation .width-navigation .navbar-nav > li > span',
				'property' => 'text-transform',
			),
			array(
				'choice'   => 'line-height',
				'element'  => '.navigation .width-navigation .navbar-nav > li > a, .navigation .width-navigation .navbar-nav > li > span',
				'property' => 'line-height',
			),
			array(
				'choice'   => 'font-size',
				'element'  => '.navigation .width-navigation .navbar-nav > li > a, .navigation .width-navigation .navbar-nav > li > span',
				'property' => 'font-size',
			),
			array(
				'choice'   => 'variant',
				'element'  => '.navigation .width-navigation .navbar-nav > li > a, .navigation .width-navigation .navbar-nav > li > span',
				'property' => 'font-weight',
			),
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

//thim_customizer()->add_field(
//	array(
//		'type'      => 'select',
//		'id'        => 'thim_main_menu_font_weight',
//		'section'   => 'header_main_menu',
//		'label'     => esc_html__( 'Fonts Weight', 'eduma' ),
//		'default'   => '600',
//		'priority'  => 11,
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
//				'element'  => '.navigation .width-navigation .navbar-nav > li > a, .navigation .width-navigation .navbar-nav > li > span',
//				'function' => 'css',
//				'property' => 'font-weight',
//			),
//		),
//		'wrapper_attrs' => array(
//			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
//		)
//	)
//);

// Background Header
thim_customizer()->add_field(
	array(
		'id'        => 'thim_bg_main_menu_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Background Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you can choose background color for your header. ', 'eduma' ),
		'section'   => 'header_main_menu',
		'default'   => 'rgba(255,255,255,0)',
		'priority'  => 20,
		'choices'   => array( 'alpha' => true ),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'css',
				'element'  => '.site-header, .site-header.header_v2 .width-navigation',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

// Text color
thim_customizer()->add_field(
	array(
		'id'        => 'thim_main_menu_text_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Text Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to select color for text.', 'eduma' ),
		'section'   => 'header_main_menu',
		'default'   => '#ffffff',
		'priority'  => 25,
		'choices'   => array( 'alpha' => true ),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '
                            .navigation .width-navigation .navbar-nav > li > a,
                            .navigation .width-navigation .navbar-nav > li > span,
                            .thim-course-search-overlay .search-toggle,
                            .widget_shopping_cart .minicart_hover .cart-items-number,
                            .menu-right .search-form:after
                            ',
				'property' => 'color',
			),
			array(
				'element'  => '.menu-mobile-effect.navbar-toggle span.icon-bar',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);

// Text Link Hover
thim_customizer()->add_field(
	array(
		'id'        => 'thim_main_menu_text_hover_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Text Color Hover', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to select color for text link when hover text link.', 'eduma' ),
		'section'   => 'header_main_menu',
		'default'   => '#ffffff',
		'priority'  => 30,
		'choices'   => array( 'alpha' => true ),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => '
								.navigation .width-navigation .navbar-nav > li > a:hover,
								.navigation .width-navigation .navbar-nav > li > span:hover
								',
				'property' => 'color',
			),
			array(
				'element'  => 'body.page-template-landing-page .navigation .navbar-nav #magic-line',
				'property' => 'background-color',
			)
		),
		'wrapper_attrs' => array(
			'class' => '{default_class}' . thim_customizer_extral_class( 'header' )
		)
	)
);


