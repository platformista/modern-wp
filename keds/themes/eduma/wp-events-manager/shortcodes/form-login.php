<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="thim-login">
    <h2 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h2>
	<?php
	wp_login_form(
		array(
			'redirect'       => ! empty( $_REQUEST['redirect_to'] ) ? esc_url( $_REQUEST['redirect_to'] ) : apply_filters( 'thim_default_login_redirect', home_url() ),
			'id_username'    => 'thim_login',
			'id_password'    => 'thim_pass',
			'label_username' => esc_html__( 'Username or email', 'eduma' ),
			'label_password' => esc_html__( 'Password', 'eduma' ),
			'label_remember' => esc_html__( 'Remember me', 'eduma' ),
			'label_log_in'   => esc_html__( 'Login', 'eduma' ),
		)
	);
	?>
	<?php echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'eduma' ) . ' <a href="' . esc_url( thim_get_register_url() ) . '">' . esc_html__( 'Register now', 'eduma' ) . '</a></p>'; ?>
</div>
