<?php

/**
 * Class Thim_Theme_Manager.
 *
 * @since   0.7.0
 *
 * @package Thim_Core_Admin
 */
class Thim_Theme_Manager {

	/**
	 * Flush data.
	 *
	 * @since 1.2.0
	 */
	public static function flush() {
		self::set_metadata();
	}

	/**
	 * Get theme meta data.
	 *
	 * @param      $field
	 * @param bool $default
	 *
	 * @return mixed
	 * @since 1.2.0
	 *
	 */
	public static function get_data( $field, $default = true ) {
		$theme_data = self::get_metadata();

		if ( ! isset( $theme_data[$field] ) ) {
			return $default;
		}

		return $theme_data[$field];
	}

	/**
	 * Set theme data.
	 *
	 * @since 0.3.0
	 */
	public static function set_metadata() {
		global $thim_dashboard;

		$wp_theme       = wp_get_theme();
		$stylesheet     = $wp_theme->get_stylesheet();
		$is_child_theme = thim_core_is_child_theme();

		if ( $is_child_theme ) {
			$parent   = $wp_theme->get_template();
			$wp_theme = wp_get_theme( $parent );
		}

		$theme = array(
			'name'           => $wp_theme->get( 'Name' ),
			'description'    => $wp_theme->get( 'Description' ),
			'version'        => $wp_theme->get( 'Version' ),
			'author'         => $wp_theme->get( 'Author' ),
			'text_domain'    => $wp_theme->get( 'TextDomain' ),
			'stylesheet'     => $wp_theme->get_stylesheet(),
			'template'       => $wp_theme->get_template(),
			'changelog_file' => false,
			'child_theme'    => false,
		);

		//Stylesheet child theme
		if ( $is_child_theme ) {
			$theme['child_theme'] = $stylesheet;
		}

		/**
		 * Set purchase link.
		 */
		$purchase_link          = apply_filters( 'thim_envato_link_purchase', false );
		$theme['purchase_link'] = $purchase_link;

		/**
		 * Set item id on themeforest.
		 */
		$item_id                 = apply_filters( 'thim_envato_item_id', false );
		$theme['envato_item_id'] = $item_id;

		/**
		 * Changelog file
		 */
		$changelog_file = get_template_directory() . '/changelog.html';
		$changelog_file = apply_filters( 'thim_theme_changelog_file', $changelog_file );
		if ( file_exists( $changelog_file ) ) {
			$theme['changelog_file'] = $changelog_file;
		}
		/**
		 * Changelog file
		 */
		$integrations_file = get_template_directory() . '/integrations.txt';
		$integrations_file = apply_filters( 'thim_theme_integrations_file', $integrations_file );
		if ( file_exists( $integrations_file ) ) {
			$theme['integrations_file'] = $integrations_file;
		}

		/**
		 * Documentation links
		 */
		$links_default = array(
			'docs'            => '#',
			'knowledge'       => 'https://thimpress.com/knowledge-base/',
			'support'         => 'https://thimpress.com/forums/',
			'changelog'       => false,
			'video_introduce' => false,
			'video_customize' => false,
		);

		$links          = apply_filters( 'thim_theme_links_guide_user', array() );
		$links          = wp_parse_args( $links, $links_default );
		$theme['links'] = $links;

		/**
		 * Child themes.
		 */
		$theme['child_themes'] = apply_filters( 'thim_core_list_child_themes', array() );

		$thim_dashboard['theme_data'] = $theme;
	}

	/**
	 * Get theme metadata.
	 *
	 * @param $refresh
	 *
	 * @return array
	 * @since 0.7.0
	 *
	 */
	public static function get_metadata( $refresh = false ) {
		global $thim_dashboard;

		$theme_data = isset( $thim_dashboard['theme_data'] ) ? $thim_dashboard['theme_data'] : false;
		if ( ! $theme_data || $refresh ) {
			self::set_metadata();

			return self::get_metadata();
		}

		return $theme_data;
	}

	/**
	 * Get current theme (template).
	 *
	 * @return string Current template theme. Example: education-wp
	 * @since 0.9.0
	 *
	 */
	public static function get_current_theme() {
		$theme_metadata = self::get_metadata();
		$current_theme  = $theme_metadata['template'];

		return $current_theme;
	}

	/**
	 * Get themes installed.
	 *
	 * @return WP_Theme[]
	 * @since 1.2.0
	 *
	 */
	public static function themes_installed() {
		return wp_get_themes();
	}

	/**
	 * Check can update.
	 *
	 * @return bool
	 * @since 1.4.0
	 *
	 */
	public static function can_update() {
		$theme_data      = self::get_metadata();
		$template        = $theme_data['template'];
		$current_version = $theme_data['version'];

		$update_themes = Thim_Product_Registration::get_update_themes();
		$themes        = $update_themes['themes'];

		$data = isset( $themes[$template] ) ? $themes[$template] : false;
		if ( ! $data ) {
			return apply_filters( 'thim_core_can_update_theme', false );
		}

		/**
		 * Double check update.
		 */
		$can_update = version_compare( $data['version'], $current_version, '>' );

		return apply_filters( 'thim_core_can_update_theme', $can_update );
	}
}
