<?php
/**
 * Template: Levels
 * Version: 3.0.1
 *
 * See documentation for how to override the PMPro templates.
 * @link    https://www.paidmembershipspro.com/documentation/templates/
 *
 * @version 3.0.1
 *
 * @author  Paid Memberships Pro
 */
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;
$pmpro_levels = pmpro_sort_levels_by_order( pmpro_getAllLevels( false, true ) );
$pmpro_levels = apply_filters( 'pmpro_levels_array', $pmpro_levels );
$has_group    = false;

if ( function_exists( 'pmpro_get_level_groups_in_order' ) ) {
	$has_group = true;
}


if ( $pmpro_msg ) {
	?>
	<div class="pmpro_message <?php echo $pmpro_msgt ?>"><?php echo $pmpro_msg ?></div>
	<?php
}
if ( $has_group ) {
	$level_groups = pmpro_get_level_groups_in_order();
} else {
	$level_groups             = array( 'all' );
	$levels_to_show_for_group = $pmpro_levels;
}
foreach ( $level_groups as $level_group ) {

	if ( $has_group ) {
		$levels_in_group = pmpro_get_level_ids_for_group( $level_group->id );

		// The pmpro_levels_array filter is sometimes used to hide levels from the levels page.
		// Let's make sure that every level in the group should still be displayed.
		$levels_to_show_for_group = array();
		foreach ( $pmpro_levels as $level ) {
			if ( in_array( $level->id, $levels_in_group ) ) {
				$levels_to_show_for_group[] = $level;
			}
		}

		if ( empty( $levels_to_show_for_group ) ) {
			continue;
		}

		if ( count( $level_groups ) > 1 ) {
			?>
			<h2><?php echo esc_html( $level_group->name ); ?></h2>
			<?php
			if ( ! empty( $level_group->allow_multiple_selections ) ) {
				?>
				<p><?php esc_html_e( 'You may select multiple levels from this group.', 'paid-memberships-pro' ); ?></p>
				<?php
			} else {
				?>
				<p><?php esc_html_e( 'You may select only one level from this group.', 'paid-memberships-pro' ); ?></p>
				<?php
			}
		}
	}
	?>
	<div class="lp_pmpro_courses_by_level row">
		<?php
		$count = 0;
		foreach ( $levels_to_show_for_group as $level ) {
			$user_level = pmpro_getSpecificMembershipLevelForUser( $current_user->ID, $level->id );
			$has_level  = ! empty( $user_level );
			?>
			<div class="col-sm-4 col-xs-6 thim-level-wrap">
				<div class="level-wrap">
					<div class="lp_pmpro_level">
						<header>
							<h2 class="lp_pmpro_title_level">
								<?php echo esc_html( $level->name ); ?>
							</h2>
							<div class="lp_pmpro_price_level">
								<div class="price-wrap">
									<?php if ( pmpro_isLevelFree( $level ) ): ?>
										<?php

										echo '<p class="price">' . esc_html( 'Free', 'eduma' ) . '</p>';

										if ( $level->expiration_number ) {
											echo '<p class="expired">' . sprintf( __( "expires after %d %s.", "eduma" ), $level->expiration_number, pmpro_translate_billing_period( $level->expiration_period, $level->expiration_number ) ) . '</p>';
										}

										?>

									<?php else: ?>
										<?php
										$cost_text       = pmpro_getLevelCost( $level, true, true );
										$expiration_text = pmpro_getLevelExpiration( $level );

										echo ent2ncr( $cost_text );

										if ( $level->expiration_number ) {
											echo '<p class="expired">' . sprintf( __( "expires after %d %s.", "eduma" ), $level->expiration_number, pmpro_translate_billing_period( $level->expiration_period, $level->expiration_number ) ) . '</p>';
										}

										?>
									<?php endif; ?>
								</div>
							</div>
						</header>

						<main>
							<?php echo ent2ncr( $level->description ); ?>
						</main>

						<footer>
							<div class="button">
								<?php if ( ! $has_level ) { ?>
									<a class="pmpro_btn pmpro_btn-select"
									   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ) ?>"><?php _e( 'GET IT NOW', 'eduma' ); ?></a>
								<?php } else { ?>
									<?php
									if ( pmpro_isLevelExpiringSoon( $user_level ) && $level->allow_signups ) {
										?>
										<a class="pmpro_btn pmpro_btn-select"
										   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ) ?>"><?php _e( 'Renew', 'eduma' ); ?></a>
										<?php
									} else {
										?>
										<a class="pmpro_btn disabled"
										   href="<?php echo pmpro_url( 'account' ) ?>"><?php _e( 'Your Level', 'eduma' ); ?></a>
										<?php
									}
									?>

								<?php } ?>
							</div>
						</footer>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
?>
<nav id="nav-below" class="navigation" role="navigation">
	<div class="nav-previous alignleft">
		<?php if ( ! empty( $current_user->membership_level->ID ) ) { ?>
			<a href="<?php echo pmpro_url( "account" ) ?>"><?php esc_html_e( '&larr; Return to Your Account', 'eduma' ); ?></a>
		<?php } else { ?>
			<a href="<?php echo esc_url( home_url() ); ?>"><?php _e( '&larr; Return to Home', 'eduma' ); ?></a>
		<?php } ?>
	</div>
</nav>
