<?php
$theme_data = Thim_Theme_Manager::get_metadata();
$links      = $theme_data['links'];
?>
<div class="tc-box-body">
	<div class="tc-documentation-wrapper">
		<div class="list-boxes">
			<div class="box">
				<h3><?php esc_html_e( 'Documentation', 'thim-core' ); ?></h3>
				<p class="description"><?php esc_html_e( 'A collection of step-by-step guides to help you install, customize and work effectively with the theme.', 'thim-core' ); ?></p>
				<a href="<?php echo esc_url( $links['docs'] ); ?>"
				   target="_blank"><?php esc_html_e( 'Read more', 'thim-core' ); ?></a>
			</div>
			<div class="box">

				<h3><?php esc_html_e( 'Support Forum', 'thim-core' ); ?></h3>
				<p class="description"><?php esc_html_e( 'If any problem arise while using the theme, this is where you can ask our technical supporters so that we can help you out.', 'thim-core' ); ?></p>
				<a href="<?php echo esc_url( $links['support'] ); ?>"
				   target="_blank"><?php esc_html_e( 'Read more', 'thim-core' ); ?></a>

			</div>

			<div class="box">

				<h3><?php esc_html_e( 'Knowledge Base', 'thim-core' ); ?></h3>
				<p class="description"><?php esc_html_e( 'You can find detailed answers to almost all common issues regarding theme and plugins usage here.', 'thim-core' ); ?></p>
				<a href="<?php echo esc_url( $links['knowledge'] ); ?>"
				   target="_blank"><?php esc_html_e( 'Read more', 'thim-core' ); ?></a>
			</div>
		</div>
	</div>
</div>
