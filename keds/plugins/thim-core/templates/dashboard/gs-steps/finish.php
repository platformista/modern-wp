<?php
$theme_data  = Thim_Theme_Manager::get_metadata();
$links       = $theme_data['links'];
$link_review = Thim_Product_Registration::get_link_reviews();
?>

<div class="top">
	<h2>Your Website is Ready to Shine!</h2>
	<?php

	$html_finish = '<div class="caption">
		<p>Congratulations! You have finished the installation steps for this theme. The theme has been activated and your website is ready for duty.</p>
	</div>';
	$html_finish .= '<div>
		<h4>What\'s next?</h4>
		<p>Please go to your WordPress dashboard and make changes and customization to the default content in a way that suits you the most.</p>

		<p>If you are happy with this theme, please <a href="' . esc_url( $link_review ) . '" target=" _blank" rel="noopener">leave us a 5-star</a> rating on ThemeForest to support and encourage us.</p>

		<p>You may want to follow <a href="https://twitter.com/thimpress" target="_blank" rel="noopener">@thimpress</a>
			on Twitter to see updates or follow <a href="https://www.youtube.com/c/ThimPressDesign" target="_blank" rel="noopener">ThimPress Youtube channel</a>
			for more video tutorials.
		</p>
	</div>';
	$html_finish .= '<div class="row">
		<div class="col-md-6">
			<h3>Next Steps</h3>
			<ul>
				<li><a class="button button-secondary tc-button" href="https://www.facebook.com/ThimPress/" target="_blank" rel="noopener">Follow Facebook</a></li>
				<li><a class="button button-secondary tc-button" href="' . esc_url( Thim_Dashboard::get_link_main_dashboard() ) . '">Theme Dashboard</a></li>
			</ul>
		</div>
		<div class="col-md-6">
			<h3>More Resources</h3>
 			<ul>
				<li class="docs"><a href="' . esc_url( $links['docs'] ) . '" target="_blank" rel="noopener">Theme Documentation</a></li>
				<li class="support"><a href="' . esc_url( $links['support'] ) . '" target="_blank" rel="noopener">Get Help and Support</a></li>
				<li class="blog"><a href="https://thimpress.com/blog/" target="_blank" rel="noopener">Read our blog</a></li>
				<li class="rating"><a href="' . esc_url( $link_review ) . '" target="_blank" rel="noopener">Leave an Item Rating</a></li>
			</ul>
		</div>
	</div>';
	echo apply_filters( 'thim_core_html_finish_dashboard', $html_finish );
	?>


</div>

<div class="bottom">
	<a class="tc-skip-step"><?php esc_html_e( 'Skip', 'thim-core' ); ?></a>
	<a href="<?php echo esc_url( get_home_url() ); ?>" target="_blank" class="button button-primary tc-button tc-run-step" rel="noopener">
		<?php esc_html_e( 'View Your Site', 'thim-core' ); ?>
	</a>
</div>
