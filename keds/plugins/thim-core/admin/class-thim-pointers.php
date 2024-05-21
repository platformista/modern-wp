<?php

/**
 * Class Thim_Pointers
 *
 * @since 1.2.1
 */
class Thim_Pointers extends Thim_Singleton {
	/**
	 * Thim_Pointers constructor.
	 *
	 * @since 1.2.1
	 */
	protected function __construct() {
		$this->hooks();
	}

	/**
	 * Add hooks.
	 *
	 * @since 1.2.1
	 */
	private function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'pointer_load' ) );
	}

	/**
	 * Load pointers.
	 *
	 * @since 1.2.1
	 *
	 * @param $hook_suffix
	 */
	public function pointer_load( $hook_suffix ) {
		// Don't run on WP < 3.3
		if ( get_bloginfo( 'version' ) < '3.3' ) {
			return;
		}

		$screen    = get_current_screen();
		$screen_id = $screen->id;

		// Get pointers for this screen
		$pointers = apply_filters( 'thim_core_admin_pointers-' . $screen_id, array() );

		if ( ! $pointers || ! is_array( $pointers ) ) {
			return;
		}

		// Get dismissed pointers
		$dismissed      = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
		$valid_pointers = array();

		// Check pointers and remove dismissed ones.
		foreach ( $pointers as $pointer_id => $pointer ) {

			// Sanity check
			if ( in_array( $pointer_id, $dismissed ) || empty( $pointer ) || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) ) {
				continue;
			}

			$pointer['pointer_id'] = $pointer_id;

			// Add the pointer to $valid_pointers array
			$valid_pointers['pointers'][] = $pointer;
		}

		// No valid pointers? Stop here.
		if ( empty( $valid_pointers ) ) {
			return;
		}

		// Add pointers style to queue.
		wp_enqueue_style( 'wp-pointer' );

		// Add pointers script to queue. Add custom script.
		wp_enqueue_script( 'thim-core-pointer', THIM_CORE_ADMIN_URI . '/assets/js/pointers.js', array( 'wp-pointer' ), THIM_CORE_VERSION );

		// Add pointer options to script.
		wp_localize_script( 'thim-core-pointer', 'thim_pointers', $valid_pointers );
	}
}
