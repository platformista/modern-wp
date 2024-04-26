<?php
/**
 * Panel Event
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'testimonial',
        'priority' => 50,
        'title'    => esc_html__( 'Testimonials', 'eduma' ),
        'icon'     => 'dashicons-welcome-write-blog',
    )
);