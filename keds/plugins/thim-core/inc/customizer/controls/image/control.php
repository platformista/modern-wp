<?php
namespace ThimPress\Customizer\Control;

use ThimPress\Customizer\Modules\Base;

defined( 'ABSPATH' ) || exit;

class Image extends Base {

	public $type = 'thim-image';

	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="image-wrapper attachment-media-view image-upload">
			<# url = ( _.isObject( data.value ) && ! _.isUndefined( data.value.url ) ) ? data.value.url : data.value; #>
			<# if ( data.value.url || '' !== url ) { #>
				<div class="thumbnail thumbnail-image">
					<img src="{{ url }}"/>
				</div>
			<# } else { #>
				<div class="placeholder"><?php echo 'No image selected'; ?></div>
			<# } #>
			<div class="actions">
				<button class="button image-upload-remove-button<# if ( '' === url ) { #> hidden <# } #>"><?php echo 'Remove'; ?></button>
				<# if ( data.default && '' !== data.default ) { #>
					<button type="button" class="button image-default-button"<# if ( data.default === data.value || ( ! _.isUndefined( data.value.url ) && data.default === data.value.url ) ) { #> style="display:none;"<# } #>><?php echo 'Default'; ?></button>
				<# } #>
				<button type="button" class="button image-upload-button"><?php echo 'Select image'; ?></button>
			</div>
		</div>
		<?php
	}
}
