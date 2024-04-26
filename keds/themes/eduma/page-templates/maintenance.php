<?php
/**
 * Template Name: Maintenance
 *
 **/
?>
<!DOCTYPE html>
<?php $theme_options_data = get_theme_mods(); ?>
<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?><?php if (  is_rtl()  ) {
    echo " dir=\"rtl\"";
} ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
    <?php
    wp_head();
    ?>
</head>
<body <?php body_class(); ?> id="thim-body">
<?php wp_body_open(); ?>
<?php do_action( 'thim_before_body' ); ?>
<div class="maintenance-wrap">
    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('content', 'page'); ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; // end of the loop.  ?>
</div>
<?php wp_footer(); ?>
</body>
</html>