<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Login_Popup extends Widget_Base {

	public function get_name() {
		return 'thim-login-popup';
	}

	public function get_title() {
		return esc_html__( 'Login Popup', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-login-popup';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content',
			[
				'label' => esc_html__( 'Login Popup', 'eduma' )
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base' => esc_html__( 'Default', 'eduma' ),
					'icon' => esc_html__( 'Icon', 'eduma' ),
					'both' => esc_html__( 'Icon & Text', 'eduma' ),
				],
				'default' => 'base',
			]
		);
		$this->add_control(
			'sub_info',
			[
				'label'   => esc_html__( 'Show Sub Info User', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);
		if ( get_option( 'users_can_register' ) ) {
			$this->add_control(
				'text_register', [
					'label'       => esc_html__( 'Register Label', 'eduma' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Register', 'eduma' ),
					'placeholder' => esc_html__( 'Register', 'eduma' ),
					'condition'   => [
						'layout!' => 'icon'
					],
				]
			);
			$this->add_control(
				'register_icons',
				[
					'label'       => esc_html__( 'Register Icon', 'eduma' ),
					'type'        => Controls_Manager::ICONS,
					'skin'        => 'inline',
					'label_block' => false,
					'default'     => [
						'value'   => 'far fa-user',
						'library' => 'Font Awesome 5 Free',
					],
					'condition'   => [
						'layout!' => 'base'
					],
				]
			);
		}

		$this->add_control(
			'text_login', [
				'label'       => esc_html__( 'Login Label', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Login', 'eduma' ),
				'placeholder' => esc_html__( 'Login', 'eduma' ),
				'condition'   => [
					'layout!' => 'icon'
				],
			]
		);
		$this->add_control(
			'login_icons',
			[
				'label'       => esc_html__( 'Login Icon', 'eduma' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'far fa-user',
					'library' => 'Font Awesome 5 Free',
				],
				'condition'   => [
					'layout!' => 'base'
				],
			]
		);

		$this->add_control(
			'text_logout', [
				'label'       => esc_html__( 'Logout Label', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Logout', 'eduma' ),
				'placeholder' => esc_html__( 'Logout', 'eduma' ),
				'condition'   => [
					'layout!' => 'icon'
				],
			]
		);
		$this->add_control(
			'logout_icons',
			[
				'label'       => esc_html__( 'Logout Icon', 'eduma' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-share',
					'library' => 'Font Awesome 5 Free',
				],
				'condition'   => [
					'layout!' => 'base'
				],
			]
		);
		$this->add_control(
			'text_profile', [
				'label'       => esc_html__( 'Profile Label', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Profile', 'eduma' ),
				'placeholder' => esc_html__( 'Profile', 'eduma' ),
				'condition'   => [
					'layout!' => 'icon'
				],
			]
		);
		$this->add_control(
			'profile_url', [
				'label' => esc_html__( 'Profile Url', 'thim-elementor-kit' ),
				'type'  => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'profile_icons',
			[
				'label'       => esc_html__( 'Profile Icon', 'eduma' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'far fa-user',
					'library' => 'Font Awesome 5 Free',
				],
				'condition'   => [
					'layout!' => 'base'
				],
			]
		);
		$this->add_control(
			'captcha',
			[
				'label'   => esc_html__( 'Use Captcha?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);
		$this->add_control(
			'shortcode', [
				'label'       => esc_html__( 'ShortCode', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
 				'placeholder' => esc_html__( 'shortcode login social', 'eduma' ),
 			]
		);

		$this->add_control(
			'term',
			[
				'label'         => esc_html__( 'Terms of Service link', 'eduma' ),
				'description'   => esc_html__( 'Leave empty to disable this field.', 'eduma' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'eduma' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true
				],
			]
		);

		$this->end_controls_section();

		$this->register_style_setting_label();

		if ( get_option( 'users_can_register' ) ) {
			$this->register_style_setting_label_register( esc_html__( 'Register Label', 'eduma' ), 'register' );
		}

		$this->register_style_setting_label_register( esc_html__( 'Login Label', 'eduma' ), 'login' );
		$this->register_style_setting_label_register( esc_html__( 'Logout Label', 'eduma' ), 'logout' );
		$this->register_style_setting_label_register( esc_html__( 'Profile Label', 'eduma' ), 'profile' );
	}

	protected function register_style_setting_label() {

		$this->start_controls_section(
			'settings_style_tabs',
			[
				'label' => esc_html__( 'Settings Label', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-link-login a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.site-header .navbar-nav>li.menu-right {{WRAPPER}} .thim-link-login a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-link-login a'             => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .thim-link-login a:last-child'  => 'margin-right: 0;',
					'{{WRAPPER}} .thim-link-login a:first-child' => 'margin-left: 0;',
				],
			]
		);
		$this->add_responsive_control(
			'icon_space_right',
			[
				'label'      => esc_html__( 'Space icon', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-link-login a i'      => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .thim-link-login a i' => 'margin-right: 0; margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'layout!' => 'base'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'settings_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}  .thim-link-login a',
			]
		);

		$this->end_controls_section();

	}

	protected function register_style_setting_label_register( $label, $class ) {

		$this->start_controls_section(
			$class . '_settings_style_tabs',
			[
				'label' => $label,
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			$class . '_settings_border',
			[
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'   => esc_html__( 'None', 'eduma' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'eduma' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'eduma' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'eduma' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'eduma' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'eduma' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$class . '_border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					$class . '_settings_border!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( $class . '_tabs_color_settings_style' );
		$this->start_controls_tab(
			$class . '_tab_color_link_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);
		$this->add_control(
			$class . '_text_color',
			[
				'label'     => __( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			$class . '_border_text',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					$class . '_settings_border!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			$class . '_bg_text',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			$class . '_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-link-login .' . $class => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			$class . '_tab_color_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);
		$this->add_control(
			$class . '_text_color_hover',
			[
				'label'     => __( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class . ':hover' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			$class . '_border_text_hover',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class . ':hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					$class . '_settings_border!' => 'none'
				],
			]
		);
		$this->add_control(
			$class . '_bg_text_hover',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-link-login .' . $class . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			$class . '_border_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-link-login .' . $class . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
 		$class_sub_info = isset($settings['sub_info']) && $settings['sub_info'] ? ' has_sub_info' : '';
 		?>
		<div class="thim-link-login thim-login-popup<?php echo esc_attr($class_sub_info);?>">
			<?php
			$layout               = isset( $settings['layout'] ) ? $settings['layout'] : 'base';
			$registration_enabled = get_option( 'users_can_register' );

			$profile_text  = ( $layout != 'icon' && isset( $settings['text_profile'] ) ) ? $settings['text_profile'] : '';
			$logout_text   = ( $layout != 'icon' && isset( $settings['text_logout'] ) ) ? $settings['text_logout'] : '';
			$login_text    = ( $layout != 'icon' && isset( $settings['text_login'] ) ) ? $settings['text_login'] : '';
			$register_text = ( $layout != 'icon' && isset( $settings['text_register'] ) ) ? $settings['text_register'] : '';

			$show_icon_profile  = ( $layout == 'icon' && ! empty( $settings['profile_icons'] ) ) ? true : false;
			$show_icon_logout   = ( $layout == 'icon' && ! empty( $settings['logout_icons'] ) ) ? true : false;
			$show_icon_login    = ( $layout == 'icon' && ! empty( $settings['login_icons'] ) ) ? true : false;
			$show_icon_register = ( $layout == 'icon' && ! empty( $settings['register_icons']['library'] ) ) ? true : false;

			// Login popup link output
			if ( is_user_logged_in() ) {
				if(isset($settings['sub_info']) && $settings['sub_info']){
					echo thim_sub_info_login_popup($profile_text, $logout_text);
				}else{
					$link_profile = '';
					if ( class_exists( 'LearnPress' ) ) {
						$link_profile = learn_press_user_profile_link();
					}
					if ( isset( $settings['profile_url'] ) && $settings['profile_url'] ) {
						$link_profile = $settings['profile_url'];
					}

					if ( ( $profile_text || $show_icon_profile ) && $link_profile ) {
						echo '<a class="profile" href="' . esc_url( $link_profile ) . '">';
						Icons_Manager::render_icon( $settings['profile_icons'], [ 'aria-hidden' => 'true' ] );
						echo wp_kses_post( $profile_text );
						echo '</a>';
					}
					if ( $logout_text || $show_icon_logout ) {
						echo '<a class="logout" href="' . esc_url( wp_logout_url( apply_filters( 'thim_default_logout_redirect', thim_eduma_get_current_url() ) ) ) . '">';
						Icons_Manager::render_icon( $settings['logout_icons'], [ 'aria-hidden' => 'true' ] );
						echo wp_kses_post( $logout_text );
						echo '</a>';
					}
				}
			} else {
				if ( $registration_enabled && ( $register_text || $show_icon_register ) ) {
					echo '<a class="register js-show-popup" href="' . esc_url( thim_get_register_url() ) . '">';
					Icons_Manager::render_icon( $settings['register_icons'], [ 'aria-hidden' => 'true' ] );
					echo wp_kses_post($register_text);
					echo '</a>';
				}
				if ( $login_text || $show_icon_login ) {
					echo '<a class="login js-show-popup" href="' . esc_url( thim_get_login_page_url() ) . '">';
					Icons_Manager::render_icon( $settings['login_icons'], [ 'aria-hidden' => 'true' ] );
					echo wp_kses_post( $login_text );
					echo '</a>';
				}
			}
			// End login popup link output
			?>
		</div>
		<?php
		add_action( 'wp_footer', array( $this, 'display_login_popup_form' ), 5 );
	}

	public function display_login_popup_form() {
		$settings = $this->get_settings_for_display();

		if ( ! is_user_logged_in() ) {
			$registration_enabled = get_option( 'users_can_register' );
			?>
			<div id="thim-popup-login">
				<div
					class="popup-login-wrapper<?php echo ( ! empty( $settings['shortcode'] ) ) ? ' has-shortcode' : ''; ?>">
					<div class="thim-login-container">
						<?php
						if ( ! empty( $settings['shortcode'] ) ) {
							echo do_shortcode( $settings['shortcode'] );
						}
						?>

						<div class="thim-popup-inner">
							<div class="thim-login">
								<h4 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h4>
								<?php
								$captcha = isset( $settings['captcha'] ) && $settings['captcha'] ? $settings['captcha'] : 'no';
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
									if ( isset( $settings['term'] ) && ! empty( $settings['term']['url'] ) ) {
										$term['url']         = $settings['term']['url'];
										$term['is_external'] = $settings['term']['is_external'] ? $settings['term']['is_external'] : 'false';
										$term['nofollow']    = $settings['term']['nofollow'] ? $settings['term']['nofollow'] : 'false';
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
