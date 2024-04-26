<?php

if ( ! function_exists( 'thim_wrapper_layout' ) ) :
	function thim_wrapper_layout() {
		$get_post_type = get_post_type();
		global $wp_query;
		$using_custom_layout = $wrapper_layout = $cat_ID = '';
		$class_col           = 'col-sm-9 alignleft';
		$prefix              = thim_get_prefix_page_title();

		if ( is_front_page() || is_home() ) {
			$prefix = 'thim_front_page';
		} elseif ( is_page() ) {
			$prefix = 'thim_page';
		}

		// get id category
		$cat_obj = $wp_query->get_queried_object();
		if ( isset( $cat_obj->term_id ) ) {
			$cat_ID = $cat_obj->term_id;
		}
		// get layout
		if ( is_page() || is_single() || $get_post_type == "lp_collection" ) {
			$postid         = get_the_ID();
			$wrapper_layout = get_theme_mod( $prefix . '_single_layout', 'sidebar-right' );
			if ( $get_post_type == "forum" || $get_post_type == "topic" ) {
				$wrapper_layout = get_theme_mod( $prefix . '_cate_layout', 'full-content' );
			}

			if ( is_page() ) {
				$wrapper_layout = get_theme_mod( $prefix . '_layout', 'sidebar-right' );
				if ( get_the_ID() == get_option( 'woocommerce_cart_page_id' ) ||
					get_the_ID() == get_option( 'woocommerce_checkout_page_id' ) ||
					get_the_ID() == get_option( 'learn_press_profile_page_id' ) ||
					get_the_ID() == get_option( 'learn_press_checkout_page_id' ) ||
					get_the_ID() == get_option( 'learn_press_instructors_page_id' ) ||
					get_the_ID() == get_option( 'learn_press_single_instructor_page_id' ) ) {
					$wrapper_layout = 'full-content';
				}
			}

			/***********custom layout*************/
			$using_custom_layout = get_post_meta( $postid, 'thim_mtb_custom_layout', true );
			if ( $using_custom_layout ) {
				$wrapper_layout = get_post_meta( $postid, 'thim_mtb_layout', true );
			}
			// no sidebar single course in style 1 & 3
			if ( ( thim_lp_style_single_course() == 'new-1' || thim_lp_style_single_course() == 'layout_style_3' ) && $prefix == 'thim_learnpress' ) {
				$wrapper_layout = 'full-content';
			}
		} else {
			$wrapper_layout = get_theme_mod( $prefix . '_cate_layout', 'sidebar-right' );
			/***********custom layout*************/
			$using_custom_layout = get_term_meta( $cat_ID, 'thim_layout', true );
			if ( $using_custom_layout <> '' ) {
				$wrapper_layout = get_term_meta( $cat_ID, 'thim_layout', true );
			}
		}

		if ( $wrapper_layout == 'full-content' ) {
			$class_col = "col-sm-12 full-width";
		}
		if ( $wrapper_layout == 'sidebar-right' ) {
			$class_col = "col-sm-9 alignleft";
		}
		if ( $wrapper_layout == 'sidebar-left' ) {
			$class_col = 'col-sm-9 alignright';
		}

		if ( $wrapper_layout == 'full-width' ) {
			$class_col = 'content-wide';
		}


		return $class_col;
	}
endif;

//
add_action( 'thim_wrapper_loop_start', 'thim_wrapper_loop_start', 10 );

if ( ! function_exists( 'thim_wrapper_loop_start' ) ) :
	function thim_wrapper_loop_start() {
		$class_no_padding = '';
		if ( is_page() || is_single() ) {
			$mtb_no_padding = get_post_meta( get_the_ID(), 'thim_mtb_no_padding', true );
			if ( $mtb_no_padding ) {
				$class_no_padding = ' no-padding-top';
			}
		}
		//thim_no_padding_content

		$class_col     = thim_wrapper_layout();
		$sidebar_class = '';
		if ( is_404() ) {
			$class_col = 'col-sm-12 full-width';
		}
		if ( $class_col == "col-sm-9 alignleft" ) {
			$sidebar_class = ' sidebar-right';
		}
		if ( $class_col == "col-sm-9 alignright" ) {
			$sidebar_class = ' sidebar-left';
		}
		if ( $class_col == "content-wide" ) {
			$sidebar_class = '-fluid';
		}

		do_action( 'thim_before_site_content' );

		echo '<div class="container' . $sidebar_class . $class_no_padding . ' site-content">';

		echo '<div class="row"><main id="main" class="site-main ' . $class_col . '">';
	}
endif;

add_action( 'thim_wrapper_loop_end', 'thim_wrapper_loop_end', 10 );
if ( ! function_exists( 'thim_wrapper_loop_end' ) ) :
	function thim_wrapper_loop_end() {
		$class_col     = thim_wrapper_layout();
		$get_post_type = get_post_type();
		if ( is_404() ) {
			$class_col = 'col-sm-12 full-width';
		}
		echo '</main>';

		if ( $class_col == 'col-sm-9 alignleft' || $class_col == 'col-sm-9 alignright' ) {
			if ( is_search() ) {
				if ( ! empty( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {
					get_sidebar( 'shop' );
				}else {
					get_sidebar();
				}
			} else if ( $get_post_type == "lp_course" || $get_post_type == "lp_quiz" || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
				get_sidebar( 'courses' );
			} else if ( $get_post_type == "tp_event" ) {
				get_sidebar( 'events' );
			} else if ( $get_post_type == "product" ) {
				get_sidebar( 'shop' );
			} else {
				get_sidebar();
			}
		}
		echo '</div>';

		do_action( 'thim_after_site_content' );

		echo '</div>';
	}
endif;


add_action( 'thim_wrapper_loop_start', 'thim_wrapper_div_open', 1 );
if ( ! function_exists( 'thim_wrapper_div_open' ) ) {
	function thim_wrapper_div_open() {

		echo '<section class="content-area">';
	}
}

add_action( 'thim_wrapper_loop_end', 'thim_wrapper_div_close', 30 );

if ( ! function_exists( 'thim_wrapper_div_close' ) ) {
	function thim_wrapper_div_close() {
		echo '</section>';
	}
}
// show switch layout for blog
if ( ! function_exists( 'thim_blog_switch_layout' ) ) {
	function thim_blog_switch_layout() {
		if ( is_front_page() || is_home() ) {
			$prefix = 'thim_front_page';
		} else {
			$prefix = 'thim_archive';
		}

		if ( get_theme_mod( $prefix . '_cate_display_layout' ) == false ) {
			return;
		}
		global $wp_query;

		if ( is_category() ) {
			$total = get_queried_object();
			$total = $total->count;
		} elseif ( ! empty( $_REQUEST['s'] ) ) {
			$total = $wp_query->found_posts;
		} else {
			$total = wp_count_posts( 'post' );
			$total = $total->publish;
		}

		if ( $total == 0 ) {
			echo '<p class="message message-error">' . esc_html__( 'There are no available posts!', 'eduma' ) . '</p>';

			return;
		} elseif ( $total == 1 ) {
			$index = esc_html__( 'Showing only one result', 'eduma' );
		} else {
			$courses_per_page = absint( get_option( 'posts_per_page' ) );
			$paged            = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

			$from = 1 + ( $paged - 1 ) * $courses_per_page;
			$to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;
			if ( $from == $to ) {
				$index = sprintf( esc_html__( 'Showing last post of %s results', 'eduma' ), $total );
			} else {
				$index = sprintf( esc_html__( 'Showing %s-%s of %s results', 'eduma' ), $from, $to, $total );
			}
		} ?>
		<div class="thim-blog-top switch-layout-container">
			<div class="switch-layout blog-switch-layout">
				<a href="javascript:;" class="list switchToGrid"><i class="fa fa-th-large"></i></a>
				<a href="javascript:;" class="grid switchToList switch-active"><i class="fa fa-list-ul"></i></a>
			</div>
			<div class="post-index"><?php echo esc_html( $index ); ?></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'thim_blog_show_decription' ) ) {
	function thim_blog_show_decription() {
		if ( get_theme_mod( 'thim_archive_cate_show_description', false ) && category_description() ) {
			echo '<div class="desc_cat">' . category_description() . '</div>';
		}
	}
}

add_action( 'thim_blog_before_main_content', 'thim_blog_switch_layout', 10 );
add_action( 'thim_blog_before_main_content', 'thim_blog_show_decription', 20 );

if ( ! function_exists( 'thim_blog_grid_column' ) ) {
	function thim_blog_grid_column() {
		if ( is_front_page() || is_home() ) {
			$prefix = 'thim_front_page';
		} else {
			$prefix = 'thim_archive';
		}
 		return get_theme_mod( $prefix . '_cate_columns_grid', 3 );
	}
}
