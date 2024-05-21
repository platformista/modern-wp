<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MB_Show_Hide' ) ) {

	/**
	 * This class controls toggling meta boxes via JS
	 * All meta boxes are included, but the job of showing/hiding them are handled via JS
	 */
	class MB_Show_Hide {
		/**
		 * Add hooks when class is loaded
		 */
		public function __construct() {
			add_action( 'rwmb_before', array( $this, 'js_data' ) );
 		}

		/**
		 * Output data for Javascript in data-show, data-hide attributes
		 * Data is output as a .mb-show-hide inside the meta box
		 * JS will read this data and process
		 *
		 * @param RW_Meta_Box $obj The meta box object.
		 */
		public function js_data( RW_Meta_Box $obj ) {
			$meta_box   = $obj->meta_box;
			$conditions = array( 'show', 'hide' );
			$data       = '';

			foreach ( $conditions as $condition ) {
				if ( empty( $meta_box[$condition] ) ) {
					continue;
				}

				// Remove empty rules.
				$rules = array_filter( $meta_box[$condition] );
				if ( 1 === count( $rules ) && isset( $rules['relation'] ) ) {
					continue;
				}

				$data .= ' data-' . $condition . '="' . esc_attr( wp_json_encode( $rules ) ) . '"';
			}

			if ( $data ) {
				// Use <script> tag to prevent browser render, thus improves performance.
				echo '<script type="text/html" class="mb-show-hide"' . $data . '></script>';
			}
		}
	}

	new MB_Show_Hide();
}
