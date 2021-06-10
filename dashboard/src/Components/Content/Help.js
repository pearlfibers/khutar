/* global khutarDash */
import Card from '../Card';

import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { Button, Icon, ExternalLink } from '@wordpress/components';

const Help = (props) => {
	const { setTab } = props;

	let { docsURL, codexURL, supportURL, whiteLabel, assets } = khutarDash;
	const { supportCardDescription, docsCardDescription } = khutarDash.strings;

	if (whiteLabel && whiteLabel.agencyURL) {
		supportURL = whiteLabel.agencyURL;
		docsURL = whiteLabel.agencyURL;
	}

	return (
		<Fragment>
			{!whiteLabel && (
				<Card
					icon={assets + 'arrows.svg'}
					title={__(
						'Build a landing page with a drag-and-drop content builder',
						'khutar'
					)}
					description={__(
						'In the documentation below you will find an easy way to build a great looking landing page using a drag-and-drop content builder plugin.',
						'khutar'
					)}
				>
					<ExternalLink href="http://docs.pearlfibers.com/article/219-how-to-build-a-landing-page-with-a-drag-and-drop-content-builder">
						{__('Learn More', 'khutar')}
					</ExternalLink>
				</Card>
			)}
			<Card
				icon={assets + 'page.svg'}
				title={__('Documentation', 'khutar')}
				description={docsCardDescription}
			>
				{!whiteLabel && (
					<ExternalLink href={codexURL}>
						{__('Go to khutar Codex', 'khutar')}
					</ExternalLink>
				)}
				<ExternalLink href={docsURL}>
					{__('Go to docs', 'khutar')}
				</ExternalLink>
				{!whiteLabel && (
					<Button
						isLink
						className="facebook-badge"
						href="https://www.facebook.com/groups/648646435537266/"
						target="_blank"
						rel="external noreferrer noopener"
					>
						<span className="components-visually-hidden">
							{__('(opens in a new tab)', 'khutar')}
						</span>
						<Icon icon="facebook-alt" />
						<span>{__('Join our Facebook Group', 'khutar')}</span>
					</Button>
				)}
			</Card>

			{!whiteLabel && (
				<Card
					icon={assets + 'clone.svg'}
					title={__('Create a child theme', 'khutar')}
					description={__(
						"If you want to make changes to the theme's files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation below.",
						'khutar'
					)}
				>
					<ExternalLink href="http://docs.pearlfibers.com/article/14-how-to-create-a-child-theme">
						{__('Learn More', 'khutar')}
					</ExternalLink>
				</Card>
			)}

			<Card
				icon={khutarDash.assets + 'buoy.svg'}
				title={__('Contact Support', 'khutar')}
				description={supportCardDescription}
			>
				<Button
					isPrimary
					href={supportURL}
					target="_blank"
					rel="external noreferrer noopener"
				>
					<span className="components-visually-hidden">
						{__('(opens in a new tab)', 'khutar')}
					</span>
					{__('Contact Support', 'khutar')}
				</Button>
			</Card>

			{!whiteLabel && (
				<Card
					icon={assets + 'tachometer.svg'}
					title={__('Speed up your site', 'khutar')}
					description={__(
						'If you find yourself in a situation where everything on your site is running very slowly, you might consider having a look at the documentation below where you will find the most common issues causing this and possible solutions for each of the issues.',
						'khutar'
					)}
				>
					<ExternalLink href="http://docs.pearlfibers.com/article/63-speed-up-your-wordpress-site">
						{__('Learn More', 'khutar')}
					</ExternalLink>
				</Card>
			)}
			{!whiteLabel && (
				<Card
					icon={assets + 'list.svg'}
					title={__('Changelog', 'khutar')}
					description={__(
						'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.',
						'khutar'
					)}
					ßßßßß
				>
					<Button isLink onClick={() => setTab('changelog')}>
						{__('View Changelog', 'khutar')}
					</Button>
				</Card>
			)}
		</Fragment>
	);
};

export default Help;
