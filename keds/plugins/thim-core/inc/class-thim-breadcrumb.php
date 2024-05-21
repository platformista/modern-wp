<?php
/**
 * Thim_Breadcrumbs class.
 *
 */

namespace ThimCoreBreadcrumbs;

if ( ! class_exists( 'Thim_Breadcrumbs' ) ) {
	class Thim_Breadcrumbs {
		/**
		 * @var array
		 */
		public $data = array();

		protected $crumbs = array();

		public function __construct() {

			//$this->breadcrumb_structured_data($this->render());

			// Output.
			add_action( 'wp_footer', array( $this, 'output_structured_data' ), 10 );
		}

		public function breadcrumb_structured_data( $crumbs ) {
			if ( empty( $crumbs ) || ! is_array( $crumbs ) ) {
				return;
			}

			$markup                    = array();
			$markup['@type']           = 'BreadcrumbList';
			$markup['itemListElement'] = array();

			foreach ( $crumbs as $key => $crumb ) {
				$markup['itemListElement'][$key] = array(
					'@type'    => 'ListItem',
					'position' => $key + 1,
					'item'     => array(
						'name' => $crumb[0],
					),
				);

				if ( ! empty( $crumb[1] ) ) {
					$markup['itemListElement'][$key]['item'] += array( '@id' => $crumb[1] );
				} elseif ( isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
					$current_url = set_url_scheme( 'http://' . wp_unslash( $_SERVER['HTTP_HOST'] ) . wp_unslash( $_SERVER['REQUEST_URI'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

					$markup['itemListElement'][$key]['item'] += array( '@id' => $current_url );
				}
			}

			$this->data[] = apply_filters( 'thim/structured_data/breadcrumblist', $markup, $crumbs );
		}

		public function output_structured_data() {
			$data = $this->get_structured_data();

			if ( ! empty( $data ) ) {
				echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		public function get_structured_data() {
			$data = array();

			foreach ( $this->data as $value ) {
				$data[strtolower( $value['@type'] )][] = $value;
			}

			foreach ( $data as $type => $value ) {
				$data[$type] = count( $value ) > 1 ? array( '@graph' => $value ) : $value[0];
				$data[$type] = array( '@context' => 'https://schema.org/' ) + $data[$type];
			}

			$types = apply_filters( 'thim/structured_data/types', array( 'breadcrumblist' ) );

			$data = $types ? array_values( array_intersect_key( $data, array_flip( $types ) ) ) : array_values( $data );

			if ( ! empty( $data ) ) {
				if ( 1 < count( $data ) ) {
					$data = array( '@context' => 'https://schema.org/' ) + array( '@graph' => $data );
				} else {
					$data = $data[0];
				}
			}

			return $data;
		}

		/**
		 * Add crumb
		 *
		 * @param string $name Name.
		 * @param string $link Link.
		 */
		public function add_crumb( $name, $link = '' ) {
			$this->crumbs[] = array(
				wp_strip_all_tags( $name ),
				$link,
			);
		}

		/**
		 * Reset crumbs.
		 */
		public function reset() {
			$this->crumbs = array();
		}

		/**
		 * Get the breadcrumb.
		 *
		 * @return array
		 */
		public function thim_get_breadcrumb() {
			return apply_filters( 'thim_get_breadcrumb', $this->crumbs, $this );
		}

		/**
		 * Render breadcrumb.
		 *
		 * @return array of breadcrumbs
		 */
		public function render() {
			$conditionals = array(
				'is_home',
				'is_404',
				'is_attachment',
				'is_single',
				'is_page',
				'is_post_type_archive',
				'is_category',
				'is_tag',
				'is_author',
				'is_date',
				'is_tax',
				'is_search'
			);
			$text_home    = apply_filters( 'thim_breadcrumb_text_home', _x( 'Home', 'breadcrumb', 'thim-core' ) );
			$this->add_crumb( $text_home, home_url( '/' ) );

			if ( ! is_front_page() || is_paged() ) {
				foreach ( $conditionals as $conditional ) {
					if ( function_exists( $conditional ) && call_user_func( $conditional ) ) {
						call_user_func( array( $this, 'add_crumbs_' . substr( $conditional, 3 ) ) );
						break;
					}
				}

				$this->crumb_paged();

				// Structured
				$this->breadcrumb_structured_data( $this->thim_get_breadcrumb() );

				return $this->thim_get_breadcrumb();
			}

			return array();
		}

		/**
		 * Add crumbs for Is home
		 */
		protected function add_crumbs_home() {
			$this->add_crumb( single_post_title( '', false ) );
		}

		/**
		 * Add crumbs for page 404.
		 */
		protected function add_crumbs_404() {
			$this->add_crumb( __( 'Error 404', 'thim-core' ) );
		}

		/**
		 * Add crumbs for Search.
		 */
		protected function add_crumbs_search() {
			if ( is_search() ) {
				$this->add_crumb( sprintf( esc_html__( 'Search results for &ldquo;%s&rdquo;', 'thim-core' ), get_search_query() ), remove_query_arg( 'paged' ) );
			}
		}

		/**
		 * Add crumbs for Attachment.
		 */
		protected function add_crumbs_attachment() {
			global $post;

			$this->add_crumbs_single( $post->post_parent, get_permalink( $post->post_parent ) );
			$this->add_crumb( get_the_title(), get_permalink() );
		}

		/**
		 * Add crumbs for Single post.
		 *
		 * @param int    $post_id   Post ID.
		 * @param string $permalink Post permalink.
		 */
		protected function add_crumbs_single( $post_id = 0, $permalink = '' ) {

			if ( ! $post_id ) {
				global $post;
			} else {
				$post = get_post( $post_id );
			}

			if ( ! $permalink ) {
				$permalink = get_permalink( $post );
			}

			if ( 'post' !== get_post_type( $post ) ) {

				$this->add_crumbs_post_type_archive();

				$this->add_crumbs_current_archive_single( $post->ID );

			} else {
				// get page for post single blog
				$page_for_posts = intval( get_option( 'page_for_posts' ) );
				if ( 'post' == get_post_type( $post ) && ! empty( $page_for_posts ) ) {
					$this->add_crumb( get_the_title( $page_for_posts ), get_permalink( $page_for_posts ) );
				}

				$cat = current( get_the_category( $post ) );
				if ( $cat ) {
					$this->term_ancestors( $cat->term_id, 'category' );
					$this->add_crumb( $cat->name, get_term_link( $cat ) );
				}
			}

			$this->add_crumb( get_the_title( $post ), $permalink );
		}

		/**
		 * Add crumbs for Single current category.
		 *
		 * @param int $post_id Post ID.
		 */
		protected function add_crumbs_current_archive_single( $post_id = '' ) {
			if ( get_post_type() == 'lp_course' ) {
				$taxonomy = 'course_category';
			} elseif ( get_post_type() == 'product' ) {
				$taxonomy = 'product_cat';
			} else {
				$taxonomy = apply_filters( 'thim_breadcrumb_taxonomy_single_post', '' );
			}

			if ( $taxonomy == '' || $post_id == '' ) {
				return;
			}
			$terms = wp_get_post_terms(
				$post_id, $taxonomy,
				array(
					'orderby' => 'parent',
					'order'   => 'DESC',
				)
			);
			if ( $terms ) {
				$main_term = apply_filters( 'thim_breadcrumb_main_term', $terms[0], $terms );
				$this->term_ancestors( $main_term->term_id, $taxonomy );
				$this->add_crumb( $main_term->name, get_term_link( $main_term ) );
			}
		}


		/**
		 * Add crumbs for Page.
		 */
		protected function add_crumbs_page() {
			global $post;

			if ( $post->post_parent ) {
				$parent_crumbs = array();
				$parent_id     = $post->post_parent;

				while ( $parent_id ) {
					$page            = get_post( $parent_id );
					$parent_id       = $page->post_parent;
					$parent_crumbs[] = array( get_the_title( $page->ID ), get_permalink( $page->ID ) );
				}

				$parent_crumbs = array_reverse( $parent_crumbs );

				foreach ( $parent_crumbs as $crumb ) {
					$this->add_crumb( $crumb[0], $crumb[1] );
				}
			}

			$this->add_crumb( get_the_title(), get_permalink() );

		}

		/**
		 * Add crumbs for Post type.
		 */
		protected function add_crumbs_post_type_archive() {
			$post_type = get_post_type_object( get_post_type() );
			if ( $post_type ) {
				if ( get_post_type() == 'lp_course' ) {
					if ( intval( get_option( 'page_on_front' ) ) === learn_press_get_page_id( 'courses' ) ) {
						return;
					}

					$_name = learn_press_get_page_id( 'courses' ) ? get_the_title( learn_press_get_page_id( 'courses' ) ) : '';

					if ( ! $_name ) {
						$product_post_type = get_post_type_object( 'lp_course' );
						$_name             = $product_post_type->labels->name;
					}
  				} elseif ( get_post_type() == 'product' ) {
					if ( intval( get_option( 'page_on_front' ) ) === wc_get_page_id( 'shop' ) ) {
						return;
					}

					$_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

					if ( ! $_name ) {
						$product_post_type = get_post_type_object( 'product' );
						$_name             = $product_post_type->labels->name;
					}
 				} else {
					$_name = $post_type->labels->name;
				}
				$this->add_crumb( apply_filters( 'thim_breadcrumb_post_type_name', $_name ), get_post_type_archive_link( get_post_type() ) );
			}
		}

		/**
		 * Add crumbs for Category.
		 */
		protected function add_crumbs_category() {
			$this_category = get_category( $GLOBALS['wp_query']->get_queried_object() );

			if ( 0 !== intval( $this_category->parent ) ) {
				$this->term_ancestors( $this_category->term_id, 'category' );
			}

			$this->add_crumb( single_cat_title( '', false ), get_category_link( $this_category->term_id ) );
		}

		/**
		 * Add crumbs for Tag.
		 */
		protected function add_crumbs_tag() {
			$queried_object = $GLOBALS['wp_query']->get_queried_object();

			$this->add_crumb( single_tag_title( '', false ), get_tag_link( $queried_object->term_id ) );
		}

		/**
		 * Add crumbs for date based archives.
		 */
		protected function add_crumbs_date() {
			if ( is_year() || is_month() || is_day() ) {
				$this->add_crumb( get_the_time( 'Y' ), get_year_link( get_the_time( 'Y' ) ) );
			}
			if ( is_month() || is_day() ) {
				$this->add_crumb( get_the_time( 'F' ), get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) );
			}
			if ( is_day() ) {
				$this->add_crumb( get_the_time( 'd' ) );
			}
		}

		/**
		 * Add crumbs for taxonomies
		 */
		protected function add_crumbs_tax() {
			$this_term = $GLOBALS['wp_query']->get_queried_object();

			$this->add_crumbs_post_type_archive();

			if ( 0 !== intval( $this_term->parent ) ) {
				$this->term_ancestors( $this_term->term_id, $this_term->taxonomy );
			}

			$this->add_crumb( single_term_title( '', false ), get_term_link( $this_term->term_id, $this_term->taxonomy ) );
		}

		/**
		 * Add a breadcrumb for author archives.
		 */
		protected function add_crumbs_author() {
			global $author;

			$userdata = get_userdata( $author );

			/* translators: %s: author name */
			$this->add_crumb( sprintf( __( 'Author: %s', 'thim-core' ), $userdata->display_name ) );
		}

		/**
		 * Add crumbs for a term.
		 *
		 * @param int    $term_id  Term ID.
		 * @param string $taxonomy Taxonomy.
		 */
		protected function term_ancestors( $term_id, $taxonomy ) {
			$ancestors = get_ancestors( $term_id, $taxonomy );
			$ancestors = array_reverse( $ancestors );

			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, $taxonomy );

				if ( ! is_wp_error( $ancestor ) && $ancestor ) {
					$this->add_crumb( $ancestor->name, get_term_link( $ancestor ) );
				}
			}
		}

		/**
		 * Add crumbs for paged.
		 */
		protected function crumb_paged() {
			if ( get_query_var( 'paged' ) ) {
				$this->add_crumb( sprintf( esc_html__( 'Page %d', 'thim-core' ), get_query_var( 'paged' ) ) );
			}
		}
	}
}
