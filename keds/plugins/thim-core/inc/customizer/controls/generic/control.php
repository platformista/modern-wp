<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

class Generic extends Base {

	public $type = 'thim-generic';

	protected function content_template() {
		?>
		<label class="customize-control-label" for="{{ ! data.choices.id ? 'customize-input-' + data.id : data.choices.id }}">
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="thim-control-form">
			<# element = ( data.choices.element ) ? data.choices.element : 'input'; #>

			<# if ( 'textarea' === element ) { #>
				<textarea
					{{{ data.inputAttrs }}}
					{{ data.link.replace(/"/g, '') }}
					<# if ( ! data.choices.id ) { #>
						id="{{'customize-input-' + data.id}}"
					<# } #>
					<# _.each( data.choices, function( val, key ) { #>
						{{ key }}="{{ val }}"
					<# }); #>
				>{{{ data.value }}}</textarea>
			<# } else { #>
				<{{ element }}
					{{{ data.inputAttrs }}}
					value="{{ data.value }}"
					{{ data.link.replace(/"/g, '') }}

					<# if ( ! data.choices.id ) { #>
						id="{{'customize-input-' + data.id}}"
					<# } #>

					<# _.each( data.choices, function( val, key ) { #>
						{{ key }}="{{ val }}"
					<# } ); #>
				<# if ( data.choices.content ) { #>>{{{ data.choices.content }}}</{{ element }}><# } else { #>/><# } #>
			<# } #>
		</div>
		<?php
	}
}
