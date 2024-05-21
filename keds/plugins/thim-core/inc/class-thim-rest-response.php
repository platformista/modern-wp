<?php

/**
 * Class Thim_REST_Response
 *
 * @author  tungnx
 * @package LearnPress/Classes
 * @version 1.0
 * @since 3.2.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Thim_REST_Response {
	public $status = 'error';
	public $message = '';
	/**
	 * @var array|object
	 */
	public $data;
}
