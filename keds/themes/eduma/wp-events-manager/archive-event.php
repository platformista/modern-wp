<?php
/**
 * The Template for displaying all archive products.
 *
 * Override this template by copying it to yourtheme/tp-event/templates/archive-event.php
 *
 * @author        ThimPress
 * @package       tp-event/template
 * @version       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();

/**
 * thim_wrapper_loop_start hook
 *
 * @hooked thim_wrapper_loop_end - 1
 * @hooked thim_wapper_page_title - 5
 * @hooked thim_wrapper_loop_start - 30
 */

do_action( 'thim_wrapper_loop_start' );

$default_tab       = array( 'happening', 'upcoming', 'expired' );
$default_tab_title = array(
	'happening' => esc_html__( 'Happening', 'eduma' ),
	'upcoming'  => esc_html__( 'Upcoming', 'eduma' ),
	'expired'   => esc_html__( 'Expired', 'eduma' )
);
$output_tab        = array();

$customize_order_tab = get_theme_mod( 'thim_event_change_order_tab', array() );

$tab_style = get_theme_mod( 'thim_tab_event_style' ) ? ' ' . get_theme_mod( 'thim_tab_event_style' ) : '';

if ( ! $customize_order_tab ) { // set default value for the first time
	$customize_order_tab = $default_tab;
}

foreach ( $customize_order_tab as $tab_key ) {
	$output_tab[$tab_key] = $default_tab_title[$tab_key];
}
?>

<div class="list-tab-event">
	<ul class="nav nav-tabs<?php echo esc_attr( $tab_style ); ?>">
		<?php
		$first_tab = true;
		foreach ( $output_tab as $k => $v ) {
			if ( $first_tab ) {
				$first_tab = false;
				echo '<li class="active"><a href="#tab-' . ( $k ) . '" data-toggle="tab">' . ( $v ) . '</a></li>';
			} else {
				echo '<li><a href="#tab-' . ( $k ) . '" data-toggle="tab">' . ( $v ) . '</a></li>';
			}
			?>
			<?php
		}
		?>
	</ul>

	<div class="tab-content thim-list-event">

		<?php
		$query_args = array(
			'post_type'           => 'tp_event',
			'posts_per_page'      => - 1,
			'meta_query'          => array(
				array(
					'key'     => 'tp_event_status',
					'value'   => array( 'happening', 'upcoming', 'expired' ),
					'compare' => 'IN',
				),
			),
			'ignore_sticky_posts' => true
		);
		$events     = new WP_Query( $query_args );

		$happening = $expired = $upcoming = '';
		if ( $events->have_posts() ) {
			while ( $events->have_posts() ) {
				$events->the_post();
				$event_status = get_post_meta( get_the_ID(), 'tp_event_status', true );
				ob_start();
				get_template_part( 'wp-events-manager/content', 'event' );
				switch ( $event_status ) {
					case 'happening':
						$happening .= ob_get_contents();
						ob_end_clean();
						break;
					case 'expired':
						$expired .= ob_get_contents();
						ob_end_clean();
						break;
					case 'upcoming':
						$upcoming .= ob_get_contents();
						ob_end_clean();
						break;
				}
			}
		}
		wp_reset_postdata();

		$first_tab_content = true;
		foreach ( $output_tab as $type => $title ) :
			if ( $first_tab_content ) {
				$first_tab_content = false;
				echo '<div role="tabpanel" class="tab-pane fade active in" id="tab-' . $type . '">';
			} else {
				echo '<div role="tabpanel" class="tab-pane fade" id="tab-' . $type . '">';
			}
			if ( ${$type} != '' ) {
				echo ent2ncr( ${$type} );
			}
			echo '</div>';
		endforeach;
		?>
	</div>
</div>

<?php

/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );

get_footer(); ?>
