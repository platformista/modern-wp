<?php

/**
 * Class Thim_Core_Schedule.
 *
 * @since 1.5.0
 */
class Thim_Core_Schedule extends Thim_Singleton {

	/**
	 * Thim_Core_Schedule constructor.
	 *
	 * @since 1.5.0
	 */
	protected function __construct() {
		$this->check_product_registration();
	}

	/**
	 * Check product registration.
	 */
	private function check_product_registration() {
		if ( ! wp_next_scheduled( 'thim_core_check_product_registration' ) ) {
			wp_schedule_event( time(), 'twicedaily', 'thim_core_check_product_registration' );
		}
	}
}