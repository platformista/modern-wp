<?php

/**
 * Class Thim_Walker_Menu_Edit.
 *
 * @since 0.9.0
 */
class Thim_Walker_Menu_Edit extends Walker_Nav_Menu_Edit {
	/**
	 * @since 0.9.0
	 *
	 * @param string $output
	 * @param object $item
	 * @param int $depth
	 * @param array $args
	 * @param int $id
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args, $id );

		$output .= preg_replace(
			'/(?=<fieldset[^>]+class="[^"]*field-move)/',
			apply_filters( 'thim_walker_nav_menu_edit_start_el', $item, $depth, $args, $id ),
			$item_output
		);
	}
}
