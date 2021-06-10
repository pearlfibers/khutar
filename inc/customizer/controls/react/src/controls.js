/* global CustomEvent,khutarReactCustomize */
import domReady from '@wordpress/dom-ready';

import { init as initDynamicFields } from './dynamic-fields/index';
import { ToggleControl } from './toggle/Control';
import { ResponsiveToggleControl } from './responsive-toggle/Control';
import { BackgroundControl } from './background/Control';
import { SpacingControl } from './spacing/Control';
import { TypefaceControl } from './typeface/Control';
import { FontFamilyControl } from './font-family/Control';
import { RadioButtonsControl } from './radio-buttons/Control';
import { ButtonAppearanceControl } from './button-appearance/Control';
import { RangeControl } from './range/Control';
import { ResponsiveRangeControl } from './responsive-range/Control';
import { ColorControl } from './color/Control';
import { PresetsSelectorControl } from './presets-selector/Control';
import { MultiSelectControl } from './multiselect/Control';
import { ResponsiveRadioButtonsControl } from './responsive-radio-buttons/Control';
import { RadioImageControl } from './radio-image/Control';
import { OrderingControl } from './ordering/Control';
import { UiControl } from './ui/Control';
import { GlobalColorsControl } from './global-colors/Control';
import { NRSpacingControl } from './non-responsive-spacing/Control';
import { InlineSelectControl } from './inline-select/Control';

import './style.scss';

const { controlConstructor } = wp.customize;

controlConstructor.khutar_toggle_control = ToggleControl;
controlConstructor.khutar_responsive_toggle_control = ResponsiveToggleControl;
controlConstructor.khutar_background_control = BackgroundControl;
controlConstructor.khutar_spacing = SpacingControl;
controlConstructor.khutar_typeface_control = TypefaceControl;
controlConstructor.khutar_font_family_control = FontFamilyControl;
controlConstructor.khutar_radio_buttons_control = RadioButtonsControl;
controlConstructor.khutar_button_appearance = ButtonAppearanceControl;
controlConstructor.khutar_range_control = RangeControl;
controlConstructor.khutar_responsive_range_control = ResponsiveRangeControl;
controlConstructor.khutar_color_control = ColorControl;
controlConstructor.khutar_presets_selector = PresetsSelectorControl;
controlConstructor.khutar_multiselect = MultiSelectControl;
controlConstructor.khutar_responsive_radio_buttons_control = ResponsiveRadioButtonsControl;
controlConstructor.khutar_radio_image_control = RadioImageControl;
controlConstructor.khutar_ordering_control = OrderingControl;
controlConstructor.khutar_ui_control = UiControl;
controlConstructor.khutar_global_colors = GlobalColorsControl;
controlConstructor.khutar_non_responsive_spacing = NRSpacingControl;
controlConstructor.khutar_inline_select = InlineSelectControl;

const initDeviceSwitchers = () => {
	const deviceButtons = document.querySelector(
		'#customize-footer-actions .devices, .hfg--cb-devices-switcher a.switch-to'
	);
	deviceButtons.addEventListener('click', function (e) {
		const event = new CustomEvent('khutarChangedRepsonsivePreview', {
			detail: e.target.dataset.device,
		});
		document.dispatchEvent(event);
	});
};

const initBlogPageFocus = () => {
	wp.customize.section('khutar_blog_archive_layout', (section) => {
		section.expanded.bind((isExpanded) => {
			const front = wp.customize.control('show_on_front').setting();
			let pageId = '';
			if (front === 'page') {
				pageId = wp.customize.control('page_for_posts').setting();
			}

			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(
					pageId ? `/?page_id=${pageId}` : '/'
				);
			}
		});
	});
};

domReady(() => {
	initDeviceSwitchers();
	initBlogPageFocus();
});

wp.customize.bind('ready', () => {
	initDynamicFields();
});

window.HFG = {
	getSettings: () => {
		const usedSettings = {};
		khutarReactCustomize.headerControls.map((item) => {
			if (!wp.customize.control(item)) return false;
			usedSettings[item] = wp.customize.control(item).setting.get();
			return item;
		});
		return JSON.stringify(usedSettings);
	},
};
