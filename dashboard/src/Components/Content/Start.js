/* global khutarDash */
import Card from '../Card';
import { tabs } from '../../utils/common';

import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { Button, ExternalLink } from '@wordpress/components';
import { withSelect } from '@wordpress/data';

const Start = (props) => {
	const { setTab, tier } = props;
	const {
		showFeedbackNotice,
		pro,
		whiteLabel,
		customizerShortcuts,
		tpcAdminURL,
	} = khutarDash;
	const starterSitesHidden = whiteLabel && whiteLabel.hideStarterSites;

	const renderCustomizerLinks = () => {
		const split = Math.ceil(customizerShortcuts.length / 2);
		const parts = [
			customizerShortcuts.slice(0, split),
			customizerShortcuts.slice(split),
		];
		return (
			<div className="columns">
				{parts.map((column, index) => {
					return (
						<div className="col" key={index}>
							{column.map((item, indexColumn) => {
								return (
									<Fragment key={indexColumn}>
										<Button isLink href={item.link}>
											{item.text}
										</Button>
										{indexColumn !== column.length - 1 && (
											<hr />
										)}
									</Fragment>
								);
							})}
						</div>
					);
				})}
			</div>
		);
	};

	return (
		<>
			{!starterSitesHidden && (
				<Card
					icon={khutarDash.assets + 'squares.svg'}
					title={__('Starter Sites', 'khutar')}
					description={khutarDash.strings.starterSitesCardDescription}
				>
					{tabs['starter-sites'] ? (
						<Button
							isPrimary
							onClick={() => {
								setTab('starter-sites');
							}}
						>
							{__('Go to Starter Sites', 'khutar')}
						</Button>
					) : (
						<Button href={tpcAdminURL} isPrimary>
							{__('Go to Starter Sites', 'khutar')}
						</Button>
					)}
				</Card>
			)}

			<Card
				classNames="customizer-quick-links"
				icon={khutarDash.assets + 'compass.svg'}
				title={__('Customizer quick links', 'khutar')}
			>
				{renderCustomizerLinks()}
			</Card>

			{!whiteLabel && (
				<>
					<Card
						icon={khutarDash.assets + 'page.svg'}
						title={__(
							'Getting Started? Check help and docs',
							'khutar'
						)}
						description={__(
							'Need more details? Please check our full documentation for detailed information on how to use khutar.',
							'khutar'
						)}
					>
						<Button isLink onClick={() => setTab('help')}>
							{__('Go to docs', 'khutar')}
						</Button>
					</Card>
					<Card
						icon={khutarDash.assets + 'template-cloud.svg'}
						title="Templates Cloud"
						description={__(
							'Boost productivity and speed up your workflow by saving all your designs and share them automatically to all your sites in 1-click.',
							'khutar'
						)}
					>
						{tier !== 3 && (
							<ExternalLink href="https://docs.pearlfibers.com/article/1354-khutar-template-cloud-library">
								{__('Discover Templates Cloud', 'khutar')}
							</ExternalLink>
						)}
						{tier === 3 && (
							<ExternalLink href="https://docs.pearlfibers.com/article/1354-khutar-template-cloud-library">
								{__('Learn how to use Templates Cloud', 'khutar')}
							</ExternalLink>
						)}
					</Card>
				</>
			)}
			{showFeedbackNotice && !pro && (
				<Card
					classNames="feedback-card"
					icon="awards"
					dashicon={true}
					title={__('Feedback', 'khutar')}
					description={__(
						'Share your feedback for khutar and get the chance to win the pro version.',
						'khutar'
					)}
				>
					<Button
						isPrimary
						href="https://pearlfibers.com/review-khutar-theme/"
					>
						{__('Leave Feedback', 'khutar')}
					</Button>
				</Card>
			)}
		</>
	);
};

export default withSelect((select) => {
	const { getLicenseTier } = select('khutar-dashboard');
	return {
		tier: getLicenseTier(),
	};
})(Start);
