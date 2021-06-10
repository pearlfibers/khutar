/* global khutarDash */
import Accordion from '../Accordion';
import classnames from 'classnames';

import { __ } from '@wordpress/i18n';
import { Fragment, useState } from '@wordpress/element';

const Changelog = () => {
	const { changelog, changelogPro } = khutarDash;
	const [showForPro, setShowForPro] = useState(false);

	return (
		<div className="card">
			{changelogPro && (
				<div className="changelog-tabs">
					<span>{__('Show changelog for', 'khutar')}</span>
					<a
						href="#changelog-khutar"
						className={classnames([{ active: !showForPro }])}
						onClick={() => {
							setShowForPro(false);
						}}
					>
						khutar
					</a>
					<a
						href="#show-for-pro"
						className={classnames([{ active: showForPro }])}
						onClick={() => {
							setShowForPro(true);
						}}
					>
						khutar Pro
					</a>
				</div>
			)}
			{(showForPro ? changelogPro : changelog).map((entry, index) => {
				const { date, version, tweaks, fixes, features } = entry;
				if (!tweaks && !fixes && !features) {
					return null;
				}
				const title = (
					<Fragment>
						<span className="version">v{version}</span> -{' '}
						<span className="date">{date}</span>
					</Fragment>
				);

				return (
					<Accordion key={index} isOpen={0 === index} title={title}>
						{features && (
							<div className="features changelog-category">
								<div className="label-wrap">
									<span className="label success">
										{__('Features', 'khutar')}
									</span>
								</div>
								<ul className="entries">
									{features.map((feature, indexFeature) => (
										<li
											key={indexFeature}
											dangerouslySetInnerHTML={{
												__html: feature,
											}}
										/>
									))}
								</ul>
							</div>
						)}
						{fixes && (
							<div className="bugs changelog-category">
								<div className="label-wrap">
									<span className="label error">
										{__('Bug Fixes', 'khutar')}
									</span>
								</div>
								<ul className="entries">
									{fixes.map((fix, indexFixes) => (
										<li
											key={indexFixes}
											dangerouslySetInnerHTML={{
												__html: fix,
											}}
										/>
									))}
								</ul>
							</div>
						)}
						{tweaks && (
							<div className="tweaks changelog-category">
								<div className="label-wrap">
									<span className="label info">
										{__('Tweaks', 'khutar')}
									</span>
								</div>
								<ul className="entries">
									{tweaks.map((tweak, indexTweak) => (
										<li
											key={indexTweak}
											dangerouslySetInnerHTML={{
												__html: tweak,
											}}
										/>
									))}
								</ul>
							</div>
						)}
					</Accordion>
				);
			})}
		</div>
	);
};

export default Changelog;
