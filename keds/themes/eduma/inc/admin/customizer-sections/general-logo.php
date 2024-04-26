<?php
/**
 * Field Logo and Sticky Logo
 *
 */
thim_customizer()->add_field(
	array(
		'id'       		=> 'thim_logo_retina',
		'type'          => 'image',
		'section'  		=> 'title_tagline',
		'label'    		=> esc_html__( 'Logo Retina', 'eduma' ),
		'tooltip'     	=> esc_html__( 'Allows you to add, remove, change logo on your site. ', 'eduma' ),
		'priority' 		=> 10,
		'default'       => '',
	)
);
// Header Logo
thim_customizer()->add_field(
	array(
		'id'       		=> 'thim_logo',
		'type'          => 'image',
		'section'  		=> 'title_tagline',
		'label'    		=> esc_html__( 'Logo', 'eduma' ),
		'tooltip'     	=> esc_html__( 'Allows you to add, remove, change logo on your site. ', 'eduma' ),
		'priority' 		=> 10,
		'default'       => THIM_URI . "images/logo.png",
	)
);

// Header Sticky Logo
thim_customizer()->add_field(
	array(
		'id'       		=> 'thim_sticky_logo',
		'type'          => 'image',
		'section'  		=> 'title_tagline',
		'label'    		=> esc_html__( 'Sticky Logo', 'eduma' ),
		'tooltip'     	=> esc_html__( 'Allows you to add, remove, change sticky logo on your site. ', 'eduma' ),
		'priority' 		=> 20,
		'default'       => THIM_URI . "images/logo-sticky.png",
	)
);

// Logo width
thim_customizer()->add_field(
	array(
		'id'          => 'thim_width_logo',
		'type'        => 'dimension',
		'label'       => esc_html__( 'Logo width', 'eduma' ),
		'tooltip'     => esc_html__( 'Allows you to assign a value for logo width. Example: 10px, 3em, 48%, 90vh etc.', 'eduma' ),
		'section'     => 'title_tagline',
		'default'     => '155px',
		'priority'    => 40,
		'choices'     => array(
			'min'  => 100,
			'max'  => 500,
			'step' => 1,
		),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => 'header#masthead .width-logo > a',
				'property' => 'width',
			)
		)
	)
);