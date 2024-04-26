<?php
function thim_add_default_templates() {
    $data                 = array();
    $data['name']         = __( 'Courses Slider 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-slider-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1471791722105{margin-bottom: 100px !important;}"][vc_column 0=""][vc_row_inner 0=""][vc_column_inner 0=""][thim-heading title="Popular Courses" line="yes"][/vc_column_inner][/vc_row_inner][thim-courses limit="6"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Icon Box 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/icon-box-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Icon Box'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row el_class="thim-best-industry" css=".vc_custom_1471005335630{margin-right: -2px !important;margin-left: -2px !important;}"][vc_column width="1/3" css=".vc_custom_1471791457305{margin-bottom: 30px !important;padding-right: 2px !important;padding-left: 2px !important;}"][thim-icon-box line_after_title="" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="" read_more_text="View More" read_more_text_color="#ffb606" read_more_text_hover_color="#ffb606" icon_type="custom" custom_image_icon="50" width_icon_box="135" layout_pos="left" layout_style_box="overlay" title="Best Industry Leaders"][/vc_column][vc_column width="1/3" css=".vc_custom_1471791466594{margin-bottom: 30px !important;padding-right: 2px !important;padding-left: 2px !important;}"][thim-icon-box line_after_title="" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="" read_more_text="View More" read_more_text_color="#ffb606" read_more_text_hover_color="#ffb606" icon_type="custom" custom_image_icon="1748" width_icon_box="135" layout_pos="left" layout_style_box="overlay" title="Learn Course Online"][/vc_column][vc_column width="1/3" css=".vc_custom_1471791487523{margin-bottom: 30px !important;padding-right: 2px !important;padding-left: 2px !important;}"][thim-icon-box line_after_title="" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="" read_more_text="View More" read_more_text_color="#ffb606" read_more_text_hover_color="#ffb606" icon_type="custom" custom_image_icon="1749" width_icon_box="135" layout_pos="left" layout_style_box="overlay" title="Book Library &amp; Store"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Countdown + Form 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/countdown-form.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Countdown'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" parallax="content-moving" parallax_image="5841" parallax_speed_bg="1.3" el_class="thim-bg-overlay"][vc_column width="1/2"][vc_raw_html 0=""]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aGltLWdldC0xMDBzJTIyJTNFJTBBJTNDcCUyMGNsYXNzJTNEJTIyZ2V0LTEwMHMlMjIlM0VHZXQlMjAxMDBzJTIwb2YlMjBvbmxpbmUlMjAlM0NzcGFuJTIwY2xhc3MlM0QlMjJ0aGltLWNvbG9yJTIyJTNFQ291cnNlcyUyMEZvciUyMEZyZWUlM0MlMkZzcGFuJTNFJTNDJTJGcCUzRSUwQSUzQ2gyJTNFUmVnaXN0ZXIlMjBOb3clM0MlMkZoMiUzRSUwQSUzQyUyRmRpdiUzRQ==[/vc_raw_html][thim-countdown-box style_color="white" text_align="text-left" time_year="2018" time_month="05" time_day="01" time_hour="12"][/vc_column][vc_column width="1/2"][vc_raw_html 0=""]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aGltLXJlZ2lzdGVyLW5vdy1mb3JtJTIyJTNFJTBBJTNDaDMlMjBjbGFzcyUzRCUyMnRpdGxlJTIyJTNFJTNDc3BhbiUzRUNyZWF0ZSUyMHlvdXIlMjBmcmVlJTIwYWNjb3VudCUyMG5vdyUyMGFuZCUyMGdldCUyMGltbWVkaWF0ZSUyMGFjY2VzcyUyMHRvJTIwMTAwcyUyMG9mJTIwb25saW5lJTIwY291cnNlcy4lM0MlMkZzcGFuJTNFJTNDJTJGaDMlM0UlMEElNUJjb250YWN0LWZvcm0tNyUyMGlkJTNEJTIyODUlMjIlMjB0aXRsZSUzRCUyMkdldCUyMEl0JTIwTm93JTIyJTVEJTBBJTNDJTJGZGl2JTNF[/vc_raw_html][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'List Events 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/event-list-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'List Events'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row 0=""][vc_column 0=""][vc_row_inner 0=""][vc_column_inner 0=""][thim-heading title="Events" sub_heading="Upcoming Education Events to feed your brain." line="yes"][/vc_column_inner][/vc_row_inner][thim-list-events text_link="VIEW ALL"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'List Posts 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/posts-list-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'List Posts'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" parallax="content-moving" parallax_image="5854" parallax_speed_bg="1.3" el_class="thim-bg-overlay" css=".vc_custom_1471016167480{padding-top: 30px !important;padding-bottom: 85px !important;}"][vc_column 0=""][vc_row_inner 0=""][vc_column_inner 0=""][thim-heading title="Latest News" textcolor="#ffffff" title_custom="custom" font_weight="" sub_heading="Education news all over the world." sub_heading_color="#ffffff" line="yes" bg_line="#ffffff"][/vc_column_inner][/vc_row_inner][thim-carousel-posts cat_id="9" number_posts="4"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Testimonials Slider 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/testimonials-slider-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Testimonials'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row 0=""][vc_column 0=""][vc_row_inner 0=""][vc_column_inner 0=""][thim-heading title="What People Say" sub_heading="How real people said about Education WordPress Theme." line="yes" text_align="text-center"][/vc_column_inner][/vc_row_inner][thim-testimonials autoplay="" mousewheel=""][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Search Form 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-search-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row_content_no_spaces" el_class="thim-bg-overlay-color" css=".vc_custom_1471451947317{margin-bottom: 80px !important;background-image: url(https://eduma.thimpress.com/thim-2/wp-content/uploads/sites/42/2015/11/bg-home-2.jpg?id=2809) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column css=".vc_custom_1471451509115{padding-top: 120px !important;padding-bottom: 111px !important;}"][vc_row_inner][vc_column_inner][thim-courses-searching title="Online Courses to Learn" description="Own your future learning new skills online"][/vc_column_inner][/vc_row_inner][vc_raw_html]JTNDdWwlMjBjbGFzcyUzRCUyMnNlYXJjaC1jb3Vyc2UtbGlzdC1pbmZvJTIyJTNFJTBBJTA5JTNDbGklM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLWdyYWR1YXRpb24tY2FwJTIyJTNFJTNDJTJGaSUzRSUzQ2ElMjBocmVmJTNEJTIyJTIzJTIyJTNFT3ZlciUyMDclMjBtaWxsaW9uJTIwc3R1ZGVudHMuJTNDJTJGYSUzRSUzQyUyRmxpJTNFJTBBJTA5JTNDbGklM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLXJlYmVsJTIyJTNFJTNDJTJGaSUzRSUzQ2ElMjBocmVmJTNEJTIyJTIzJTIyJTNFTW9yZSUyMHRoYW4lMjAzMCUyQzAwMCUyMGNvdXJzZXMuJTNDJTJGYSUzRSUzQyUyRmxpJTNFJTBBJTA5JTNDbGklM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLXBhcGVyLXBsYW5lJTIyJTNFJTNDJTJGaSUzRSUzQ2ElMjBocmVmJTNEJTIyJTIzJTIyJTNFTGVhcm4lMjBhbnl0aGluZyUyMG9ubGluZS4lM0MlMkZhJTNFJTNDJTJGbGklM0UlMEElM0MlMkZ1bCUzRQ==[/vc_raw_html][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Categories Slider', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/course-categories-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1471365268801{margin-right: -2px !important;margin-left: -2px !important;}"][vc_column css=".vc_custom_1471005347922{padding-right: 2px !important;padding-left: 2px !important;}"][thim-course-categories layout="slider" slider_show_pagination="" slider_show_navigation="yes"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Counter Up 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/counter-up-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Counter Up'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" parallax="content-moving" parallax_image="5841" parallax_speed_bg="1.8" el_class="thim-bg-overlay" css=".vc_custom_1471451648643{padding-top: 124px !important;padding-bottom: 124px !important;}"][vc_column width="1/4"][thim-counters-box counters_label="LEARNER" counters_value="5000"][/vc_column][vc_column width="1/4"][thim-counters-box counters_label="GRADUATES" counters_value="6000"][/vc_column][vc_column width="1/4"][thim-counters-box counters_label="COUNTRIES REACHED" counters_value="150"][/vc_column][vc_column width="1/4" el_class="thim-no-border"][thim-counters-box counters_label="COURSES PUBLISHED" counters_value="940"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Slider Form', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/slider-form.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Slider'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row_content_no_spaces" css=".vc_custom_1471532229220{background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][rev_slider_vc alias="home-page-video"][/vc_column][/vc_row][vc_row el_class="thim-register-form-top"][vc_column width="1/2"][/vc_column][vc_column width="1/2"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aGltLXJlZ2lzdGVyLW5vdy1mb3JtJTIwdG9wLWhvbWVwYWdlJTIyJTNFJTBBJTNDaDMlMjBjbGFzcyUzRCUyMnRpdGxlJTIyJTNFJTNDc3BhbiUzRUNyZWF0ZSUyMHlvdXIlMjBmcmVlJTIwYWNjb3VudCUyMG5vdyUyMGFuZCUyMGdldCUyMGltbWVkaWF0ZSUyMGFjY2VzcyUyMHRvJTIwMTAwcyUyMG9mJTIwb25saW5lJTIwQ291cnNlcy4lM0MlMkZzcGFuJTNFJTNDJTJGaDMlM0UlMEElNUJjb250YWN0LWZvcm0tNyUyMGlkJTNEJTIyODUlMjIlMjB0aXRsZSUzRCUyMkdldCUyMEl0JTIwTm93JTIyJTVEJTBBJTNDJTJGZGl2JTNF[/vc_raw_html][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Counter Up 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/counter-up-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Counter Up'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row el_class="thim-global-locations" css=".vc_custom_1474599409571{margin-right: 0px !important;margin-bottom: 60px !important;margin-left: 0px !important;}"][vc_column width="1/3" css=".vc_custom_1471709478576{padding-right: 0px !important;padding-left: 0px !important;}"][thim-counters-box counters_label="Global Locations" counters_value="10" view_more_text="Find Our Location" view_more_link="#" style="number-left" background_color="#febf28"][/vc_column][vc_column width="1/3" css=".vc_custom_1471709692797{padding-right: 0px !important;padding-left: 0px !important;}"][thim-counters-box counters_label="Programs &amp; Courses" counters_value="94" view_more_text="Discover Now" view_more_link="#" style="number-left" background_color="#ffb605"][/vc_column][vc_column width="1/3" css=".vc_custom_1471709705625{padding-right: 0px !important;padding-left: 0px !important;}"][thim-counters-box counters_label="Years Of Experience" counters_value="25" view_more_text="Learn More" view_more_link="#" style="number-left" background_color="#f0aa03"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Image Box 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/image-box-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Image Box'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row gap="15" el_class="thim-box-language-tests" css=".vc_custom_1474599425613{margin-bottom: 60px !important;}"][vc_column width="1/3"][thim-icon-box title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" title_custom_mg_top="28" title_custom_mg_bt="18" line_after_title="true" desc_content="Plura mihi bona sunt, inclinet, amari petere vellent. Quo usque tandem abutere, Catilina, patientia nostra. Vivamus sagittis lacus vel augue laoreet rutrum" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="true" read_more_text="Learn More" icon_type="custom" custom_image_icon="5961" width_icon_box="0" layout_text_align_sc="text-left" title="Language Tests"][/vc_column][vc_column width="1/3"][thim-icon-box title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" title_custom_mg_top="28" title_custom_mg_bt="18" line_after_title="true" desc_content="Plura mihi bona sunt, inclinet, amari petere vellent. Quo usque tandem abutere, Catilina, patientia nostra. Vivamus sagittis lacus vel augue laoreet rutrum" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="true" read_more_text="Learn More" icon_type="custom" custom_image_icon="5962" width_icon_box="0" layout_text_align_sc="text-left" title="Business English Programs"][/vc_column][vc_column width="1/3"][thim-icon-box title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" title_custom_mg_top="28" title_custom_mg_bt="18" line_after_title="true" desc_content="Plura mihi bona sunt, inclinet, amari petere vellent. Quo usque tandem abutere, Catilina, patientia nostra. Vivamus sagittis lacus vel augue laoreet rutrum" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="true" read_more_text="Learn More" icon_type="custom" custom_image_icon="5963" width_icon_box="0" layout_text_align_sc="text-left" title="Junior Programs"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Call To Action 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/call-to-action-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Call To Action'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row gap="15" el_class="thim-buy-now thim-bg-overlay" css=".vc_custom_1474599183269{margin-right: 0px !important;margin-left: 0px !important;background-image: url(https://eduma.thimpress.com/demo-vc/wp-content/uploads/sites/29/2016/08/bg-buy-now.jpg?id=6713) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column width="2/3"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aGltLWJ1eS1ub3ctZGVzYyUyMiUzRSUwQSUzQ2gzJTIwY2xhc3MlM0QlMjJoZWFkaW5nJTIyJTNFTmV3JTIwU3R1ZGVudHMlMjBKb2luJTIwRXZlcnklMjBXZWVrJTNDJTJGaDMlM0UlMEElM0NwJTIwY2xhc3MlM0QlMjJkZXNjcmlwdGlvbiUyMiUzRUxvcmVtJTIwSXBzdW0lMjBpcyUyMHNpbXBseSUyMGR1bW15JTIwdGV4dCUyMG9mJTIwdGhlJTIwcHJpbnRpbmclMjBhbmQlMjB0eXBlc2V0dGluZyUyMGluZHVzdHJ5LiUzQyUyRnAlM0UlMEElM0MlMkZkaXYlM0U=[/vc_raw_html][/vc_column][vc_column width="1/3"][thim-button title="Apply Now" new_window="true" custom_style="custom_style" font_size="0" font_weight="700" color="#333333" border_color="#ffb606" bg_color="#ffb606" hover_color="#333333" hover_border_color="#e6a303" hover_bg_color="#e6a303"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Tabs', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-tab-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1474599138210{margin-top: 30px !important;margin-bottom: 60px !important;}"][vc_column][thim-heading title="Choose Your Languages" line="yes"][thim-courses limit="14" layout="tabs" cat_id_tab="31,36,37,44"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Search Form 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-search-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row_content_no_spaces" el_class="thim-bg-overlay thim-search-light-style" css=".vc_custom_1472061806438{margin-bottom: 80px !important;padding-top: 230px !important;padding-bottom: 200px !important;background-image: url(https://eduma.thimpress.com/demo-vc-courses-hub/wp-content/uploads/sites/33/2016/08/top-banner.jpg?id=6760) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner][thim-courses-searching title="Online Courses to Learn" description="Own your future learning new skills online"][/vc_column_inner][/vc_row_inner][vc_raw_html]JTNDdWwlMjBjbGFzcyUzRCUyMnNlYXJjaC1jb3Vyc2UtbGlzdC1pbmZvJTIyJTNFJTBBJTA5JTNDbGklM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLWdyYWR1YXRpb24tY2FwJTIyJTNFJTNDJTJGaSUzRSUzQ2ElMjBocmVmJTNEJTIyJTIzJTIyJTNFT3ZlciUyMDclMjBtaWxsaW9uJTIwc3R1ZGVudHMuJTNDJTJGYSUzRSUzQyUyRmxpJTNFJTBBJTA5JTNDbGklM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLXJlYmVsJTIyJTNFJTNDJTJGaSUzRSUzQ2ElMjBocmVmJTNEJTIyJTIzJTIyJTNFTW9yZSUyMHRoYW4lMjAzMCUyQzAwMCUyMGNvdXJzZXMuJTNDJTJGYSUzRSUzQyUyRmxpJTNFJTBBJTA5JTNDbGklM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLXBhcGVyLXBsYW5lJTIyJTNFJTNDJTJGaSUzRSUzQ2ElMjBocmVmJTNEJTIyJTIzJTIyJTNFTGVhcm4lMjBhbnl0aGluZyUyMG9ubGluZS4lM0MlMkZhJTNFJTNDJTJGbGklM0UlMEElM0MlMkZ1bCUzRQ==[/vc_raw_html][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Collections 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-colections-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row][vc_column][thim-courses-collection limit="4" feature_items="2"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Icon Box 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/icon-box-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Icon Box'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1471674632787{padding-top: 29px !important;padding-bottom: 29px !important;background-color: #ffb606 !important;}" el_class="thim-university-top-icon"][vc_column width="1/6"][thim-icon-box title_color="#ffffff" title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" line_after_title="" desc_content="" custom_font_weight_desc="" link_to_icon="" icon_type="font-awesome" font_awesome_icon="fa fa-twitch" font_awesome_icon_size="36" width_icon_box="70" icon_color="#ffffff" layout_text_align_sc="text-center" title="ARTSUW"][/vc_column][vc_column width="1/6"][thim-icon-box title_color="#ffffff" title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" line_after_title="" desc_content="" custom_font_weight_desc="" link_to_icon="" icon_type="font-awesome" font_awesome_icon="fa fa-twitch" font_awesome_icon_size="36" width_icon_box="70" icon_color="#ffffff" layout_text_align_sc="text-center" title="ARTSUW"][/vc_column][vc_column width="1/6"][thim-icon-box title_color="#ffffff" title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" line_after_title="" desc_content="" custom_font_weight_desc="" link_to_icon="" icon_type="font-awesome" font_awesome_icon="fa fa-twitch" font_awesome_icon_size="36" width_icon_box="70" icon_color="#ffffff" layout_text_align_sc="text-center" title="ARTSUW"][/vc_column][vc_column width="1/6"][thim-icon-box title_color="#ffffff" title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" line_after_title="" desc_content="" custom_font_weight_desc="" link_to_icon="" icon_type="font-awesome" font_awesome_icon="fa fa-twitch" font_awesome_icon_size="36" width_icon_box="70" icon_color="#ffffff" layout_text_align_sc="text-center" title="ARTSUW"][/vc_column][vc_column width="1/6"][thim-icon-box title_color="#ffffff" title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" line_after_title="" desc_content="" custom_font_weight_desc="" link_to_icon="" icon_type="font-awesome" font_awesome_icon="fa fa-twitch" font_awesome_icon_size="36" width_icon_box="70" icon_color="#ffffff" layout_text_align_sc="text-center" title="ARTSUW"][/vc_column][vc_column width="1/6" el_class="thim-no-border"][thim-icon-box title_color="#ffffff" title_font_heading="custom" title_custom_font_size="18" title_custom_font_weight="700" line_after_title="" desc_content="" custom_font_weight_desc="" link_to_icon="" icon_type="font-awesome" font_awesome_icon="fa fa-twitch" font_awesome_icon_size="36" width_icon_box="70" icon_color="#ffffff" layout_text_align_sc="text-center" title="ARTSUW"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Events + Form', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/events-form-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'List Events'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1471681244488{margin-right: -15px !important;margin-bottom: 100px !important;margin-left: -15px !important;}" el_class="thim-welcome-university"][vc_column width="1/3" css=".vc_custom_1471674731278{padding-right: 30px !important;padding-left: 15px !important;}"][vc_row_inner][vc_column_inner][thim-heading title="Welcome" line="yes"][/vc_column_inner][/vc_row_inner][thim-icon-box line_after_title="" desc_content="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words." custom_font_size_desc="0" custom_font_weight_desc="" read_more_link="#" read_more_link_to="more" link_to_icon="" read_more_text="Read More" icon_type="custom" custom_image_icon="6705" width_icon_box="370" layout_text_align_sc="text-left"][/vc_column][vc_column width="1/3" css=".vc_custom_1471675313730{padding-right: 15px !important;padding-left: 30px !important;}"][vc_row_inner][vc_column_inner][thim-heading title="Events" line="yes"][/vc_column_inner][/vc_row_inner][thim-list-events number_posts="3" layout="layout-2" text_link="VIEW ALL"][/vc_column][vc_column width="1/3"][vc_raw_html]JTNDZGl2JTIwY2xhc3MlM0QlMjJ0aGltLXJlZ2lzdGVyLW5vdy1mb3JtJTIyJTNFJTBBJTNDaDMlMjBjbGFzcyUzRCUyMnRpdGxlJTIyJTNFJTNDc3BhbiUzRUNyZWF0ZSUyMHlvdXIlMjBmcmVlJTIwYWNjb3VudCUyMG5vdyUyMGFuZCUyMGdldCUyMGltbWVkaWF0ZSUyMGFjY2VzcyUyMHRvJTIwMTAwcyUyMG9mJTIwb25saW5lJTIwY291cnNlcy4lM0MlMkZzcGFuJTNFJTNDJTJGaDMlM0UlMEElNUJjb250YWN0LWZvcm0tNyUyMGlkJTNEJTIyODUlMjIlMjB0aXRsZSUzRCUyMkdldCUyMEl0JTIwTm93JTIyJTVEJTBBJTNDJTJGZGl2JTNF[/vc_raw_html][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Posts Slider 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/posts-slider-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'List Posts'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1471681425935{margin-bottom: 85px !important;}" el_class="thim-latest-new-university"][vc_column][vc_row_inner][vc_column_inner][thim-heading title="Latest News" title_custom="custom" font_weight="" sub_heading="Education news all over the world." line="yes"][/vc_column_inner][/vc_row_inner][thim-carousel-posts cat_id="9" number_posts="4"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Call To Action 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/call-to-action-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Call To Action'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" parallax="content-moving" parallax_image="6707" parallax_speed_bg="1.3" el_class="thim-dark thim-join-the-elite-group"][vc_column][vc_row_inner][vc_column_inner][thim-heading title="Trusted by over 6000+ students" textcolor="#ffffff" sub_heading="Join our community of students around the world helping you succeed." sub_heading_color="#ffffff" line="" text_align="text-center"][/vc_column_inner][/vc_row_inner][thim-button title="Get Started" new_window="true"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Slider React', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/slider-react.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Slider'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row_content_no_spaces" el_class="thim_overlay_gradient_2 thim_image_overlay_bottom"][vc_column][rev_slider_vc alias="home-page"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Icon Box React', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/icon-box-react.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Icon Box'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1524106096428{padding-bottom: 55px !important;background-color: #fafafa !important;}"][vc_column width="1/3" css=".vc_custom_1524106110518{margin-top: -120px !important;}"][thim-icon-box title_color="#333333" title_size="h3" title_font_heading="custom" title_custom_font_size="20" title_custom_font_weight="normal" title_custom_mg_top="30" title_custom_mg_bt="20" line_after_title="" desc_content="Well-known as the #1 theme for Education, Eduma is now available in a new look." custom_font_size_desc="16" custom_font_weight_desc="" link_to_icon="" icon_type="custom" custom_image_icon="7508" width_icon_box="160" height_icon_box="160" icon_border_color="#3b93f7" icon_bg_color="#3b93f7" layout_box_icon_style="circle" layout_pos="top" layout_text_align_sc="text-center" title="A new modern Eduma" color_desc="#808080"][/vc_column][vc_column width="1/3" css=".vc_custom_1524106154009{margin-top: -120px !important;}"][thim-icon-box title_color="#333333" title_size="h3" title_font_heading="custom" title_custom_font_size="20" title_custom_font_weight="normal" title_custom_mg_top="30" title_custom_mg_bt="20" line_after_title="" desc_content="Integrated with the best tools for e-Learning, Eduma can meet any demands for education purpose." custom_font_size_desc="16" custom_font_weight_desc="" link_to_icon="" icon_type="custom" custom_image_icon="7509" width_icon_box="160" height_icon_box="160" icon_border_color="#e3674e" icon_bg_color="#e3674e" layout_box_icon_style="circle" layout_pos="top" layout_text_align_sc="text-center" title="Best choice for E-Learning" color_desc="#808080"][/vc_column][vc_column width="1/3" css=".vc_custom_1524106164041{margin-top: -120px !important;}"][thim-icon-box title_color="#333333" title_size="h3" title_font_heading="custom" title_custom_font_size="20" title_custom_font_weight="normal" title_custom_mg_top="30" title_custom_mg_bt="20" line_after_title="" desc_content="Eduma React gives you modern designs, friendly UI/UX for the best learning experience." custom_font_size_desc="16" custom_font_weight_desc="" link_to_icon="" icon_type="custom" custom_image_icon="7507" width_icon_box="160" height_icon_box="160" icon_border_color="#65d656" icon_bg_color="#65d656" layout_box_icon_style="circle" layout_pos="top" layout_text_align_sc="text-center" title="Learn better with Eduma" color_desc="#808080"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Categories Tabs 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/categories-tab-1.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1524634000944{padding-top: 95px !important;padding-bottom: 120px !important;background-image: url(https://eduma.thimpress.com/demo-vc-react/wp-content/uploads/sites/50/2018/04/bg_parallax_2.png?id=7503) !important;}" el_class="vc_parallax_right vc_parallax"][vc_column][thim-heading title="Categories" size="h2" title_custom="custom" font_size="28" font_weight="normal" clone_title="true" line="" text_align="text-center"][thim-course-categories layout="tab-slider"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Countdown + Form 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/countdown-form-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Countdown'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" el_class="thim-bg-overlay-70" css=".vc_custom_1524634225548{padding-top: 90px !important;padding-bottom: 90px !important;background-image: url(https://eduma.thimpress.com/demo-vc-react/wp-content/uploads/sites/50/2018/04/bg_countdown.jpg?id=7519) !important;}"][vc_column width="1/2"][thim-heading title="We Can Offer" textcolor="#ffffff" size="h2" title_custom="custom" font_size="32" font_weight="normal" clone_title="true" line="" text_align="text-left"][thim-icon-box title_color="#ffffff" title_size="h2" title_font_heading="custom" title_custom_font_size="20" title_custom_font_weight="bold" line_after_title="" desc_content="With the team of professionals, we guarantee the best lessons and courses for your students" custom_font_size_desc="16" custom_font_weight_desc="" icon_type="custom" custom_image_icon="7506" width_icon_box="85" height_icon_box="75" layout_pos="left" layout_text_align_sc="text-left" title="Expert Instructors" color_desc="#999999"][vc_empty_space height="40px"][thim-icon-box title_color="#ffffff" title_size="h2" title_font_heading="custom" title_custom_font_size="20" title_custom_font_weight="bold" line_after_title="" desc_content="Detailed Learning Documents and Video Tutorials are well-prepared and can be accessed anytime." custom_font_size_desc="16" custom_font_weight_desc="" icon_type="custom" custom_image_icon="7505" width_icon_box="85" height_icon_box="75" layout_pos="left" layout_text_align_sc="text-left" title="Learning Documents" color_desc="#999999"][vc_empty_space height="40px"][thim-icon-box title_color="#ffffff" title_size="h2" title_font_heading="custom" title_custom_font_size="20" title_custom_font_weight="bold" line_after_title="" desc_content="Eduma can provide the best environment for learning via a friendly UI/UX with many exclusive features." custom_font_size_desc="16" custom_font_weight_desc="" icon_type="custom" custom_image_icon="7504" width_icon_box="85" height_icon_box="75" layout_pos="left" layout_text_align_sc="text-left" title="Powerful Learning Tools" color_desc="#999999"][/vc_column][vc_column width="1/2"][vc_row_inner el_class="thim_countdown_newletter_box"][vc_column_inner][thim-countdown-box layout="pie-gradient" time_year="2018" time_month="7" time_day="30" time_hour="10"][vc_column_text][mc4wp_form id="3101"][/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Tabs 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-tab-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1524041206370{padding-top: 75px !important;}"][vc_column][thim-courses title="Online Courses" limit="5" featured="" order="latest" layout="tabs-slider" view_all_position="top" limit_tab="5" cat_id_tab="65" view_all_courses="View All Courses"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'List Instructors 1', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/list-instructors.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1524644527304{padding-top: 100px !important;background-image: url(https://eduma.thimpress.com/demo-vc-react/wp-content/uploads/sites/50/2018/04/bg_instructor_blur.jpg?id=7518) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column css=".vc_custom_1524105621298{margin-bottom: -165px !important;}"][thim-heading title="Instructors" textcolor="#ffffff" size="h2" title_custom="custom" font_size="28" font_weight="normal" clone_title="true" line="" text_align="text-center"][thim-list-instructors layout="new" visible_item="1" show_pagination="no" panel="%5B%7B%22panel_img%22%3A%227510%22%2C%22panel_id%22%3A%2236036%22%7D%2C%7B%22panel_img%22%3A%227510%22%2C%22panel_id%22%3A%2236037%22%7D%5D"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Slider Edtech', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/slider-edtech.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Slider'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row_content_no_spaces" el_class="thim_overlay_gradient have_scroll_bottom"][vc_column 0=""][rev_slider_vc alias="home-page"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'List Instructors 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/list-instructors-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1524110766762{padding-top: 100px !important;background-image: url(https://eduma.thimpress.com/demo-vc-edtech/wp-content/uploads/sites/47/2017/12/bg_instructor_blur.jpg?id=7335) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][thim-heading title="Instructors" textcolor="#ffffff" size="h2" title_custom="custom" font_size="28" font_weight="normal" clone_title="true" line="" text_align="text-center"][thim-list-instructors visible_item="3" number="3"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Events Lists 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/events-list-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'List Events'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1513321249828{padding-top: 220px !important;padding-bottom: 120px !important;}" el_class="layout_demo_1"][vc_column][thim-heading title="Events" clone_title="true" line=""][thim-list-events number_posts="3"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Counter Up 3', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/counter-up-3.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Counter Up'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1532070583248{margin-bottom: 0px !important;padding-top: 60px !important;padding-bottom: 60px !important;background-color: #353866 !important;}"][vc_column width="1/4" css=".vc_custom_1532062830416{padding-top: 0px !important;}"][thim-counters-box counters_label="Passing" counters_value="100" text_number="%" style="home-page" el_class="home-grad"][/vc_column][vc_column width="1/4" css=".vc_custom_1532062836262{padding-top: 0px !important;}"][thim-counters-box counters_label="People Working" counters_value="100" style="home-page" el_class="home-grad"][/vc_column][vc_column width="1/4" css=".vc_custom_1532062843476{padding-top: 0px !important;}"][thim-counters-box counters_label="Students Enrolled" counters_value="55" text_number="K" style="home-page" el_class="home-grad"][/vc_column][vc_column width="1/4" css=".vc_custom_1532062850425{padding-top: 0px !important;}"][thim-counters-box counters_label="Years of experience" counters_value="40" style="home-page" el_class="home-grad"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data                 = array();
    $data['name']         = __( 'Courses Collections 2', 'eduma' );
    $data['weight']       = 0; // Weight of your template in the template list
    $data['image_path']   = preg_replace( '/\s/', '%20', THIM_URI . 'images/vc-template/courses-collections-2.jpg' ); //image size 300x200px
    $data['custom_class'] = '';
    $data['cat']          = 'Courses'; //Category filter
    $data['content']      = <<<CONTENT
        [vc_row css=".vc_custom_1532397882289{margin-bottom: 0px !important;}" el_class="margin-top-collection"][vc_column css=".vc_custom_1532071377271{padding-top: 0px !important;}"][vc_column_text][thim-courses-collection layout="slider" limit="5" columns="4" feature_items=""][/vc_column_text][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );


}
add_action( 'vc_load_default_templates_action', 'thim_add_default_templates' );