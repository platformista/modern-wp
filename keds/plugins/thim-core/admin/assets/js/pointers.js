;(function($) {

    $(document).ready(function() {
        thim_open_pointer(0);
        function thim_open_pointer(i) {
            var pointer = thim_pointers.pointers[i];
            var options = $.extend( pointer.options, {
                close: function() {
                    $.post( ajaxurl, {
                        pointer: pointer.pointer_id,
                        action: 'dismiss-wp-pointer'
                    });
                }
            });

            $(pointer.target).pointer( options ).pointer('open');
        }
    });
})(jQuery);