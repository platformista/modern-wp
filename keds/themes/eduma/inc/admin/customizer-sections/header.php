<?php
/**
 * Panel Header
 * 
 * @package Eduma
 */


thim_customizer()->add_panel(
	array(
		'id'       => 'header',
		'priority' => 20,
		'title'    => esc_html__( 'Header', 'eduma' ),
		'icon'     => 'dashicons-align-left',
	)
);