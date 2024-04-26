<?php
/**
 * Panel 404
 *
 * @package Eduma
 */

thim_customizer()->add_section(
    array(
        'id'       => '404_page',
        'panel'    => 'general',
        'priority' => 150,
        'title'    => esc_html__( '404 Page', 'eduma' ),
    )
);

thim_customizer()->add_field(
    array(
        'type'     => 'text',
        'id'       => 'thim_single_404_page_title',
        'label'    => esc_html__( 'Custom title', 'eduma' ),
        'tooltip'  => esc_html__( 'Allows you can setup custom title.', 'eduma' ),
        'section'  => '404_page',
        'priority' => 10,
    )
);

thim_customizer()->add_field(
    array(
        'type'     => 'text',
        'id'       => 'thim_single_404_sub_title',
        'label'    => esc_html__( 'Sub Heading', 'eduma' ),
        'tooltip'  => esc_html__( 'Allows you can setup sub heading.', 'eduma' ),
        'section'  => '404_page',
        'priority' => 15,
    )
);

thim_customizer()->add_field(
    array(
        'type'      => 'image',
        'id'        => 'thim_single_404_top_image',
        'label'     => esc_html__( 'Top Image', 'eduma' ),
        'priority'  => 30,
        'transport' => 'postMessage',
        'section'  => '404_page',
        'default'     => THIM_URI . "images/bg-page.jpg",
    )
);

// Page Title Background Color
thim_customizer()->add_field(
    array(
        'id'          => 'thim_single_404_bg_color',
        'type'        => 'color',
        'label'       => esc_html__( 'Background Color', 'eduma' ),
        'tooltip'     => esc_html__( 'If you do not use background image, then can use background color for page title on heading top. ', 'eduma' ),
        'section'     => '404_page',
        'default'     => 'rgba(0,0,0,0.5)',
        'priority'    => 35,
        'choices' => array ('alpha'     => true),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'choice'   => 'color',
                'element'  => '.top_site_main>.overlay-top-header',
                'property' => 'background',
            )
        )
    )
);

thim_customizer()->add_field(
    array(
        'id'          => 'thim_single_404_title_color',
        'type'        => 'color',
        'label'       => esc_html__( 'Title Color', 'eduma' ),
        'tooltip'     => esc_html__( 'Allows you can select a color make text color for title.', 'eduma' ),
        'section'     => '404_page',
        'default'     => '#ffffff',
        'priority'    => 40,
        'choices' => array ('alpha'     => true),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'choice'   => 'color',
                'element'  => '.top_site_main h1, .top_site_main h2',
                'property' => 'color',
            )
        )
    )
);

thim_customizer()->add_field(
    array(
        'id'          => 'thim_single_404_sub_title_color',
        'type'        => 'color',
        'label'       => esc_html__( 'Sub Title Color', 'eduma' ),
        'tooltip'     => esc_html__( 'Allows you can select a color make sub title color page title.', 'eduma' ),
        'section'     => '404_page',
        'default'     => '#999',
        'priority'    => 45,
        'choices' => array ('alpha'     => true),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'choice'   => 'color',
                'element'  => '.top_site_main .banner-description',
                'property' => 'color',
            )
        )
    )
);

thim_customizer()->add_field(
	array(
		'type'      => 'image',
		'id'        => 'thim_single_404_left',
		'label'     => esc_html__( 'Image Left', 'eduma' ),
		'priority'  => 20,
		'transport' => 'postMessage',
		'section'  => '404_page',
		'default'     => THIM_URI . "images/image-404.jpg",
	)
);
