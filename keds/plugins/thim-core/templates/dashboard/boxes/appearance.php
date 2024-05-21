<div class="tc-box-body">
	<div class="text-panel-customizer">
		<?php
		/**
		 * Documentation links
		 */
		$customizer_section_default = array(
			'panel'   => array( 'general', 'widgets', 'nav_menus' ),
			'section' => array( 'typography' )
		);

		$customizer_section = apply_filters( 'thim_theme_customizer_section', $customizer_section_default );
 		foreach ( $customizer_section as $key => $values ) {
			foreach ( $values as $value ) {
				echo '<a class="tc-button-box tc-base-color" target="_blank" href="' . wp_customize_url() . '?autofocus[' . $key . ']=' . $value . '">' . esc_html( str_replace( "_", " ", $value ) ) . '</a>';
			}
		}
		?>
	</div>
</div>
