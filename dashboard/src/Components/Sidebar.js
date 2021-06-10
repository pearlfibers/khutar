/* global khutarDash */
import { changeOption } from '../utils/rest';
import LicenseCard from './LicenseCard';
import { __ } from '@wordpress/i18n';
import { ToggleControl, ExternalLink } from '@wordpress/components';
import { createInterpolateElement, useState } from '@wordpress/element';
import { withDispatch, withSelect } from '@wordpress/data';
import { compose } from '@wordpress/compose';

const Sidebar = ({ currentTab, setToast, loggerValue, setLogger }) => {
	const [tracking, setTracking] = useState('yes' === loggerValue);

	return (
		<div className="sidebar-wrap">
			{khutarDash.pro && <LicenseCard isVisible={'pro' === currentTab} />}
			{!khutarDash.whiteLabel && (
				<aside className="sidebar card">
					<div className="sidebar-section">
						<h4>{__('khutar Community', 'khutar')}</h4>
						<p>
							{createInterpolateElement(
								__(
									'Share opinions, ask questions and help each other on our khutar community! Keep up with what we’re working on and vote to help us prioritize on our <external_link>public roadmap</external_link>.',
									'khutar'
								),
								{
									external_link: (
										<ExternalLink href="https://khutar.nolt.io">
											#dumptext
										</ExternalLink>
									),
								}
							)}
						</p>
						<ExternalLink href="https://www.facebook.com/groups/648646435537266/">
							{__('Join our Facebook Group', 'khutar')}
						</ExternalLink>
					</div>
					<hr />
					<div className="sidebar-section">
						<h4>{__('Leave us a review', 'khutar')}</h4>
						<p>
							{__(
								'Are you are enjoying khutar? We would love to hear your feedback.',
								'khutar'
							)}
						</p>
						<ExternalLink href="https://wordpress.org/support/theme/khutar/reviews/#new-post">
							{__('Submit a review', 'khutar')}
						</ExternalLink>
					</div>
					<hr />
					<div className="sidebar-section">
						<h4>{__('Contributing', 'khutar')}</h4>
						<p>
							{__(
								'Become a contributor by opting in to our anonymous data tracking. We guarantee no sensitive data is collected.',
								'khutar'
							)}
							&nbsp;
							<ExternalLink href="https://docs.pearlfibers.com/article/1122-khutar-usage-tracking">
								{__('What do we track?', 'khutar')}
							</ExternalLink>
						</p>
						<ToggleControl
							checked={tracking}
							label={__('Allow Anonymous Tracking', 'khutar')}
							onChange={(value) => {
								setTracking(value);
								changeOption(
									'khutar_logger_flag',
									value ? 'yes' : 'no',
									false,
									false
								).then((r) => {
									if (!r.success) {
										setToast(
											__(
												'Could not update option. Please try again.',
												'khutar'
											)
										);
										setTracking(!value);
										return false;
									}
									setLogger(value ? 'yes' : 'no');
									setToast(__('Option Updated', 'khutar'));
								});
							}}
						/>
					</div>
				</aside>
			)}
		</div>
	);
};

export default compose(
	withDispatch((dispatch) => {
		const { setToast, setLogger } = dispatch('khutar-dashboard');
		return {
			setToast: (message) => setToast(message),
			setLogger: (value) => setLogger(value),
		};
	}),
	withSelect((select) => {
		const { getOption } = select('khutar-dashboard');
		return {
			loggerValue: getOption('khutar_logger_flag'),
		};
	})
)(Sidebar);
