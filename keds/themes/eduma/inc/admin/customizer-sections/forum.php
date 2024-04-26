<?php
/**
 * Panel Event
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'forum',
        'priority' => 50,
        'title'    => esc_html__( 'Forum', 'eduma' ),
        'icon'     => 'dashicons-welcome-write-blog',
    )
);