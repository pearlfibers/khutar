import PropTypes from 'prop-types';
import { __ } from '@wordpress/i18n';
import SizingControl from '../common/Sizing';
import { Panel, PanelBody, PanelRow } from '@wordpress/components';
import ColorControl from '../common/ColorControl';
import RadioIcons from '../common/RadioIcons';

const ButtonAppearance = ({ label, value, onChange, noHover, defaultVals }) => {
	const { type, borderRadius, borderWidth } = value;

	const TypeControl = () => {
		const types = {
			fill: {
				label: 'fill',
				tooltip: __('Filled', 'khutar'),
				icon: 'text',
			},
			outline: {
				label: 'outline',
				tooltip: __('Outline', 'khutar'),
				icon: 'text',
			},
		};
		const updateType = (nextType) => {
			onChange('type', nextType);
		};

		return (
			<RadioIcons options={types} onChange={updateType} value={type} />
		);
	};

	const renderColors = () => {
		if (!type) {
			return null;
		}
		const settings = {
			normal: {
				label: __('Normal', 'khutar'),
				controls: {
					background: __('Background', 'khutar'),
					text:
						type === 'fill'
							? __('Text', 'khutar')
							: __('Text and Border', 'khutar'),
				},
			},
			hover: {
				label: __('Hover', 'khutar'),
				controls: {
					backgroundHover: __('Background', 'khutar'),
					textHover:
						type === 'fill'
							? __('Text', 'khutar')
							: __('Text and Border', 'khutar'),
				},
			},
		};

		return (
			<Panel>
				{Object.keys(settings).map((optionType, panelIndex) => {
					if (noHover && optionType === 'hover') {
						return null;
					}

					return (
						<PanelBody
							key={panelIndex}
							title={noHover ? '' : settings[optionType].label}
							initialOpen={optionType === 'normal'}
						>
							{Object.keys(settings[optionType].controls).map(
								(controlSlug, controlIndex) => {
									return (
										<PanelRow key={controlIndex}>
											<ColorControl
												label={
													settings[optionType]
														.controls[controlSlug]
												}
												selectedColor={
													value[controlSlug]
												}
												onChange={(nextColor) => {
													onChange(
														controlSlug,
														nextColor
													);
												}}
											/>
										</PanelRow>
									);
								}
							)}
						</PanelBody>
					);
				})}
			</Panel>
		);
	};

	const borderControls = () => {
		const directions = {
			top: __('Top', 'khutar'),
			right: __('Right', 'khutar'),
			bottom: __('Bottom', 'khutar'),
			left: __('Left', 'khutar'),
		};

		const widthOptions = [];
		const radiusOptions = [];

		Object.keys(directions).map((direction) => {
			widthOptions.push({
				type: direction,
				label: direction[direction],
				value: borderWidth[direction] || '',
			});
			radiusOptions.push({
				type: direction,
				label: direction[direction],
				value: borderRadius[direction] || '',
			});
			return direction;
		});

		return (
			<>
				<span className="customize-control-title">
					{__('Border Radius', 'khutar')}
				</span>
				<SizingControl
					min={0}
					max={100}
					step={1}
					options={radiusOptions}
					defaults={defaultVals.borderRadius}
					value={borderRadius}
					onChange={(newVal) => {
						onChange('borderRadius', newVal);
					}}
					onReset={() => {
						onChange('borderRadius', defaultVals.borderRadius);
					}}
				/>
				{type === 'outline' && (
					<>
						<span className="customize-control-title">
							{__('Border Width', 'khutar')}
						</span>
						<SizingControl
							min={0}
							max={100}
							step={1}
							options={widthOptions}
							defaults={defaultVals.borderWidth}
							value={borderWidth}
							onChange={(newVal) => {
								onChange('borderWidth', newVal);
							}}
							onReset={() => {
								onChange(
									'borderWidth',
									defaultVals.borderWidth
								);
							}}
						/>
					</>
				)}
			</>
		);
	};

	return (
		<div className="khutar-button-appearance-control">
			{label && <span className="customize-control-title">{label}</span>}
			<div className="khutar-white-background-control">
				<span className="customize-control-title">
					{__('Style', 'khutar')}
				</span>
				<TypeControl />
				{borderControls()}
				{renderColors()}
			</div>
		</div>
	);
};

const valuePropTypeTemplate = PropTypes.shape({
	type: PropTypes.oneOf(['outline', 'fill', '']),
	background: PropTypes.string,
	backgroundHover: PropTypes.string,
	text: PropTypes.string,
	textHover: PropTypes.string,
	borderRadius: PropTypes.shape({
		top: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		bottom: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		right: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		left: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
	}),
	borderWidth: PropTypes.shape({
		top: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		bottom: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		right: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
		left: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
	}),
});

ButtonAppearance.propTypes = {
	value: valuePropTypeTemplate,
	defaultVals: valuePropTypeTemplate,
};

export default ButtonAppearance;
