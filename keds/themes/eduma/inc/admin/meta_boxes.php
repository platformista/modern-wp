<?php

use Thim_EL_Kit\Functions;

function thim_eduma_register_meta_boxes_portfolio( $meta_boxes ) {
	$prefix       = 'thim_';
	$meta_boxes[] = array(
		'id'         => 'portfolio_bg_color',
		'title'      => __( 'Portfolio Meta', 'eduma' ),
		'post_types' => 'portfolio',
		'fields'     => array(
			array(
				'name' => __( 'Background Color', 'eduma' ),
				'id'   => $prefix . 'portfolio_bg_color_ef',
				'type' => 'color',
			),
		)
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'thim_eduma_register_meta_boxes_portfolio' );

function thim_eduma_register_meta_boxes_post( $meta_boxes ) {
	$prefix       = 'thim_';
	$meta_boxes[] = array(
		'id'         => 'post_gallery',
		'title'      => __( 'Post Layout', 'eduma' ),
		'post_types' => 'post',
		'fields'     => array(
			array(
				'name'    => __( 'Layout Grid', 'eduma' ),
				'id'      => $prefix . 'post_gallery_layout',
				'type'    => 'select',
				'options' => array(
					'size11' => "Size 1x1(225 x 225)",
					'size32' => "Size 3x2(900 x 450)",
					'size22' => "Size 2x2(450 x 450)"
				),
			),
		)
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'thim_eduma_register_meta_boxes_post' );
//Filter meta-box
add_filter( 'thim_metabox_display_settings', 'thim_add_metabox_settings', 100, 2 );
if ( ! function_exists( 'thim_add_metabox_settings' ) ) {
	function thim_add_metabox_settings( $meta_box, $prefix ) {
		$meta_box['post_types'] = array(
			'page',
			'post',
			'lp_course',
			'our_team',
			'testimonials',
			'product',
			'tp_event',
			'portfolio'
		);
		$loop_product_item      = '';
		$prefix                 = 'thim_mtb_';
		//		if ( class_exists( '\Thim_EL_Kit\Functions' ) ) {
		//			$loop_product_item = array(
		//				                     '' => esc_html__( 'Default', 'eduma' )
		//			                     ) + Functions::instance()->get_pages_loop_item( 'product' );
		//		} else {
		//			$loop_product_item = array( '' => esc_html__( 'Default', 'eduma' ) );
		//		}
		if ( isset( $_GET['post'] ) && ( $_GET['post'] == get_option( 'page_on_front' ) || $_GET['post'] == get_option( 'page_for_posts' ) ) ) {
			$meta_box['tabs'] = array(
				'header' => array(
					'label' => __( 'Custom Header', 'eduma' ),
					'icon'  => 'dashicons-editor-kitchensink',
				),
			);
		} else {
			$meta_box['tabs'] = array(
				'title'  => array(
					'label' => __( 'Featured Title Area', 'eduma' ),
					'icon'  => 'dashicons-admin-appearance',
				),
				'layout' => array(
					'label' => __( 'Layout', 'eduma' ),
					'icon'  => 'dashicons-align-left',
				),
				'header' => array(
					'label' => __( 'Header Setting', 'eduma' ),
					'icon'  => 'dashicons-editor-kitchensink',
				),
			);
		}
		if ( get_post_type() == 'lp_course' ) {
			$meta_box['tabs']['course_setting'] = array(
				'label' => __( 'Course Setting', 'eduma' ),
				'icon'  => 'dashicons-editor-kitchensink',
			);
		}
		if ( class_exists( '\Thim_EL_Kit\Functions' ) && isset( $_GET['post'] ) && ( get_option( 'woocommerce_cart_page_id' ) == $_GET['post'] ) ) {
			$meta_box['tabs']['product_setting'] = array(
				'label' => __( 'Product Setting', 'eduma' ),
				'icon'  => 'dashicons-editor-insertmore',
			);
			$loop_product_item                   = array(
				'name'    => esc_html__( 'Select Loop Item', 'eduma' ),
				'id'      => 'thim_loop_item_content_product',
				'type'    => 'select',
				'options' => array( '' => esc_html__( 'Default', 'eduma' ) ) + Functions::instance()->get_pages_loop_item( 'product' ),
				'tab'     => 'product_setting',
			);
		}
		$meta_box['fields'] = array(
			/**
			 * Custom Title and Subtitle.
			 */
			array(
				'name' => __( 'Custom Title and Subtitle', 'eduma'),
				'id'   => $prefix . 'using_custom_heading',
				'type' => 'checkbox',
				'std'  => false,
				'tab'  => 'title',
			),
			array(
				'name'   => __( 'Hide Title and Subtitle', 'eduma'),
				'id'     => $prefix . 'hide_title_and_subtitle',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Custom Title', 'eduma'),
				'id'     => $prefix . 'custom_title',
				'type'   => 'text',
				'desc'   => __( 'Leave empty to use post title', 'eduma'),
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Color Title', 'eduma'),
				'id'     => $prefix . 'text_color',
				'type'   => 'color',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Subtitle', 'eduma'),
				'id'     => 'thim_subtitle',
				'type'   => 'text',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Color Subtitle', 'eduma'),
				'id'     => $prefix . 'color_sub_title',
				'type'   => 'color',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Hide Breadcrumbs', 'eduma'),
				'id'     => $prefix . 'hide_breadcrumbs',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),

			array(
				'name'             => __( 'Background Image', 'eduma'),
				'id'               => $prefix . 'top_image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'tab'              => 'title',
				'hidden'           => array( $prefix . 'using_custom_heading', '!=', true ),
			),
			array(
				'name'   => __( 'Background color', 'eduma'),
				'id'     => $prefix . 'bg_color',
				'type'   => 'color',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
				'alpha'  => true,

			),
			array(
				'name'   => __( 'Background color opacity', 'eduma'),
				'id'     => $prefix . 'bg_opacity',
				'type'   => 'number',
				'desc'   => __( 'input color opacity: Ex: 0.1 ', 'eduma'),
				'std'    => 1,
				'step'   => '0.1',
				'min'    => 0,
				'max'    => 1,
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),

			/**
			 * Custom layout
			 */
			array(
				'name' => __( 'Use Custom Layout', 'eduma'),
				'id'   => $prefix . 'custom_layout',
				'type' => 'checkbox',
				'tab'  => 'layout',
				'std'  => false,
			),
			array(
				'name'    => __( 'Select Layout', 'eduma'),
				'id'      => $prefix . 'layout',
				'type'    => 'image_select',
				'options' => array(
					'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
					'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
					'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
					'full-width'    => THIM_URI . 'images/layout/content-full.jpg',
				),
				'default' => 'sidebar-right',
				'tab'     => 'layout',
				'hidden'  => array( $prefix . 'custom_layout', '=', false ),
			),
			array(
				'name' => __( 'No Padding Content', 'eduma'),
				'id'   => $prefix . 'no_padding',
				'type' => 'checkbox',
				'std'  => false,
				'tab'  => 'layout',
			),
			/*
			 * Header
			 */
			array(
				'name'             => __( 'Logo', 'eduma' ),
				'id'               => $prefix . 'logo',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'tab'              => 'header',
			),
			array(
				'name'    => __( 'Position', 'eduma' ),
				'id'      => $prefix . 'header_position',
				'type'    => 'select',
				'options' => array(
					''               => esc_html__( 'Use option Customizer', 'eduma' ),
					'header_default' => esc_html__( 'Default', 'eduma' ),
					'header_overlay' => esc_html__( 'Overlay', 'eduma' ),
				),
				'tab'     => 'header',
			),
			array(
				'name'  => __( 'Background color', 'eduma' ),
				'id'    => $prefix . 'bg_main_menu_color',
				'type'  => 'color',
				'alpha' => true,
				'tab'   => 'header',
			),
			array(
				'name' => __( 'Text Color', 'eduma' ),
				'id'   => $prefix . 'main_menu_text_color',
				'type' => 'color',
				'tab'  => 'header',
			),
			array(
				'name' => __( 'Text Color Hover', 'eduma' ),
				'id'   => $prefix . 'main_menu_text_hover_color',
				'type' => 'color',
				'tab'  => 'header',
			),

			array(
				'name'    => __( 'Select Layout', 'eduma'),
				'id'      => $prefix . 'layout_content_page',
				'type'    => 'image_select',
				'options' => array(
					''               => THIM_URI . 'images/customizer/single-default.svg',
					'normal'         => THIM_URI . 'images/customizer/single-course-1.svg',
					'new-1'          => THIM_URI . 'images/customizer/single-course-2.svg',
					'layout_style_2' => THIM_URI . 'images/customizer/single-course-3.svg',
					'layout_style_3' => THIM_URI . 'images/customizer/single-course-4.svg',
				),
				'default' => '',
				'tab'     => 'course_setting',
			),
			array(
				'name'   => __( 'Top infor Course BG Colors', 'eduma' ),
				'id'     => $prefix . 'bg_top_info_course',
				'type'   => 'color',
				'tab'    => 'course_setting',
				'hidden' => array( $prefix . 'layout_content_page', '!=', 'layout_style_3' ),
			),
			array(
				'name'   => __( 'Top infor Course Colors', 'eduma' ),
				'id'     => $prefix . 'text_top_info_course',
				'type'   => 'color',
				'tab'    => 'course_setting',
				'hidden' => array( $prefix . 'layout_content_page', '!=', 'layout_style_3' ),
			),
			$loop_product_item
		);

		return $meta_box;
	}
}
