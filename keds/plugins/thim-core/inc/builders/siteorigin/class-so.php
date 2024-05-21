<?php
/**
 * Thim_Builder handler class
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

if ( ! class_exists( 'Thim_Builder_SO' ) ) {
	/**
	 * Class Thim_Builder_SO
	 */
	class Thim_Builder_SO {
		/**
		 * Thim_Builder_SO constructor.
		 */
		public function __construct() {

			// parent class
			require_once( THIM_CORE_INC_PATH . '/builders/siteorigin/class-so-widget.php' );

			// mapping params
			require_once( THIM_CORE_INC_PATH . '/builders/siteorigin/class-so-mapping.php' );

			// add group
			add_filter( 'siteorigin_panels_widget_dialog_tabs', array( $this, 'register_widget_groups' ) );

			// load widgets
			add_action( 'widgets_init', array( $this, 'load_widgets' ) );
		}

		/**
		 * @param $tabs
		 *
		 * @return array
		 */
		public function register_widget_groups( $tabs ) {
			$tabs[] = array(
				'title'  => apply_filters( 'thim_shortcode_group_name', esc_html__( 'Thim Builder Widgets', 'thim-core' ) ),
				'filter' => array(
					'groups' => array( 'thim_builder_so_widgets' )
				)
			);

			return $tabs;
		}

		/**
		 * Load SO widgets
		 */
		public function load_widgets() {
			$widgets = thim_builder_get_elements();
			$is_support = get_theme_support( 'thim-full-widgets' );
//			$sp_group        = thim_builder_folder_group();
			foreach ( $widgets as $group => $_widgets ) {
				foreach ( $_widgets as $widget ) {
					$file = '';
					if ( is_plugin_active( 'siteorigin-panels/siteorigin-panels.php' ) || $group == 'widgets' || $is_support) {
						if ( thim_builder_folder_group()) {
							$file = apply_filters( 'thim-builder/so-widget-file', TP_THEME_ELEMENTS_THIM_DIR . "$group/$widget/class-so-$widget.php", $widget );
						} else {
							$file = apply_filters( 'thim-builder/so-widget-file', TP_THEME_ELEMENTS_THIM_DIR . "$widget/class-so-$widget.php", $widget );
						}
					}

					if ( file_exists( $file ) ) {
						include_once $file;
						$class = apply_filters( 'thim-before-class-widget', 'Thim_' ) . str_replace( '-', '_', ucwords( $widget, '-' ) ) . apply_filters( 'thim-after-class-widget', '_Widget' );
						if ( class_exists( $class ) ) {
							$class_slow = apply_filters( 'fixed_slow_function_widget', array() );
							if ( ! empty( $class_slow ) ) {
								if ( in_array( $widget, apply_filters( 'fixed_slow_function_widget', array() ) ) ) {
									$class = strtolower( $class );
								}
							}
							register_widget( $class );
						}
					}
				}
			}
		}
	}
}

new Thim_Builder_SO();


