<?php
namespace ThimPress\Customizer\Modules\Webfonts;

final class Embed {

	protected $webfonts;

	public function __construct( $webfonts ) {
		$this->webfonts = $webfonts;

		add_action( 'wp', [ $this, 'init' ], 9 );
	}

	public function init() {
//		add_action( 'wp_head', [ $this, 'action_preloads' ], 1 );
		add_action( 'thim_customizer_dynamic_css', [ $this, 'the_css' ] );
	}

	public function the_css() {
		$url = $this->webfonts->google_fonts_api_v2_link();

		if ( empty( $url ) ) {
			return;
		}

		$downloader = new Downloader( $url );

		$contents = $downloader->get_styles();

		if ( $contents ) {
			echo wp_strip_all_tags( $contents );
		}
	}

	public function action_preloads() {
		$url = $this->webfonts->google_fonts_api_v2_link();

		if ( empty( $url ) ) {
			return;
		}

		$downloader = new Downloader( $url );

		echo $downloader->action_preload_fonts();
	}
}
