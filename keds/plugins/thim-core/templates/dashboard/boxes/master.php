<?php
$body_template = 'boxes/' . $args['template'] . '.php';

$locked       = $args['lock'] && ! Thim_Product_Registration::is_active();
$box_id       = isset( $args['id'] ) ? $args['id'] : '';
$class_extend = apply_filters( 'thim_core_dashboard_box_classes', '', $box_id );
$class_extend .= isset( $args['class'] ) ? $args['class'] : '';
?>

<div class="tc-box<?php echo esc_attr( $locked ? ' locked' : '' ); ?> <?php echo esc_attr( $class_extend ); ?>"
	 data-id="<?php echo esc_attr( $args['id'] ); ?>">
	<div class="tc-box-header">
		<?php
		if ( $args['lock'] ) {
			Thim_Dashboard::get_template( 'partials/box-status.php' );
		}
		?>
		<h2 class="box-title"><?php echo esc_html( $args['title'] ); ?></h2>
		<?php if ( $args['id'] == 'appearance' ) {
			echo '<a href="' . wp_customize_url() . '" class="sub_link">' . __( 'Go to Customize', 'thim-core' ) . '</a>';
		}
		if ( $args['id'] == 'changelog' && $args['links'] ) {
 			echo '<a href="' . esc_url($args['links']) . '" class="sub_link">' . __( 'View all Changelog', 'thim-core' ) . '</a>';
		}
		?>
	</div>

	<?php Thim_Dashboard::get_template( $body_template ); ?>
</div>
