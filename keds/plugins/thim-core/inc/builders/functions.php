<?php
/**
 * Thim_Builder functions
 *
 * @version     1.0.0
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, leehld
 */

defined( 'ABSPATH' ) || exit;
/**
 * Prevent loading this file directly
 */
if ( ! function_exists( 'thim_builder_get_template' ) ) {
	/**
	 * @param        $template_name
	 * @param array  $args
	 * @param string $template_path
	 * @param string $default_path
	 */
	function thim_builder_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) {
			extract( $args );
		}

		if ( false === strpos( $template_name, '.php' ) ) {
			$template_name .= '.php';
		}
		$template_file = thim_builder_locate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $template_file ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );

			return;
		}

		include $template_file;
	}
}

if ( ! function_exists( 'thim_builder_locate_template' ) ) {
	/**
	 * @param        $template_name
	 * @param string $template_path
	 * @param string $default_path
	 *
	 * @return mixed
	 */
	function thim_builder_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		// Set default plugin templates path.
		if ( ! $default_path ) {
			$default_path = TP_THEME_ELEMENTS_THIM_DIR . $template_path; // Path to the template folder
		}

		$base = str_replace( '/tpl/', '', $template_path );

		// Get template file.
		$template = $default_path . $template_name;

		//check file overwritten file in child theme
		$child_template_path = TP_CHILD_THEME_ELEMENTS_THIM_DIR . $base . "/" . $template_name;
		if ( file_exists( $child_template_path ) ) {
			$template = $child_template_path;
		}

		return apply_filters( 'thim-builder/locate-template', $template, $template_name, $template_path, $default_path );
	}
}

if ( ! function_exists( 'thim_builder_get_elements' ) ) {
	/**
	 * @return mixed
	 */
	function thim_builder_get_elements() {
		$TB       = ThimCore_Builder();
		$elements = $TB->get_elements();

		// allow unset elements
		$unset = apply_filters( 'thim-builder/elements-unset', array() );

		foreach ( $elements as $plugin => $_elements ) {
			foreach ( $unset as $item ) {
				$index = array_search( $item, $_elements );

				if ( $index != false ) {
					unset( $elements[$plugin][$index] );
				}
			}
		}

		return $elements;
	}
}

if ( ! function_exists( 'thim_builder_get_group' ) ) {
	/**
	 * Get group of element (widget/shortcode) by name
	 *
	 * @param $name
	 *
	 * @return int|mixed|string
	 */
	function thim_builder_get_group( $name ) {

		$TB       = ThimCore_Builder();
		$elements = $TB->get_elements();

		foreach ( $elements as $group => $_elements ) {
			if ( in_array( $name, $_elements ) ) {
				return $group;
			}
		}

		return apply_filters( 'thim-builder/default-group', 'general', $name );
	}
}

if ( ! function_exists( 'thim_builder_getCSSAnimation' ) ) {
	function thim_builder_getCSSAnimation( $css_animation ) {
		$output = '';
		if ( '' !== $css_animation && 'none' !== $css_animation ) {
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_style( 'vc_animate-css' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
		}

		return $output;
	}
}

if ( ! function_exists( 'thim_builder_folder_group' ) ) {
	function thim_builder_folder_group() {
		return apply_filters( 'thim_support_folder_groups', true );
	}
}
