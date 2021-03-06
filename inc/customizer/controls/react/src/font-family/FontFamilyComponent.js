/* jshint esversion: 6 */
/* global khutarReactCustomize */
import PropTypes from 'prop-types';
import FontFamilySelector from './FontFamilySelector.js';

import { useState } from '@wordpress/element';

const TypefaceComponent = ({ control }) => {
	const [fontFamily, setFontFamily] = useState(control.setting.get());

	const defaultParams = {
		default_is_inherit: false,
	};

	const controlParams = control.params.input_attrs
		? {
				...defaultParams,
				...control.params.input_attrs,
		  }
		: defaultParams;

	const maybeGetTypekitFont = (font) => {
		const { typekitSlugs } = khutarReactCustomize;

		if (!typekitSlugs) {
			return font;
		}

		if (!typekitSlugs[font]) {
			return font;
		}

		return typekitSlugs[font];
	};

	const onChoseFont = (fontSource, font) => {
		setFontFamily(font);
		updateControl(font, fontSource);
	};

	const updateControl = (font, fontSource) => {
		control.setting.set(maybeGetTypekitFont(font));
		if (control.id !== 'khutar_fallback_font_family') {
			wp.customize.previewer.send('font-selection', {
				value: maybeGetTypekitFont(font),
				source: fontSource,
				controlId: control.id,
				type: '\\khutar\\Customizer\\Controls\\React\\Font_Family',
				inherit: controlParams.default_is_inherit,
			});
		}
	};

	return (
		<>
			{control.params.label && (
				<span className="customize-control-title">
					{control.params.label}
				</span>
			)}
			<div className="khutar-typeface-control khutar-white-background-control">
				<FontFamilySelector
					fonts={khutarReactCustomize.fonts}
					selected={fontFamily}
					onFontChoice={(fontSource, font) => {
						onChoseFont(fontSource, font);
					}}
					inheritDefault={controlParams.default_is_inherit}
					systemFonts={controlParams.system}
					maybeGetTypekit={maybeGetTypekitFont}
				/>
			</div>
		</>
	);
};

TypefaceComponent.propTypes = {
	control: PropTypes.object.isRequired,
};

export default TypefaceComponent;
