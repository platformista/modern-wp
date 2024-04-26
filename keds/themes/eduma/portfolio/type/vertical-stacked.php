<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-format-vertical-stacked' ); ?>>
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
        <div class="clear" style="margin-bottom:30px;"></div>
		<?php
		$array = array(
			'fadeIn'      => 'fadeIn',
			'fadeInUp'    => 'fadeInUp',
			'fadeInDown'  => 'fadeInDown',
			'fadeInLeft'  => 'fadeInLeft',
			'fadeInRight' => 'fadeInRight',
		);


		if ( get_post_meta( get_the_ID(), 'project_item_slides', true ) ) {
			$images = get_post_meta( get_the_ID(), 'project_item_slides', false );
			foreach ( $images as $att ) {
				$animate = array_rand( $array, 1 );
				echo '<div class="be-animate" data-animation="' . $animate . '"><p>';
				// Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
				$src = wp_get_attachment_image_src( $att, 'full' );
				$src = $src[0];
				// Show image
				echo "<img src='{$src}' />";
				echo '</p></div>';
			}
		} elseif ( has_post_thumbnail( get_the_ID() ) ) {
			$animate = array_rand( $array, 1 );
			echo '<div class="be-animate" data-animation="' . $animate . '"><p>';
			echo get_the_post_thumbnail( get_the_ID(), 'full' );
			echo '</p></div>';
		} else {
			// do nothing
		}
		?>
    </div>
	<?php thim_related_portfolio( get_the_ID() ); ?>

</article><!-- #post-## -->
