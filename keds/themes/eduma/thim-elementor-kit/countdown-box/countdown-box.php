<?php
// use \Elementor\Plugin;
namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Countdown_Box extends Widget_Base {

	public function get_name() {
		return 'thim-countdown-box';
	}

	public function get_title() {
		return esc_html__( 'Countdown Box', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-countdown-box';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'config',
			[
				'label' => __( 'Countdown', 'eduma' )
			]
		);
		$this->add_control(
			'countdown_due_time',
			[
				'label'       => esc_html__( 'Countdown Due Date', 'eduma' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => date( "Y-m-d", strtotime( "+ 1 day" ) ),
				'description' => esc_html__( 'Set the due date and time', 'eduma' ),
			]
		);
		$this->add_control(
			'text_days',
			[
				'label'       => __( 'Text Days', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Days', 'eduma' ),
			]
		);

		$this->add_control(
			'text_hours',
			[
				'label'       => __( 'Text Hours', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Hours', 'eduma' ),
			]
		);

		$this->add_control(
			'text_minutes',
			[
				'label'       => __( 'Text Minutes', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Minutes', 'eduma' ),
			]
		);

		$this->add_control(
			'text_seconds',
			[
				'label'       => __( 'Text Seconds', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Seconds', 'eduma' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'     => __( 'Layout', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'base'         => esc_html__( 'Default', 'eduma' ),
					'pie'          => esc_html__( 'Pie', 'eduma' ),
					'pie-gradient' => esc_html__( 'Pie Gradient', 'eduma' ),
					'square'       => esc_html__( 'Square', 'eduma' ),
				],
				'default'   => 'base',
				'separator' => 'before'
			]
		);

		//		$this->add_control(
		//			'style_color',
		//			[
		//				'label'   => __( 'Style', 'eduma' ),
		//				'type'    => Controls_Manager::SELECT,
		//				'options' => [
		//					'white' => esc_html__( 'White', 'eduma' ),
		//					'black' => esc_html__( 'Black', 'eduma' )
		//				],
		//				'default' => 'white',
		//			]
		//		);

		$this->add_control(
			'text_align',
			[
				'label'     => __( 'Alignment', 'eduma' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'eduma' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .thim-countdown' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,

			]
		);
		$this->add_control(
			'bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'layout' => [ 'base','square' ]
				],
				'selectors' => [
					'{{WRAPPER}} .thim-countdown .counter-group .counter-block' => 'background-color: {{VALUE}};'
 				],
			]
		);
		$this->add_control(
			'color',
			[
				'label'     => esc_html__( 'Text Number Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-countdown .counter-group .counter-block .counter' => 'color: {{VALUE}};',
					'.ClassyCountdown-wrapper .ClassyCountdown-value>div' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'color_caption',
			[
				'label'     => esc_html__( 'Text caption Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-countdown .counter-group .counter-block .counter-caption' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ClassyCountdown-wrapper .ClassyCountdown-value span' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'line_button-color',
			[
				'label'     => esc_html__( 'Line Button Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'layout' => [ 'square' ]
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-square .counter-group .counter-block:after' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'countdown_border',
				'label' => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-countdown .counter-group .counter-block',
			'condition' => [
					'layout' => [ 'base','square' ]
				],
			]
		);


		$this->add_control(
			'countdown_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'condition' => [
					'layout' => [ 'base','square' ]
				],
				'selectors'  => array(
					'{{WRAPPER}} .thim-countdown .counter-group .counter-block'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
 				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		if ( $settings['layout'] == 'base' || $settings['layout'] == 'square' ) {
			$this->render_base( $settings );
		} else {
			$this->render_base_pie( $settings );
		}

	}

	protected function render_base( $settings ) {
		$class = '';
		wp_enqueue_script( 'mb-commingsoon' );
		$countdown_due_time = isset( $settings['countdown_due_time'] ) ? date_format( date_create( $settings['countdown_due_time'] ), "Y/m/d H:i" ) : '';
		if ( isset( $settings['style_color'] ) && $settings['style_color'] == 'black' ) {
			$class = ' color-black';
		}
		// old data
		if ( isset( $settings['text_align'] ) && ( $settings['text_align'] == 'text-center' || $settings['text_align'] == 'text-right' ) ) {
			$class .= ' ' . $settings['text_align'];
		}

		if ( $settings['layout'] != '' ) {
			$class .= ' countdown-' . $settings['layout'];
		}

		echo '<div class="thim-countdown' . $class . '" id="coming-soon-counter' . $this->get_id() . '">'.$this->render_edit_mode().'</div>';
		// if (Plugin::instance()->editor->is_edit_mode()) {
			wp_enqueue_script( 'mb-commingsoon' );
		?>
		<script data-cfasync="true" type="text/javascript">
			(function ($) {
				'use strict';
				$(document).ready(function () {
					if (jQuery().mbComingsoon) {
						$("#coming-soon-counter<?php echo esc_js( $this->get_id() ); ?>").mbComingsoon({
							expiryDate  : new Date('<?php echo( $countdown_due_time ); ?>'),
							localization: {
								days   : "<?php echo esc_js( $settings['text_days'] ); ?>",
								hours  : "<?php echo esc_js( $settings['text_hours'] ); ?>",
								minutes: "<?php echo esc_js( $settings['text_minutes'] ); ?>",
								seconds: "<?php echo esc_js( $settings['text_seconds'] ); ?>",
							},
							speed       : 100,
						});
						setTimeout(function () {
							jQuery(window).resize();
						}, 200);
					}
				});
			})(jQuery);
		</script>
		<?php
		// }
	}

	protected function render_base_pie( $settings ) {
 		wp_enqueue_script( 'jquery-classycountdown', THIM_URI . 'inc/widgets/countdown-box/js/jquery.classycountdown.js', array( 'jquery' ), null );
		wp_enqueue_script( 'jquery-throttle', THIM_URI . 'inc/widgets/countdown-box/js/jquery.throttle.js', array( 'jquery' ), null );
		wp_enqueue_script( 'jquery-knob', THIM_URI . 'inc/widgets/countdown-box/js/jquery.knob.js', array( 'jquery' ), null );

		$countdown_due_time = isset( $settings['countdown_due_time'] ) ? date_format( date_create( $settings['countdown_due_time'] ), "Y/m/d H:i" ) : '';

		if ( $settings['layout'] == 'pie' ) {
			echo '<div id="countdown' . esc_attr( $this->get_id() ) . '"  class="thim-countdown thim_countdown_pie style_white_wide">'.$this->render_edit_mode().'</div>';
			$theme = 'white-wide';
		} else {
			echo '<div id="countdown' . esc_attr( $this->get_id() ) . '"  class="thim-countdown thim_countdown_pie style_black_wide"></div>';
			$theme = 'black-wide-gradient';
		}
		// if (Plugin::instance()->editor->is_edit_mode()) {
 		?>

		<script type="text/javascript">
			(function ($) {
				'use strict';
				$(document).ready(function () {
					$('#countdown<?php echo esc_js( $this->get_id() );?>').ClassyCountdown({
						theme        : "<?php echo esc_js( $theme );?>",
						labels       : true,
						labelsOptions: {
							lang : {
								days   : "<?php echo esc_js( $settings['text_days'] ); ?>",
								hours  : "<?php echo esc_js( $settings['text_hours'] ); ?>",
								minutes: "<?php echo esc_js( $settings['text_minutes'] ); ?>",
								seconds: "<?php echo esc_js( $settings['text_seconds'] ); ?>",
							},
							style: 'font-size: 0.5em;',
						},
						now          : '<?php echo strtotime( "now" );?>',
						end          : '<?php echo strtotime( $countdown_due_time );?>',
					});
				});
			})(jQuery);
		</script>
		<?php
		// }
	}
	public function render_edit_mode() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$html = '<div class="counter-group">';
			for ( $i = 0; $i <= 3; $i ++ ) {
				$html .= '<div class="counter-block">
					<div class="counter days">
 						<div class="number show n1 tens">0</div>
						<div class="number show n1 units">0</div> 
					</div>
					<div class="counter-caption">Label</div>
				</div>';
			}
			$html .=  '</div>';
			return $html;
		}
	}
}
