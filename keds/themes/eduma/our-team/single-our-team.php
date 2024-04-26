<?php
/**
 * The Template for displaying all single posts.
 *
 * @package    thimpress
 */

get_header();

/**
 * thim_wrapper_loop_start hook
 *
 * @hooked thim_wrapper_loop_end - 1
 * @hooked thim_wapper_page_title - 5
 * @hooked thim_wrapper_loop_start - 30
 */

do_action( 'thim_wrapper_loop_start' );

?>
	<div class="page-content">
		<?php
		while ( have_posts() ) : the_post();
			$team_id = get_the_ID();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="image">
					<?php echo thim_get_feature_image( get_post_thumbnail_id(), 'full', 200, 200 ); ?>
				</div>
				<div class="content">
					<h3 class="title"><?php echo get_the_title() ?></h3>
					<?php
					$regency      = get_post_meta( $team_id, 'regency', true );
					$link_face    = get_post_meta( $team_id, 'face_url', true );
					$link_twitter = get_post_meta( $team_id, 'twitter_url', true );
					$skype_url    = get_post_meta( $team_id, 'skype_url', true );
					$dribbble_url = get_post_meta( $team_id, 'dribbble_url', true );
					$linkedin_url = get_post_meta( $team_id, 'linkedin_url', true );
					$phone        = get_post_meta( $team_id, 'our_team_phone', true );
					$email        = get_post_meta( $team_id, 'our_team_email', true );
					echo '<div class="regency">' . esc_attr( $regency ) . '</div>';
					?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="extra-info">
					<?php
					if ( ! empty( $email ) ) {
						echo '<p class="email"><i class="fa fa-envelope thim-color"></i><a href="mailto:' . $email . '">' . $email . '</a></p>';
					}
					if ( ! empty( $phone ) ) {
						echo '<p class="email"><i class="fa fa-phone thim-color"></i>' . $phone . '</p>';
					}
					?>

					<ul class="thim-social">
						<?php
						if ( $link_face <> '' ) {
							echo '<li><a href="' . $link_face . '" class="facebook"><i class="fa fa-facebook"></i></a></li>';
						}
						if ( $link_twitter <> '' ) {
							echo '<li><a href="' . $link_twitter . '" class="twitter"><i class="fa fa-x-twitter"></i></a></li>';
						}
						if ( $dribbble_url <> '' ) {
							echo '<li><a href="' . $dribbble_url . '" class="dribbble"><i class="fa fa-dribbble"></i></a></li>';
						}
						if ( $skype_url <> '' ) {
							echo '<li><a href="' . $skype_url . '" class="skyper"><i class="fa fa-skype"></i></a></li>';
						}
						if ( $linkedin_url <> '' ) {
							echo '<li><a href="' . $linkedin_url . '" class="linkedin"><i class="fa fa-linkedin"></i></a></li>';
						}
						?>
					</ul>
				</div>
			</article>
			<div class="clear"></div>
			<?php $related_member = thim_related_our_team( $team_id, - 1 ); ?>
			<?php if ( $related_member->have_posts() ) : ?>
				<div class="thim-other-member wrapper-lists-our-team">
					<h3 class="box-title"><?php esc_html_e( 'Other Members', 'eduma' ); ?></h3>
					<div
						class="thim-carousel-wrapper <?php echo ( $related_member->post_count > 4 ) ? 'has-next-slider' : ''; ?>"
						data-visible="4" data-pagination="1">
						<?php while ( $related_member->have_posts() ) : $related_member->the_post(); ?>
							<div class="our-team-item">
								<div class="our-team-image">
									<?php echo thim_get_feature_image( get_post_thumbnail_id(), 'full', 200, 200 ); ?>
									<?php
									$team_id      = get_the_ID();
									$regency      = get_post_meta( $team_id, 'regency', true );
									$link_face    = get_post_meta( $team_id, 'face_url', true );
									$link_twitter = get_post_meta( $team_id, 'twitter_url', true );
									$skype_url    = get_post_meta( $team_id, 'skype_url', true );
									$dribbble_url = get_post_meta( $team_id, 'dribbble_url', true );
									$linkedin_url = get_post_meta( $team_id, 'linkedin_url', true );
									?>
									<div class="social-team">
										<?php
										if ( $link_face <> '' ) {
											echo '<a href="' . $link_face . '"><i class="fa fa-facebook"></i></a>';
										}
										if ( $link_twitter <> '' ) {
											echo '<a href="' . $link_twitter . '"><i class="fa fa-x-twitter"></i></a>';
										}
										if ( $dribbble_url <> '' ) {
											echo '<a href="' . $dribbble_url . '"><i class="fa fa-dribbble"></i></a>';
										}
										if ( $skype_url <> '' ) {
											echo '<a href="' . $skype_url . '"><i class="fa fa-skype"></i></a>';
										}
										if ( $linkedin_url <> '' ) {
											echo '<a href="' . $linkedin_url . '"><i class="fa fa-linkedin"></i></a>';
										}
										?>
									</div>

								</div>
								<div class="content-team">
									<h4 class="title"><a
											href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
									</h4>
									<?php if ( $regency <> '' ) {
										echo '<div class = "regency">' . $regency . '</div>';
									}
									?>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>

		<?php endwhile; // end of the loop. ?>
	</div>
<?php
/**
 * thim_wrapper_loop_end hook
 *
 * @hooked thim_wrapper_loop_end - 10
 * @hooked thim_wrapper_div_close - 30
 */
do_action( 'thim_wrapper_loop_end' );

get_footer();
