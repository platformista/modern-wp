<?php
add_action( 'thim_wrapper_loop_start', 'thim_wapper_page_title', 5 );
if ( ! function_exists( 'thim_wapper_page_title' ) ) :
	function thim_wapper_page_title() {
		global $wp_query;
		$GLOBALS['post'] = @$wp_query->post;
		$wp_query->setup_postdata( @$wp_query->post );

		$custom_title = $style_heading = $cate_top_image_src = $bg_opacity = $style_content = $bg_color_overlay = '';

		if ( is_single() ) {
			$typography = 'h2';
		} else {
			$typography = 'h1';
		}
		// color theme options
		$cat_obj = $wp_query->get_queried_object();

		if ( isset( $cat_obj->term_id ) ) {
			$cat_ID       = $cat_obj->term_id;
			$cat_taxonomy = $cat_obj->taxonomy;
		} else {
			$cat_ID       = '';
			$cat_taxonomy = '';
		}
		//Get $prefix
		$prefix = thim_get_prefix_page_title();

		//Get $prefix_inner
		$prefix_inner = thim_get_prefix_inner_page_title();

		//Background image default from customizer options

		if ( get_post_type() == 'forum' || get_post_type() == 'topic' ) {
			$prefix       = 'thim_forum_';
			$prefix_inner = 'cate_';
		}
		if ( get_post_type() == 'learnpress_package' ) {
			$prefix       = 'thim_package_';
			$prefix_inner = '';
		}

		// config page 404
		if ( is_404() ) {
			$prefix       = 'thim_single_';
			$prefix_inner = '404_';
		}

		$cate_top_image = get_theme_mod( $prefix . $prefix_inner . 'top_image' );
		if ( is_numeric( $cate_top_image ) ) {
			$cate_top_attachment = wp_get_attachment_image_src( $cate_top_image, 'full' );
			$cate_top_image_src  = $cate_top_attachment[0];
		} else {
			$cate_top_image_src = $cate_top_image;
		}

		//Hide breadcrumbs default from customizer options
		$hide_breadcrumbs = get_theme_mod( $prefix . $prefix_inner . 'hide_breadcrumbs' );
		$hide_title       = get_theme_mod( $prefix . $prefix_inner . 'hide_title' );
		$subtitle         = get_theme_mod( $prefix . $prefix_inner . 'sub_title' );
		$text_color       = get_theme_mod( $prefix . $prefix_inner . 'title_color' );
		$sub_color        = get_theme_mod( $prefix . $prefix_inner . 'sub_title_color' );
		$bg_color         = get_theme_mod( $prefix . $prefix_inner . 'bg_color' );
		// fix all show top heading title for page
		if ( is_page() || ( $prefix == 'thim_learnpress' && ! is_single() ) ) {
			if ( is_page() ) {
				$hide_title = 0;
			}
		}

		//Get by Tax-meta-class for categories & custom field for single
		if ( is_page() || is_single() ) {
			$post_id = get_the_ID();
			if ( class_exists( 'BuddyPress' ) ) {
				$bp = buddypress();
				if ( $bp->current_component ) {
					$page_array = get_option( 'bp-pages' );
					if ( isset( $page_array[$bp->current_component] ) ) {
						$post_id = $page_array[$bp->current_component];
					}
				}
			}
			//Check using custom heading on single
			$using_custom_heading = get_post_meta( $post_id, 'thim_mtb_using_custom_heading', true );

			if ( $using_custom_heading ) {
				$hide_title       = get_post_meta( $post_id, 'thim_mtb_hide_title_and_subtitle', true );
				$hide_breadcrumbs = get_post_meta( $post_id, 'thim_mtb_hide_breadcrumbs', true );
				$custom_title     = get_post_meta( $post_id, 'thim_mtb_custom_title', true );
				$subtitle         = get_post_meta( $post_id, 'thim_subtitle', true );
				$bg_opacity       = get_post_meta( $post_id, 'thim_mtb_bg_opacity', true );

				$text_color_single = get_post_meta( $post_id, 'thim_mtb_text_color', true );
				$sub_color_single  = get_post_meta( $post_id, 'thim_mtb_color_sub_title', true );
				$bg_color_single   = get_post_meta( $post_id, 'thim_mtb_bg_color', true );
				$cate_top_image    = get_post_meta( $post_id, 'thim_mtb_top_image', true );
				if ( ! empty( $text_color_single ) && $text_color_single != '#' ) {
					$text_color = $text_color_single;
				}
				if ( ! empty( $sub_color_single ) && $sub_color_single != '#' ) {
					$sub_color = $sub_color_single;
				}
				if ( ! empty( $bg_color_single ) && $bg_color_single != '#' ) {
					$bg_color = $bg_color_single;
				}
				if ( is_numeric( $cate_top_image ) ) {
					$post_page_top_attachment = wp_get_attachment_image_src( $cate_top_image, 'full' );
					$cate_top_image_src       = $post_page_top_attachment[0];
				}
			}
		} else {
			$thim_custom_heading = get_term_meta( $cat_ID, 'thim_custom_heading', true );

			if ( $thim_custom_heading == 'custom' || $thim_custom_heading == 'on' ) {
				$text_color_cate = get_term_meta( $cat_ID, $prefix . '_cate_heading_text_color', true );
				$bg_color_cate   = get_term_meta( $cat_ID, $prefix . '_cate_heading_bg_color', true );
				$sub_color_cate  = get_term_meta( $cat_ID, $prefix . '_cate_sub_heading_bg_color', true );
				// reset default
				if ( ! empty( $text_color_cate ) && $text_color_cate != '#' ) {
					$text_color = $text_color_cate;
				}
				if ( ! empty( $bg_color_cate ) && $bg_color_cate != '#' ) {
					$bg_color = $bg_color_cate;
				}
				if ( ! empty( $sub_color_cate ) && $sub_color_cate != '#' ) {
					$sub_color = $sub_color_cate;
				}

				$subtitle         = term_description( $cat_ID, $cat_taxonomy );
				$hide_breadcrumbs = get_term_meta( $cat_ID, $prefix . '_cate_hide_breadcrumbs', true );
				$hide_title       = get_term_meta( $cat_ID, $prefix . '_cate_hide_title', true );
				$cate_top_image   = get_term_meta( $cat_ID, $prefix . '_top_image', true );
				$bg_opacity       = get_term_meta( $cat_ID, $prefix . '_cate_heading_bg_opacity', true );

				if ( ! empty( $cate_top_image ) ) {
					$cate_top_image_src = $cate_top_image['url'];
				}
			}
		}

		//Check ssl for top image
		$cate_top_image_src = thim_ssl_secure_url( $cate_top_image_src );
		// css
		$top_site_main_style = ( $text_color != '' ) ? 'color: ' . $text_color . ';' : '';

		$sub_title_style = ( $sub_color != '' ) ? ' style="color:' . $sub_color . '"' : '';

		$top_overlay_style = ! empty( $bg_color ) ? 'background-color:' . $bg_color . ';' : '';
		$top_overlay_style .= ! empty( $bg_opacity ) ? 'opacity:' . $bg_opacity . ';' : '';
		$top_site_main     = $style_h_3 = false;

		//set style heading title
		//thim_top_heading
		$no_padding        = '';
		$top_heading_style = get_theme_mod( 'thim_top_heading', 'normal' );
		// URL for demo eduma
		if ( isset( $_GET['breadcrumb'] ) ) {
			$top_heading_style = $_GET['breadcrumb'];
		}
		// old options for course
		if ( $top_heading_style == '' && ! empty( thim_lp_style_single_course() ) ) {
			if ( thim_lp_style_single_course() == 'new-1' ) {
				$top_heading_style = 'style_2';
			} elseif ( thim_lp_style_single_course() == 'layout_style_2' ) {
				$top_heading_style = 'style_3';
				$bg_color_overlay  .= '--thim-padding-content-pdtop-desktop:0px;';
			}
		}

		//
		if ( $top_heading_style == 'style_2' ) {
			$top_overlay_style = '';
			// fix if thim breadcrumb color not config
			if ( get_theme_mod( 'thim_breacrumb_color' ) == '' ) {
				$bg_color_overlay .= '--thim-breacrumb-color: #ccc;';
			}
			$style_heading = ' style_heading_2';
			if ( thim_lp_style_single_course() == 'new-1' ) {
				$bg_color_overlay .= '--thim-courses-offset-top: -220px;';
				if ( is_single() && get_post_type() == 'lp_course' ) {
					$style_content = ' style_content_2';
				}
			}
		} elseif ( $top_heading_style == 'style_3' ) {
			$style_heading    = ' style_heading_3';
			$bg_color_overlay .= '--thim-padding-content-pdtop-desktop:0px;';
			if ( ! empty( $bg_color ) ) {
				$bg_color_overlay .= ! empty( $bg_opacity ) ? '--thim-overlay-top-header-opacity:' . $bg_opacity . ';' : '';
				$bg_color_overlay .= get_theme_mod( 'thim_top_bg_gradient', true ) == false ? '--thim-overlay-top-header-color-bottom:' . $bg_color . ';' : '';
				$bg_color_overlay .= '--thim-overlay-top-header-color:' . $bg_color . ';';
			}
			// color breacrumn style 2 like color title
			$bg_color_overlay .= ! empty( $text_color ) ? '--thim-breacrumb-color: ' . $text_color . ';' : '';
			$bg_color_overlay .= '--thim-offset-image-bottom:' . get_theme_mod( 'thim_image_offset_bottom', - 270 ) . 'px';

			$top_overlay_style = '';
			$top_overlay_style .= ( $cate_top_image_src != '' ) ? 'background-image:url(' . $cate_top_image_src . ');' : '';
			// clear background image
			$cate_top_image_src = '';
			$style_h_3          = true;
		} elseif ( $top_heading_style == 'normal' && get_theme_mod( 'thim_top_heading_line_title', true ) == false ) {
			$style_content = ' no-line-title';
		}

		if ( thim_lp_style_single_course() == 'new-1' && is_single() && get_post_type() == 'lp_course' ) {
			$typography   = 'h1';
			$custom_title = get_the_title();
		}
		if(get_post_type() == 'portfolio' && is_single()){
			$typography   = 'h1';
		}
		echo ( $bg_color_overlay != '' ) ? '<style>.content-area{' . $bg_color_overlay . '}</style>' : '';

		$top_site_main_style .= ( $cate_top_image_src != '' ) ? 'background-image:url(' . $cate_top_image_src . ');' : '';

		?>

		<div class="top_heading<?php echo $style_heading; ?>_out<?php echo $style_content; ?>">
			<?php
			if ( get_theme_mod( 'thim_header_position', 'header_overlay' ) != 'header_default' || $hide_title != '1' || $style_h_3 ) {
				$top_site_main = true;
				echo '<div class="top_site_main' . $style_heading . '" style="' . ent2ncr( $top_site_main_style ) . '">';
				echo '<span class="overlay-top-header" style="' . ent2ncr( $top_overlay_style ) . '"></span>';
			}
			//Display breadcrumbs
			if ( ! $style_h_3 && $hide_breadcrumbs != '1' && get_theme_mod( 'thim_breadcrumb_position', 'default' ) == 'above-title' ) {
				thim_print_breadcrumbs();
			}
			if ( $hide_title != '1' || $style_h_3 ) { ?>
				<div class="page-title-wrapper">
					<div class="banner-wrapper container">
						<?php
						echo '<' . $typography . ' class="page-title">' . thim_get_page_title( $custom_title, '' ) . '</' . $typography . '>';

						if ( ! empty( $subtitle ) ) {
							echo '<div class="banner-description"' . $sub_title_style . '>' . $subtitle . '</div>';
						}

						if ( $style_h_3 && $hide_breadcrumbs != '1' && ! is_front_page() && ! is_404() ) {
							thim_print_breadcrumbs();
						}
						?>
					</div>
				</div>
			<?php }

			if ( $top_site_main ) {
				echo '</div>';
			}
			//Display breadcrumbs
			if ( ! $style_h_3 && $hide_breadcrumbs != '1' && ! is_front_page() && ! is_404() && get_theme_mod( 'thim_breadcrumb_position', 'default' ) != 'above-title' ) {
				thim_print_breadcrumbs();
			}
			?>
		</div>
		<?php
	}
endif;
?>
