<?php
/**
 * Section Settings
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'event_setting',
		'panel'    => 'event',
		'title'    => esc_html__( 'Settings', 'eduma' ),
		'priority' => 20,
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'thim_tab_event_style',
		'type'     => 'select',
		'label'    => esc_html__( 'Tab Style', 'eduma' ),
		'priority' => 10,
		'default'  => '',
		'multiple' => 0,
		'section'  => 'event_setting',
		'choices'  => array(
			'' 			=> esc_html__( 'Default', 'eduma' ),
			'style_1' => esc_html__( 'Style 1', 'eduma' ),
		),
	)
);
 

// Enable or disable quick view
thim_customizer()->add_field(
	array(
		'id'       => 'thim_event_display_year',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Year', 'eduma' ),
		'tooltip'  => esc_html__( 'Show year on date of all place display events.', 'eduma' ),
		'section'  => 'event_setting',
		'default'  => false,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);

// Enable or disable quick view
thim_customizer()->add_field(
	array(
		'id'       => 'thim_event_disable_book_event',
		'type'     => 'switch',
		'label'    => esc_html__( 'Disable booking tickets', 'eduma' ),
		'tooltip'  => esc_html__( 'Disable booking tickets on single event.', 'eduma' ),
		'section'  => 'event_setting',
		'default'  => false,
		'priority' => 15,
		'choices'  => array(
			true  => esc_html__( 'On', 'eduma' ),
			false => esc_html__( 'Off', 'eduma' ),
		),
	)
);