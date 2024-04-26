<?php
/**
 * Template for displaying thumbnail of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/thumbnail.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post;
$course      = learn_press_get_course();
$media_intro = get_post_meta( $post->ID, 'thim_course_media_intro', true );
 ?>

<div class="course-thumbnail">
	<?php
    if ( !empty( $media_intro ) ) {
        ?>
        <div class="media-intro">
            <?php
			if ( wp_oembed_get( $media_intro ) ) {
				echo '<div class="responsive-iframe">' . wp_oembed_get( $media_intro ) . '</div>';
			} else {
				echo str_replace(
					array( "<iframe", "</iframe>" ), array(
					'<div class="responsive-iframe"><iframe',
					"</iframe></div>"
				), do_shortcode( $media_intro )
				);
			}
          ?>
        </div>
        <?php
    }  elseif ( has_post_thumbnail() ) {
        $image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
        $image_caption = get_post( get_post_thumbnail_id() ) ? esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ) : '""';
        $image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
        $image         = get_the_post_thumbnail( $post->ID, 'full', array(
            'title' => $image_title,
            'alt'   => $image_title
        ) );

        echo apply_filters(
            'learn_press_single_course_image_html',
            sprintf( '%s', $image ),
            $post->ID
        );
    }
	?>
</div>
