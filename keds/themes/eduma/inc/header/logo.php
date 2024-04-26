<?php
add_action( 'thim_logo', 'thim_logo', 1 );
// logo
if ( ! function_exists( 'thim_logo' ) ) :
	function thim_logo() {
		$thim_logo_retina   = get_theme_mod( 'thim_logo_retina', false );
		$thim_logo          = get_theme_mod( 'thim_logo', false );
		$sticky_logo        = get_theme_mod( 'thim_sticky_logo', false );
		$thim_mobile_logo   = get_theme_mod( 'thim_logo_mobile', false );
		$sticky_mobile_logo = get_theme_mod( 'thim_sticky_logo_mobile', false );
		$style              = 'width="auto" height="auto"';
		$data_logo = $custom_logo = '';
		$logo_alt           = get_bloginfo( 'name' );
		if ( ! empty( $thim_logo ) ) {
			if ( is_numeric( $thim_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo, 'full' );

				if ( get_post_meta( $thim_logo, '_wp_attachment_image_alt', true ) ) {
					$logo_alt = get_post_meta( $thim_logo, '_wp_attachment_image_alt', true );
				}
				if ( $logo_attachment ) {
					$src   = $logo_attachment[0];
					$style = 'width="' . $logo_attachment[1] . '" height="' . $logo_attachment[2] . '"';
				} else {
					// Default image
					// Case: image ID from demo data
					$src   = get_template_directory_uri() . '/images/logo.png';
					$style = 'width="153" height="40"';
				}
			} else {
				$src = $thim_logo;
			}
		} else {
			// Default image
			// Case: The first install
			$src   = get_template_directory_uri() . '/images/logo.png';
			$style = 'width="153" height="40"';
		}
		$src = thim_ssl_secure_url( $src );
		// Custom Logo For a page and post
		if ( is_page() || is_single() ) {
			$custom_logo = get_post_meta( get_the_ID(), 'thim_mtb_logo', true );
			if ( is_numeric( $custom_logo ) ) {
				$custom_logo = wp_get_attachment_image_src( $custom_logo, 'full' );
				if ( is_array( $custom_logo ) ) {
					$src = $custom_logo[0];
				}
			}
		}

		// restina logo
		if ( ! empty( $thim_logo_retina ) ) {
			if ( is_numeric( $thim_logo_retina ) ) {
				$thim_logo_retina_attachment = wp_get_attachment_image_src( $thim_logo_retina, 'full' );
				if ( $thim_logo_retina_attachment ) {
					$src_logo_retina = $thim_logo_retina_attachment[0];
				}
			} else {
				$src_logo_retina = $thim_logo_retina;
			}
			// fix logo restina for custom logo a page and post
			if ( is_numeric( $custom_logo ) ) {
				$custom_logo_retina = wp_get_attachment_image_src( $custom_logo, 'full' );
				if ( is_array( $custom_logo_retina ) ) {
					$src_logo_retina = $custom_logo_retina[0];
				}
			}
			$data_logo .= ' data-retina="' . thim_ssl_secure_url( $src_logo_retina ) . '"';
		}

		// sticky logo
		if ( ! empty( $sticky_logo ) ) {
			if ( is_numeric( $sticky_logo ) ) {
				$sticky_logo_attachment = wp_get_attachment_image_src( $sticky_logo, 'full' );
				if ( $sticky_logo_attachment ) {
					$src_sticky = $sticky_logo_attachment[0];
				}
			} else {
				$src_sticky = $sticky_logo;
			}
			$data_logo .= ' data-sticky="' . thim_ssl_secure_url( $src_sticky ) . '"';
		}
		// mobile logo
		if ( ! empty( $thim_mobile_logo ) && ( get_theme_mod( 'thim_config_logo_mobile', false ) == 'custom_logo' ) ) {
			if ( is_numeric( $thim_mobile_logo ) ) {
				$thim_mobile_logo_attachment = wp_get_attachment_image_src( $thim_mobile_logo, 'full' );
				if ( $thim_mobile_logo_attachment ) {
					$src_mobile_logo = $thim_mobile_logo_attachment[0];
				}
			} else {
				$src_mobile_logo = $thim_mobile_logo;
			}
			$data_logo .= ' data-mobile="' . thim_ssl_secure_url( $src_mobile_logo ) . '"';
			if ( wp_is_mobile() ) {
				$src = $src_mobile_logo;
			}
		}
		//stick mobile logo
		if ( ! empty( $sticky_mobile_logo ) && ( get_theme_mod( 'thim_config_logo_mobile', false ) == 'custom_logo' ) ) {
			if ( is_numeric( $sticky_mobile_logo ) ) {
				$sticky_mobile_logo_attachment = wp_get_attachment_image_src( $sticky_mobile_logo, 'full' );
				if ( $sticky_mobile_logo_attachment ) {
					$src_sticky_mobile_logo = $sticky_mobile_logo_attachment[0];
				}
			} else {
				$src_sticky_mobile_logo = $sticky_mobile_logo;
			}
			$data_logo .= ' data-sticky_mobile="' . thim_ssl_secure_url( $src_sticky_mobile_logo ) . '"';
		}

		echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="thim-logo">';
		echo '<img src="' . $src . '" alt="' . esc_attr( $logo_alt ) . '" ' . $style . $data_logo . '>';
		echo '</a>';
	}
endif;

//add_action( 'thim_sticky_logo', 'thim_sticky_logo', 1 );

// get sticky logo
if ( ! function_exists( 'thim_sticky_logo' ) ) :
	function thim_sticky_logo() {
		$sticky_logo     = get_theme_mod( 'thim_sticky_logo', false );
		$sticky_logo_alt = get_bloginfo( 'name' );

		$style = '';
		if ( ! empty( $sticky_logo ) ) {
			if ( is_numeric( $sticky_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $sticky_logo, 'full' );
				if ( get_post_meta( $sticky_logo, '_wp_attachment_image_alt', true ) ) {
					$sticky_logo_alt = get_post_meta( $sticky_logo, '_wp_attachment_image_alt', true );
				}
				if ( $logo_attachment ) {
					$src   = $logo_attachment[0];
					$style = 'width="' . $logo_attachment[1] . '" height="' . $logo_attachment[2] . '"';
				} else {
					// Default image
					// Case: image ID from demo data
					$src   = get_template_directory_uri() . '/images/logo-sticky.png';
					$style = 'width="153" height="40"';
				}
			} else {
				$src = $sticky_logo;
			}
		} else {
			// Default image
			// Case: The first install
			$src   = get_template_directory_uri() . '/images/logo-sticky.png';
			$style = 'width="153" height="40"';
		}
		$src = thim_ssl_secure_url( $src );
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="sticky-logo">';
		echo '<img src="' . $src . '" alt="' . esc_attr( $sticky_logo_alt ) . '" ' . $style . '>';
		echo '</a>';
	}
endif;
