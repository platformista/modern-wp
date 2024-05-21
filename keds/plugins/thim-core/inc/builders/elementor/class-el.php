<?php
/**
 * Thim_Builder Elementor class
 *
 * @version     1.0.0
 * @author      Thim_Builder
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'Thim_Builder_El' ) ) {
	/**
	 * Class Thim_Builder_El
	 */
	class Thim_Builder_El {

		/**
		 * @var null
		 */
		private static $instance = null;

		/**
		 * Thim_Builder_El constructor.
		 */
		public function __construct() {

			// mapping params
			require_once( THIM_CORE_INC_PATH . '/builders/elementor/class-el-mapping.php' );

			// add widget categories
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );
			// load widget
			add_action( 'elementor/widgets/register', array( $this, 'load_widgets' ) );
		}

		/**
		 * Add widget categories
		 */
		public function register_categories() {
			\Elementor\Plugin::instance()->elements_manager->add_category(
				'thim-builder',
				array(
					'title' => apply_filters( 'thim_shortcode_group_name', esc_html__( 'Thim Builder Widgets', 'thim-core' ) ),
					'icon'  => 'fa fa-plug'
				)
			);
		}

		/**
		 * @param $widgets_manager Elementor\Widgets_Manager
		 *
		 * @throws Exception
		 */
		public function load_widgets( $widgets_manager ) {

			// parent class
			require_once( THIM_CORE_INC_PATH . '/builders/elementor/class-el-widget.php' );

			$widgets = thim_builder_get_elements();
   			foreach ( $widgets as $group => $_widgets ) {
				foreach ( $_widgets as $widget ) {
					if ( $group != 'widgets' ) {
						if ( thim_builder_folder_group()) {
							$file = apply_filters( 'thim-builder/el-widget-file', TP_THEME_ELEMENTS_THIM_DIR . "$group/$widget/class-el-$widget.php", $widget );
						}else{
							$file = apply_filters( 'thim-builder/el-widget-file', TP_THEME_ELEMENTS_THIM_DIR . "$widget/class-el-$widget.php", $widget );
						}

						if ( file_exists( $file ) ) {
							include_once $file;
							$class = '\Thim_Builder_El_' . str_replace( '-', '_', ucfirst( $widget ) );

							if ( class_exists( $class ) ) {
								$widgets_manager->register( new $class() );
							}
						}
					}
				}
			}
		}

		/**
		 * Instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
		}
	}
}

new Thim_Builder_El();
