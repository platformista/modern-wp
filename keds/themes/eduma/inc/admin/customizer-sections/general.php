<?php
/**
 * Panel General
 * 
 * @package Eduma
 */

thim_customizer()->add_panel(
	array(
		'id'       => 'general',
		'priority' => 10,
		'title'    => esc_html__( 'General', 'eduma' ),
		'icon'     => 'dashicons-admin-generic',
	)
);