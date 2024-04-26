<?php
/**
 * Section Background Boxed Mode
 *
 * @package Hair_Salon
 */

// Body Background Group
thim_customizer()->add_group( array(
	'id'       => 'general_boxed_background_group',
	'section'  => 'general_styling',
	'priority' => 50,
	'groups'   => array(
		array(
			'id'     => 'thim_boxed_background_group',
			'label'  => esc_html__( 'Boxed Background', 'eduma' ),
			'fields' => array(
				array(
					'type'     => 'radio-buttonset',
					'id'       => 'thim_bg_boxed_type',
					'label'    => esc_html__( 'Select Background Type', 'eduma' ),
					'tooltip'  => esc_html__( 'Allows you to select a background for body content when you selected box layout in General Layouts', 'eduma' ),
					'default'  => 'image',
					'priority' => 10,
					'choices'  => array(
						'image'   => esc_html__( 'Image', 'eduma' ),
						'pattern' => esc_html__( 'Pattern', 'eduma' ),
					),
				),
				array(
					'type'            => 'image',
					'id'              => 'thim_bg_upload',
					'label'           => esc_html__( 'Background image', 'eduma' ),
					'priority'        => 30,
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => 'body.boxed-area.bg-boxed-image',
							'function' => 'css',
							'property' => 'background-image',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'thim_bg_boxed_type',
							'operator' => '===',
							'value'    => 'image',
						),
					),
				),
				array(
					'type'            => 'select',
					'id'              => 'thim_bg_repeat',
					'label'           => esc_html__( 'Background Repeat', 'eduma' ),
					'default'         => 'no-repeat',
					'priority'        => 40,
					'choices'         => array(
						'repeat'    => esc_html__( 'Tile', 'eduma' ),
						'repeat-x'  => esc_html__( 'Tile Horizontally', 'eduma' ),
						'repeat-y'  => esc_html__( 'Tile Vertically', 'eduma' ),
						'no-repeat' => esc_html__( 'No Repeat', 'eduma' ),
					),
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => 'body.boxed-area.bg-boxed-image',
							'function' => 'css',
							'property' => 'background-repeat',
						)
					),
					'active_callback' => array(
						array(
							'setting'  => 'thim_bg_boxed_type',
							'operator' => '===',
							'value'    => 'image',
						),
						array(
							'setting'  => 'thim_bg_upload',
							'operator' => '!=',
							'value'    => '',
						),
					),
				),
				array(
					'type'            => 'select',
					'id'              => 'thim_bg_position',
					'label'           => esc_html__( 'Background Position', 'eduma' ),
					'default'         => 'center',
					'priority'        => 50,
					'choices'         => array(
						'left'   => esc_html__( 'Left', 'eduma' ),
						'center' => esc_html__( 'Center', 'eduma' ),
						'right'  => esc_html__( 'Right', 'eduma' ),
					),
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => 'body.boxed-area.bg-boxed-image',
							'function' => 'css',
							'property' => 'background-position',
						)
					),
					'active_callback' => array(
						array(
							'setting'  => 'thim_bg_boxed_type',
							'operator' => '===',
							'value'    => 'image',
						),
						array(
							'setting'  => 'thim_bg_upload',
							'operator' => '!=',
							'value'    => '',
						),
					),
				),
				array(
					'type'            => 'select',
					'id'              => 'thim_bg_attachment',
					'label'           => esc_html__( 'Background Attachment', 'eduma' ),
					'default'         => 'inherit',
					'priority'        => 60,
					'choices'         => array(
						'scroll'  => esc_html__( 'Scroll', 'eduma' ),
						'fixed'   => esc_html__( 'Fixed', 'eduma' ),
						'inherit' => esc_html__( 'Inherit', 'eduma' ),
						'initial' => esc_html__( 'Initial', 'eduma' ),
					),
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => 'body.boxed-area.bg-boxed-image',
							'function' => 'css',
							'property' => 'background-attachment',
						)
					),
					'active_callback' => array(
						array(
							'setting'  => 'thim_bg_boxed_type',
							'operator' => '===',
							'value'    => 'image',
						),
						array(
							'setting'  => 'thim_bg_upload',
							'operator' => '!=',
							'value'    => '',
						),
					),
				),

				array(
					'type'            => 'select',
					'id'              => 'thim_bg_size',
					'label'           => esc_html__( 'Background Size', 'eduma' ),
					'default'         => 'inherit',
					'priority'        => 60,
					'choices'         => array(
						'contain' => esc_html__( 'Contain', 'eduma' ),
						'cover'   => esc_html__( 'Cover', 'eduma' ),
						'initial' => esc_html__( 'Initial', 'eduma' ),
						'inherit' => esc_html__( 'Inherit', 'eduma' ),
					),
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => 'body.boxed-area.bg-boxed-image',
							'function' => 'css',
							'property' => 'background-size',
						)
					),
					'active_callback' => array(
						array(
							'setting'  => 'thim_bg_boxed_type',
							'operator' => '===',
							'value'    => 'image',
						),
						array(
							'setting'  => 'thim_bg_upload',
							'operator' => '!=',
							'value'    => '',
						),
					),
				),


				array(
					'type'            => 'radio-image',
					'id'              => 'thim_bg_pattern',
					'label'           => esc_html__( 'Select a Background Pattern', 'eduma' ),
					'section'         => 'background',
					'default'         => THIM_URI . 'images/patterns/pattern1.png',
					'priority'        => 70,
					'choices'         => array(
						THIM_URI . 'images/patterns/pattern1.png'  => THIM_URI . 'images/patterns/pattern1.png',
						THIM_URI . 'images/patterns/pattern2.png'  => THIM_URI . 'images/patterns/pattern2.png',
						THIM_URI . 'images/patterns/pattern3.png'  => THIM_URI . 'images/patterns/pattern3.png',
						THIM_URI . 'images/patterns/pattern4.png'  => THIM_URI . 'images/patterns/pattern4.png',
						THIM_URI . 'images/patterns/pattern5.png'  => THIM_URI . 'images/patterns/pattern5.png',
						THIM_URI . 'images/patterns/pattern6.png'  => THIM_URI . 'images/patterns/pattern6.png',
						THIM_URI . 'images/patterns/pattern7.png'  => THIM_URI . 'images/patterns/pattern7.png',
						THIM_URI . 'images/patterns/pattern8.png'  => THIM_URI . 'images/patterns/pattern8.png',
						THIM_URI . 'images/patterns/pattern9.png'  => THIM_URI . 'images/patterns/pattern9.png',
						THIM_URI . 'images/patterns/pattern10.png' => THIM_URI . 'images/patterns/pattern10.png',
						THIM_URI . 'images/patterns/pattern11.png' => THIM_URI . 'images/patterns/pattern11.png',
						THIM_URI . 'images/patterns/pattern12.png' => THIM_URI . 'images/patterns/pattern12.png',
						THIM_URI . 'images/patterns/pattern13.png' => THIM_URI . 'images/patterns/pattern13.png',
						THIM_URI . 'images/patterns/pattern14.png' => THIM_URI . 'images/patterns/pattern14.png',
						THIM_URI . 'images/patterns/pattern15.png' => THIM_URI . 'images/patterns/pattern15.png',
						THIM_URI . 'images/patterns/pattern16.png' => THIM_URI . 'images/patterns/pattern16.png',
						THIM_URI . 'images/patterns/pattern17.png' => THIM_URI . 'images/patterns/pattern17.png',
						THIM_URI . 'images/patterns/pattern18.png' => THIM_URI . 'images/patterns/pattern18.png',
						THIM_URI . 'images/patterns/pattern19.png' => THIM_URI . 'images/patterns/pattern19.png',
						THIM_URI . 'images/patterns/pattern20.png' => THIM_URI . 'images/patterns/pattern20.png',
						THIM_URI . 'images/patterns/pattern21.png' => THIM_URI . 'images/patterns/pattern21.png',
					),
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => 'body.boxed-area.bg-boxed-pattern',
							'function' => 'css',
							'property' => 'background-image',
						)
					),
					'active_callback' => array(
						array(
							'setting'  => 'thim_bg_boxed_type',
							'operator' => '===',
							'value'    => 'pattern',
						),
					),
				),
			),
		),
	)
) );