<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $course_rate_res ) ) {
	return;
}

$rated = $course_rate_res['rated'] ?? 0;
$total = $course_rate_res['total'] ?? 0;
?>
<div class="course-rating">
	<h3><?php esc_html_e( 'Reviews', 'eduma' ); ?></h3>
	<div class="average-rating">
		<p class="rating-title"><?php esc_html_e( 'Average Rating', 'eduma' ); ?></p>

		<div class="rating-box">
			<div class="average-value" itemprop="ratingValue"><?php echo ( $rated ) ? esc_html( round( $rated, 1 ) ) : 0; ?></div>
			<div class="review-star">
				<?php thim_print_rating( $rated ); ?>
			</div>
			<div class="review-amount">
				<meta itemprop="ratingCount" content="<?php echo $total; ?>>"/>
				<?php $total ? printf( _n( '%1$s rating', '%1$s ratings', $total, 'eduma' ), number_format_i18n( $total ) ) : esc_html_e( '0 rating', 'eduma' ); ?>
			</div>
		</div>
	</div>
	<div class="detailed-rating">
		<p class="rating-title"><?php esc_html_e( 'Detailed Rating', 'eduma' ); ?></p>

		<div class="rating-box">
			<div class="detailed-rating">
				<?php
				if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ) :
					foreach ( $course_rate_res['items'] as $item ) :
						$percent = round( $item['percent'], 0 );
						?>
						<div class="stars">
							<div class="key">
								<?php
								echo esc_html( $item['rated'] );
								?>
							</div>
							<div class="bar">
								<div class="full_bar">
									<div style="width:<?php echo $percent; ?>% "></div>
								</div>
							</div>
							<span><?php echo esc_html( $percent ); ?>%</span>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>
</div>
