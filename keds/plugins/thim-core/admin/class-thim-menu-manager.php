<?php

/**
 * Class Thim_Mega_Menu
 *
 * @package Thim_Core
 * @since   0.3.1
 */
class Thim_Menu_Manager extends Thim_Singleton {
	/**
	 * Update menu content from post content by post id.
	 *
	 * @since 0.9.0
	 *
	 * @param $args
	 */
	public static function update_menu_content( $args ) {
		if ( ! is_array( $args ) || count( $args ) < 2 ) {
			return;
		}

		$post_ID = $args[0];
		$menu_id = $args[1];

		$post = get_post( $post_ID );

		if ( get_class( $post ) != 'WP_Post' ) {
			return;
		}

		$builder      = Thim_Layout_Builder::detect_page_builder( $post_ID );
		$post_content = Thim_Layout_Builder::get_content( $post_ID );

		update_post_meta( $menu_id, 'tc_mega_menu_content', $post_content );
		update_post_meta( $menu_id, 'tc_mega_menu_page_builder', $builder );
	}

	/**
	 * Get mega menu content layout builder.
	 *
	 * @since 0.9.0
	 *
	 * @param $menu_id
	 *
	 * @return mixed
	 */
	public static function get_megamenu_content( $menu_id ) {
		$content = get_post_meta( $menu_id, 'tc_mega_menu_content', true );
		$builder = get_post_meta( $menu_id, 'tc_mega_menu_page_builder', true );

		$render_content = Thim_Layout_Builder::render_content( $content, $builder, 'tc-megamenu-' . $menu_id );
		$render_content = apply_filters( 'tc_mega_menu_content_layout_builder', $render_content, $menu_id );

		return $render_content;
	}

	/**
	 * Get link video how to use custom layout.
	 *
	 * @since 0.9.1
	 *
	 * @return mixed
	 */
	public static function get_link_iframe_how_to_use() {
		return apply_filters( 'thim_core_megamenu_video_how_to_use', 'https://www.youtube.com/embed/3Pis9jBder8' );
	}

	/**
	 * Thim_Mega_Menu constructor.
	 *
	 * @since 0.9.0
	 */
	protected function __construct() {
		$this->init_hooks();
	}

	/**
	 * Notification mega menu support WP 4.7 or higher.
	 *
	 * @since 0.9.1
	 * @since 1.3.1
	 */
	public function notification_support() {
		global $wp_version;

		if ( version_compare( $wp_version, '4.7' ) < 0 ) {
			Thim_Notification::add_notification( array(
				'id'          => 'mega-menu-support-47+',
				'type'        => 'warning',
				'content'     => sprintf( __( 'Feature Mega Menu only support for WordPress 4.7 or higher. Please <a href="%s">update</a> your site to latest version to use Mega Menu.', 'thim-core' ), network_admin_url( 'update-core.php' ) ),
				'dismissible' => false,
				'global'      => true,
			) );
		}
	}

	/**
	 * Get link page builder for menu.
	 *
	 * @since 0.9.0
	 *
	 * @return string
	 */
	public static function get_base_link_page_builder() {
		return admin_url( '?tc-mega-menu-go-to-layout-builder=1&menu_id=' );
	}

	/**
	 * Init hooks.
	 *
	 * @since 0.9.0
	 */
	private function init_hooks() {
		add_action( 'admin_footer', array( $this, 'register_modals_area' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9999 );
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'extra_filed_menu_edit' ) );
		add_filter( 'thim_walker_nav_menu_edit_start_el', array( $this, 'add_fields_menu' ), 10, 1 );
		add_action( 'wp_update_nav_menu', array( $this, 'update_nav_menu' ) );
		add_filter( 'manage_nav-menus_columns', array( $this, 'add_screen_option' ), 9999 );
		add_action( 'thim_mega_menu_modals_area', array( $this, 'modal_choose_icon' ) );
		add_action( 'thim_mega_menu_modals_area', array( $this, 'modal_layout_builder' ) );
		add_filter( 'thim_mega_menu_package_icons', array( $this, 'add_package_font_fa' ) );
		add_filter( 'thim_mega_menu_package_icons', array( $this, 'add_package_font_dashicons' ) );
		add_action( 'admin_init', array( $this, 'handle_go_to_builder' ) );

 			add_filter( 'wp_nav_menu_args', array( $this, 'modify_nav_menu_args' ), 9999 );

 		add_action( 'admin_init', array( $this, 'notification_support' ) );
	}

	/**
	 * Filter args nav menu.
	 *
	 * @since 0.9.0
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function modify_nav_menu_args( $args ) {
		$args['walker'] = new Thim_Walker_Mega_Menu();

		return $args;
	}

	/**
	 * Handler request go to layout builder.
	 *
	 * @since 0.9.0
	 */
	public function handle_go_to_builder() {
		$detect = isset( $_GET['tc-mega-menu-go-to-layout-builder'] ) ? true : false;
		if ( ! $detect ) {
			return;
		}

		$menu_id = isset( $_GET['menu_id'] ) ? $_GET['menu_id'] : false;
		if ( ! $menu_id ) {
			return;
		}

		$this->go_to_layout_builder( $menu_id );
		exit();
	}

	/**
	 * Go to layout builder.
	 *
	 * @since 0.9.0
	 *
	 * @param $menu_id
	 */
	private function go_to_layout_builder( $menu_id ) {
		$post_content = get_post_meta( $menu_id, 'tc_mega_menu_content', true );
		$builder      = get_post_meta( $menu_id, 'tc_mega_menu_page_builder', true );
		if ( $builder=='default' ) {
			$builder = 'vc';
			update_post_meta( $menu_id, 'tc_mega_menu_page_builder', 'vc' );
		}

		$page_layout_builder = Thim_Layout_Builder::get_link_panel_page_builder( $post_content, $builder, array( __CLASS__, 'update_menu_content' ), $menu_id );

		thim_core_redirect( $page_layout_builder );
	}

	/**
	 * Add font awesome.
	 *
	 * @since 0.9.0
	 *
	 * @param $packages
	 *
	 * @return array
	 */
	public function add_package_font_fa( $packages ) {
		$fa = array(
			'key'   => 'fa',
			'name'  => __( 'Font Awesome' ),
			'fonts' => $this->get_all_fa(),
		);

		$packages[] = $fa;

		return $packages;
	}

	/**
	 * Add font awesome.
	 *
	 * @since 0.9.0
	 *
	 * @param $packages
	 *
	 * @return array
	 */
	public function add_package_font_dashicons( $packages ) {
		$fa = array(
			'key'   => 'dashicons',
			'name'  => __( 'Dashicons' ),
			'fonts' => $this->get_all_font_dashicons(),
		);

		$packages[] = $fa;

		return $packages;
	}

	/**
	 * Render modal.
	 *
	 * @since 0.9.0
	 *
	 * @param $args
	 *
	 * @return bool
	 */
	public function render_modal( $args = array() ) {
		$dir_path = 'mega-menu/';

		$args = wp_parse_args( $args, array(
			'template' => '',
		) );

		$args['template'] = $dir_path . $args['template'];

		return Thim_Modal::render_modal( $args );
	}

	/**
	 * Add modal choose icon.
	 *
	 * @since 0.9.0
	 *
	 */
	public function modal_choose_icon() {
		self::render_modal( array(
			'id'       => 'tc-megamenu-choose-icons',
			'template' => 'choose-icon.php',
		) );
	}

	/**
	 * Add modal layout builder.
	 *
	 * @since 0.9.0
	 */
	public function modal_layout_builder() {
		self::render_modal( array(
			'id'       => 'tc-mega-menu-layout-builder',
			'template' => 'layout-builder.php',
		) );
	}

	/**
	 * Register modals area.
	 *
	 * @since 0.9.0
	 */
	public function register_modals_area() {
		global $pagenow;
		if ( $pagenow != 'nav-menus.php' ) {
			return;
		}

		do_action( 'thim_mega_menu_modals_area' );
	}

	/**
	 * Add screen option.
	 *
	 * @since 0.9.0
	 *
	 * @param $arr
	 *
	 * @return mixed
	 */
	public function add_screen_option( $arr ) {
		$arr['thim-icons']     = __( 'Thim Custom Icons', 'thim-core' );
		$arr['thim-sub-align'] = __( 'Thim Sub-menu Align', 'thim-core' );
		$arr['thim-mega-menu'] = __( 'Thim Custom Layout', 'thim-core' );

		return $arr;
	}

	/**
	 * Update data mega menu.
	 *
	 * @since 0.9.0
	 *
	 */
	public function update_nav_menu() {
		$items = isset( $_POST['tc-mega-menu'] ) ? $_POST['tc-mega-menu'] : array();

		if ( empty( $items ) ) {
			return;
		}

		foreach ( $items as $menu_id => $values ) {
			update_post_meta( $menu_id, 'tc-mega-menu', $values );
		}
	}

	/**
	 * Get settings mega menu.
	 *
	 * @since 0.9.0
	 *
	 * @param $menu_id
	 *
	 * @return array
	 */
	public function get_settings( $menu_id ) {
		$settings = get_post_meta( $menu_id, 'tc-mega-menu', true );

		return wp_parse_args( $settings, array(
			'enable'            => false,
			'icon'              => '',
			'layout'            => 'default',
			'layout_hide_title' => false,
			'align'             => 'left',
		) );
	}

	/**
	 * Get setting mega menu.
	 *
	 * @since 0.9.0
	 *
	 * @param $menu_id
	 * @param $key
	 *
	 * @return null
	 */
	public function get_setting( $menu_id, $key ) {
		$settings = $this->get_settings( $menu_id );

		if ( ! isset( $settings[ $key ] ) ) {
			return null;
		}

		return $settings[ $key ];
	}

	/**
	 * Get class walker menu edit.
	 *
	 * @since 0.9.0
	 *
	 * @return string
	 */
	public function extra_filed_menu_edit() {
		return 'Thim_Walker_Menu_Edit';
	}

	/**
	 * Add extra filed menu item.
	 *
	 * @since 0.9.0
	 *
	 * @param $item
	 *
	 * @return string
	 */
	public function add_fields_menu( $item ) {
		$menu_id  = $item->ID;
		$settings = $this->get_settings( $menu_id );

		return Thim_Template_Helper::template( 'mega-menu/extra-fields.php', array(
			'$menu_id'  => $menu_id,
			'$settings' => $settings,
		), false );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.9.0
	 *
	 * @param $page
	 */
	public function enqueue_scripts( $page ) {
		if ( $page != 'nav-menus.php' ) {
			return;
		}

		Thim_Modal::enqueue_modal();

		wp_dequeue_style( 'sb_instagram_font_awesome' );
		wp_enqueue_style( 'thim-menu-manager', THIM_CORE_URI . '/admin/assets/css/menu-manager.css', array( 'thim-font-awesome' ), THIM_CORE_VERSION );
		wp_enqueue_script( 'thim-menu-manager', THIM_CORE_URI . '/admin/assets/js/menu-manager.js', array( 'jquery', 'backbone' ), THIM_CORE_VERSION );

		wp_localize_script( 'thim-menu-manager', 'thim_menu_manager', array(
			'confirm'  => __( 'Are you really want to remove menu item?', 'thim-core' ),
			'packages' => $this->get_package_fonts(),
		) );
	}

	/**
	 * Get all package icons for mega menu.
	 *
	 * @since 0.9.0
	 *
	 * @return mixed
	 */
	public function get_package_fonts() {
		$package = array();

		return apply_filters( 'thim_mega_menu_package_icons', $package );
	}

	/**
	 * Get all font mega menu.
	 *
	 * @since 0.9.0
	 */
	public function get_all_fa() {
		$list = array(
			'fa-500px',
			'fa-address-book',
			'fa-address-book-o',
			'fa-address-card',
			'fa-address-card-o',
			'fa-adjust',
			'fa-adn',
			'fa-align-center',
			'fa-align-justify',
			'fa-align-left',
			'fa-align-right',
			'fa-amazon',
			'fa-ambulance',
			'fa-american-sign-language-interpreting',
			'fa-anchor',
			'fa-android',
			'fa-angellist',
			'fa-angle-double-down',
			'fa-angle-double-left',
			'fa-angle-double-right',
			'fa-angle-double-up',
			'fa-angle-down',
			'fa-angle-left',
			'fa-angle-right',
			'fa-angle-up',
			'fa-apple',
			'fa-archive',
			'fa-area-chart',
			'fa-arrow-circle-down',
			'fa-arrow-circle-left',
			'fa-arrow-circle-o-down',
			'fa-arrow-circle-o-left',
			'fa-arrow-circle-o-right',
			'fa-arrow-circle-o-up',
			'fa-arrow-circle-right',
			'fa-arrow-circle-up',
			'fa-arrow-down',
			'fa-arrow-left',
			'fa-arrow-right',
			'fa-arrow-up',
			'fa-arrows',
			'fa-arrows-alt',
			'fa-arrows-h',
			'fa-arrows-v',
			'fa-asl-interpreting',
			'fa-assistive-listening-systems',
			'fa-asterisk',
			'fa-at',
			'fa-audio-description',
			'fa-automobile',
			'fa-backward',
			'fa-balance-scale',
			'fa-ban',
			'fa-bandcamp',
			'fa-bank',
			'fa-bar-chart',
			'fa-bar-chart-o',
			'fa-barcode',
			'fa-bars',
			'fa-bath',
			'fa-bathtub',
			'fa-battery',
			'fa-battery-0',
			'fa-battery-1',
			'fa-battery-2',
			'fa-battery-3',
			'fa-battery-4',
			'fa-battery-empty',
			'fa-battery-full',
			'fa-battery-half',
			'fa-battery-quarter',
			'fa-battery-three-quarters',
			'fa-bed',
			'fa-beer',
			'fa-behance',
			'fa-behance-square',
			'fa-bell',
			'fa-bell-o',
			'fa-bell-slash',
			'fa-bell-slash-o',
			'fa-bicycle',
			'fa-binoculars',
			'fa-birthday-cake',
			'fa-bitbucket',
			'fa-bitbucket-square',
			'fa-bitcoin',
			'fa-black-tie',
			'fa-blind',
			'fa-bluetooth',
			'fa-bluetooth-b',
			'fa-bold',
			'fa-bolt',
			'fa-bomb',
			'fa-book',
			'fa-bookmark',
			'fa-bookmark-o',
			'fa-braille',
			'fa-briefcase',
			'fa-btc',
			'fa-bug',
			'fa-building',
			'fa-building-o',
			'fa-bullhorn',
			'fa-bullseye',
			'fa-bus',
			'fa-buysellads',
			'fa-cab',
			'fa-calculator',
			'fa-calendar',
			'fa-calendar-check-o',
			'fa-calendar-minus-o',
			'fa-calendar-o',
			'fa-calendar-plus-o',
			'fa-calendar-times-o',
			'fa-camera',
			'fa-camera-retro',
			'fa-car',
			'fa-caret-down',
			'fa-caret-left',
			'fa-caret-right',
			'fa-caret-square-o-down',
			'fa-caret-square-o-left',
			'fa-caret-square-o-right',
			'fa-caret-square-o-up',
			'fa-caret-up',
			'fa-cart-arrow-down',
			'fa-cart-plus',
			'fa-cc',
			'fa-cc-amex',
			'fa-cc-diners-club',
			'fa-cc-discover',
			'fa-cc-jcb',
			'fa-cc-mastercard',
			'fa-cc-paypal',
			'fa-cc-stripe',
			'fa-cc-visa',
			'fa-certificate',
			'fa-chain',
			'fa-chain-broken',
			'fa-check',
			'fa-check-circle',
			'fa-check-circle-o',
			'fa-check-square',
			'fa-check-square-o',
			'fa-chevron-circle-down',
			'fa-chevron-circle-left',
			'fa-chevron-circle-right',
			'fa-chevron-circle-up',
			'fa-chevron-down',
			'fa-chevron-left',
			'fa-chevron-right',
			'fa-chevron-up',
			'fa-child',
			'fa-chrome',
			'fa-circle',
			'fa-circle-o',
			'fa-circle-o-notch',
			'fa-circle-thin',
			'fa-clipboard',
			'fa-clock-o',
			'fa-clone',
			'fa-close',
			'fa-cloud',
			'fa-cloud-download',
			'fa-cloud-upload',
			'fa-cny',
			'fa-code',
			'fa-code-fork',
			'fa-codepen',
			'fa-codiepie',
			'fa-coffee',
			'fa-cog',
			'fa-cogs',
			'fa-columns',
			'fa-comment',
			'fa-comment-o',
			'fa-commenting',
			'fa-commenting-o',
			'fa-comments',
			'fa-comments-o',
			'fa-compass',
			'fa-compress',
			'fa-connectdevelop',
			'fa-contao',
			'fa-copy',
			'fa-copyright',
			'fa-creative-commons',
			'fa-credit-card',
			'fa-credit-card-alt',
			'fa-crop',
			'fa-crosshairs',
			'fa-css3',
			'fa-cube',
			'fa-cubes',
			'fa-cut',
			'fa-cutlery',
			'fa-dashboard',
			'fa-dashcube',
			'fa-database',
			'fa-deaf',
			'fa-deafness',
			'fa-dedent',
			'fa-delicious',
			'fa-desktop',
			'fa-deviantart',
			'fa-diamond',
			'fa-digg',
			'fa-dollar',
			'fa-dot-circle-o',
			'fa-download',
			'fa-dribbble',
			'fa-drivers-license',
			'fa-drivers-license-o',
			'fa-dropbox',
			'fa-drupal',
			'fa-edge',
			'fa-edit',
			'fa-eercast',
			'fa-eject',
			'fa-ellipsis-h',
			'fa-ellipsis-v',
			'fa-empire',
			'fa-envelope',
			'fa-envelope-o',
			'fa-envelope-open',
			'fa-envelope-open-o',
			'fa-envelope-square',
			'fa-envira',
			'fa-eraser',
			'fa-etsy',
			'fa-eur',
			'fa-euro',
			'fa-exchange',
			'fa-exclamation',
			'fa-exclamation-circle',
			'fa-exclamation-triangle',
			'fa-expand',
			'fa-expeditedssl',
			'fa-external-link',
			'fa-external-link-square',
			'fa-eye',
			'fa-eye-slash',
			'fa-eyedropper',
			'fa-fa',
			'fa-facebook',
			'fa-facebook-f',
			'fa-facebook-official',
			'fa-facebook-square',
			'fa-fast-backward',
			'fa-fast-forward',
			'fa-fax',
			'fa-feed',
			'fa-female',
			'fa-fighter-jet',
			'fa-file',
			'fa-file-archive-o',
			'fa-file-audio-o',
			'fa-file-code-o',
			'fa-file-excel-o',
			'fa-file-image-o',
			'fa-file-movie-o',
			'fa-file-o',
			'fa-file-pdf-o',
			'fa-file-photo-o',
			'fa-file-picture-o',
			'fa-file-powerpoint-o',
			'fa-file-sound-o',
			'fa-file-text',
			'fa-file-text-o',
			'fa-file-video-o',
			'fa-file-word-o',
			'fa-file-zip-o',
			'fa-files-o',
			'fa-film',
			'fa-filter',
			'fa-fire',
			'fa-fire-extinguisher',
			'fa-firefox',
			'fa-first-order',
			'fa-flag',
			'fa-flag-checkered',
			'fa-flag-o',
			'fa-flash',
			'fa-flask',
			'fa-flickr',
			'fa-floppy-o',
			'fa-folder',
			'fa-folder-o',
			'fa-folder-open',
			'fa-folder-open-o',
			'fa-font',
			'fa-font-awesome',
			'fa-fonticons',
			'fa-fort-awesome',
			'fa-forumbee',
			'fa-forward',
			'fa-foursquare',
			'fa-free-code-camp',
			'fa-frown-o',
			'fa-futbol-o',
			'fa-gamepad',
			'fa-gavel',
			'fa-gbp',
			'fa-ge',
			'fa-gear',
			'fa-gears',
			'fa-genderless',
			'fa-get-pocket',
			'fa-gg',
			'fa-gg-circle',
			'fa-gift',
			'fa-git',
			'fa-git-square',
			'fa-github',
			'fa-github-alt',
			'fa-github-square',
			'fa-gitlab',
			'fa-gittip',
			'fa-glass',
			'fa-glide',
			'fa-glide-g',
			'fa-globe',
			'fa-google',
			'fa-google-plus',
			'fa-google-plus-circle',
			'fa-google-plus-official',
			'fa-google-plus-square',
			'fa-google-wallet',
			'fa-graduation-cap',
			'fa-gratipay',
			'fa-grav',
			'fa-group',
			'fa-h-square',
			'fa-hacker-news',
			'fa-hand-grab-o',
			'fa-hand-lizard-o',
			'fa-hand-o-down',
			'fa-hand-o-left',
			'fa-hand-o-right',
			'fa-hand-o-up',
			'fa-hand-paper-o',
			'fa-hand-peace-o',
			'fa-hand-pointer-o',
			'fa-hand-rock-o',
			'fa-hand-scissors-o',
			'fa-hand-spock-o',
			'fa-hand-stop-o',
			'fa-handshake-o',
			'fa-hard-of-hearing',
			'fa-hashtag',
			'fa-hdd-o',
			'fa-header',
			'fa-headphones',
			'fa-heart',
			'fa-heart-o',
			'fa-heartbeat',
			'fa-history',
			'fa-home',
			'fa-hospital-o',
			'fa-hotel',
			'fa-hourglass',
			'fa-hourglass-1',
			'fa-hourglass-2',
			'fa-hourglass-3',
			'fa-hourglass-end',
			'fa-hourglass-half',
			'fa-hourglass-o',
			'fa-hourglass-start',
			'fa-houzz',
			'fa-html5',
			'fa-i-cursor',
			'fa-id-badge',
			'fa-id-card',
			'fa-id-card-o',
			'fa-ils',
			'fa-image',
			'fa-imdb',
			'fa-inbox',
			'fa-indent',
			'fa-industry',
			'fa-info',
			'fa-info-circle',
			'fa-inr',
			'fa-instagram',
			'fa-institution',
			'fa-internet-explorer',
			'fa-intersex',
			'fa-ioxhost',
			'fa-italic',
			'fa-joomla',
			'fa-jpy',
			'fa-jsfiddle',
			'fa-key',
			'fa-keyboard-o',
			'fa-krw',
			'fa-language',
			'fa-laptop',
			'fa-lastfm',
			'fa-lastfm-square',
			'fa-leaf',
			'fa-leanpub',
			'fa-legal',
			'fa-lemon-o',
			'fa-level-down',
			'fa-level-up',
			'fa-life-bouy',
			'fa-life-buoy',
			'fa-life-ring',
			'fa-life-saver',
			'fa-lightbulb-o',
			'fa-line-chart',
			'fa-link',
			'fa-linkedin',
			'fa-linkedin-square',
			'fa-linode',
			'fa-linux',
			'fa-list',
			'fa-list-alt',
			'fa-list-ol',
			'fa-list-ul',
			'fa-location-arrow',
			'fa-lock',
			'fa-long-arrow-down',
			'fa-long-arrow-left',
			'fa-long-arrow-right',
			'fa-long-arrow-up',
			'fa-low-vision',
			'fa-magic',
			'fa-magnet',
			'fa-mail-forward',
			'fa-mail-reply',
			'fa-mail-reply-all',
			'fa-male',
			'fa-map',
			'fa-map-marker',
			'fa-map-o',
			'fa-map-pin',
			'fa-map-signs',
			'fa-mars',
			'fa-mars-double',
			'fa-mars-stroke',
			'fa-mars-stroke-h',
			'fa-mars-stroke-v',
			'fa-maxcdn',
			'fa-meanpath',
			'fa-medium',
			'fa-medkit',
			'fa-meetup',
			'fa-meh-o',
			'fa-mercury',
			'fa-microchip',
			'fa-microphone',
			'fa-microphone-slash',
			'fa-minus',
			'fa-minus-circle',
			'fa-minus-square',
			'fa-minus-square-o',
			'fa-mixcloud',
			'fa-mobile',
			'fa-mobile-phone',
			'fa-modx',
			'fa-money',
			'fa-moon-o',
			'fa-mortar-board',
			'fa-motorcycle',
			'fa-mouse-pointer',
			'fa-music',
			'fa-navicon',
			'fa-neuter',
			'fa-newspaper-o',
			'fa-object-group',
			'fa-object-ungroup',
			'fa-odnoklassniki',
			'fa-odnoklassniki-square',
			'fa-opencart',
			'fa-openid',
			'fa-opera',
			'fa-optin-monster',
			'fa-outdent',
			'fa-pagelines',
			'fa-paint-brush',
			'fa-paper-plane',
			'fa-paper-plane-o',
			'fa-paperclip',
			'fa-paragraph',
			'fa-paste',
			'fa-pause',
			'fa-pause-circle',
			'fa-pause-circle-o',
			'fa-paw',
			'fa-paypal',
			'fa-pencil',
			'fa-pencil-square',
			'fa-pencil-square-o',
			'fa-percent',
			'fa-phone',
			'fa-phone-square',
			'fa-photo',
			'fa-picture-o',
			'fa-pie-chart',
			'fa-pied-piper',
			'fa-pied-piper-alt',
			'fa-pied-piper-pp',
			'fa-pinterest',
			'fa-pinterest-p',
			'fa-pinterest-square',
			'fa-plane',
			'fa-play',
			'fa-play-circle',
			'fa-play-circle-o',
			'fa-plug',
			'fa-plus',
			'fa-plus-circle',
			'fa-plus-square',
			'fa-plus-square-o',
			'fa-podcast',
			'fa-power-off',
			'fa-print',
			'fa-product-hunt',
			'fa-puzzle-piece',
			'fa-qq',
			'fa-qrcode',
			'fa-question',
			'fa-question-circle',
			'fa-question-circle-o',
			'fa-quora',
			'fa-quote-left',
			'fa-quote-right',
			'fa-ra',
			'fa-random',
			'fa-ravelry',
			'fa-rebel',
			'fa-recycle',
			'fa-reddit',
			'fa-reddit-alien',
			'fa-reddit-square',
			'fa-refresh',
			'fa-registered',
			'fa-remove',
			'fa-renren',
			'fa-reorder',
			'fa-repeat',
			'fa-reply',
			'fa-reply-all',
			'fa-resistance',
			'fa-retweet',
			'fa-rmb',
			'fa-road',
			'fa-rocket',
			'fa-rotate-left',
			'fa-rotate-right',
			'fa-rouble',
			'fa-rss',
			'fa-rss-square',
			'fa-rub',
			'fa-ruble',
			'fa-rupee',
			'fa-s15',
			'fa-safari',
			'fa-save',
			'fa-scissors',
			'fa-scribd',
			'fa-search',
			'fa-search-minus',
			'fa-search-plus',
			'fa-sellsy',
			'fa-send',
			'fa-send-o',
			'fa-server',
			'fa-share',
			'fa-share-alt',
			'fa-share-alt-square',
			'fa-share-square',
			'fa-share-square-o',
			'fa-shekel',
			'fa-sheqel',
			'fa-shield',
			'fa-ship',
			'fa-shirtsinbulk',
			'fa-shopping-bag',
			'fa-shopping-basket',
			'fa-shopping-cart',
			'fa-shower',
			'fa-sign-in',
			'fa-sign-language',
			'fa-sign-out',
			'fa-signal',
			'fa-signing',
			'fa-simplybuilt',
			'fa-sitemap',
			'fa-skyatlas',
			'fa-skype',
			'fa-slack',
			'fa-sliders',
			'fa-slideshare',
			'fa-smile-o',
			'fa-snapchat',
			'fa-snapchat-ghost',
			'fa-snapchat-square',
			'fa-snowflake-o',
			'fa-soccer-ball-o',
			'fa-sort',
			'fa-sort-alpha-asc',
			'fa-sort-alpha-desc',
			'fa-sort-amount-asc',
			'fa-sort-amount-desc',
			'fa-sort-asc',
			'fa-sort-desc',
			'fa-sort-down',
			'fa-sort-numeric-asc',
			'fa-sort-numeric-desc',
			'fa-sort-up',
			'fa-soundcloud',
			'fa-space-shuttle',
			'fa-spinner',
			'fa-spoon',
			'fa-spotify',
			'fa-square',
			'fa-square-o',
			'fa-stack-exchange',
			'fa-stack-overflow',
			'fa-star',
			'fa-star-half',
			'fa-star-half-empty',
			'fa-star-half-full',
			'fa-star-half-o',
			'fa-star-o',
			'fa-steam',
			'fa-steam-square',
			'fa-step-backward',
			'fa-step-forward',
			'fa-stethoscope',
			'fa-sticky-note',
			'fa-sticky-note-o',
			'fa-stop',
			'fa-stop-circle',
			'fa-stop-circle-o',
			'fa-street-view',
			'fa-strikethrough',
			'fa-stumbleupon',
			'fa-stumbleupon-circle',
			'fa-subscript',
			'fa-subway',
			'fa-suitcase',
			'fa-sun-o',
			'fa-superpowers',
			'fa-superscript',
			'fa-support',
			'fa-table',
			'fa-tablet',
			'fa-tachometer',
			'fa-tag',
			'fa-tags',
			'fa-tasks',
			'fa-taxi',
			'fa-telegram',
			'fa-television',
			'fa-tencent-weibo',
			'fa-terminal',
			'fa-text-height',
			'fa-text-width',
			'fa-th',
			'fa-th-large',
			'fa-th-list',
			'fa-themeisle',
			'fa-thermometer',
			'fa-thermometer-0',
			'fa-thermometer-1',
			'fa-thermometer-2',
			'fa-thermometer-3',
			'fa-thermometer-4',
			'fa-thermometer-empty',
			'fa-thermometer-full',
			'fa-thermometer-half',
			'fa-thermometer-quarter',
			'fa-thermometer-three-quarters',
			'fa-thumb-tack',
			'fa-thumbs-down',
			'fa-thumbs-o-down',
			'fa-thumbs-o-up',
			'fa-thumbs-up',
			'fa-ticket',
			'fa-times',
			'fa-times-circle',
			'fa-times-circle-o',
			'fa-times-rectangle',
			'fa-times-rectangle-o',
			'fa-tint',
			'fa-toggle-down',
			'fa-toggle-left',
			'fa-toggle-off',
			'fa-toggle-on',
			'fa-toggle-right',
			'fa-toggle-up',
			'fa-trademark',
			'fa-train',
			'fa-transgender',
			'fa-transgender-alt',
			'fa-trash',
			'fa-trash-o',
			'fa-tree',
			'fa-trello',
			'fa-tripadvisor',
			'fa-trophy',
			'fa-truck',
			'fa-try',
			'fa-tty',
			'fa-tumblr',
			'fa-tumblr-square',
			'fa-turkish-lira',
			'fa-tv',
			'fa-twitch',
			'fa-twitter',
			'fa-twitter-square',
			'fa-umbrella',
			'fa-underline',
			'fa-undo',
			'fa-universal-access',
			'fa-university',
			'fa-unlink',
			'fa-unlock',
			'fa-unlock-alt',
			'fa-unsorted',
			'fa-upload',
			'fa-usb',
			'fa-usd',
			'fa-user',
			'fa-user-circle',
			'fa-user-circle-o',
			'fa-user-md',
			'fa-user-o',
			'fa-user-plus',
			'fa-user-secret',
			'fa-user-times',
			'fa-users',
			'fa-vcard',
			'fa-vcard-o',
			'fa-venus',
			'fa-venus-double',
			'fa-venus-mars',
			'fa-viacoin',
			'fa-viadeo',
			'fa-viadeo-square',
			'fa-video-camera',
			'fa-vimeo',
			'fa-vimeo-square',
			'fa-vine',
			'fa-vk',
			'fa-volume-control-phone',
			'fa-volume-down',
			'fa-volume-off',
			'fa-volume-up',
			'fa-warning',
			'fa-wechat',
			'fa-weibo',
			'fa-weixin',
			'fa-whatsapp',
			'fa-wheelchair',
			'fa-wheelchair-alt',
			'fa-wifi',
			'fa-wikipedia-w',
			'fa-window-close',
			'fa-window-close-o',
			'fa-window-maximize',
			'fa-window-minimize',
			'fa-window-restore',
			'fa-windows',
			'fa-won',
			'fa-wordpress',
			'fa-wpbeginner',
			'fa-wpexplorer',
			'fa-wpforms',
			'fa-wrench',
			'fa-xing',
			'fa-xing-square',
			'fa-y-combinator',
			'fa-y-combinator-square',
			'fa-yahoo',
			'fa-yc',
			'fa-yc-square',
			'fa-yelp',
			'fa-yen',
			'fa-yoast',
			'fa-youtube',
			'fa-youtube-play',
			'fa-youtube-square',
		);

		return apply_filters( 'thim_mega_menu_list_fontawesome', $list );
	}

	/**
	 * Get list fonts dash icons.
	 *
	 * @since 0.9.0
	 *
	 * @return array
	 */
	public function get_all_font_dashicons() {
		$list = array(
			'dashicons-menu',
			'dashicons-admin-site',
			'dashicons-dashboard',
			'dashicons-admin-post',
			'dashicons-admin-media',
			'dashicons-admin-links',
			'dashicons-admin-page',
			'dashicons-admin-comments',
			'dashicons-admin-appearance',
			'dashicons-admin-plugins',
			'dashicons-admin-users',
			'dashicons-admin-tools',
			'dashicons-admin-settings',
			'dashicons-admin-network',
			'dashicons-admin-home',
			'dashicons-admin-generic',
			'dashicons-admin-collapse',
			'dashicons-filter',
			'dashicons-admin-customizer',
			'dashicons-admin-multisite',
			'dashicons-welcome-write-blog',
			'dashicons-welcome-add-page',
			'dashicons-welcome-view-site',
			'dashicons-welcome-widgets-menus',
			'dashicons-welcome-comments',
			'dashicons-welcome-learn-more',
			'dashicons-format-aside',
			'dashicons-format-image',
			'dashicons-format-gallery',
			'dashicons-format-video',
			'dashicons-format-status',
			'dashicons-format-quote',
			'dashicons-format-chat',
			'dashicons-format-audio',
			'dashicons-camera',
			'dashicons-images-alt',
			'dashicons-images-alt2',
			'dashicons-video-alt',
			'dashicons-video-alt2',
			'dashicons-video-alt3',
			'dashicons-media-archive',
			'dashicons-media-audio',
			'dashicons-media-code',
			'dashicons-media-default',
			'dashicons-media-document',
			'dashicons-media-interactive',
			'dashicons-media-spreadsheet',
			'dashicons-media-text',
			'dashicons-media-video',
			'dashicons-playlist-audio',
			'dashicons-playlist-video',
			'dashicons-controls-play',
			'dashicons-controls-pause',
			'dashicons-controls-forward',
			'dashicons-controls-skipforward',
			'dashicons-controls-back',
			'dashicons-controls-skipback',
			'dashicons-controls-repeat',
			'dashicons-controls-volumeon',
			'dashicons-controls-volumeoff',
			'dashicons-image-crop',
			'dashicons-image-rotate',
			'dashicons-image-rotate-left',
			'dashicons-image-rotate-right',
			'dashicons-image-flip-vertical',
			'dashicons-image-flip-horizontal',
			'dashicons-image-filter',
			'dashicons-undo',
			'dashicons-redo',
			'dashicons-editor-bold',
			'dashicons-editor-italic',
			'dashicons-editor-ul',
			'dashicons-editor-ol',
			'dashicons-editor-quote',
			'dashicons-editor-alignleft',
			'dashicons-editor-aligncenter',
			'dashicons-editor-alignright',
			'dashicons-editor-insertmore',
			'dashicons-editor-spellcheck',
			'dashicons-editor-expand',
			'dashicons-editor-contract',
			'dashicons-editor-kitchensink',
			'dashicons-editor-underline',
			'dashicons-editor-justify',
			'dashicons-editor-textcolor',
			'dashicons-editor-paste-word',
			'dashicons-editor-paste-text',
			'dashicons-editor-removeformatting',
			'dashicons-editor-video',
			'dashicons-editor-customchar',
			'dashicons-editor-outdent',
			'dashicons-editor-indent',
			'dashicons-editor-help',
			'dashicons-editor-strikethrough',
			'dashicons-editor-unlink',
			'dashicons-editor-rtl',
			'dashicons-editor-break',
			'dashicons-editor-code',
			'dashicons-editor-paragraph',
			'dashicons-editor-table',
			'dashicons-align-left',
			'dashicons-align-right',
			'dashicons-align-center',
			'dashicons-align-none',
			'dashicons-lock',
			'dashicons-unlock',
			'dashicons-calendar',
			'dashicons-calendar-alt',
			'dashicons-visibility',
			'dashicons-hidden',
			'dashicons-post-status',
			'dashicons-edit',
			'dashicons-trash',
			'dashicons-sticky',
			'dashicons-external',
			'dashicons-arrow-up',
			'dashicons-arrow-down',
			'dashicons-arrow-right',
			'dashicons-arrow-left',
			'dashicons-arrow-up-alt',
			'dashicons-arrow-down-alt',
			'dashicons-arrow-right-alt',
			'dashicons-arrow-left-alt',
			'dashicons-arrow-up-alt2',
			'dashicons-arrow-down-alt2',
			'dashicons-arrow-right-alt2',
			'dashicons-arrow-left-alt2',
			'dashicons-sort',
			'dashicons-leftright',
			'dashicons-randomize',
			'dashicons-list-view',
			'dashicons-exerpt-view',
			'dashicons-grid-view',
			'dashicons-share',
			'dashicons-share-alt',
			'dashicons-share-alt2',
			'dashicons-twitter',
			'dashicons-rss',
			'dashicons-email',
			'dashicons-email-alt',
			'dashicons-facebook',
			'dashicons-facebook-alt',
			'dashicons-googleplus',
			'dashicons-networking',
			'dashicons-hammer',
			'dashicons-art',
			'dashicons-migrate',
			'dashicons-performance',
			'dashicons-universal-access',
			'dashicons-universal-access-alt',
			'dashicons-tickets',
			'dashicons-nametag',
			'dashicons-clipboard',
			'dashicons-heart',
			'dashicons-megaphone',
			'dashicons-schedule',
			'dashicons-wordpress',
			'dashicons-wordpress-alt',
			'dashicons-pressthis',
			'dashicons-update',
			'dashicons-screenoptions',
			'dashicons-info',
			'dashicons-cart',
			'dashicons-feedback',
			'dashicons-cloud',
			'dashicons-translation',
			'dashicons-tag',
			'dashicons-category',
			'dashicons-archive',
			'dashicons-tagcloud',
			'dashicons-text',
			'dashicons-yes',
			'dashicons-no',
			'dashicons-no-alt',
			'dashicons-plus',
			'dashicons-plus-alt',
			'dashicons-minus',
			'dashicons-dismiss',
			'dashicons-marker',
			'dashicons-star-filled',
			'dashicons-star-half',
			'dashicons-star-empty',
			'dashicons-flag',
			'dashicons-warning',
			'dashicons-location',
			'dashicons-location-alt',
			'dashicons-vault',
			'dashicons-shield',
			'dashicons-shield-alt',
			'dashicons-sos',
			'dashicons-search',
			'dashicons-slides',
			'dashicons-analytics',
			'dashicons-chart-pie',
			'dashicons-chart-bar',
			'dashicons-chart-line',
			'dashicons-chart-area',
			'dashicons-groups',
			'dashicons-businessman',
			'dashicons-id',
			'dashicons-id-alt',
			'dashicons-products',
			'dashicons-awards',
			'dashicons-forms',
			'dashicons-testimonial',
			'dashicons-portfolio',
			'dashicons-book',
			'dashicons-book-alt',
			'dashicons-download',
			'dashicons-upload',
			'dashicons-backup',
			'dashicons-clock',
			'dashicons-lightbulb',
			'dashicons-microphone',
			'dashicons-desktop',
			'dashicons-tablet',
			'dashicons-smartphone',
			'dashicons-phone',
			'dashicons-index-card',
			'dashicons-carrot',
			'dashicons-building',
			'dashicons-store',
			'dashicons-album',
			'dashicons-palmtree',
			'dashicons-tickets-alt',
			'dashicons-money',
			'dashicons-smiley',
			'dashicons-thumbs-up',
			'dashicons-thumbs-down',
			'dashicons-layout',
		);

		return apply_filters( 'thim_mega_menu_list_font_dashicons', $list );
	}
}
