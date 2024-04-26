<?php
/**
 * Section Sidebar
 * 
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'sidebar',
		'panel'    => 'general',
		'priority' => 120,
		'title'    => esc_html__( 'Sidebar', 'eduma' ),
	)
);

// Feature: RTL
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'thim_sticky_sidebar',
		'label'    => esc_html__( 'Sticky Sidebar', 'eduma' ),
		'section'  => 'sidebar',
		'default'  => true,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);
thim_customizer()->add_group( array(
    'id'       => 'sidebar_typography',
    'section'  => 'sidebar',
    'priority' => 20,
    'groups'   => array(
        array(
            'id'     => 'thim_sidebar_group',
            'label'  => esc_html__( 'Sidebar', 'eduma' ),
            'fields' => array(
                array(
                    'id'        => 'thim_font_title_sidebar',
                    'label'     => esc_html__( 'Sidebar Font', 'eduma' ),
                    'tooltip'  => esc_html__( 'Allows you to select all font properties of button tag for your site', 'eduma' ),
                    'type'      => 'typography',
                    'priority'    => 10,
                    'default'     => array(
                        'font-size'      => '18px',
                        'line-height'    => '1.4em',
						'text-transform' => 'uppercase',
                    ),
                    'transport' => 'postMessage',
                ),
            ),
        ),
    )
) );