<?php
/**
 * Panel Product
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
    array(
        'id'       => 'woocommerce',
        'priority' => 44,
        'title'    => esc_html__( 'WooCommerce', 'eduma' ),
        'icon'     => 'dashicons-cart',
    )
);