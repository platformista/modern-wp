<?php
/**
 * Section Blog Archive
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
    array(
        'id'       => 'blog_meta',
        'panel'    => 'blog',
        'title'    => esc_html__( 'Meta Tags', 'eduma' ),
        'priority' => 20,
    )
);

// Enable or Disable Page Title
thim_customizer()->add_field(
	array(
		'id'          => 'thim_blog_display_year',
		'type'        => 'switch',
		'label'       => esc_html__( 'Display Year', 'eduma' ),
		'tooltip'     => esc_html__( 'Display year on date of Blog.', 'eduma' ),
		'section'     => 'blog_meta',
		'default'     => false,
		'priority'    => 20,
		'choices'     => array(
			true  	  => esc_html__( 'On', 'eduma' ),
			false	  => esc_html__( 'Off', 'eduma' ),
		),
	)
);

// Enable or Disable Author Meta Tags
thim_customizer()->add_field(
    array(
        'id'          => 'thim_show_author',
        'type'        => 'switch',
        'label'       => esc_html__( 'Show Author', 'eduma' ),
        'tooltip'     => esc_html__( 'Allows you to show author meta tags to display at all blog page.', 'eduma' ),
        'section'     => 'blog_meta',
        'default'     => true,
        'priority'    => 30,
        'choices'     => array(
            true  	  => esc_html__( 'Show', 'eduma' ),
            false	  => esc_html__( 'Hide', 'eduma' ),
        ),
    )
);

// Enable or Disable Date Meta Tags
thim_customizer()->add_field(
    array(
        'id'          => 'thim_show_date',
        'type'        => 'switch',
        'label'       => esc_html__( 'Show Date', 'eduma' ),
        'tooltip'     => esc_html__( 'Allows you to show date meta tags to display at all blog page.', 'eduma' ),
        'section'     => 'blog_meta',
        'default'     => true,
        'priority'    => 31,
        'choices'     => array(
            true  	  => esc_html__( 'Show', 'eduma' ),
            false	  => esc_html__( 'Hide', 'eduma' ),
        ),
    )
);

// Enable or Disable Category Meta Tags
thim_customizer()->add_field(
    array(
        'id'          => 'thim_show_category',
        'type'        => 'switch',
        'label'       => esc_html__( 'Show Category', 'eduma' ),
        'tooltip'     => esc_html__( 'Allows you to show category meta tags to display at single post page.', 'eduma' ),
        'section'     => 'blog_meta',
        'default'     => false,
        'priority'    => 32,
        'choices'     => array(
            true  	  => esc_html__( 'Show', 'eduma' ),
            false	  => esc_html__( 'Hide', 'eduma' ),
        ),
    )
);

//Enable or Disable Comments Meta Tags
thim_customizer()->add_field(
    array(
        'id'       => 'thim_show_comment',
        'type'     => 'switch',
        'label'    => esc_html__( 'Show Comment Number', 'eduma' ),
        'tooltip'  => esc_html__( 'Allows you to show comment meta tags to display at single post page.', 'eduma' ),
        'section'  => 'blog_meta',
        'default'  => true,
        'priority' => 33,
        'choices'  => array(
            true  	  => esc_html__( 'Show', 'eduma' ),
            false	  => esc_html__( 'Hide', 'eduma' ),
        ),
    )
);

//Enable or Disable Comments Meta Tags
thim_customizer()->add_field(
    array(
        'id'       => 'thim_show_tag',
        'type'     => 'switch',
        'label'    => esc_html__( 'Show Tag', 'eduma' ),
        'tooltip'  => esc_html__( 'Allows you to meta tags to display at single post page.', 'eduma' ),
        'section'  => 'blog_meta',
        'default'  => false,
        'priority' => 33,
        'choices'  => array(
            true  	  => esc_html__( 'Show', 'eduma' ),
            false	  => esc_html__( 'Hide', 'eduma' ),
        ),
    )
);
