(function ($) {
	'use strict'
	//Widget live search course
	var search_timer = false

	function thimlivesearch(contain) {
		var input_search = contain.find('.courses-search-input'),
			list_search = contain.find('.courses-list-search'),
			keyword = input_search.val(),
			loading = contain.find('.fa-search,.fa-times')

		if (keyword) {
			if (keyword.length < 1) {
				return
			}
			loading.addClass('fa-spinner fa-spin')
			$.ajax({
				type   : 'POST',
				data   : 'action=courses_searching&keyword=' + keyword + '&from=search',
				url    : ajaxurl,
				success: function (html) {
					var data_li = ''
					var see_more = ''
					var items = jQuery.parseJSON(html)
					if (!items.error) {
						$.each(items, function (index) {
							if (index == 0) {
								if (this['guid'] != '#') {
									data_li += '<li class="search-item ui-menu-item' +
										this['id'] +
										'"><a class="ui-corner-all" href="' +
										this['guid'] + '">' + this['title'] +
										'</a></li>'
								} else {
									data_li += '<li class="search-item ui-menu-item">' +
										this['title'] + '</li>'
								}

							} else {
								if (index == items.length - 1 && this['see_more']) {
									see_more = this['see_more']
								} else {
									data_li += '<li class="search-item ui-menu-item' +
										this['id'] +
										'"><a class="ui-corner-all" href="' +
										this['guid'] + '">' + this['title'] +
										'</a></li>'
								}
							}
						})
						list_search.addClass('search-visible').html('').append(data_li)
						if (see_more) {
							list_search.append('<li class="see-more">' + see_more + '</li>')
						}
					}
					thimsearchHover()
					thimsearchSeemore()
					loading.removeClass('fa-spinner fa-spin')
				},
				error  : function (html) {
				},
			})
		}
	}

	function thimsearchHover() {
		$('.courses-list-search .search-item').on('mouseenter', function () {
			$('.courses-list-search .search-item').removeClass('ob-selected')
			$(this).addClass('ob-selected')
		})
		$('.courses-list-search .search-item').on('mouseleave', function () {
			$('.courses-list-search .search-item').removeClass('ob-selected')
		})
	}

	function thimsearchSeemore() {
		if ($('.search-item').length > 0) {
			$('.see-more').show();
		}
		$('.see-more').on('click', function (e) {
			$('.courses-searching form').submit();
		});
	}

	$(document).ready(function () {
		$(document).on('click', '.thim-course-search-overlay .search-toggle',
			function (e) {
				e.stopPropagation()
				var parent = $(this).parent()
				$('body').addClass('thim-search-active')
				setTimeout(function () {
					parent.find('.thim-s').focus()
				}, 500)

			})
		$(document).on('click', '.search-popup-bg', function () {
			var parent = $(this).parent()
			window.clearTimeout(search_timer)
			parent.find('.courses-list-search').empty()
			parent.find('.thim-s').val('')
			$('body').removeClass('thim-search-active')
		})

		$(document).on('keyup', '.courses-search-input', function (event) {
			clearTimeout($.data(this, 'search_timer'))
			var contain = $(this).parents('.courses-searching'),
				list_search = contain.find('.courses-list-search'),
				item_search = list_search.find('>li')
			if (event.which == 13) {
				event.preventDefault()
				$(this).stop()
			} else if (event.which == 38) {
				if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(
					navigator.userAgent.substring(navigator.userAgent.indexOf(
						'Chrome') + 7).split(' ')[0]) >= 15) {
					var selected = item_search.filter('.ob-selected')
					if (item_search.length > 1) {
						item_search.removeClass('ob-selected')
						// if there is no element before the selected one, we select the last one
						if (selected.prev().length == 0) {
							selected.siblings().last().addClass('ob-selected')
						} else { // otherwise we just select the next one
							selected.prev().addClass('ob-selected')
						}
					}
				}
			} else if (event.which == 40) {
				if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(
					navigator.userAgent.substring(navigator.userAgent.indexOf(
						'Chrome') + 7).split(' ')[0]) >= 15) {
					var selected = item_search.filter('.ob-selected')
					if (selected.length == 0) {
						selected = item_search.first()
						selected.addClass('ob-selected')
					} else {
						if (item_search.length > 1) {
							item_search.removeClass('ob-selected')
							// if there is no element before the selected one, we select the last one
							if (selected.next().length == 0) {
								selected.siblings().first().addClass('ob-selected')
							} else { // otherwise we just select the next one
								selected.next().addClass('ob-selected')
							}
						}
					}
				}
			} else if (event.which == 27) {
				if ($('body').hasClass('thim-search-active')) {
					$('body').removeClass('thim-search-active')
				}
				list_search.html('')
				$(this).val('')
				$(this).stop()
			} else {
				var search_timer = setTimeout(function () {
					thimlivesearch(contain)
				}, 500)
				$(this).data('search_timer', search_timer)
			}
		})
		$(document).on('keypress', '.courses-search-input', function (event) {
			var item_search = $(this).parents('.courses-searching').find('.courses-list-search>li')
			if (event.keyCode == 13) {
				var selected = item_search.filter('.ob-selected')
				if (selected.length > 0) {
					event.preventDefault()
					var ob_href = selected.find('a').first().attr('href')
					window.location.href = ob_href
				}
			}
			if (event.keyCode == 27) {
				if ($('body').hasClass('thim-search-active')) {
					$('body').removeClass('thim-search-active')
				}
				$('.courses-list-search').html('')
				$(this).val('')
				$(this).stop()
			}
			if (event.keyCode == 38) {
				var selected = item_search.filter('.ob-selected')
				// if there is no element before the selected one, we select the last one
				if (item_search.length > 1) {
					item_search.removeClass('ob-selected')
					if (selected.prev().length == 0) {
						selected.siblings().last().addClass('ob-selected')
					} else { // otherwise we just select the next one
						selected.prev().addClass('ob-selected')
					}
				}
			}
			if (event.keyCode == 40) {
				var selected = item_search.filter('.ob-selected')
				if (selected.length == 0) {
					selected = item_search.first()
					selected.addClass('ob-selected')
				} else {
					if (item_search.length > 1) {
						item_search.removeClass('ob-selected')
						// if there is no element before the selected one, we select the last one
						if (selected.next().length == 0) {
							selected.siblings().first().addClass('ob-selected')
						} else { // otherwise we just select the next one
							selected.next().addClass('ob-selected')
						}
					}
				}
			}
		})

		$(document).on('click', '.courses-list-search, .courses-search-input',
			function (event) {
				event.stopPropagation()
			})

		$(document).on('click', 'body', function () {
			if (!$('body').hasClass('course-scroll-remove')) {
				$('body').addClass('course-scroll-remove')
				$('.courses-list-search').html('')
			}
		})

		$(window).scroll(function () {
			if ($('body').hasClass('course-scroll-remove') &&
				$('.courses-list-search li').length > 0) {
				$('.courses-searching .courses-list-search').empty()
				$('.courses-searching .thim-s').val('')
			}
		})

		$(document).on('focus', '.courses-search-input', function () {
			if ($('body').hasClass('course-scroll-remove')) {
				$('body').removeClass('course-scroll-remove')
			}
		})

		//Prevent search result
		$(document).on('click', '#popup-header .search-visible', function (e) {
			var href = $(e.target).attr('href')
			if (!href) {
				$('#popup-header .search-visible').removeClass('search-visible')
			}

		})

		$(document).on('click', '#popup-header button', function (e) {
			$('#popup-header .thim-s').trigger('focus')

		})

		$(document).on('focus', '#popup-header .thim-s', function () {
			var link = $('#popup-header .courses-list-search a')

			if ($(this).val() != '' && link.length > 0) {
				$('#popup-header .courses-list-search').addClass('search-visible')
			}
		})
	})
})(jQuery)
