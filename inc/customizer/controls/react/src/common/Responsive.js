/* global CustomEvent */
import { Button, Tooltip, ButtonGroup } from '@wordpress/components';
import { useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import PropTypes from 'prop-types';

const ResponsiveControl = ({
	onChange,
	excluded,
	controlLabel,
	hideResponsive,
	children,
}) => {
	const changeViewType = (device) => {
		wp.customize.previewedDevice(device);
	};

	useEffect(() => {
		// eslint-disable-next-line @wordpress/no-global-event-listener
		document.addEventListener('khutarChangedRepsonsivePreview', (e) => {
			onChange(e.detail);
		});
	}, []);

	const dispatchViewChange = (device) => {
		changeViewType(device);
		const event = new CustomEvent('khutarChangedRepsonsivePreview', {
			detail: device,
		});
		document.dispatchEvent(event);
	};

	const devices = {
		desktop: {
			tooltip: __('Desktop', 'khutar'),
			icon: 'desktop',
		},
		tablet: {
			tooltip: __('Tablet', 'khutar'),
			icon: 'tablet',
		},
		mobile: {
			tooltip: __('Mobile', 'khutar'),
			icon: 'smartphone',
		},
	};

	const deviceMap = {};

	Object.keys(devices).map((key) => {
		if (excluded) {
			if (excluded.includes(key)) {
				return false;
			}
		}
		deviceMap[key] = devices[key];
		return key;
	});

	const renderDeviceButton = (device, index) => {
		const { tooltip, icon } = deviceMap[device];

		return (
			<Tooltip text={tooltip} key={index}>
				<Button
					aria-label={tooltip}
					icon={icon}
					className={device}
					onClick={() => {
						dispatchViewChange(device);
					}}
				/>
			</Tooltip>
		);
	};

	return (
		<>
			<div className="khutar-responsive-control-bar">
				{controlLabel && (
					<span className="customize-control-title">
						{controlLabel}
					</span>
				)}
				{!hideResponsive && (
					<div className="floating-controls">
						<ButtonGroup>
							{Object.keys(deviceMap).map((device, index) =>
								renderDeviceButton(device, index)
							)}
						</ButtonGroup>
					</div>
				)}
			</div>
			{children && (
				<div className="khutar-responsive-controls-content">
					{children}
				</div>
			)}
		</>
	);
};

ResponsiveControl.propTypes = {
	onChange: PropTypes.func,
	controlLabel: PropTypes.string,
	hideResponsive: PropTypes.bool,
	children: PropTypes.any,
	excluded: PropTypes.array,
};

export default ResponsiveControl;
