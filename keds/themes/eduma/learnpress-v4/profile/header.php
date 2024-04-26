<?php
/**
 * Template for displaying profile header.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

$profile = LP_Profile::instance();
$user    = $profile->get_user();

if ( ! isset( $user ) ) {
	return;
}

$bio = $user->get_description();
?>
<!-- <div class="lp-profile-right"> -->
 
	<?php if ( $bio ) : ?>
		<div class="lp-profile-user-bio">
			<?php echo wpautop( $bio ); ?>
		</div>

	<?php endif; ?>
<!-- </div> -->
