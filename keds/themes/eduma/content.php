<?php
$theme_options_data = get_theme_mods();

$classes   = array();
$classes[] = 'col-sm-12';


?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="content-inner">
		<?php do_action( 'thim_entry_top', 'full' ); ?>
		<div class="entry-content">
			<?php
			if ( has_post_format( 'link' ) && thim_meta( 'thim_link_url' ) && thim_meta( 'thim_link_text' ) ) {
				$url   = thim_meta( 'thim_link_url' );
				$title = thim_meta( 'thim_link_text' );
			} else {
				$url   = get_permalink();
				$title = get_the_title();
			}
			?>

			<header class="entry-header">
				<?php
				if ( ! isset( $theme_options_data['thim_show_date'] ) || $theme_options_data['thim_show_date'] == 1 ) {
					?>
					<div class="date-meta">
						<?php
						if ( ! empty( $theme_options_data['thim_blog_display_year'] ) ) {
							echo get_the_date( 'd' ) . '<i>' . get_the_date( 'M, Y' ) . '</i>';
						} else {
							echo get_the_date( "d\<\i\>\ F\<\/\i\>\ " );
						}
						?>
					</div>
					<?php
				}
				?>
				<div class="entry-contain">
					<?php echo sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">%s</a></h2>', esc_url( $url ), esc_attr( $title ) ); ?>
					<?php thim_entry_meta(); ?>
				</div>
			</header>
			<div class="entry-summary">
				<?php
				the_excerpt();
				?>
			</div>
			<div class="readmore">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'eduma' ); ?></a>
			</div>
		</div>
	</div>
</article><!-- #post-## -->
