(function ($) {
	'use strict'

    function thim_course_filter () {
		let $body = $('body')

		if (!$body.hasClass('learnpress') || !$body.hasClass('archive')) {
			return
		}

		let ajaxCall = function (data) {
			return $.ajax({
				url       : $('#lp-archive-courses').data('allCoursesUrl'), //using for course category page
				type      : 'POST',
				data      : data,
				dataType  : 'html',
				beforeSend: function () {
					$('#thim-course-archive').addClass('loading')
				},
			}).fail(function () {
				$('#thim-course-archive').removeClass('loading')
			}).done(function (data) {
				/*if (typeof history.pushState === 'function') {
				  history.pushState(orderby, null, url);
				}*/
				let $document = $($.parseHTML(data))

				$('#thim-course-archive').replaceWith($document.find('#thim-course-archive'))
				$('.learn-press-pagination').html($document.find('.learn-press-pagination').html() || '')
				$('.thim-course-top .course-index span').replaceWith($document.find('.thim-course-top .course-index span'))
			})
		}

		let sendData = {
			s             : '',
			ref           : 'course',
			post_type     : 'lp_course',
			course_orderby: 'newly-published',
			course_paged  : 1,
		}

		/*
		* Handle courses sort ajax
		* */
		$(document).on('change', '.thim-course-order > select', function () {
			sendData.s = $('.courses-searching .course-search-filter').val()
			sendData.course_orderby = $(this).val()
			sendData.course_paged = 1

			ajaxCall(sendData)
		})

		/*
		* Handle pagination ajax
		* */
		var filterCategoryId = 0;
		$(document).on('click', '#lp-archive-courses .learn-press-pagination a.page-numbers', function (e) {
			e.preventDefault()
            console.log('object');

			// Check is page category of course
			var body = $('body');
			if (body.hasClass('archive') && body.hasClass('tax-course_category') &&
				'thim-body' === body.attr('id')) {
				var regexCheckCourseCategoryId = new RegExp('term-([0-9]+)');

				$.each(document.getElementsByTagName('body')[0].classList,
					function (i, e) {
						var match = regexCheckCourseCategoryId.exec(e);

						console.log(match);

						if (match && undefined != match[1]) {
							filterCategoryId = match[1];
							return;
						}
					});
			}

			$('html, body').animate({
				'scrollTop': $('.site-content').offset().top - 140,
			}, 1000)

			let pageNum = parseInt($(this).text()),
				paged = pageNum ? pageNum : 1,
				cateArr = [], instructorArr = [],
				cpage = $('.learn-press-pagination.navigation.pagination ul.page-numbers li span.page-numbers.current').text(),
				isNext = $(this).hasClass('next') && $(this).hasClass('page-numbers'),
				isPrev = $(this).hasClass('prev') && $(this).hasClass('page-numbers')
			if (!pageNum) {
				if (isNext) {
					paged = parseInt(cpage) + 1
				}
				if (isPrev) {
					paged = parseInt(cpage) - 1
				}
			}

			$('form.thim-course-filter').find('input.filtered').each(function () {
				switch ($(this).attr('name')) {
					case 'term_id':
						cateArr.push($(this).val())
						break
					case 'c_authors':
						instructorArr.push($(this).val())
						break
					case 'sort_by':
						sendData.course_price_filter = $(this).val()
						break
					default:
						break
				}
			})

			if ($body.hasClass('category') && $('.list-cate-filter').length <= 0) {
				let bodyClass = $body.attr('class'),
					cateClass = bodyClass.match(/category\-\d+/gi)[0],
					cateID = cateClass.split('-').pop()

				cateArr.push(cateID)
			}

			if (cateArr.length === 0 && filterCategoryId) {
				cateArr.push(filterCategoryId);
			}

			sendData.course_cate_filter = cateArr
			sendData.course_instructor_filter = instructorArr

			sendData.s = $('.courses-searching .course-search-filter').val()
			sendData.course_orderby = $('.thim-course-order > select').val()
			sendData.course_paged = paged

			ajaxCall(sendData)
		})

		/*
		* Handle filter form click ajax
		* */
		$('form.thim-course-filter').on('submit', function (e) {
			e.preventDefault()

			let formData = $(this).serializeArray(),
				cateArr = [], instructorArr = []

			if (!formData.length) {
				return
			}

			$('html, body').animate({
				'scrollTop': $('.site-content').offset().top - 140,
			}, 1000)

			$(this).find('input').each(function () {
				let form_input = $(this)
				form_input.removeClass('filtered')

				if (form_input.is(':checked')) {
					form_input.addClass('filtered')
				}
			})

			$.each(formData, function (index, filter) {
				switch (filter.name) {
					case 'term_id':
						cateArr.push(filter.value)
						break
					case 'c_authors':
						instructorArr.push(filter.value)
						break
					case 'sort_by':
						sendData.course_price_filter = filter.value
						break
					default:
						break
				}
			})

			if ($body.hasClass('tax-course_category') && $('.list-cate-filter').length <= 0) {
				let bodyClass = $body.attr('class'),
					cateClass = bodyClass.match(/term\-\d+/gi)[0],
					cateID = cateClass.split('-').pop()

				cateArr.push(cateID)
			}

			sendData.course_cate_filter = cateArr
			sendData.course_instructor_filter = instructorArr
			sendData.course_paged = 1

			ajaxCall(sendData)
		})
    }

    //Course archive search filter
    function thim_course_search (){
        var search_time_out = null
        $(document).on('keydown', 'body:not(.course-filter-active) .course-search-filter',
            function (event) {
              if (event.ctrlKey) {
                return
              }

              if (event.keyCode === 13) {
                event.preventDefault()
                return false
              }

              if ((event.keyCode >= 48 && event.keyCode <= 90) || event.keyCode === 8 || event.keyCode === 32) {
                var elem = $(this),
                    keyword = event.keyCode === 8 ? elem.val() : elem.val() + event.key,
                    $body = $('body')

                if (search_time_out != null) clearTimeout(search_time_out)

                search_time_out = setTimeout(function () {
                  elem.attr('disabled', 'disabled')
                  search_time_out = null

                  $('#thim-course-archive').addClass('loading')

                  var archive = elem.parents('#lp-archive-courses'),
                      cateArr = []

                  if ($body.hasClass('category')) {
                    var bodyClass = $body.attr('class'),
                        cateClass = bodyClass.match(/category\-\d+/gi)[0],
                        cateID = cateClass.split('-').pop()

                    cateArr.push(cateID)
                  }

                  if ($('.list-cate-filter').length > 0) {
                    $('.list-cate-filter input.filtered').each(function () {

                      if ($(this).val() !== cateID) {
                        cateArr.push($(this).val())
                      }
                    })
                  }

                  $.ajax({
                    url     : $('#lp-archive-courses').data('allCoursesUrl'),
                    type    : 'POST',
                    dataType: 'html',
                    data    : {
                      s                 : keyword,
                      ref               : 'course',
                      post_type         : 'lp_course',
                      course_orderby    : $('.thim-course-order > select').val(),
                      course_cate_filter: cateArr,
                      course_paged      : 1,
                    },
                    success : function (html) {
                      var archive_html = $(html).find('#lp-archive-courses').html()
                      archive.html(archive_html)
                      $('.course-search-filter').val(keyword).trigger('focus')
                      $body.removeClass('course-filter-active')
                      $('.filter-loading').remove()
                    },
                    error   : function () {
                      $body.removeClass('course-filter-active')
                      $('.filter-loading').remove()
                    },
                  })
                }, 1000)
            }
        })
    }

    $(document).ready(function () {
		thim_course_filter();
        thim_course_search();
	})

})(jQuery);
