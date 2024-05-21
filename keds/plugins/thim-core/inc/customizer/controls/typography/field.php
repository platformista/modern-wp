<?php
namespace ThimPress\Customizer\Field;

use ThimPress\Customizer\Modules\Field;

class Typography extends Field {

	public $type = 'thim-typography';

	private static $fonts_var_added = false;

	private static $preview_var_added = false;

	private static $typography_controls = array();

	private static $std_variants;

	private static $complete_variants;

	private static $complete_variant_labels = array();

	public function init( $args = array() ) {

		self::$typography_controls[] = $args['id'];

		self::$std_variants = array(
			array(
				'value' => 'regular',
				'label' => 'Regular',
			),
			array(
				'value' => 'italic',
				'label' => 'Italic',
			),
			array(
				'value' => '500',
				'label' => '500',
			),
			array(
				'value' => '500italic',
				'label' => '500 Italic',
			),
			array(
				'value' => '600',
				'label' => '600',
			),
			array(
				'value' => '600italic',
				'label' => '600 Italic',
			),
			array(
				'value' => '700',
				'label' => '700',
			),
			array(
				'value' => '700italic',
				'label' => '700 Italic',
			),
		);

		self::$complete_variants = array(
			array(
				'value' => 'regular',
				'label' => 'Regular',
			),
			array(
				'value' => 'italic',
				'label' => 'Italic',
			),
			array(
				'value' => '100',
				'label' => '100',
			),
			array(
				'value' => '100italic',
				'label' => '100 Italic',
			),
			array(
				'value' => '200',
				'label' => '200',
			),
			array(
				'value' => '200italic',
				'label' => '200 Italic',
			),
			array(
				'value' => '300',
				'label' => '300',
			),
			array(
				'value' => '300italic',
				'label' => '300 Italic',
			),
			array(
				'value' => '500',
				'label' => '500',
			),
			array(
				'value' => '500italic',
				'label' => '500 Italic',
			),
			array(
				'value' => '600',
				'label' => '600',
			),
			array(
				'value' => '600italic',
				'label' => '600 Italic',
			),
			array(
				'value' => '700',
				'label' => '700',
			),
			array(
				'value' => '700italic',
				'label' => '700 Italic',
			),
			array(
				'value' => '800',
				'label' => '800',
			),
			array(
				'value' => '800italic',
				'label' => '800 Italic',
			),
			array(
				'value' => '900',
				'label' => '900',
			),
			array(
				'value' => '900italic',
				'label' => '900 Italic',
			),
		);

		foreach ( self::$complete_variants as $variants ) {
			self::$complete_variant_labels[ $variants['value'] ] = $variants['label'];
		}

		$this->add_sub_fields( $args );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ) );
	}

	public function enqueue_control_scripts() {
		wp_localize_script( 'thim-customizer-control', 'thimTypographyControls', self::$typography_controls );

		$args = $this->args;

		$variants = array();

		if ( isset( $args['choices'] ) && isset( $args['choices']['fonts'] ) && isset( $args['choices']['fonts']['families'] ) ) {
			foreach ( $args['choices']['fonts']['families'] as $font_family_key => $font_family_value ) {
				foreach ( $font_family_value['children'] as $font_family ) {
					if ( isset( $args['choices']['fonts']['variants'] ) && isset( $args['choices']['fonts']['variants'][ $font_family['id'] ] ) ) {
						if ( ! isset( $variants[ $font_family['id'] ] ) ) {
							$variants[ $font_family['id'] ] = array();
						}

						foreach ( $args['choices']['fonts']['variants'][ $font_family['id'] ] as $custom_variant ) {
							if ( isset( self::$complete_variant_labels[ $custom_variant ] ) ) {
								array_push(
									$variants[ $font_family['id'] ],
									array(
										'value' => $custom_variant,
										'label' => self::$complete_variant_labels[ $custom_variant ],
									)
								);
							}
						}
					}
				}
			}
		}

		if ( ! isset( $args['choices']['fonts'] ) || ! isset( $args['choices']['fonts']['standard'] ) ) {
			$standard_fonts = self::get_standard_fonts();

			foreach ( $standard_fonts as $font ) {
				if ( isset( $font['variants'] ) ) {
					if ( ! isset( $variants[ $font['stack'] ] ) ) {
						$variants[ $font['stack'] ] = array();
					}

					foreach ( $font['variants'] as $std_variant ) {
						if ( isset( self::$complete_variant_labels[ $std_variant ] ) ) {
							array_push(
								$variants[ $font['stack'] ],
								array(
									'value' => $std_variant,
									'label' => self::$complete_variant_labels[ $std_variant ],
								)
							);
						}
					}
				}
			}
		} elseif ( is_array( $args['choices']['fonts']['standard'] ) ) {
			foreach ( $args['choices']['fonts']['standard'] as $key => $val ) {
				$key = ( is_int( $key ) ) ? $val : $key;

				if ( isset( $val['variants'] ) ) {
					if ( ! isset( $variants[ $key ] ) ) {
						$variants[ $key ] = array();
					}

					foreach ( $val['variants'] as $std_variant ) {
						if ( isset( self::$complete_variant_labels[ $std_variant ] ) ) {
							array_push(
								$variants[ $key ],
								array(
									'value' => $std_variant,
									'label' => self::$complete_variant_labels[ $std_variant ],
								)
							);
						}
					}
				}
			}
		}

		if ( ! self::$fonts_var_added ) {
			wp_localize_script(
				'thim-customizer-control',
				'thimFontVariants',
				array(
					'standard' => self::$std_variants,
					'complete' => self::$complete_variants,
				)
			);

			$google = new \ThimPress\Customizer\Utils\GoogleFonts();

			wp_localize_script( 'thim-customizer-control', 'thimGoogleFonts', $google->get_array() );
			wp_add_inline_script( 'thim-customizer-control', 'var thimCustomVariants = {};', 'before' );

			self::$fonts_var_added = true;
		}

		$custom_variant_key   = str_ireplace( ']', '', $args['id'] );
		$custom_variant_key   = str_ireplace( '[', '_', $custom_variant_key );
		$custom_variant_value = wp_json_encode( \ThimPress\Customizer\Utils\Helper::prepare_php_array_for_js( $variants ) );

		wp_add_inline_script(
			'thim-customizer-control',
			'thimCustomVariants["' . $custom_variant_key . '"] = ' . $custom_variant_value . ';',
			$variants
		);
	}

	public static function get_standard_fonts() {
		$standard = array(
			'serif'      => array(
				'label' => 'Serif',
				'stack' => 'Georgia,Times,"Times New Roman",serif',
			),
			'sans-serif' => array(
				'label' => 'Sans Serif',
				'stack' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
			),
			'monospace'  => array(
				'label' => 'Monospace',
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
			),
		);

		// Filter backwards compatibility.
		$standard = apply_filters( 'kirki/fonts/standard_fonts', $standard );

		return apply_filters( 'thim_customizer_fonts_standard_fonts', $standard );
	}

	private function add_sub_fields( $args ) {
		$args['thim_config'] = isset( $args['thim_config'] ) ? $args['thim_config'] : 'global';

		$defaults = isset( $args['default'] ) ? $args['default'] : array();

		new \ThimPress\Customizer\Field\Generic(
			wp_parse_args(
				array(
					'sanitize_callback' => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : array( __CLASS__, 'sanitize' ),
					'wrapper_opts'      => array(
						'gap' => 'small',
					),
					'input_attrs'       => '',
					'choices'           => array(
						'type'        => 'hidden',
						'parent_type' => 'thim-typography',
					),
				),
				$args
			)
		);

		$args['parent_setting'] = $args['id'];
		$args['output']         = array();
		$args['wrapper_attrs']  = array(
			'data-thim-parent-control-type' => 'thim-typography',
			'class' => $args['wrapper_attrs']['class'] ?? '{default_class}',
		);

		if ( isset( $args['transport'] ) && 'auto' === $args['transport'] ) {
			$args['transport'] = 'postMessage';
		}

		if ( isset( $args['default']['font-family'] ) ) {
			new \ThimPress\Customizer\Field\Select(
				wp_parse_args(
					array(
						'label'       => 'Font Family',
						'description' => '',
						'id'          => $args['id'] . '[font-family]',
						'default'     => isset( $args['default']['font-family'] ) ? $args['default']['font-family'] : '',
						'input_attrs' => $this->filter_preferred_choice_setting( 'input_attrs', 'font-family', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'thim-typography-subcontrol-type' => 'font-family',
							),
							$args['wrapper_attrs']
						),
						'choices'     => array(),
						'css_vars'    => array(),
						'output'      => array(),
					),
					$args
				)
			);

			$font_variant = isset( $args['default']['variant'] ) ? (array) $args['default']['variant'] : array( 'regular' );

			if ( isset( $args['default']['font-variant'] ) ) {
				$font_variant = 400 === $args['default']['font-variant'] || '400' === $args['default']['font-variant'] ? array( 'regular' ) : (array) $args['default']['font-variant'];
			}

			new \ThimPress\Customizer\Field\Select(
				wp_parse_args(
					array(
						'label'       => 'Font Family Variants',
						'description' => '',
						'id'          => $args['id'] . '[family-variant]',
						'default'     => apply_filters( 'thim_customizer_typography_family_variants_default', $font_variant, $args['id'] ),
						'tooltip'     => 'Use for font family Google Font API',
						'input_attrs' => $this->filter_preferred_choice_setting( 'input_attrs', 'family-variant', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'thim-typography-subcontrol-type' => 'font-family-variant',
							),
							$args['wrapper_attrs']
						),
						'multiple'    => true,
						'choices'     => array(),
						'css_vars'    => array(),
						'output'      => array(),
					),
					$args
				)
			);

			$font_weight = isset( $args['default']['variant'] ) ? $args['default']['variant'] : 'regular';

			if ( isset( $args['default']['font-weight'] ) ) {
				$font_weight = 400 === $args['default']['font-weight'] || '400' === $args['default']['font-weight'] ? 'regular' : $args['default']['font-weight'];
			}

			new \ThimPress\Customizer\Field\Select(
				wp_parse_args(
					array(
						'label'         => 'Font Weight',
						'description'   => '',
						'id'            => $args['id'] . '[variant]',
						'default'       => $font_weight,
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'variant', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'thim-typography-subcontrol-type' => 'font-variant',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'choices'       => array(),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		} else {

			if ( isset( $defaults['variant'] ) ) {
				new \ThimPress\Customizer\Field\Select(
					wp_parse_args(
						array(
							'label'         => 'Font Weight',
							'description'   => '',
							'id'            => $args['id'] . '[variant]',
							'default'       => $defaults['variant'],
							'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'variant', $args ),
							'wrapper_attrs' => wp_parse_args(
								array(
									'thim-typography-subcontrol-type' => 'font-variant',
									'class'                           => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
								),
								$args['wrapper_attrs']
							),
							'choices'       => array(),
							'css_vars'      => array(),
							'output'        => array(),
						),
						$args
					)
				);
			}
		}

		if ( isset( $defaults['font-size'] ) ) {
			new \ThimPress\Customizer\Field\Dimension(
				wp_parse_args(
					array(
						'label'         => 'Font Size',
						'description'   => '',
						'id'            => $args['id'] . '[font-size]',
						'default'       => $args['default']['font-size'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'font-size', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'font-size',
								'thim-typography-subcontrol-type' => 'font-size',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'choices'       => array(),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['color'] ) ) {
			new \ThimPress\Customizer\Field\Color(
				wp_parse_args(
					array(
						'label'         => 'Font Color',
						'description'   => '',
						'id'            => $args['id'] . '[color]',
						'default'       => $args['default']['color'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'color', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'color',
								'thim-typography-subcontrol-type' => 'color',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'choices'       => array(
							'alpha'       => true,
							'label_style' => 'top',
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['text-align'] ) ) {
			new \ThimPress\Customizer\Field\Select(
				wp_parse_args(
					array(
						'label'         => 'Text Align',
						'description'   => '',
						'id'            => $args['id'] . '[text-align]',
						'default'       => $args['default']['text-align'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'text-align', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'text-align',
								'thim-typography-subcontrol-type' => 'text-align',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'choices'       => array(
							'initial' => 'Initial',
							'left'    => 'Left',
							'center'  => 'Center',
							'right'   => 'Right',
							'justify' => 'Justify',
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['text-transform'] ) ) {
			new \ThimPress\Customizer\Field\Select(
				wp_parse_args(
					array(
						'label'         => 'Text Transform',
						'description'   => '',
						'id'            => $args['id'] . '[text-transform]',
						'default'       => $args['default']['text-transform'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'text-transform', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'text-transform',
								'thim-typography-subcontrol-type' => 'text-transform',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'choices'       => array(
							'none'       => 'None',
							'capitalize' => 'Capitalize',
							'uppercase'  => 'Uppercase',
							'lowercase'  => 'Lowercase',
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['text-decoration'] ) ) {
			new \ThimPress\Customizer\Field\Select(
				wp_parse_args(
					array(
						'label'         => 'Text Decoration',
						'description'   => '',
						'id'            => $args['id'] . '[text-decoration]',
						'default'       => $args['default']['text-decoration'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'text-decoration', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'text-decoration',
								'thim-typography-subcontrol-type' => 'text-decoration',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'choices'       => array(
							'none'         => 'None',
							'underline'    => 'Underline',
							'line-through' => 'Line Through',
							'overline'     => 'Overline',
							'solid'        => 'Solid',
							'wavy'         => 'Wavy',
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['line-height'] ) ) {
			new \ThimPress\Customizer\Field\Dimension(
				wp_parse_args(
					array(
						'label'         => 'Line Height',
						'description'   => '',
						'id'            => $args['id'] . '[line-height]',
						'default'       => $args['default']['line-height'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'line-height', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'line-height',
								'thim-typography-subcontrol-type' => 'line-height',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['letter-spacing'] ) ) {
			new \ThimPress\Customizer\Field\Dimension(
				wp_parse_args(
					array(
						'label'         => 'Letter Spacing',
						'description'   => '',
						'id'            => $args['id'] . '[letter-spacing]',
						'default'       => $args['default']['letter-spacing'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'letter-spacing', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'letter-spacing',
								'thim-typography-subcontrol-type' => 'letter-spacing',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['margin-top'] ) ) {
			new \ThimPress\Customizer\Field\Dimension(
				wp_parse_args(
					array(
						'label'         => 'Margin Top',
						'description'   => '',
						'id'            => $args['id'] . '[margin-top]',
						'default'       => $args['default']['margin-top'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'margin-top', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'margin-top',
								'thim-typography-subcontrol-type' => 'margin-top',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		if ( isset( $defaults['margin-bottom'] ) ) {
			new \ThimPress\Customizer\Field\Dimension(
				wp_parse_args(
					array(
						'label'         => 'Margin Bottom',
						'description'   => '',
						'id'            => $args['id'] . '[margin-bottom]',
						'default'       => $args['default']['margin-bottom'],
						'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', 'margin-bottom', $args ),
						'wrapper_attrs' => wp_parse_args(
							array(
								'data-thim-typography-css-prop' => 'margin-bottom',
								'thim-typography-subcontrol-type' => 'margin-bottom',
								'class' => $args['wrapper_attrs']['class'] . ' thim-group-item thim-w50',
							),
							$args['wrapper_attrs']
						),
						'css_vars'      => array(),
						'output'        => array(),
					),
					$args
				)
			);
		}

		new \ThimPress\Customizer\Field\Custom(
			wp_parse_args(
				array(
					'label'       => '',
					'description' => '',
					'id'          => $args['id'] . '[custom_line_bottom]',
					'default'     => '<hr />',
					'choices'     => array(),
					'css_vars'    => array(),
					'output'      => array(),
				),
				$args
			)
		);
	}

	public static function sanitize( $value ) {
		if ( ! is_array( $value ) ) {
			return array();
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family'] = sanitize_text_field( $val );
					break;

				case 'variant':
					$value['variant'] = ( 400 === $val || '400' === $val ) ? 'regular' : $val;

					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( 'regular' === $value['variant'] || 'italic' === $value['variant'] ) ? '400' : (string) absint( $value['font-weight'] );

					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}

					break;

				case 'text-align':
					if ( ! in_array( $val, array( '', 'inherit', 'left', 'center', 'right', 'justify' ), true ) ) {
						$value['text-align'] = '';
					}

					break;

				case 'text-transform':
					if ( ! in_array( $val, array( '', 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ), true ) ) {
						$value['text-transform'] = '';
					}

					break;

				case 'text-decoration':
					if ( ! in_array( $val, array( '', 'none', 'underline', 'overline', 'line-through', 'solid', 'wavy', 'initial', 'inherit' ), true ) ) {
						$value['text-transform'] = '';
					}

					break;

				case 'color':
					$value['color'] = '' === $value['color'] ? '' : \ThimPress\Customizer\Field\Color::sanitize( $value['color'] );
					break;

				default:
					$value[ $key ] = sanitize_text_field( $value[ $key ] );
			}
		}

		return $value;
	}

	public function filter_preferred_choice_setting( $setting, $choice, $args ) {
		if ( ! isset( $args[ $setting ] ) ) {
			return '';
		}

		if ( isset( $args[ $setting ][ $choice ] ) ) {
			return $args[ $setting ][ $choice ];
		}

		foreach ( $args['choices'] as $id => $set ) {
			if ( $id !== $choice && isset( $args[ $setting ][ $id ] ) ) {
				unset( $args[ $setting ][ $id ] );
			} elseif ( ! isset( $args[ $setting ][ $id ] ) ) {
				$args[ $setting ] = '';
			}
		}

		return $args[ $setting ];
	}

	private function get_font_family_choices() {
		$args = $this->args;

		$sorting   = 'alpha';
		$max_fonts = 9999;
		$google    = new \ThimPress\Customizer\Utils\GoogleFonts();

		if ( isset( $args['choices'] ) && isset( $args['choices']['fonts'] ) && isset( $args['choices']['fonts']['google'] ) && ! empty( $args['choices']['fonts']['google'] ) ) {
			if ( in_array( $args['choices']['fonts']['google'][0], array( 'alpha', 'popularity', 'trending' ), true ) ) {
				$sorting = $args['choices']['fonts']['google'][0];

				if ( isset( $args['choices']['fonts']['google'][1] ) && is_int( $args['choices']['fonts']['google'][1] ) ) {
					$max_fonts = (int) $args['choices']['fonts']['google'][1];
				}

				$g_fonts = $google->get_google_fonts_by_args(
					array(
						'sort'  => $sorting,
						'count' => $max_fonts,
					)
				);
			} else {
				$g_fonts = $args['choices']['fonts']['google'];
			}
		} else {
			$g_fonts = $google->get_google_fonts_by_args(
				array(
					'sort'  => $sorting,
					'count' => $max_fonts,
				)
			);
		}

		$std_fonts = array();

		if ( ! isset( $args['choices']['fonts'] ) || ! isset( $args['choices']['fonts']['standard'] ) ) {
			$standard_fonts = self::get_standard_fonts();

			foreach ( $standard_fonts as $font ) {
				$std_fonts[ $font['stack'] ] = $font['label'];
			}
		} elseif ( is_array( $args['choices']['fonts']['standard'] ) ) {
			foreach ( $args['choices']['fonts']['standard'] as $key => $val ) {
				$key               = ( \is_int( $key ) ) ? $val : $key;
				$std_fonts[ $key ] = $val;
			}
		}

		$choices = array();

		$choices['default'] = array(
			'Defaults',
			apply_filters(
				'thim_customizer_fonts_default_fonts',
				array(
					'' => 'Default',
				)
			),
		);

		if ( isset( $args['choices'] ) && isset( $args['choices']['fonts'] ) && isset( $args['choices']['fonts']['families'] ) ) {
			// Implementing the custom font families.
			foreach ( $args['choices']['fonts']['families'] as $font_family_key => $font_family_value ) {
				if ( ! isset( $choices[ $font_family_key ] ) ) {
					$choices[ $font_family_key ] = array();
				}

				$family_opts = array();

				foreach ( $font_family_value['children'] as $font_family ) {
					$family_opts[ $font_family['id'] ] = $font_family['text'];
				}

				$choices[ $font_family_key ] = array(
					$font_family_value['text'],
					$family_opts,
				);
			}
		}

		$choices['standard'] = array(
			'Standard Fonts',
			$std_fonts,
		);

		$choices['google'] = array(
			'Google Fonts',
			array_combine( array_values( $g_fonts ), array_values( $g_fonts ) ),
		);

		if ( empty( $choices['standard'][1] ) ) {
			$choices = array_combine( array_values( $g_fonts ), array_values( $g_fonts ) );
		} elseif ( empty( $choices['google'][1] ) ) {
			$choices = $std_fonts;
		}

		return $choices;

	}

	private function get_variant_choices() {
		$args    = $this->args;
		$choices = self::$std_variants;

		if ( isset( $args['choices'] ) && isset( $args['choices']['fonts'] ) && isset( $args['choices']['fonts']['families'] ) ) {
			$choices = array();

			foreach ( $args['choices']['fonts']['families'] as $font_family_key => $font_family_value ) {
				foreach ( $font_family_value['children'] as $font_family ) {
					if ( isset( $args['choices']['fonts']['variants'] ) && isset( $args['choices']['fonts']['variants'][ $font_family['id'] ] ) ) {
						foreach ( $args['choices']['fonts']['variants'][ $font_family['id'] ] as $custom_variant ) {
							if ( isset( self::$complete_variant_labels[ $custom_variant ] ) ) {
								array_push(
									$choices,
									array(
										'value' => $custom_variant,
										'label' => self::$complete_variant_labels[ $custom_variant ],
									)
								);
							}
						}
					}
				}
			}
		}

		return $choices;
	}

	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['id'] === $this->args['id'] . '[font-family]' ) {
			$args            = parent::filter_control_args( $args, $wp_customize );
			$args['choices'] = $this->get_font_family_choices();
		}

		if ( $args['id'] === $this->args['id'] . '[variant]' ) {
			$args            = parent::filter_control_args( $args, $wp_customize );
			$args['choices'] = $this->get_variant_choices();
		}

		return $args;
	}

	public function add_setting( $wp_customize ) {}

	public function add_control( $wp_customize ) {}
}
