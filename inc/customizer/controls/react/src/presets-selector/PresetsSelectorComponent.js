/* global CustomEvent */
import PropTypes from 'prop-types';

import PresetsSelector from './PresetsSelector';
import { maybeParseJson } from '../common/common';

const PresetsSelectorComponent = ({ control }) => {
	const { presets } = control.params;

	const handleClick = (setup) => {
		setup = maybeParseJson(setup);
		if (typeof khutarProReactCustomize === 'undefined') {
			Object.keys(setup).map((themeMod) => {
				if (themeMod === 'hfg_header_layout') {
					wp.customize.control(themeMod).setting.set(setup[themeMod]);
					document.dispatchEvent(
						new CustomEvent('khutar-changed-builder-value', {
							detail: {
								value: maybeParseJson(setup[themeMod]),
								id: 'header',
							},
						})
					);
					return false;
				}
				if (!wp.customize.control(themeMod)) return false;
				if (
					['text', 'textarea', 'select'].includes(
						wp.customize.control(themeMod).params.type
					)
				) {
					wp.customize.control(themeMod).setting.set(setup[themeMod]);
					return false;
				}

				document.dispatchEvent(
					new CustomEvent('khutar-changed-customizer-value', {
						detail: {
							value: setup[themeMod] || '',
							id: themeMod,
						},
					})
				);
				return false;
			});
			return false;
		}
		document.dispatchEvent(
			new CustomEvent('khutar-preset-changed', {
				detail: {
					themeMods: setup,
				},
			})
		);
	};

	return <PresetsSelector onSelect={handleClick} presets={presets} />;
};

PresetsSelectorComponent.propTypes = {
	control: PropTypes.object.isRequired,
};

export default PresetsSelectorComponent;
