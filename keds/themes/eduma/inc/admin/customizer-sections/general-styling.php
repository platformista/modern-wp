<?php
/**
 * Section Styling
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
	array(
		'id'       => 'general_styling',
		'panel'    => 'general',
		'title'    => esc_html__( 'Styling (Global Color)', 'eduma' ),
		'priority' => 30,
	)
);

// Select Theme Primary Colors
thim_customizer()->add_field(
	array(
		'id'        => 'thim_body_primary_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Primary Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a primary color for your site.', 'eduma' ),
		'section'   => 'general_styling',
		'priority'  => 10,
		'default'   => '#ffb606',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => ':root',
				'property' => '--thim-body-primary-color',
			),
		),
		'choices'   => array( 'alpha' => true ),
	)
);

// Select Theme Secondary Colors
thim_customizer()->add_field(
	array(
		'id'        => 'thim_body_secondary_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Secondary Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a secondary color for your site.', 'eduma' ),
		'section'   => 'general_styling',
		'priority'  => 10,
		'choices'   => array( 'alpha' => true ),
		'default'   => '#4caf50',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => ':root',
				'property' => '--thim-body-secondary-color',
			),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'thim_button_hover_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Button Hover Background Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a button hover background color for your site.', 'eduma' ),
		'section'   => 'general_styling',
		'priority'  => 10,
		'choices'   => array( 'alpha' => true ),
		'default'   => '#e6a303',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => ':root',
				'property' => '--thim-button-hover-color',
			),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'thim_button_text_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Button Text Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose a button text color for your site.', 'eduma' ),
		'section'   => 'general_styling',
		'priority'  => 10,
		'choices'   => array( 'alpha' => true ),
		'default'   => '#333',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => ':root',
				'property' => '--thim-button-text-color',
			),
		),
	)
);


thim_customizer()->add_field(
	array(
		'id'        => 'thim_body_bg_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Body Background Color', 'eduma' ),
		'tooltip'   => esc_html__( 'Allows you to choose background color for body.', 'eduma' ),
		'section'   => 'general_styling',
		'priority'  => 10,
		'choices'   => array( 'alpha' => true ),
		'default'   => '#fff',
		'transport' => 'postMessage',
 		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => ':root',
				'property' => '--thim-body-bg-color',
			),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'        => 'thim_border_color',
		'type'      => 'color',
		'label'     => esc_html__( 'Border Color', 'eduma' ),
		'section'   => 'general_styling',
		'priority'  => 10,
		'choices'   => array( 'alpha' => true ),
		'default'   => '#eee',
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'function' => 'style',
				'element'  => ':root',
				'property' => '--thim-border-color',
			),
		),
	)
);



