<?php
thim_customizer()->add_panel(
	array(
		'id'       => 'dark_mode',
		'priority' => 60,
		'title'    => esc_html__( 'Dark Mode', 'eduma' ),
		'icon'     => 'dashicons-index-card',
	)
);
// Add Section Footer Options
thim_customizer()->add_section(
	array(
		'id'       => 'dark_mode_options',
		'title'    => esc_html__( 'Settings', 'eduma' ),
		'panel'    => 'dark_mode',
		'priority' => 10,
	)
);
// Footer Text Color
thim_customizer()->add_field(
	array(
		'type'      => 'multicolor',
		'id'        => 'thim_dark_mode_color',
		'label'     => esc_html__( 'Colors', 'eduma' ),
		'section'   => 'dark_mode_options',
		'priority'  => 50,
		'choices'   => array(
			'bg_body'=>esc_html__( 'Body Background Color', 'eduma' ),
			'text_body'=>esc_html__( 'Body Text Color', 'eduma' ),
			'text_heading'=>esc_html__( 'Text Heading Color', 'eduma' ),
			'primary' => esc_html__( 'Primary Color', 'eduma' ),
			'secondary'  => esc_html__( 'Secondary Color', 'eduma' ),
			'bg_button_hover'  => esc_html__( 'Button Hover Background Color', 'eduma' ),
			'text_button' => esc_html__( 'Button Text Color', 'eduma' ),
			'border'  => esc_html__( 'Border Color', 'eduma' ),
		),
		'default'   => array(
			'bg_body'=> '#000',
			'text_body'=> '#fff',
			'text_heading'=> '#fff',
			'primary' => '#ffb606',
			'secondary'  => '#4caf50',
			'bg_button_hover'  => '#ffffff',
			'text_button' => '#fff',
			'border'=>'#333',
		),
		'transport' => 'postMessage',
 	)
);
