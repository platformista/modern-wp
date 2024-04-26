<?php

add_action( 'admin_init', 'thim_eduma_check_need_upgrade_from_2x', 100 );

function thim_eduma_check_need_upgrade_from_2x() {
	$detect = get_site_transient( '_thim_eduma_need_upgrade' );

	if ( empty( $detect ) ) {
		return;
	}

	wp_redirect( admin_url( '?thim-auto-compile-sass-to-css' ) );
}

add_action( 'admin_init', 'thim_auto_compile_sass_to_css' );
function thim_auto_compile_sass_to_css() {
	$request = isset( $_GET['thim-auto-compile-sass-to-css'] );
	if ( ! $request ) {
		return;
	}

	delete_site_transient( '_thim_eduma_need_upgrade' );

	thim_auto_updated_theme_mods_30();
}


/**
 * hook after active plugin thim_core
 */
if ( ! function_exists( 'thim_activation_thim_core' ) ) {
	function thim_activation_thim_core() {
		$active_plugins = get_option( 'active_plugins' );

		if ( ( $key = array_search( 'thim-framework/tp-framework.php', $active_plugins ) ) !== false ) {
			unset( $active_plugins[ $key ] );
			update_option( 'active_plugins', $active_plugins );

			set_site_transient( '_thim_eduma_need_upgrade', true, 3600 );
		}
	}
}
add_action( 'thim_core_installer_install_success', 'thim_activation_thim_core' );


/**
 * Update theme_mods_eduma when update to version 3.0
 */
if ( ! function_exists( 'thim_auto_updated_theme_mods_30' ) ) {
	function thim_auto_updated_theme_mods_30() {
		$updated = get_option( 'thim_auto_updated_theme_mods_30', false );

		if ( $updated ) {
			wp_redirect( admin_url( '?thim-redirect-to-theme-dashboard' ) );

			return;
		}

		$theme_name = get_option( 'stylesheet' );
		//Backup old theme_mods
		$theme_mods_option = get_option( 'theme_mods_' . $theme_name );

		update_option( 'theme_mods_old_' . $theme_name, $theme_mods_option );

		//Update theme mods
		$thim_font_size_main_menu   = ! empty( $theme_mods_option['thim_font_size_main_menu'] ) ? $theme_mods_option['thim_font_size_main_menu'] : '14px';
//		$thim_font_weight_main_menu = ! empty( $theme_mods_option['thim_font_weight_main_menu'] ) ? $theme_mods_option['thim_font_weight_main_menu'] : '600';

		$theme_mods_option['thim_main_menu'] = array(
//			'variant'   => $thim_font_weight_main_menu,
			'font-size' => $thim_font_size_main_menu
		);

		//Font body
		$thim_font_body = ! empty( $theme_mods_option['thim_font_body'] ) ? $theme_mods_option['thim_font_body'] : array();
		if ( ! is_array( $thim_font_body ) ) {
			$thim_font_body = maybe_unserialize( $thim_font_body );
		}
		$thim_font_body_font_family          = ! empty( $thim_font_body['font-family'] ) ? $thim_font_body['font-family'] : 'Roboto';
		$thim_font_body_variant              = ! empty( $thim_font_body['font-weight'] ) ? $thim_font_body['font-weight'] : '400';
		$thim_font_body_font_size            = ! empty( $thim_font_body['font-size'] ) ? $thim_font_body['font-size'] : '15px';
		$thim_font_body_line_height          = ! empty( $thim_font_body['line-height'] ) ? $thim_font_body['line-height'] : '1.7em';
		$thim_font_body_color                = ! empty( $thim_font_body['color-opacity'] ) ? $thim_font_body['color-opacity'] : '#666';
		$theme_mods_option['thim_font_body'] = array(
			'font-family' => $thim_font_body_font_family,
			'variant'     => $thim_font_body_variant,
			'font-size'   => $thim_font_body_font_size,
			'line-height' => $thim_font_body_line_height,
			'color'       => $thim_font_body_color
		);

		//Font title
		$thim_font_title = ! empty( $theme_mods_option['thim_font_title'] ) ? $theme_mods_option['thim_font_title'] : array();
		if ( ! is_array( $thim_font_title ) ) {
			$thim_font_title = maybe_unserialize( $thim_font_title );
		}
		$thim_font_title_font_family = ! empty( $thim_font_title['font-family'] ) ? $thim_font_title['font-family'] : 'Roboto Slab';
		$thim_font_title_variant     = ! empty( $thim_font_title['font-weight'] ) ? $thim_font_title['font-weight'] : '700';
		$thim_font_title_color       = ! empty( $thim_font_title['color-opacity'] ) ? $thim_font_title['color-opacity'] : '#333';

		$theme_mods_option['thim_font_title'] = array(
			'font-family' => $thim_font_title_font_family,
			'variant'     => $thim_font_title_variant,
			'color'       => $thim_font_title_color
		);

		//Font heading h1-h6
		$thim_font_h1 = ! empty( $theme_mods_option['thim_font_h1'] ) ? $theme_mods_option['thim_font_h1'] : array();
		if ( ! is_array( $thim_font_h1 ) ) {
			$thim_font_h1 = maybe_unserialize( $thim_font_h1 );
		}
		$thim_font_h1_font_size   = ! empty( $thim_font_h1['font-size'] ) ? $thim_font_h1['font-size'] : '36px';
		$thim_font_h1_line_height = ! empty( $thim_font_h1['line-height'] ) ? $thim_font_h1['line-height'] : '1.6em';

		$theme_mods_option['thim_font_h1'] = array(
			'font-size'   => $thim_font_h1_font_size,
			'line-height' => $thim_font_h1_line_height,
		);

		$thim_font_h2 = ! empty( $theme_mods_option['thim_font_h2'] ) ? $theme_mods_option['thim_font_h2'] : array();
		if ( ! is_array( $thim_font_h2 ) ) {
			$thim_font_h2 = maybe_unserialize( $thim_font_h2 );
		}
		$thim_font_h2_font_size   = ! empty( $thim_font_h2['font-size'] ) ? $thim_font_h2['font-size'] : '28px';
		$thim_font_h2_line_height = ! empty( $thim_font_h2['line-height'] ) ? $thim_font_h2['line-height'] : '1.6em';

		$theme_mods_option['thim_font_h2'] = array(
			'font-size'   => $thim_font_h2_font_size,
			'line-height' => $thim_font_h2_line_height,
		);

		$thim_font_h3 = ! empty( $theme_mods_option['thim_font_h3'] ) ? $theme_mods_option['thim_font_h3'] : array();
		if ( ! is_array( $thim_font_h3 ) ) {
			$thim_font_h3 = maybe_unserialize( $thim_font_h3 );
		}
		$thim_font_h3_font_size   = ! empty( $thim_font_h3['font-size'] ) ? $thim_font_h3['font-size'] : '24px';
		$thim_font_h3_line_height = ! empty( $thim_font_h3['line-height'] ) ? $thim_font_h3['line-height'] : '1.6em';

		$theme_mods_option['thim_font_h3'] = array(
			'font-size'   => $thim_font_h3_font_size,
			'line-height' => $thim_font_h3_line_height,
		);

		$thim_font_h4 = ! empty( $theme_mods_option['thim_font_h4'] ) ? $theme_mods_option['thim_font_h4'] : array();
		if ( ! is_array( $thim_font_h4 ) ) {
			$thim_font_h4 = maybe_unserialize( $thim_font_h4 );
		}
		$thim_font_h4_font_size            = ! empty( $thim_font_h4['font-size'] ) ? $thim_font_h4['font-size'] : '18px';
		$thim_font_h4_line_height          = ! empty( $thim_font_h4['line-height'] ) ? $thim_font_h4['line-height'] : '1.6em';
		$theme_mods_option['thim_font_h4'] = array(
			'font-size'   => $thim_font_h4_font_size,
			'line-height' => $thim_font_h4_line_height,
		);

		$thim_font_h5 = ! empty( $theme_mods_option['thim_font_h5'] ) ? $theme_mods_option['thim_font_h5'] : array();
		if ( ! is_array( $thim_font_h5 ) ) {
			$thim_font_h5 = maybe_unserialize( $thim_font_h5 );
		}
		$thim_font_h5_font_size            = ! empty( $thim_font_h5['font-size'] ) ? $thim_font_h5['font-size'] : '16px';
		$thim_font_h5_line_height          = ! empty( $thim_font_h5['line-height'] ) ? $thim_font_h5['line-height'] : '1.6em';
		$theme_mods_option['thim_font_h5'] = array(
			'font-size'   => $thim_font_h5_font_size,
			'line-height' => $thim_font_h5_line_height,
		);

		$thim_font_h6 = ! empty( $theme_mods_option['thim_font_h5'] ) ? $theme_mods_option['thim_font_h5'] : array();
		if ( ! is_array( $thim_font_h6 ) ) {
			$thim_font_h6 = maybe_unserialize( $thim_font_h5 );
		}
		$thim_font_h6_font_size   = ! empty( $thim_font_h6['font-size'] ) ? $thim_font_h6['font-size'] : '16px';
		$thim_font_h6_line_height = ! empty( $thim_font_h6['line-height'] ) ? $thim_font_h6['line-height'] : '1.4em';

		$theme_mods_option['thim_font_h6'] = array(
			'font-size'   => $thim_font_h6_font_size,
			'line-height' => $thim_font_h6_line_height,
		);

		//Toolbar
		$thim_font_size_toolbar            = ! empty( $theme_mods_option['thim_font_size_toolbar'] ) ? $theme_mods_option['thim_font_size_toolbar'] : '12px';
		$theme_mods_option['thim_toolbar'] = array(
			'font-size' => $thim_font_size_toolbar
		);

		$thim_footer_title_font_color = ! empty( $theme_mods_option['thim_footer_title_font_color'] ) ? $theme_mods_option['thim_footer_title_font_color'] : '#fff';
		$thim_footer_text_font_color  = ! empty( $theme_mods_option['thim_footer_text_font_color'] ) ? $theme_mods_option['thim_footer_text_font_color'] : '#999';

		$theme_mods_option['thim_footer_color'] = array(
			'title' => $thim_footer_title_font_color,
			'text'  => $thim_footer_text_font_color
		);

		if ( ! empty( $theme_mods_option['thim_width_logo'] ) && is_numeric( $theme_mods_option['thim_width_logo'] ) ) {
			$theme_mods_option['thim_width_logo'] = $theme_mods_option['thim_width_logo'] . 'px';
		}


		$list_image = array(
			'thim_logo',
			'thim_sticky_logo',
			'thim_logo_mobile',
			'thim_sticky_logo_mobile',
			'thim_bg_upload',
			'thim_archive_cate_top_image',
			'thim_front_page_top_image',
			'thim_archive_single_top_image',
			'thim_woo_cate_top_image',
			'thim_woo_single_top_image',
			'thim_learnpress_cate_top_image',
			'thim_learnpress_single_top_image',
			'thim_portfolio_cate_top_image',
			'thim_portfolio_single_top_image',
			'thim_event_cate_top_image',
			'thim_event_single_top_image',
			'thim_footer_background_img',
			'thim_footer_bottom_bg_img'
		);

		foreach ( $list_image as $value ) {
			$value_id = ! empty( $theme_mods_option[ $value ] ) ? $theme_mods_option[ $value ] : false;
			if ( ! empty( $value_id ) && is_numeric( $value_id ) ) {

				$value_image = wp_get_attachment_image_src( $value_id, 'full' );
				if ( ! empty( $value_image[0] ) ) {
					$theme_mods_option[ $value ] = $value_image[0];
				}
			}
		}

		//Auto update theme_mods when active thim-core
		update_option( 'theme_mods_' . $theme_name, $theme_mods_option );

		//Update menu meta
		// thim_upgrade_post_meta_menu();

		//Update post meta thim_gallery
		thim_upgrade_post_meta_gallery();

		//upgrade data for megamenu
		// thim_upgrade_megamenu_sidebar();

		//Auto compile sass
		if ( function_exists( 'thim_compile_custom_css_theme' ) ) {

			update_option( 'thim_compile_custom_css_theme', true );
			thim_compile_custom_css_theme();
		}

		//Update option check update theme mods for 3.0
		update_option( 'thim_auto_updated_theme_mods_30', '1' );

		wp_redirect( admin_url( 'admin.php?page=thim-getting-started' ) );
	}
}


/**
 * upgrade post meta for menu
 */
if ( ! function_exists( 'thim_upgrade_post_meta_menu' ) ) {
	function thim_upgrade_post_meta_menu() {
		global $wpdb;
		$result    = $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value <> '' OR meta_key = %s AND meta_value <> '' ", '_menu-item-tp-submenu-type', '_menu-item-tp-menu-icon' );
		$menus_old = $wpdb->get_results( $result );
		if ( ! empty( $menus_old ) ) {
			$new_menus = array();
			foreach ( $menus_old as $menu_item ) {
				if ( $menu_item->meta_key == '_menu-item-tp-menu-icon' ) {
					$new_menus[ $menu_item->post_id ]['icon'] = 'fa fa-' . $menu_item->meta_value;
				} else if ( $menu_item->meta_key == '_menu-item-tp-submenu-type' ) {
					if ( $menu_item->meta_value == 'widget_area' ) {
						$new_menus[ $menu_item->post_id ]['layout'] = 'builder';
					} else if ( $menu_item->meta_value == 'multicolumn' ) {
						$new_menus[ $menu_item->post_id ]['layout'] = 'column';
					} else {
						$new_menus[ $menu_item->post_id ]['layout'] = 'default';
					}
				}
			}

			if ( ! empty( $new_menus ) ) {
				foreach ( $new_menus as $key => $value ) {
					update_post_meta( $key, 'tc-mega-menu', $value );
				}
			}
		}
	}
}

/**
 * upgrade post meta for thim_gallery
 */
if ( ! function_exists( 'thim_upgrade_post_meta_gallery' ) ) {
	function thim_upgrade_post_meta_gallery() {
		global $wpdb;
		$result_gallery = $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value <> ''", 'thim_gallery' );
		$post_gallery   = $wpdb->get_results( $result_gallery );

		if ( ! empty( $post_gallery ) ) {
			foreach ( $post_gallery as $value ) {
				if ( strpos( $value->meta_value, ',' ) !== false ) {
					$post_meta = explode( ',', $value->meta_value );
					if ( ! empty( $post_meta ) ) {
						foreach ( $post_meta as $meta ) {
							if ( ! empty( $meta ) ) {
								add_post_meta( $value->post_id, $value->meta_key, $meta );
							}
						}
						delete_post_meta( $value->post_id, $value->meta_key, $value->meta_value );
					}
				}
			}
		}
	}
}

/**
 * Add variables to auto compile sass
 * @return array
 *
 * TODO issue: khi them 1 option customize moi can them id vao bien field
 */
function thim_filter_variables_compile_scss() {

	$variables = array();

	$fields = array(
		'thim_main_menu',
		'thim_font_body',
		'thim_font_title',
		'thim_font_h1',
		'thim_font_h2',
		'thim_font_h3',
		'thim_font_h4',
		'thim_font_h5',
		'thim_font_h6',
		'thim_width_logo',
		'thim_bg_main_menu_color',

		//menu
		'thim_main_menu_text_color',
		'thim_main_menu_text_hover_color',
		'thim_font_size_main_menu',
		'thim_font_weight_main_menu',
		'thim_bg_mobile_menu_color',
		'thim_mobile_menu_text_color',
		'thim_mobile_menu_text_hover_color',
		'thim_sub_menu_bg_color',
		'thim_sub_menu_border_color',
		'thim_sub_menu_text_color',
		'thim_sub_menu_text_color_hover',
		'thim_sticky_bg_main_menu_color',
		'thim_sticky_main_menu_text_color',
		'thim_sticky_main_menu_text_hover_color',

		//toolbar
		'thim_toolbar',
		'thim_bg_color_toolbar',
		'thim_text_color_toolbar',
		'thim_link_color_toolbar',
        'thim_link_hover_color_toolbar',

		//body
		'thim_body_bg_color',
		'thim_body_primary_color',
		'thim_bg_repeat',
		'thim_bg_position',
		'thim_bg_attachment',
		'thim_bg_size',
		'thim_button_hover_color',
		'thim_button_text_color',
		'thim_body_secondary_color',
		'thim_bg_upload',
		'thim_bg_pattern',

		//footer
		'thim_copyright_bg_color',
		'thim_copyright_text_color',
		'thim_copyright_border_color',
		'thim_footer_color_hover',
		'thim_footer_color_link',
		'thim_footer_color',
		'thim_footer_bg_color',
		'thim_footer_bg_repeat',
		'thim_footer_background_img',
		'thim_footer_bg_position',
		'thim_footer_bg_size',
		'thim_footer_bg_attachment',

		//archive
		'thim_archive_cate_bg_color',
		'thim_archive_cate_title_color',
		'thim_archive_cate_sub_title_color',
		'thim_archive_single_bg_color',
		'thim_archive_single_title_color',
		'thim_archive_single_sub_title_color',
		'thim_front_page_bg_color',
		'thim_front_page_title_color',
		'thim_front_page_sub_title_color',

		//course
		'thim_learnpress_cate_bg_color',
		'thim_learnpress_cate_title_color',
		'thim_learnpress_cate_sub_title_color',
		'thim_learnpress_single_bg_color',
		'thim_learnpress_single_title_color',
		'thim_learnpress_single_sub_title_color',

		//event
		'thim_event_cate_bg_color',
		'thim_event_cate_title_color',
		'thim_event_cate_sub_title_color',
		'thim_event_single_bg_color',
		'thim_event_single_title_color',
		'thim_event_single_sub_title_color',

		//Preload
		'thim_preload_style_color',
		'thim_preload_style_background',
		'thim_preload_style',

		//Woo
		'thim_woo_cate_bg_color',
		'thim_woo_cate_title_color',
		'thim_woo_cate_sub_title_color',
		'thim_woo_single_bg_color',
		'thim_woo_single_title_color',
		'thim_woo_single_sub_title_color',

        'thim_maintenance_text_color',
        'thim_maintenance_bg_color',
        'thim_link_color_toolbar_border_button',
	);

	$prefix = 'thim_';

	$theme_mods = get_theme_mods();

	foreach ( $fields as $field ) {

		$values = ! empty( $theme_mods[ $field ] ) ? $theme_mods[ $field ] : '';

		if ( in_array( $field, array( 'thim_bg_pattern', 'thim_footer_background_img', 'thim_bg_upload' ) ) ) {
			$values = str_replace( 'https://', '//', $values );
			$values = str_replace( 'http://', '//', $values );

			$values = '"' . $values . '"';
		}


		if ( is_array( $values ) ) {
			foreach ( $values as $key => $val ) {
				if ( 'subsets' === $key ) {//Excluded subsets
					continue;
				}
				if('font-family'===$key){
				    $val = "'".$val."'";
				}

				if ( 'variant' === $key ) {
					if ( 'regular' === $val ) {
						$val = '400normal';
					}

					if ( 'italic' === $val ) {
						$val = '400italic';
					}

					$font_weight = intval( $val );

					if ( 0 === $font_weight ) {
						$font_weight = 400;
					}

					$font_style = str_replace( $font_weight, '', $val );

					if ( empty( $font_style ) ) {
						$font_style = 'normal';
					}

					$key = $prefix . $field;

					$variables[ $key . '_font_weight' ] = $font_weight;
					$variables[ $key . '_font_style' ]  = $font_style;
					continue;
				}

				$key = $field . '_' . $key;
				$key = $prefix . $key;
				$key = str_replace( '-', '_', $key );

				$variables[ $key ] = $val;
			}
		} else {
			if ( empty( $values ) ) {
				$values = '""';
			}
			$variables[ $prefix . $field ] = $values;
		}
	}

	return $variables;
}

add_filter( 'tc_variables_compile_scss_theme', 'thim_filter_variables_compile_scss' );

/**
 * upgrade megamenu widget area
 */
function thim_upgrade_megamenu_sidebar() {
	global $wpdb;
	$result    = $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = 'widget_area' ", '_menu-item-tp-submenu-type' );
	$menus_old = $wpdb->get_results( $result );
	if ( ! empty( $menus_old ) ) {
		foreach ( $menus_old as $menu_item ) {
			$widget_area = get_post_meta( $menu_item->post_id, '_menu-item-tp-widget-area', true );
			$widget_area = str_replace( 'widget_area_', '', $widget_area );
			ob_start();
			dynamic_sidebar( $widget_area );
			$megamenu_content = ob_get_contents();
			ob_end_clean();
			$megamenu_content = preg_replace( array( '~^<li~', '~<\/li>$~' ), array( '<div', '</div>' ), $megamenu_content );
			update_post_meta( $menu_item->post_id, 'tc_mega_menu_content', $megamenu_content );
		}
	}
}
