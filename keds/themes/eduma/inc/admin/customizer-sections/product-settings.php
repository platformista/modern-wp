<?php
/**
 * Section Settings
 *
 * @package Eduma
 */

// thim_customizer()->add_section(
// 	array(
// 		'id'       => 'product_setting',
// 		'panel'    => 'woocommerce',
// 		'title'    => esc_html__( 'Settings', 'eduma' ),
// 		'priority' => 10,
// 	)
// );

// thim_customizer()->add_field( 
// 	array(
// 		'type'     => 'select',
// 		'id'       => 'thim_woo_product_column',
// 		'label'    => esc_html__( 'Products per row', 'woocommerce' ),
// 		'tooltip'  => esc_html__( 'How many products should be shown per row?', 'woocommerce' ),
// 		'default'  => '3',
// 		'priority' => 10,
// 		'multiple' => 0,
// 		'section'  => 'woocommerce_product_catalog',
// 		'choices'  => array(
// 			'2' => esc_html__( '2', 'eduma' ),
// 			'3' => esc_html__( '3', 'eduma' ),
// 			'4' => esc_html__( '4', 'eduma' ),
// 		),
// 	)
// );

// Product per page
// thim_customizer()->add_field(
// 	array(
// 		'id'          => 'thim_woo_product_per_page',
// 		'type'        => 'slider',
// 		'label'       => esc_html__( 'Products Per Page', 'eduma' ),
// 		'tooltip'     => esc_html__( 'Choose the number of products per page.', 'eduma' ),
// 		'priority'    => 30,
// 		'default'     => 9,
// 		'section'  => 'woocommerce_product_catalog',
// 		'choices'     => array(
// 			'min'  => '1',
// 			'max'  => '20',
// 			'step' => '1',
// 		),
// 	)
// );

// Enable or disable quick view
thim_customizer()->add_field(
	array(
		'id'       => 'thim_woo_set_show_qv',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Quick View', 'eduma' ),
		'tooltip'  => esc_html__( 'Allows you to enable or disable quick view.', 'eduma' ),
		'section'  => 'woocommerce_product_catalog',
		'default'  => true,
		'priority' => 40,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);