<div class="top">
	<h2>Help and Support</h2>
	<?php
	$html_support = '<div class="caption">
        <p>This theme is quality checked by Envato and is maintained by ThimPress. It comes with 6 month support from the purchase date. There is an option for you extend this support period. If you
            wish to use this theme on another website, please purchase an additional license for your support benefits.</p>
    </div>
    <div>
        <div class="text-success">Item Support can be accessed from <a href="https://thimpress.com/forums/" target="_blank">ThimPress</a> and includes:</div>

        <ul class="tc-list">
            <li>Availability of the author to answer questions</li>
            <li>Answering technical questions about item features</li>
            <li>Assistance with reported bugs and issues</li>
            <li>Help with included 3rd party assets</li>
        </ul>

        <div class="text-error">Item Support DOES NOT include:</div>

        <ul class="tc-list">
            <li>Customization services (this is available through <a href="https://thimpress.com/wordpress-theme-customization-services/" target="_blank">ThimPress Customization Studio</a>)
            </li>
            <li>Installation Services (this can be available if you contact our support team via <a href="http://thimpress.com/forums/" target="_blank">our forum</a> )
            </li>
            <li>Help and Support for non-bundled 3rd party plugins (i.e. plugins you install yourself later on)</li>
            <li>More details about item support can be found in <a href="https://help.market.envato.com/hc/en-us/categories/200216004">the ThemeForest Item Support Policy</a>
            </li>
        </ul>
    </div>';
	echo apply_filters( 'thim_core_html_help_support', $html_support );
	?>


</div>

<div class="bottom">
	<a class="tc-skip-step">Skip</a>
	<button
		class="button button-primary tc-button tc-run-step"><?php esc_html_e( 'Agree and Continue', 'thim-core' ); ?></button>
</div>
