<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

class Radio_Buttonset extends Base {

	public $type = 'thim-radio-buttonset';

	protected function content_template() {
		?>
		<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<div id="input_{{ data.id }}" class="buttonset">
			<# for ( key in data.choices ) { #>
				<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="{{ key }}" name="_customize-radio-{{{ data.id }}}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( key === data.value ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( key === data.value ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}{{ key }}">{{{ data.choices[ key ] }}}</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}
