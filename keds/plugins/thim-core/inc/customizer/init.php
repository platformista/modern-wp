<?php
/**
 * New Customizer Class
 *
 * @package WordPress
 * @subpackage New Customizer Class
 * @author Nhamdv
 */

namespace ThimPress\Customizer;

define( 'THIM_CUSTOMIZER_DIR', dirname( __FILE__ ) );
define( 'THIM_CUSTOMIZER_URI', THIM_CORE_URI . '/inc/customizer' );

class Init {

	private static $instance;

	public function __construct() {
		$this->autoload();
		$this->includes();
		$this->register();
		$this->hooks();
	}

	public function register() {
		$classes = array(
			'\ThimPress\Customizer\Modules\Css',
			'\ThimPress\Customizer\Modules\Webfonts',
			'\ThimPress\Customizer\Modules\Dependencies',
			'\ThimPress\Customizer\Modules\Postmessage',
			'\ThimPress\Customizer\Modules\Tooltips',
			'\ThimPress\Customizer\Modules\Loading',
		);

		foreach ( $classes as $class ) {
			if ( class_exists( $class ) ) {
				new $class();
			}
		}
	}

	public function hooks() {
		add_action(
			'customize_preview_init',
			function() {
				$script_info = include THIM_CUSTOMIZER_DIR . '/build/preview.asset.php';

				wp_enqueue_script( 'thim-customizer-control', THIM_CUSTOMIZER_URI . '/build/preview.js', array_merge( $script_info['dependencies'], array( 'jquery', 'customize-preview' ) ), $script_info['version'], true );
			}
		);

		/**
		 * When use Kirki can't set variants mutilple so in theme use 'thim_multiple_variants_fonts' for select variants.
		 * Use this hook to set when customer update thim core use new customizer.
		 *
		 * TODO: Remove this code when Customer use this customizer.
		 */
		add_filter(
			'thim_customizer_typography_family_variants_default',
			function( $variants, $id ) {
				$variant_fallback = get_theme_mod( 'thim_multiple_variants_fonts', array() );
				
				if ( ! empty( $variant_fallback ) ) {
					// Convert '400' to 'regular'.
					$variant_fallback = array_map(
						function( $variant ) {
							if ( $variant === '400' ) {
								return 'regular';
							}
	
							return $variant;
						},
						$variant_fallback
					);

					$variants = array_merge( $variants, $variant_fallback );
				}

				return $variants;
			},
			10,
			2
		);
	}

	public function autoload() {
		require_once wp_normalize_path( THIM_CUSTOMIZER_DIR . '/autoloader.php' );

		$autoloader = new \ThimPress\Customizer\Autoloader();
		$autoloader->add_namespace( 'ThimPress\Customizer\Modules', THIM_CUSTOMIZER_DIR . '/modules/' );
		$autoloader->add_namespace( 'ThimPress\Customizer\Utils', THIM_CUSTOMIZER_DIR . '/utils/' );
		$autoloader->register();
	}

	public function includes() {
		foreach ( glob( THIM_CUSTOMIZER_DIR . '/controls/*/' ) as $control ) {
			if ( file_exists( $control . 'control.php' ) ) {
				require_once wp_normalize_path( $control . 'control.php' );
			}
			if ( file_exists( $control . 'field.php' ) ) {
				require_once wp_normalize_path( $control . 'field.php' );
			}
			if ( file_exists( $control . 'css.php' ) ) {
				require_once wp_normalize_path( $control . 'css.php' );
			}
		}

		// Load Kirki-Font use for in theme.
		require_once wp_normalize_path( THIM_CUSTOMIZER_DIR . '/class-kirki-fonts.php' );
	}

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Init::instance();
