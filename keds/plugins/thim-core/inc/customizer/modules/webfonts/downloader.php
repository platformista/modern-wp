<?php
namespace ThimPress\Customizer\Modules\Webfonts;

// Download all fonts from Google Fonts API to local.
class Downloader {

	protected $url;

	protected $filesystem;

	protected $font_folder = 'thim-fonts';

	public function __construct( $url ) {
		$this->url = $url;
		$this->filesystem = $this->get_filesystem();
	}

	public function action_preload_fonts() {
		$fonts = $this->get_fonts_local();

		$preloads = array();

		foreach ( $fonts as $font ) {
			if ( ! empty( $font['url'] ) && ! empty( $font['format'] ) ) {
				$preloads[] = '<link rel="preload" href="' . $font['url'] . '" as="font" type="font/' . $font['format'] . '" crossorigin="anonymous">';
			}
		}

		return implode( "\n", $preloads );
	}

	public function get_styles() {
		$styles = $this->get_content_cache();

		$fonts = $this->get_fonts_local();

		// replace src google fonts to local fonts in $styles.
		foreach ( $fonts as $font ) {
			$styles = str_replace(
				$font['src'],
				$font['url'],
				$styles
			);
		}

		return $styles;
	}

	protected function get_fonts_local() {
		$fonts = $this->download_fonts_to_local();

		// Add file url to fonts.
		$fonts = array_map(
			function( $font ) {
				$font['url'] = $this->get_font_url( $font['name'], $font['folder'] );
				return $font;
			},
			$fonts
		);

		return $fonts;
	}

	protected function get_font_url( $font_file_name, $font_family_folder ) {
		$upload_dir = wp_upload_dir();
		$fonts_dir  = $upload_dir['baseurl'] . '/' . $this->font_folder;

		return $fonts_dir . '/' . $font_family_folder . '/' . $font_file_name;
	}

	public function download_fonts_to_local() {
		$fonts = $this->get_files_from_contents();

		$stored = get_option( 'thim_customizer_downloaded_ggfont_files', array() );
		$stored_names = array();
		$change     = false;

		if ( ! empty( $stored ) ) {
			$stored_names = array_map(
				function( $font ) {
					return $font['name'];
				},
				$stored
			);
		}

		// download fonts to folder fonts in wp_content.
		$upload_dir = wp_upload_dir();
		$fonts_dir  = $upload_dir['basedir'] . '/' . $this->font_folder;

		if ( ! file_exists( $fonts_dir ) ) {
			wp_mkdir_p( $fonts_dir );
		}

		foreach ( $fonts as $font ) {
			if ( in_array( $font['name'], $stored_names ) ) {
				continue;
			}

			// create folder font-family if not exists.
			$font_family_dir = $fonts_dir . '/' . $font['folder'];

			if ( ! file_exists( $font_family_dir ) ) {
				wp_mkdir_p( $font_family_dir );
			}

			$font_file_path = $font_family_dir . '/' . $font['name'];

			if ( ! file_exists( $font_file_path ) ) {
				$font_file_contents = $this->get_font_file_contents( $font['src'] );

				if ( $font_file_contents ) {
					$this->filesystem->put_contents( $font_file_path, $font_file_contents );
				}
			}

			// update file path.
			$font['path'] = $font_file_path;
			$stored[] = $font;
			$change   = true;
		}

		if ( $change ) {
			update_option( 'thim_customizer_downloaded_ggfont_files', $stored );
		}

		return $stored;
	}

	private function get_font_file_contents( $font_src ) {
		$font_src = str_replace( 'https://', 'http://', $font_src );

		$response = wp_remote_get(
			$font_src,
			array(
				'timeout' => 30,
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$contents = wp_remote_retrieve_body( $response );

		if ( is_wp_error( $contents ) || empty( $contents ) ) {
			return false;
		}

		return $contents;
	}

	public function get_files_from_contents() {
		$contents = $this->get_content_cache();

		// $content: /* cyrillic-ext */ @font-face { font-family: 'Open Sans'; font-style: italic; font-weight: 500; font-stretch: normal; font-display: swap; src: url(https://fonts.gstatic.com/s/opensans/v35/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk_RkWV0exoMUdjFnmiU_.woff) format('woff'); unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F; } /* cyrillic */ @font-face { font-family: 'Open Sans'; font-style: italic; font-weight: 500; font-stretch: normal; font-display: swap; src: url(https://fonts.gstatic.com/s/opensans/v35/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk_RkWVQexoMUdjFnmiU_.woff) format('woff'); unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116; }
		// get all font-face in $contents.
		$font_faces = explode( '@font-face', $contents );

		// remove first element.
		array_shift( $font_faces );

		$fonts = array();

		foreach ( $font_faces as $font_face ) {
			$fonts = array_merge( $fonts, $this->get_fonts_from_font_face( $font_face ) );
		}

		return $fonts;
	}

	private function get_fonts_from_font_face( $font_face ) {
		// get font-family.
		$pattern = '/font-family:\s*\'(.*)\';/i';
		preg_match( $pattern, $font_face, $matches );

		$font_family = $matches[1];

		// get font-weight.
		$pattern = '/font-weight:\s*(.*);/i';
		preg_match( $pattern, $font_face, $matches );

		$font_weight = $matches[1];

		// get font-style.
		$pattern = '/font-style:\s*(.*);/i';
		preg_match( $pattern, $font_face, $matches );

		$font_style = $matches[1];

		// get font-display.
		$pattern = '/font-display:\s*(.*);/i';
		preg_match( $pattern, $font_face, $matches );

		$font_display = $matches[1];

		// get src.
		$pattern = '/src:\s*url\((.*)\)\s*format\(\'(.*)\'\);/i';
		preg_match( $pattern, $font_face, $matches );

		$font_src    = $matches[1];
		$font_format = $matches[2];

		// font_name get file name in font_src.
		$file_name  = basename( $font_src );

		$folder_name = explode( '/', $font_src );
		$folder_name = $folder_name[4];

		$font = array(
			'name'   => $file_name,
			// 'family' => $font_family,
			'folder' => $folder_name,
			// 'weight' => $font_weight,
			// 'style'  => $font_style,
			'src'    => $font_src,
			'format' => $font_format,
		);

		return array( $font );
	}

	public function get_content_cache() {
		$cache = get_site_transient( 'thim_customizer_ggfonts_content_cache' );

		$cache_key = md5( $this->url );

		if ( ! empty( $cache[ $cache_key ] ) ) {
			return $cache[ $cache_key ];
		}

		$contents = $this->get_google_api_contents();

		if ( $contents ) {
			$cache[ $cache_key ] = $contents;
			set_site_transient( 'thim_customizer_ggfonts_content_cache', $cache, 60 * 60 * 24 * 7 );
		}

		return $contents;
	}

	protected function get_google_api_contents() {
		$user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36';

		$response = wp_remote_get(
			$this->url,
			array(
				'timeout'    => 30,
				'user-agent' => $user_agent,
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$contents = wp_remote_retrieve_body( $response );

		if ( is_wp_error( $contents ) || empty( $contents ) ) {
			return false;
		}

		return $contents;
	}

	protected function get_filesystem() {
		global $wp_filesystem;
		if ( ! $wp_filesystem ) {
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
			}
			WP_Filesystem();
		}
		return $wp_filesystem;
	}

}
