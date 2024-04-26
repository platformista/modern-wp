<?php
// Get Related Portfolio by Category
if ( get_theme_mod( 'thim_archive_single_related_post', true ) == false ) {
	return;
}

$number_related = apply_filters( 'thim_related_posts', 3 );
$related        = thim_get_related_posts( get_the_ID(), $number_related );
if ( $related->have_posts() ) {
	?>
	<section class="related-archive">
		<h3 class="single-title"><?php esc_html_e( 'You may also like', 'eduma' ); ?></h3>
		<?php
		echo '<div class="archived-posts">';
		echo '<div class="thim-carousel-wrapper" data-visible="3" data-itemtablet="2" data-itemmobile="1" data-pagination="1">';
		while ( $related->have_posts() ) {
			$related->the_post(); ?>
			<div <?php post_class(); ?>>
				<div class="category-posts clear">
					<?php
					if ( has_post_thumbnail() ) {
						$class = '';
						?>
						<a href="<?php echo esc_url( get_the_permalink() ); ?>"  title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo thim_get_feature_image( get_post_thumbnail_id(), 'full', '300', '200' ); ?></a>
					<?php } else {
						$class = 'no-images';
					}
					?>
					<div class="rel-post-text">
						<?php echo sprintf( '<h5 class="title-related '.esc_attr( $class ).'"><a href="%s" rel="bookmark">%s</a></h5>', esc_url( get_the_permalink() ), esc_attr( get_the_title() ) );?>
 						<div class="date">
							<?php echo get_the_date( 'j F, Y' ); ?>
						</div>
					</div>
					<?php if ( $class == 'no-images' ) { ?>
						<div class="des-related">
							<?php the_excerpt(); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
		echo '</div>';
		echo '</div>';
		?>
	</section><!--.related-->
<?php }
