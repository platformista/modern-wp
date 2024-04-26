<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package thim
 */
if ( ! function_exists( 'thim_paging_nav' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function thim_paging_nav() {
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );

		$query_args = array();
		$url_parts  = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => esc_html__( '<', 'eduma' ),
			'next_text' => esc_html__( '>', 'eduma' ),
			'type'      => 'list'
		) );

		if ( $links ) :
			?>
			<div class="pagination loop-paginationasd">
				<?php echo ent2ncr( $links ); ?>
			</div>
			<!-- .pagination -->
		<?php
		endif;
	}

endif;

if ( ! function_exists( 'thim_post_nav' ) ) :

	function thim_post_nav() {
		$prev_post = get_previous_post();
		$next_post = get_next_post();
		?>
		<?php if ( ! empty( $prev_post ) || ! empty( $next_post ) ): ?>
			<div class="entry-navigation-post">
				<?php
				if ( ! empty( $prev_post ) ):
					?>
					<div class="prev-post">
						<p class="heading"><?php echo esc_html__( 'Previous post', 'eduma' ); ?></p>
						<h5 class="title">
							<a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo esc_html( $prev_post->post_title ); ?></a>
						</h5>

						<div class="date">
							<?php echo get_the_date( get_option( 'date_format' ) ); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				if ( ! empty( $next_post ) ):
					?>
					<div class="next-post">
						<p class="heading"><?php echo esc_html__( 'Next post', 'eduma' ); ?></p>
						<h5 class="title">
							<a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo esc_html( $next_post->post_title ); ?></a>
						</h5>

						<div class="date">
							<?php echo get_the_date( get_option( 'date_format' ), $next_post->ID ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif;
	}

endif;
// action footer blog
add_action( 'thim_post_footer', 'thim_post_nav', 15 );
add_action( 'thim_post_footer', 'thim_about_author', 5 );
add_action( 'thim_post_footer', 'thim_single_post_related', 25 );

if ( ! function_exists( 'thim_single_post_related' ) ) {
	function thim_single_post_related() {
		get_template_part( 'inc/related' );
	}
}

if ( ! function_exists( 'thim_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function thim_entry_meta() {
		$theme_options_data = get_theme_mods();
		$archive_layout     = ! empty( $theme_options_data['thim_archive_cate_display_layout'] ) ? $theme_options_data['thim_archive_cate_display_layout'] : 'default';
		?>
		<ul class="entry-meta">
			<?php
			if ( isset( $theme_options_data['thim_show_author'] ) && $theme_options_data['thim_show_author'] == 1 ) {
				?>
				<li class="author">
					<span><?php echo esc_html__( 'Posted by', 'eduma' ); ?></span>
					<?php printf(
						'<span class="vcard author author_name"><a href="%1$s">%2$s</a></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						esc_html( get_the_author() )
					); ?>
				</li>
				<?php
			}
			if ( isset( $theme_options_data['thim_show_category'] ) && $theme_options_data['thim_show_category'] == 1 && get_the_category() ) {
				?>
				<li class="entry-category">
					<span><?php esc_html_e( 'Categories', 'eduma' ); ?></span> <?php the_category( ', ', '' ); ?>
				</li>
				<?php
			}
			if ( isset( $theme_options_data['thim_show_date'] ) && $theme_options_data['thim_show_date'] == 1 && ( is_single() || ( $archive_layout == 'grid' ) ) ) {
				?>
				<li class="entry-date">
					<span><?php echo esc_html__( 'Date', 'eduma' ); ?></span>
					<span class="value"> <?php echo get_the_date( get_option( 'date_format' ) ); ?></span>
				</li>
				<?php
			}
			if ( isset( $theme_options_data['thim_show_comment'] ) && $theme_options_data['thim_show_comment'] == 1 ) {
				?>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
					?>
					<li class="comment-total">
						<span><?php echo esc_html__( 'Comments', 'eduma' ) ?></span>
						<?php comments_popup_link( esc_html__( '0 comment', 'eduma' ), esc_html__( '1 comment', 'eduma' ), '% ' . esc_html__( 'comments', 'eduma' ) ); ?>
					</li>
				<?php
				endif;
			}
			if ( isset( $theme_options_data['thim_show_tag'] ) && $theme_options_data['thim_show_tag'] == 1 ) {
				?>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
					?>
					<li class="entry-category">
						<span><?php esc_html_e( 'Tags', 'eduma' ); ?></span> <?php the_tags( '', ', ' ); ?>
					</li>
				<?php
				endif;
			}
			?>

		</ul>
		<?php
	}
endif;

if ( ! function_exists( 'thim_archive_title' ) ) :

	/*
	 * Shim for `the_archive_title()`.
	 *
	 * Display the archive title based on the queried object.
	 *
	 *
	 * @param string $before Optional. Content to prepend to the title. Default empty.
	 * @param string $after  Optional. Content to append to the title. Default empty.
	 */
	function thim_archive_title( $before = '', $after = '' ) {
		$title              = '';
		$theme_options_data = get_theme_mods();
		if ( is_category() ) {
			$title = sprintf( esc_html__( '%s', 'eduma' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( '%s', 'eduma' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( '%s', 'eduma' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Year: %s', 'eduma' ), get_the_date( _x( 'Y', 'yearly archives date format', 'eduma' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Month: %s', 'eduma' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'eduma' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Day: %s', 'eduma' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'eduma' ) ) );
		} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'eduma' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'eduma' );
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( esc_html__( '%s', 'eduma' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( esc_html__( '%2$s', 'eduma' ), $tax->labels->singular_name, single_term_title( '', false ) );
		} elseif ( is_404() ) {
			$title = esc_html__( '404 Page', 'eduma' );
			if ( ! empty( $theme_options_data['thim_single_404_page_title'] ) ) {
				$title = $theme_options_data['thim_single_404_page_title'];
			}
		} elseif ( is_search() ) {
			$title = sprintf( esc_html__( 'Search Results for: %s', 'eduma' ), get_search_query() );
		} else {
			$title = esc_html__( 'Archives', 'eduma' );
		}

		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		//$title = apply_filters( 'get_the_archive_title', $title );

		return $before . $title . $after;
	}

endif;

if ( ! function_exists( 'thim_forum_title' ) ) :
	function thim_forum_title( $before = '', $after = '' ) {
		// Search page
		if ( function_exists( 'is_bbpress' ) ) {
			$pre_current_text = '';
			if ( bbp_is_search() ) {
				$pre_current_text = bbp_get_search_title();
				// Forum archive
			} elseif ( bbp_is_forum_archive() ) {
				$pre_current_text = bbp_get_forum_archive_title();
				// Topic archive
			} elseif ( bbp_is_topic_archive() ) {
				$pre_current_text = bbp_get_topic_archive_title();

				// View
			} elseif ( bbp_is_single_view() ) {
				$pre_current_text = bbp_get_view_title();

				// Single Forum
			} elseif ( bbp_is_single_forum() ) {
				$pre_current_text = bbp_get_forum_title();

				// Single Topic
			} elseif ( bbp_is_single_topic() ) {
				$pre_current_text = bbp_get_topic_title();

				// Single Topic
			} elseif ( bbp_is_single_reply() ) {
				$pre_current_text = bbp_get_reply_title();
				// Topic Tag (or theme compat topic tag)
			} elseif ( bbp_is_topic_tag() || ( get_query_var( 'bbp_topic_tag' ) && ! bbp_is_topic_tag_edit() ) ) {
				// Always include the tag name
				$tag_data[] = bbp_get_topic_tag_name();
				// If capable, include a link to edit the tag
				if ( current_user_can( 'manage_topic_tags' ) ) {
					$tag_data[] = '' . esc_html__( '(Edit)', 'eduma' ) . '';
				}

				// Implode the results of the tag data
				$pre_current_text = sprintf( esc_html__( 'Topic Tag: %s', 'eduma' ), implode( ' ', $tag_data ) );

				// Edit Topic Tag
			} elseif ( bbp_is_topic_tag_edit() ) {
				$pre_current_text = esc_html__( 'Edit', 'eduma' );
			} else {
				$pre_current_text = get_the_title();
			}

			return $before . $pre_current_text . $after;
		}
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function thim_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'thim_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'thim_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so thim_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so thim_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in thim_categorized_blog.
 */
function thim_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'thim_categories' );
}

add_action( 'edit_category', 'thim_category_transient_flusher' );
add_action( 'save_post', 'thim_category_transient_flusher' );


/**
 * About the author
 */
if ( ! function_exists( 'thim_about_author' ) ) {
	function thim_about_author() {
		$lp_info = get_the_author_meta( 'lp_info' );
		$link    = '#';
		if ( get_post_type() == 'lpr_course' ) {
			$link = apply_filters( 'learn_press_instructor_profile_link', '#', $user_id = null, get_the_ID() );
		} elseif ( get_post_type() == 'lp_course' ) {
			$instructor = learn_press_get_user( get_the_author_meta( 'ID' ));
 			if ( $instructor &&  thim_is_new_learnpress( '4.2.3' ) ) {
				$link = $instructor->get_url_instructor();
			}else{
				$link = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
			}
 		} elseif ( is_single() ) {
			$link = get_author_posts_url( get_the_author_meta( 'ID' ) );
		}
		?>
		<div class="thim-about-author">
			<div class="author-wrapper lp-course-author">
				<div class="author-avatar">
					<a href="<?php echo esc_url( $link ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 110, '', esc_attr__( 'author avatar', 'eduma' ) ); ?>
					</a>
				</div>
				<div class="author-bio">
					<div class="author-top">
						<a class="name instructor-display-name" href="<?php echo esc_url( $link ); ?>">
							<?php echo get_the_author(); ?>
						</a>
						<?php if ( isset( $lp_info['major'] ) && $lp_info['major'] ) : ?>
							<p class="job"><?php echo esc_html( $lp_info['major'] ); ?></p>
						<?php endif; ?>
					</div>
					<?php
					if ( function_exists( 'thim_lp_social_user' ) && get_post_type() == 'lp_course' ) {
						thim_lp_social_user();
					}
					?>
					<div class="author-description">
						<?php
						//                    fix error author description cannot line break
						echo wpautop( get_user_meta( get_the_author_meta( 'ID' ), 'description', true ) );
						?>
					</div>
				</div>

			</div>
		</div>
		<?php
		if ( class_exists( 'LearnPress' ) && function_exists( 'thim_co_instructors' ) ) {
			thim_co_instructors( get_the_ID(), get_the_author_meta( 'ID' ) );
		}
	}
}

add_action( 'thim_about_author', 'thim_about_author' );


function thim_modify_contact_methods( $profile_fields ) {
	$profile_fields['job'] = 'Job';

	return $profile_fields;
}

add_filter( 'user_contactmethods', 'thim_modify_contact_methods' );
