<?php
/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Thim_Builder_Abstract_Config' ) ) {
	/**
	 * Class Thim_Builder_Abstract_Config
	 */
	abstract class Thim_Builder_Abstract_Config {

		/**
		 * @var string
		 */
		public static $group = '';
		/**
		 * @var string
		 */
		public static $template_name = '';

		/**
		 * @var string
		 */
		public static $base = '';

		/**
		 * @var string
		 */
		public static $name = '';

		/**
		 * @var string
		 */
		public static $desc = '';
		/**
		 * @var string
		 */
		public static $icon = '';
		/**
		 * @var array
		 */
		public static $options = array();

		/**
		 * @var string
		 */
		public static $assets_url = '';

		/**
		 * @var string
		 */
		public static $assets_path = '';

		/**
		 * @var array
		 */
		public static $styles = array();

		/**
		 * @var array
		 */
		public static $scripts = array();

		/**
		 * @var array
		 */
		public static $queue_assets = array();

		/**
		 * @var array
		 */
		public static $localize = array();

		/**
		 * Thim_Builder_Abstract_Config constructor.
		 */
		public function __construct() {

			// set group

			self::$group = thim_builder_folder_group() ? thim_builder_get_group( self::$base ) : '';

			self::$assets_url  = TP_THEME_ELEMENTS_THIM_URI . self::$group . '/' . self::$base . '/assets/';
			self::$assets_path = TP_THEME_ELEMENTS_THIM_DIR . self::$group . '/' . self::$base . '/assets/';

			// set options
			self::$options = is_array( $this->get_options() ) ? $this->get_options() : array();
			// set options
			self::$template_name = $this->get_template_name() ? $this->get_template_name() : '';
			// handle std, add default options
			self::$options = apply_filters( "thim-builder/" . self::$base . '/config-options', $this->_handle_options( self::$options ) );

			// set styles
			self::$styles = apply_filters( 'thim-builder/' . self::$base . '/styles', $this->get_styles() );

			// set scripts
			self::$scripts = apply_filters( 'thim-builder/' . self::$base . '/scripts', $this->get_scripts() );
			// set localize
			self::$localize = apply_filters( 'thim-builder/' . self::$base . '/localize', $this->get_localize() );
		}

		/**
		 * @param $options
		 *
		 * @return mixed
		 */
		protected function _handle_options( $options ) {

			foreach ( $options as $key => $option ) {
				if ( ! isset( $option['std'] ) ) {
					$type = $option['type'];

					switch ( $type ) {
						case 'dropdown':
							$values               = ( ! empty( $option['value'] ) && is_array( $option['value'] ) ) ? array_values( $option['value'] ) : '';
							$options[$key]['std'] = $values ? reset( $values ) : '';
							break;
						case 'param_group':
							$options[$key]['params'] = $this->_handle_options( $option['params'] );
							break;
						case 'radio_image':
							$values               = ( ! empty( $option['options'] ) && is_array( $option['options'] ) ) ? array_values( $option['options'] ) : '';
							$options[$key]['std'] = $values ? reset( $values ) : '';
							break;
						default:
							$options[$key]['std'] = '';
							break;
					}
				}
			}

			return $options;
		}

		/**
		 * @return array
		 */
		public function get_options() {
			return array();
		}

		public function get_template_name() {

		}

		/**
		 * @return array
		 */
		public function get_styles() {
			return array();
		}

		/**
		 * @return array
		 */
		public function get_scripts() {
			return array();
		}

		/**
		 * @return array
		 */
		public function get_localize() {
			return array();
		}

		/**
		 * @return array
		 */
		public static function _get_assets() {

			$queue_assets = array();

			$prefix = apply_filters( 'thim-builder/prefix-assets', 'thim-core' );

			if ( self::$styles ) {
				// allow hook default folder
				$default_folder_css = apply_filters( 'thim-builder/default-assets-folder', self::$assets_path . 'css/', self::$base );
				$default_url_css    = apply_filters( 'thim-builder/default-assets-folder', self::$assets_url . 'css/', self::$base );

				foreach ( self::$styles as $handle => $args ) {
					$src      = $args['src'];
					$depends  = ( isset( $args['deps'] ) && is_array( $args['deps'] ) ) ? $args['deps'] : array();
					$media    = ! empty( $args['media'] ) ? $args['media'] : 'all';
					$deps_src = isset( $args['deps_src'] ) ? $args['deps_src'] : array();
					if ( file_exists( $default_folder_css . $src ) ) {
						// enqueue depends
						if ( $depends ) {
							foreach ( $depends as $depend ) {
								if ( wp_script_is( $depend ) ) {

									wp_enqueue_style( $depend );
								} else {
									do_action( 'thim-builder/enqueue-depends-styles', self::$base, $depend );
								}
							}
						}

						// add to queue
						$queue_assets['styles'][$prefix . $handle] = array(
							'url'      => $default_url_css . $src,
							'deps'     => $depends,
							'media'    => $media,
							'deps_src' => $deps_src
						);
					}
				}
			}

			if ( self::$scripts ) {
				// allow hook default folder
				$default_folder_js = apply_filters( 'thim-builder/default-assets-folder', self::$assets_path . 'js/', self::$base );
				$default_url_js    = apply_filters( 'thim-builder/default-assets-folder', self::$assets_url . 'js/', self::$base );
				$localized         = false;

				foreach ( self::$scripts as $handle => $args ) {
					$src       = $args['src'];
					$depends   = ! empty( $args['deps'] ) ? $args['deps'] : array();
					$in_footer = isset( $args['in_footer'] ) ? $args['in_footer'] : true;
					$deps_src  = isset( $args['deps_src'] ) ? $args['deps_src'] : array();

					if ( file_exists( $default_folder_js . $src ) ) {
						// enqueue depends
						if ( $depends ) {
							foreach ( $depends as $depend ) {
								if ( wp_script_is( $depend ) && $depend != 'jquery' ) {
									wp_enqueue_script( $depend );
								} else {
									do_action( 'thim-builder/enqueue-depends-scripts', self::$base, $depend );
								}
							}
						}

						// add to queue
						$queue_assets['scripts'][$prefix . $handle] = array(
							'url'       => $default_url_js . $src,
							'deps'      => $depends,
							'in_footer' => $in_footer,
							'deps_src'  => $deps_src
						);

						if ( self::$localize ) {
							foreach ( self::$localize as $name => $data ) {
								$queue_assets['scripts'][$prefix . $handle]['localize'][$name] = $data;
							}
						}

						if ( ! $localized && self::$localize ) {
							foreach ( self::$localize as $name => $data ) {
								wp_localize_script( $prefix . $handle, $name, $data );
							}
							$localized = true;
						}
					}
				}
			}

			return $queue_assets;
		}

		/**
		 * Register scripts
		 */
		public static function register_scripts() {

			$queue = self::_get_assets();

			$localized = false;
			if ( $queue ) {
				foreach ( $queue as $key => $assets ) {
					if ( $key == 'styles' ) {
						if ( ! empty( $args['deps_src'] ) ) {
							foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
								if ( ! wp_script_is( $deps_name, 'registered' ) ) {
									wp_register_style( $deps_name, $deps_src );
								}
							}
						}
						foreach ( $assets as $name => $args ) {
							wp_register_style( $name, $args['url'], $args['deps'], '', $args['media'] );
						}
					} else if ( $key == 'scripts' ) {
						foreach ( $assets as $name => $args ) {
							if ( ! empty( $args['deps_src'] ) ) {
								foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
									if ( ! wp_script_is( $deps_name, 'registered' ) ) {
										wp_register_script( $deps_name, $deps_src );
									}
								}
							}

							wp_register_script( $name, $args['url'], $args['deps'], '', $args['in_footer'] );

							// localize scripts
							if ( ! $localized && isset( $args['localize'] ) ) {
								foreach ( $args['localize'] as $index => $data ) {
									wp_localize_script( $name, $index, $data );
								}
								$localized = true;
							}
						}
					}
				}
			}
		}

		/**
		 * Enqueue scripts.
		 */
		public static function enqueue_scripts() {
			$queue = self::_get_assets();

			if ( $queue ) {
				foreach ( $queue as $key => $assets ) {
					if ( $key == 'styles' ) {
						foreach ( $assets as $name => $args ) {
							if ( ! empty( $args['deps_src'] ) ) {
								foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
									if ( ! wp_script_is( $deps_name, 'registered' ) ) {
										wp_register_style( $deps_name, $deps_src );
									}
								}
							}
							wp_enqueue_style( $name );
						}
					} else if ( $key == 'scripts' ) {
						foreach ( $assets as $name => $args ) {
							if ( ! empty( $args['deps_src'] ) ) {
								foreach ( $args['deps_src'] as $deps_name => $deps_src ) {
									if ( ! wp_script_is( $deps_name, 'registered' ) ) {
										wp_register_script( $deps_name, $deps_src );
									}
								}
							}
							wp_enqueue_script( $name );
						}
					}
				}
			}
		}
		/**
		 * Options to config number items in slider.
		 *
		 * @param array $default
		 * @param array $depends
		 *
		 * @return mixed
		 */
		protected function _number_items_options( $default = array(), $depends = array() ) {

			$options = apply_filters( 'thim-builder/element-default-number-items-slider', array(
				array(
					'type'             => 'number',
					'heading'          => esc_html__( 'Visible Items', 'thim-core' ),
					'param_name'       => 'items_visible',
					'std'              => '4',
					'admin_label'      => true,
					'edit_field_class' => 'vc_col-xs-4',
				),

				array(
					'type'             => 'number',
					'heading'          => esc_html__( 'Tablet Items', 'thim-core' ),
					'param_name'       => 'items_tablet',
					'std'              => '2',
					'admin_label'      => true,
					'edit_field_class' => 'vc_col-xs-4',
				),

				array(
					'type'             => 'number',
					'heading'          => esc_html__( 'Mobile Items', 'thim-core' ),
					'param_name'       => 'items_mobile',
					'std'              => '1',
					'admin_label'      => true,
					'edit_field_class' => 'vc_col-xs-4',
				)
			) );

			// handle default value
			if ( $default ) {
				foreach ( $options as $key => $item ) {
					$name = $item['param_name'];
					if ( array_key_exists( $name, $default ) ) {
						$options[ $key ]['std'] = $default[ $name ];
					}
				}
			}

			// handle dependency
			if ( $depends ) {
				foreach ( $options as $key => $item ) {
					$options[ $key ]['dependency'] = $depends;
				}
			}

			return $options;
		}

	}
}
