<?php
global $post;

$limit         = $instance['limit'] ? $instance['limit'] : 4;
$columns       = $instance['columns'] ? $instance['columns'] : 3;
$feature_items = $instance['feature_items'] ? $instance['feature_items'] : 2;

$condition = array(
    'post_type'           => 'lp_collection',
    'posts_per_page'      => $limit,
    'ignore_sticky_posts' => true,
);

$items_html = '';

$the_query = new WP_Query( $condition );

if ( $the_query->have_posts() ) :

    while ( $the_query->have_posts() ) : $the_query->the_post();

        ob_start();
        ?>
        <div class="item">
            <div class="thumbnail">
                <?php
                echo '<a href="' . esc_url( get_the_permalink() ) . '" class="feature-image">';
                echo thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', 300, 210, get_the_title() );
                echo '</a>';
                ?>
            </div>
            <div class="content">
                <h3><a class="title" href="<?php echo esc_url( get_the_permalink() ); ?>"> <?php echo get_the_title(); ?></a></h3>
                <?php echo thim_excerpt(10);?>
            </div>
        </div>
        <?php
        $items_html .= ob_get_contents();
        ob_end_clean();

    endwhile;

endif;

wp_reset_postdata();

?>
<div class="thim-courses-collection">
    <div class="thim-carousel-wrapper thim-collection-carousel" data-visible="<?php echo esc_attr( $columns ); ?>"
         data-pagination="0" data-navigation="1" data-autoplay="0">
    <?php echo ent2ncr( $items_html ); ?>
    </div>
</div>
