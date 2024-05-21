<?php

/**
 * Class Thim_Layout_Builder
 *
 * @since 0.8.2
 */
if ( ! class_exists( 'Thim_Layout_Builder' ) ) {
	class Thim_Layout_Builder extends Thim_Singleton {
		/**
		 * @var string
		 * @since 0.9.1
		 */
		public static $post_type = 'thim-component';

		/**
		 * Get link panel page builder.
		 *
		 * @since 1.0.0
		 *
		 * @param $content
		 * @param $builder
		 * @param $hook_after_save
		 * @param $extra
		 *
		 * @return string
		 */
		public static function get_link_panel_page_builder( $content, $builder = 'default', $hook_after_save = array(), $extra = null ) {
			$post_id = self::get_layout_builder_available();

			/**
			 * Setup default.
			 */
			$meta = array(
				'tc_hook_after_save_post' => $hook_after_save,
				'tc_extra'                => $extra,
			);

			$args = array(
				'ID' => $post_id,
			);

			if ( $builder != 'so' ) {
				$args['post_content'] = $content;
			} else {
				$meta['panels_data'] = $content;
			}

			if ( $builder != 'vc' ) {
				$meta['_wpb_vc_js_status'] = 'false';
			} else {
				$meta['_wpb_vc_js_status'] = 'true';
			}

			$args['meta_input'] = $meta;

			wp_update_post( $args );
			if ( is_wp_error( $post_id ) ) {
				wp_die( __( 'Something went wrong!', 'thim-core' ) );
			}

			return admin_url( "post.php?post=$post_id&action=edit" );
		}

		/**
		 * Get content layout builder.
		 *
		 * @since 1.0.0
		 *
		 * @param $post_ID
		 *
		 * @return string|mixed
		 */
		public static function get_content( $post_ID ) {
			$p = get_post( $post_ID );

			if ( ! $p ) {
				return '';
			}

			$builder = self::detect_page_builder( $post_ID );

			if ( $builder != 'so' ) {
				return $p->post_content;
			}

			return get_post_meta( $post_ID, 'panels_data', true );
		}

		/**
		 * Render content to HTML.
		 *
		 * @since 1.0.0
		 *
		 * @param $content
		 * @param $builder
		 * @param $fake_post_id
		 *
		 * @return string
		 */
		public static function render_content( $content, $builder, $fake_post_id ) {
			if ( $builder == 'so' ) {
				if ( ! function_exists( 'siteorigin_panels_render' ) ) {
				    if(is_plugin_active( 'elementor/elementor.php' )){
				        $related_id = self::thim_get_post_id_by_meta_key_and_value( 'tc_extra', str_replace( 'tc-megamenu-', '', $fake_post_id ) );
				        update_post_meta( $related_id, 'panels_data', '' );
					    $real_content = self::get_content($related_id);

					    return do_shortcode( $real_content );
                    }
					return "<pre class='notification-error'>"
					       . sprintf( __( 'Please install <a href="%s" target="_blank">SiteOrigin Page Builder</a>', 'thim-core' ), 'https://siteorigin.com/page-builder/' )
					       . '</pre>';
				}

				return siteorigin_panels_render( $fake_post_id, true, $content );
			}

			$rendered = do_shortcode( $content );

			if ( $builder == 'vc' && function_exists( 'visual_composer' ) ) {
				$custom_css = visual_composer()->parseShortcodesCustomCss( $content );

				if ( ! empty( $custom_css ) ) {
					$script = '<script type="text/javascript">
                tc_insert_internal_css("' . $custom_css . '");
			</script>';

					$rendered .= $script;
				}
			}

			return $rendered;
		}

		/**
		 * Detect page builder.
		 *
		 * @since 1.0.0
		 *
		 * @param $post_ID
		 *
		 * @return string so: Site Origin, vc: Visual Composer, default: HTML
		 */
		public static function detect_page_builder( $post_ID ) {
			$vc = get_post_meta( $post_ID, '_wpb_vc_js_status', true );
			if ( ! empty( $vc ) && $vc == 'true' ) {
				return 'vc';
			}

			$site_origin = get_post_meta( $post_ID, 'panels_data', true );
			if ( ! empty( $site_origin ) && function_exists( 'siteorigin_panels_render' ) ) {
				return 'so';
			}

			return 'default';
		}

		/**
		 * Get post layout builder.
		 *
		 * @since 0.9.0
		 *
		 * @return WP_Error|int
		 */
		public static function get_layout_builder_available() {
			$max_post_count = 3;
			$query          = new WP_Query( array(
				'posts_per_page' => - 1,
				'post_type'      => self::$post_type,
				'order'          => 'ASC',
				'orderby'        => 'modified',
			) );

			$postID = false;

			$posts = $query->get_posts();
			if ( ! $posts || count( $posts ) < $max_post_count ) {
				$args = array(
					'post_title'   => time(),
					'post_content' => '',
					'post_status'  => 'publish',
					'post_type'    => self::$post_type,
					'meta_input'   => array(
						'_wpb_vc_js_status'       => 'true',
						'tc_hook_after_save_post' => '',
					),
				);

				$post   = wp_insert_post( $args, new WP_Error( '5000', __( 'Can not create new post', 'thim-core' ) ) );
				$postID = $post;
			}

			$post = $posts[0];
			if ( $post instanceof WP_Post ) {
				$postID = $post->ID;
			}

			if ( ! $postID ) {
				return new WP_Error( '5000', __( 'Layout builder not available now! Please try again later :)', 'thim-core' ) );
			}

			update_post_meta( $postID, 'tc_hook_after_save_post', '' );

			return $postID;
		}

		/**
		 * Get link page layout builder.
		 *
		 * @since 0.9.0
		 *
		 * @param $content
		 * @param $hook_after_save
		 * @param $extra
		 *
		 * @return string|WP_Error
		 */
		public static function get_link_page_layout_builder( $content, $hook_after_save = array(), $extra = null ) {
			$post_id = self::get_layout_builder_available();

			if ( is_wp_error( $post_id ) ) {
				return $post_id;
			}

			$meta = array(
				'tc_hook_after_save_post' => $hook_after_save,
			);

			if ( $extra !== null ) {
				$meta['tc_extra'] = $extra;
			}

			wp_update_post( array(
				'ID'           => $post_id,
				'post_content' => $content,
				'meta_input'   => $meta,
			) );

			return admin_url( "post.php?post=$post_id&action=edit" );
		}

		/**
		 * Thim_Layout_Builder constructor.
		 *
		 * @since 0.8.2
		 */
		protected function __construct() {
			$this->init_hooks();
		}

		/**
		 * Init hooks.
		 *
		 * @since 0.8.2
		 */
		private function init_hooks() {
			add_action( 'init', array( $this, 'register_post_type' ), 0 );
			add_action( 'widgets_init', array( $this, 'register_widget' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_init', array( $this, 'disable_revisions' ) );
			add_filter( 'get_user_option_screen_layout_thim-component', array( $this, 'screen_layout_post' ) );
			add_action( 'admin_init', array( $this, 'enable_visual_composer' ) );
			add_action( 'init', array( $this, 'enable_site_origin_builder' ) );
			add_action( 'admin_init', array( $this, 'handle_request_edit_content_widget' ) );
			add_action( 'delete_widget', array( $this, 'delete_page_linking_widget' ), 10, 3 );
			add_filter( 'thim_show_footer', array( $this, 'hide_footer_when_preview' ) );
			add_filter( 'thim_show_header', array( $this, 'hide_header_when_preview' ) );
			add_action( 'thim_wrapper_init', array( $this, 'override_template_preview' ) );
			add_action( 'wp_insert_post', array( $this, 'after_save_post_layout_builder' ), 999, 2 );

			add_action( 'wp_head', array( $this, 'add_function_insert_internal_css' ) );
		}

		/**
		 * Add script function insert internal css.
		 *
		 * @since 1.0.1
		 */
		public function add_function_insert_internal_css() {
			?>
            <script type="text/javascript">
                function tc_insert_internal_css(css) {
                    var tc_style = document.createElement("style");
                    tc_style.type = "text/css";
                    tc_style.setAttribute('data-type', 'tc-internal-css');
                    var tc_style_content = document.createTextNode(css);
                    tc_style.appendChild(tc_style_content);
                    document.head.appendChild(tc_style);
                }
            </script>
			<?php
		}

		/**
		 * Enable site origin builder.
		 *
		 * @since 0.9.0
		 */
		public function enable_site_origin_builder() {
			if ( ! class_exists( 'SiteOrigin_Panels_Settings' ) ) {
				return;
			}

			$post_types        = SiteOrigin_Panels_Settings::single()->get( 'post-types' );
			$post_types_unique = array_unique( $post_types );

			if ( array_search( self::$post_type, $post_types_unique ) === false ) {
				$post_types_unique[] = self::$post_type;
				SiteOrigin_Panels_Settings::single()->set( 'post-types', $post_types_unique );

				return;
			}

			//Remove duplicate post types
			if ( count( $post_types_unique ) !== count( $post_types ) ) {
				SiteOrigin_Panels_Settings::single()->set( 'post-types', $post_types_unique );
			}
		}

		/**
		 * Handler after save post layout builder (call hook).
		 *
		 * @since 0.9.0
		 *
		 * @param $post_ID
		 * @param $post
		 */
		public function after_save_post_layout_builder( $post_ID, $post ) {
			if ( $post->post_type != self::$post_type ) {
				return;
			}

			$hook_after_save_post = get_post_meta( $post_ID, 'tc_hook_after_save_post', true );

			if ( empty( $hook_after_save_post ) ) {
				return;
			}

			if ( is_callable( $hook_after_save_post ) ) {
				$extra = get_post_meta( $post_ID, 'tc_extra', true );

				call_user_func( $hook_after_save_post, array( $post_ID, $extra ) );
			}
		}

		/**
		 * Enable visual composer.
		 *
		 * @since 0.8.2
		 */
		public function enable_visual_composer() {
			$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : false;
			if ( get_post_type( $post_id ) !== self::$post_type ) {
				return;
			}

			add_filter( 'vc_role_access_with_post_types_get_state', '__return_true' );
			add_filter( 'vc_role_access_with_backend_editor_get_state', '__return_true' );
			add_filter( 'vc_role_access_with_frontend_editor_get_state', '__return_true' );
			add_filter( 'vc_check_post_type_validation', '__return_true' );
		}

		/**
		 * Override template preview.
		 *
		 * @since 0.9.0
		 */
		public function override_template_preview() {
			$post_type = get_post_type();
			if ( $post_type == self::$post_type ) {
				Thim_Template_Helper::template( 'layout-builder/preview.php', array(), true );
				exit();
			}
		}

		/**
		 * Hide footer when preview.
		 *
		 * @since 0.9.0
		 *
		 * @param $show
		 *
		 * @return bool
		 */
		public function hide_footer_when_preview( $show ) {
			if ( get_post_type() !== self::$post_type ) {
				return $show;
			}

			return false;
		}

		/**
		 * Hide header when preview.
		 *
		 * @since 0.9.0
		 *
		 * @param $show
		 *
		 * @return bool
		 */
		public function hide_header_when_preview( $show ) {
			if ( get_post_type() !== self::$post_type ) {
				return $show;
			}

			return false;
		}

		/**
		 * Action delete page link to widget.
		 *
		 * @since 0.8.2
		 *
		 * @param $widget_id
		 * @param $sidebar_id
		 * @param $id_base
		 */
		public function delete_page_linking_widget( $widget_id, $sidebar_id, $id_base ) {
			if ( $id_base !== Thim_Widget_Layout_Builder::get_id_base() ) {
				return;
			}

			$id = str_replace( $id_base . '-', '', $widget_id );
			if ( ! is_numeric( $id ) ) {
				return;
			}

			Thim_Builder_Linking_Widget::delete_page_linking_widget( $id );
		}

		/**
		 * Handle request go to page builder.
		 *
		 * @since 0.8.2
		 */
		public function handle_request_edit_content_widget() {
			Thim_Builder_Linking_Widget::handle_request_edit_content_widget();
		}

		/**
		 * Add filter screen layout edit post type thim-component is 1 column.
		 *
		 * @since 0.8.2
		 *
		 * @return int
		 */
		public function screen_layout_post() {
			return 1;
		}

		/**
		 * Enqueue scripts.
		 *
		 * @since 0.8.2
		 */
		public function enqueue_scripts() {
			$screen = get_current_screen();

			if ( $screen->post_type !== self::$post_type ) {
				return;
			}

			wp_enqueue_style( 'thim-edit-component', THIM_CORE_ADMIN_URI . '/assets/css/thim-layout-builder.css' );
			do_action( 'tc_enqueue_scripts_panel_layout_builder' );
		}

		/**
		 * Disable revisions.
		 *
		 * @since 0.8.2
		 */
		public function disable_revisions() {
			remove_post_type_support( self::$post_type, 'revisions' );
		}

		/**
		 * Register custom post type.
		 *
		 * @since 0.8.2
		 */
		public function register_post_type() {
			$labels  = array(
				'name'                  => _x( 'TP Component', 'Post Type General Name', 'thim-core' ),
				'singular_name'         => _x( 'TP Component', 'Post Type Singular Name', 'thim-core' ),
				'menu_name'             => __( 'TP Components', 'thim-core' ),
				'name_admin_bar'        => __( 'TP Component', 'thim-core' ),
				'archives'              => __( 'Item Archives', 'thim-core' ),
				'parent_item_colon'     => __( 'Parent Item:', 'thim-core' ),
				'all_items'             => __( 'All Items', 'thim-core' ),
				'add_new_item'          => __( 'Add New Item', 'thim-core' ),
				'add_new'               => __( 'Add New', 'thim-core' ),
				'new_item'              => __( 'New Item', 'thim-core' ),
				'edit_item'             => __( 'Edit Item', 'thim-core' ),
				'update_item'           => __( 'Update Item', 'thim-core' ),
				'view_item'             => __( 'View Item', 'thim-core' ),
				'search_items'          => __( 'Search Item', 'thim-core' ),
				'not_found'             => __( 'Not found', 'thim-core' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'thim-core' ),
				'featured_image'        => __( 'Featured Image', 'thim-core' ),
				'set_featured_image'    => __( 'Set featured image', 'thim-core' ),
				'remove_featured_image' => __( 'Remove featured image', 'thim-core' ),
				'use_featured_image'    => __( 'Use as featured image', 'thim-core' ),
				'insert_into_item'      => __( 'Insert into item', 'thim-core' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'thim-core' ),
				'items_list'            => __( 'Items list', 'thim-core' ),
				'items_list_navigation' => __( 'Items list navigation', 'thim-core' ),
				'filter_items_list'     => __( 'Filter items list', 'thim-core' ),
			);
			$rewrite = array(
				'slug'       => self::$post_type,
				'with_front' => true,
				'pages'      => false,
				'feeds'      => false,
			);
			$args    = array(
				'label'               => __( 'Thim Component', 'thim-core' ),
				'description'         => __( 'Post Type Description', 'thim-core' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor' ),
				'hierarchical'        => true,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'menu_position'       => 20,
				'menu_icon'           => 'dashicons-layout',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => false,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => $rewrite,
				'capability_type'     => 'page',
			);
			register_post_type( self::$post_type, $args );
		}

		/**
		 * Register widget.
		 *
		 * @since 0.8.2
		 */
		public function register_widget() {
			register_widget( 'Thim_Widget_Layout_Builder' );
		}

		/**
		 * Get post id from meta key and value
		 * @param string $key
		 * @param mixed $value
		 * @return int|bool
		 * @author David M&aring;rtensson <david.martensson@gmail.com>
		 */
		public static function thim_get_post_id_by_meta_key_and_value($key, $value) {
			global $wpdb;
			$meta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key=%s AND meta_value=%s", $key, $value ) );
			if ( is_array($meta) && !empty($meta) && isset($meta[0]) ) {
				$meta = $meta[0];
			}
			if (is_object($meta)) {
				return $meta->post_id;
			}
			else {
				return false;
			}
		}
	}
}
