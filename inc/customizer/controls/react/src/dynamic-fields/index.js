/* global khutarReactCustomize, Event */

import DynamicFieldInserter from './dynamic-field-inserter.js';
import { render } from '@wordpress/element';

/**
 * Initialize the dynamic tag buttons.
 *
 * @return {boolean}|{void}
 */
export const init = () => {
	const controls = khutarReactCustomize?.dynamicTags?.controls || false;
	if (!controls) {
		return false;
	}
	khutarReactCustomize.fieldSelection = {};
	Object.keys(controls).forEach((controlId) => {
		const control = wp.customize.control(controlId);
		if (typeof control === 'undefined') {
			return false;
		}
		const container = control.container[0];
		const dynamicControlWrap = document.createElement('div');

		dynamicControlWrap.setAttribute('id', `dynamic-${controlId}`);
		dynamicControlWrap.classList.add('khutar-dynamic-tag-selector');
		container.classList.add('khutar-has-dynamic-tag-selector');
		container.appendChild(dynamicControlWrap);

		const input = document.querySelector(
			`[data-customize-setting-link="${control.id}"]`
		);

		input.addEventListener('focusout', function (e) {
			khutarReactCustomize.fieldSelection[controlId] = {
				start: e.target.selectionStart,
				end: e.target.selectionEnd,
			};
		});
		render(
			<DynamicFieldInserter
				options={khutarReactCustomize?.dynamicTags?.options || []}
				allowedOptionsTypes={controls[controlId]}
				onSelect={(magicTag, group) =>
					addToField(magicTag, control, group)
				}
			/>,
			dynamicControlWrap
		);
	});
};

/**
 * Add dynamic tag to input field.
 *
 * @param {string} magicTag
 * @param {Object} control
 * @param {string} optionType
 */
const addToField = function (magicTag, control, optionType) {
	let tag;
	const input = document.querySelector(
		`[data-customize-setting-link="${control.id}"]`
	);

	if (optionType === 'url' && control.params.type === 'textarea') {
		tag = `<a href="{${magicTag}}">Link</a>`;
	} else {
		tag = `{${magicTag}}`;
	}

	if (optionType === 'url' && input.value === '#') {
		input.value = tag;
	} else if (khutarReactCustomize.fieldSelection[control.id]) {
		const { start, end } = khutarReactCustomize.fieldSelection[control.id];
		const length = input.value.length;
		input.value =
			input.value.substring(0, start) +
			tag +
			input.value.substring(end, length);
	} else {
		input.value += tag;
	}
	khutarReactCustomize.fieldSelection[control.id] = false;
	input.focus();
	input.dispatchEvent(new Event('change'));
};
