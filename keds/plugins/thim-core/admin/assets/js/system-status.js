(function ($) {
    $(document).ready(function () {
        var clipboard = new Clipboard('.btn-copy-system-status');
        var $button = $('.btn-copy-system-status');
        var $text = $('#tc_draw_system_status');

        clipboard.on('success', function (e) {
            $text.removeClass('copy-text');
            $('.btn-copy-container').addClass('copied');
            $button.addClass('copied');
            setTimeout(function () {
                $button.removeClass('copied');
            }, 1000);
        });

        $('.btn-copy-container .tc-close').on('click', function () {
            $text.addClass('copy-text');
            $('.btn-copy-container').removeClass('copied');
        });
    });
})(jQuery);