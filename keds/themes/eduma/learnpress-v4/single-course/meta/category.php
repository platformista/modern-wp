<?php
/**
 * Template for displaying categories of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/categories.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$term_list = get_the_term_list( get_the_ID(), 'course_category', '', ', ', '' );
if ( $term_list ) :
    ?>
    <div class="course-categories">
        <label><?php esc_html_e( 'Categories', 'eduma' ); ?></label>

        <div class="value">
            <?php

            printf(
                '<span class="cat-links">%s</span>',
                $term_list
            );
            ?>
        </div>
    </div>
    <?php
endif;