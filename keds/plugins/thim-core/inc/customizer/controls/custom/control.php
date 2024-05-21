<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

defined( 'ABSPATH' ) || exit;

class Custom extends Base {

	public $type = 'thim-custom';

	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			{{{ data.value }}}
		</label>
		<?php
	}
}
