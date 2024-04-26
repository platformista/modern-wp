
<?php
/**
 * Template for displaying price of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/price.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}
$unit_price = get_post_meta( get_the_ID(), 'thim_course_unit_price', true );
$class = ( $course->has_sale_price() ) ? ' has-origin' : '';
if ( $course->is_free() ) {
    $class .= ' free-course';
}
?>

<div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
    <?php if ( $price_html = $course->get_price_html() ) { ?>
        <div class="value <?php echo $class; ?>" itemprop="price">
            <?php if ( $course->get_origin_price() != $course->get_price() ) { ?>
                <?php $origin_price_html = $course->get_origin_price_html(); ?>
                <span class="course-origin-price"><?php echo $origin_price_html; ?></span>
            <?php } ?>
            <?php echo $price_html; ?>
        </div>
        <?php if($unit_price): ?><span class="unit-price">/<?php echo esc_html($unit_price); ?> <?php endif; ?>
        <meta itemprop="priceCurrency" content="<?php echo learn_press_get_currency(); ?>" />
    <?php } ?>
</div>
