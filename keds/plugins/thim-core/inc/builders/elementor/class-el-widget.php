<?php
/**
 * Thim_Builder Elementor widget class
 *
 * @version     1.0.0
 * @author      Thim_Builder
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, leehld
 */

//namespace Thim_Builder;

use \Elementor\Widget_Base;

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_El_Widget' ) ) {
	/**
	 * Class Thim_Builder_El_Widget
	 */
	abstract class Thim_Builder_El_Widget extends Widget_Base {

		/**
		 * @var string
		 */
		protected $config_class = '';
		/**
		 * @var string
		 */
		protected $config_base = '';
		/**
		 * @var null
		 */
		protected $keywords = array();

		/**
		 * @var null
		 */
		protected $class = null;

		/**
		 * Thim_Builder_El_Widget constructor.
		 *
		 * @param array      $data
		 * @param array|null $args
		 *
		 * @throws Exception
		 */
		public function __construct( array $data = [], array $args = null ) {

			if ( ! $this->config_class ) {
				return;
			}
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();
			$config_class::register_scripts();
			add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_scripts' ) );
			add_action( 'elementor/preview/enqueue_scripts', array( $this, 'preview_scripts' ) );
			parent::__construct( $data, $args );
		}

		public function preview_scripts() {
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			$config_class::register_scripts();
		}

		/**
		 * Register scripts
		 */

		/**
		 * @return mixed|string
		 */
		public function get_name() {
			if ( ! empty( $this->config_base ) ) {
				return 'thim-' . $this->config_base;
			} else {
				if ( ! $this->config_class ) {
					return '';
				}
				// config class
				$config_class = new $this->config_class();

				return 'thim-' . $config_class::$base;
			}
		}

		/**
		 * @return mixed|string
		 */
		public function get_icon() {
			if ( ! $this->config_class ) {
				return '';
			}
			// config class
			$config_class = new $this->config_class();

			return $config_class::$icon;
		}

		/**
		 * @return string
		 */
		public function get_base() {
			if ( ! $this->config_class ) {
				return '';
			}

			// config class
			$config_class = new $this->config_class();

			return $config_class::$base;
		}

		/**
		 * @return mixed|string
		 */
		public function get_title() {

			if ( ! $this->config_class ) {
				return '';
			}

			// config class
			$config_class = new $this->config_class();

			return $config_class::$name;
		}

		/**
		 * @return string
		 */
		public function get_group() {

			if ( ! $this->config_class ) {
				return '';
			}

			// config class
			$config_class = new $this->config_class();

			return $config_class::$group;
		}

		/**
		 * @return string
		 */
		public function get_template_name() {

			if ( ! $this->config_class ) {
				return '';
			}

			// config class
			$config_class = new $this->config_class();

			return $config_class::$template_name;
		}

		/**
		 * @return array
		 */
		public function get_categories() {
			return array( 'thim-builder' );
		}

		/**
		 * @return array
		 */
		public function get_keywords() {
			$keywords = array_merge( $this->keywords, array( $this->get_name(), 'thimbuilder' ) );

			return $keywords;
		}

		/**
		 * @return array
		 */
		public function get_script_depends() {
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			$assets = $config_class::_get_assets();

			$depends = array();
			if ( ! empty( $assets['scripts'] ) ) {
				foreach ( $assets['scripts'] as $key => $script ) {
					$depends[] = $key;
				}
			}

			return $depends;
		}

		/**
		 * @return array
		 */
		public function get_style_depends() {
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			$assets = $config_class::_get_assets();

			$depends = array();
			if ( ! empty( $assets['styles'] ) ) {
				foreach ( $assets['styles'] as $key => $style ) {
					$depends[] = $key;
				}
			}

			return $depends;
		}

		/**
		 * Render.
		 */
		protected function render() {
			if ( ! $this->config_class ) {
				return;
			}

			// allow hook before template
			do_action( 'thim-builder/before-element-template', $this->get_name() );

			// get settings
			$settings = $this->get_settings_for_display();

 			// handle settings
			$settings = $this->_handle_settings( $this->thim_convert_setting( $settings ) );

			// fix for old themes by tuanta
			$params       = thim_builder_folder_group() ? 'params' : 'instance';
			$group_folder = thim_builder_folder_group() ? $this->get_group() . '/' : '';

			$args                 = array();
			$args['before_title'] = '<h3 class="widget-title">';
			$args['after_title']  = '</h3>';

			$settings = array_merge(
				$settings, array(
					'group'         => $this->get_group(),
					'base'          => $this->get_base(),
					'template_path' => $group_folder . $this->get_base() . '/tpl/'
				)
			);


			$base_file = $this->get_template_name() ? $this->get_template_name() : $this->get_base();
			echo '<div class="thim-widget-' . $this->get_base() . ' template-' . $base_file . '">';

			thim_builder_get_template( $base_file, array( $params => $settings, 'args' => $args ), $settings['template_path'] );

			echo '</div>';
		}

		/**
		 * @param      $settings
		 * @param null $controlsx
		 *
		 * @return mixed
		 */
		private function _handle_settings( $settings, $controls = null ) {

			if ( ! $controls ) {
				$controls = $this->options();
			}

			foreach ( $controls as $key => $control ) {
				if ( array_key_exists( $control['param_name'], $settings ) ) {

					$type  = $control['type'];
					$value = $settings[$control['param_name']];
					switch ( $type ) {
						case 'param_group':
							if ( isset( $value ) ) {
								foreach ( $value as $_key => $_value ) {
									$settings[$control['param_name']][$_key] = $this->_handle_settings( $_value, $control['params'] );
								}
							}
							break;

						case 'vc_link':
							$settings[$control['param_name']] = array(
								'url'    => $value['url'],
								'target' => $value['is_external'] == 'on' ? '_blank' : '',
								'rel'    => $value['nofollow'] == 'on' ? 'nofollow' : '',
								'title'  => ''
							);
							break;
						case 'attach_image':
							$settings[$control['param_name']] = isset( $value ) ? $value['id'] : '';
							break;
						default:
							// fix for param group
							//							if ( isset( $control['group_id'] ) ) {
							//								$settings[$control['group_id']][$control['param_name']] =  $value;
							//							}
							break;
					}
				}
			}

			return $settings;
		}

		/**
		 * @return array
		 */
		public function options() {
			if ( ! $this->config_class ) {
				return array();
			}

			// config class
			$config_class = new $this->config_class();
			$options      = $config_class::$options;
			foreach ( $options as $key_lv1 => $value_lv1 ) {
				if ( $value_lv1['type'] != 'param_group' ) {
					continue;
				}
				$params_lv1 = $value_lv1['params'];
				foreach ( $params_lv1 as $key_lv2 => $value_lv2 ) {
					if ( $value_lv2['type'] != 'param_group' ) {
						continue;
					}
					if ( isset( $value_lv2['max_el_items'] ) && $value_lv2['max_el_items'] > 0 ) {
						$params_lv2    = $value_lv2['params'];
						$separate_text = $params_lv1[$key_lv2]['heading'];
						unset( $params_lv1[$key_lv2] );
						$params_lv1 = array_values( $params_lv1 );
						$i          = 0;
						while ( $i < $value_lv2['max_el_items'] ) {
							$i ++;
							$default_hidden = array();
							foreach ( $params_lv2 as $key_lv3 => $value_lv3 ) {
								$horizon = array(
									'type'       => 'bp_heading',
									'heading'    => $separate_text . ' #' . $i,
									'param_name' => 'horizon_line' . ' #' . $i
								);
								if ( $i === 1 ) {
									$default_hidden[] = $value_lv3['param_name'];
									$hidden           = array(
										'type'       => 'bp_hidden',
										'param_name' => $value_lv2['param_name'],
										'std'        => $value_lv2['max_el_items'] . '|' . implode( ',', $default_hidden )
									);
									$params_lv1[]     = $hidden;
								}
								$params_lv1[]            = $horizon;
								$value_lv3['param_name'] = $value_lv3['param_name'] . $i;
								if ( isset( $value_lv3['dependency'] ) && $value_lv3['dependency']['element'] != '' ) {
									$value_lv3['dependency']['element'] = $value_lv3['dependency']['element'] . $i;
								}
								$params_lv1[] = $value_lv3;
							}
						}
					}
				}
				$options[$key_lv1]['params'] = $params_lv1;
			}

			return $options;
		}

		/**
		 * @return string
		 */
		public function assets_url() {
			if ( ! $this->config_class ) {
				return '';
			}

			// config class
			$config_class = new $this->config_class();

			return $config_class::$assets_url;
		} 
		
		// convert setting
		function thim_convert_setting( $settings ) {
			return $settings;
		}
	}

}
