<?php
/**
 * Thim_Builder SiteOrigin widget class
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_SO_Widget' ) ) {
	abstract class Thim_Builder_SO_Widget extends Thim_Widget {

		/**
		 * @var array
		 */
		protected $form_options;
		protected $field_ids;

		/**
		 * @var string
		 */
		protected $base_folder;

		protected $base = '';

		protected $icon = '';

		protected $template_name = '';

		protected $assets_url = '';

		protected $assets_path = '';

		/**
		 * @var null
		 */
		protected $config_class = null;

		/**
		 * @var int|mixed|string
		 */
		protected $group;

		/**
		 * Thim_Builder_SO_Widget constructor.
		 */
		function __construct() {

			if ( ! class_exists( $this->config_class ) ) {
				return;
			}

			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			$this->base = $config_class::$base;
			$name       = $config_class::$name;
			// fix base of shortcode for theme
			$this->template_name = $config_class::$template_name;

			$widget_options = array(
				'description'   => $config_class::$desc,
				'panels_groups' => array( 'thim_builder_so_widgets' ),
				'panels_icon'   => $config_class::$icon ? $config_class::$icon : '',
			);

			$options            = $this->get_config_options();
			$this->form_options = Thim_Builder_SO_Mapping::mapping_options( $options );
			// group
			$this->group = $config_class::$group;

			$control_options = wp_parse_args(
				$widget_options,
				array(
					'width' => 600,
				)
			);

			// enqueue scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_scripts' ) );

			parent::__construct( $this->base, $name, $widget_options, $control_options, $this->form_options );
		}

		/**
		 * Display the widget.
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$args = wp_parse_args(
				$args,
				array(
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => '',
				)
			);

			// Add any missing default values to the instance

			$instance = $this->add_defaults( $this->form_options, $instance );

			// enqueue frontend scripts
			$this->enqueue_frontend_scripts();

			// sync variable from builders
			$params = $this->_handle_variables( $instance );

			// allow hook before template
			do_action( 'thim-builder/before-element-template', $this->id_base );

			// include template
			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

			// fix for old themes by tuanta
			$_params      = thim_builder_folder_group() ? 'params' : 'instance';
			$group_folder = thim_builder_folder_group() ? $this->group . '/' : '';

			$base_file = $this->template_name ? $this->template_name : $this->base;

			echo '<div class="thim-widget-' . esc_attr( $this->base ) . ' template-' . esc_attr( $base_file ) . '">';
			thim_builder_get_template(
				$base_file,
				array(
					$_params   => $params,
					'style_so' => isset( $instance['style'] ) ? $instance['style'] : '',
					'args'     => $args,
				),
				$group_folder . $this->base . '/tpl/'
			);
			echo '</div>';

			echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

		/**
		 * @param $instance
		 *
		 * @return mixed
		 */
		public function _handle_variables( $instance ) {
			$instance = array_merge(
				$instance,
				array(
					'base'          => $this->base,
					'group'         => $this->group,
					'template_path' => $this->group . '/' . $this->base . '/tpl/',
				)
			);

			do_action( 'thim-builder/so/handle-variables', $instance );

			return $instance;
		}

		/**
		 * Get the template name that we'll be using to render this widget.
		 *
		 * @param $instance
		 *
		 * @return mixed
		 */
		function get_template_name( $instance ) {
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			return $config_class::$base;
		}

		function get_style_name( $instance ) {
			return false;
		}

		/**
		 * Register frontend scripts.
		 */
		function register_frontend_scripts() {
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			$config_class::register_scripts();
		}

		/**
		 * Register frontend scripts.
		 */
		function enqueue_frontend_scripts() {
			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			$config_class::enqueue_scripts();
		}

		/**
		 * By default, or overwritten in widgets.
		 */
		function get_config_options() {
			if ( ! class_exists( $this->config_class ) ) {
				return;
			}

			/**
			 * @var $config_class Thim_Builder_Abstract_Config
			 */
			$config_class = new $this->config_class();

			return apply_filters( 'thim_so_custom_option_' . $this->base, $config_class::$options );
		}
	}
}
