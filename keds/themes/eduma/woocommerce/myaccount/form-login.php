<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="col2-set" id="customer_login">

	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="col-1 login-area" id="woo-login-area">

		<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'eduma' ); ?></h2>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-row form-row-wide">
				<input type="text" class="input-text" name="username" id="username" autocomplete="username"
					   placeholder="<?php esc_attr_e( 'Username or email address', 'eduma' ); ?>"
					   value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/>
			</p>

			<p class="form-row form-row-wide">
				<input class="input-text" type="password" name="password" id="password" autocomplete="current-password"  placeholder="<?php esc_attr_e( 'Password', 'eduma' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="row">
				<div class="col-xs-6 remember">
					<label for="rememberme" class="inline">
						<input name="rememberme" type="checkbox" id="rememberme"
							   value="forever"/> <?php esc_html_e( 'Remember me', 'eduma' ); ?>
					</label>
				</div>

				<div class="col-xs-6 lost-password">
					<p class="lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'eduma' ); ?></a>
					</p>
				</div>
			</div>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'eduma' ); ?>"/>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-2 register-area" id="woo-register-area">

		<h2 class="title"><?php esc_html_e( 'Register', 'eduma' ); ?></h2>

		<form method="post" class="register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<input type="text" class="input-text" name="username" id="reg_username"
						   placeholder="<?php esc_html_e( 'Username', 'eduma' ); ?>"  autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<input type="email" class="input-text" name="email" id="reg_email"
					   placeholder="<?php esc_html_e( 'Email address', 'eduma' ); ?>" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<input type="password" class="input-text" name="password" id="reg_password"
						   placeholder="<?php esc_html_e( 'Password', 'eduma' ); ?>"   autocomplete="new-password"/>
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button" name="register"
					   value="<?php esc_attr_e( 'Register', 'eduma' ); ?>"/>
			</p>

 			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>
<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
