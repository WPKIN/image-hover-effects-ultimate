(function () {
	'use strict';

	if (typeof elementor === 'undefined') {
		return;
	}

	/**
	 * When the Image Hover widget panel opens, update the "Edit Shortcode"
	 * button href and keep it in sync whenever the dropdown changes.
	 */
	elementor.hooks.addAction(
		'panel/open_editor/widget/iheu_image_hover',
		function (panel, model) {
			function updateBtn() {
				var btn = panel.$el
					? panel.$el.find('.iheu-edit-shortcode-btn')[0]
					: null;
				if (!btn) return;

				var urls = {};
				try {
					urls = JSON.parse(btn.getAttribute('data-urls') || '{}');
				} catch (e) {}

				// In Elementor, settings is a nested Backbone model.
				var settings = model.get('settings');
				var id = settings ? settings.get('id') : '';
				btn.href = urls[id] || '#';
			}

			// Initial update – slight delay so the HTML is rendered.
			setTimeout(updateBtn, 100);
			setTimeout(updateBtn, 500);

			// Listen for changes on the nested settings model.
			var settings = model.get('settings');
			if (settings) {
				settings.on('change:id', function () {
					setTimeout(updateBtn, 50);
				});
			}
		}
	);
})();
