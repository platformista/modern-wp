<?php
$theme_metadata  = Thim_Theme_Manager::get_metadata();
$links           = $theme_metadata['links'];
$video_customize = $links['video_customize'];
$video_id        = thim_parse_id_youtube( $video_customize );
?>

<div class="top">
    <div class="row">
        <div class="col-md-<?php echo esc_attr( $video_id ? '6' : '12' ); ?>">
            <h2>Customize Your Site</h2>
            <div class="caption no-line">
                <p>Congratulations! You are all set!</p>

                <h4>What now?</h4>
                <ul class="tc-list">
                    <li>You should edit the content of the web to fit your business purpose (update images, articles...).</li>
                    <li>You should customize your website to make it fit your idea, using the advanced customize system of the theme.</li>
                    <li>Watch this video tutorial to learn how to use the Customize system and how to edit the theme easily.</li>
                </ul>
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
    <a href="<?php echo esc_url( admin_url( 'customize.php?return=' . urlencode( Thim_Getting_Started::get_link_redirect_step( 'support' ) ) ) ); ?>"
       class="button button-primary tc-button tc-run-step">
		<?php esc_html_e( 'Customize your site', 'thim-core' ); ?>
    </a>
</div>

