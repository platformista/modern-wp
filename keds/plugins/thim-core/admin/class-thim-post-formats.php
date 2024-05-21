<?php

/**
 * Class Thim_Post_Formats.
 *
 * @package   Thim_Core
 * @since     0.1.0
 * @docs      docs/post-formats.md
 */
class Thim_Post_Formats extends Thim_Singleton {
	/**
	 * Thim_Post_Formats constructor.
	 *
	 * @since 0.1.0
	 */
	protected function __construct() {
		$this->init_hooks();
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.1.0
	 */
	private function init_hooks() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'metabox' ) );
	}

	/**
	 * Metabox post format: Audio
	 *
	 * @since 0.1.0
	 */
	private function metabox_audio() {
		$prefix = TP::$prefix;

		$metabox_audio = array(
			'id'         => $prefix . 'metabox_audio',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Audio', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'audio' ),
			),
			'fields'     => array(
				array(
					'id'   => $prefix . 'audio',
					'name' => __( 'Audio URL or Embeded Code', 'thim-core' ),
					'desc' => '',
					'type' => 'textarea',
				),
			),
		);

		return apply_filters( 'thim_metabox_audio', $metabox_audio );
	}

	/**
	 * Metabox post format: Video
	 *
	 * @since 0.1.0
	 */
	private function metabox_video() {
		$prefix = TP::$prefix;

		$metabox_video = array(
			'id'         => $prefix . 'metabox_video',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Video', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'video' ),
			),
			'fields'     => array(
				array(
					'id'   => $prefix . 'video',
					'name' => __( 'Video URL or Embeded Code', 'thim-core' ),
					'desc' => '',
					'type' => 'textarea',
				),
			),
		);

		return apply_filters( 'thim_metabox_video', $metabox_video );
	}

	/**
	 * Metabox post format: Image
	 *
	 * @since 0.1.0
	 */
	private function metabox_image() {
		$prefix = TP::$prefix;

		$metabox_image = array(
			'id'         => $prefix . 'metabox_image',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Image', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'image' ),
			),
			'fields'     => array(
				array(
					'id'               => $prefix . 'image',
					'name'             => __( 'Select or Upload Image', 'thim-core' ),
					'desc'             => '',
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
				),
			),
		);

		return apply_filters( 'thim_metabox_image', $metabox_image );
	}

	/**
	 * Metabox post format: Gallery
	 *
	 * @since 0.1.0
	 */
	private function metabox_gallery() {
		$prefix = TP::$prefix;

		$metabox_gallery = array(
			'id'         => $prefix . 'metabox_gallery',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Gallery', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'gallery' ),
			),
			'fields'     => array(
				array(
					'id'               => $prefix . 'gallery',
					'name'             => __( 'Select or Upload Image', 'thim-core' ),
					'desc'             => '',
					'type'             => 'image_advanced',
					'max_file_uploads' => 999,
				),
			),
		);

		return apply_filters( 'thim_metabox_gallery', $metabox_gallery );
	}

	/**
	 * Metabox post format: Link
	 *
	 * @since 0.1.0
	 */
	private function metabox_link() {
		$prefix = TP::$prefix;

		$metabox_link = array(
			'id'         => $prefix . 'metabox_link',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Link', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'link' ),
			),
			'fields'     => array(
				array(
					'id'   => $prefix . 'link_url',
					'name' => __( 'URL', 'thim-core' ),
					'type' => 'text',
				),
				array(
					'id'   => $prefix . 'link_text',
					'name' => __( 'Text', 'thim-core' ),
					'type' => 'text',
				),
			),
		);

		return apply_filters( 'thim_metabox_link', $metabox_link );
	}

	/**
	 * Metabox post format: Quote
	 *
	 * @since 0.1.0
	 */
	private function metabox_quote() {
		$prefix = TP::$prefix;

		$metabox_quote = array(
			'id'         => $prefix . 'metabox_quote',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Quote', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'quote' ),
			),
			'fields'     => array(
				array(
					'id'   => $prefix . 'quote_author_text',
					'name' => __( 'Author', 'thim-core' ),
					'type' => 'text',
				),
				array(
					'id'   => $prefix . 'quote_author_url',
					'name' => __( 'Author URL', 'thim-core' ),
					'type' => 'url',
				),
			),
		);

		return apply_filters( 'thim_metabox_quote', $metabox_quote );
	}

	/**
	 * Metabox post format: Chat
	 *
	 * @since 0.1.0
	 */
	private function metabox_chat() {
		$prefix = TP::$prefix;

		$metabox_chat = array(
			'id'         => $prefix . 'metabox_chat',
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => esc_html__( 'Post format: Chat', 'thim-core' ),
			'post_types' => array( 'post' ),
			'show'       => array(
				'post_format' => array( 'chat' ),
			),
			'fields'     => array(
				array(
					'id'     => $prefix . 'group_chat',
					'type'   => 'group',
					'clone'  => true,
					'fields' => array(
						array(
							'id'   => $prefix . 'chat_name',
							'name' => __( 'Name', 'thim-core' ),
							'type' => 'text',
						),
						array(
							'id'   => $prefix . 'chat_content',
							'name' => __( 'Content', 'thim-core' ),
							'type' => 'textarea',
						),
					),
				),
			),
		);

		return apply_filters( 'thim_metabox_chat', $metabox_chat );
	}

	/**
	 * Add filter metabox for post formats.
	 *
	 * @param array $meta_boxes
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function metabox( $meta_boxes ) {
		$meta_boxes[] = $this->metabox_audio();
		$meta_boxes[] = $this->metabox_video();
		$meta_boxes[] = $this->metabox_image();
		$meta_boxes[] = $this->metabox_gallery();
		$meta_boxes[] = $this->metabox_link();
		$meta_boxes[] = $this->metabox_quote();
		$meta_boxes[] = $this->metabox_chat();

		return $meta_boxes;
	}
}
