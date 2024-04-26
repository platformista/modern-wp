<?php
/**
 * @package thimpress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-format-standard' ); ?>>
    <div class="row entry-content-portfolio">
        <div class="entry-content-left col-sm-12">
			<?php
			if ( get_post_meta( get_the_ID(), 'project_video_embed', true ) ) {
				echo '<iframe title="YouTube video player" class="youtube-video" allowfullscreen type="text/html" width="100%" height="500" src="https://www.youtube.com/embed/' . get_post_meta( get_the_ID(), 'project_video_embed', true ) . '" frameborder="0"></iframe>';
			} elseif ( has_post_thumbnail( get_the_ID() ) ) {
				echo "<div class='single-img'>" . get_the_post_thumbnail( get_the_ID(), 'full' ) . '</div>';
			} else {
				// do nothing
			}
			?>
            <div class="bd-content-portfolio">
				<?php the_content(); ?>
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
                        <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'project_link', true ) ); ?>"
                           target="_blank" class="sc-btn"><?php echo esc_html__( 'Link project:', 'eduma' ); ?></a>
                    </div>
				<?php } ?>
            </div>

			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eduma' ),
				'after'  => '</div>',
			) );
			?>

        </div>

    </div>
	<?php thim_related_portfolio( get_the_ID() ); ?>

</article><!-- #post-## -->
