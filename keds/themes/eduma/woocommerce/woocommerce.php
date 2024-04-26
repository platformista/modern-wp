<?php

/**
 * init class.
 */
class Thim_WC_Init {
	/**
	 * @var Thim_WC_Init
	 */
	protected static $_instance;

	/**
	 * WC_Init
	 */
	public function __construct() {
		// Wrap checkout form elements for styling.
		add_action( 'woocommerce_checkout_before_order_review_heading', array( $this, 'before_order_review' ), 1 );
		add_action( 'woocommerce_checkout_after_order_review', array( $this, 'after_order_review' ), 90 );

		// Remove each style one by one
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'woo_dequeue_styles' ) );

		/*****************quick view*****************/
		//remove_action( 'woocommerce_single_product_summary_quick', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_title', 5 );
		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_rating', 15 );
		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_add_to_cart', 20 );
		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_excerpt', 30 );

		//remove_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_meta', 40 );
		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_meta', 7 );

		add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_sharing', 50 );

		//overwrite content product.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		// add_action( 'woocommerce_after_shop_loop_item_title_rating', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );

		// add_filter( 'loop_shop_columns', '__return_false' );


		// remove woocommerce_breadcrumb
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		// add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ) );

		/* Share Product */
		add_action( 'woocommerce_share', 'thim_social_share' );
		add_action( 'wp_ajax_jck_quickview', array( $this, 'jck_quickview' ) );
		add_action( 'wp_ajax_nopriv_jck_quickview', array( $this, 'jck_quickview' ) );
		/**
		 * Custom WooCommerce breadcrumbs
		 *
		 * @return array
		 */

		add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'woocommerce_breadcrumbs' ) );

		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ), 20 );

		add_filter( 'woocommerce_upsell_display_args', array( $this, 'upsell_products_column' ), 20 );
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sell_products_column' ), 20 );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_success_ajax' ) );
		// Override WooCommerce Widgets
		add_action( 'widgets_init', array( $this, 'override_woocommerce_widgets' ), 15 );
		add_filter( 'woocommerce_account_menu_items', array( $this, 'woocommerce_account_menu_items' ) );
		//remove cross-sells
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
		//add plus minus to add to cart
		//add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'woo_add_text_quantity_before_add_to_cart' ) );
		add_action( 'woocommerce_before_quantity_input_field', array( $this, 'ts_quantity_minus_sign' ) );
		add_action( 'woocommerce_after_quantity_input_field', array( $this, 'ts_quantity_plus_sign' ) );
		/**
		 * Shop layout grid/list
		 */
		$shop_layout = get_theme_mod( 'thim_woo_cate_display_layout', 'grid' );
		if ( 'grid' == $shop_layout ) {
			add_action( 'woocommerce_before_shop_loop', array( $this, 'woocommerce_product_filter' ), 15 );
			add_action( 'woocommerce_before_shop_loop', array( $this, 'woo_add_div_sec' ), 60 );
		}

		if ( thim_customizer_extral_class( 'archive-product' ) === ' hidden' ) {
			add_action( 'init', array( $this, 'woocommerce_remove_action' ), 15 );
		}
		// re_update column default
		if ( get_option( 'woocommerce_catalog_columns' ) == '' ) {
			update_option( 'woocommerce_catalog_columns', get_theme_mod( 'thim_woo_product_column', 3 ) );
		}
		/**
		 * hook plugin woo boster tooltip
		 */
		add_filter( 'wcbt_product_thumbnails_size',function (){
			return array(138,136);
		});
		add_filter( 'wcbt/filter/breadcrumb/enable', '__return_false' );
		// add_action( 'wcbt/layout/wishlist/container/before','thim_wapper_page_title',99);
		// add_action( 'wcbt/layout/compare/container/before','thim_wapper_page_title',99);
	}
	function woo_add_div_sec() {
		echo '</div>';
	}
	function woocommerce_remove_action() {
		remove_action( 'woocommerce_before_shop_loop', array( $this, 'woocommerce_product_filter' ), 15 );
		remove_action( 'woocommerce_before_shop_loop', array( $this, 'woo_add_div_sec' ), 60 );
	}
	/**
	 * Wrap checkout order review with a `col2-set` div.
	 */
	public static function before_order_review() {
		echo '<div class="col2-set"><div class="inner-col-set">';
	}

	/**
	 * Close the div wrapper.
	 */
	public static function after_order_review() {
		echo '</div></div>';
	}

	public function woo_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-smallscreen'] );   // Remove the smallscreen optimisation

		return $enqueue_styles;
	}

	public function loop_shop_per_page() {
		$product_per_page = get_theme_mod( 'thim_woo_product_per_page', false );
		parse_str( $_SERVER['QUERY_STRING'], $params );
		if ( ! empty( $product_per_page ) ) {
			$per_page = $product_per_page;
		} else {
			$per_page = 12;
		}
		$pc = ! empty( $params['product_count'] ) ? $params['product_count'] : $per_page;

		return $pc;
	}

	/** The Quickview Ajax Output **/
	public function jck_quickview() {
		global $post, $product;
		$prod_id = $_POST['product'];
		$post    = get_post( $prod_id );
		$product = wc_get_product( $prod_id );
		// Get category permalink
		ob_start();

		wc_get_template_part( 'content', 'single-product-lightbox' );

		$output = ob_get_contents();
		ob_end_clean();
		echo ent2ncr( $output );
		die();
	}

	/* End PRODUCT QUICK VIEW */
	public function woocommerce_breadcrumbs() {
		return array(
			'delimiter'   => '',
			'wrap_before' => '<ul class="breadcrumbs" id="breadcrumbs">',
			'wrap_after'  => '</ul>',
			'before'      => '<li>',
			'after'       => '</li>',
			'home'        => esc_html__( 'Home', 'eduma' ),
		);
	}

	public function related_products_args( $args ) {
		$args['posts_per_page'] = get_theme_mod( 'thim_woo_related_column', 3 );
		$args['columns']        = get_theme_mod( 'thim_woo_related_column', 3 );

		return $args;
	}

	public function upsell_products_column( $args ) {
		$args['columns'] = get_theme_mod( 'thim_woo_related_column', 3 );

		return $args;
	}

	public function cross_sell_products_column( $columns ) {
		$columns = get_theme_mod( 'thim_woo_related_column', 3 );

		return $columns;
	}

	public function add_to_cart_success_ajax( $count_cat_product ) {
		$cart_items                                                              = is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
		$count_cat_product['#header-mini-cart .cart-items-number .items-number'] = '<span class="items-number">' . $cart_items . '</span>';

		return $count_cat_product;
	}

	public function override_woocommerce_widgets() {
		if ( class_exists( 'WC_Widget_Cart' ) ) {
			unregister_widget( 'WC_Widget_Cart' );
			$file_child = get_stylesheet_directory() . '/woocommerce/widgets/class-wc-widget-cart.php';
			if ( file_exists( $file_child ) ) {
				include_once( get_stylesheet_directory() . '/woocommerce/widgets/class-wc-widget-cart.php' );
			} else {
				include_once( 'widgets/class-wc-widget-cart.php' );
			}
			register_widget( 'Thim_Custom_WC_Widget_Cart' );
		}
	}

	public function woocommerce_account_menu_items( $items ) {
		unset( $items['customer-logout'] );

		return $items;
	}

	public function woocommerce_product_filter() {
		echo '<div class="thim-product-switch-wrap switch-layout-container">
					<div class="thim-product-switch-layout switch-layout">
							<a href="javascript:;" class="list switchToGrid switch-active"><i class="fa fa-th"></i></a>
							<a href="javascript:;" class="grid switchToList"><i class="fa fa-list-ul"></i></a>
					</div>';
	}
	function ts_quantity_plus_sign() {
		echo '<div  class="plus" >+</div></div>';
	}

	function ts_quantity_minus_sign() {
		echo '<div class="quantity-add-value"><div  class="minus" >-</div>';
	}

	public static function getInstance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}

Thim_WC_Init::getInstance();
