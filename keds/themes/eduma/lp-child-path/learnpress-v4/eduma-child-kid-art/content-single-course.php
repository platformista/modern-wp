<?php
/**
 * The template for display the content of single course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}

//$is_required = $course->is_required_enroll();
//$user        = LearnPress::instance()->user;
//$is_enrolled = $user->has( 'enrolled-course', $course->id );

do_action( 'learn_press_before_single_course' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'learn-press' ); ?> itemscope itemtype="http://schema.org/CreativeWork">

	<?php do_action( 'learn_press_before_single_course_summary' ); ?>

	<?php
	the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
	?>

	<div class="course-meta course-meta-single">
		<?php learn_press_course_instructor(); ?>
		<?php learn_press_course_categories(); ?>
	</div>

	<div class="course-payment thim-enroll-kid-art">
		<?php
		$price      = get_post_meta( get_the_ID(), 'thim_course_price', true );
		$unit_price = get_post_meta( get_the_ID(), 'thim_course_unit_price', true );
		?>
		<div class="course-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<div class="value " itemprop="price" content="<?php echo esc_attr( $price ); ?>">
				<?php echo esc_html( $price ); ?>
			</div>
			<?php echo ( ! empty( $unit_price ) ) ? '<div class="unit-price">/' . $unit_price . '</div>' : ''; ?>
		</div>
		<a class="thim-enroll-course-button" href="#"><?php esc_html_e( 'Register', 'eduma-child-kid-art' ); ?></a>
	</div>

	<?php learn_press_get_template( 'single-course/thumbnail.php' ); ?>

	<div class="course-summary">
		<?php learn_press_get_template( 'single-course/content-landing.php' ); ?>
	</div>

	<?php do_action( 'learn_press_after_single_course_summary' ); ?>

	<?php do_action( 'learn_press_after_single_course_summary' ); ?>

</article><!-- #post-## -->

<?php thim_related_courses(); ?>
<?php do_action( 'learn_press_after_single_course' ); ?>
