<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( function_exists( 'wpems_get_location_map' ) ) {
	echo '<div class="entry-location">';
	wpems_get_location_map();
	echo '</div>';
}
