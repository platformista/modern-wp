<?php

thim_core_set_time_limit();

require_once THIM_CORE_ADMIN_PATH . '/includes/wordpress-importer/wordpress-importer.php';

/**
 * Class Thim_WP_Import
 *
 * @since     0.3.1
 * @package   Thim_Core_Admin
 */
class Thim_WP_Import_Service extends WP_Import {
	/**
	 * @since 1.0.6
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Current demo information
	 *
	 * @var mixed|null|void
	 */
	protected $_current_demo = null;

	/**
	 * Cache path
	 *
	 * @var null
	 */
	protected $_cache_dir = null;

	/**
	 * @var string
	 */
	protected $_thim_demo_content_key = '_thim_demo_content';

	/**
	 * @var int
	 */
	protected $_posts_per_page = 100;

	/**
	 * @var int
	 */
	protected $_attachments_per_page = 10;

	/**
	 * @var int
	 */
	protected $_chunks = 0;

	/**
	 * @var int
	 */
	protected $_attachment_demo_id = 0;

	/**
	 * Get single instance Thim_WP_Import_Service.
	 *
	 * @since 1.0.6
	 *
	 * @param bool $clean
	 *
	 * @return Thim_WP_Import_Service
	 */
	public static function instance( $clean = false ) {
		if ( self::$instance === null ) {
			self::$instance = new self( $clean );
		}

		return self::$instance;
	}

	/**
	 * Thim_WP_Import constructor.
	 *
	 * @param bool $clean
	 */
	public function __construct( $clean = false ) {
		$this->allow_edit_variables();
		$this->_current_demo = $this->get_current_demo();
		$this->get_demo_cache_path();

		if ( $clean ) {
			$this->_clean_cache_folder();
		}

		parent::__construct();

		$this->processed_terms      = (array) $this->get_cache_data( 'processed_terms' );
		$this->processed_posts      = (array) $this->get_cache_data( 'processed_posts' );
		$this->processed_authors    = (array) $this->get_cache_data( 'processed_authors' );
		$this->post_orphans         = (array) $this->get_cache_data( 'post_orphans' );
		$this->author_mapping       = (array) $this->get_cache_data( 'author_mapping' );
		$this->featured_images      = (array) $this->get_cache_data( 'featured_images' );
		$this->processed_menu_items = (array) $this->get_cache_data( 'processed_menu_items' );
		$this->menu_item_orphans    = (array) $this->get_cache_data( 'menu_item_orphans' );
		$this->missing_menu_items   = (array) $this->get_cache_data( 'missing_menu_items' );
		$this->url_remap            = (array) $this->get_cache_data( 'url_remap' );
		$this->_chunks              = (array) $this->get_cache_data( 'chunks' );


		add_filter( 'import_post_meta_key', array( $this, 'import_object_meta' ), 1000, 2 );
		add_filter( 'import_comment_meta_key', array( $this, 'import_object_meta' ), 1000, 2 );
		add_filter( 'import_term_meta_key', array( $this, 'import_object_meta' ), 1000, 3 );
	}

	/**
	 * Allow set variables to import.
	 *
	 * @since 1.0.4
	 */
	private function allow_edit_variables() {
		$posts_pp       = get_option( 'thim_importer_posts_pp' );
		$attachments_pp = get_option( 'thim_importer_attachments_pp' );

		if ( is_numeric( $posts_pp ) ) {
			$this->_posts_per_page = intval( $posts_pp );
		}

		if ( is_numeric( $attachments_pp ) ) {
			$this->_attachments_per_page = intval( $attachments_pp );
		}

		if ( defined( 'THIM_IMPORTER_POSTS_PP' ) ) {
			$this->_posts_per_page = THIM_IMPORTER_POSTS_PP;
		}

		if ( defined( 'THIM_IMPORTER_ATTACHMENTS_PP' ) ) {
			$this->_attachments_per_page = THIM_IMPORTER_ATTACHMENTS_PP;
		}
	}

	/**
	 * Get demo image.
	 *
	 * @since 0.3.1
	 *
	 * @return array
	 */
	private function _get_demo_image() {
		$image      = array();
		$image_path = get_template_directory() . '/inc/data/demo_image.jpg';
		$image_path = apply_filters( 'thim_core_importer_path_demo_image', $image_path );
		if ( file_exists( $image_path ) ) {
			$image['path'] = $image_path;
			$image['uri']  = apply_filters( 'thim_core_importer_uri_demo_image', get_stylesheet_directory_uri() . '/inc/data/demo_image.jpg' );

			return $image;
		}

		return array(
			'path' => THIM_CORE_ADMIN_PATH . '/assets/images/demo_image.png',
			'uri'  => THIM_CORE_URI . '/admin/assets/images/demo_image.png',
		);
	}

	/**
	 * Insert demo image.
	 *
	 * @since 0.4.0
	 *
	 * @return string
	 */
	private function _insert_attachment_demo_image() {

		if ( $this->_attachment_demo_id ) {
			return $this->_attachment_demo_id;
		}
		$args  = array(
			'meta_query'     => array(
				array(
					'key'   => '_thim_demo_attachment',
					'value' => 'yes'
				)
			),
			'post_type'      => 'attachment',
			'posts_per_page' => 1
		);
		$posts = get_posts( $args );

		if ( $posts ) {
			$this->_attachment_demo_id = $posts[0]->ID;

			return $this->_attachment_demo_id;
		}

		$image      = $this->_get_demo_image();
		$image_path = $image['path'];

		$file_name = basename( $image_path );
		$file_type = wp_check_filetype( $file_name, null );

		$wp_upload_dir = wp_upload_dir();

		$image_destination_path = $wp_upload_dir['path'] . '/' . $file_name;

		@copy( $image_path, $image_destination_path );

		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
			'post_mime_type' => $file_type['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', $file_name ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $image_destination_path );

		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$attach_data = wp_generate_attachment_metadata( $attach_id, $image_destination_path );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		update_post_meta( $attach_id, '_thim_demo_attachment', 'yes' );
		$this->_set_object_is_demo_content( 'post', $attach_id );

		return $attach_id;
	}

	/**
	 * Import main content (no media file).
	 *
	 * @since 0.3.1
	 *
	 * @param $xml_file
	 */
	public function import_main_content( $xml_file ) {
		$this->set_import_media( false );

		return $this->import( $xml_file );
	}

	/**
	 * Import media file.
	 *
	 * @since 0.3.1
	 *
	 * @param $xml_file
	 */
	public function import_media( $xml_file ) {
		$this->set_import_media( true );

		return $this->import( $xml_file );
	}

	/***********************************************/
	/**
	 * Read content of a file
	 *
	 * @param        $file
	 * @param string $mode
	 *
	 * @return bool|string
	 */
	private function _read_file( $file, $mode = 'r' ) {
		$content = false;
		if ( $f = fopen( $file, $mode ) ) {
			$content = fread( $f, filesize( $file ) );
		}
		@fclose( $f );

		return $content;
	}

	/**
	 * Write data to a file
	 *
	 * @param        $file
	 * @param        $content
	 * @param string $mode
	 *
	 * @return bool|int
	 */
	private function _write_file( $file, $content, $mode = 'w' ) {
		$return = false;
		if ( $f = fopen( $file, $mode ) ) {
			if ( ! is_string( $content ) ) {
				$content = maybe_serialize( $content );
			}
			$return = fwrite( $f, $content );
		}

		@fclose( $f );

		return $return;
	}

	/**
	 * Get full path of a file for cache.
	 * If check_exists is TRUE return path if file exists otherwise, return FALSE
	 * If check_exists is FALSE return path
	 *
	 * @param string $name
	 * @param bool $check_exists
	 *
	 * @return bool|string
	 */
	private function _get_cache_file( $name, $check_exists = true ) {
		if ( ! file_exists( $name ) ) {
			$file = $this->_cache_dir . "/cache/{$name}.data";
		} else {
			$file = $name;
		}
		if ( $check_exists && ! file_exists( $file ) ) {
			return false;
		}

		return $file;
	}

	/**
	 * Get data from a file of cache.
	 * Creates a PHP value from a stored string with a format is serialize of json.
	 * Default is use maybe_unserialize for conversion
	 *
	 * @param string $name
	 * @param string $converter
	 *
	 * @return bool|mixed|string
	 */
	public function get_cache_data( $name, $converter = 'maybe_unserialize' ) {
		$file = $this->_get_cache_file( $name );
		if ( ! $file ) {
			return false;
		}
		$data = $this->_read_file( $file );

		// if 'converter' is a function or method is callable
		if ( is_callable( $converter ) ) {
			$data = call_user_func_array( $converter, array( $data ) );
		} else {
		}

		return $data;
	}

	/**
	 * Put data to a file of cache.
	 * Convert data to string before store.
	 *
	 * @param string $name
	 * @param mixed $data
	 * @param string $converter
	 *
	 * @return int
	 */
	private function _set_cache_data( $name, $data, $converter = 'maybe_serialize' ) {
		$file = $this->_get_cache_file( $name, false );
		if ( is_callable( $converter ) ) {
			$data = call_user_func_array( $converter, array( $data ) );
		}

		return $this->_write_file( $file, $data );
	}

	/**
	 * Clean cache data.
	 * Simply is remove a file from cache.
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	private function _remove_cache_data( $name ) {
		$file = $this->_get_cache_file( $name );
		if ( $file ) {
			return @unlink( $file );
		}

		return false;
	}

	/**
	 * Get current post type is importing.
	 * Read content of file from cache and parse PHP value (array).
	 * Return the first of element from array.
	 *
	 * @return bool|mixed
	 */
	private function _get_current_post_type() {
		$post_types = $this->get_cache_data( 'post-types' );
		if ( $post_types ) {
			return array_shift( $post_types );
		}

		return false;
	}

	/**
	 * Remove a post type has imported from cache
	 * If there is not any post type to be import, remove cache
	 *
	 * @param string $post_type
	 *
	 * @return bool|mixed
	 */
	private function _remove_current_post_type( $post_type = '' ) {
		$post_types = $this->get_cache_data( 'post-types' );
		$next       = false;
		if ( $post_types ) {
			array_shift( $post_types );
			if ( $post_types ) {
				$this->_set_cache_data( 'post-types', $post_types );
				$next = array_shift( $post_types );
			} else {
				$this->_remove_cache_data( 'post-types' );
			}
		}

		return $next;
	}

	/**
	 * Get a bunch of posts to be import.
	 * Default is 20 posts for each bunch.
	 *
	 * @return array|bool
	 */
	private function _get_next_posts() {

		$posts             = false;
		$current_post_type = $this->_get_current_post_type();
		$posts_per_page    = $current_post_type == 'attachment' ? $this->_attachments_per_page : $this->_posts_per_page;
		if ( ! $current_post_type ) {
			return $posts;
		}
		$data_posts = $this->get_cache_data( "posts-{$current_post_type}" );
		if ( ! $data_posts ) {
			return $posts;
		}
		$posts = array_splice( $data_posts, 0, $posts_per_page );
		if ( $data_posts ) {
			$this->_set_cache_data( "posts-{$current_post_type}", $data_posts );
		} else {
			$this->_remove_cache_data( "posts-{$current_post_type}" );
		}
		if ( sizeof( $posts ) < $posts_per_page || ! $data_posts ) {
			$next = $this->_remove_current_post_type( $current_post_type );
		}
		if ( $current_post_type == 'attachment' ) {
		}

		return $posts;
	}

	/**
	 * This function retrieve authors from posts if there is no any authors
	 * existing in imported data.
	 *
	 * @param array $authors
	 * @param array $posts
	 */
	private function _get_author_from_posts( &$authors, $posts ) {
		foreach ( $posts as $post ) {
			$login = sanitize_user( $post['post_author'], true );
			if ( empty( $login ) ) {
				continue;
			}

			if ( ! isset( $authors[ $login ] ) ) {
				$authors[ $login ] = array(
					'author_login'        => $login,
					'author_display_name' => $post['post_author']
				);
			}
		}
	}

	/**
	 * Import categories
	 */
	public function process_categories() {

		$this->categories = apply_filters( 'wp_import_categories', $this->categories );

		if ( empty( $this->categories ) ) {
			return;
		}
		foreach ( $this->categories as $cat ) {
			// if the category already exists leave it alone
			$term_id = term_exists( $cat['category_nicename'], 'category' );
			if ( $term_id ) {
				if ( is_array( $term_id ) ) {
					$term_id = $term_id['term_id'];
				}
				if ( isset( $cat['term_id'] ) ) {
					$this->processed_terms[ intval( $cat['term_id'] ) ] = (int) $term_id;
					//$this->_set_object_is_demo_content( 'term', (int) $term_id );
				}
				continue;
			}

			$category_parent      = empty( $cat['category_parent'] ) ? 0 : category_exists( $cat['category_parent'] );
			$category_description = isset( $cat['category_description'] ) ? $cat['category_description'] : '';
			$catarr               = array(
				'category_nicename'    => $cat['category_nicename'],
				'category_parent'      => $category_parent,
				'cat_name'             => $cat['cat_name'],
				'category_description' => $category_description
			);
 			$catarr               = wp_slash( $catarr );

			$id = wp_insert_category( $catarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset( $cat['term_id'] ) ) {
					$this->processed_terms[ intval( $cat['term_id'] ) ] = $id;
					$this->_set_object_is_demo_content( 'term', $id );
				}
				do_action( 'thim_import_processed_term', $id, $cat );

			} else {
				ob_start();
				printf( __( 'Failed to import category %s at %d in %s', 'wordpress-importer' ), esc_html( $cat['category_nicename'] ), __LINE__, __FILE__ );
				if ( defined( 'IMPORT_DEBUG' ) && IMPORT_DEBUG ) {
					echo ': ' . $id->get_error_message();
				}
				$log = ob_get_clean();
				thim_add_log( $log );
				continue;
			}
			$this->process_termmeta( $cat, $id );
		}

		do_action( 'thim_import_processed_terms', $this->processed_terms, $this->categories );

		unset( $this->categories );

		$this->_remove_cache_data( 'categories' );
		$this->_set_cache_data( 'processed_terms', $this->processed_terms );
	}

	/**
	 * Import tags
	 */
	public function process_tags() {
		$this->tags = apply_filters( 'wp_import_tags', $this->tags );

		if ( empty( $this->tags ) ) {
			return;
		}

		foreach ( $this->tags as $tag ) {
			// if the tag already exists leave it alone
			$term_id = term_exists( $tag['tag_slug'], 'post_tag' );
			if ( $term_id ) {
				if ( is_array( $term_id ) ) {
					$term_id = $term_id['term_id'];
				}
				if ( isset( $tag['term_id'] ) ) {
					$this->processed_terms[ intval( $tag['term_id'] ) ] = (int) $term_id;
				}
				continue;
			}

			$tag      = wp_slash( $tag );
			$tag_desc = isset( $tag['tag_description'] ) ? $tag['tag_description'] : '';
			$tagarr   = array( 'slug' => $tag['tag_slug'], 'description' => $tag_desc );

			$id = wp_insert_term( $tag['tag_name'], 'post_tag', $tagarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset( $tag['term_id'] ) ) {
					$this->processed_terms[ intval( $tag['term_id'] ) ] = $id['term_id'];
					$this->_set_object_is_demo_content( 'term', $id['term_id'] );

				}
			} else {
				continue;
			}

			$this->process_termmeta( $tag, $id['term_id'] );
		}

		unset( $this->tags );
		$this->_remove_cache_data( 'tags' );
		$this->_set_cache_data( 'processed_terms', $this->processed_terms );
	}

	/**
	 * Import terms
	 */
	public function process_terms() {
		$this->terms = apply_filters( 'wp_import_terms', $this->terms );

		if ( empty( $this->terms ) ) {
			return;
		}
//		var_dump($this->terms );
//		die;
		foreach ( $this->terms as $term ) {
			// if the term already exists in the correct taxonomy leave it alone
			// WooCommerce product attributes registration.
			if ( class_exists( 'WooCommerce' ) ) {
				/**
				 * Pre-process term taxonomy data.
				 */
				if(strstr( $term['term_taxonomy'], 'pa_' ) ){
					if ( ! taxonomy_exists(  $term['term_taxonomy'] ) ) {
						global $wpdb;
						$attribute_name = wc_sanitize_taxonomy_name( str_replace( 'pa_', '',  $term['term_taxonomy']) );

						// Create the taxonomy
						if ( ! in_array( $attribute_name, wc_get_attribute_taxonomies() ) ) {
							$attribute_type = apply_filters( 'thim_import_wcbt_attribute_type', 'select' );
							if ( is_array( $attribute_type ) ) {
								$attribute_type = isset( $attribute_type[$term['term_taxonomy']] ) ? $attribute_type[$term['term_taxonomy']] : 'select';
							}

							$attribute = array(
								'attribute_label'   => $attribute_name,
								'attribute_name'    => $attribute_name,
								'attribute_type'    => $attribute_type,
								'attribute_orderby' => 'menu_order',
								'attribute_public'  => 0
							);
							$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
							delete_transient( 'wc_attribute_taxonomies' );
						}

						// Register the taxonomy now so that the import works!
						register_taxonomy(
							$term['term_taxonomy'],
							apply_filters( 'woocommerce_taxonomy_objects_' .  $term['term_taxonomy'], array( 'product' ) ),
							apply_filters( 'woocommerce_taxonomy_args_' .  $term['term_taxonomy'], array(
								'hierarchical' => true,
								'show_ui'      => false,
								'query_var'    => true,
								'rewrite'      => false,
							) )
						);
					}
				}
			}
			$term_id = term_exists( $term['slug'], $term['term_taxonomy'] );
			if ( $term_id ) {
				if ( is_array( $term_id ) ) {
					$term_id = $term_id['term_id'];
				}
				if ( isset( $term['term_id'] ) ) {
					$this->processed_terms[ intval( $term['term_id'] ) ] = (int) $term_id;
				}
				continue;
			}

			if ( empty( $term['term_parent'] ) ) {
				$parent = 0;
			} else {
				$parent = term_exists( $term['term_parent'], $term['term_taxonomy'] );
				if ( is_array( $parent ) ) {
					$parent = $parent['term_id'];
				}
			}
			$term        = wp_slash( $term );
			$description = isset( $term['term_description'] ) ? $term['term_description'] : '';
			$termarr     = array(
				'slug'        => $term['slug'],
				'description' => $description,
				'parent'      => intval( $parent )
			);

			$id = wp_insert_term( $term['term_name'], $term['term_taxonomy'], $termarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset( $term['term_id'] ) ) {
					$this->processed_terms[ intval( $term['term_id'] ) ] = $id['term_id'];
					$this->_set_object_is_demo_content( 'term', $id['term_id'] );
				}
			} else {
				continue;
			}

			$this->process_termmeta( $term, $id['term_id'] );
		}

		unset( $this->terms );
		$this->_remove_cache_data( 'terms' );
		$this->_set_cache_data( 'processed_terms', $this->processed_terms );

	}

	private function _import_posts( $posts, $attachment_demo_image_id = false ) {
		$this->posts = apply_filters( 'wp_import_posts', $posts );

		foreach ( $this->posts as $post ) {
			do_action( 'thim_import_import_post', $post );

			$post = apply_filters( 'wp_import_post_data_raw', $post );

			// Third-party can ignore import their post by filter above
			if ( ! $post ) {
				continue;
			}

			if ( ! post_type_exists( $post['post_type'] ) ) {
				// TODO: anything here
				do_action( 'wp_import_post_exists', $post );
				continue;
			}

			if ( isset( $this->processed_posts[ $post['post_id'] ] ) && ! empty( $post['post_id'] ) ) {
				continue;
			}

			if ( $post['status'] == 'auto-draft' ) {
				continue;
			}

			if ( 'attachment' == $post['post_type'] ) {
				if ( $attachment_demo_image_id == false ) {
					continue;
				}
				$this->fetch_attachments = true;
			}

			// Import menu item
			if ( 'nav_menu_item' == $post['post_type'] ) {
				$this->process_menu_item( $post );
				continue;
			}

			// Import post
			$this->import_post( $post, $attachment_demo_image_id );
		}

		unset( $this->posts );

		$this->set_cache_objects();
	}

	/**
	 * Check a post is already existed by title and date
	 *
	 * @param array $post
	 *
	 * @return int|mixed
	 */
	public function post_exists( $post ) {
		$post_exists = post_exists( $post['post_title'], '', $post['post_date'] );

		/**
		 * Filter ID of the existing post corresponding to post currently importing.
		 *
		 * Return 0 to force the post to be imported. Filter the ID to be something else
		 * to override which existing post is mapped to the imported post.
		 *
		 * @see   post_exists()
		 * @since 0.6.2
		 *
		 * @param int $post_exists Post ID, or 0 if post did not exist.
		 * @param array $post The post array to be inserted.
		 */
		return apply_filters( 'wp_import_existing_post', $post_exists, $post );
	}

	/**
	 * Import post
	 *
	 * @param array $post
	 * @param int $attachment_demo_image_id
	 *
	 * @return bool|int
	 */
	public function import_post( $post, $attachment_demo_image_id ) {
		$old_post_id = intval( $post['post_id'] );
		$post_exists = $this->post_exists( $post );

		if ( $post_exists && get_post_type( $post_exists ) == $post['post_type'] ) {
			$comment_post_ID                       = $post_id = $post_exists;
			$this->processed_posts[ $old_post_id ] = intval( $post_exists );
		} else {
			$post_parent = (int) $post['post_parent'];
			if ( $post_parent ) {
				// if we already know the parent, map it to the new local ID
				if ( isset( $this->processed_posts[ $post_parent ] ) ) {
					$post_parent = $this->processed_posts[ $post_parent ];
					// otherwise record the parent for later
				} else {
					$this->post_orphans[ $old_post_id ] = $post_parent;
					$post_parent                        = 0;
				}
			}

			// map the post author
			$author = sanitize_user( $post['post_author'], true );
			if ( isset( $this->author_mapping[ $author ] ) ) {
				$author = $this->author_mapping[ $author ];
			} else {
				$author = (int) get_current_user_id();
			}

			$postdata = array(
				'import_id'      => $old_post_id,
				'post_author'    => $author,
				'post_date'      => $post['post_date'],
				'post_date_gmt'  => $post['post_date_gmt'],
				'post_content'   => $post['post_content'],
				'post_excerpt'   => $post['post_excerpt'],
				'post_title'     => $post['post_title'],
				'post_status'    => $post['status'],
				'post_name'      => $post['post_name'],
				'comment_status' => $post['comment_status'],
				'ping_status'    => $post['ping_status'],
				'guid'           => $post['guid'],
				'post_parent'    => $post_parent,
				'menu_order'     => $post['menu_order'],
				'post_type'      => $post['post_type'],
				'post_password'  => $post['post_password']
			);

			$original_post_ID = $old_post_id;
			$postdata         = apply_filters( 'wp_import_post_data_processed', $postdata, $post );

			$postdata = wp_slash( $postdata );

			if ( 'attachment' == $postdata['post_type'] ) {

				$remote_url = ! empty( $post['attachment_url'] ) ? $post['attachment_url'] : $post['guid'];

				// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
				// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
				$postdata['upload_date'] = $post['post_date'];
				if ( isset( $post['postmeta'] ) ) {
					foreach ( $post['postmeta'] as $meta ) {
						if ( $meta['key'] == '_wp_attached_file' ) {
							if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) ) {
								$postdata['upload_date'] = $matches[0];
							}
							break;
						}
					}
				}
				$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url );
				if ( ! $comment_post_ID || is_wp_error( $comment_post_ID ) ) {
					$comment_post_ID = $post_id = $this->_insert_attachment_demo_image();
				}
			} else {
				$comment_post_ID = $post_id = wp_insert_post( $postdata, true );
				do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
			}

			if ( is_wp_error( $post_id ) ) {
				return false;
			}

			if ( $post['is_sticky'] == 1 ) {
				stick_post( $post_id );
			}

			$this->_set_object_is_demo_content( 'post', $post_id );
		}

		// map pre-import ID to local ID
		$this->processed_posts[ $old_post_id ] = (int) $post_id;

		// Update post terms
		$this->update_post_terms( $post_id, $post );

		// Update post comments
		$this->update_post_comment( $post_id, $comment_post_ID, $post );

		// Update post meta
		$this->update_post_meta( $post_id, $post, $attachment_demo_image_id );
	}

	/**
	 * Update post categories/tags/terms etc
	 *
	 * @param int $post_id
	 * @param array $post
	 */
	public function update_post_terms( $post_id, $post ) {
		if ( ! isset( $post['terms'] ) ) {
			$post['terms'] = array();
		}

		$post['terms'] = apply_filters( 'wp_import_post_terms', $post['terms'], $post_id, $post );

		// add categories, tags and other terms
		if ( ! empty( $post['terms'] ) ) {
			$terms_to_set = array();
			foreach ( $post['terms'] as $term ) {
				// back compat with WXR 1.0 map 'tag' to 'post_tag'
				$taxonomy    = ( 'tag' == $term['domain'] ) ? 'post_tag' : $term['domain'];
				$term_exists = term_exists( $term['slug'], $taxonomy );
				$term_id     = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
				if ( ! $term_id ) {
					$t = wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'] ) );
					if ( ! is_wp_error( $t ) ) {
						$term_id = $t['term_id'];
						do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
					} else {
						do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
						continue;
					}
				}
				$terms_to_set[ $taxonomy ][] = intval( $term_id );
			}

			foreach ( $terms_to_set as $tax => $ids ) {
				$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
				do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
			}
			unset( $post['terms'], $terms_to_set );
		}
	}

	/**
	 * Update post comments
	 *
	 * @param int $post_id
	 * @param int $comment_post_ID
	 * @param array $post
	 */
	public function update_post_comment( $post_id, $comment_post_ID, $post ) {
		if ( ! isset( $post['comments'] ) ) {
			$post['comments'] = array();
		}

		$post['comments'] = apply_filters( 'wp_import_post_comments', $post['comments'], $post_id, $post );

		// add/update comments
		if ( ! empty( $post['comments'] ) ) {
			$post_exists       = $this->post_exists( $post );
			$num_comments      = 0;
			$inserted_comments = array();
			foreach ( $post['comments'] as $comment ) {
				$comment_id                                         = $comment['comment_id'];
				$newcomments[ $comment_id ]['comment_post_ID']      = $comment_post_ID;
				$newcomments[ $comment_id ]['comment_author']       = $comment['comment_author'];
				$newcomments[ $comment_id ]['comment_author_email'] = $comment['comment_author_email'];
				$newcomments[ $comment_id ]['comment_author_IP']    = $comment['comment_author_IP'];
				$newcomments[ $comment_id ]['comment_author_url']   = $comment['comment_author_url'];
				$newcomments[ $comment_id ]['comment_date']         = $comment['comment_date'];
				$newcomments[ $comment_id ]['comment_date_gmt']     = $comment['comment_date_gmt'];
				$newcomments[ $comment_id ]['comment_content']      = $comment['comment_content'];
				$newcomments[ $comment_id ]['comment_approved']     = $comment['comment_approved'];
				$newcomments[ $comment_id ]['comment_type']         = $comment['comment_type'];
				$newcomments[ $comment_id ]['comment_parent']       = $comment['comment_parent'];
				$newcomments[ $comment_id ]['commentmeta']          = isset( $comment['commentmeta'] ) ? $comment['commentmeta'] : array();
				if ( isset( $this->processed_authors[ $comment['comment_user_id'] ] ) ) {
					$newcomments[ $comment_id ]['user_id'] = $this->processed_authors[ $comment['comment_user_id'] ];
				}
			}
			ksort( $newcomments );

			foreach ( $newcomments as $key => $comment ) {
				// if this is a new post we can skip the comment_exists() check
				if ( ! $post_exists || ! comment_exists( $comment['comment_author'], $comment['comment_date'] ) ) {
					if ( isset( $inserted_comments[ $comment['comment_parent'] ] ) ) {
						$comment['comment_parent'] = $inserted_comments[ $comment['comment_parent'] ];
					}
					$comment                   = wp_filter_comment( $comment );
					$inserted_comments[ $key ] = wp_insert_comment( $comment );

					do_action( 'wp_import_insert_comment', $inserted_comments[ $key ], $comment, $comment_post_ID, $post );

					foreach ( $comment['commentmeta'] as $meta ) {
						$value = maybe_unserialize( $meta['value'] );
						// Hook to enable ignore some comment's meta
						$meta['key'] = apply_filters( 'import_comment_meta_key', $meta['key'], $value );
						if ( ! $meta['key'] ) {
							continue;
						}
						add_comment_meta( $inserted_comments[ $key ], $meta['key'], $value );
					}

					$num_comments ++;

					$this->_set_object_is_demo_content( 'comment', $inserted_comments[ $key ] );
				}
			}
			unset( $newcomments, $inserted_comments, $post['comments'] );
		}
	}

	/**
	 * Update all post meta.
	 *
	 * @param int $post_id
	 * @param array $post
	 * @param mixed $attachment_demo_image_id
	 */
	public function update_post_meta( $post_id, $post, $attachment_demo_image_id = false ) {
		if ( ! isset( $post['postmeta'] ) ) {
			$post['postmeta'] = array();
		}

		$post['postmeta'] = apply_filters( 'wp_import_post_meta', $post['postmeta'], $post_id, $post );

		// add/update post meta
		if ( ! empty( $post['postmeta'] ) ) {
			foreach ( $post['postmeta'] as $meta ) {
				$key   = apply_filters( 'import_post_meta_key', $meta['key'], $post_id, $post );
				$value = false;

				if ( '_edit_last' == $key ) {
					if ( isset( $this->processed_authors[ intval( $meta['value'] ) ] ) ) {
						$value = $this->processed_authors[ intval( $meta['value'] ) ];
					} else {
						$key = false;
					}
				}

				if ( $key ) {
					// export gets meta straight from the DB so could have a serialized string
					if ( ! $value ) {
						$value = thim_maybe_unserialize( $meta['value'] );
					}
					// if the post has a featured image, take note of this in case of remap
					if ( '_thumbnail_id' == $key ) {

						if ( $attachment_demo_image_id && is_numeric( $attachment_demo_image_id ) ) {
							$value = $attachment_demo_image_id;
						}

						$this->featured_images[ $post_id ] = (int) $value;
					}

					if ( $key === '_elementor_data' ) {
						$meta_handler = new Thim_Elementor_Import_Service( $value, $this->_chunks['base_blog_url'] );
						$meta_handler->filter_meta();
					}

					// tuanta edit import global setting elementor
					if ( '_elementor_template_type' == $key ) {
						update_post_meta( $post_id, wp_slash( $key ), wp_slash_strings_only( $value ) );
					}else{
						add_post_meta( $post_id, wp_slash( $key ), wp_slash_strings_only( $value ) );
					}

  					do_action( 'import_post_meta', $post_id, $key, $value );
				}
			}
		}
	}

	/**
	 * Store object data to server files
	 */
	public function set_cache_objects() {
		$cache_objects = array(
			'processed_posts',
			'processed_authors',
			'post_orphans',
			'featured_images',
			'author_mapping',
			'processed_menu_items',
			'menu_item_orphans',
			'missing_menu_items',
			'url_remap'
		);
		foreach ( $cache_objects as $object ) {
			$this->_set_cache_data( $object, $this->{$object} );
		}
	}

	/**
	 * Import posts
	 *
	 * @param bool
	 *
	 * @return bool|mixed
	 */
	public function import_posts( $fetch_attachment = false ) {
		wp_suspend_cache_invalidation( true );
		$has_posts         = true;
		$current_post_type = $this->_get_current_post_type();
		$next_posts        = false;
		/**
		 * We check data need to import by a priority.
		 * If the data with a highest priority has imported then move
		 * to next.
		 *
		 * Priorities: this can be changed
		 * + Categories
		 * + Tags
		 * + Terms
		 * + Post types
		 */
		if ( $categories = $this->get_cache_data( 'categories' ) ) {
			$this->categories = $categories;
 			$this->process_categories();
 		} elseif ( $tags = $this->get_cache_data( 'tags' ) ) {
			$this->tags = $tags;
			$this->process_tags();
		} elseif ( $terms = $this->get_cache_data( 'terms' ) ) {
			$this->terms = $terms;
			$this->process_terms();
		} else {
			$next_posts = $this->_get_next_posts();
			if ( $next_posts ) {
				if ( ! $fetch_attachment ) {
					$attachment_id = $this->_insert_attachment_demo_image();
				} else {
					$attachment_id = true;
				}
				$this->_import_posts( $next_posts, $attachment_id );
			}
			$has_posts = $this->_get_current_post_type();
			// we are in the end
			if ( ! $has_posts ) {
				$this->backfill_parents();
				$this->backfill_attachment_urls();
				$this->remap_featured_images();
			}
		}
		wp_suspend_cache_invalidation( false );
		$percentage = 1;

		if ( $current_post_type == 'attachment' ) {
			$this->_chunks['attachment']['processed'] ++;
			if ( $this->_chunks['attachment']['chunks'] ) {
				$percentage = intval( $this->_chunks['attachment']['processed'] / $this->_chunks['attachment']['chunks'] * 100 );
			}
		} else {
			$this->_chunks['posts']['processed'] ++;
			if ( $this->_chunks['posts']['chunks'] ) {
				$percentage = intval( $this->_chunks['posts']['processed'] / $this->_chunks['posts']['chunks'] * 100 );
			}
		}
		$this->_set_cache_data( 'chunks', $this->_chunks );

		$this->set_cache_objects();

		return array(
			'current'    => $current_post_type,
			'has_posts'  => $has_posts,
			'percentage' => min( 100, $percentage )
		);
	}

	public function set_menu_locations() {
		// There is not any terms processed
		if ( ! $this->processed_terms ) {
			return;
		}

		// There is not any menu locations
		if ( ! $menu_locations = get_theme_mod( 'nav_menu_locations' ) ) {
			return;
		}

		$error_locations = array();
		/*
		 * Loop through all menu locations
		 * Those are menu items from export
		 */
		foreach ( $menu_locations as $location => $menu_id ) {
			if ( empty( $this->processed_terms[ $menu_id ] ) ) {
				$error_locations[] = $location;
				continue;
			}

			/**
			 * Get menu object by new id, ignore if the menu does not exists
			 */
			$new_menu_id = $this->processed_terms[ $menu_id ];
			$new_menu    = wp_get_nav_menu_object( $new_menu_id );
			if ( is_wp_error( $new_menu ) ) {
				$error_locations[] = $location;
				continue;
			}
			$menu_locations[ $location ] = $new_menu_id;
		}

		// remove all locations is invalid
		if ( $error_locations ) {
			foreach ( $error_locations as $location ) {
				unset( $menu_locations[ $location ] );
			}
		}

		if ( ! $menu_locations ) {
			remove_theme_mod( 'nav_menu_locations' );
		} else {
			set_theme_mod( 'nav_menu_locations', $menu_locations );
		}
	}

	/**
	 * Analyze content of demo
	 *
	 * @since 1.3.4
	 *
	 * @param $xml
	 */
	public function analyze_content( $xml ) {
		$this->clean_demo_content();
		$content_file = $xml;

		$parser = new WXR_Parser();
		$data   = $parser->parse( $content_file );

		$chunks = array(
			'posts'      => array( 'chunks' => 0, 'processed' => 0 ),
			'attachment' => array( 'chunks' => 0, 'processed' => 0 )
		);

		$chunks['base_blog_url'] = esc_url( $data['base_blog_url'] );

		if ( $data['posts'] ) {
			$posts      = $data['posts'];
			$post_types = array();
			//$posts = array_chunk( $posts, 25);
			foreach ( $posts as $k => $post ) {
				if ( empty( $post_types[ $post['post_type'] ] ) ) {
					$post_types[ $post['post_type'] ] = array();
				}
				$post_types[ $post['post_type'] ][] = $post;
			}
			$pp = array();
			if ( ! empty( $post_types['post'] ) ) {
				$pp['post'] = $post_types['post'];
				unset( $post_types['post'] );
			}

			if ( ! empty( $post_types['page'] ) ) {
				$pp['page'] = $post_types['page'];
				unset( $post_types['page'] );
			}

			if ( ! empty( $post_types['nav_menu_item'] ) ) {
				$pp['nav_menu_item'] = $post_types['nav_menu_item'];
				unset( $post_types['nav_menu_item'] );
			}

			if ( ! empty( $post_types['attachment'] ) ) {
				$attachment = $post_types['attachment'];
				unset( $post_types['attachment'] );
			}

			$post_types = array_merge( $pp, $post_types );
			if ( isset( $attachment ) ) {
				$post_types['attachment'] = $attachment;
			}
			$registered_posts = get_post_types( '', 'objects' );

			foreach ( $post_types as $post_type => $posts ) {
				if ( ! empty( $registered_posts[ $post_type ] ) && ( $size_of_posts = sizeof( $posts ) ) ) {

					if ( $post_type == 'attachment' ) {
						if ( empty( $chunks['attachment'] ) ) {
							$chunks['attachment'] = array( 'chunks' => 0, 'processed' => 0 );
						}
						$chunks['attachment']['chunks'] += ceil( $size_of_posts / $this->_attachments_per_page );
					} else {
						if ( empty( $chunks['posts'] ) ) {
							$chunks['posts'] = array( 'chunks' => 0, 'processed' => 0 );
						}
						$chunks['posts']['chunks'] += ceil( $size_of_posts / $this->_posts_per_page );
					}
					$this->_set_cache_data( "posts-{$post_type}", $posts );

				} else {
					unset( $post_types[ $post_type ] );
				}
			}

			$this->_post_types = array_keys( $post_types );
		}
		$this->_set_cache_data( 'post-types', $this->_post_types );

		if ( empty( $data['authors'] ) ) {
			$authors = array();
			$this->_get_author_from_posts( $authors, $data['posts'] );
			$data['authors'] = $authors;
		}

		foreach ( array( 'terms', 'categories', 'tags', 'authors' ) as $type ) {
			if ( ! empty( $data[ $type ] ) ) {
				$this->_set_cache_data( $type, $data[ $type ] );
				$chunks['posts']['chunks'] += 1;
			}
		}
		$this->_chunks = $chunks;
		$this->_set_cache_data( 'chunks', $this->_chunks );
		do_action( 'thim_import_parse_demo_data', $this );
	}

	/**
	 * Get current demo information.
	 *
	 * @param string $field
	 *
	 * @return mixed
	 */
	public function get_current_demo( $field = '' ) {
		$current_demo = get_option( 'thim_importer_current_demo' );
		if ( $field && array_key_exists( $field, $current_demo ) ) {
			$get = $current_demo[ $field ];
		} else {
			$get = $current_demo;
		}

		return $get;
	}

	/**
	 * Get cache path for current demo.
	 * Create new path if it does not exists.
	 *
	 * @return null|string
	 */
	public function get_demo_cache_path() {
		$upload_dir       = wp_upload_dir();
		$this->_cache_dir = $upload_dir['basedir'] . "/thim-import-demo/" . $this->get_current_demo( 'demo' );

		//$this->rmdir( $this->_cache_dir );

		if ( ! Thim_File_Helper::mkdir( $this->_cache_dir ) ) {
			die( sprintf( __( 'Unable to create directory %s' ), $this->_cache_dir ) );
		}

		Thim_File_Helper::mkdir( $this->_cache_dir . '/cache' );

		return $this->_cache_dir;
	}

	/**
	 * Filter to continue or ignore importing object's meta
	 *
	 * @param        $return_me
	 * @param        $meta_key
	 * @param string $unused
	 *
	 * @return bool
	 */
	public function import_object_meta( $return_me, $meta_key, $unused = '' ) {
		if ( '_thim_demo_content' == $return_me ) {
			$return_me = false;
		}

		return $return_me;
	}

	function add_log( $file ) {
		ob_start();
		foreach ( func_get_args() as $arg ) {
			print_r( $arg );
		}
		$output = ob_get_clean();
		@file_put_contents( ABSPATH . '/' . $file, $output );
	}

	/**
	 * Delete anything that we has marked it as demo content.
	 *
	 * @return bool
	 */
	public function clean_demo_content() {
		$this->_clean_posts();
		$this->_clean_taxes();
		$this->_clean_comments();
		$this->_clean_users();

		return true;
	}

	/**
	 * Clean all terms including categories, tags, terms, etc...
	 */
	private function _clean_taxes() {
		global $wpdb;

		$exclude = get_option( 'default_category' );
		/**
		 * Custom query to get all taxonomies marked as demo content data
		 */
		$query = $wpdb->prepare( "
			SELECT *
			FROM {$wpdb->terms} AS t
			INNER JOIN {$wpdb->term_taxonomy} as tt ON tt.term_id = t.term_id
			INNER JOIN {$wpdb->termmeta} tm ON tt.term_id = tm.term_id AND tm.meta_key = %s
			WHERE t.term_id <> %d
		", '_thim_demo_content', $exclude );

		if ( $terms = $wpdb->get_results( $query ) ) {
			$tt_ids            = array();
			$term_ids          = array();
			$update_parents    = array();
			$update_in_parents = array();
			foreach ( $terms as $term ) {

				$parent              = $term->parent;
				$taxonomy            = $term->taxonomy;
				$update_parents[]    = $wpdb->prepare( "WHEN parent = %d AND taxonomy = %s THEN %d", $term->term_id, $taxonomy, $parent );
				$update_in_parents[] = $parent;

				$tt_ids[]   = $term->term_taxonomy_id;
				$term_ids[] = $term->term_id;
			}

			// Update children of current term being deleted to it parent
			$parent_format = array_fill( 0, sizeof( $update_in_parents ), '%d' );
			$query         = $wpdb->prepare( "
				UPDATE {$wpdb->term_taxonomy}
				SET parent = CASE
				" . join( "\n", $update_parents ) . "
				ELSE parent
				END
				WHERE parent IN(" . join( ',', $parent_format ) . ")
			", $update_in_parents );
			$wpdb->query( $query );

			$tt_format = array_fill( 0, sizeof( $tt_ids ), '%d' );

			// Delete term metas
			$term_format = array_fill( 0, sizeof( $term_ids ), '%d' );
			$query       = $wpdb->prepare( "
				DELETE
				FROM {$wpdb->termmeta}
				WHERE term_id IN(" . join( ',', $term_format ) . ")
			", $term_ids );
			$wpdb->query( $query );

			// Delete term taxonomies
			$wpdb->query(
				$wpdb->prepare( "
					DELETE
					FROM {$wpdb->term_taxonomy}
					WHERE term_taxonomy_id IN(" . join( ',', $tt_format ) . ")
				", $tt_ids )
			);

			$this->_delete_object_term_relationships( $tt_ids );

			// Fire actions
			foreach ( $tt_ids as $tt_id ) {
				do_action( 'deleted_term_taxonomy', $tt_id );
			}


			$format = array_fill( 0, sizeof( $term_ids ), '%d' );
			$wpdb->query(
				$wpdb->prepare( "
					DELETE
					FROM {$wpdb->terms}
					WHERE term_id IN(" . join( ',', $format ) . ")
				", $term_ids )
			);

			// Finally, force cleaning ALL cache
			wp_cache_flush();
		}
	}

	private function _clean_comments() {
		global $wpdb;

		$query = $wpdb->prepare( "
			SELECT c.comment_ID
			FROM {$wpdb->comments} c
			INNER JOIN {$wpdb->commentmeta} cm ON cm.comment_id = c.comment_ID
			WHERE cm.meta_key = %s
			AND cm.meta_value = %s
		", $this->_thim_demo_content_key, 'yes' );

		$comment_ids = $wpdb->get_col( $query );

		if ( count( $comment_ids ) > 0 ) {
			// Delete all metas to prevent wp delete each meta individually
			$this->_delete_comment_metas( $comment_ids );

			foreach ( $comment_ids as $index => $id ) {
				wp_delete_comment( $id, true );

				// TODO: Maybe todo more here
				continue;
				// Move children up a level.
				$children = $wpdb->get_col( $wpdb->prepare( "SELECT comment_ID FROM $wpdb->comments WHERE comment_parent = %d", $comment->comment_ID ) );
				if ( ! empty( $children ) ) {
					$wpdb->update( $wpdb->comments, array( 'comment_parent' => $comment->comment_parent ), array( 'comment_parent' => $comment->comment_ID ) );
					clean_comment_cache( $children );
				}

				// Delete metadata
				$meta_ids = $wpdb->get_col( $wpdb->prepare( "SELECT meta_id FROM $wpdb->commentmeta WHERE comment_id = %d", $comment->comment_ID ) );
				foreach ( $meta_ids as $mid ) {
					delete_metadata_by_mid( 'comment', $mid );
				}

				if ( ! $wpdb->delete( $wpdb->comments, array( 'comment_ID' => $comment->comment_ID ) ) ) {
					return false;
				}

				/**
				 * Fires immediately after a comment is deleted from the database.
				 *
				 * @since 2.9.0
				 *
				 * @param int $comment_id The comment ID.
				 */
				do_action( 'deleted_comment', $comment->comment_ID );

				$post_id = $comment->comment_post_ID;
				if ( $post_id && $comment->comment_approved == 1 ) {
					wp_update_comment_count( $post_id );
				}

				clean_comment_cache( $comment->comment_ID );

				/** This action is documented in wp-includes/comment.php */
				do_action( 'wp_set_comment_status', $comment->comment_ID, 'delete' );

				wp_transition_comment_status( 'delete', $comment->comment_approved, $comment );

			}
		}
	}

	private function _clean_users() {
		global $wpdb;

		$query    = $wpdb->prepare( "
			SELECT ID
			FROM {$wpdb->users} u
			INNER JOIN {$wpdb->usermeta} um ON um.user_id = u.ID
			WHERE um.meta_key = %s
			AND um.meta_value = %s
		", $this->_thim_demo_content_key, 'yes' );
		$user_ids = $wpdb->get_col( $query );
		if ( $user_ids ) {
			$in = array_fill( 0, sizeof( $user_ids ), '%d' );
			// Delete records from table users and usermeta
			$query = $wpdb->prepare( "
				DELETE FROM {$wpdb->users}, {$wpdb->usermeta}
				USING {$wpdb->users}, {$wpdb->usermeta}
				WHERE {$wpdb->users}.ID = {$wpdb->usermeta}.user_id
				AND {$wpdb->users}.ID IN(" . join( ",", $in ) . ")
			", $user_ids );
			$wpdb->query( $query );
		}

	}

	private function _delete_comment_metas( $comment_ids ) {
		global $wpdb;
		if ( ! $comment_ids ) {
			return false;
		}
		settype( $comment_ids, 'array' );
		$comment_format_ids = array_fill( 0, sizeof( $comment_ids ), '%d' );
		$query              = $wpdb->prepare( "
			DELETE
			FROM {$wpdb->commentmeta}
			WHERE comment_id IN(" . join( ',', $comment_format_ids ) . ")
		", $comment_ids );
		$wpdb->query( $query );

		return true;
	}

	private function _delete_post_metas( $post_ids ) {
		global $wpdb;
		if ( ! $post_ids ) {
			return false;
		}
		settype( $post_ids, 'array' );
		$post_format_ids = array_fill( 0, sizeof( $post_ids ), '%d' );
		$query           = $wpdb->prepare( "
			DELETE
			FROM {$wpdb->postmeta}
			WHERE post_id IN(" . join( ',', $post_format_ids ) . ")
		", $post_ids );
		$wpdb->query( $query );

		return true;
	}

	/**
	 * Clean all post types and it's meta. This function also delete
	 * attachment's data from database and remove image files from
	 * server.
	 */
	private function _clean_posts() {
		global $wpdb;

		// Firstly, we need to delete all posts (and it's meta data) has meta $this->_thim_demo_content_key is 'yes'.
		// But, we do not delete attachment.
		$query    = $wpdb->prepare( "
			SELECT ID
			FROM $wpdb->posts p
			INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
			WHERE pm.meta_key = %s
			AND pm.meta_value = %s
			AND p.post_type <> %s
		", $this->_thim_demo_content_key, 'yes', 'attachment' );
		$post_ids = $wpdb->get_col( $query );
		if ( $post_ids ) {
			$this->_delete_object_term_relationships( $post_ids, 'object_id' );

			$in = array_fill( 0, sizeof( $post_ids ), '%d' );
			// Delete records from table posts and postmeta
			$query = $wpdb->prepare( "
				DELETE FROM {$wpdb->posts}, {$wpdb->postmeta}
				USING {$wpdb->posts}, {$wpdb->postmeta}
				WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
				AND {$wpdb->posts}.ID IN(" . join( ",", $in ) . ")
			", $post_ids );
			$wpdb->query( $query );
		}

		/**
		 * Now, we get all attachment ids and use wp_delete_attachment.
		 * This function will take care the rest
		 */
		$query = $wpdb->prepare( "
			SELECT ID
			FROM $wpdb->posts p
			INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
			WHERE pm.meta_key = %s
			AND pm.meta_value = %s
			AND p.post_type = %s
		", $this->_thim_demo_content_key, 'yes', 'attachment' );
		if ( $attachments = $wpdb->get_col( $query ) ) {

			// Delete metas of comments for all attachments
			$format_attachment_ids = array_fill( 0, sizeof( $attachments ), '%d' );
			$comment_ids           = $wpdb->get_col( $wpdb->prepare( "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID IN(" . join( ',', $format_attachment_ids ) . ")", $attachments ) );
			$this->_delete_comment_metas( $comment_ids );

			// Delete attachment from term relationships
			$this->_delete_object_term_relationships( $attachments, 'object_id' );
			foreach ( $attachments as $attachment ) {
				$this->_delete_attachment( $attachment );
				/**
				 * There are some queries in this function.
				 * So, this may is not a good solution in this case.
				 */
				//wp_delete_attachment( $attachment, true );
			}

			$in = array_fill( 0, sizeof( $attachments ), '%d' );
			// Delete records from table posts and postmeta
			$query = $wpdb->prepare( "
				DELETE FROM {$wpdb->posts}, {$wpdb->postmeta}
				USING {$wpdb->posts}, {$wpdb->postmeta}
				WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
				AND {$wpdb->posts}.ID IN(" . join( ",", $in ) . ")
			", $attachments );
			$wpdb->query( $query );
		}
	}

	private function _delete_object_term_relationships( $ids, $by = 'term_taxonomy_id' ) {
		global $wpdb;
		if ( ! $ids ) {
			return;
		}
		if ( is_string( $ids ) || is_numeric( $ids ) ) {
			$ids = array( $ids );
		}
		$format = array_fill( 0, sizeof( $ids ), '%d' );

		if ( $by == 'object_id' ) {
			$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->term_relationships WHERE object_id IN (" . join( ',', $format ) . ")", $ids ) );
		} else if ( $by ) {
			$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id IN (" . join( ',', $format ) . ")", $ids ) );
		}
	}

	private function _delete_attachment( $post_id ) {
		try {
			$meta         = wp_get_attachment_metadata( $post_id );
			$backup_sizes = get_post_meta( $post_id, '_wp_attachment_backup_sizes', true );
			$file         = get_attached_file( $post_id );
			$post = get_post( $post_id );

			if ( is_multisite() ) {
				delete_transient( 'dirsize_cache' );
			}

			/**
			 * Fires before an attachment is deleted, at the start of wp_delete_attachment().
			 *
			 * @since 2.0.0
			 *
			 * @param int $post_id Attachment ID.
			 */
			do_action( 'delete_attachment', $post_id, $post );

			wp_defer_comment_counting( false );

			do_action( 'delete_post', $post_id, $post );
			do_action( 'deleted_post', $post_id, $post );

			$uploadpath = wp_get_upload_dir();

			if ( ! empty( $meta['thumb'] ) ) {
				$thumbfile = str_replace( basename( $file ), $meta['thumb'], $file );
				/** This filter is documented in wp-includes/functions.php */
				$thumbfile = apply_filters( 'wp_delete_file', $thumbfile );
				@ unlink( path_join( $uploadpath['basedir'], $thumbfile ) );
			}

			// Remove intermediate and backup images if there are any.
			if ( isset( $meta['sizes'] ) && is_array( $meta['sizes'] ) ) {
				foreach ( $meta['sizes'] as $size => $sizeinfo ) {
					$intermediate_file = str_replace( basename( $file ), $sizeinfo['file'], $file );
					/** This filter is documented in wp-includes/functions.php */
					$intermediate_file = apply_filters( 'wp_delete_file', $intermediate_file );
					@ unlink( path_join( $uploadpath['basedir'], $intermediate_file ) );
				}
			}

			if ( is_array( $backup_sizes ) ) {
				foreach ( $backup_sizes as $size ) {
					$del_file = path_join( dirname( $meta['file'] ), $size['file'] );
					/** This filter is documented in wp-includes/functions.php */
					$del_file = apply_filters( 'wp_delete_file', $del_file );
					@ unlink( path_join( $uploadpath['basedir'], $del_file ) );
				}
			}
			wp_delete_file( $file );
		} catch ( Throwable $e ) {
			error_log( $e->getMessage() );
		}
	}

	/**
	 * Clean cache folder
	 */
	private function _clean_cache_folder() {
		Thim_File_Helper::rmdir( $this->_cache_dir . '/cache' );
		Thim_File_Helper::mkdir( $this->_cache_dir . '/cache' );
	}

	/**
	 * Mark a post is demo content imported by ThimImporter
	 *
	 * @param string $object_type
	 * @param int $object_id
	 * @param string $key
	 * @param string $value
	 *
	 * @return mixed
	 */
	private function _set_object_is_demo_content( $object_type, $object_id, $key = '_thim_demo_content', $value = 'yes' ) {
		$caller = 'update_post_meta';
		switch ( $object_type ) {
			case 'user':
			case 'post':
			case 'term':
			case 'comment':
				$caller = "update_{$object_type}_meta";
				break;

		}
		if ( is_callable( $caller ) ) {
			$args = array(
				$object_id,
				$key,
				$value
			);

			return call_user_func_array( $caller, $args );
		}

		return false;
	}

	/**
	 * Attempt to download a remote file attachment
	 *
	 * @param string $url URL of item to fetch
	 * @param array $post Attachment details
	 *
	 * @return array|WP_Error Local file location details on success, WP_Error otherwise
	 */
	function fetch_remote_file( $url, $post ) {
		$file_name = basename( $url );

		// get placeholder file in the upload dir with a unique, sanitized filename
		$upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );
		if ( $upload['error'] ) {
			return new WP_Error( 'upload_dir_error', $upload['error'] );
		}

		$download = Thim_Remote_Helper::download( $url, $upload['file'] );

		if ( is_wp_error( $download ) ) {
			thim_add_log( $download->get_error_message(), $download->get_error_code() );

			return $download;
		}

		// keep track of the old and new urls so we can substitute them later
		$this->url_remap[ $url ]          = $upload['url'];
		$this->url_remap[ $post['guid'] ] = $upload['url']; // r13735, really needed?

		return $upload;
	}

	/**
	 * Attempt to create a new menu item from import data
	 *
	 * Fails for draft, orphaned menu items and those without an associated nav_menu
	 * or an invalid nav_menu term. If the post type or term object which the menu item
	 * represents doesn't exist then the menu item will not be imported (waits until the
	 * end of the import to retry again before discarding).
	 *
	 * @param array $item Menu item details from WXR file
	 *
	 * @return bool|int
	 */
	function process_menu_item( $item, $backfill = false ) {
		if ( ! $item ) {
			return false;
		}

		$old_post_id = intval( $item['post_id'] );
		// skip draft, orphaned menu items
		if ( 'draft' == $item['status'] ) {
			return false;
		}


		if ( isset( $this->processed_menu_items[ $old_post_id ] ) ) {
			return false;
		}

		if ( isset( $this->processed_posts[ $old_post_id ] ) ) {
			//return false;
		}


		$menu_slug = false;
		if ( isset( $item['terms'] ) ) {
			// loop through terms, assume first nav_menu term is correct menu
			foreach ( $item['terms'] as $term ) {
				if ( 'nav_menu' == $term['domain'] ) {
					$menu_slug = $term['slug'];
					break;
				}
			}
		}

		// no nav_menu term associated with this menu item
		if ( ! $menu_slug ) {
			_e( 'Menu item skipped due to missing menu slug', 'wordpress-importer' );
			echo '<br />';

			return false;
		}

		$menu_id = term_exists( $menu_slug, 'nav_menu' );
		if ( ! $menu_id ) {
			printf( __( 'Menu item skipped due to invalid menu slug: %s', 'wordpress-importer' ), esc_html( $menu_slug ) );
			echo '<br />';

			return false;
		} else {
			$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
		}

		$_menu_item_object_id        = 0;
		$_menu_item_menu_item_parent = 0;
		$_menu_item_type             = '';
		$_menu_item_classes          = '';
		$_menu_item_object           = '';
		$_menu_item_url              = '';
		$_menu_item_target           = '';
		$_menu_item_xfn              = '';

		$dynamic_variables = array();
		foreach ( $item['postmeta'] as $meta ) {
			$dynamic_variables[ $meta['key'] ] = $meta['value'];
		}
		extract( $dynamic_variables );

		if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[ intval( $_menu_item_object_id ) ] ) ) {
			$_menu_item_object_id = $this->processed_terms[ intval( $_menu_item_object_id ) ];
		} else if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[ intval( $_menu_item_object_id ) ] ) ) {
			$_menu_item_object_id = $this->processed_posts[ intval( $_menu_item_object_id ) ];
		} else if ( 'post_type_archive' == $_menu_item_type && isset( $this->processed_posts[ intval( $_menu_item_object_id ) ] ) ) {
			$_menu_item_object_id = $this->processed_posts[ intval( $_menu_item_object_id ) ];
		} else if ( $backfill && 'post_type_archive' == $_menu_item_type ) {
			// do nothing???
		} else if ( 'custom' != $_menu_item_type ) {
			// associated object is missing or not imported yet, we'll retry later
			$this->missing_menu_items[ $old_post_id ] = $item;

			return false;
		}

		if ( isset( $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ] ) ) {
			$_menu_item_menu_item_parent = $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ];
		} else if ( $_menu_item_menu_item_parent ) {
			$this->menu_item_orphans[ intval( $item['post_id'] ) ] = (int) $_menu_item_menu_item_parent;
			$_menu_item_menu_item_parent                           = 0;
		}

		// wp_update_nav_menu_item expects CSS classes as a space separated string
		$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
		if ( is_array( $_menu_item_classes ) ) {
			$_menu_item_classes = implode( ' ', $_menu_item_classes );
		}

		$args = array(
			'menu-item-object-id'   => $_menu_item_object_id,
			'menu-item-object'      => $_menu_item_object,
			'menu-item-parent-id'   => $_menu_item_menu_item_parent,
			'menu-item-position'    => intval( $item['menu_order'] ),
			'menu-item-type'        => $_menu_item_type,
			'menu-item-title'       => $item['post_title'],
			'menu-item-url'         => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title'  => $item['post_excerpt'],
			'menu-item-target'      => $_menu_item_target,
			'menu-item-classes'     => $_menu_item_classes,
			'menu-item-xfn'         => $_menu_item_xfn,
			'menu-item-status'      => $item['status']
		);

		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( $id && ! is_wp_error( $id ) ) {

			$this->processed_menu_items[ $old_post_id ] = (int) $id;
			$this->processed_posts[ $old_post_id ]      = (int) $id;

			$this->_set_object_is_demo_content( 'post', intval( $id ) );


			// Add post meta
			if ( ! empty( $item['postmeta'] ) ) {
				$item['postmeta'] = apply_filters( 'tc_importer_meta_menu_item', $item['postmeta'], $item );

				foreach ( $item['postmeta'] as $meta ) {
					if ( metadata_exists( 'post', $id, $meta['key'] ) ) {
						continue;
					}

					$value = thim_maybe_unserialize( $meta['value'] );
					add_post_meta( $id,  $meta['key'] ,  $value );
 				}
			}

		}

		return $id;
	}


	function backfill_parents() {
		global $wpdb;

		// find parents for post orphans
		foreach ( $this->post_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = false;
			if ( isset( $this->processed_posts[ $child_id ] ) ) {
				$local_child_id = $this->processed_posts[ $child_id ];
			}
			if ( isset( $this->processed_posts[ $parent_id ] ) ) {
				$local_parent_id = $this->processed_posts[ $parent_id ];
			}

			if ( $local_child_id && $local_parent_id ) {
				$wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
				clean_post_cache( $local_child_id );
			}
		}

		// all other posts/terms are imported, retry menu items with missing associated object
		$missing_menu_items = $this->missing_menu_items;
		foreach ( $missing_menu_items as $item ) {
			$this->process_menu_item( $item );
		}

		// find parents for menu item orphans
		foreach ( $this->menu_item_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = 0;
			if ( isset( $this->processed_menu_items[ $child_id ] ) ) {
				$local_child_id = $this->processed_menu_items[ $child_id ];
			}
			if ( isset( $this->processed_menu_items[ $parent_id ] ) ) {
				$local_parent_id = $this->processed_menu_items[ $parent_id ];
			}

			if ( $local_child_id && $local_parent_id ) {
				update_post_meta( $local_child_id, '_menu_item_menu_item_parent', (int) $local_parent_id );
			}
		}
	}
	/**
	 * Use stored mapping information to update old attachment URLs
	 */
	function backfill_attachment_urls() {
		global $wpdb;
		// make sure we do the longest urls first, in case one is a substring of another
		uksort( $this->url_remap, array( &$this, 'cmpr_strlen' ) );
		if ( $this->url_remap ) {
			$this->url_remap = array_filter( $this->url_remap );
		}
		if ( ! $this->url_remap ) {
			return;
		}
		foreach ( $this->url_remap as $from_url => $to_url ) {
			if ( $from_url && $to_url && strlen( $from_url ) > 5 && strlen( $to_url ) > 5 ) {
				// remap urls in post_content
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url ) );
				// remap enclosure urls
				$result = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url ) );
			}
		}
	}

	/**
	 * Add metadata to imported term.
	 *
	 * @since 0.6.2
	 *
	 * @param array $term Term data from WXR import.
	 * @param int $term_id ID of the newly created term.
	 */
	protected function process_termmeta( $term, $term_id ) {
		if ( ! isset( $term['termmeta'] ) ) {
			$term['termmeta'] = array();
		}

		/**
		 * Filters the metadata attached to an imported term.
		 *
		 * @since 0.6.2
		 *
		 * @param array $termmeta Array of term meta.
		 * @param int $term_id ID of the newly created term.
		 * @param array $term Term data from the WXR import.
		 */
		$term['termmeta'] = apply_filters( 'wp_import_term_meta', $term['termmeta'], $term_id, $term );

		if ( empty( $term['termmeta'] ) ) {
			return;
		}

		foreach ( $term['termmeta'] as $meta ) {
			/**
			 * Filters the meta key for an imported piece of term meta.
			 *
			 * @since 0.6.2
			 *
			 * @param string $meta_key Meta key.
			 * @param int $term_id ID of the newly created term.
			 * @param array $term Term data from the WXR import.
			 */
			$key = apply_filters( 'import_term_meta_key', $meta['key'], $term_id, $term );
			if ( ! $key ) {
				continue;
			}

			// Export gets meta straight from the DB so could have a serialized string
			$value = maybe_unserialize( $meta['value'] );

			if ( ! $value && strpos($meta['value'], '\\' ) !== false ) {
				$try_unserialize = wp_unslash( $meta['value'] );
				$value = maybe_unserialize( $try_unserialize );
			}

			add_term_meta( $term_id, $key, $value );

			/**
			 * Fires after term meta is imported.
			 *
			 * @since 0.6.2
			 *
			 * @param int $term_id ID of the newly created term.
			 * @param string $key Meta key.
			 * @param mixed $value Meta value.
			 */
			do_action( 'import_term_meta', $term_id, $key, $value );
		}
	}
}
