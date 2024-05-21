<?php
$theme_metadata = Thim_Theme_Manager::get_metadata();
$theme_name     = $theme_metadata['name'];
$links          = $theme_metadata['links'];
$video_intro    = $links['video_introduce'];
$video_id       = thim_parse_id_youtube( $video_intro );
$docs           = $links['docs'];
$support        = $links['support'];
?>

<div class="top">
    <div class="row">
        <div class="col-md-<?php echo esc_attr( $video_id ? '6' : '12' ); ?>">
            <h2>Welcome to <?php echo esc_html( $theme_name ); ?></h2>

            <div class="caption no-line">
				<?php
				printf(
					__(
						'<p>Hello there,</p>

				<p>If this is the first time you work with %1$s, please read and follow the instructions carefully.
				This is the getting started section of %1$s Theme Dashboard. It involves some simple steps to help you install the theme easier and to show you how the theme works, how to edit
				and customize the theme as you want it to be.</p>

				<p>All the documentation and tutorial of the theme can be found <a href="%2$s" target="_blank">here</a>.
				If there\'re any problem with the theme, please create a ticket for our supporters to help you <a href="%3$s" target="_blank">here</a>.</p>
				
				<p>Thank you for using the theme.</p>

				<p>Now, let\'s start!</p>
				<div class="shortcuts">
					<strong>Keyboard shortcuts: </strong>
					<ul>
						<li>Press <span class=\"tc-kbd dashicons dashicons-editor-break\"></span> to Continue</li>
						<li>Press <span class=\"tc-kbd dashicons dashicons-arrow-right-alt\"></span> to Skip</li>
						<li>Press <span class=\"tc-kbd dashicons dashicons-arrow-left-alt\"></span> to Go back</li>
					</ul>
				</div>',
						'thim-core'
					),
					$theme_name,
					$docs,
					$support
				);
				?>
            </div>
        </div>

		<?php if ( $video_id ) : ?>
            <div class="col-md-6">
                <div class="thim-video-youtube" data-video="<?php echo esc_attr( $video_id ); ?>" id="<?php echo esc_attr( $video_id ); ?>"></div>
            </div>
		<?php endif; ?>
    </div>
</div>

<div class="bottom">
    <a class="tc-skip-step">Skip</a>
    <button class="button button-primary tc-button tc-run-step"><?php esc_html_e( 'Next step →', 'thim-core' ); ?></button>
</div>
