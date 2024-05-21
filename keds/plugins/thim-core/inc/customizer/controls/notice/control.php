<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

defined( 'ABSPATH' ) || exit;

class Notice extends Base {

	public $type = 'thim-notice';

	protected function content_template() {
		?>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<?php
	}
}
