<?php

if ( is_admin() ) {
	/*
	   * prefix of meta keys, optional
	   */
	$prefix = 'thim_';

	/*
	   * configure your meta box
	   */
	$config = array(
		'id'             => 'category_meta_box',
		// meta box id, unique per meta box
		'title'          => esc_html__( 'Category Meta Box', 'eduma' ),
		// meta box title
		'pages'          => array( 'category', 'product_cat', 'course_category', 'portfolio_category', 'post_tag' ),
		// taxonomy name, accept categories, post_tag and custom taxonomies
		'context'        => 'normal',
		// where the meta box appear: normal (default), advanced, side; optional
		'fields'         => array(),
		// list of meta fields (can be added by field arrays)
		'local_images'   => false,
		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => get_template_directory_uri() . '/inc/libs/Tax-meta-class'
		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$taxonomy = ! empty( $_REQUEST['taxonomy'] ) ? $_REQUEST['taxonomy'] : 'category';
	if ( $taxonomy == 'product_cat' ) {
		$top_prefix  = 'woo_';
		$cate_prefix = 'woo_cate_';
	} elseif ( $taxonomy == 'course_category' ) {
		$top_prefix  = 'learnpress_';
		$cate_prefix = 'learnpress_cate_';
	} else {
		$top_prefix  = 'archive_';
		$cate_prefix = 'archive_cate_';
	}

	$my_meta = new Tax_Meta_Class( $config );
	if ( $taxonomy == 'course_category' ) {
		$my_meta->addColor( $cate_prefix . 'text_color', array( 'name' => esc_html__( 'Text Color', 'eduma' ), 'desc' => esc_html__( 'Use for widget Course layout Category Item Tabs Slider', 'eduma' ) ) );
	}
	$my_meta->addImage( $prefix . $cate_prefix . 'icon', array( 'name' => __( 'Icon', 'eduma' ),'std'=>array() ) );
	$my_meta->addImage( $prefix . $cate_prefix . 'thumnail', array( 'name' => esc_html__( 'Thumbnail', 'eduma' ), 'std'=>array() ) );
	$my_meta->addWysiwyg( $prefix . $cate_prefix . 'content', array('name'=> __( 'Content', 'eduma' ) ) );


	$my_meta->addSelect( $prefix . 'layout', array(
		''              => esc_html__( 'Using in Theme Option', 'eduma' ),
		'full-content'  => esc_html__( 'No Sidebar', 'eduma' ),
		'sidebar-left'  => esc_html__( 'Left Sidebar', 'eduma' ),
		'sidebar-right' => esc_html__( 'Right Sidebar', 'eduma' )
	), array( 'name' => esc_html__( 'Custom Layout ', 'eduma' ), 'std' => array( '' ) ) );

	$my_meta->addCheckbox( $prefix . 'custom_heading', array(
		'name' => esc_html__( 'Custom Heading ', 'eduma' ),
		'std'  => ''
	) );

	$my_meta->addImage( $prefix . $top_prefix . 'top_image', array( 'name' => esc_html__( 'Background Image Heading', 'eduma' ),'std'=>array() ) );
	$my_meta->addColor( $prefix . $cate_prefix . 'heading_bg_color', array( 'name' => esc_html__( 'Background Color Heading', 'eduma' ) ) );
	$my_meta->addText( $prefix . $cate_prefix . 'heading_bg_opacity', array( 'name' => __( 'Background color opacity', 'eduma' ) ) );
	$my_meta->addColor( $prefix . $cate_prefix . 'heading_text_color', array( 'name' => esc_html__( 'Text Color Heading', 'eduma' ) ) );
	$my_meta->addColor( $prefix . $cate_prefix . 'sub_heading_text_color', array( 'name' => esc_html__( 'Color Description Category', 'eduma' ) ) );
	$my_meta->addCheckbox( $prefix . $cate_prefix . 'hide_title', array( 'name' => esc_html__( 'Hide Title', 'eduma' ) ) );
	$my_meta->addCheckbox( $prefix . $cate_prefix . 'hide_breadcrumbs', array( 'name' => esc_html__( 'Hide Breadcrumbs', 'eduma' ) ) );
	$my_meta->Finish();
}
