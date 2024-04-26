<?php

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
if ( ! function_exists( 'thim_event_add_meta_boxes' ) ) {
	function thim_event_add_meta_boxes() {

		if ( ! post_type_exists( 'tp_event' ) || ! post_type_exists( 'our_team' ) ) {
			return;
		}
		add_meta_box(
			'thim_organizers',
			esc_html__( 'Organizers', 'eduma' ),
			'thim_event_meta_boxes_callback',
			'tp_event'
		);
	}
}
add_action( 'add_meta_boxes', 'thim_event_add_meta_boxes' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
if ( ! function_exists( 'thim_event_meta_boxes_callback' ) ) {
	function thim_event_meta_boxes_callback( $post ) {

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'thim_event_save_meta_boxes', 'thim_event_meta_boxes_nonce' );

		// Get all team
		$team = new WP_Query(
			array(
				'post_type'           => 'our_team',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'posts_per_page'      => - 1
			)
		);

		if ( empty( $team->post_count ) ) {
			echo '<p>' . esc_html__( 'No members exists. You can create a member data from', 'eduma' ) . ' <a target="_blank" href="' . admin_url( 'post-new.php?post_type=our_team' ) . '">Our Team</a></p>';

			return;
		}

		echo '<label for="thim_event_members">';
		esc_html_e( 'Get Members', 'eduma' );
		echo '</label> ';
		echo '<select id="thim_event_members" name="thim_event_members[]" multiple>';
		if ( isset( $team->posts ) ) {
			$team = $team->posts;
			foreach ( $team as $member ) {
				echo '<option value="' . esc_attr( $member->ID ) . '">' . get_the_title( $member->ID ) . '</option>';
			}
		}
		echo '</select>';
		echo '<span>';
		esc_html_e( 'Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.', 'eduma' );
		echo '</span><br>';
		wp_reset_postdata();

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$members = get_post_meta( $post->ID, 'thim_event_members', true );
		echo '<p>' . esc_html__( 'Current Members: ', 'eduma' );
		if ( ! $members ) {
			echo esc_html__( 'None', 'eduma' ) . '</p>';
		} else {
			$total = count( $members );
			foreach ( $members as $key => $id ) {
				echo '<strong><a target="_blank" href="' . get_edit_post_link( $id ) . '">' . get_the_title( $id ) . '</a></strong>';
				if ( ( $key + 1 ) != $total ) {
					echo ', ';
				}
			}
		}
	}
}


/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
if ( ! function_exists( 'thim_event_save_meta_boxes' ) ) {
	function thim_event_save_meta_boxes( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['thim_event_meta_boxes_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['thim_event_meta_boxes_nonce'], 'thim_event_save_meta_boxes' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'tp_event' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST['thim_event_members'] ) ) {
			return;
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, 'thim_event_members', $_POST['thim_event_members'] );
	}
}
add_action( 'save_post', 'thim_event_save_meta_boxes' );

/**
 * Remove action search on archive page
 */
remove_action( 'tp_event_before_main_content', 'wpems_before_main_content' );

/**
 * Set unlimit events in archive
 *
 * @param $query
 */
if ( ! function_exists( 'thim_event_post_filter' ) ) {
	function thim_event_post_filter( $query ) {
		if ( is_post_type_archive( 'tp_event' ) && 'tp_event' == $query->get( 'post_type' ) ) {
			$query->set( 'posts_per_page', - 1 );

			return;
		}
		if ( $query->is_main_query() && ! is_admin() && is_post_type_archive( 'our_team' ) ) {
			$query->set( 'posts_per_page', 1 );
		}
	}
}
add_action( 'pre_get_posts', 'thim_event_post_filter' );


/**
 * Process events order
 */

add_filter( 'posts_fields', 'thim_event_posts_fields', 10, 2 );
add_filter( 'posts_join_paged', 'thim_event_posts_join_paged', 10, 2 );
add_filter( 'posts_where_paged', 'thim_event_posts_where_paged', 10, 2 );
/**
 * Check is event archive
 */
if ( ! function_exists( 'thim_is_events_archive' ) ) {
	function thim_is_events_archive() {
		if ( ! is_post_type_archive( 'tp_event' ) || ! is_main_query() ) {
			return false;
		}

		return true;
	}
}


/**
 * Event posts fields
 */
if ( ! function_exists( 'thim_event_posts_fields' ) ) {
	function thim_event_posts_fields( $fields, $q ) {
		if ( ! thim_is_events_archive() ) {
			return $fields;
		}
		if ( $q->get( 'post_status' ) == 'tp-event-expired' ) {
			$alias = 'end_date_time';
		} else {
			$alias = 'start_date_time';
		}
		$fields = " DISTINCT " . $fields;
		$fields .= ', concat( str_to_date( pm1.meta_value, \'%m/%d/%Y\' ), \' \', str_to_date(pm2.meta_value, \'%h:%i %p\' ) ) as ' . $alias;

		return $fields;
	}
}

/**
 * Event post join paged
 */
if ( ! function_exists( 'thim_event_posts_join_paged' ) ) {
	function thim_event_posts_join_paged( $join, $q ) {
		if ( ! thim_is_events_archive() ) {
			return $join;
		}

		global $wpdb;
		if ( $q->get( 'post_status' ) == 'tp-event-expired' ) {
			$join .= " LEFT JOIN {$wpdb->postmeta} pm1 ON pm1.post_id = {$wpdb->posts}.ID AND pm1.meta_key = 'tp_event_date_end'";
			$join .= " LEFT JOIN {$wpdb->postmeta} pm2 ON pm2.post_id = {$wpdb->posts}.ID AND pm2.meta_key = 'tp_event_time_end'";
		} else {
			$join .= " LEFT JOIN {$wpdb->postmeta} pm1 ON pm1.post_id = {$wpdb->posts}.ID AND pm1.meta_key = 'tp_event_date_start'";
			$join .= " LEFT JOIN {$wpdb->postmeta} pm2 ON pm2.post_id = {$wpdb->posts}.ID AND pm2.meta_key = 'tp_event_time_start'";
		}

		return $join;
	}
}

/**
 * Event posts where paged
 */
if ( ! function_exists( 'thim_event_posts_where_paged' ) ) {
	function thim_event_posts_where_paged( $where, $q ) {
		if ( ! thim_is_events_archive() ) {
			return $where;
		}

		return $where;
	}
}

/**
 * Remove action single event
 */
remove_action( 'tp_event_after_loop_event_item', 'event_auth_register' );
remove_action( 'tp_event_after_single_event', 'wpems_single_event_register' );
remove_action( 'tp_event_after_single_event', 'event_auth_register' );
remove_action( 'tp_event_after_single_event', 'tp_event_single_event_register' );

if ( ! function_exists( 'thim_remove_create_page_action_event_auth' ) ) {
	function thim_remove_activate_action_event_auth( $plugin ) {
		if ( $plugin === 'tp-event-auth' ) {
			add_filter( 'event_auth_create_pages', 'thim_remove_create_page_action_event_auth' );
		}
	}
}
add_action( 'activate_plugin', 'thim_remove_activate_action_event_auth' );

if ( ! function_exists( 'thim_remove_create_page_action_event_auth' ) ) {
	function thim_remove_create_page_action_event_auth( $return ) {
		return false;
	}
}

/**
 * Remove hook tp-event-auth
 */
if ( class_exists( 'TP_Event_Authentication' ) ) {
	if ( ! version_compare( get_option( 'event_auth_version' ), '1.0.3', '>=' ) ) {
		$auth = TP_Event_Authentication::getInstance()->auth;

		remove_action( 'login_form_login', array( $auth, 'redirect_to_login_page' ) );
		remove_action( 'login_form_register', array( $auth, 'login_form_register' ) );
		remove_action( 'login_form_lostpassword', array( $auth, 'redirect_to_lostpassword' ) );
		remove_action( 'login_form_rp', array( $auth, 'resetpass' ) );
		remove_action( 'login_form_resetpass', array( $auth, 'resetpass' ) );

		remove_action( 'wp_logout', array( $auth, 'wp_logout' ) );
		remove_filter( 'login_url', array( $auth, 'login_url' ) );
		remove_filter( 'login_redirect', array( $auth, 'login_redirect' ) );
	}
}
/**
 * Filter event login url
 */
add_filter( 'tp_event_login_url', 'thim_get_login_page_url' );
add_filter( 'event_auth_login_url', 'thim_get_login_page_url' );
/**
 * Filter map single event 2.0
 */
if ( ! function_exists( 'thim_filter_event_map' ) ) {
	function thim_filter_event_map( $map_data ) {
		$map_data['height']                  = '210px';
		$map_data['map_data']['scroll-zoom'] = false;
		$map_data['map_data']['marker-icon'] = get_template_directory_uri() . '/images/map_icon.png';

		return $map_data;
	}
}
add_filter( 'tp_event_filter_event_location_map', 'thim_filter_event_map' );
