<?php
add_action( 'thim_form_login_widget', 'thim_form_login_widget', 10, 1 );
function thim_form_login_widget( $captcha ) { ?>
	<form name="loginpopopform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>"
		  method="post" novalidate>
		<?php do_action( 'thim_before_login_form' ); ?>
		<p class="login-username">
			<input type="text" name="log" placeholder="<?php esc_html_e( 'Username or email', 'eduma' ); ?>"
				   class="input required" size="20"/>
		</p>
		<p class="login-password">
			<input type="password" name="pwd" placeholder="<?php esc_html_e( 'Password', 'eduma' ); ?>"
				   class="input required" value="" size="20"/>
		</p>
		<?php
		/**
		 * Fires following the 'Password' field in the login form.
		 *
		 * @since 2.1.0
		 */
		do_action( 'login_form' );
		?>
		<?php if ( $captcha == 'yes' ) : ?>
			<p class="thim-login-captcha">
				<?php
				$value_1 = rand( 1, 9 );
				$value_2 = rand( 1, 9 );
				?>
				<input type="text" data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
					   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
					   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
					   class="captcha-result required"/>
			</p>
		<?php endif; ?>
		<?php echo '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'eduma' ) . '">' . esc_html__( 'Lost your password?', 'eduma' ) . '</a>'; ?>

		<p class="forgetmenot login-remember">
			<label for="popupRememberme"><input name="rememberme" type="checkbox"
												value="forever"
												id="popupRememberme"/> <?php esc_html_e( 'Remember Me', 'eduma' ); ?>
			</label></p>
		<p class="submit login-submit">
			<input type="submit" name="wp-submit"
				   class="button button-primary button-large"
				   value="<?php esc_attr_e( 'Login', 'eduma' ); ?>"/>
			<input type="hidden" name="redirect_to"
				   value="<?php echo esc_url( thim_eduma_get_current_url() ); ?>"/>
			<input type="hidden" name="testcookie" value="1"/>
			<input type="hidden" name="nonce"
				   value="<?php echo wp_create_nonce( 'thim-loginpopopform' ) ?>"/>
			<input type="hidden" name="eduma_login_user">
		</p>

		<?php do_action( 'thim_after_login_form' ); ?>

	</form>
<?php }

add_action( 'thim_form_register_widget', 'thim_form_register_widget', 10, 3 );
function thim_form_register_widget( $captcha, $term, $redirect_to = 'account' ) { ?>
	<form class="<?php if ( get_theme_mod( 'thim_auto_login', true ) ) {
		echo 'auto_login';
	} ?>" name="registerformpopup"
		  action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
		  method="post" novalidate="novalidate">

		<?php wp_nonce_field( 'ajax_register_nonce', 'register_security' ); ?>

		<p>
			<input placeholder="<?php esc_attr_e( 'Username', 'eduma' ); ?>"
				   type="text" name="user_login" class="input required"/>
		</p>

		<p>
			<input placeholder="<?php esc_attr_e( 'Email', 'eduma' ); ?>"
				   type="email" name="user_email" class="input required"/>
		</p>

		<?php if ( get_theme_mod( 'thim_auto_login', true ) ) { ?>
			<p>
				<input placeholder="<?php esc_attr_e( 'Password', 'eduma' ); ?>"
					   type="password" name="password" class="input required"/>
			</p>
			<p>
				<input
					placeholder="<?php esc_attr_e( 'Repeat Password', 'eduma' ); ?>"
					type="password" name="repeat_password"
					class="input required"/>
			</p>
		<?php } ?>

		<?php
		if ( is_multisite() && function_exists( 'gglcptch_login_display' ) ) {
			gglcptch_login_display();
		}

		do_action( 'register_form' );
		?>

		<?php if ( $captcha == 'yes' ) : ?>
			<p class="thim-login-captcha">
				<?php
				$value_1 = rand( 1, 9 );
				$value_2 = rand( 1, 9 );
				?>
				<input type="text"
					   data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
					   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
					   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
					   class="captcha-result required"/>
			</p>
		<?php endif; ?>

		<?php
		if ( $term ):
			$target = ( isset( $term['is_external'] ) && ! empty( $term['is_external'] ) ) ? '_blank' : '_self';
			$rel = ( isset( $term['nofollow'] ) && ! empty( $term['nofollow'] ) ) ? 'nofollow' : 'dofollow';
			?>
			<p>
				<input type="checkbox" class="required" name="term" id="termFormFieldPopup">
				<label
					for="termFormField"><?php printf( __( 'I accept the <a href="%s" target="%s" rel="%s">Terms of Service</a>', 'eduma' ), esc_url( $term['url'] ), $target, $rel ); ?></label>
			</p>
		<?php endif; ?>
		<?php
		if ( $redirect_to == 'current' ) {
			$register_redirect = esc_url( thim_eduma_get_current_url() );
		} else {
			$register_redirect = get_theme_mod( 'thim_register_redirect', false );
			if ( empty( $register_redirect ) ) {
				$register_redirect = add_query_arg( 'result', 'registered', thim_get_login_page_url() );
			}
		}
		?>
		<input type="hidden" name="redirect_to"
			   value="<?php echo ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $register_redirect; ?>"/>
		<input type="hidden" name="modify_user_notification" value="1">
		<input type="hidden" name="eduma_register_user">


		<?php do_action( 'signup_hidden_fields', 'create-another-site' ); ?>
		<p class="submit">
			<input type="submit" name="wp-submit" class="button button-primary button-large"
				   value="<?php echo esc_attr_x( 'Sign up', 'Login popup form', 'eduma' ); ?>"/>
		</p>
	</form>
<?php }

if ( ! function_exists( "thim_sub_info_login_popup" ) ) {
	function thim_sub_info_login_popup( $text_profile = '', $text_logout = '' ) {
		$user              = wp_get_current_user();
		$user_profile_edit = get_edit_user_link( $user->ID );
		$user_avatar       = get_avatar( $user->ID, 30 );
		$html              = '';
		if ( ! class_exists( 'LearnPress' ) ) {
			$html .= '<a href="' . esc_url( $user_profile_edit ) . '" class="profile"><span class="author">' . wp_kses_post( $text_profile ) . ' ' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
			$html .= '<ul class="user-info">';
		} else {
			$profile       = LP_Profile::instance();
			$allowed_roles = array( 'editor', 'administrator', 'author', 'instructor' );

			if ( array_intersect( $allowed_roles, $user->roles ) ) {

				$html .= '<a href="' . esc_url( $user_profile_edit ) . '" class="profile"><span class="author">' . wp_kses_post( $text_profile ) . ' ' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
			} else {
				$html .= '<a href="' . esc_url( $profile->get_tab_link( 'settings', true ) ) . '" class="profile"><span class="author">' . wp_kses_post( $text_profile ) . ' ' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
			}

			$html .= '<ul class="user-info">';

			$items = apply_filters( 'thim_menu_profile_items', array( 'courses', 'orders', 'become_a_teacher', 'certificates', 'settings' ) );

			$menu_items_output = '';

			$profile_page = learn_press_get_page_link( 'profile' );
			$current_user = wp_get_current_user();

			if ( is_array( $items ) && count( $items ) > 0 ) {
				$view_endpoint                   = LP_Settings::instance()->get( 'learn_press_profile_endpoints' );
				$view_endpoint_basic_information = isset( $view_endpoint['settings-basic-information'] ) ? $view_endpoint['settings-basic-information'] : '';
				$view_endpoint_orders            = isset( $view_endpoint['profile-orders'] ) ? $view_endpoint['profile-orders'] : '';
				$view_endpoint_settings          = isset( $view_endpoint['profile-settings'] ) ? $view_endpoint['profile-settings'] : '';


				for ( $index = 0; $index < count( $items ); $index ++ ) {

					switch ( $items[$index] ) {
						case 'courses':
							if ( 0 == $current_user->ID ) {
								$menu_items_output .= '<li class="menu-item-courses"><a href="' . esc_url( $profile->get_tab_link( 'courses', true ) ) . '">' . esc_html__( 'My Courses', 'eduma' ) . '</a></li>';

							} else {
								$menu_items_output .= '<li class="menu-item-courses"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '">' . esc_html__( 'My Courses', 'eduma' ) . '</a></li>';

							}

							break;
						case 'orders':
							if ( 0 == $current_user->ID ) {
								$menu_items_output .= '<li class="menu-item-orders"><a href="' . esc_url( $profile->get_tab_link( 'orders', true ) ) . '">' . esc_html__( 'My Orders', 'eduma' ) . '</a></li>';

							} else {
								if ( ! empty( $view_endpoint_orders ) ) {
									$menu_items_output .= '<li class="menu-item-orders"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/' . $view_endpoint_orders . '">' . esc_html__( 'My Orders', 'eduma' ) . '</a></li>';
								} else {
									$menu_items_output .= '<li class="menu-item-orders"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/orders' . '">' . esc_html__( 'My Orders', 'eduma' ) . '</a></li>';
								}
							}
							break;
						case 'become_a_teacher':
							if ( learn_press_get_page_link( 'become_a_teacher' ) && ! array_intersect( array( 'administrator', 'lp_teacher', 'instructor' ), $user->roles ) ) {
								$menu_items_output .= '<li class="menu-item-become-a-teacher"><a href="' . learn_press_get_page_link( 'become_a_teacher' ) . '">' . esc_html__( 'Become An Instructor', 'eduma' ) . '</a></li>';
							}
							break;
						case 'certificates':
							if ( ! class_exists( 'LP_Addon_Certificates' ) ) {
								break;
							}
							if ( 0 == $current_user->ID ) {
								$menu_items_output .= '<li class="menu-item-certificates"><a href="' . esc_url( $profile->get_tab_link( 'certificates', true ) ) . '">' . esc_html__( 'My Certificates', 'eduma' ) . '</a></li>';
							} else {
								$menu_items_output .= '<li class="menu-item-certificates"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/certificates' . '">' . esc_html__( 'My Certificates', 'eduma' ) . '</a></li>';
							}
							break;
						case 'settings':
							if ( 0 == $current_user->ID ) {
								$menu_items_output .= '<li class="menu-item-settings"><a href="' . esc_url( $profile->get_tab_link( 'settings', true ) ) . '">' . esc_html__( 'Edit Profile', 'eduma' ) . '</a></li>';
							} else {
								if ( ! empty( $view_endpoint_settings ) ) {
									if ( ! empty( $view_endpoint_basic_information ) ) {
										$menu_items_output .= '<li class="menu-item-settings"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/' . $view_endpoint_settings . '/' . $view_endpoint_basic_information . '">' . esc_html__( 'Edit Profile', 'eduma' ) . '</a></li>';
									} else {
										$menu_items_output .= '<li class="menu-item-settings"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/' . $view_endpoint_settings . '/basic-information' . '">' . esc_html__( 'Edit Profile', 'eduma' ) . '</a></li>';
									}
								} else {
									$menu_items_output .= '<li class="menu-item-settings"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/settings' . '">' . esc_html__( 'Edit Profile', 'eduma' ) . '</a></li>';
								}
							}
							break;
						default:
							break;
					}
				}
			}

			$html .= apply_filters( 'thim_menu_profile_items_extend', $menu_items_output );
			$html .= '<li class="menu-item-log-out">' . '<a href="' . wp_logout_url( home_url() ) . '">' . wp_kses_post( $text_logout ) . '</a></li>';
			$html .= '</ul>';
		}

		return $html;
	}
}
