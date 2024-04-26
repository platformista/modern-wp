<?php
/**
 * Section Sharing
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
    array(
        'id'       => 'sharing',
        'panel'    => 'general',
        'title'    => esc_html__( 'Social Share', 'eduma' ),
        'priority' => 40,
    )
);

// Sharing Group
thim_customizer()->add_field(
    array(
        'id'       => 'group_sharing',
        'type'     => 'sortable',
        'label'    => esc_html__( 'Sortable Buttons Sharing', 'eduma' ),
        'tooltip'  => esc_html__( 'Click on eye icons to show or hide buttons. Use drag and drop to change the position of social share icons..', 'eduma' ),
        'section'  => 'sharing',
        'priority' => 10,
        'default'  => array(
            'facebook',
            'twitter',
            'pinterest',
            'google',
            'linkedin',
        ),
        'choices'  => array(
            'facebook'  => esc_html__( 'Facebook', 'eduma' ),
            'twitter'   => esc_html__( 'Twitter', 'eduma' ),
            'pinterest' => esc_html__( 'Pinterest', 'eduma' ),
             'linkedin'    => esc_html__( 'LinkedIn', 'eduma' ),
        ),
    )
);

