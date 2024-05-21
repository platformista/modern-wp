<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

defined( 'ABSPATH' ) || exit;

class Dimension extends Base {

	public $type = 'thim-dimension';

	public function enqueue() {
		parent::enqueue();
	}

	public function to_json() {
		$input_class = 'thim-control-input';

		if ( isset( $this->input_attrs['class'] ) ) {
			$input_class .= ' ' . $this->input_attrs['class'];
			unset( $this->input_attrs['class'] );
		}

		parent::to_json();

		$this->json['inputClass'] = $input_class;

		$this->json['labelPosition'] = 'top';

		if ( isset( $this->choices['label_position'] ) && 'bottom' === $this->choices['label_position'] ) {
			$this->json['labelPosition'] = 'bottom';
		}

		$this->json['inputId'] = '_customize-input-' . $this->id;
	}

	protected function content_template() {
		?>

		<div class="thim-control-form <# if ('bottom' === data.labelPosition) { #>has-label-bottom<# } #>">
			<# if ( 'top' === data.labelPosition ) { #>
				<label class="thim-control-label" for="{{ data.inputId }}">
					<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
					<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
				</label>
			<# } #>

			<div class="thim-input-control">
				<# var val = ( data.value && _.isString( data.value ) ) ? data.value.replace( '%%', '%' ) : ''; #>
				<input id="{{ data.inputId }}" {{{ data.inputAttrs }}} type="text" value="{{ val }}" class="{{ data.inputClass }}" />
			</div>

			<# if ( 'bottom' === data.labelPosition ) { #>
				<label class="thim-control-label" for="{{ data.inputId }}">
					<# if ( data.label ) { #>{{{ data.label }}} <# } #>
				</label>
			<# } #>
		</div>

		<?php
	}
}
