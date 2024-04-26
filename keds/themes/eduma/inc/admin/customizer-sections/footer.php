<?php
/**
 * Panel Footer
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'footer',
		'priority' => 60,
		'title'    => esc_html__( 'Footer', 'eduma' ),
		'icon'     => 'dashicons-align-right',
	)
);
