<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package thim
 */
if ( ! is_active_sidebar( 'sidebar_shop' ) ) {
	return;
}
$theme_options_data = get_theme_mods();
$sticky_sidebar     = !empty( $theme_options_data['thim_sticky_sidebar'] ) ? ' sticky-sidebar' : '';
$cls_sidebar = '';
if ( get_theme_mod( 'thim_header_style', 'header_v1' ) == 'header_v4' ) {
    $cls_sidebar = ' sidebar_' . get_theme_mod( 'thim_header_style' );
}
?>

<div id="sidebar" class="widget-area col-sm-3<?php echo esc_attr( $sticky_sidebar ); ?><?php echo $cls_sidebar;?>" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar_shop' ) ) :
		dynamic_sidebar( 'sidebar_shop' );
	endif; // end sidebar widget area ?>
</div><!-- #secondary-2 -->
