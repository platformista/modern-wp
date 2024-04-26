<?php

if ( ! class_exists( 'Thim_Login_Popup_Widget' ) ) {
	class Thim_Login_Popup_Widget extends Thim_Widget {

		public $ins = array();

		function __construct() {
			parent::__construct(
				'login-popup',
				esc_html__( 'Thim: Login Popup', 'eduma' ),
				array(
					'panels_groups' => array( 'thim_builder_so_widgets' ),
					'panels_icon'   => 'thim-widget-icon thim-widget-icon-login-popup'
				),
				array(),
				array(
					'text_register' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Register Label', 'eduma' ),
						'default' => 'Register',
					),
					'text_login'    => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Login Label', 'eduma' ),
						'default' => 'Login',
					),
					'text_logout'   => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Logout Label', 'eduma' ),
						'default' => 'Logout',
					),
					'text_profile'  => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Profile Label', 'eduma' ),
						'default' => 'Profile',
					),
					'layout'        => array(
						'type'    => 'select',
						'label'   => esc_html__( 'Layout', 'eduma' ),
						'default' => 'base',
						'options' => array(
							'base' => esc_html__( 'Default', 'eduma' ),
							'icon' => esc_html__( 'Icon', 'eduma' ),
						)
					),
					'sub_info'   => array(
						'type'        => 'checkbox',
						'label'       => esc_html__( 'Show Sub Info User', 'eduma' ),
 						'default'     => false,
					),
					'captcha'   => array(
						'type'        => 'checkbox',
						'label'       => esc_html__( 'Use captcha?', 'eduma' ),
						'description' => esc_html__( 'Use captcha in register and login form.', 'eduma' ) . esc_html__( '(not show when Enable register form of LearnPress.)', 'eduma' ),
						'default'     => false,
					),
					'term'      => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Terms of Service link', 'eduma' ),
						'description' => esc_html__( 'Leave empty to disable this field.', 'eduma' ) . esc_html__( '(not show when Enable register form of LearnPress.)', 'eduma' ),
						'default'     => '',
					),
					'shortcode' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Shortcode', 'eduma' ),
						'description' => esc_html__( 'Enter shortcode to show in form Login.', 'eduma' ),
						'default'     => '',
					)

				)
			);

		}

		/**
		 * Initialize the CTA widget
		 */
		function get_template_name( $instance ) {
			$this->ins = $instance;
			add_action( 'wp_footer', array( $this, 'thim_display_login_popup_form' ), 5 );

 			return 'base';
		}

		function get_style_name( $instance ) {
			return false;
		}

		function thim_display_login_popup_form() {
			$instance = $this->ins;
			if ( ! is_user_logged_in() ) {
				$registration_enabled = get_option( 'users_can_register' );

				?>
				<div id="thim-popup-login">
					<div class="popup-login-wrapper<?php echo ( ! empty( $instance['shortcode'] ) ) ? ' has-shortcode' : ''; ?>">
						<div class="thim-login-container">
							<?php
							if ( ! empty( $instance['shortcode'] ) ) {
								echo do_shortcode( $instance['shortcode'] );
							}
							 ?>

							<div class="thim-popup-inner">
								<div class="thim-login">
									<h4 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h4>
									<?php
									$captcha = isset( $instance['captcha'] ) && $instance['captcha'] ? $instance['captcha'] : 'no';
									/*
									 * @hooked thim_form_login_widget - 10
									 */
									do_action( 'thim_form_login_widget', $captcha );

									if ( $registration_enabled ) {
										echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'eduma' ) . ' <a class="register" href="' . esc_url( thim_get_register_url() ) . '">' . esc_html__( 'Register now', 'eduma' ) . '</a></p>';
									}
									?>
									<?php do_action( 'thim-message-after-link-bottom' ); ?>
								</div>

								<?php if ( $registration_enabled ): ?>
									<div class="thim-register">
										<h4 class="title"><?php echo esc_html_x( 'Register a new account', 'Login popup form', 'eduma' ); ?></h4>
										<?php
										$term = array();
										if ( isset( $instance['term'] ) ) {
											$term['url']         = $instance['term'];
											$term['is_external'] = '_blank';
											$term['nofollow']    = '';
										}
										/*
										* @hooked thim_form_register_widget - 10
										 */
										do_action( 'thim_form_register_widget', $captcha, $term, 'current' );
										?>
										<?php echo '<p class="link-bottom">' . esc_html_x( 'Are you a member? ', 'Login popup form', 'eduma' ) . ' <a class="login" href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html_x( 'Login now', 'Login popup form', 'eduma' ) . '</a></p>'; ?>
										<?php do_action( 'thim-message-after-link-bottom' ); ?>
										<div class="popup-message"></div>
									</div>
								<?php endif; ?>
							</div>

							<span class="close-popup"><i class="fa fa-times" aria-hidden="true"></i></span>
							<div class="cssload-container">
								<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
 		}
	}
}

function thim_login_popup_widget() {
	register_widget( 'Thim_Login_Popup_Widget' );

}

add_action( 'widgets_init', 'thim_login_popup_widget' );
