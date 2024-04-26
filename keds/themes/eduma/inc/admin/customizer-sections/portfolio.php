<?php
/**
 * Panel Portfolio
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'portfolio',
        'priority' => 50,
        'title'    => esc_html__( 'Portfolio', 'eduma' ),
        'icon'     => 'dashicons-portfolio',
    )
);