<?php
/**
 * @package thimpress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-format-gallery' ); ?>>
    <div class="portfolio-gallery">
		<?php
		if ( get_post_meta( get_the_ID(), 'project_item_slides', true ) ) {
			$images = get_post_meta( get_the_ID(), 'project_item_slides', false );
			foreach ( $images as $att ) {
				echo '<div class="col-md-4 col-sm-6 columns">';

				// Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
				$src_full = wp_get_attachment_image_src( $att, 'full' );
				$src_full = $src_full[0];

				$src = wp_get_attachment_image_src( $att, 'portfolio_size11' );
				$src = $src[0];

				echo '<a href="' . esc_url( $src_full ) . '" data-rel="prettyPhoto[gallery]">';
				// Show image
				echo "<img src='{$src}' />";
				echo '</a>';
				echo '</div>';
			}
		} elseif ( has_post_thumbnail( get_the_ID() ) ) {
			echo get_the_post_thumbnail( get_the_ID(), 'full' );
		} else {
			// do nothing
		}
		?>
    </div>
    <div class="clear" style="margin-bottom:30px;"></div>
    <div class="row entry-content-portfolio">
        <div class="entry-content-left col-sm-9">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eduma' ),
				'after'  => '</div>',
			) );
			?>
        </div>
        <div class="entry-content-right col-sm-3">
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
                    <a href="<?php echo get_post_meta( get_the_ID(), 'project_link', true ); ?>" target="_blank"
                       class="sc-btn"><?php esc_html_e( 'Link project', 'eduma' ); ?></a>
                </div>
			<?php } ?>

        </div>
    </div>

	<?php thim_related_portfolio( get_the_ID() ); ?>

</article><!-- #post-## -->
		
