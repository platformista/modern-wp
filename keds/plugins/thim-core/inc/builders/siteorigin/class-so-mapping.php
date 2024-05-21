<?php
/**
 * Thim_Builder Elementor Mapping class
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_SO_Mapping' ) ) {
	/**
	 * Class Thim_Builder_SO_Mapping
	 */
	class Thim_Builder_SO_Mapping {

		/**
		 * Mapping Visual Composer type to SiteOrigin
		 *
		 * @param $type
		 *
		 * @return bool|mixed
		 */
		private static function _mapping_types( $type ) {

			$mapping = array(
				'number'            => 'number',
				'textfield'         => 'text',
				'vc_link'           => 'so_link',
				'param_group'       => 'repeater',
				'attach_image'      => 'media',
				'attach_images'     => 'multimedia',
				'iconpicker'        => 'icon',
				'section'           => 'section',
				'dropdown'          => 'select',
				'dropdown_multiple' => 'select',
				'colorpicker'       => 'color',
				'textarea'          => 'textarea',
				'textarea_html'     => 'textarea',
				'textarea_raw_html' => 'textarea_raw_html',
				'radio_image'       => 'radioimage',
				'datetimepicker'    => 'sobp_datetime',
				'loop'              => '',
				'checkbox'          => 'checkbox',
			);

			if ( ! array_key_exists( $type, $mapping ) ) {
				return false;
			}

			return apply_filters( 'thim-builder/so-mapping-types', $mapping[ $type ], $type );
		}

		/**
		 * @param $params
		 *
		 * @return array
		 */
		public static function mapping_options( $params ) {

			if ( ! is_array( $params ) ) {
				return array();
			}

			// mapping result
			$options = array();

			foreach ( $params as $param ) {

				$type  = $param['type'];
				$field = array();

				// get mapping field
				$field['type'] = self::_mapping_types( $type );

				// add params
				switch ( $type ) {
					// common structure field
					case 'number':
					case 'textfield':
					case 'vc_link':
					case 'attach_image':
					case 'attach_images':
					case 'colorpicker':
						break;
					case 'iconpicker':
						$field['settings'] = isset( $param['settings'] ) ? $param['settings'] : '';
						break;
					case 'textarea':
						$field['allow_html_formatting'] = isset( $param['allow_html_formatting'] ) ? $param['allow_html_formatting'] : '';
						break;
					case 'param_group':
					case 'section':
						// repeat options
						$fields        = self::mapping_options( $param['params'] );
						$field['hide'] = isset( $param['hide'] ) ? $param['hide'] : 'false';
						$field         = array_merge(
							$field,
							array(
								'item_name' => __( 'Item', 'thim-core' ),
								'fields'    => $fields,
							)
						);
						break;
					case 'dropdown':
						$field['options'] = array_flip( $param['value'] );
						break;
					case 'dropdown_multiple':
						$field['options']  = array_flip( $param['value'] );
						$field['multiple'] = true;
						break;
					case 'radio_image':
						$field['options'] = $param['options'];
						break;
					default:
						$field = array_merge( $field, apply_filters( 'thim-builder/field-so-param', array(), $type ) );
						break;
				}

				// general fields
				$field['label']       = isset( $param['heading'] ) ? $param['heading'] : '';
				$field['description'] = isset( $param['description'] ) ? $param['description'] : '';
				if ( isset( $param['class'] ) ) {
					$field['class'] = $param['class'];
				}
				if ( isset( $param['std'] ) ) {
					$field['default'] = $param['std'];
				}

				// handle dependency to state_emitter
				if ( isset( $param['dependency'] ) ) {
					$dependency = $param['dependency'];

					if ( array_key_exists( $dependency['element'], $options ) ) {

						// for parent option
						if ( ! isset( $options[ $dependency['element'] ]['state_emitter'] ) ) {
							$options[ $dependency['element'] ]['state_emitter'] = array(
								'callback' => 'select',
								'args'     => array( $dependency['element'] . '_deps' ),
							);
						}

						// for child options
						$state_handler = array();
						if ( isset( $options[ $dependency['element'] ]['options'] ) ) {
							$_parent_options = $options[ $dependency['element'] ]['options'];
							if ( is_array( $_parent_options ) ) {
								foreach ( $_parent_options as $key => $value ) {
									$state_handler[ $dependency['element'] . '_deps[' . $key . ']' ] = array( in_array( $key, (array) ( $dependency['value'] ) ) ? 'show' : 'hide' );
								}
							} else {
								$state_handler[ $dependency['element'] . '_deps[' . $_parent_options . ']' ] = array( in_array( $_parent_options, (array) ( $dependency['value'] ) ) ? 'show' : 'hide' );
							}
						}

						$field['state_handler'] = $state_handler;
					}
				}
				// handle group to section
				if ( isset( $param['param_name_so'] ) ) {
					$param['param_name'] = $param['param_name_so'];
				}
				if ( isset( $param['group'] ) && isset( $param['group_id'] ) ) {
					$section_title  = $param['group'];
					$section_option = isset( $param['group_id'] ) ? $param['group_id'] : str_replace( ' ', '_', strtolower( $section_title ) );
					if ( ! array_key_exists( $section_option, $options ) ) {
						$options[ $section_option ] = array(
							'type'   => 'section',
							'label'  => $section_title,
							'hide'   => true,
							'fields' => array(),
						);
					}
					$options[ $section_option ]['fields'][ $param['param_name'] ] = $field;
				} else {
					$options[ $param['param_name'] ] = $field;
				}
			}

			return $options;
		}
	}
}

new Thim_Builder_SO_Mapping();
