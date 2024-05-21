(function ($) {
    'use strict';

    $(document).ready(function () {
        var url_ajax = thim_theme_update.admin_ajax;
        var action = thim_theme_update.action;
        var i18l = thim_theme_update.i18l;

        // $(document).on('click', '.tc-login-envato', function (e) {
        //     e.preventDefault();
		//
        //     var $btn = $('.tc-registration-wrapper .activate-btn');
        //     if ($btn.length) {
        //         $btn.click();
        //     }
        // });
		//
        // $(document).on('click', '.tc-button-deregister', function (e) {
        //     e.preventDefault();
		//
        //     var confirm = window.confirm(i18l.confirm_deregister);
        //     if (!confirm) {
        //         return;
        //     }
		//
        //     window.location.href = thim_theme_update.url_deregister;
        // });

        $(document).on('click', '.tc-update-now', function () {
            var $button = $(this);
            var $notice = $button.closest('.has-update');
            var $p = $notice.find('.update-message');

            $notice.addClass('updating-theme');
            $p.text(i18l.updating);

            request_update_theme()
                .success(
                    function (response) {
                        var success = response.success || false;
                        var messages = response.data;

                        if (success) {
                            var version = response.data;
                            $('.box-info-update .h5').text(i18l.updated);
                            $('.box-info-update p').text(i18l.text_version +' ' + version);
                            $('.tc-header .version').text(version);
                            $p.remove();
                            var $notification_count = $('.theme-count-notification');
                           	var count = $notification_count.data('count') - 1;
							// console.log(count);
							if (count > 0) {
								$notification_count.find('.theme-count').text(count);
							} else {
								$notification_count.remove();
							}
                         } else if (messages.length && !success) {
                            var html = '';
                            messages.forEach(function (string) {
                                html += '<div>' + string + '</div>';
                            });

                            $p.html(html);
                        } else {
                            $p.html(i18l.wrong);
                        }

                        if (success) {
                            $notice.addClass('no-update');
							$notice.removeClass('has-update');
                          } else {
							$p.addClass('notice-error');
                        }
                    }
                )
                .error(
                    function (error) {
                        $p.html(i18l.wrong);
						$p.addClass('notice-error');
                    }
                )
                .complete(
                    function () {
                        window.onbeforeunload = null;
                        $notice.removeClass('updating-theme');
                    }
                );
        });

        function request_update_theme() {
            var nonce = thim_theme_update.nonce;

            window.onbeforeunload = function () {
                return i18l.warning_leave;
            };

            return $.ajax({
                url: url_ajax,
                method: 'POST',
                data: {
                    action: action,
                    nonce: nonce
                },
                dataType: 'json'
            });
        }
    });
})(jQuery);
