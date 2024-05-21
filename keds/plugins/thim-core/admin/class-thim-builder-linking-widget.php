<?php

if ( class_exists( 'Thim_Builder_Linking_Widget' ) ) {
	return;
}

/**
 * Class Thim_Layout_Builder_Widget
 *
 * @since 0.8.2
 */
class Thim_Builder_Linking_Widget {
	/**
	 * @since 0.8.2
	 * @var
	 */
	public $widget_id;

	/**
	 * @var null
	 *
	 * @since 0.8.2
	 */
	protected static $_instance = array();

	/**
	 * @var string
	 *
	 * @since 0.8.2
	 */
	public static $key_request = 'thim-widget-go-to-page-builder';

	/**
	 * @var string
	 *
	 * @since 0.8.2
	 */
	public static $key_meta_linking = 'linking-widget';

	/**
	 * Return unique instance of Thim_Builder_Linking_Widget.
	 *
	 * @param $widget_id
	 *
	 * @since 0.8.2
	 *
	 * @return Thim_Builder_Linking_Widget
	 */
	static function instance( $widget_id ) {
		if ( ! isset( self::$_instance[ $widget_id ] ) ) {
			self::$_instance[ $widget_id ] = new self( $widget_id );
		}

		return self::$_instance[ $widget_id ];
	}

	/**
	 * Handle request go to page builder.
	 *
	 * @since 0.8.2
	 */
	public static function handle_request_edit_content_widget() {
		$query_detect = self::$key_request;
		$detect       = isset( $_REQUEST[ $query_detect ] ) ? true : false;
		if ( ! $detect ) {
			return;
		}

		$widget_id = isset( $_REQUEST['widget-id'] ) ? $_REQUEST['widget-id'] : false;
		if ( ! $widget_id || ! is_numeric( $widget_id ) ) {
			wp_die( __( 'Widget not found!', 'thim-core' ) );
		}

		$widget_builder      = self::instance( $widget_id );
		$content             = Thim_Widget_Layout_Builder::get_content( $widget_builder->widget_id );
		$page_layout_builder = Thim_Layout_Builder::get_link_page_layout_builder( $content, array( __CLASS__, 'update_widget_content' ), $widget_builder->widget_id );
		thim_core_redirect( $page_layout_builder );
	}

	/**
	 * Get widget id linking with page builder.
	 *
	 * @since 0.8.2
	 *
	 * @param $page_id
	 *
	 * @return bool|mixed
	 */
	public static function get_widget_id_linking_page_id( $page_id ) {
		$widget_id = get_post_meta( $page_id, self::$key_meta_linking, true );
		if ( empty( $widget_id ) ) {
			return false;
		}

		return $widget_id;
	}

	/**
	 * Update widget content form page content.
	 *
	 * @since 0.8.2
	 *
	 * @param $args
	 */
	public static function update_widget_content( $args ) {
		if ( ! is_array( $args ) || count( $args ) < 2 ) {
			return;
		}

		$post_ID   = $args[0];
		$widget_id = $args[1];

		$post = get_post( $post_ID );
		if ( get_class( $post ) != 'WP_Post' ) {
			return;
		}

		$post_content = $post->post_content;

		Thim_Widget_Layout_Builder::update_content( $widget_id, $post_content );
	}

	/**
	 * Delete page link to widget.
	 *
	 * @since 0.8.2
	 *
	 * @param $widget_id
	 */
	public static function delete_page_linking_widget( $widget_id ) {
		$widget = self::instance( $widget_id );
		$widget->delete_linking_page();
	}

	/**
	 * Thim_Layout_Builder_Widget constructor.
	 *
	 * @param $widget_id
	 */
	private function __construct( $widget_id ) {
		$this->widget_id = $widget_id;
	}

	/**
	 * Get url page builder.
	 *
	 * @since 0.8.2
	 *
	 * @return string
	 */
	public function get_url_page_edit() {
		return admin_url( 'post.php?post=' . $this->get_page_id() . '&action=edit#post' );
	}

	/**
	 * Get url go to page builder.
	 *
	 * @since 0.8.2
	 *
	 * @return string|void
	 */
	public function get_url_go_to_page_builder() {
		return admin_url( sprintf( '?%1$s=true&widget-id=%2$s', self::$key_request, $this->widget_id ) );
	}

	/**
	 * Transfer content widget to page builder.
	 *
	 * @since 0.8.2
	 *
	 * @return bool
	 */
	public function transfer_content_to_page() {
		$page_id = self::get_page_id();
		if ( ! $page_id ) {
			return false;
		}

		$content = Thim_Widget_Layout_Builder::get_content( $this->widget_id );

		$update = wp_update_post( array(
			'ID'           => $page_id,
			'post_content' => $content,
			'post_title'   => $this->widget_id,
		) );

		if ( is_wp_error( $update ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Insert page builder and get id.
	 *
	 * @since 0.8.2
	 *
	 * @return bool|int
	 */
	public function get_page_id() {
		if ( $id = self::get_id_first_page() ) {
			return $id;
		}

		$new_page_id = self::create_new_page();
		if ( ! $new_page_id ) {
			return false;
		}

		return self::get_page_id();
	}

	/**
	 * Create new page builder.
	 *
	 * @since 0.8.2
	 *
	 * @return bool
	 */
	private function create_new_page() {
		if ( $this->get_id_first_page() ) {
			return false;
		}

		$new_page = wp_insert_post( array(
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => Thim_Layout_Builder::$post_type,
			'meta_input'   => array(
				self::$key_meta_linking => $this->widget_id,
				'_wpb_vc_js_status'     => 'true'//Default is backend editor
			)
		) );

		if ( is_wp_error( $new_page ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Get page builder id.
	 *
	 * @since 0.8.2
	 *
	 * @return bool
	 */
	private function get_id_first_page() {
		$posts = get_posts( array(
			'post_type'      => 'thim-component',
			'posts_per_page' => - 1,
			'meta_key'       => self::$key_meta_linking,
			'meta_value'     => $this->widget_id,
		) );

		if ( count( $posts ) == 0 ) {
			return false;
		}

		$first_post = $posts[0];

		return isset( $first_post->ID ) ? $first_post->ID : false;
	}

	/**
	 * Delete linking page.
	 *
	 * @since 0.8.2
	 *
	 * @return bool
	 */
	private function delete_linking_page() {
		$page_id = $this->get_id_first_page();

		if ( ! $page_id ) {
			return false;
		}

		$delete = wp_delete_post( $page_id, true );

		return (bool) $delete;
	}
}