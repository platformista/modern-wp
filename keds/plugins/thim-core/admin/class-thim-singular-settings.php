<?php

/**
 * Class Thim_Singular_Settings
 *
 * @package   Thim_Core
 * @since     0.1.0
 * @docs      docs/page-settings.md
 */
class Thim_Singular_Settings extends Thim_Singleton {
	/**
	 * Thim_Singular_Settings constructor.
	 *
	 * @since 0.1.0
	 */
	protected function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.1.0
	 */
	private function init_hooks() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'metabox' ) );
	}

	/**
	 * Filter add metabox.
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function metabox( $meta_boxes ) {
		$box = $this->metabox_display_settings();
		if ( ! empty( $box ) ) {
			$meta_boxes[] = $box;
		}

		return $meta_boxes;
	}

	/**
	 * Metabox display settings.
	 *
	 * @return mixed
	 * @since 0.1.0
	 */
	private function metabox_display_settings() {
		$prefix = TP::$prefix;

		$meta_box = array(
			'title'      => __( 'Display settings', 'thim-core' ),
			'post_types' => array( 'page', 'post' ),
			'tabs'       => array(
				'title'  => array(
					'label' => __( 'Featured Title Area', 'thim-core' ),
					'icon'  => 'dashicons-admin-appearance',
				),
				'layout' => array(
					'label' => __( 'Layout', 'thim-core' ),
					'icon'  => 'dashicons-align-left',
				),
			),
			'tab_style'  => 'box',

			'tab_wrapper' => false,
			'fields'      => array(
				/**
				 * Custom Title and Subtitle.
				 */
				array(
					'name' => __( 'Custom Title and Subtitle', 'thim-core' ),
					'id'   => $prefix . 'enable_custom_title',
					'type' => 'checkbox',
					'std'  => false,
					'tab'  => 'title',
				),
				array(
					'id'     => $prefix . 'group_custom_title',
					'type'   => 'group',
					'tab'    => 'title',
					'hidden' => array( $prefix . 'enable_custom_title', '=', false ),
					'fields' => array(
						array(
							'name' => __( 'Hide Title and Subtitle', 'thim-core' ),
							'id'   => $prefix . 'hide_title',
							'type' => 'checkbox',
							'std'  => false,
						),
						array(
							'name'   => __( 'Custom Title', 'thim-core' ),
							'id'     => $prefix . 'custom_title',
							'type'   => 'text',
							'desc'   => __( 'Leave empty to use post title', 'thim-core' ),
							'hidden' => array( $prefix . 'hide_title', '=', true ),
						),
						array(
							'name'   => __( 'Color Title', 'thim-core' ),
							'id'     => $prefix . 'color_title',
							'type'   => 'color',
							'hidden' => array( $prefix . 'hide_title', '=', true ),
						),
						array(
							'name'   => __( 'Subtitle', 'thim-core' ),
							'id'     => $prefix . 'custom_subtitle',
							'type'   => 'text',
							'hidden' => array( $prefix . 'hide_title', '=', true ),
						),
						array(
							'name'   => __( 'Color Subtitle', 'thim-core' ),
							'id'     => $prefix . 'color_subtitle',
							'type'   => 'color',
							'hidden' => array( $prefix . 'hide_title', '=', true ),
						),
						array(
							'name' => __( 'Hide Breadcrumbs', 'thim-core' ),
							'id'   => $prefix . 'hide_breadcrumbs',
							'type' => 'checkbox',
							'std'  => false,
						),
					),
				),
				array(
					'id'     => $prefix . 'group_custom_background',
					'name'   => __( 'Background', 'thim-core' ),
					'type'   => 'group',
					'tab'    => 'title',
					'hidden' => array( $prefix . 'enable_custom_title', '!=', true ),
					'fields' => array(
						array(
							'name'             => __( 'Background Image', 'thim-core' ),
							'id'               => $prefix . 'heading_image',
							'type'             => 'image_advanced',
							'max_file_uploads' => 1,
						),
						array(
							'name' => __( 'Background color', 'thim-core' ),
							'id'   => $prefix . 'heading_background',
							'type' => 'color',
						),
						array(
							'name'    => __( 'Background color opacity', 'thim-core' ),
							'id'      => $prefix . 'heading_background_opacity',
							'type'    => 'text',
							'default' => 1,
						),
					),
				),

				/**
				 * Custom layout
				 */
				array(
					'name' => __( 'Use Custom Layout', 'thim-core' ),
					'id'   => $prefix . 'enable_custom_layout',
					'type' => 'checkbox',
					'tab'  => 'layout',
					'std'  => false,
				),
				array(
					'name'    => __( 'Select Layout', 'thim-core' ),
					'id'      => $prefix . 'custom_layout',
					'type'    => 'image_select',
					'options' => array(
						'sidebar-left'  => THIM_CORE_ADMIN_URI . '/assets/images/layout/sidebar-left.png',
						'no-sidebar'    => THIM_CORE_ADMIN_URI . '/assets/images/layout/body-full.png',
						'sidebar-right' => THIM_CORE_ADMIN_URI . '/assets/images/layout/sidebar-right.png',
						'full-sidebar'  => THIM_CORE_ADMIN_URI . '/assets/images/layout/body-left-right.png',
					),
					'default' => 'sidebar-right',
					'tab'     => 'layout',
					'hidden'  => array( $prefix . 'enable_custom_layout', '=', false ),
				),
				array(
					'name'    => __( 'Select sidebar left', 'thim-core' ),
					'id'      => $prefix . 'custom_sidebar_left',
					'type'    => 'select',
					'options' => $this->get_list_sidebar(),
					'tab'     => 'layout',
					'hidden'  => array( $prefix . 'custom_layout', '!=', 'full-sidebar' ),
				),
				array(
					'name'    => __( 'Select sidebar right', 'thim-core' ),
					'id'      => $prefix . 'custom_sidebar_right',
					'type'    => 'select',
					'options' => $this->get_list_sidebar(),
					'tab'     => 'layout',
					'hidden'  => array( $prefix . 'custom_layout', '!=', 'full-sidebar' ),
				),
				array(
					'name' => __( 'No Padding Content', 'thim-core' ),
					'id'   => $prefix . 'no_padding_content',
					'type' => 'checkbox',
					'std'  => false,
					'tab'  => 'layout',
				),
			),
		);

		return apply_filters( 'thim_metabox_display_settings', $meta_box, $prefix );
	}

	/**
	 * Get array sidebars.
	 *
	 * @return array ['id' => 'name']
	 * @since 0.1.0
	 */
	public function get_list_sidebar() {
		global $wp_registered_sidebars;

		$sidebar_array     = array();
		$sidebar_array[''] = esc_html__( '-- Select Sidebar --', 'thim-core' );

		foreach ( $wp_registered_sidebars as $key => $sidebar ) {
			$sidebar_array[ $key ] = $sidebar['name'];
		}

		return $sidebar_array;
	}
}
