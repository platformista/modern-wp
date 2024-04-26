<?php
/**
 * Section Custom CSS
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'box_custom_css',
		'panel'    => 'general',
		'title'    => esc_html__( 'Custom CSS & JS', 'eduma' ),
		'priority' => 110,
	)
);

thim_customizer()->add_field( array(
	'type'        => 'code',
	'id'          => 'thim_custom_css',
	'label'       => esc_html__( 'Custom CSS', 'eduma' ),
	'description' => esc_html__( 'Just want to do some quick CSS changes? Enter theme here, they will be applied to the theme.', 'eduma' ),
	'section'     => 'box_custom_css',
	'default'     => '.test-class{ color: red; }',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'scss',
		'theme'    => 'monokai',
		'height'   => 250,
	),
	'transport'   => 'postMessage',
	'js_vars'     => array()
) );

thim_customizer()->add_field( array(
	'type'        => 'code',
	'id'          => 'thim_custom_js',
	'label'       => esc_html__( 'Custom JS', 'eduma' ),
	'description' => esc_html__( 'Just want to do some quick JS changes? Enter theme here, they will be applied to the theme.', 'eduma' ),
	'section'     => 'box_custom_css',
	'default'     => '',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'javascript',
		'theme'    => 'monokai',
		'height'   => 250,
	),
	'transport'   => 'postMessage',
	'js_vars'     => array()
) );
