<?php
namespace ThimPress\Customizer\Utils;

final class GoogleFonts {

	public static $google_fonts;

	public static $google_font_names;


	public function __construct() {
		add_action( 'wp_ajax_thim_fonts_google_all_get', array( $this, 'print_googlefonts_json' ) );
		add_action( 'wp_ajax_nopriv_thim_fonts_google_all_get', array( $this, 'print_googlefonts_json' ) );
	}

	public function print_googlefonts_json( $die = true ) {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$google_fonts = $wp_filesystem->get_contents( THIM_CUSTOMIZER_DIR . '/utils/googlefonts/webfonts.json' );

		if ( function_exists( 'wp_die' ) && $die ) {
			wp_die( $google_fonts );
		} else {
			return $google_fonts;
		}
	}

	public function get_array() {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$google_fonts = $wp_filesystem->get_contents( THIM_CUSTOMIZER_DIR . '/utils/googlefonts/webfonts.json' );

		return json_decode( $google_fonts, true );
	}

	public function get_names_array() {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$google_fonts = $wp_filesystem->get_contents( THIM_CUSTOMIZER_DIR . '/utils/googlefonts/webfont-names.json' );

		return json_decode( $google_fonts, true );
	}

	public function get_google_fonts() {
		self::$google_fonts = get_site_transient( 'thim_customizer_googlefonts_cache' );

		if ( self::$google_fonts ) {
			return self::$google_fonts;
		}

		$fonts = $this->get_array();

		self::$google_fonts = array();
		if ( is_array( $fonts ) ) {
			foreach ( $fonts['items'] as $font ) {
				self::$google_fonts[ $font['family'] ] = array(
					'label'    => $font['family'],
					'variants' => $font['variants'],
					'category' => $font['category'],
				);
			}
		}

		self::$google_fonts = apply_filters( 'thim_customizer_fonts_google_fonts', self::$google_fonts );

		$cache_time = apply_filters( 'thim_customizer_googlefonts_transient_time', HOUR_IN_SECONDS );

		set_site_transient( 'thim_customizer_googlefonts_cache', self::$google_fonts, $cache_time );

		return self::$google_fonts;
	}

	public function get_google_font_names() {
		self::$google_font_names = get_site_transient( 'thim_customizer_googlefont_names_cache' );

		if ( self::$google_font_names ) {
			return self::$google_font_names;
		}

		self::$google_font_names = $this->get_names_array();

		self::$google_font_names = apply_filters( 'thim_customizer_fonts_google_font_names', self::$google_font_names );

		$cache_time = apply_filters( 'thim_customizer_googlefont_names_transient_time', HOUR_IN_SECONDS );
		set_site_transient( 'thim_customizer_googlefont_names_cache', self::$google_font_names, $cache_time );

		return self::$google_font_names;
	}

	public function get_google_fonts_by_args( $args = array() ) {
		$cache_name = 'thim_customizer_googlefonts_' . md5( wp_json_encode( $args ) );
		$cache      = get_site_transient( $cache_name );

		if ( $cache ) {
			return $cache;
		}

		$args['sort'] = isset( $args['sort'] ) ? $args['sort'] : 'alpha';

		$fonts         = $this->get_array();
		$ordered_fonts = $fonts['order'][ $args['sort'] ];

		if ( isset( $args['count'] ) ) {
			$ordered_fonts = array_slice( $ordered_fonts, 0, $args['count'] );
			set_site_transient( $cache_name, $ordered_fonts, HOUR_IN_SECONDS );
			return $ordered_fonts;
		}

		set_site_transient( $cache_name, $ordered_fonts, HOUR_IN_SECONDS );

		return $ordered_fonts;
	}

	public function is_google_font( $fontname ) {
		if ( is_string( $fontname ) ) {
			$fonts = $this->get_google_fonts();

			return isset( $fonts[ $fontname ] );
		}

		return false;
	}
}
