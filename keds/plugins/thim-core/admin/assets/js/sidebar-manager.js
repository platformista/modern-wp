jQuery(document).ready(function ($) {
	var prefix = thim_sidebar_manager.prefix || 'thim_sidebar_';
	var remove_template = thim_sidebar_manager.remove_template || '';

	$('#widgets-right .widgets-sortables[id^="' + prefix + '"]').each(function () {
		$(this).append(remove_template);
	});

	$('body').on('click', '.thim-btn-remove-sidebar', function (event) {
		var this_ = this;

		var $parent = $(this_).parent('.widgets-sortables');
		var sidebar_id = $parent.attr('id') || false;

		if (!sidebar_id) {
			return;
		}

		remove_sidebar(sidebar_id);
	});

	/**
	 * Request remove sidebar with id.
	 * @param sidebar_id
	 */
	function remove_sidebar(sidebar_id) {
		var $sidebar = $('#' + sidebar_id);
		var title = $sidebar.find('h2').text().trim();

		var confirm_remove_msg = thim_sidebar_manager.confirm_remove || '';
		var remove = confirm(confirm_remove_msg + '"' + title + '"?');
		if (remove) {
			$('#thim_input_remove_sidebar').val(sidebar_id);
			$('#thim-form-remove-sidebar').submit();
		}
	}
});