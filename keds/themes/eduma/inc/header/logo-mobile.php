<?php
$theme_options_data = get_theme_mods();
if ( wp_is_mobile() && ( isset( $theme_options_data['thim_config_logo_mobile'] ) && $theme_options_data['thim_config_logo_mobile'] == 'custom_logo' ) ) {
	// custom logo mobile
	//add_action( 'thim_logo', 'thim_logo_mobile', 2 );
	if ( !function_exists( 'thim_logo_mobile' ) ) :
		function thim_logo_mobile() {

			$theme_options_data = get_theme_mods();
			if ( !empty( $theme_options_data['thim_logo_mobile'] ) ) {
				$thim_logo       = $theme_options_data['thim_logo_mobile'];
				//$logo_attachment = wp_get_attachment_image_src( $thim_logo, 'full' );
				if ( $thim_logo ) {
					$src   = $thim_logo;
					$style = '';
				} else {
					// Default image
					// Case: image ID from demo data
					$src   = get_template_directory_uri() . '/images/logo.png';
					$style = 'width="153" height="40"';
				}
			} else {
				// Default image
				// Case: The first install
				$src   = get_template_directory_uri() . '/images/logo.png';
				$style = 'width="153" height="40"';
			}

			echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="no-sticky-logo-mobile">';
			echo '<img src="' . $src . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" ' . $style . '>';
			echo '</a>';

		}
	endif;

	if ( ( isset( $theme_options_data['thim_logo_mobile'] ) && $theme_options_data['thim_logo_mobile'] <> '' ) || ( isset( $theme_options_data['thim_sticky_logo_mobile'] ) && $theme_options_data['thim_sticky_logo_mobile'] <> '' ) ) {
		//add_action( 'thim_sticky_logo', 'thim_sticky_logo_mobile', 2 );
		// get sticky logo
		if ( !function_exists( 'thim_sticky_logo_mobile' ) ) :
			function thim_sticky_logo_mobile() {
				$theme_options_data = get_theme_mods();
				if ( !empty( $theme_options_data['thim_sticky_logo_mobile'] ) ) {
					$thim_logo       = $theme_options_data['thim_sticky_logo_mobile'];
					//$logo_attachment = wp_get_attachment_image_src( $thim_logo, 'full' );
					if ( $thim_logo ) {
						$src   = $thim_logo;
						$style = '';
					} else {
						// Default image
						// Case: image ID from demo data
						$src   = get_template_directory_uri() . '/images/logo.png';
						$style = 'width="153" height="40"';
					}
				} else {
					// Default image
					// Case: The first install
					$src   = get_template_directory_uri() . '/images/logo.png';
					$style = 'width="153" height="40"';
				}

				echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="sticky-logo-mobile">';
				echo '<img src="' . $src . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" ' . $style . '>';
				echo '</a>';
			}
		endif; // thim_sticky_logo
	}
}
