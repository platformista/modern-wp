<?php
get_header();
?>
    <div class="home-content home-page container" role="main">
		<?php
		while ( have_posts() ) :
            the_post();
			the_content();
		endwhile;
		?>
    </div><!-- #main-content -->

<?php
get_footer();
