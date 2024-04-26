<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package thim
 */
$theme_options_data = get_theme_mods();
$show_booking     = !empty( $theme_options_data['thim_event_disable_book_event'] ) ? false : true;
if ( !is_active_sidebar( 'sidebar_events' ) && !$show_booking ) {
	return;
}

$sticky_sidebar     = !empty( $theme_options_data['thim_sticky_sidebar'] ) ? ' sticky-sidebar' : '';
$cls_sidebar = '';
if ( get_theme_mod( 'thim_header_style', 'header_v1' ) == 'header_v4' ) {
    $cls_sidebar = ' sidebar_' . get_theme_mod( 'thim_header_style' );
}
?>

<div id="sidebar" class="widget-area col-sm-3 sidebar-events<?php echo esc_attr( $sticky_sidebar ); ?><?php echo $cls_sidebar;?>" role="complementary">
	<?php
	if($show_booking && is_singular('tp_event')) {
		echo '<div class="widget_book-event">';
		if ( defined( 'WPEMS_VER' ) ) {
			if ( version_compare( WPEMS_VER, '2.0', '>=' ) ) {
				wpems_get_template( 'loop/booking-form.php', array( 'event_id' => get_the_ID() ) );
			}else{
				if ( version_compare( get_option( 'event_auth_version' ), '1.0.4', '>=' ) ) {
					tpe_auth_addon_get_template( 'form-book-event.php', array( 'event_id' => get_the_ID() ) );
				} else {
					WPEMS_Authentication()->loader->load_module( '\WPEMS_Auth\Events\Event' )->book_event_template();
				}
			}
		} else if ( defined( 'TP_EVENT_VER' ) ) {
			if ( version_compare( TP_EVENT_VER, '2.0', '>=' ) ) {
				tp_event_get_template( 'loop/booking-form.php', array( 'event_id' => get_the_ID() ) );
			}else{
				if ( version_compare( get_option( 'event_auth_version' ), '1.0.4', '>=' ) ) {
					tpe_auth_addon_get_template( 'form-book-event.php', array( 'event_id' => get_the_ID() ) );
				} else {
					TP_Event_Authentication()->loader->load_module( '\TP_Event_Auth\Events\Event' )->book_event_template();
				}
			}
		}else{
			return;
		}
		echo '</div>';
	}
	?>
	<?php if ( !dynamic_sidebar( 'sidebar_events' ) ) :
		dynamic_sidebar( 'sidebar_events' );
	endif; // end sidebar widget area ?>
</div><!-- #secondary -->
