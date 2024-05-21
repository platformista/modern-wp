<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

defined( 'ABSPATH' ) || exit;

class Radio extends Base {

	public $type = 'thim-radio';
	
	protected function content_template() {
		?>
		<span class="customize-control-title">{{{ data.label }}}</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<# _.each( data.choices, function( val, key ) { #>
			<label>
				<input
					{{{ data.inputAttrs }}}
					type="radio"
					data-id="{{ data.id }}"
					value="{{ key }}"
					{{ data.link }}
					name="_customize-radio-{{ data.id }}"
					<# if ( data.value === key ) { #> checked<# } #>
				/>
				<# if ( _.isArray( val ) ) { #>
					{{{ val[0] }}}<span class="option-description">{{{ val[1] }}}</span>
				<# } else { #>
					{{ val }}
				<# } #>
			</label>
		<# } ); #>
		<?php
	}
}
