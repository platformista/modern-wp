<?php

/**
 * @package   Thim_Core
 * @since     0.9.0
 */

if ( ! class_exists( 'Thim_Walker_Mega_Menu' ) ) :
	/**
	 * Class Thim_Walker_Mega_Menu.
	 *
	 * @since 0.9.0
	 */
	class Thim_Walker_Mega_Menu extends Walker_Nav_Menu {
		public $args_menu = array();
		public $args_mega_menu = array();
		public $item = false;
		public $sub_elements = array();
		public static $is_root = false;
		public static $layout_mega_menu = false;

		/**
		 * Get layout mega menu. Default is 'default'
		 *
		 * @since 0.9.0
		 *
		 * @param int $depth
		 *
		 * @return mixed|string
		 */
		private function get_layout_megamenu( $depth = 0 ) {
			$layout = isset( $this->args_mega_menu['layout'] ) ? $this->args_mega_menu['layout'] : 'default';

			if ( $depth > 0 ) {
				$layout = 'default';
			}

			return $layout;
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth. It is possible to set the
		 * max depth to include all depths, see walk() method.
		 *
		 * This method should not be called directly, use the walk() method instead.
		 *
		 * @since 2.5.0
		 *
		 * @param object $element Data object.
		 * @param array $children_elements List of elements to continue traversing.
		 * @param int $max_depth Max depth to traverse.
		 * @param int $depth Depth of current element.
		 * @param array $args An array of arguments.
		 * @param string $output Passed by reference. Used to append additional content.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}

			self::$is_root = ! $depth;

			$id_field = $this->db_fields['id'];
			$id       = $element->$id_field;

			//display this element
			$this->has_children = ! empty( $children_elements[ $id ] );
			if ( isset( $args[0] ) && is_array( $args[0] ) ) {
				$args[0]['has_children'] = $this->has_children; // Back-compat.
			}

			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( $this, 'start_el' ), $cb_args );

			// descend only when the depth is right and there are childrens for this element
			if ( ( $max_depth == 0 || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

				foreach ( $children_elements[ $id ] as $child ) {
					$this->sub_elements = $children_elements[ $id ];

					if ( ! isset( $newlevel ) ) {
						$newlevel = true;
						//start the child delimiter
						self::$is_root = false;
						$cb_args       = array_merge( array( &$output, $depth ), $args );
						call_user_func_array( array( $this, 'start_lvl' ), $cb_args );
					}
					$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
				}
				unset( $children_elements[ $id ] );
			}

			if ( isset( $newlevel ) && $newlevel ) {
				//end the child delimiter
				$cb_args = array_merge( array( &$output, $depth ), $args );
				call_user_func_array( array( $this, 'end_lvl' ), $cb_args );
			}

			//end this element
			$cb_args = array_merge( array( &$output, $element, $depth ), $args );
			call_user_func_array( array( $this, 'end_el' ), $cb_args );
		}

		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( ! self::$is_root && self::$layout_mega_menu == 'builder' ) {
				return;
			}

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			$indent = str_repeat( $t, $depth );
			$layout = $this->get_layout_megamenu( $depth );
			if ( $layout == 'default' ) {
				$output .= "{$n}{$indent}<ul class=\"sub-menu\">{$n}";

				return;
			}

			$number_columns = 1;
			if ( $this->has_children ) {
				$number_columns = count( $this->sub_elements );
			}

			$output .= "{$n}{$indent}<div class=\"tc-megamenu-wrapper tc-megamenu-holder mega-sub-menu sub-menu tc-columns-{$number_columns}\">{$n}<ul class=\"row\">{$n}";
		}

		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			if ( $depth > 0 && self::$layout_mega_menu == 'builder' ) {
				return;
			}

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			$layout = $this->get_layout_megamenu( $depth );

			if ( $layout == 'default' ) {
				$output .= "$indent</ul><!-- End wrapper ul sub -->{$n}";

				return;
			}

			$output .= "$indent</ul><!-- End row -->{$n}</div><!-- End wrapper megamenu -->{$n}";
		}

		/**
		 * Get classes grid bootstrap (getbootstrap.com)
		 *
		 * @since 0.9.0
		 *
		 * @param $number_column
		 *
		 * @return string
		 */
		private function get_classes_bootstrap( $number_column ) {
			$column_layout = 12;
			if ( $number_column < 12 ) {
				$column_layout = intval( 12 / $number_column );
			}

			$classes = "col-md-$column_layout";
			switch ( $column_layout ) {
				case 6 || 4:
					$classes .= ' col-sm-12';
					break;
				case 3 || 2:
					$classes .= ' col-sm-6 col-xs-12';
					break;
			}

			return $classes;
		}

		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			/**
			 * Set some args for mega menu.
			 */
			$this->args_menu = get_post_meta( $item->ID, 'tc-mega-menu', true );
			if ( $depth == 0 ) {
				$this->args_mega_menu   = $this->args_menu;
				self::$layout_mega_menu = isset( $this->args_menu['layout'] ) ? $this->args_menu['layout'] : 'default';
				$this->item             = $item;
			}

			$layout_builder = '';

			if ( $depth == 0 && self::$layout_mega_menu == 'builder' ) {
				$menu_content   = Thim_Menu_Manager::get_megamenu_content( $item->ID );
				$layout_builder = "<div class='tc-megamenu-wrapper tc-megamenu-holder mega-sub-menu sub-menu'>$menu_content</div>";
			}

			if ( $depth > 0 && self::$layout_mega_menu == 'builder' ) {
				return;
			}

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @since 4.4.0
			 *
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param WP_Post $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			$extra_class = "tc-menu-item tc-menu-depth-$depth";
			/**
			 * Align
			 */
			if ( ! empty( $this->args_menu['align'] ) ) {
				$extra_class .= " tc-menu-align-{$this->args_menu['align']}";
			}

			/**
			 * Layout
			 */
			if ( $depth == 0 ) {
				$menu_layout = ! empty( $this->args_mega_menu['layout'] ) ? $this->args_mega_menu['layout'] : 'default';
				$extra_class .= " tc-menu-layout-$menu_layout";

				if ( $menu_layout == 'column' ) {
					$extra_class .= ! empty( $this->args_mega_menu['layout_hide_title'] ) ? ' tc-menu-column-hide-title' : '';
				}
			}

			/**
			 * Columns
			 */
			if ( $depth == 1 && self::$layout_mega_menu == 'column' ) {
				$number_column   = count( $this->sub_elements );
				$class_bootstrap = $this->get_classes_bootstrap( $number_column );
				$extra_class     .= " $class_bootstrap";
			}

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post $item The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names .= " $extra_class";
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param WP_Post $item The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 * @type string $title Title attribute.
			 * @type string $target Target attribute.
			 * @type string $rel The rel attribute.
			 * @type string $href The href attribute.
			 * }
			 *
			 * @param WP_Post $item The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$class_inner_tag = 'tc-menu-inner';
			/**
			 * Add class title column for tag a
			 */
			if ( self::$layout_mega_menu && $depth == 1 ) {
				$class_inner_tag .= ' tc-megamenu-title';
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @since 4.4.0
			 *
			 * @param string $title The menu item's title.
			 * @param WP_Post $item The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output = isset( $args->before ) ? $args->before : '';

			$tag_name    = empty( $atts['href'] ) ? 'span' : 'a';
			$item_output .= "<$tag_name" . $attributes . ' class="' . $class_inner_tag . '">';

			$item_output .= apply_filters( 'tc_nav_menu_begin_inner_menu', '', $item, $args );

			// Add @tc-icon
			if ( ! empty( $this->args_menu['icon'] ) ) {
				$item_output .= "<span class='tc-icon {$this->args_menu['icon']}'></span>";
			}

			$item_output .= apply_filters( 'tc_nav_menu_before_inner_menu', '', $item, $args );

			$item_output .= isset( $args->link_before ) ? $args->link_before : '';
			$item_output .= $title;
			$item_output .= isset( $args->link_after ) ? $args->link_after : '';

			$item_output .= apply_filters( 'tc_nav_menu_after_inner_menu', '', $item, $args );

			/**
			 * Icon toggle
			 */
			if ( $this->has_children && ! self::$layout_mega_menu ) {
				$item_output .= "<span class='icon-toggle'><i class='fa fa-angle-down'></i></span>";
			}

			$item_output .= apply_filters( 'tc_nav_menu_end_inner_menu', '', $item, $args );

			$item_output .= "</$tag_name>";

			$item_output .= $layout_builder;

			$item_output .= isset( $args->after ) ? $args->after : '';

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param WP_Post $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		public function end_el( &$output, $item, $depth = 0, $args = array() ) {
			if ( ! self::$is_root && self::$layout_mega_menu == 'builder' ) {
				return;
			}

			parent::end_el( $output, $item, $depth, $args );
		}
	}

endif;