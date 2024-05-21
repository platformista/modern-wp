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

class Thim_Import_REST_Response extends Thim_REST_Response {
	public $step = ''; // name step import
	public $finish = 0; // Finish all Import
	public $extra = null; // data send continue with step not finished
	public $step_finished = 0; // Finish of a step
	public $percentage = 0; // percentage progress of a step

	public function __construct() {

	}
}
