<?php
$classes = array();
if ( is_front_page() || is_home() ) {
	$prefix = 'thim_front_page';
} else {
	$prefix = 'thim_archive';
}
$theme_options_data = get_theme_mods();
$columns            = thim_blog_grid_column();
$show_author        = ! empty( $theme_options_data['thim_show_author'] ) && $theme_options_data['thim_show_author'] == '1';
$show_date          = ! empty( $theme_options_data['thim_show_date'] ) && $theme_options_data['thim_show_date'] == '1';
$show_comment       = ! empty( $theme_options_data['thim_show_comment'] ) && $theme_options_data['thim_show_comment'] == '1';
$classes[]          = 'blog-grid-' . $columns;
switch ( $columns ) {
	case 2:
		$arr_size = array( '570', '300' );
		break;
	case 3:
		$arr_size = array( '370', '220' );
		break;
	default:
		$arr_size = array( '270', '150' );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="content-inner">
		<?php
		do_action( 'thim_entry_top', 'full' ); ?>
		<div class="entry-content">
			<?php
			if ( has_post_format( 'link' ) && thim_meta( 'thim_link_url' ) && thim_meta( 'thim_link_text' ) ) {
				$url   = thim_meta( 'thim_link_url' );
				$title = thim_meta( 'thim_link_text' );
			} else {
				$url   = get_permalink();
				$title = get_the_title();
			}
			if ( get_theme_mod( 'thim_show_author', true ) ) {
				?>
				<div class="author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
					<?php printf( '<span class="vcard author author_name"><a href="%1$s">%2$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) ); ?>
				</div>
				<?php
			}
			?>

			<header class="entry-header">
				<div class="entry-contain">
					<?php echo sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">%s</a></h2>', esc_url( $url ), esc_attr( $title ) ); ?>
					<?php thim_entry_meta(); ?>
				</div>
			</header>
			<div class="entry-grid-meta">
				<?php
				if ( $show_date ) {
					?>
					<div class="date">
						<i class="fa fa-calendar"></i><?php echo get_the_date( get_option( 'date_format' ) ); ?>
					</div>
					<?php
				}
				if ( $show_comment ) {
					$comments = wp_count_comments( get_the_ID() );
					?>
					<div class="comments"><i class="fa fa-comment"></i><?php echo $comments->total_comments; ?> </div>
					<?php
				}
				?>
			</div>
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
