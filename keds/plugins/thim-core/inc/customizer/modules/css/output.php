<?php
namespace ThimPress\Customizer\Modules\CSS;

class Output {

	protected $output = [];

	protected $styles = [];

	protected $field = [];

	protected $value;

	public function __construct( $config_id, $output, $value, $field ) {
		$this->value  = $value;
		$this->output = $output;
		$this->field  = $field;

		$this->parse_output();
	}

	protected function apply_sanitize_callback( $output, $value ) {
		if ( isset( $output['sanitize_callback'] ) && null !== $output['sanitize_callback'] ) {
			if ( ! is_callable( $output['sanitize_callback'] ) ) {
				return $value;
			}

			return call_user_func( $output['sanitize_callback'], $this->value );
		}

		return $value;
	}

	protected function apply_value_pattern( $output, $value ) {
		if ( isset( $output['value_pattern'] ) && is_string( $output['value_pattern'] ) ) {
			if ( ! is_array( $value ) ) {
				$value = str_replace( '$', $value, $output['value_pattern'] );
			}

			if ( is_array( $value ) ) {
				foreach ( array_keys( $value ) as $value_k ) {
					if ( is_array( $value[ $value_k ] ) ) {
						continue;
					}
					if ( isset( $output['choice'] ) ) {
						if ( $output['choice'] === $value_k ) {
							$value[ $output['choice'] ] = str_replace( '$', $value[ $output['choice'] ], $output['value_pattern'] );
						}
						continue;
					}

					$value[ $value_k ] = str_replace( '$', $value[ $value_k ], $output['value_pattern'] );
				}
			}

			$value = $this->apply_pattern_replace( $output, $value );
		}

		return $value;
	}

	protected function apply_pattern_replace( $output, $value ) {
		if ( isset( $output['pattern_replace'] ) && is_array( $output['pattern_replace'] ) ) {
			$option_type = ( isset( $this->field['option_type'] ) ) ? $this->field['option_type'] : 'theme_mod';
			$option_name = ( isset( $this->field['option_name'] ) ) ? $this->field['option_name'] : '';
			$options     = [];

			if ( $option_name ) {
				$options = ( 'site_option' === $option_type ) ? get_site_option( $option_name ) : get_option( $option_name );
			}

			foreach ( $output['pattern_replace'] as $search => $replace ) {
				$replacement = '';
				switch ( $option_type ) {
					case 'option':
						if ( is_array( $options ) ) {
							if ( $option_name ) {
								$subkey      = str_replace( [ $option_name, '[', ']' ], '', $replace );
								$replacement = ( isset( $options[ $subkey ] ) ) ? $options[ $subkey ] : '';
								break;
							}
							$replacement = ( isset( $options[ $replace ] ) ) ? $options[ $replace ] : '';
							break;
						}
						$replacement = get_option( $replace );
						break;
					case 'site_option':
						$replacement = ( is_array( $options ) && isset( $options[ $replace ] ) ) ? $options[ $replace ] : get_site_option( $replace );
						break;
					case 'user_meta':
						$user_id = get_current_user_id();
						if ( $user_id ) {
							$replacement = get_user_meta( $user_id, $replace, true );
						}
						break;
					default:
						$replacement = get_theme_mod( $replace );
						if ( ! $replacement ) {
							$replacement = Values::get_value( $this->field['thim_config'], $replace );
						}
				}

				$replacement = ( false === $replacement ) ? '' : $replacement;

				if ( is_array( $value ) ) {
					foreach ( $value as $k => $v ) {
						$_val        = ( isset( $value[ $v ] ) ) ? $value[ $v ] : $v;
						$value[ $k ] = str_replace( $search, $replacement, $_val );
					}
					return $value;
				}

				$value = str_replace( $search, $replacement, $value );
			}
		}

		return $value;
	}

	protected function parse_output() {
		foreach ( $this->output as $output ) {
			$skip = false;

			$value = $this->apply_sanitize_callback( $output, $this->value );

			if ( '' === $this->value ) {
				$skip = true;
			}

			if ( isset( $output['exclude'] ) && is_array( $output['exclude'] ) ) {
				foreach ( $output['exclude'] as $exclude ) {
					if ( is_array( $value ) ) {
						if ( is_array( $exclude ) ) {
							$diff1 = array_diff( $value, $exclude );
							$diff2 = array_diff( $exclude, $value );

							if ( empty( $diff1 ) && empty( $diff2 ) ) {
								$skip = true;
							}
						}

						if ( isset( $output['choice'] ) && isset( $value[ $output['choice'] ] ) && $exclude == $value[ $output['choice'] ] ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
							$skip = true;
						}
					}

					if ( $skip ) {
						continue;
					}

					if ( $exclude === $value || ( '' === $exclude && empty( $value ) ) ) {
						$skip = true;
					}
				}
			}

			if ( $skip ) {
				continue;
			}

			$value = $this->apply_value_pattern( $output, $value );

			if ( isset( $output['element'] ) && is_array( $output['element'] ) ) {
				$output['element'] = array_unique( $output['element'] );
				sort( $output['element'] );
				$output['element'] = implode( ',', $output['element'] );
			}

			$value = $this->process_value( $value, $output );

			if ( is_admin() ) {
				if ( ! isset( $_GET['editor'] ) || 1 !== (int) $_GET['editor'] ) {
					continue;
				}
			} else {
				if ( isset( $output['context'] ) && ! in_array( 'front', $output['context'], true ) ) {
					continue;
				}
			}


			if ( isset( $_GET['editor'] ) && 1 === (int) $_GET['editor'] ) {
				if ( isset( $output['element'] ) && ! empty( $output['element'] ) ) {

					if ( -1 < strpos( $output['element'], ',' ) ) {
						$elms = explode( ',', $output['element'] );

						foreach ( $elms as $index => $elm ) {
							if ( ! empty( $elm ) ) {
								$elms[ $index ] = '.editor-styles-wrapper ' . $elm;
								$elms[ $index ] = str_ireplace( '.editor-styles-wrapper :root', '.editor-styles-wrapper', $elms[ $index ] );
							}
						}

						$output['element'] = implode( ',', $elms );
					} else {
						$output['element'] = '.editor-styles-wrapper ' . $output['element'];
						$output['element'] = str_ireplace( '.editor-styles-wrapper :root', '.editor-styles-wrapper', $output['element'] );
					}
				}
			}

			$this->process_output( $output, $value );
		}
	}

	protected function process_output( $output, $value ) {
		$output = apply_filters( 'thim_customizer_output_item_args', $output, $value, $this->output, $this->field );

		if ( ! isset( $output['element'] ) || ! isset( $output['property'] ) ) {
			return;
		}

		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
		$output['prefix']      = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
		$output['units']       = ( isset( $output['units'] ) ) ? $output['units'] : '';
		$output['suffix']      = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';

		$accepts_multiple = [
			'background-image',
			'background',
		];

		if ( in_array( $output['property'], $accepts_multiple, true ) ) {
			if ( isset( $this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] ) && ! is_array( $this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] ) ) {
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = (array) $this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ];
			}

			$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ][] = $output['prefix'] . $value . $output['units'] . $output['suffix'];

			return;
		}

		if ( is_string( $value ) || is_numeric( $value ) ) {
			$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value ) . $output['units'] . $output['suffix'];
		}
	}

	protected function process_property_value( $property, $value ) {
		$properties = apply_filters(
			'thim_customizer_output_property_classnames',
			[
				'font-family'         => '\ThimPress\Customizer\Modules\CSS\Property\Fontfamily',
				'background-image'    => '\ThimPress\Customizer\Modules\CSS\Property\Backgroundimage',
				'background-position' => '\ThimPress\Customizer\Modules\CSS\Property\Backgroundposition',
			]
		);
		if ( array_key_exists( $property, $properties ) ) {
			$classname = $properties[ $property ];
			$obj       = new $classname( $property, $value );
			return $obj->get_value();
		}
		return $value;
	}

	protected function process_value( $value, $output ) {
		if ( isset( $output['property'] ) ) {
			return $this->process_property_value( $output['property'], $value );
		}
		return $value;
	}


	public function get_styles() {
		return $this->styles;
	}
}
