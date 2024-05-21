<?php
// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MetaBox_Extensions' ) ) {
	/**
	 * Extension main class.
	 */
	class MetaBox_Extensions {

		/**
		 * Add hooks to meta box.
		 */
		public function init() {
			// Hook to 'init' with priority 5 to make sure all actions are registered before Meta Box 4.9.0 runs.
			add_action( 'init', array( $this, 'load_files' ), 5 );
			add_action( 'rwmb_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/**
		 * Load field class.
		 */
		public function load_files() {
			require_once dirname( __FILE__ ) . '/class-conditional-logic.php';
			require_once dirname( __FILE__ ) . '/class-show-hide.php';
			require_once dirname( __FILE__ ) . '/class-tabs.php';
		}

		/**
		 * Enqueue scripts and styles for tabs.
		 */
		public function enqueue() {
			wp_enqueue_script( 'metabox-extensions-js', THIM_CORE_ADMIN_URI . '/includes/metabox-extensions/assets/metabox-extensions.js', array( 'jquery' ), THIM_CORE_VERSION );
			wp_enqueue_style( 'metabox-extensions', THIM_CORE_ADMIN_URI . '/includes/metabox-extensions/assets/metabox-extensions.css', THIM_CORE_VERSION );
			$post_id = $this->get_post_id();
			$parent  = null;
			if ( $post_id ) {
				$post   = get_post( $post_id );
				$parent = $post->post_parent;
			}
			$data = array(
				'template'    => get_post_meta( $post_id, '_wp_page_template', true ),
				'post_format' => get_post_format( $post_id ),
				'parent'      => $parent,
			);

			wp_localize_script( 'metabox-extensions-js', 'MBShowHideData', $data );
		}

		public function get_post_id() {
			$post_id = null;
			if ( isset( $_GET['post'] ) ) {
				$post_id = intval( $_GET['post'] );
			} elseif ( isset( $_POST['post_ID'] ) ) {
				$post_id = intval( $_POST['post_ID'] );
			}

			return $post_id;
		}
	}

	$mtb_ex = new MetaBox_Extensions;
	$mtb_ex->init();
}
