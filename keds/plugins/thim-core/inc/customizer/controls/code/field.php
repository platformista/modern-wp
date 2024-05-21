<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

defined( 'ABSPATH' ) || exit;

class Code extends Field {

	public $type = 'thim-code';

	protected $control_class = '\ThimPress\Customizer\Control\Code';

	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = function( $value ) {
					return $value;
				};
			}
		}

		return $args;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			$args['type'] = 'code_editor';

			$args['input_attrs'] = array(
				'aria-describedby' => 'thim-code editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
			);
			if ( ! isset( $args['choices']['language'] ) ) {
				return;
			}

			$language = $args['choices']['language'];
			switch ( $language ) {
				case 'json':
				case 'xml':
					$language = 'application/' . $language;
					break;
				case 'http':
					$language = 'message/' . $language;
					break;
				case 'js':
				case 'javascript':
					$language = 'text/javascript';
					break;
				case 'txt':
					$language = 'text/plain';
					break;
				case 'css':
				case 'jsx':
				case 'html':
					$language = 'text/' . $language;
					break;
				default:
					$language = ( 'js' === $language ) ? 'javascript' : $language;
					$language = ( 'htm' === $language ) ? 'html' : $language;
					$language = ( 'yml' === $language ) ? 'yaml' : $language;
					$language = 'text/x-' . $language;
					break;
			}
			if ( ! isset( $args['editor_settings'] ) ) {
				$args['editor_settings'] = array();
			}
			if ( ! isset( $args['editor_settings']['codemirror'] ) ) {
				$args['editor_settings']['codemirror'] = array();
			}
			if ( ! isset( $args['editor_settings']['codemirror']['mode'] ) ) {
				$args['editor_settings']['codemirror']['mode'] = $language;
			}

			if ( 'text/x-scss' === $args['editor_settings']['codemirror']['mode'] ) {
				$args['editor_settings']['codemirror'] = array_merge(
					$args['editor_settings']['codemirror'],
					array(
						'lint'              => false,
						'autoCloseBrackets' => true,
						'matchBrackets'     => true,
					)
				);
			}
		}
		
		return $args;
	}
}
