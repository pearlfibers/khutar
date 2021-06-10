/* global khutarMetabox,jQuery */

(function ($) {
	$.khutarMetabox = {
		data: khutarMetabox,

		init() {
			this.syncRangeToNumber();
			this.handleDependentUi();
		},

		syncRangeToNumber() {
			$('#khutar-page-settings .khutar-range-input').each(function (
				index,
				element
			) {
				const range = $(element).find('input.nv-range');
				const number = $(element).find('input.nv-number');
				$(range).on('input change', function (e) {
					$(number).val(e.target.value);
				});
				$(number).on('input change', function (e) {
					$(range).val(e.target.value);
				});
			});
		},
		handleDependentUi() {
			$('#khutar-page-settings .khutar-dependent').each(function (
				index,
				element
			) {
				const influencer = $('input#' + $(element).data('depends'));
				$(influencer).on('change', function () {
					$(element).toggleClass('khutar-hidden');
				});
			});
		},
	};
})(jQuery);

jQuery(window).on('load', function () {
	jQuery.khutarMetabox.init();
});
