<?php

/**
 * Class Thim_Widget
 *
 * @since 0.9.0
 */
if ( ! class_exists( 'Thim_Widget' ) ) {
	abstract class Thim_Widget extends WP_Widget {

		protected $form_options;
		protected $base_folder;
		protected $field_ids;

		/**
		 * @var array The array of registered frontend scripts
		 */
		protected $frontend_scripts = array();

		/**
		 * @var array The array of registered frontend styles
		 */
		protected $frontend_styles = array();

		/**
		 *
		 * @param string $id
		 * @param string $name
		 * @param array  $widget_options  Optional Normal WP_Widget widget options and a few extras.
		 *                                - help: A URL which, if present, causes a help link to be displayed on the Edit Widget modal.
		 *                                - instance_storage: Whether or not to temporarily store instances of this widget.
		 * @param array  $control_options Optional Normal WP_Widget control options.
		 * @param array  $form_options    Optional An array describing the form fields used to configure SiteOrigin widgets.
		 * @param mixed  $base_folder     Optional
		 */
		public function __construct( $id, $name, $widget_options = array(), $control_options = array(), $form_options = array(), $base_folder = false ) {
			$this->form_options = $form_options;
			$this->base_folder  = $base_folder;
			$this->field_ids    = array();

			$control_options = wp_parse_args(
				$control_options,
				array(
					'width' => 600,
				)
			);

			parent::__construct( $id, $name, $widget_options, $control_options );
		}

		/**
		 * Get the form options and allow child widgets to modify that form.
		 *
		 * @return mixed
		 */
		public function form_options() {
			return $this->modify_form( $this->form_options );
		}

		/**
		 * Display the widget.
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$instance = $this->modify_instance( $instance );

			$args = wp_parse_args(
				$args,
				array(
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => '',
				)
			);

			$instance = $this->add_defaults( $this->form_options, $instance );

			$css_name = $this->id_base . '-base';

			$this->enqueue_frontend_scripts();
			$this->enqueue_instance_frontend_scripts( $instance );

			extract( $this->get_template_variables( $instance, $args ) );

			$widget_template       = TP_THEME_THIM_DIR . 'inc/widgets/' . $this->id_base . '/tpl/' . $this->get_template_name( $instance ) . '.php';
			$child_widget_template = TP_CHILD_THEME_THIM_DIR . 'inc/widgets/' . $this->id_base . '/' . $this->get_template_name( $instance ) . '.php';

			// Override the widget in child theme.
			if ( file_exists( $child_widget_template ) ) {
				$widget_template = $child_widget_template;
			}

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<div class="thim-widget-' . esc_attr( $this->id_base ) . ' thim-widget-' . $css_name . ' template-' . $this->get_template_name( $instance ) . '">';
			if ( file_exists( $widget_template ) ) {
				include $widget_template;
			}
			echo '</div>';
			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Add default values to the instance.
		 *
		 * @param $form
		 * @param $instance
		 * @param $level
		 */
		function add_defaults( $form, $instance ) {
			foreach ( $form as $id => $field ) {
				if ( $field['type'] == 'repeater' && ! empty( $instance[ $id ] ) ) {
					foreach ( array_keys( $instance[ $id ] ) as $i ) {
						$instance[ $id ][ $i ] = $this->add_defaults( $field['fields'], $instance[ $id ][ $i ] );
					}
				} else {
					if ( ! isset( $instance[ $id ] ) && isset( $field['default'] ) ) {
						$instance[ $id ] = $field['default'];
					}
				}
			}

			return $instance;
		}

		/**
		 * Display the widget form.
		 *
		 * @param array $instance
		 *
		 * @return string|void
		 */
		public function form( $instance ) {
			$this->enqueue_scripts();

			$instance = $this->modify_instance( $instance );

			$form_id = 'thim_widget_form_' . uniqid();
			?>

			<div
				id="<?php echo esc_attr( $form_id ); ?>"
				class="thim-widget-form thim-widget-form-main"
				data-class="<?php echo esc_attr( get_class( $this ) ); ?>"
			>
				<?php
				foreach ( $this->form_options() as $field_name => $field ) {
					$this->render_field( $field_name, $field, $instance[ $field_name ] ?? null, false );
				}
				?>
			</div>

			<?php if ( ! empty( $this->widget_options['help'] ) ) : ?>
				<a href="<?php echo esc_url( $this->widget_options['help'] ); ?>" class="thim-widget-help-link thim-panels-help-link" target="_blank" rel="noopener">
					<?php esc_html_e( 'Help', 'thim-framework' ); ?>
				</a>
			<?php endif; ?>

			<script>
				(function ($) {
					if (typeof $.fn.obSetupForm != 'undefined') {
						$('#<?php echo esc_js( $form_id ); ?>').obSetupForm();
					} else {
						// Init once admin scripts have been loaded
						$(window).load(function() {
							$('#<?php echo esc_js( $form_id ); ?>').obSetupForm();
						});
					}
					if (!$('#thim-widget-admin-css').length && $.isReady) {
						alert('<?php esc_html_e( 'Please refresh this page to start using this widget.', 'thim-framework' ); ?>')
					}
				})(jQuery);
			</script>

			<?php
		}

		/**
		 * Enqueue the admin scripts for the widget form.
		 */
		public function enqueue_scripts() {
			if ( ! wp_script_is( 'thim-widget-admin' ) ) {
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style( 'thim-widget-admin', THIM_CORE_ADMIN_URI . '/assets/css/widget-admin.css', array( 'media-views' ), THIM_CORE_VERSION );
				wp_enqueue_style( 'thim-font-awesome' );

				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_media();

				wp_enqueue_script( 'thim-widget-admin', THIM_CORE_ADMIN_URI . '/assets/js/widget-admin.min.js', array( 'jquery', 'jquery-ui-sortable' ), THIM_CORE_VERSION, true );

				wp_localize_script(
					'thim-widget-admin',
					'soWidgets',
					array(
						'ajaxurl' => wp_nonce_url( admin_url( 'admin-ajax.php' ), 'widgets_action', '_widgets_nonce' ),
						'sure'    => esc_html__( 'Are you sure?', 'thim-framework' ),
					)
				);
			}

			$this->enqueue_admin_scripts();
		}

		/**
		 * Update the widget instance.
		 *
		 * @param array $new_instance
		 * @param array $old_instance
		 *
		 * @return array|void
		 */
		public function update( $new_instance, $old_instance ) {
			$new_instance = $this->sanitize( $new_instance, $this->form_options() );

			return $new_instance;
		}

		/**
		 * @param $instance
		 * @param $fields
		 */
		public function sanitize( $instance, $fields ) {
			if ( empty( $fields ) ) {
				$fields = $this->form_options();
			}

			foreach ( $fields as $name => $field ) {
				if ( empty( $instance[ $name ] ) ) {
					$instance[ $name ] = false;
				}

				switch ( $field['type'] ) {
					case 'select':
						if ( is_array( $instance[ $name ] ) ) { // Multilple select
							$instance[ $name ] = array_map( 'sanitize_text_field', $instance[ $name ] );
						} else {
							$instance[ $name ] = sanitize_text_field( $instance[ $name ] );
						}
						break;

					case 'radio':
						$keys = array_keys( $field['options'] );

						if ( ! in_array( $instance[ $name ], $keys ) ) {
							$instance[ $name ] = isset( $field['default'] ) ? $field['default'] : false;
						}
						break;

					case 'number':
					case 'slider':
						$instance[ $name ] = (float) $instance[ $name ];
						break;

					case 'textarea':
						$instance[ $name ] = wp_kses( trim( wp_unslash( $instance[ $name ] ) ), wp_kses_allowed_html( 'post' ) );
						break;

					case 'text':
						if ( empty( $field['allow_html_formatting'] ) ) {
							$instance[ $name ] = sanitize_text_field( $instance[ $name ] );
						} else {
							$instance[ $name ] = wp_kses( $instance[ $name ], $field['allow_html_formatting'] );
						}
						break;

					case 'textarea_raw_html':
						$instance[ $name ] = $instance[ $name ];
						break;

					case 'color':
						if ( ! preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $instance[ $name ] ) ) {
							$instance[ $name ] = false;
						}
						break;

					case 'media':
						$instance[ $name ] = intval( $instance[ $name ] );
						break;

					case 'checkbox':
						$instance[ $name ] = ! empty( $instance[ $name ] );
						break;

					case 'repeater':
						if ( ! empty( $instance[ $name ] ) ) {
							foreach ( $instance[ $name ] as $i => $sub_instance ) {
								$instance[ $name ][ $i ] = $this->sanitize( $sub_instance, $field['fields'] );
							}
						}
						break;

					case 'section':
						$instance[ $name ] = $this->sanitize( $instance[ $name ], $field['fields'] );
						break;

					default:
						$instance[ $name ] = sanitize_text_field( $instance[ $name ] );
						break;
				}

				$instance[ $name ] = apply_filters( 'thim_core_widgets_sanitize_field_' . $field['type'], $instance[ $name ], $field, $name );
			}

			return $instance;
		}

		/**
		 * @param        $field_name
		 * @param array      $repeater
		 * @param string     $repeater_append
		 *
		 * @return mixed|string
		 */
		private function thim_get_field_name( $field_name, $repeater = array(), $repeater_append = '[]' ) {
			if ( empty( $repeater ) ) {
				return $this->get_field_name( $field_name );
			} else {
				$repeater_extras = '';

				foreach ( $repeater as $r ) {
					$repeater_extras .= '[' . $r['name'] . ']';

					if ( isset( $r['type'] ) && $r['type'] === 'repeater' ) {
						$repeater_extras .= '[#' . $r['name'] . '#]';
					}
				}

				$name = $this->get_field_name( '{{{FIELD_NAME}}}' );

				$name = str_replace( '[{{{FIELD_NAME}}}]', $repeater_extras . '[' . esc_attr( $field_name ) . ']', $name );

				return $name;
			}
		}

		/**
		 * Get the ID of this field.
		 *
		 * @param         $field_name
		 * @param array      $repeater
		 * @param boolean    $is_template
		 *
		 * @return string
		 */
		private function thim_get_field_id( $field_name, $repeater = array(), $is_template = false ) {
			if ( empty( $repeater ) ) {
				return $this->get_field_id( $field_name );
			} else {
				$name = array();

				foreach ( $repeater as $key => $val ) {
					$name[] = $val['name'];
				}

				$name[]        = $field_name;
				$field_id_base = $this->get_field_id( implode( '-', $name ) );

				if ( $is_template ) {
					return $field_id_base . '-{id}';
				}

				if ( ! isset( $this->field_ids[ $field_id_base ] ) ) {
					$this->field_ids[ $field_id_base ] = 1;
				}

				$curId = $this->field_ids[ $field_id_base ] ++;

				return $field_id_base . '-' . $curId;
			}
		}

		/**
		 * Render a form field
		 *
		 * @param       $name
		 * @param       $field
		 * @param       $value
		 * @param array $repeater
		 */
		public function render_field( $name, $field, $value, $repeater = array(), $is_template = false ) {
			if ( is_null( $value ) && isset( $field['default'] ) ) {
				$value = $field['default'];
			}

			$wrapper_attributes = array(
				'class' => array(
					'thim-widget-field',
					'thim-widget-field-type-' . $field['type'],
					'thim-widget-field-' . $name,
				),
			);

			if ( ! empty( $field['class'] ) ) {
				$wrapper_attributes['class'][] = $field['class'];
			}

			if ( ! empty( $field['state_name'] ) ) {
				$wrapper_attributes['class'][] = 'thim-widget-field-state-' . $field['state_name'];
			}
			if ( ! empty( $field['hidden'] ) ) {
				$wrapper_attributes['class'][] = 'thim-widget-field-is-hidden';
			}
			if ( ! empty( $field['optional'] ) ) {
				$wrapper_attributes['class'][] = 'thim-widget-field-is-optional';
			}
			$wrapper_attributes['class'] = implode( ' ', array_map( 'sanitize_html_class', $wrapper_attributes['class'] ) );

			if ( ! empty( $field['state_emitter'] ) ) {
				// State emitters create new states for the form
				$wrapper_attributes['data-state-emitter'] = wp_json_encode( $field['state_emitter'] );
			}

			if ( ! empty( $field['state_handler'] ) ) {
				// State handlers decide what to do with form states
				$wrapper_attributes['data-state-handler'] = wp_json_encode( $field['state_handler'] );
			}

			if ( ! empty( $field['state_handler_initial'] ) ) {
				// Initial state handlers are only run when the form is first loaded
				$wrapper_attributes['data-state-handler-initial'] = wp_json_encode( $field['state_handler_initial'] );
			}
			?>

			<div
				<?php
				foreach ( $wrapper_attributes as $attr => $attr_val ) {
					echo ent2ncr( $attr . '="' . esc_attr( $attr_val ) . '" ' );
				}
				?>
			>
			<?php
			$field_id = $this->thim_get_field_id( $name, $repeater, $is_template );

			if ( ! in_array( $field['type'], array( 'repeater', 'checkbox', 'separator' ) ) && ! empty( $field['label'] ) ) {
				?>
				<label for="<?php echo esc_attr( $field_id ); ?>" class="thim-widget-field-label <?php empty( $field['hide'] ) ? 'thim-widget-section-visible' : ''; ?>">
					<?php echo wp_kses_post( $field['label'] ); ?>
				</label>
				<?php
			}

			switch ( $field['type'] ) {
				case 'text':
					?>
					<input
						type="text"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						class="widefat thim-widget-input"
					/>
					<?php
					break;

				case 'color':
					?>
					<input
						type="text"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						class="widefat thim-widget-input thim-widget-input-color"
					/>
					<?php
					break;

				case 'number':
					?>
					<input
						type="number"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						value="<?php echo esc_attr( $value ); ?>"
						class="widefat thim-widget-input thim-widget-input-number"
					/>
						<?php
						if ( ! empty( $field['suffix'] ) ) {
							echo ' (' . esc_html( $field['suffix'] ) . ') ';
						}
					break;

				case 'radioimage':
					foreach ( $field['options'] as $key => $image_url ) {
						// Get the correct value, we might get a blank if index / value is 0
						if ( $value == '' ) {
							$value = $key;
						}
						?>
						<label class='tp-radio-image'>
							<input
								type="radio"
								name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
								value="<?php echo esc_attr( $key ); ?>"
								<?php checked( $value, $key ); ?>
							/>
							<img src="<?php echo esc_url_raw( $image_url ); ?>"/>
						</label>
						<?php
					}
					break;

				case 'textarea':
				case 'textarea_raw_html':
					?>
					<textarea
						type="text"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater, $is_template ) ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						class="widefat thim-widget-input"
						rows="<?php echo ! empty( $field['rows'] ) ? intval( $field['rows'] ) : 4; ?>"
					><?php echo esc_textarea( $value ); ?></textarea>
					<?php
					break;

				case 'extra_textarea':
					$param_value = str_replace( ',', "\n", esc_textarea( $value ) );
					?>
					<textarea
						class="widefat"
						id="<?php echo esc_attr( $field_id ); ?>"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						rows="6"
					>
						<?php echo ent2ncr( $param_value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</textarea>
					<?php
					break;

				case 'editor':
					?>
					<textarea
						type="text"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						class="widefat thim-widget-input thim-widget-input-editor"
						rows="<?php echo ! empty( $field['rows'] ) ? intval( $field['rows'] ) : 4; ?>"
					>
						<?php echo esc_textarea( $value ); ?>
					</textarea>
					<?php
					break;

				case 'radio':
					?>
					<?php foreach ( $field['options'] as $k => $v ) : ?>
						<label for="<?php echo esc_attr( $field_id ) . '-' . $k; ?>">
							<input
								type="radio"
								name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
								id="<?php echo esc_attr( $field_id ) . '-' . $k; ?>"
								class="ob-widget-input"
								value="<?php echo esc_attr( $k ); ?>"
								<?php checked( $k, $value ); ?>
							>
							<?php echo esc_html( $v ); ?>
						</label>
					<?php endforeach; ?>
					<?php
					break;

				case 'slider':
					?>
					<div class="thim-widget-slider-value">
						<?php echo ! empty( $value ) ? $value : 0; ?>
					</div>
					<div class="thim-widget-slider-wrapper">
						<div class="thim-widget-value-slider"></div>
					</div>
					<input
						type="number"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						value="<?php echo ! empty( $value ) ? esc_attr( $value ) : 0; ?>"
						min="<?php echo isset( $field['min'] ) ? intval( $field['min'] ) : 0; ?>"
						max="<?php echo isset( $field['max'] ) ? intval( $field['max'] ) : 100; ?>"
						data-integer="<?php echo ! empty( $field['integer'] ) ? 'true' : 'false'; ?>"/>
					<?php
					break;

				case 'select':
					?>
					<select
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?><?php echo ! empty( $field['multiple'] ) ? '[]' : ''; ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						class="thim-widget-input thim-widget-select ob-widget-input"
						<?php echo ! empty( $field['multiple'] ) ? 'multiple' : ''; ?>
					>
						<?php if ( isset( $field['prompt'] ) ) : ?>
							<option value="default" disabled="disabled" selected="selected"><?php echo esc_html( $field['prompt'] ); ?></option>
						<?php endif; ?>

						<?php foreach ( $field['options'] as $key => $val ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php echo is_array( $value ) ? selected( true, in_array( $key, $value ), false ) : selected( $key, $value, false ); ?>>
								<?php echo esc_html( $val ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<?php
					break;

				case 'checkbox':
					?>
					<label for="<?php echo esc_attr( $field_id ); ?>">
						<input
							type="checkbox"
							name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
							id="<?php echo esc_attr( $field_id ); ?>"
							class="thim-widget-input"
							<?php checked( ! empty( $value ) ); ?>
						/>
						<?php echo wp_kses_post( $field['label'] ); ?>
					</label>
					<?php
					break;

				case 'media':
					$src = ! empty( $value ) ? wp_get_attachment_image_src( $value, 'thumbnail' ) : false;
					?>
					<div class="media-field-wrapper">
						<div class="current">
							<div class="thumbnail-wrapper">
								<?php if ( $src ) : ?>
									<img src="<?php echo esc_url( $src[0] ); ?>" class="thumbnail"/>
								<?php else : ?>
									<img src="" class="thumbnail" style="display: none;"/>
								<?php endif; ?>
							</div>
						</div>
						<a
							href="#"
							class="media-upload-button"
							data-choose="<?php echo $args['choose'] ?? 'Choose Media'; ?>"
							data-update="<?php echo $args['update'] ?? 'Set Media'; ?>"
							data-library="<?php echo $field['library'] ?? 'image'; ?>"
						>
							<?php echo $args['choose'] ?? 'Choose Media'; ?>
						</a>
						<a href="#" class="media-remove-button">Remove</a>
					</div>

					<input
						type="hidden"
						value="<?php echo esc_attr( is_array( $value ) ? '-1' : $value ); ?>"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						class="thim-widget-input"
					/>
					<div class="clear"></div>
					<?php
					break;

				case 'multimedia':
					$data = ! empty( $value ) ? explode( ',', $value ) : array();
					$data = is_array( $data ) ? $data : array( $value );
					?>

					<div class="multi-media-field-wrapper">
						<ul class="media-content">
							<?php foreach ( $data as $v ) : ?>
								<?php $src = wp_get_attachment_image_src( $v, 'thumbnail' ); ?>
									<?php if ( ! empty( $src ) ) : ?>
										<li id="<?php echo esc_attr( $v ); ?>" class="current">
											<div class="thumbnail-wrapper">
												<img src="<?php echo esc_url( $src[0] ); ?>" class="thumbnail"/>
												<a href="#" class="multimedia-remove-button">Remove</a>
											</div>
										</li>
									<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						<a
							href="#"
							class="media-upload-button"
							data-choose="<?php echo $args['choose'] ?? 'Choose Media'; ?>"
							data-update="<?php echo $args['update'] ?? 'Set Media'; ?>"
							data-library="<?php echo $field['library'] ?? 'image'; ?>"
						>
							<?php echo $args['choose'] ?? 'Choose Media'; ?>
						</a>

					</div>

					<input
						type="hidden"
						value="<?php echo esc_attr( is_array( $value ) ? '-1' : $value ); ?>"
						name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>"
						class="thim-widget-input"
					/>
					<div class="clear"></div>
					<?php
					break;

				case 'repeater':
					if ( empty( $field['fields'] ) ) {
						return;
					}

					if ( ! $repeater ) {
						$repeater = array();
					}

					$repeater[] = array(
						'name' => $name,
						'type' => 'repeater',
					);

					$html = array();

					foreach ( $field['fields'] as $sub_field_name => $sub_field ) {
						ob_start();
						$this->render_field( $sub_field_name, $sub_field, $value[ $sub_field_name ] ?? null, $repeater, true );
						$html[] = ob_get_clean();
					}
					?>

					<div
						class="thim-widget-field-repeater"
						data-item-name="<?php echo ! empty( $field['item_name'] ) ? esc_attr( $field['item_name'] ) : 'Item'; ?>"
						data-repeater-name="<?php echo esc_attr( $name ); ?>"
						data-repeater-add="<?php echo htmlentities( implode( '', $html ) ); ?>"
					>
						<div class="thim-widget-field-repeater-top">
							<div class="thim-widget-field-repeater-expend"></div>
							<h3><?php echo esc_html( $field['label'] ); ?></h3>
						</div>
						<div class="thim-widget-field-repeater-items">
							<?php
							if ( ! empty( $value ) ) {
								foreach ( $value as $v ) {
									?>
									<div class="thim-widget-field-repeater-item ui-draggable">
										<div class="thim-widget-field-repeater-item-top">
											<div class="thim-widget-field-expand"></div>
											<div class="thim-widget-field-remove"></div>
											<h4><?php echo esc_html( $field['item_name'] ); ?></h4>
										</div>
										<div class="thim-widget-field-repeater-item-form">
											<?php
											foreach ( $field['fields'] as $sub_field_name => $sub_field ) {
												$this->render_field( $sub_field_name, $sub_field, $v[ $sub_field_name ] ?? null, $repeater, false );
											}
											?>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
						<div class="thim-widget-field-repeater-add">
							<?php esc_html_e( 'Add', 'thim-framework' ); ?>
						</div>
					</div>
					<?php
					break;

				case 'icon':
				case 'icon-7-stroke':
				 	$icon = include THIM_CORE_ADMIN_PATH . '/assets/icons-widget.php';

 					$icons        = apply_filters( 'thim_core_widget_standard_icons', $icon[ $field['type'] ] );
					$unique_id    = 'search-' . uniqid();

					if ( ! empty( $field['settings'] ) ) {
						$icons = apply_filters( 'thim-builder-so-' . $field['settings']['type'] . '-icon', array() );
						if ( isset( $field['settings']['prefix_icon'] ) ) {
							$prefix_class = $field['settings']['prefix_icon'];
						} else {
							$prefix_class = '';
						}

						if ( isset( $field['settings']['enqueue_style'] ) ) {
							wp_enqueue_style( $field['settings']['enqueue_style'] );
						}
					} else {
						if ( $field['type'] == 'icon-7-stroke' ) {
							$prefix_class = 'pe-7s-';
						} else {
							$prefix_class = 'fa fa-';
						}
						$icons = apply_filters( 'thim_core_widget_standard_icons', $icon[ $field['type'] ] );
					}
					?>

					<div class="wrapper_icon">
						<input type="hidden" name="<?php echo esc_attr( $this->thim_get_field_name( $name, $repeater ) ); ?>" value="<?php echo esc_attr( $value ); ?>"/>
						<div class="thim-widget-icon-picker">
							<div class="icon-preview"><i class="<?php echo esc_attr( $prefix_class . $value ); ?>"></i></div>
							<input class="search <?php echo esc_attr( $unique_id ); ?>" type="text" placeholder="Search" />
						</div>

						<div id="icon-dropdown">
							<ul class="icon-list">
								<?php foreach ( $icons as $icon ) : ?>
									<li <?php echo $icon == esc_attr( $value ) ? 'class="selected"' : ''; ?> data-icon="<?php echo esc_attr( $icon ); ?>" data-prefix="<?php echo esc_attr( $prefix_class ); ?>">
										<?php if ( $icon === 'none' ) : ?>
											<span>None</span>
										<?php else : ?>
											<i class="icon <?php echo esc_html( $prefix_class . $icon ); ?>"></i>
										<?php endif; ?>
										<label class="icon"><?php echo esc_html( $icon ); ?></label>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
					</div>
					<script>
						(function(){
							jQuery(".<?php echo esc_js( $unique_id ); ?>").on( "keyup", function() {
								// Retrieve the input field text and reset the count to zero
								var search = jQuery(this).val();
								// Loop through the icon list
								jQuery(this).closest(".wrapper_icon").find(".icon-list li").each(function() {
									if ( ! jQuery(this).data( 'icon' ).toLowerCase().includes( search.toLowerCase() )) {
										jQuery(this).fadeOut();
									} else {
										jQuery(this).show();
									}
								});
							});

							jQuery("#icon-dropdown li").on( "click", function() {
								jQuery(this).attr("class","selected").siblings().removeAttr("class");

								var icon = jQuery(this).attr("data-icon");
								var prefix = jQuery(this).attr("data-prefix");

								jQuery(this).closest(".wrapper_icon").find('input[type="hidden"]').val(icon);
								jQuery(this).closest(".wrapper_icon").find(".icon-preview").html("<i class=\'icon " + prefix + icon + "\'></i>");
							});
						})(jQuery);
					</script>
					<?php
					break;

				case 'section':
					?>
					<div class="thim-widget-section <?php echo ! empty( $field['hide'] ) ? 'thim-widget-section-hide' : ''; ?>">
						<?php
						if ( ! empty( $field['fields'] ) ) {
							foreach ( (array) $field['fields'] as $sub_name => $sub_field ) {
 								$new   = $repeater ? $repeater : array();
  								$new[] = array( 'name' => $name );

								$this->render_field( $sub_name, $sub_field, $value[ $sub_name ] ?? null, $new, false );
							}
						}
						?>
					</div>
					<?php
					break;

				default:
					echo 'Unknown Field';
					break;
			}

			if ( ! empty( $field['description'] ) ) {
				?>
				<div class="thim-widget-field-description">
					<?php echo esc_html( $field['description'] ); ?>
				</div>
				<?php
			}
			?>
			</div>

			<?php
		}

		/**
		 * Get the template name that we'll be using to render this widget.
		 *
		 * @param $instance
		 *
		 * @return mixed
		 */
		abstract function get_template_name( $instance );

		/**
		 * Get the template name that we'll be using to render this widget.
		 *
		 * @param $instance
		 *
		 * @return mixed
		 */
		abstract function get_style_name( $instance );

		/**
		 * This function can be overwritten to modify form values in the child widget.
		 *
		 * @param $form
		 *
		 * @return mixed
		 */
		function modify_form( $form ) {
			return $form;
		}

		/**
		 * This function should be overwritten by child widgets to filter an instance. Run before rendering form and widget.
		 *
		 * @param $instance
		 *
		 * @return mixed
		 */
		function modify_instance( $instance ) {
			return $instance;
		}

		/**
		 * Can be overwritten by child themes to enqueue scripts and styles for the frontend
		 */
		function enqueue_frontend_scripts() {

		}

		/**
		 * By default, just return an array. Should be overwritten by child widgets.
		 *
		 * @param $instance
		 * @param $args
		 *
		 * @return array
		 */
		public function get_template_variables( $instance, $args ) {
			return array();
		}

		/**
		 * Enqueue all the registered scripts
		 */
		function enqueue_registered_scripts() {
			foreach ( $this->frontend_scripts as $f_script ) {
				if ( ! wp_script_is( $f_script[0] ) ) {
					wp_enqueue_script(
						$f_script[0],
						isset( $f_script[1] ) ? $f_script[1] : false,
						isset( $f_script[2] ) ? $f_script[2] : array(),
						isset( $f_script[3] ) ? $f_script[3] : false,
						isset( $f_script[4] ) ? $f_script[4] : false
					);
				}
			}
		}

		/**
		 * Used by child widgets to register styles to be enqueued for the frontend.
		 *
		 * @param array $styles an array of styles. Each element is an array that corresponds to wp_enqueue_style arguments
		 */

		public function register_frontend_styles( $styles ) {
			foreach ( $styles as $style ) {
				if ( ! isset( $this->frontend_styles[ $style[0] ] ) ) {
					$this->frontend_styles[ $style[0] ] = $style;
				}
			}
		}

		/**
		 * Enqueue any frontend styles that were registered
		 */
		public function enqueue_registered_styles() {
			foreach ( $this->frontend_styles as $f_style ) {
				if ( ! wp_style_is( $f_style[0] ) ) {
					wp_enqueue_style(
						$f_style[0],
						isset( $f_style[1] ) ? $f_style[1] : false,
						isset( $f_style[2] ) ? $f_style[2] : array(),
						isset( $f_style[3] ) ? $f_style[3] : false,
						isset( $f_style[4] ) ? $f_style[4] : 'all'
					);
				}
			}
		}

		public function enqueue_instance_frontend_scripts( $instance ) {
			$this->enqueue_registered_scripts();
			$this->enqueue_registered_styles();

			// Give plugins a chance to enqueue additional frontend scripts
			do_action( 'thim_widgets_enqueue_frontend_scripts_' . $this->id_base, $instance, $this );
		}

		/**
		 * Can be overwritten by child widgets to enqueue admin scripts and styles if necessary.
		 */
		function enqueue_admin_scripts() {

		}

		/**
		 * Initialize this widget in whatever way we need to. Run before rendering widget or form.
		 */
		function initialize() {

		}
	}
}
