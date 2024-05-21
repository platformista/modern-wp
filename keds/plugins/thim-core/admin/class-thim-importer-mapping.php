<?php

/**
 * Class Thim_Importer_Mapping
 *
 * @since 1.0.1
 */
class Thim_Importer_Mapping extends Thim_Singleton {
	/**
	 * @since 1.0.1
	 *
	 * @var null
	 */
	static $terms = null;

	/**
	 * Get array terms mapping.
	 *
	 * @since 0.9.1
	 *
	 * @return array
	 */
	public static function get_terms_mapping() {
		if ( self::$terms === null ) {
			$thim_wp_import = Thim_WP_Import_Service::instance( false );
			self::$terms    = $thim_wp_import->processed_terms;
		}

		return self::$terms;
	}

	/**
	 * Get mapping menu id.
	 *
	 * @since 0.9.1
	 *
	 * @param $old_menu_id
	 *
	 * @return mixed|bool
	 */
	public static function get_map_nav_menu( $old_menu_id ) {
		$terms = self::get_terms_mapping();

		if ( empty( $terms[ $old_menu_id ] ) ) {
			return false;
		}

		return $terms[ $old_menu_id ];
	}

	/**
	 * Thim_Importer_Mapping constructor.
	 *
	 * @since 1.0.1
	 */
	protected function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since 1.0.1
	 */
	private function init_hooks() {
		add_filter( 'tc_importer_meta_menu_item', array( $this, 'filter_post_meta_menu_item_mega_menu' ), 10, 1 );
	}

	/**
	 * Filter post meta menu item.
	 *
	 * @since 1.0.1
	 *
	 * @param $post_meta
	 *
	 * @return mixed
	 */
	public function filter_post_meta_menu_item_mega_menu( $post_meta ) {
		$builder            = false;
		$index_meta_content = false;
		$meta_content       = false;

		foreach ( $post_meta as $index => $meta ) {
			$key   = ! empty( $meta['key'] ) ? $meta['key'] : false;
			$value = isset( $meta['value'] ) ? $meta['value'] : false;

			if ( $key === 'tc_mega_menu_page_builder' ) {
				$builder = $value;
				continue;
			}

			if ( $key != 'tc_mega_menu_content' || ! $value ) {
				continue;
			}

			$index_meta_content = $index;
			$meta_content       = $meta;
		}

		if ( empty( $meta_content ) ) {
			return $post_meta;
		}

		if ( $builder == 'so' ) {
			$meta_content['value']            = $this->mapping_content_so_builder( $meta_content['value'] );
			$post_meta[ $index_meta_content ] = $meta_content;
		} else {
			$meta_content['value']            = $this->mapping_content_shortcode( $meta_content['value'] );
			$post_meta[ $index_meta_content ] = $meta_content;
		}

		return $post_meta;
	}

	/**
	 * Mapping content shortcode.
	 *
	 * @since 1.0.6
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	private function mapping_content_shortcode( $value ) {
		return self::mapping_nav_menu_in_content_shortcode( $value );
	}

	/**
	 * Mapping content in Widget Layout Builder Site Origin.
	 *
	 * @since 1.0.6
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	private function mapping_content_so_builder( $value ) {
		$data          = maybe_unserialize( $value );
		$child_widgets = ! empty( $data['widgets'] ) ? $data['widgets'] : false;
		if ( ! is_array( $child_widgets ) ) {
			return $value;
		}

		foreach ( $child_widgets as $i => $child_widget ) {
			$new_widget = Thim_Widget_Importer_Service::map_so_settings_widget( $child_widget );

			if ( $new_widget ) {
				$child_widgets[ $i ] = $new_widget;
			}
		}

		$data['widgets'] = $child_widgets;

		return maybe_serialize( $data );
	}

	/**
	 * Mapping nav menu in content (shortcode).
	 *
	 * @since 0.9.1
	 *
	 * @param $content
	 *
	 * @return mixed
	 */
	public static function mapping_nav_menu_in_content_shortcode( $content ) {
		$match = false;
		preg_match_all( '/nav_menu=\"(\d+)\"/i', $content, $match );
		if ( empty( $match ) || ! $match ) {
			return $content;
		}

		$strings = isset( $match[0] ) ? $match[0] : false;
		$ids     = isset( $match[1] ) ? $match[1] : false;
		if ( empty( $strings ) || empty( $ids ) || ! is_array( $strings ) || ! is_array( $ids ) ) {
			return $content;
		}

		foreach ( $strings as $index => $string ) {
			$menu_id     = $ids[ $index ];
			$new_menu_id = self::get_map_nav_menu( $menu_id );

			$new_string = $string;
			if ( $new_menu_id ) {
				$new_string = "nav_menu=\"$new_menu_id\"";
			}

			$content = str_replace( $string, $new_string, $content );
		}

		return $content;
	}
}
