<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package thim
 */
?><!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ?? '' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="thim-body">
<?php if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} ?>

<?php do_action( 'thim_before_body' ); ?>
<!-- Mobile Menu-->

    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-inner">
            <div class="icon-wrapper">
			<div class="icon-menu-back" data-close=""><?php esc_html_e('Back','eduma');?><span></span></div>
                <div class="menu-mobile-effect navbar-toggle close-icon" data-effect="mobile-effect">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </div>
            </div>
            <nav class="mobile-menu-container mobile-effect">
                <?php get_template_part( 'inc/header/menu-mobile' ); ?>
            </nav>
        </div>
    </div>

<div id="wrapper-container" class="wrapper-container">
    <div class="content-pusher">
        <header id="masthead" class="site-header affix-top<?php thim_header_class(); ?>">
			<?php
			//Toolbar
			if ( get_theme_mod( 'thim_toolbar_show', true ) ) {
				get_template_part( 'inc/header/toolbar' );
			}

			//Header style
			if ( get_theme_mod( 'thim_header_style', 'header_v1' ) ) {
				get_template_part( 'inc/header/' . get_theme_mod( 'thim_header_style', 'header_v1' ) );
			}
			?>
        </header>

        <div id="main-content">
