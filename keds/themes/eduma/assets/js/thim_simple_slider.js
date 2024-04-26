(function ($) {
	$.fn.extend({

		thim_simple_slider: function (options) {

			// Default options for slider
			var defaults = {
				item        : 3,
				itemActive  : 1,
				itemSelector: '.item-event',
				align       : 'left',
				navigation  : true,
				pagination  : true,
				height      : 400,
				activeWidth : 1170,
				itemWidth   : 800,
				prev_text   : 'Prev',
				next_text   : 'Next'
			};

			var options = $.extend(defaults, options);

			return this.each(function () {
				var opts = options;

				// get thim_simple_slider
				var obj = $(this);

				// Get item selector
				var items = $(opts.itemSelector, obj),
					count_item = items.length,
					current_item = opts.itemActive - 1,
					loaded = false;


				obj.wrapInner('<div class="thim-simple-wrapper ' + opts.align + '"><div class="wrapper"></div></div>');

				var simple_wrapper = $(".thim-simple-wrapper", obj),
					wrapper = simple_wrapper.find(".wrapper"),
					activeWidth = opts.activeWidth,
					itemWidth = opts.itemWidth;

				_parseItems(items);

				var item_slider = simple_wrapper.find(".simple-item");


				simple_wrapper.css('height', opts.height);
				$('.simple-item', obj).css('height', opts.height);
				//wrapper.css({'height': dimension.height});

				_updatePosition();
				_navEvent();
				_pagiEvent();

				//Event for navigation
				function _navEvent() {
					loaded = true;
					if (opts.navigation) {
						simple_wrapper.append('<div class="navigation"><div data-nav="prev" class="control-nav prev">'+opts.prev_text+'</div><div data-nav="next" class="control-nav next">'+opts.next_text+'</div></div>');
					}else{
						return;
					}
					$('.control-nav', obj).on('click', function () {
						var data_nav = $(this).data('nav');
						if (data_nav == 'prev') {
							_prevItem();
						} else {
							_nextItem();
						}
					});
				}


				//Event for pagination
				function _pagiEvent() {
					if (opts.pagination) {
						var pagi_html = '<div class="pagination">';
						for ( var i = 0; i < count_item ; i++) {
							if( i === current_item ) {
								pagi_html += '<div class="item active"></div>';
							}else{
								pagi_html += '<div class="item"></div>';
							}

						}
						pagi_html += '</div>';

						simple_wrapper.append(pagi_html);
					}else{
						return;
					}

					$('.pagination .item', obj).on('click', function ( e ) {
						if( $(this).hasClass('active')) {
							e.preventDefault();
						}
						var index = $( ".pagination .item" ).index( this );
						$('.pagination .item', obj).removeClass('active');
						$(this).addClass('active');
						current_item = index;
						_updatePosition();
					});
				}


				function _updatePosition() {
					if( loaded ) {
						item_slider.removeClass('active-item').css({'width': '', 'opacity': ''});
						item_slider.eq(current_item).addClass('active-item').css({'width': activeWidth}).animate({
							'opacity': 0.2
						}, 300, function(){
							item_slider.eq(current_item).animate({
								'opacity': 1
							}, 500);
						})
					}
					var list_item = $('.simple-item:not(.active-item)', obj);
					//Set width for items
					if( opts.align == 'left' ) {
						item_slider.eq(current_item).css({'width':activeWidth, 'left': ''});
					}else{
						item_slider.eq(current_item).css({'width':activeWidth, 'right': ''});
					}

					list_item.css('width', itemWidth);

					var right_pos = activeWidth;
					for ( var i = current_item; i < list_item.length; i++) {
						var elem = list_item.eq(i);
						if( opts.align == 'left' ) {
							elem.css('left', right_pos);
						}else{
							elem.css('right', right_pos);
						}
						right_pos = right_pos + itemWidth;
					}
					if( current_item > 0 ) {
						for ( var i = 0 ; i < current_item ; i++) {
							var elem = list_item.eq(i);
							if( opts.align == 'left' ) {
								elem.css('left', right_pos);
							}else{
								elem.css('right', right_pos);
							}
							right_pos = right_pos + itemWidth;
						}
					}

					if( opts.pagination ) {
						$('.pagination .item', obj).removeClass('active').eq(current_item).addClass('active');
					}
				}


				function _nextItem() {
					if (current_item < count_item - 1) {
						current_item = current_item + 1;
					} else {
						current_item = 0;
					}
					_updatePosition();
				};

				function _prevItem() {
					if (current_item > 0) {
						current_item = current_item - 1;
					} else {
						current_item = count_item - 1;
					}
					_updatePosition();
				}

				function _parseItems($items) {
					$items.each(function (key, val) {
						if (key == current_item) {
							$(val).wrap('<div class="simple-item active-item"></div>');
						} else {
							$(val).wrap('<div class="simple-item"></div>');
						}
					});
				}
			});
		}
	});
})(jQuery);