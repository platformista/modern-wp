<?php
/**
 * Template Name: Blank Page
 * Template Post Type: page, ae_global_templates
 **/
?><!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="thim-body">
<?php wp_body_open(); ?>

	<div id="main-home-content" class="blank-content blank-page container" role="main">
		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>
	</div><!-- #main-content -->

<?php wp_footer(); ?>
</body>
</html>
