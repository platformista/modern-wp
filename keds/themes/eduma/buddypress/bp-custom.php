<?php

function thim_buddypress_search_form() {
	$query_arg = bp_core_get_component_search_query_arg( 'members' );

	if ( ! empty( $_REQUEST[ $query_arg ] ) ) {
		$search_value = stripslashes( $_REQUEST[ $query_arg ] );
	} else {
		$search_value = bp_get_search_default_text( 'members' );
	}

	$search_form_html = '<form action="" method="get" id="search-members-form">
		<input type="text" name="' . esc_attr( $query_arg ) . '" id="members_search" placeholder="'. esc_attr( $search_value ) .'" />
		<input type="submit" id="members_search_submit" name="members_search_submit" value="' . esc_attr__( 'Search', 'eduma' ) . '" />
	</form>';

	return $search_form_html;
}
add_filter( 'bp_directory_members_search_form', 'thim_buddypress_search_form' );
 