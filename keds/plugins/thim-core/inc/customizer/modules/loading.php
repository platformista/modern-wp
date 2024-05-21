<?php
namespace ThimPress\Customizer\Modules;

class Loading {

	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		global $wp_customize;
		
		if ( ! $wp_customize ) {
			return;
		}

		add_action( 'wp_footer', array( $this, 'add_loader_to_footer' ) );
		add_action( 'wp_head', array( $this, 'add_loader_styles_to_header' ), 99 );

		$this->remove_default_loading_styles();
	}

	public function add_loader_to_footer() {
		?>
		<div class="thim-customizer-loading-wrapper">
			<span class="thim-customizer-loading"></span>
		</div>
		<?php
	}

	public function add_loader_styles_to_header() {
		?>
		<style>
			body.wp-customizer-unloading {
				opacity: 1;
				cursor: progress !important;
				-webkit-transition: none;
				transition: none;
			}
			body.wp-customizer-unloading * {
				pointer-events: none !important;
			}
			.thim-customizer-loading-wrapper {
				width: 100%;
				height: 100%;
				position: fixed;
				top: 0;
				left: 0;
				background: rgba(255,255,255,0.83);
				z-index: 999999;
				display: none;
				opacity: 0;
				-webkit-transition: opacity 0.5s;
				transition: opacity 0.5s;
				background-image: url('data:image/png;base64,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');
				background-repeat: no-repeat;
				background-position: center center;
			}
			body.wp-customizer-unloading .thim-customizer-loading-wrapper {
				display: block;
				opacity: 1;
			}
			.thim-customizer-loading-wrapper .thim-customizer-loading {
				position: absolute;
				width: 60px;
				height: 60px;
				top: 50%;
				left: 50%;
				margin: -30px;
				background-color: rgba(0,0,0,.83);
				border-radius: 100%;
				-webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
				animation: sk-scaleout 1.0s infinite ease-in-out;
			}
			@-webkit-keyframes sk-scaleout {
				0% { -webkit-transform: scale(0) }
				100% {
					-webkit-transform: scale(1.0);
					opacity: 0;
				}
			}
			@keyframes sk-scaleout {
				0% {
					-webkit-transform: scale(0);
					transform: scale(0);
				}
				100% {
					-webkit-transform: scale(1.0);
					transform: scale(1.0);
					opacity: 0;
				}
			}
		</style>
		<?php
	}

	public function remove_default_loading_styles() {
		global $wp_customize;

		remove_action( 'wp_head', array( $wp_customize, 'customize_preview_loading_style' ) );
	}
}
