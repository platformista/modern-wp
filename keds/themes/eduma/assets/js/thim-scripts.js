/*
* Re-structure JS
* */
(function ($) {
	'use strict'
	var thim_eduma = {
		el_thim_pop_up_login: null,
		el_loginpopopform: null,
		el_registerPopupForm: null,
		el_form_purchase_course: null,
		el_form_enroll_course: null,

		ready: function () {
			this.getElements()
			if (this.el_thim_pop_up_login.length) {
				this.el_loginpopopform = this.el_thim_pop_up_login.find('form[name=loginpopopform]')
				this.el_registerPopupForm = this.el_thim_pop_up_login.find('form[name=registerformpopup]')
				this.login_form()
			}
			this.form_submission_validate()
			this.thim_TopHeader()
			this.ctf7_input_effect()
			this.mobile_menu_toggle()
			this.thim_background_gradient()
			this.thim_magnificPopup()
			this.full_right()
			this.course_sidebar_right_offset_top()
			this.thim_carousel()
			this.event_click()
			this.plus_minus_addtocart()
			this.back_to_top()
			this.StickySidebar()
			this.thim_SwitchLayout('thim-course')
			this.thim_SwitchLayout('thim-product')
			this.thim_SwitchLayout('blog')
			this.thim_gallery()
			this.submit_form_validate()
			this.waypoint_js()
			this.product_gallery()
		},

		getElements: function () {
			this.el_thim_pop_up_login = $('#thim-popup-login')
			this.el_form_purchase_course = $('form[name=purchase-course]')
			this.el_form_enroll_course = $('form[name=enroll-course]')
		},

		load: function () {
			this.thim_menu()
			this.thim_contentslider()
			this.counter_box()
			this.product_quick_view()
			if ($('#contact-form-registration').length) {
				this.thim_course_offline_popup_form_register();
			}
		},

		resize: function () {
			this.full_right()
			this.thim_carousel()
			this.thim_gallery()
		},

		plus_minus_addtocart: function () {
			if ($('body').hasClass('woocommerce-cart')) {
				$('th.product-name').attr('colspan', '2')
			}
			$(document).on('click', '.quantity-add-value div.plus,.quantity-add-value div.minus', function (event) {
				var qty = $(this).parent('.quantity-add-value').find('.qty');
				var val = parseFloat(qty.val());
				if (isNaN(val)) {
					val = 0;
				}
				var max = parseFloat(qty.attr('max'));
				var min = parseFloat(qty.attr('min'));
				var step = parseFloat(qty.attr('step'));
				if ($(this).is('.plus')) {
					if (max && (max <= val)) {
						qty.val(max).change();
					} else {
						qty.val(val + step).change();
					}
				} else {
					if (min && (min >= val)) {
						qty.val(min).change();
					} else if (val > 0) {
						qty.val(val - step).change();
					}
				}
			});
			// check quanity in cart page
			$('.quantity-add-value').each(function () {
				var type = $(this).find('.qty').attr("type");
				if (type == 'hidden') {
					$(this).hide();
				}
			})
		},

		validate_form: function (form) {
			var valid = true,
				email_valid = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm

			form.find('input.required').each(function () {
				// Check empty value
				if (!$(this).val()) {
					$(this).addClass('invalid')
					valid = false
				}

				// Uncheck
				if ($(this).is(':checkbox') && !$(this).is(':checked')) {
					$(this).addClass('invalid')
					valid = false
				}

				// Check email format
				if ('email' === $(this).attr('type')) {
					if (!email_valid.test($(this).val())) {
						$(this).addClass('invalid')
						valid = false
					}
				}

				// Check captcha
				if ($(this).hasClass('captcha-result')) {
					let captcha_1 = parseInt($(this).data('captcha1')),
						captcha_2 = parseInt($(this).data('captcha2'))

					if ((captcha_1 + captcha_2) !== parseInt($(this).val())) {
						$(this).addClass('invalid').val('')
						valid = false
					}
				}
			})

			// Check repeat password
			if (form.hasClass('auto_login')) {
				let $pw = form.find('input[name=password]'),
					$repeat_pw = form.find('input[name=repeat_password]')

				if ($pw.val() !== $repeat_pw.val()) {
					$pw.addClass('invalid')
					$repeat_pw.addClass('invalid')
					valid = false
				}
			}

			$('form input.required').on('focus', function () {
				$(this).removeClass('invalid')
			})

			return valid
		},

		login_form: function () {
			var teduma = this

			$(document).on('click', '#thim-popup-login .close-popup', function (event) {
				event.preventDefault()
				$('body').removeClass('thim-popup-active')
				teduma.el_thim_pop_up_login.removeClass()

				// Remove param purchase course on login popup
				teduma.el_loginpopopform.find('.params-purchase-code').remove()
				// Remove param enroll course on login popup
				teduma.el_loginpopopform.find('.params-enroll-code').remove()
			})

			$('body .thim-login-popup a.js-show-popup').on('click', function (event) {
				event.preventDefault()

				$('body').addClass('thim-popup-active')
				teduma.el_thim_pop_up_login.addClass('active')

				if ($(this).hasClass('login')) {
					teduma.el_thim_pop_up_login.addClass('sign-in')
				} else {
					teduma.el_thim_pop_up_login.addClass('sign-up')
				}
			})

			//when login in single page event, show login-popup ,remove redirect to page account
			$('body .widget_book-event a.js-show-popup').on('click', function (event) {
				event.preventDefault()
				$('body').addClass('thim-popup-active')
				teduma.el_thim_pop_up_login.addClass('active')
			})

			teduma.el_thim_pop_up_login.find('.link-bottom a').on('click', function (e) {
				e.preventDefault()

				if ($(this).hasClass('login')) {
					teduma.el_thim_pop_up_login.removeClass('sign-up').addClass('sign-in')
				} else {
					teduma.el_thim_pop_up_login.removeClass('sign-in').addClass('sign-up')
				}
			})

			// Show login popup when click to LP buttons
			$('body:not(".logged-in") .enroll-course .button-enroll-course, body:not(".logged-in") form.purchase-course:not(".guest_checkout") .button:not(.button-add-to-cart)').on('click', function (e) {
				if ($('body').hasClass('thim-popup-feature')) {
					e.preventDefault();
					$('.thim-link-login.thim-login-popup .login').trigger('click')

					// Add param purchase course to login and Register form if exists
					teduma.add_params_purchase_course_to_el(teduma.el_loginpopopform)
					teduma.add_params_purchase_course_to_el(teduma.el_registerPopupForm)
				}
			})

			$('.learn-press-content-protected-message .lp-link-login').on('click', function (e) {
				e.preventDefault()

				if ($('body').hasClass('thim-popup-feature')) {
					$('.thim-link-login.thim-login-popup .login').trigger('click')
					// Add param purchase course to login and Register form if exists
					teduma.add_params_purchase_course_to_el(teduma.el_loginpopopform)
					teduma.add_params_purchase_course_to_el(teduma.el_registerPopupForm)
				} else {
					window.location.href = $(this).href()
				}
			})

			$(document).on('click', '#thim-popup-login', function (e) {
				if ($(e.target).attr('id') === 'thim-popup-login') {
					$('body').removeClass('thim-popup-active')
					teduma.el_thim_pop_up_login.removeClass()

					// remove param purchase course on login popup
					teduma.el_loginpopopform.find('.params-purchase-code').remove()
					teduma.el_registerPopupForm.find('.params-purchase-code').remove()
					// remove param enroll course on login popup
					teduma.el_loginpopopform.find('.params-enroll-code').remove()
					teduma.el_registerPopupForm.find('.params-enroll-code').remove()
				}
			})

			this.el_loginpopopform.submit(function (e) {
				if (!thim_eduma.validate_form($(this))) {
					e.preventDefault()
					return false
				}

				var $elem = teduma.el_thim_pop_up_login.find('.thim-login-container')
				$elem.addClass('loading')
			})

			teduma.el_thim_pop_up_login.find('form[name=registerformpopup]').on('submit', function (e) {
				if (!thim_eduma.validate_form($(this))) {
					e.preventDefault()
					return false
				}

				var $elem = teduma.el_thim_pop_up_login.find('.thim-login-container')
				$elem.addClass('loading')
			})

			//My account login
			$('#customer_login .login').submit(function (event) {
				var elem = $(this),
					input_username = elem.find('#username'),
					input_pass = elem.find('#password')

				if (input_pass.length > 0 && input_pass.val() == '') {
					input_pass.addClass('invalid')
					event.preventDefault()
				}

				if (input_username.length > 0 && input_username.val() == '') {
					input_username.addClass('invalid')
					event.preventDefault()
				}
			})
			//My account register
			$('#customer_login .register').submit(function (event) {
				var elem = $(this),
					input_username = elem.find('#reg_username'),
					input_email = elem.find('#reg_email'),
					input_pass = elem.find('#reg_password'),
					input_captcha = $('#customer_login .register .captcha-result'),
					valid_email = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm

				if (input_captcha.length > 0) {
					var captcha_1 = parseInt(input_captcha.data('captcha1')),
						captcha_2 = parseInt(input_captcha.data('captcha2'))

					if (captcha_1 + captcha_2 != parseInt(input_captcha.val())) {
						input_captcha.addClass('invalid').val('')
						event.preventDefault()
					}
				}

				if (input_pass.length > 0 && input_pass.val() == '') {
					input_pass.addClass('invalid')
					event.preventDefault()
				}

				if (input_username.length > 0 && input_username.val() == '') {
					input_username.addClass('invalid')
					event.preventDefault()
				}

				if (input_email.length > 0 && (input_email.val() == '' ||
					!valid_email.test(input_email.val()))) {
					input_email.addClass('invalid')
					event.preventDefault()
				}
			})
			$('#reg_username, #reg_email, #reg_password,#username, #password').on('focus', function () {
				$(this).removeClass('invalid')
			})
		},

		/**
		 * Add params purchase course to element
		 * @purpose When register, login via buy course will send params purchase to action
		 *
		 * @param el
		 * @since 4.2.6
		 * @author tungnx
		 */
		add_params_purchase_course_to_el: function (el) {
			const teduma = this
			// Purchase course.
			if (teduma.el_form_purchase_course.length) {
				el.append('<p class="params-purchase-code"></p>')

				var el_paramsPurchaseCode = el.find('.params-purchase-code')

				$.each(teduma.el_form_purchase_course.find('input'), function (i) {
					const inputName = $(this).attr('name')
					const inputPurchaseCourse = $(this).clone()

					if (el_paramsPurchaseCode.find('input[name=' + inputName + ']').length === 0) {
						el_paramsPurchaseCode.append(inputPurchaseCourse)
					}
				})
			}

			// Enroll course
			if (teduma.el_form_enroll_course.length) {
				el.append('<p class="params-enroll-code"></p>')
				const el_paramsEnrollCode = el.find('.params-enroll-code')

				$.each(teduma.el_form_enroll_course.find('input'), function (i) {
					const inputName = $(this).attr('name')
					const inputEnrollCourse = $(this).clone()

					if (el_paramsEnrollCode.find('input[name=' + inputName + ']').length === 0) {
						el_paramsEnrollCode.append(inputEnrollCourse)
					}
				})
			}
		},

		form_submission_validate: function () {
			// Form login
			$('.form-submission-login form[name=loginform]').on('submit', function (e) {
				if (!thim_eduma.validate_form($(this))) {
					e.preventDefault()
					return false
				}
			})

			// Form register
			$('.form-submission-register form[name=registerform]').on('submit', function (e) {
				if (!thim_eduma.validate_form($(this))) {
					e.preventDefault()
					return false
				}
			})

			// Form lost password
			$('.form-submission-lost-password form[name=lostpasswordform]').on('submit', function (e) {
				if (!thim_eduma.validate_form($(this))) {
					e.preventDefault()
					return false
				}
			})
		},

		thim_TopHeader: function () {
			var header = $('#masthead'),
				height_sticky_header = header.outerHeight(true),
				content_pusher = $('#wrapper-container .content-pusher'),
				top_site_main = $('#wrapper-container .top_site_main')
			$('body').removeClass('fixloader');
			if (header.hasClass('header_overlay')) { // Header overlay
				top_site_main.css({ 'padding-top': height_sticky_header + 'px' })
				$(window).resize(function () {
					let height_sticky_header = header.outerHeight(true)
					top_site_main.css({ 'padding-top': height_sticky_header + 'px' })
				})
			} else if (header.hasClass('sticky-header') & header.hasClass('header_default')) { // Header default
				content_pusher.css({ 'padding-top': height_sticky_header + 'px' })
				$(window).resize(function () {
					let height_sticky_header = header.outerHeight(true)
					content_pusher.css({ 'padding-top': height_sticky_header + 'px' })
				})
			}
		},

		ctf7_input_effect: function () {
			let $ctf7_edtech = $('.form_developer_course'),
				$item_input = $ctf7_edtech.find('.field_item input'),
				$submit_wrapper = $ctf7_edtech.find('.submit_row')

			$item_input.focus(function () {
				$(this).parent().addClass('focusing')
			}).blur(function () {
				$(this).parent().removeClass('focusing')

			})
			$submit_wrapper.on('click', function () {
				$(this).closest('form').submit()
			})
		},



		thim_menu: function () {
			// add class last-menu-item
			$('.width-navigation .menu-main-menu>li.menu-item').last().addClass('last-menu-item')

			//Add class for masthead
			var $header = $('#masthead.sticky-header'),
				off_Top = ($('.content-pusher').length > 0) ? $('.content-pusher').offset().top : 0,
				menuH = $header.outerHeight(),
				latestScroll = 0
			var $imgLogo = $('.site-header .thim-logo img'),
				srcLogo = $($imgLogo).attr('src'),
				dataRetina = $($imgLogo).data('retina'),
				dataSticky = $($imgLogo).data('sticky'),
				dataMobile = $($imgLogo).data('mobile'),
				dataStickyMobile = $($imgLogo).data('sticky_mobile');
			if ($(window).scrollTop() > 2) {
				$header.removeClass('affix-top').addClass('affix')
			}
			if ($(window).outerWidth() < 769) {
				if (dataMobile != null) {
					$($imgLogo).attr('src', dataMobile);
				}
			} else {
				if (window.devicePixelRatio > 1 && dataRetina != null) {
					$($imgLogo).attr('src', dataRetina);
				}
			}
			let flag = false;
			$(window).scroll(function () {
				var current = $(this).scrollTop()
				if (current > 2) {
					$header.removeClass('affix-top').addClass('affix');
					if (!flag) {
						if ($(window).outerWidth() < 769) {
							if (dataStickyMobile != null) {
								$($imgLogo).attr('src', dataStickyMobile);
							} else {
								if (dataSticky != null) {
									$($imgLogo).attr('src', dataSticky);
								}
							}
						} else {
							if (dataSticky != null) {
								$($imgLogo).attr('src', dataSticky);
							}
						}
					}
					flag = true;
				} else {
					$header.removeClass('affix').addClass('affix-top');
					if (flag) {
						if ($(window).outerWidth() < 769) {
							if (dataMobile != null) {
								$($imgLogo).attr('src', dataMobile);
							} else if (srcLogo != null) {
								$($imgLogo).attr('src', srcLogo);
							}
						} else {
							if (window.devicePixelRatio > 1 && dataRetina != null) {
								$($imgLogo).attr('src', dataRetina);

							} else if (srcLogo != null) {
								$($imgLogo).attr('src', srcLogo);
							}
						}
					}
					flag = false;
				}

				if (current > latestScroll && current > menuH + off_Top) {
					if (!$header.hasClass('menu-hidden')) {
						$header.addClass('menu-hidden')
					}
				} else {
					if ($header.hasClass('menu-hidden')) {
						$header.removeClass('menu-hidden')
					}
				}

				latestScroll = current
			})

			//Submenu position
			$('.wrapper-container:not(.mobile-menu-open) .site-header .navbar-nav > .menu-item').each(function () {
				if ($('>.sub-menu', this).length <= 0) {
					return
				}

				let elm = $('>.sub-menu', this),
					off = elm.offset(),
					left = off.left,
					width = elm.width()

				let navW = $('.thim-nav-wrapper').width(),
					isEntirelyVisible = (left + width <= navW)

				if (!isEntirelyVisible) {
					elm.addClass('dropdown-menu-right')
				} else {
					let subMenu2 = elm.find('>.menu-item>.sub-menu')

					if (subMenu2.length <= 0) {
						return
					}

					let off = subMenu2.offset(),
						left = off.left,
						width = subMenu2.width()

					let isEntirelyVisible = (left + width <= navW)

					if (!isEntirelyVisible) {
						elm.addClass('dropdown-left-side')
					}
				}
			})

			let $headerLayout = $('header#masthead')
			let magicLine = function () {
				if ($(window).width() > 768) {
					//Magic Line
					var menu_active = $(
						'#masthead .navbar-nav>li.menu-item.current-menu-item,#masthead .navbar-nav>li.menu-item.current-menu-parent, #masthead .navbar-nav>li.menu-item.current-menu-ancestor')
					if (menu_active.length > 0) {
						menu_active.before('<span id="magic-line"></span>')
						var menu_active_child = menu_active.find(
							'>a,>span.disable_link,>span.tc-menu-inner'),
							menu_left = menu_active.position().left,
							menu_child_left = parseInt(menu_active_child.css('padding-left')),
							magic = $('#magic-line')

						magic.width(menu_active_child.width()).css('left', Math.round(menu_child_left + menu_left)).data('magic-width', magic.width()).data('magic-left', magic.position().left)

					} else {
						var first_menu = $(
							'#masthead .navbar-nav>li.menu-item:first-child')
						first_menu.before('<span id="magic-line"></span>')
						var magic = $('#magic-line')
						magic.data('magic-width', 0)
					}

					var nav_H = parseInt($('.site-header .navigation').outerHeight())
					magic.css('bottom', nav_H - (nav_H - 90) / 2 - 64)
					if ($headerLayout.hasClass('item_menu_active_top')) {
						magic.css('bottom', nav_H - 2)
					}
					$('#masthead .navbar-nav>li.menu-item').on({
						'mouseenter': function () {
							var elem = $(this).find('>a,>span.disable_link,>span.tc-menu-inner'),
								new_width = elem.width(),
								parent_left = elem.parent().position().left,
								left = parseInt(elem.css('padding-left'))
							if (!magic.data('magic-left')) {
								magic.css('left', Math.round(parent_left + left))
								magic.data('magic-left', 'auto')
							}
							magic.stop().animate({
								left: Math.round(parent_left + left),
								width: new_width,
							})
						},
						'mouseleave': function () {
							magic.stop().animate({
								left: magic.data('magic-left'),
								width: magic.data('magic-width'),
							})
						},
					})
				}
			}

			if (!$headerLayout.hasClass('noline_menu_active')) {
				magicLine()
			}

		},

		mobile_menu_toggle: function () {
			// Mobile Menu
			if (jQuery('.navbar-nav>li.menu-item-has-children').hasClass("thim-ekits-menu__has-dropdown") == false) {
				if (jQuery(window).width() > 768) {
					jQuery('.navbar-nav>li.menu-item-has-children >a,.navbar-nav>li.menu-item-has-children >span,.navbar-nav>li.tc-menu-layout-builder >a,.navbar-nav>li.tc-menu-layout-builder >span').after(
						'<span class="icon-toggle"><i class="fa fa-angle-down"></i></span>')
				} else {
					jQuery('.navbar-nav>li.menu-item-has-children:not(.current-menu-parent) >a,.navbar-nav>li.menu-item-has-children:not(.current-menu-parent) >span,.navbar-nav>li.tc-menu-layout-builder:not(.current-menu-parent) >a,.navbar-nav>li.tc-menu-layout-builder:not(.current-menu-parent) >span').after(
						'<span class="icon-toggle"><i class="fa fa-angle-down"></i></span>')
					jQuery('.navbar-nav>li.menu-item-has-children.current-menu-parent >a,.navbar-nav>li.menu-item-has-children.current-menu-parent >span,.navbar-nav>li.tc-menu-layout-builder.current-menu-parent >a,.navbar-nav>li.tc-menu-layout-builder.current-menu-parent >span').after(
						'<span class="icon-toggle"><i class="fa fa-angle-up"></i></span>')
				}
			}

			$(document).on('click', '.menu-mobile-effect', function (e) {
				e.stopPropagation()
				$('body').toggleClass('mobile-menu-open')
			})

			$(document).on('click', '.wrapper-container', function (e) {
				$('body').removeClass('mobile-menu-open')
			})

			$(document).on('click', '.mobile-menu-inner', function (e) {
				e.stopPropagation()
			})

			$('.navbar-nav>li .icon-toggle').on('click', function (e) {
				e.stopPropagation();
				$(this).parent().addClass('thim-ekits-menu__is-hover');
			})

			$('.navbar-nav>li .icon-toggle,.thim-ekits-menu__icon').on('click', function (e) {
				e.stopPropagation();
				$('.mobile-menu-wrapper .icon-menu-back').addClass('show-icon');
			})

			$('.mobile-menu-wrapper .icon-menu-back').on('click', function (e) {
				e.stopPropagation();
				$('.mobile-menu-container > ul >li').removeClass('thim-ekits-menu__is-hover');
				$(this).removeClass('show-icon');
			})
		},

		thim_carousel: function () {
			if (jQuery().owlCarousel) {
				let is_rtl = $('body').hasClass('rtl') ? true : false;
				$('.thim-gallery-images').owlCarousel({
					rtl: is_rtl,
					autoplay: false,
					singleItem: true,
					stopOnHover: true,
					autoHeight: false,
					loop: true,
					loadedClass: 'owl-loaded owl-carousel',
				})

				$('.thim-carousel-wrapper').each(function () {

					var item_visible = $(this).data('visible') ? parseInt(
						$(this).data('visible')) : 4,
						item_desktopsmall = $(this).data('desktopsmall') ? parseInt(
							$(this).data('desktopsmall')) : item_visible,
						itemsTablet = $(this).data('itemtablet') ? parseInt(
							$(this).data('itemtablet')) : 2,
						itemsMobile = $(this).data('itemmobile') ? parseInt(
							$(this).data('itemmobile')) : 1,
						pagination = !!$(this).data('pagination'),
						navigation = !!$(this).data('navigation'),
						autoplay = $(this).data('autoplay') ? parseInt(
							$(this).data('autoplay')) : false,
						margin = $(this).data('margin') ? parseInt(
								$(this).data('margin')) : 0,
						navigation_text = ($(this).data('navigation-text') &&
							$(this).data('navigation-text') === '2') ? [
							'<i class=\'fa fa-long-arrow-left \'></i>',
							'<i class=\'fa fa-long-arrow-right \'></i>',
						] : [
							'<i class=\'fa fa-chevron-left \'></i>',
							'<i class=\'fa fa-chevron-right \'></i>',
						]
					$(this).owlCarousel({
						items: item_visible,
						// itemsDesktop     : [1200, item_visible],
						// itemsDesktopSmall: [1024, item_desktopsmall],
						// itemsTablet      : [768, itemsTablet],
						// itemsMobile      : [480, itemsMobile],
						nav: navigation,
						dots: pagination,
						loop: ($(this).children().length > item_visible) ? true : false,
						rewind: true,
						rtl: is_rtl,
						margin : margin,
						// dots       : true,
						loadedClass: 'owl-loaded owl-carousel',
						navContainerClass: 'owl-nav owl-buttons',
						dotsClass: 'owl-dots owl-pagination',
						dotClass: 'owl-page',
						responsive: {
							0: {
								items: itemsMobile,
								dots: true,
								nav: false
							},
							480: {
								items: itemsTablet
							},
							1024: {
								items: item_desktopsmall
							},
							1200: {
								items: item_visible
							}
						},
						lazyLoad: true,
						autoplay: autoplay,
						navText: navigation_text,
						afterAction: function () {
							var width_screen = $(window).width()
							var width_container = $('#main-home-content').width()
							var elementInstructorCourses = $('.thim-instructor-courses')
							var button_full_left = $('.thim_full_right.thim-event-layout-6')
							if (button_full_left.length) {
								var full_left = (jQuery(window).width() - button_full_left.width()) / 2;
								button_full_left.find('.owl-controls .owl-buttons').css("margin-left", "-" + full_left + "px")
								button_full_left.find('.owl-controls .owl-buttons').css({
									'margin-left': '-' + full_left + 'px',
									'padding-left': full_left + 'px',
									'margin-right': full_left + 'px',
								})
							}
							if (elementInstructorCourses.length) {
								if (width_screen > width_container) {
									var margin_left_value = (width_screen - width_container) / 2
									$('.thim-instructor-courses .thim-course-slider-instructor .owl-controls .owl-buttons').css('left', margin_left_value + 'px')
								}
							}
						}
					})
					thim_eduma.addWrapOwlControls($(this));

				})

				$('.thim-course-slider-instructor').each(function () {
					var item_visible = $(this).data('visible') ? parseInt($(this).data('visible')) : 4,
						item_desktopsmall = $(this).data('desktopsmall') ? parseInt(
							$(this).data('desktopsmall')) : item_visible,
						itemsTablet = $(this).data('itemtablet') ? parseInt(
							$(this).data('itemtablet')) : 2,
						itemsMobile = $(this).data('itemmobile') ? parseInt(
							$(this).data('itemmobile')) : 1,
						pagination = !!$(this).data('pagination'),
						navigation = !!$(this).data('navigation'),
						autoplay = $(this).data('autoplay') ? parseInt(
							$(this).data('autoplay')) : false,
						navigation_text = ($(this).data('navigation-text') &&
							$(this).data('navigation-text') === '2') ? [
							'<i class=\'fa fa-long-arrow-left \'></i>',
							'<i class=\'fa fa-long-arrow-right \'></i>',
						] : [
							'<i class=\'fa fa-chevron-left \'></i>',
							'<i class=\'fa fa-chevron-right \'></i>',
						]

					$(this).owlCarousel({
						items: item_visible,
						rtl: is_rtl,
						// itemsDesktop     : [1400, item_desktopsmall],
						// itemsDesktopSmall: [1024, itemsTablet],
						// itemsTablet      : [768, itemsTablet],
						// itemsMobile      : [480, itemsMobile],
						responsive: {
							0: {
								items: itemsMobile
							},
							480: {
								items: itemsTablet
							},
							1024: {
								items: itemsTablet
							},
							1400: {
								items: item_desktopsmall
							}
						},
						nav: navigation,
						dots: pagination,
						loop: ($(this).children().length > item_visible) ? true : false,
						rewind: true,
						lazyLoad: true,
						autoplay: autoplay,
						navText: navigation_text,
						loadedClass: 'owl-loaded owl-carousel',
						navContainerClass: 'owl-nav owl-buttons',
						dotsClass: 'owl-dots owl-pagination',
						dotClass: 'owl-page',
						afterAction: function () {
							var width_screen = $(window).width()
							var width_container = $('#main-home-content').width()
							var elementInstructorCourses = $('.thim-instructor-courses')

							if (elementInstructorCourses.length) {
								if (width_screen > width_container) {
									var margin_left_value = (width_screen - width_container) / 2
									$('.thim-instructor-courses .thim-course-slider-instructor .owl-controls .owl-buttons').css('left', margin_left_value + 'px')
								}
							}
						}
					})
					thim_eduma.addWrapOwlControls($(this));
				})

				$('.thim-carousel-course-categories .thim-course-slider, .thim-carousel-course-categories-tabs .thim-course-slider').each(function () {

					var item_visible = $(this).data('visible') ? parseInt($(this).data('visible')) : 7,
						item_desktop = $(this).data('desktop') ? parseInt($(this).data('desktop')) : item_visible,
						item_desktopsmall = $(this).data('desktopsmall') ? parseInt($(this).data('desktopsmall')) : 6,
						item_tablet = $(this).data('tablet') ? parseInt($(this).data('tablet')) : 4,
						item_mobile = $(this).data('mobile') ? parseInt($(this).data('mobile')) : 2,
						pagination = !!$(this).data('pagination'),
						navigation = !!$(this).data('navigation'),
						autoplay = $(this).data('autoplay') ? parseInt($(this).data('autoplay')) : false
					$(this).owlCarousel({
						items: item_visible,
						loop: ($(this).children().length > item_visible) ? true : false,
						rewind: true,
						rtl: is_rtl,
						responsive: {

							0: {
								items: item_mobile
							},
							480: {
								items: item_tablet
							},
							1024: {
								items: item_desktopsmall
							},
							1800: {
								items: item_desktop
							}
						},
						nav: navigation,
						dots: pagination,
						loadedClass: 'owl-loaded owl-carousel',
						autoplay: autoplay,
						navContainerClass: 'owl-nav owl-buttons',
						dotsClass: 'owl-dots owl-pagination',
						dotClass: 'owl-page',
						navText: [
							'<i class=\'fa fa-chevron-left \'></i>',
							'<i class=\'fa fa-chevron-right \'></i>',
						],
					})
					thim_eduma.addWrapOwlControls($(this));
				})
				if ($('div').hasClass('cross-sells')) {
					var $product_grid = $('.cross-sells').find('.product-grid'),
						$product_item = $product_grid.find('.product');
					if ($product_item.length > 3) {
						$product_grid.owlCarousel({
							items            : 4,
							loop             : false,
							rewind           : true,
							dots             : true,
							nav              : true,
							margin: 30,
							responsive: 	{
								0   : {
									items : 1,
									margin: 0,
								},
								480 : {
									items : 2,
 									margin: 15,
								},
								768 : {
									items: 3,
								},
								1290: {
									items: 4
								},
							},
 							loadedClass      : 'owl-loaded owl-carousel',
							navContainerClass: 'owl-nav owl-buttons',
							dotsClass        : 'owl-dots owl-pagination',
							dotClass         : 'owl-page',
							autoplay         : false,
							navText          : ['<i class=\'tk tk-angle-left \'></i>',
								'<i class=\'tk tk-angle-right \'></i>',
							],
						})
						thim_eduma.addWrapOwlControls($product_grid);
					}
				}
			}
		},

		thim_gallery: function () {
			$('article.format-gallery .flexslider').imagesLoaded(function () {
				if (jQuery().flexslider) {
					$('.flexslider').flexslider({
						slideshow: true,
						animation: 'fade',
						pauseOnHover: true,
						animationSpeed: 400,
						smoothHeight: true,
						directionNav: true,
						controlNav: false,
					})
				}
			});
			var $container = $('.isotope-layout')
			if ($container.length > 0) {
				$container.each(function () {
					var $this = jQuery(this), $width, $col, $width_unit,
						$height_unit
					var $spacing = 10
					$col = 6
					if ($col != 1) {
						if (parseInt($container.width()) < 768) {
							$col = 4
						}
						if (parseInt($container.width()) < 480) {
							$col = 2
						}

					}
					$width_unit = Math.floor((parseInt($container.width(), 10) -
						($col - 1) * $spacing) / $col)
					$height_unit = Math.floor(parseInt($width_unit, 10))

					$this.find('.item_gallery').css({
						width: $width_unit,
					})
					if ($col == 1) {
						$height_unit = 'auto'
					}
					$this.find('.item_gallery .thim-gallery-popup').css({
						height: $height_unit,
					})
					if ($this.find('.item_gallery').hasClass('size32')) {
						if ($col > 1) {
							$this.find('.item_gallery.size32 .thim-gallery-popup').css({
								height: $height_unit * 2 + $spacing,
							})
						}
					}
					if ($this.find('.item_gallery').hasClass('size32')) {
						if ($col > 3) {
							$width = $width_unit * 4 + $spacing * 3
							$this.find('.item_gallery.size32').css({
								width: $width,
							})
						} else {
							$width = $width_unit * 2 + $spacing * 1
							$this.find('.item_gallery.size32').css({
								width: $width,
							})
						}
					}
					if ($this.find('.item_gallery').hasClass('size22') && $col != 1) {
						$this.find('.item_gallery.size22 .thim-gallery-popup').css({
							height: $height_unit * 2 + $spacing,
						})
					}
					if ($this.find('.item_gallery').hasClass('size22') && $col != 1) {
						$width = $width_unit * 2 + $spacing * 1
						$this.find('.item_gallery.size22').css({
							width: $width,
						})
					}
					if (jQuery().isotope) {
						$this.isotope({
							itemSelector: '.item_gallery',
							masonry: {
								columnWidth: $width_unit,
								gutter: $spacing,
							},
						})
					}
				})
			}
			$(document).on('click', '.thim-gallery-popup', function (e) {
				e.preventDefault()
				var elem = $(this), post_id = elem.attr('data-id'),
					data = { action: 'thim_gallery_popup', post_id: post_id }
				elem.addClass('loading')
				$.post(ajaxurl, data, function (response) {
					elem.removeClass('loading')
					$('.thim-gallery-show').append(response)
					if ($('.thim-gallery-show img').length > 0) {
						$('.thim-gallery-show').magnificPopup({
							mainClass: 'my-mfp-zoom-in',
							type: 'image',
							delegate: 'a',
							showCloseBtn: false,
							gallery: {
								enabled: true,
							},
							callbacks: {
								open: function () {
									$('body').addClass('thim-popup-active')
									$.magnificPopup.instance.close = function () {
										$('.thim-gallery-show').empty()
										$('body').removeClass('thim-popup-active')
										$.magnificPopup.proto.close.call(this)
									}
								},
							},
						}).magnificPopup('open')
					} else {
						$.magnificPopup.open({
							mainClass: 'my-mfp-zoom-in',
							items: {
								src: $('.thim-gallery-show'),
								type: 'inline',
							},
							showCloseBtn: false,
							callbacks: {
								open: function () {
									$('body').addClass('thim-popup-active')
									$.magnificPopup.instance.close = function () {
										$('.thim-gallery-show').empty()
										$('body').removeClass('thim-popup-active')
										$.magnificPopup.proto.close.call(this)
									}
								},
							},
						})
					}
				})
			})
		},

		thim_contentslider: function () {
			$('.thim-testimonial-slider').each(function () {
				var elem = $(this),
					item_visible = parseInt(elem.data('visible')),
					item_time = parseInt(elem.data('time')),
					autoplay = elem.data('auto') ? true : false,
					item_ratio = elem.data('ratio') ? elem.data('ratio') : 1.18,
					item_padding = elem.data('padding') ? elem.data('padding') : 15,
					item_activepadding = elem.data('activepadding') ? elem.data('activepadding') : 0,
					item_width = elem.data('width') ? elem.data('width') : 100,
					mousewheel = !!elem.data('mousewheel')
				if (jQuery().thimContentSlider) {
					var testimonial_slider = $(this).thimContentSlider({
						items: elem,
						itemsVisible: item_visible,
						mouseWheel: mousewheel,
						autoPlay: autoplay,
						pauseTime: item_time,
						itemMaxWidth: item_width,
						itemMinWidth: item_width,
						activeItemRatio: item_ratio,
						activeItemPadding: item_activepadding,
						itemPadding: item_padding,
					})
				}
			})
		},

		counter_box: function () {
			if (jQuery().waypoint) {
				jQuery('.counter-box').waypoint(function () {
					jQuery(this).find('.display-percentage').each(function () {
						var percentage = jQuery(this).data('percentage')
						jQuery(this).countTo({
							from: 0,
							to: percentage,
							refreshInterval: 40,
							speed: 2000,
						})
					})
				}, {
					triggerOnce: true,
					offset: '80%',
				})
			}
		},

		thim_background_gradient: function () {
			var background_gradient = jQuery('.thim_overlay_gradient')
			var background_gradient_2 = jQuery('.thim_overlay_gradient_2')
			if (background_gradient.length) {
				$('.thim_overlay_gradient rs-sbg-px > rs-sbg-wrap > rs-sbg').addClass('thim-overlayed')
			}

			if (background_gradient_2.length) {
				$('.thim_overlay_gradient_2 rs-sbg-px > rs-sbg-wrap > rs-sbg').addClass('thim-overlayed')
			}
		},

		thim_magnificPopup: function () {
			if (jQuery().magnificPopup) {
				$('.thim-single-image-popup,.thim-image-popup').magnificPopup({
					type: 'image',
					zoom: {
						enabled: true,
						duration: 300,
						easing: 'ease-in-out',
					}
				})
				$('.thim-video-popup .button-popup').on('click', function (e) {
					var item = $(this)
					e.preventDefault()
					$.magnificPopup.open({
						items: {
							src: item.parent().parent().find('.video-content'),
							type: 'inline',
						},
						showCloseBtn: false,
						callbacks: {
							open: function () {
								$('body').addClass('thim-popup-active')
								$.magnificPopup.instance.close = function () {
									$('body').removeClass('thim-popup-active')
									$.magnificPopup.proto.close.call(this)
								}
							},
						},
					})
				})
			}
		},

		full_right: function () {
			$('.thim_full_right').each(function () {
				var full_right = (jQuery(window).width() - jQuery(this).width()) / 2;
				jQuery(this).children().css("margin-right", "-" + full_right + "px");
			});
			$('.thim_full_left').each(function () {
				var full_left = (jQuery(window).width() - jQuery(this).width()) / 2;
				jQuery(this).children().css("margin-left", "-" + full_left + "px");
			});
			$('.thim_coundown_full_left').each(function () {
				var full_left = (jQuery(window).width() - jQuery(this).width()) / 2;
				var number = full_left + 'px';
				jQuery(this).find('.thim-widget-countdown-box').parent().css({
					"margin-left": '-' + number,
					"padding-left": number
				});
			});
			$('footer#colophon.has-footer-bottom').css('margin-bottom', $('.footer-bottom').height())

			// Fix RTL row full of VC
			var left_has_fill = parseFloat($('body.rtl .vc_row-has-fill[data-vc-full-width="true"]').css('left')),
				left_no_padding = parseFloat($('body.rtl .vc_row-no-padding[data-vc-full-width="true"]').css('left'))
			if (left_has_fill != 'undefined') {
				$('body.rtl .vc_row-has-fill[data-vc-full-width="true"]').css({ 'right': left_has_fill, 'left': '' })
			}
			if (left_no_padding != 'undefined') {
				$('body.rtl .vc_row-no-padding[data-vc-full-width="true"]').css({ 'right': left_no_padding, 'left': '' })
			}
		},

		thim_course_offline_popup_form_register: function () {
			if ($('#contact-form-registration >.wpcf7').length) {
				var el = $('#contact-form-registration >.wpcf7');
				el.append('<a href="#" class="thim-close fa fa-times"></a>');
			}
			$(document).on('click', '#contact-form-registration .wpcf7-form-control.wpcf7-submit', function () {
				$(document).on('mailsent.wpcf7', function (event) {
					setTimeout(function () {
						$('body').removeClass('thim-contact-popup-active');
						$('#contact-form-registration').removeClass('active');
					}, 3000);
				});
			});
			$(document).on('click', '.course-payment .thim-enroll-course-button', function (e) {
				e.preventDefault();
				$('body').addClass('thim-contact-popup-active');
				$('#contact-form-registration').addClass('active');
			});

			$(document).on('click', '#contact-form-registration', function (e) {
				if ($(e.target).attr('id') == 'contact-form-registration') {
					$('body').removeClass('thim-contact-popup-active');
					$('#contact-form-registration').removeClass('active');
				}
			});

			$(document).on('click', '#contact-form-registration .thim-close', function (e) {
				e.preventDefault();
				$('body').removeClass('thim-contact-popup-active');
				$('#contact-form-registration').removeClass('active');
			});
		},

		course_sidebar_right_offset_top: function () {
			var elementInfoTop = $('.course-info-top');
			if (elementInfoTop.length) {
				var InfoTopHeight = elementInfoTop.innerHeight(),
					elementInfoRight = $('.thim-style-content-layout_style_3 .sticky-sidebar');
				elementInfoRight.css('margin-top', '-' + (InfoTopHeight - 20) + 'px');
			}
		},

		addWrapOwlControls: function (el) {
			const elOwlControls = el.find('.owl-controls');
			if (!elOwlControls.length) {
				el.find('.owl-nav, .owl-dots').wrapAll("<div class='owl-controls'></div>");
			}
		},

		event_click: function () {
			$(document).on('click', '.filter-courses-effect', function (e) {
				e.stopPropagation()
				$('body').toggleClass('mobile-filter-open')
			})
			$(document).on('click', '.filter-column, .close-filter, .widget-area, .course-filter-submit', function (e) {
				$('body').removeClass('mobile-filter-open')
			})
			$(document).on('click', '.filter-course, .widget_course_filter', function (e) {
				e.stopPropagation()
			})
			$(document).on('click', '.button-categories-popup', function (e) {
				e.stopPropagation()
				$('body').toggleClass('categories-popup-open')
			})
			$(document).on('click', '.categories-column, .close-categories', function (e) {
				$('body').removeClass('categories-popup-open')
			})
			$(document).on('click', '.categories-popup', function (e) {
				e.stopPropagation()
			})

			$('.video-container').on('click', '.beauty-intro .btns', function () {
				var iframe = '<iframe src="' + $(this).closest('.video-container').find('.yt-player').attr('data-video') + '" height= "' + $('.parallaxslider').height() + '"></iframe>'
				$(this).closest('.video-container').find('.yt-player').replaceWith(iframe)
				$(this).closest('.video-container').find('.hideClick:first').css('display', 'none')
			})

			// add icon for button show pass
			$('.login-password').append('<span id="show_pass"><i class="fa fa-eye"></i></span>')
			$(document).on('click', '#show_pass', function () {
				var el = $(this), thim_pass = el.parents('.login-password').find('>input')
				if (el.hasClass('active')) {
					thim_pass.attr('type', 'password')
				} else {
					thim_pass.attr('type', 'text')
				}
				el.toggleClass('active')
			})

			// Nav scroll
			$('.navbar-nav li a,.arrow-scroll > a').on('click', function (e) {
				var height = 0,
					sticky_height = jQuery('#masthead').outerHeight(),
					menu_anchor = jQuery(this).attr('href'),
					adminbar_height = jQuery('#wpadminbar').outerHeight();
				if (parseInt(jQuery(window).scrollTop(), 10) < 2) {
					height = 47
				}

				if (menu_anchor && menu_anchor.indexOf('#') == 0 && menu_anchor.length > 1) {
					e.preventDefault()
					$('html,body').animate({
						scrollTop: jQuery(menu_anchor).offset().top - adminbar_height - sticky_height + height,
					}, 850)
				}
			})

			// menu course scroll
			$(document).on('click', '.content_course_2 .course_right .menu_course ul li a, .content_course_2 .thim-course-menu-landing .thim-course-landing-tab li a', function () {
				$('html, body').animate({
					scrollTop: $($(this).attr('href')).offset().top,
				}, 1000)
			})

			// Filter Gallery
			$(document).on('click', '.filter-controls .filter', function (e) {
				e.preventDefault()
				var filter = $(this).data('filter'),
					filter_wraper = $(this).parents('.thim-widget-gallery-posts').find('.wrapper-gallery-filter')
				$('.filter-controls .filter').removeClass('active')
				$(this).addClass('active')
				filter_wraper.isotope({ filter: filter })
			})
			//Background video
			$('.bg-video-play').on('click', function () {
				var elem = $(this),
					video = $(this).parents('.thim-widget-icon-box').find('.full-screen-video'),
					player = video.get(0)
				if (player.paused) {
					player.play()
					elem.addClass('bg-pause')
				} else {
					player.pause()
					elem.removeClass('bg-pause')
				}
			})

			var tab_cat_course = $('.thim-carousel-course-categories-tabs')
			tab_cat_course.each(function () {
				tab_cat_course.find('.thim-course-slider .item').click(function (e) {
					e.preventDefault()
					tab_cat_course.find('.item_content.active').removeClass('active')
					tab_cat_course.find($(this).find('.title a').attr('href')).addClass('active')
					tab_cat_course.find('.thim-course-slider .item.active').removeClass('active')
					$(this).addClass('active')
				})
			})

			//popup category
			var popup_cat = $('.click-show-sub')
			popup_cat.each(function () {
				popup_cat.find('li.has-child').click(function (e) {
					popup_cat.find('li.has-child.active').removeClass('active')
					$(this).addClass('active')
				})
			})

			//Add class for nav-tabs single course
			var tab_course = $('.course-tabs .nav-tabs>li').length
			if (tab_course > 0) {
				$('.course-tabs .nav-tabs>li').addClass('thim-col-' + tab_course)
			}
		},

		/* @ function switch layout
		  * @since 5.3.6 - Move from custom-script-v2.js file
		  * @author tuanta
		*/
		thim_SwitchLayout: function (prefix) {
			var archive = $('#' + prefix + '-archive'),
				cl_click = '.' + prefix + '-switch-layout > a';
			if (archive.length < 0) {
				return;
			}
			var switch_store = localStorage.getItem(prefix + '-layout');
			if (switch_store == 'list-layout') {
				if (archive.hasClass(prefix + '-grid')) {
					archive.removeClass(prefix + '-grid').addClass(prefix + '-list')
				}
				$(cl_click).removeClass('switch-active')
				$('.' + prefix + '-switch-layout .switchToList').addClass('switch-active')
			}
			if (switch_store == 'grid-layout') {
				if (archive.hasClass(prefix + '-list')) {
					archive.removeClass(prefix + '-list').addClass(prefix + '-grid')
				}
				$(cl_click).removeClass('switch-active')
				$('.' + prefix + '-switch-layout .switchToGrid').addClass('switch-active')
			}
			$(cl_click).on('click', function (event) {
				event.preventDefault()
				var elem = $(this);
				if (!elem.hasClass('switch-active')) {
					$(cl_click).removeClass('switch-active')
					elem.addClass('switch-active')
					if (elem.hasClass('switchToGrid')) {
						archive.fadeOut(300, function () {
							archive.removeClass(prefix + '-list').addClass(prefix + '-grid').fadeIn(300)
							localStorage.setItem(prefix + '-layout', 'grid-layout');
						})
					} else {
						archive.fadeOut(300, function () {
							archive.removeClass(prefix + '-grid').addClass(prefix + '-list').fadeIn(300)
							localStorage.setItem(prefix + '-layout', 'list-layout');
						})
					}
				}
			})
		},

		back_to_top: function () {
			if (jQuery(".scroll-circle-progress").length) {
				var progressPath = document.querySelector('.scroll-circle-progress path');
				var pathLength = progressPath.getTotalLength();
				progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
				progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
				progressPath.style.strokeDashoffset = pathLength;
				progressPath.getBoundingClientRect();
				progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
				var updateProgress = function () {
					var scroll = $(window).scrollTop();
					var height = $(document).height() - $(window).height();
					var progress = pathLength - (scroll * pathLength / height);
					progressPath.style.strokeDashoffset = progress;
				}
				updateProgress();
				$(window).scroll(updateProgress);
			}
			jQuery(window).scroll(function () {
				if (jQuery(this).scrollTop() > 100) {
					jQuery('#back-to-top').addClass('active')
				} else {
					jQuery('#back-to-top').removeClass('active')
				}
			})
			jQuery('#back-to-top').on('click', function () {
				jQuery('html, body').animate({scrollTop: '0px'}, 500)
				return false
			})
		},

		StickySidebar: function () {
			var offsetTop = 20
			if ($('#wpadminbar').length) {
				offsetTop += $('#wpadminbar').outerHeight()
			}
			if ($('#masthead.sticky-header').length) {
				offsetTop += $('#masthead.sticky-header').outerHeight()
			}
			jQuery('#sidebar.sticky-sidebar').theiaStickySidebar({
				'containerSelector': '',
				'additionalMarginTop': offsetTop,
				'additionalMarginBottom': '0',
				'updateSidebarHeight': false,
				'minWidth': '768',
				'sidebarBehavior': 'modern',
			})
		},
		/* ****** PRODUCT QUICK VIEW  ******/
		product_quick_view: function () {
			$(document).on('click', '.quick-view', function (e) {
				$('.quick-view a').css('display', 'none')
				$(this).append('<a href="javascript:;" class="loading dark"></a>')
				var product_id = $(this).attr('data-prod')
				var data = { action: 'jck_quickview', product: product_id }
				$.post(ajaxurl, data, function (response) {
					$.magnificPopup.open({
						mainClass: 'my-mfp-zoom-in',
						items: {
							src: response,
							type: 'inline',
						},
						callbacks: {
							open: function () {
								$('body').addClass('thim-popup-active')
								$.magnificPopup.instance.close = function () {
									$('body').removeClass('thim-popup-active')
									$.magnificPopup.proto.close.call(this)
								}
							},
						},
					})
					$('.quick-view a').css('display', 'inline-block')
					$('.loading').remove()
					$('.product-card .wrapper').removeClass('animate')
					setTimeout(function () {
						if (typeof wc_add_to_cart_variation_params !==
							'undefined') {
							$('.product-info .variations_form').each(function () {
								$(this).wc_variation_form().find('.variations select:eq(0)').change()
							})
						}
					}, 600)
				})
				e.preventDefault()
			})
		},

		thimLiveCourseSearch: function () {

		},
		submit_form_validate: function () {
			$('form#bbp-search-form').submit(function () {
				if ($.trim($('#bbp_search').val()) === '') {
					$('#bbp_search').focus()
					return false
				}
			})

			$('form.search-form').submit(function () {
				var input_search = $(this).find('input[name=\'s\']')
				if ($.trim(input_search.val()) === '') {
					input_search.focus()
					return false
				}
			})

			//Validate comment form submit
			$('form#commentform').submit(function (event) {
				var elem = $(this),
					comment = elem.find('#comment[aria-required="true"]'),
					author = elem.find('#author[aria-required="true"]'),
					url = elem.find('#url[aria-required="true"]'),
					email = elem.find('#email[aria-required="true"]'),
					valid_email = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm

				if (author.length > 0 && author.val() == '') {
					author.addClass('invalid')
					event.preventDefault()
				}

				if (comment.length > 0 && comment.val() == '') {
					comment.addClass('invalid')
					event.preventDefault()
				}

				if (url.length > 0 && url.val() == '') {
					url.addClass('invalid')
					event.preventDefault()
				}

				if (email.length > 0 &&
					(email.val() == '' || !valid_email.test(email.val()))) {
					email.addClass('invalid')
					event.preventDefault()
				}
			})

			$('input.wpcf7-text, textarea.wpcf7-textarea').on('focus', function () {
				if ($(this).hasClass('wpcf7-not-valid')) {
					$(this).removeClass('wpcf7-not-valid')
				}
			})

			//wpcf7-form-submit
			$(document).on('click', '.wpcf7-form-control.wpcf7-submit', function () {
				var elem = $(this), form = elem.parents('.wpcf7-form')
				form.addClass('thim-sending')
				$(document).on('invalid.wpcf7', function (event) {
					form.removeClass('thim-sending')
				})
				$(document).on('spam.wpcf7', function (event) {
					form.removeClass('thim-sending')
					setTimeout(function () {
						if ($('.wpcf7-response-output').length > 0) {
							$('.wpcf7-response-output').hide()
						}
					}, 4000)
				})
				$(document).on('mailsent.wpcf7', function (event) {
					form.removeClass('thim-sending')
					setTimeout(function () {
						if ($('.wpcf7-response-output').length > 0) {
							$('.wpcf7-response-output').hide()
						}
					}, 4000)

				})
				$(document).on('mailfailed.wpcf7', function (event) {
					form.removeClass('thim-sending')
					setTimeout(function () {
						if ($('.wpcf7-response-output').length > 0) {
							$('.wpcf7-response-output').hide()
						}
					}, 4000)
				})
			})

			$('.mc4wp-form #mc4wp_email').on('focus', function () {
				$(this).parents('.mc4wp-form').addClass('focus-input')
			}).on('focusout', function () {
				$(this).parents('.mc4wp-form.focus-input').removeClass('focus-input')
			})
		},
		waypoint_js: function () {
			/* Waypoints magic ---------------------------------------------------------- */
			if (typeof jQuery.fn.waypoint !== 'undefined') {
				jQuery('.wpb_animate_when_almost_visible:not(.wpb_start_animation)').waypoint(function () {
					jQuery(this).addClass('wpb_start_animation')
				}, { offset: '85%' })
			}
		},
		course_menu_landing: function () {
			if ($('.thim-course-menu-landing').length > 0) {
				var menu_landing = $('.thim-course-menu-landing'), tab_course = $('#learn-press-course-tabs .nav-tabs')

				var tab_active = tab_course.find('>li.active'),
					tab_item = tab_course.find('>li>a'),
					tab_landing = menu_landing.find('.thim-course-landing-tab'),
					tab_landing_item = tab_landing.find('>li>a'),
					landing_Top = ($('#course-landing').length) > 0 ? $('#course-landing').offset().top : 0,
					checkTop = ($(window).height() > landing_Top) ? $(window).height() : landing_Top

				$('footer#colophon').addClass('has-thim-course-menu')
				if (tab_active.length > 0) {
					var active_href = tab_active.find('>a').attr('href'),
						landing_active = tab_landing.find('>li>a[href="' + active_href + '"]')

					if (landing_active.length > 0) {
						landing_active.parent().addClass('active')
					}
				}

				tab_landing_item.on('click', function (event) {
					event.preventDefault()

					var href = $(this).attr('href'),
						parent = $(this).parent()

					if (!parent.hasClass('active')) {
						tab_landing.find('li.active').removeClass('active')
						parent.addClass('active')
					}

					if (tab_course.length > 0) {
						tab_course.find('>li>a[href="' + href + '"]').trigger('click')

						$('body, html').animate({
							scrollTop: tab_course.offset().top - 50,
						}, 800)
					} else {
						$('body, html').animate({
							scrollTop: $($.attr(this, 'href')).offset().top,
						}, 500)
					}
				})

				tab_item.on('click', function () {
					var href = $(this).attr('href'),
						parent_landing = tab_landing.find('>li>a[href="' + href +
							'"]').parent()

					if (!parent_landing.hasClass('active')) {
						tab_landing.find('li.active').removeClass('active')
						parent_landing.addClass('active')
					}
				})

				$(window).scroll(function () {
					if ($(window).scrollTop() > checkTop) {
						$('body').addClass('course-landing-active')
					} else {
						$('body.course-landing-active').removeClass('course-landing-active')
					}
				})
			}
		},
		product_gallery: function () {
			if (($('#carousel').length > 0) && (jQuery().flexslider)) {
				// The slider being synced must be initialized first
				jQuery('#carousel').flexslider({
					animation    : "slide",
					controlNav   : false,
					animationLoop: false,
					slideshow    : false,
					itemWidth    : 125,
					itemMargin   : 15,
					asNavFor     : '#slider'
				});

				jQuery('#slider').flexslider({
					animation    : "slide",
					controlNav   : false,
					animationLoop: false,
					slideshow    : false,
					sync         : "#carousel"
				});
			}
		}
	}

	$(document).ready(function () {
		thim_eduma.ready();

		$(window).resize(function () {
			thim_eduma.resize()
		})

	})

	$(window).on('load', function () {
		thim_eduma.load();
		setTimeout(function () {
			// TitleAnimation.initialize()
			thim_eduma.course_menu_landing()
		}, 400)
		if ($(window).width() > 767) {
			thim_min_height_carousel($('.thim-grid-posts .item-post'))
		}
		$(window).resize(function () {
			$('.thim-carousel-instructors .instructor-item').css('min-height', '')
			$('body.thim-demo-university-4 .thim-about-eduma, body.thim-demo-university-4 .thim-video-popup .video-info').css('min-height', '')
			if ($(window).width() < 767 || $(window).width() > 1200) {
				$('body.thim-demo-university-4 #sb_instagram .sbi_photo').css('min-height', '')
			}

			thim_min_height_carousel($('.thim-owl-carousel-post:not(.layout-3) .image'))
			thim_min_height_carousel($('.thim-row-bg-border-top .thim-bg-border-top'))
			thim_min_height_carousel_old($('.thim-carousel-instructors .instructor-item'))
			thim_min_height_carousel_old($('.thim-testimonial-carousel-kindergarten .item'))

			thim_min_height_carousel($('.thim-widget-carousel-categories .item'))
			thim_min_height_carousel($('.elementor-widget-thim-carousel-categories .item'))

			thim_min_height_content_area()
			if ($(window).width() > 767) {
				thim_min_height_carousel($('.thim-grid-posts .item-post'))
				thim_min_height_carousel($('body.thim-demo-university-4 .thim-about-eduma, body.thim-demo-university-4 .thim-video-popup .video-info'))
			}

			if ($(window).width() > 767 && $(window).width() < 1200) {
				if ($('body.thim-demo-university-4 .thim-icon-our-programs').length) {
					var min_height = parseInt($(
						'body.thim-demo-university-4 .thim-icon-our-programs').outerHeight() / 3)
					$('body.thim-demo-university-4 #sb_instagram .sbi_photo').css('min-height', min_height)
				}
			}
		})
		thim_min_height_carousel('.thim-carousel-instructors', '.instructor-item')
		thim_min_height_carousel('.thim-owl-carousel-post', '.image')
		thim_min_height_content_area()
	})
	//
	function thim_min_height_carousel_old($selector) {
		var min_height = 0
		$selector.each(function (index, val) {
			if ($(this).outerHeight() > min_height) {
				min_height = $(this).outerHeight()
			}
			if (index + 1 == $selector.length) {
				$selector.css('min-height', min_height)
			}
		})
	}

	function thim_min_height_carousel(el, child) {
		var $elements = $(el)

		$elements.each(function () {
			var $element = $(this),
				$child = child ? $element.find(child) : $element.children(),
				maxHeight = 0

			$child.each(function () {
				var thisHeight = $(this).outerHeight()
				if (thisHeight > maxHeight) {
					maxHeight = thisHeight
				}
			}).css('min-height', maxHeight)
		})
	}

	function thim_min_height_content_area() {
		var content_area = $('#main-content .content-area'),
			footer = $('#main-content .site-footer'),
			winH = $(window).height()
		if (content_area.length > 0 && footer.length > 0) {
			content_area.css('min-height', winH - footer.height())
		}
	}

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/thim-carousel-post.default',
			thim_eduma.thim_carousel)
		elementorFrontend.hooks.addAction('frontend/element_ready/thim-twitter.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-courses.default',
			thim_eduma.thim_carousel);

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-list-event.default',
			thim_eduma.thim_carousel);

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-course-categories.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-our-team.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-gallery-images.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-list-instructors.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-testimonials.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-courses-collection.default',
			thim_eduma.thim_carousel)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-testimonials.default',
			thim_eduma.thim_contentslider)

		elementorFrontend.hooks.addAction('frontend/element_ready/thim-counters-box.default',
			thim_eduma.counter_box)

		elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
			var $carousel = $scope.find('.owl-carousel')
			if ($carousel.length) {
				var carousel = $carousel.data('owlCarousel')
				carousel && carousel.reload()
			}
		})
	})
})(jQuery)
