<?php
/**
 * Panel Event
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'team',
        'priority' => 50,
        'title'    => esc_html__( 'Teams', 'eduma' ),
        'icon'     => 'dashicons-groups',
    )
);