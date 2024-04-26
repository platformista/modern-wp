<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-content-inner">
		<?php
		/* Video, Audio, Image, Gallery, Default will get thumb */
		do_action( 'thim_entry_top', 'full' );
		?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php thim_entry_meta(); ?>
		</header>
		<!-- .entry-header -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before'      => '<div class="pagination loop-pagination">',
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
			?>
		</div>
		<div class="entry-tag-share">
			<div class="row">
				<div class="col-sm-6">
					<?php
					if ( get_the_tag_list() ) {
						echo get_the_tag_list( '<p class="post-tag"><span>' . esc_html__( "Tag:", 'eduma' ) . '</span>', ', ', '</p>' );
					}
					?>
				</div>
				<div class="col-sm-6">
					<?php do_action( 'thim_social_share' ); ?>
				</div>
			</div>
		</div>

		<?php
		/**
		 * thim_post_footer hook
		 *
		 * @hooked thim_about_author - 5
		 * @hooked thim_post_nav - 15
		 * @hooked thim_single_post_related - 25
		 */

		do_action( 'thim_post_footer' );
		?>

	</div>
</article>
