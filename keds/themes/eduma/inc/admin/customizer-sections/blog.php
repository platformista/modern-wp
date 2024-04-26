<?php
/**
 * Panel Blog
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'blog',
        'priority' => 42,
        'title'    => esc_html__( 'Blog', 'eduma' ),
        'icon'     => 'dashicons-welcome-write-blog',
    )
);