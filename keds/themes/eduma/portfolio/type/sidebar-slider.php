<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-format-sidebar-slider' ); ?>>
    <div class='col-md-9 post-formats-wrapper'>
		<?php
		if ( get_post_meta( get_the_ID(), 'portfolio_sliders', true ) ) {
			wp_enqueue_script('flexslider');
			?>
            <div class="flexslider">
                <ul class="slides">
					<?php
					$images = get_post_meta( get_the_ID(), 'portfolio_sliders', false );
					foreach ( $images as $att ) {
						if ( 'v.' == substr( $att, 0, 2 ) ) {
							echo '<li><iframe src="http://player.vimeo.com/video/' . substr( $att, 2 ) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="auto" height="500px" frameborder="0"></iframe></li>';
						} elseif ( 'y.' == substr( $att, 0, 2 ) ) {
							echo '<li><iframe title="YouTube video player" class="youtube-player" type="text/html" width="auto" height="500px" src="https://www.youtube.com/embed/' . substr( $att, 2 ) . '" frameborder="0"></iframe></li>';
						} else {
							// Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
							$src = wp_get_attachment_image_src( $att, 'full' );
							$src = $src[0];
							// Show image
							echo "<li><a href='{$src}' data-rel='prettyPhoto[gallery]'><img src='{$src}' /></a></li>";
						}
					}
					?>
                </ul>
            </div><!-- end of portfolio slider -->
			<?php
		} elseif ( has_post_thumbnail( get_the_ID() ) ) {
			echo get_the_post_thumbnail( get_the_ID(), 'full' );
		}
		?>
    </div>
    <div class="col-md-3 entry-content-portfolio">
        <div class="entry-content-right">
            <section class="portfolio-description">
                <h3><?php the_title();?></h3>
				<?php the_content(); ?>
            </section>
			<?php
			$taxonomy = 'portfolio_category';
			$terms    = get_the_terms( get_the_ID(), $taxonomy ); // Get all terms of a taxonomy
			if ( $terms && ! is_wp_error( $terms ) ) :
				echo '<section class="tags"><i class="fa fa-tags">&nbsp;</i><ul>';
				?>
				<?php foreach ( $terms as $term ) { ?>
                <li>
                    <a href="<?php echo esc_url( get_term_link( $term->slug, $taxonomy ) ); ?>"><?php echo $term->name; ?></a>
                </li>
			<?php } ?>
				<?php
				echo '</ul></section>';
			endif;
			?>

			<?php if ( get_post_meta( get_the_ID(), 'project_link', true ) ) { ?>
                <div class="link-project">
                    <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'project_link', true ) ); ?>" target="_blank"
                       class="sc-btn"><?php esc_html_e( 'Link project', 'eduma' ); ?></a>
                </div>
			<?php } ?>


			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'eduma' ),
				'after'  => '</div>',
			) );
			?>
        </div>
    </div>
	<?php thim_related_portfolio( get_the_ID() ); ?>

</article><!-- #post-## -->
