<?php
$theme_metadata = Thim_Theme_Manager::get_metadata();
$theme_name     = $theme_metadata['name'];
?>

<div class="top">
    <h2>Import Demo Content</h2>

    <div class="caption">
        <p>You are almost done!</p>
        <p>Please choose a demo content that you like the most. These demos are all amazing, so it may take you a while to choose and a little more time to install.<br>
            P/s: We will be updating more awesome demos for <strong><?php echo esc_html( $theme_name ); ?></strong> in the near future. Please connect with us via Facebook or Twitter to receive further news of this theme!</p>
    </div>

	<?php
	do_action( 'thim_dashboard_main_page_importer' );
	do_action( 'thim_importer_modals' );
	?>
</div>

<div class="bottom">
    <a class="tc-skip-step">Skip</a>
    <button class="button button-primary tc-button tc-run-step"><?php esc_html_e( 'Next step →', 'thim-core' ); ?></button>
</div>
