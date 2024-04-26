<?php

//update_post_meta( get_the_ID(), 'thim_login_page', '1' );
// get id page added shortcode "Thim: Login Form"
update_option( 'thim_login_page', get_the_ID() );

if ( is_user_logged_in() ) {
	echo '<p class="message message-success">' . sprintf( wp_kses( __( 'You have logged in. <a href="%s">Sign Out</a>', 'eduma' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( wp_logout_url( apply_filters( 'thim_default_logout_redirect', thim_eduma_get_current_url() ) ) ) ) . '</p>';

	return;
}

$theme_options_data = get_theme_mods();
$thim_login_msg     = wp_kses_post( $_GET['thim_login_msg'] ?? '' );
?>
<?php if ( isset( $_GET['result'] ) || isset( $_GET['action'] ) ) : ?>
	<?php if ( isset( $_GET['result'] ) && $_GET['result'] == 'failed' ) : ?>
		<?php
		if ( ! empty( $thim_login_msg ) ) {
			echo sprintf( '<p class="message message-error">%s</p>', esc_html( html_entity_decode( wp_unslash( $thim_login_msg ) ) ) );
		}
		?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['action'] ) && $_GET['action'] == 'register' ) : ?>
		<?php if ( get_option( 'users_can_register' ) ) : ?>
			<?php
			$thim_register_msg = wp_kses_post( $_GET['thim_register_msg'] ?? '' );
			if ( ! empty( $_GET['thim_register_msg'] ) ) {
				echo sprintf( '<p class="message message-error">%s</p>', wp_kses_post( html_entity_decode( wp_unslash( $thim_register_msg ) ) ) );
			}
			?>
			<div class="thim-login form-submission-register">

				<h2 class="title"><?php esc_html_e( 'Register', 'eduma' ); ?></h2>

				<form class="
					<?php
					if ( get_theme_mod( 'thim_auto_login', true ) ) {
						echo 'auto_login';
					}
					?>
					" name="registerform"
					  action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
					  method="post" novalidate="novalidate">
					<p>
						<input placeholder="<?php esc_attr_e( 'Username', 'eduma' ); ?>" type="text"
							   name="user_login"
							   class="input required"/>
					</p>

					<p>
						<input placeholder="<?php esc_attr_e( 'Email', 'eduma' ); ?>" type="email" name="user_email"
							class="input required"/>
					</p>

					<?php if ( get_theme_mod( 'thim_auto_login', true ) ) { ?>
						<p>
							<input placeholder="<?php esc_attr_e( 'Password', 'eduma' ); ?>" type="password"
								name="password" class="input required"/>
						</p>
						<p>
							<input placeholder="<?php esc_attr_e( 'Repeat Password', 'eduma' ); ?>" type="password"
								name="repeat_password" class="input required"/>
						</p>

					<?php } ?>

					<?php
					if ( is_multisite() && function_exists( 'gglcptch_login_display' ) ) {
						gglcptch_login_display();
					}

					do_action( 'register_form' );
					?>

					<?php if ( isset( $instance['captcha'] ) && $instance['captcha'] == 'yes' ) : ?>
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

					<?php
					if ( isset( $instance['terms'] ) ) {
						$url = $instance['terms'];
					} else {
						$url = isset( $instance['term'] ) ? $instance['term'] : '';
					}
					if ( ! empty( $url ) ) :
						?>
						<?php
						$target = ( isset( $instance['is_external'] ) && ! empty( $instance['is_external'] ) ) ? '_blank' : '_self';
						$rel    = ( isset( $instance['nofollow'] ) && ! empty( $instance['nofollow'] ) ) ? 'nofollow' : 'dofollow';
						?>
						<p>
							<input type="checkbox" class="required" name="term" id="termFormField">
							<label
									for="termFormField"><?php printf( __( 'I accept the <a href="%1$s" target="%2$s" rel="%3$s">Terms of Service</a>', 'eduma' ), esc_url( $url ), $target, $rel ); ?></label>
						</p>
					<?php endif; ?>

					<p>
						<?php
						$register_redirect = get_theme_mod( 'thim_register_redirect', false );
						if ( empty( $register_redirect ) ) {
							$register_redirect = add_query_arg( 'result', 'registered', thim_get_login_page_url() );
						}
						?>
						<input type="hidden" name="redirect_to"
							value="<?php echo ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $register_redirect; ?>"/>
						<input type="hidden" name="modify_user_notification" value="1">
						<input type="hidden" name="eduma_register_user">
					</p>

					<?php do_action( 'signup_hidden_fields', 'create-another-site' ); ?>
					<p class="submit">
						<input type="submit" name="wp-submit" class="button button-primary button-large"
							value="<?php esc_attr_e( 'Sign up', 'eduma' ); ?>"/>
					</p>
				</form>

				<?php echo '<p class="link-bottom">' . esc_html__( 'Are you a member? ', 'eduma' ) . ' <a href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html__( 'Login now', 'eduma' ) . '</a></p>'; ?>
			</div>
			<?php return; ?>
		<?php else : ?>
			<?php echo '<p class="message message-error">' . esc_html__( 'Your site does not allow users registration.', 'eduma' ) . '</p>'; ?>
			<?php return; ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	/*** Lost password request ***/
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'lostpassword' ) :
		$thim_lostpass_msg = wp_kses_post( $_GET['thim_lostpass_msg'] ?? '' );
		if ( ! empty( $thim_lostpass_msg ) ) {
			echo sprintf( '<p class="message message-error">%s</p>', wp_kses_post( html_entity_decode( wp_unslash( $thim_lostpass_msg ) ) ) );
		}
		?>

		<div class="thim-login form-submission-lost-password">
			<h2 class="title"><?php esc_html_e( 'Get Your Password', 'eduma' ); ?></h2>

			<form name="lostpasswordform" id="lostpasswordform"
				  action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>"
				  method="post">
				<p class="description"><?php esc_html_e( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'eduma' ); ?></p>

				<p>
					<input placeholder="<?php esc_attr_e( 'Username or email', 'eduma' ); ?>" type="text"
						   name="user_login" class="input required"/>
					<input type="hidden" name="redirect_to"
						   value="<?php echo esc_attr( add_query_arg( 'result', 'reset', thim_get_login_page_url() ) ); ?>"/>
					<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large"
						   value="<?php esc_attr_e( 'Reset password', 'eduma' ); ?>"/>
					<input type="hidden" name="eduma_lostpass"/>
				</p>
				<?php do_action( 'lostpassword_form' ); ?>
			</form>
		</div>
		<?php return; ?>
	<?php endif; ?>

	<?php if ( isset( $_GET['action'] ) && $_GET['action'] == 'rp' ) : ?>
		<?php
		$thim_resetpass_msg = wp_kses_post( $_GET['thim_resetpass_msg'] ?? '' );
		if ( ! empty( $thim_resetpass_msg ) ) {
			echo sprintf( '<p class="message message-error">%s</p>', wp_kses_post( html_entity_decode( wp_unslash( $thim_resetpass_msg ) ) ) );
		}
		?>
		<div class="thim-login form-submission-change-password">
			<h2 class="title"><?php esc_html_e( 'Change Password', 'eduma' ); ?></h2>

			<form name="resetpassform" id="resetpassform"
				action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
				<input type="hidden" id="user_login" name="login"
					value="<?php echo isset( $_GET['login'] ) ? esc_attr( $_GET['login'] ) : ''; ?>"
					autocomplete="off"/>
				<input type="hidden" name="key" value="<?php echo isset( $_GET['key'] ) ? esc_attr( $_GET['key'] ) : ''; ?>"/>

				<p>
					<input placeholder="<?php esc_attr_e( 'New password', 'eduma' ); ?>" type="password" name="password"
						id="password" class="input"/>
				</p>

				<p class="resetpass-submit">
					<input type="submit" name="submit" id="resetpass-button" class="button"
						value="<?php _e( 'Reset Password', 'eduma' ); ?>"/>
				</p>

				<p class="message message-success">
					<?php esc_html_e( 'Hint: The password should be at least twelve characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).', 'eduma' ); ?>
				</p>

			</form>
		</div>
		<?php return; ?>
	<?php endif; ?>

	<?php
	/*** Send mail register success ***/
	if ( isset( $_GET['result'] ) && $_GET['result'] == 'registered' ) :
		echo '<p class="message message-success">' . esc_html__( 'Registration is successful. Confirmation will be e-mailed to you.', 'eduma' ) . '</p>';

		return;
	endif;
	?>

	<?php
	/*** Send mail reset success ***/
	if ( isset( $_GET['result'] ) && $_GET['result'] == 'reset' ) :
		echo '<p class="message message-success">' . esc_html__( 'Check your email to get a link to create a new password.', 'eduma' ) . '</p>';

		return;
	endif;
	?>

	<?php
	/*** Reset pass success ***/
	if ( isset( $_GET['result'] ) && $_GET['result'] == 'changed' ) :
		echo '<p class="message message-success">' . sprintf( wp_kses( __( 'Password changed. You can <a href="%s">login</a> now.', 'eduma' ), array( 'a' => array( 'href' => array() ) ) ), thim_get_login_page_url() ) . '</p>';

		return;
	endif;
	?>

<?php endif; ?>

<div id="thim-form-login">
	<div class="thim-login-container">
		<div class="thim-login form-submission-login">
			<h2 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h2>
			<form name="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>"
				method="post" novalidate>
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
				<?php if ( isset( $instance['captcha'] ) && $instance['captcha'] == 'yes' ) : ?>
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
					<label for="rememberMe">
						<input name="rememberme" type="checkbox" id="rememberMe"
							value="forever"/> <?php esc_html_e( 'Remember Me', 'eduma' ); ?>
					</label>
				</p>
				<p class="submit login-submit">
					<input type="submit" name="wp-submit" class="button button-primary button-large"
						value="<?php esc_attr_e( 'Login', 'eduma' ); ?>"/>
					<input type="hidden" name="redirect_to"
						value="<?php echo esc_attr( thim_eduma_get_current_url() ); ?>"/>
					<input type="hidden" name="testcookie" value="1"/>
					<input type="hidden" name="eduma_login_user">
				</p>
			</form>
			<?php
			$registration_enabled = get_option( 'users_can_register' );
			if ( $registration_enabled ) {
				echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'eduma' ) . ' <a href="' . esc_attr( thim_get_register_url() ) . '">' . esc_html__( 'Register now', 'eduma' ) . '</a></p>';
			}
			?>
		</div>
	</div>
</div>

