<?php
// remove custom field in theme eduma
remove_action( 'learnpress/course-settings/after-general', 'eduma_add_custom_field_course' );

if ( ! function_exists( 'eduma_course_offline_add_custom_field_course' ) ) {

	function eduma_course_offline_add_custom_field_course() {
		lp_meta_box_text_input_field(
			array(
				'label'       => esc_html__( 'Duration Info', 'eduma' ),
				'id'          => 'thim_course_duration',
				'description' => esc_html__( 'Overwrite display Duration in singe course', 'eduma' ),
				'default'     => ''
			)
		);
		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_time',
				'label'   => esc_html__( 'Time', 'eduma' ),
				'desc'    => esc_html__( 'Show Time start and time end in course', 'eduma' ),
				'default' => ''
			)
		);
		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_day_of_week',
				'label'   => esc_html__( 'Day of Week', 'eduma' ),
				'desc'    => esc_html__( 'Show Day of Week Course', 'eduma' ),
				'default' => ''
			)
		);
		lp_meta_box_text_input_field(
			array(
				'id'         => 'thim_course_class_size',
				'label'      => esc_html__( 'Class Size', 'eduma' ),
				'desc'       => esc_html__( 'Class Size', 'eduma' ),
				'type_input' => 'number',
				'default'    => '',
				'style'      => 'width: 100px',
			)
		);
		lp_meta_box_text_input_field(
			array(
				'id'         => 'thim_course_available_seats',
				'label'      => esc_html__( 'Available Seats', 'eduma' ),
				'desc'       => esc_html__( 'Enter available seats', 'eduma' ),
				'default'    => '',
				'type_input' => 'number',
				'style'      => 'width: 100px',
			)
		);
		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_year_old',
				'label'   => esc_html__( 'Years Old', 'eduma' ),
				'desc'    => esc_html__( 'Enter age', 'eduma' ),
				'default' => ''
			)
		);
		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_price',
				'label'   => esc_html__( 'Price', 'eduma' ),
				'desc'    => esc_html__( 'Enter course price', 'eduma' ),
				'default' => ''
			)
		);

		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_unit_price',
				'label'   => esc_html__( 'Unit', 'eduma' ),
				'desc'    => esc_html__( 'Enter unit, for example, p/h, person/hour', 'eduma' ),
				'default' => ''
			)
		);
		lp_meta_box_textarea_field(
			array(
				'id'          => 'thim_course_media_intro',
				'label'       => esc_html__( 'Media Intro', 'eduma' ),
				'description' => esc_html__( 'Enter media intro', 'eduma' ),
				'default'     => '',
			)
		);

	}
}
// add cusom field for course
add_action( 'learnpress/course-settings/after-general', 'eduma_course_offline_add_custom_field_course' );

add_action( 'learnpress_save_lp_course_metabox', function ( $post_id ) {
	$video           = ! empty( $_POST['thim_course_media_intro'] ) ? $_POST['thim_course_media_intro'] : '';
	$time            = ! empty( $_POST['thim_course_time'] ) ? $_POST['thim_course_time'] : '';
	$duration_info   = ! empty( $_POST['thim_course_duration'] ) ? $_POST['thim_course_duration'] : '';
	$day_of_week     = ! empty( $_POST['thim_course_day_of_week'] ) ? $_POST['thim_course_day_of_week'] : '';
	$available_seats = ! empty( $_POST['thim_course_available_seats'] ) ? $_POST['thim_course_available_seats'] : '';
	$course_price    = ! empty( $_POST['thim_course_price'] ) ? $_POST['thim_course_price'] : '';
	$unit_price      = ! empty( $_POST['thim_course_unit_price'] ) ? $_POST['thim_course_unit_price'] : '';
	$class_size      = ! empty( $_POST['thim_course_class_size'] ) ? $_POST['thim_course_class_size'] : '';
	$year_old        = ! empty( $_POST['thim_course_year_old'] ) ? $_POST['thim_course_year_old'] : '';

	update_post_meta( $post_id, 'thim_course_media_intro', $video );
	update_post_meta( $post_id, 'thim_course_time', $time );
	update_post_meta( $post_id, 'thim_course_duration', $duration_info );
	update_post_meta( $post_id, 'thim_course_day_of_week', $day_of_week );
	update_post_meta( $post_id, 'thim_course_available_seats', $available_seats );
	update_post_meta( $post_id, 'thim_course_price', $course_price );
	update_post_meta( $post_id, 'thim_course_unit_price', $unit_price );
	update_post_meta( $post_id, 'thim_course_class_size', $class_size );
	update_post_meta( $post_id, 'thim_course_year_old', $year_old );
} );

if ( ! function_exists( 'lp_remove_tab_course_setting' ) ) {
	add_filter( 'learnpress/course/metabox/tabs', 'lp_remove_tab_course_setting' );

	function lp_remove_tab_course_setting( $tabs ) {
		unset( $tabs['price'] );          // Remove the price
		unset( $tabs['assessment'] );          // Remove the assessment

		return $tabs;
	}
}

add_filter( 'lp/course/meta-box/fields/general', 'thim_course_offline_setting_general' );
function thim_course_offline_setting_general() {
	return array(

		'_lp_level'        => new LP_Meta_Box_Select_Field(
			esc_html__( 'Level', 'learnpress' ),
			esc_html__( 'Choose a difficulty level.', 'learnpress' ),
			'',
			array(
				'options' => lp_course_level(),
			)
		),
		'_lp_students'     => new LP_Meta_Box_Text_Field(
			esc_html__( 'Fake Students Enrolled', 'learnpress' ),
			esc_html__( 'How many students have taken this course', 'learnpress' ),
			0,
			array(
				'type_input'        => 'number',
				'custom_attributes' => array(
					'min'  => '0',
					'step' => '1',
				),
				'style'             => 'width: 70px;',
			)
		),
		'_lp_max_students' => new LP_Meta_Box_Text_Field(
			esc_html__( 'Max student', 'learnpress' ),
			esc_html__( 'Maximum students can join the course. Set 0 for unlimited.', 'learnpress' ),
			0,
			array(
				'type_input'        => 'number',
				'custom_attributes' => array(
					'min'  => '0',
					'step' => '1',
				),
				'style'             => 'width: 70px;',
			)
		),

		'_lp_featured'                 => new LP_Meta_Box_Checkbox_Field(
			esc_html__( 'Featured list', 'learnpress' ),
			esc_html__( 'Add the course to Featured List.', 'learnpress' ),
			'no'
		),
		'_lp_featured_review'          => new LP_Meta_Box_Textarea_Field(
			esc_html__( 'Featured review', 'learnpress' ),
			esc_html__( 'A good review to promote the course.', 'learnpress' )
		),
		'_lp_external_link_buy_course' => new LP_Meta_Box_Text_Field(
			esc_html__( 'External link', 'learnpress' ),
			esc_html__( 'Normally use for offline classes, Ex: link to a contact page. Format: https://google.com', 'learnpress' ),
			'',
			array(
				'desc_tip' => 'You can apply for case: user register form.<br> You accept for user can learn courses by add manual order on backend',
			)
		),
	);
}

// unregister_post_type
if ( ! function_exists( 'thim_course_offline_unregister_post_type' ) ) {
	function thim_course_offline_unregister_post_type() {
		unregister_post_type( LP_ORDER_CPT );
	}
}
add_action( 'init', 'thim_course_offline_unregister_post_type' );
// remove curriculum
add_action( 'do_meta_boxes', function () {
	remove_meta_box(
		'course-editor', LP_COURSE_CPT, 'normal'
	);
} );

// Manage columns Courses
if ( ! function_exists( 'thim_course_offline_manage_course_columns' ) ) {
	function thim_course_offline_manage_course_columns( $columns ) {
		unset( $columns['price'] );
		unset( $columns['sections'] );
		$keys   = array_keys( $columns );
		$values = array_values( $columns );
		$pos    = array_search( 'instructor', $keys );
		if ( $pos !== false ) {
			array_splice( $keys, $pos + 1, 0, array( 'thim_price' ) );
			array_splice( $values, $pos + 1, 0, __( 'Price', 'learnpress' ) );
			$columns = array_combine( $keys, $values );
		} else {
			$columns['thim_price'] = __( 'Price', 'learnpress' );
		}

		return $columns;
	}

	add_filter( 'manage_lp_course_posts_columns', 'thim_course_offline_manage_course_columns' );
}

if ( ! function_exists( 'thim_course_offline_manage_course_columns_content' ) ) {
	function thim_course_offline_manage_course_columns_content( $column ) {
		global $post;
		switch ( $column ) {
			case 'thim_price':
				$price      = get_post_meta( $post->ID, 'thim_course_price', true );
				$unit_price = get_post_meta( $post->ID, 'thim_course_unit_price', true );
				echo $price . ' ' . $unit_price;
		}
	}

	add_filter( 'manage_lp_course_posts_custom_column', 'thim_course_offline_manage_course_columns_content' );
}
//
if ( ! function_exists( 'thim_course_offline_course_info' ) ) {
	function thim_course_offline_course_info() {
		$cat_name = '';
		$course_id = get_the_ID();

		$duration        = get_post_meta( $course_id, 'thim_course_duration', true );
		$class_size      = get_post_meta( $course_id, 'thim_course_class_size', true );
		$time            = get_post_meta( $course_id, 'thim_course_time', true );
		$day_of_week     = get_post_meta( $course_id, 'thim_course_day_of_week', true );
		$skill_level     = get_post_meta( $course_id, 'thim_course_skill_levels', true );
		$year_old        = get_post_meta( $course_id, 'thim_course_year_old', true );
		$available_seats = get_post_meta( $course_id, 'thim_course_available_seats', true );
		$thim_options    = get_theme_mods();

		$category = wp_get_post_terms( $course_id, 'course_category' );
		if ( ! empty( $category ) && ! is_wp_error( $category ) ) {
			$cat_name = $category[0]->name;
		}

		?>
		<div class="thim-course-info">
			<h3 class="title"><?php esc_html_e( 'Course Features', 'eduma' ); ?></h3>
			<ul>
				<?php
				if ( $duration ) {
					echo '<li class="duration-feature">
						<i class="fa fa-clock-o"></i>
						<span class="label">' . esc_html__( 'Duration', 'eduma' ) . '</span>
						<span class="value">' . esc_attr( $duration ) . '</span>
					</li>';
				}
				if ( $cat_name ) {
					echo '<li class="activities-feature">
							<i class="fa fa-futbol-o"></i>
							<span class="label">' . esc_html__( 'Activities', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $cat_name ) . '</span>
						</li>';
				}
				if ( $class_size ) {
					echo '<li class="class-feature">
							<i class="fa fa-users"></i>
							<span class="label">' . esc_html__( 'Class Sizes', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $class_size ) . '</span>
						</li>';
				}
				if ( $year_old ) {
					echo '<li class="years-feature">
							<i class="fa fa-sun-o"></i>
							<span class="label">' . esc_html__( 'Years Old', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $year_old ) . '</span>
						</li>';
				}
				if ( $time ) {
					echo '<li class="time-feature">
							<i class="fa fa-bell-o"></i>
							<span class="label">' . esc_html__( 'Time', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $time ) . '</span>
						</li>';
				}
				if ( $day_of_week ) {
					echo '<li class="day-of-week-feature">
							<i class="fa fa-calendar-o"></i>
							<span class="label">' . esc_html__( 'Day of week', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $day_of_week ) . '</span>
						</li>';
				}
				if ( $skill_level ) {
					echo '<li class="level-feature">
							<i class="fa fa-calendar-o"></i>
							<span class="label">' . esc_html__( 'Skill level', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $skill_level ) . '</span>
						</li>';
				}
				if ( $available_seats ) {
					echo '<li class="available-feature">
							<i class="fa fa-user-plus"></i>
							<span class="label">' . esc_html__( 'Available Seats', 'eduma' ) . '</span>
							<span class="value">' . esc_attr( $available_seats ) . '</span>
						</li>';
				}
				?>
			</ul>
			<?php
			do_action( 'thim_after_course_info' );
			if ( ! empty( $thim_options['thim_learnpress_timetable_link'] ) ) {
				echo '<div class="text-center"><a class="thim-timetable-link" target="_blank" href="' . esc_url( $thim_options['thim_learnpress_timetable_link'] ) . '">' . esc_html( 'Courses Schedules', 'eduma' ) . '</a></div>';
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'thim_course_offline_course_meta' ) ) {
	function thim_course_offline_course_meta() {
		$course_id   = get_the_ID();
		$class_size  = get_post_meta( $course_id, 'thim_course_class_size', true );
		$year_old    = get_post_meta( $course_id, 'thim_course_year_old', true );
		$price       = get_post_meta( $course_id, 'thim_course_price', true );
		$unit_price  = get_post_meta( $course_id, 'thim_course_unit_price', true );
		$time_course = get_post_meta( $course_id, 'thim_course_time', true );
		$day_of_week = get_post_meta( $course_id, 'thim_course_day_of_week', true );
		$only_price  = ( $class_size == '' || $year_old == '' ) ? ' only-price' : '';

		if ( $time_course || $day_of_week ) {
			echo '<ul class="course-info">';
			echo $time_course ? '<li class="info-item"><span>' . esc_html__( 'Time: ', 'eduma' ) . '</span>' . esc_attr( $time_course ) . '</li>' : '';
			echo $day_of_week ? '<li class="info-item"><span>' . esc_html__( 'Days of Week: ', 'eduma' ) . '</span>' . esc_attr( $day_of_week ) . '</li>' : '';
			echo '</ul>';
		}

		if ( $class_size || $year_old || $price ) {
			echo '<div class="course-offline-meta' . $only_price . '">';
			if ( ! empty( $class_size ) ) {
				echo '<div class="class-size"><label>' . esc_html__( 'Class Size', 'eduma' ) . '</label><div class="value">' . esc_attr( $class_size ) . '</div></div>';
			}

			if ( ! empty( $year_old ) ) {
				echo '<div class="year-old"><label>' . esc_html__( 'Years Old', 'eduma' ) . '</label><div class="value">' . esc_attr( $year_old ) . '</div></div>';
			}

			if ( ! empty( $price ) ) {
				echo '<div class="course-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
				echo '<div class="value " itemprop="price" content="' . esc_attr( $price ) . '">' . esc_attr( $price ) . '</div>';
				echo ( ! empty( $unit_price ) ) ? '<div class="unit-price">' . $unit_price . '</div>' : '';
				echo '</div>';
			}

			echo '</div>';
		}
	}
}

/* form register in single course */
if ( ! function_exists( 'thim_course_offline_register_course' ) ) {
	function thim_course_offline_register_course() {
		if ( is_singular( 'lp_course' ) ) {
			$contact_form = get_theme_mod( 'thim_learnpress_shortcode_contact' );
			$contact      = str_replace( '&quot;', '"', $contact_form );
			if ( ! empty( $contact_form ) ) {
				echo '<div id="contact-form-registration" class="">' . do_shortcode( $contact ) . '</div>';
			}
		}
	}

	add_action( 'thim_end_wrapper_container', 'thim_course_offline_register_course' );
	add_action( 'thim_ekit/header_footer/template/after_footer', 'thim_course_offline_register_course' );

}

// remove hook course online
add_action( 'after_setup_theme', 'thim_course_offline_remove_learnpress_hooks', 20 );
if ( ! function_exists( 'thim_course_offline_remove_learnpress_hooks' ) ) {
	function thim_course_offline_remove_learnpress_hooks() {
		remove_action( 'thim_single_course_payment', LearnPress::instance()->template( 'course' )->func( 'course_pricing' ), 5 );
		remove_action( 'thim_single_course_payment', LearnPress::instance()->template( 'course' )->func( 'course_buttons' ), 15 );
		remove_action( 'thim_single_course_meta', 'thim_course_ratings', 25 );
		remove_action( 'thim_single_course_meta', LearnPress::instance()->template( 'course' )->func( 'user_progress' ), 30 );
		remove_action( 'learn-press/course-content-summary', 'thim_landing_tabs', 22 );
		remove_all_actions( 'learn-press/course-content-summary', 60 );
		remove_action( 'thim_course_info_right', 'thim_course_info', 5 );
		add_action( 'thim_course_info_right', 'thim_course_offline_course_info', 10 );
	}
}

add_action( 'thim_single_course_payment', 'thim_course_offline_single_course_payment', 15 );
function thim_course_offline_single_course_payment() {
	$price      = get_post_meta( get_the_ID(), 'thim_course_price', true );
	$unit_price = get_post_meta( get_the_ID(), 'thim_course_unit_price', true );
	if($price || $unit_price){
	?>
	<div class="course-price course-price-offline" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<div class="value " itemprop="price" content="<?php echo esc_attr( $price ); ?>">
			<?php echo esc_html( $price ); ?>
		</div>
		<?php echo ( ! empty( $unit_price ) ) ? '<div class="unit-price">' . $unit_price . '</div>' : ''; ?>
	</div>
	<?php } ?>
	<a class="thim-enroll-course-button" href="#"><?php esc_html_e( 'Register', 'eduma' ); ?></a>
	<?php
}


add_action( 'thim_single_course_payment', 'thim_course_offline_single_course_payment', 15 );

add_action( 'learn-press/course-content-summary', 'thim_course_offline_content_summary_faqs', 20 );

if ( ! function_exists( 'thim_course_offline_content_summary_faqs' ) ) {
	function thim_course_offline_content_summary_faqs() {

		$course = LP_Course::get_course( get_the_ID() );

		if ( ! $faqs = $course->get_faqs() ) {
			return;
		}

		?>
		<div class="course-tab-panel-faqs course-faqs-course_offline">
			<h3><?php echo esc_html__( 'FAQS', 'eduma' ) ?></h3>
			<?php
			foreach ( $faqs as $faq ) {
				$unique_key = uniqid();
				if ( $faq['question'] && $faq['answer'] ) : ?>
					<input type="checkbox" name="course-faqs-box-ratio"
						   id="course-faqs-box-ratio-<?php echo sanitize_key( $unique_key ); ?>"/>
					<div class="course-faqs-box">
						<label class="course-faqs-box__title"
							   for="course-faqs-box-ratio-<?php echo sanitize_key( $unique_key ); ?>">
							<?php echo esc_html( $faq['question'] ); ?>
						</label>

						<div class="course-faqs-box__content">
							<div class="course-faqs-box__content-inner">
								<?php echo $faq['answer']; ?>
							</div>
						</div>
					</div>
				<?php endif;
			}
			?>
		</div>
		<?php

	}
}

add_action( 'learn-press/course-content-summary', LearnPress::instance()->template( 'course' )->callback( 'single-course/tabs/overview' ), 15 );

// loop item course meta
remove_action( 'learnpress_loop_item_course_meta', 'thim_learnpress_loop_item_course_meta', 10 );
remove_action( 'learnpress_loop_item_course_meta', 'learn_press_courses_loop_item_price', 15 );
add_action(
	'init', function () {
	remove_all_actions( 'thim-lp-course-button-read-more');
}, 999);

add_action( 'learnpress_loop_item_course_meta', 'thim_course_offline_course_meta', 10 );
add_filter( 'learn-press/course-tabs', 'thim_unset_tab_course_offline', 9999 );
function thim_unset_tab_course_offline($defaults ){
	unset( $defaults['curriculum'] );
	return $defaults;
}

add_filter( 'learn-thim-kits-lp-meta-data', 'thim_unset_meta_data_widget_course_offline', 100 );
function thim_unset_meta_data_widget_course_offline($opt ){
	unset( $opt['duration'] );
	unset( $opt['level'] );
	unset( $opt['count_lesson'] );
	unset( $opt['count_quiz'] );
	unset( $opt['count_student'] );
	$opt['thim_course_time'] 		= esc_html__( 'Time', 'eduma' );
	$opt['thim_course_day_of_week'] = esc_html__( 'Day of Week', 'eduma' );
	return $opt;
}
add_filter ('thim-kits-widget-get-price','thim_kits_widget_show_custom_price',100);
function thim_kits_widget_show_custom_price() {
	$price      = get_post_meta( get_the_ID(), 'thim_course_price', true );
	$unit_price = get_post_meta( get_the_ID(), 'thim_course_unit_price', true );
	if($price || $unit_price){
	?>
		<div class="inner_price course-price-offline">
			<div class="value " itemprop="price" content="<?php echo esc_attr( $price ); ?>">
				<?php echo esc_html( $price ); ?>
			</div>
			<?php echo ( ! empty( $unit_price ) ) ? '<div class="unit-price">' . $unit_price . '</div>' : ''; ?>
		</div>
		<?php
	}
}

add_filter( 'thim-kits-extral-meta-data', 'thim_kits_meta_data_course_offline', 100, 3);
function thim_kits_meta_data_course_offline( $string, $meta_data, $settings){

   	if ( in_array( 'thim_course_time', $meta_data ) ) {
		$time            = get_post_meta( get_the_ID(), 'thim_course_time', true );
		if($time){
			$string .= '<span class="meta-feature">';
			if($settings['show_icon_meta_data'] == 'yes'){
				$string .= '<i class="fa fa-bell-o"></i>';
			}
			if($settings['label_meta_data'] != 'yes'){
 				$string .= '<label>' . esc_html__( 'Time', 'eduma' ) . '</label>';
			}
			$string .= '<span class="value">' . esc_attr( $time ) . '</span></span>';
		}

	}

	if ( in_array( 'thim_course_day_of_week', $meta_data ) ) {
		$day_of_week            = get_post_meta( get_the_ID(), 'thim_course_day_of_week', true );

		if($day_of_week){
			$string .= '<span class="meta-feature">';
			if($settings['show_icon_meta_data'] == 'yes'){
				$string .='<i class="fa fa-calendar-o"></i>';
			}
			if($settings['label_meta_data'] != 'yes'){
 				$string .= '<label>' . esc_html__( 'Day of Week', 'eduma' ) . '</label>';
			}
			$string .= '<span class="value">' . esc_attr( $day_of_week ) . '</span></span>';
 		}

	}
	return $string;
}
//
remove_action( 'learnpress_loop_item_price', 'learn_press_courses_loop_item_price', 5);
add_action( 'learnpress_loop_item_price', 'thim_kits_widget_show_custom_price', 5);
