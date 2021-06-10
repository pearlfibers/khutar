/* global khutarDash */
import FeatureRow from '../FeatureRow';

import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';

const Pro = () => {
	const { featureData } = khutarDash;
	return (
		<div className="col">
			<table className="card table">
				<tbody className="table-body">
					<tr className="table-head">
						<th className="large" />
						<th className="indicator">khutar</th>
						<th className="indicator">khutar Pro</th>
					</tr>
					{featureData.map((item, index) => (
						<FeatureRow key={index} item={item} />
					))}
				</tbody>
			</table>

			<div className="card upsell">
				<p>
					{__(
						'Get access to all Pro features and power-up your website',
						'khutar'
					)}
				</p>
				<Button
					target="_blank"
					rel="external noreferrer noopener"
					href={khutarDash.upgradeURL}
					isPrimary
				>
					{__('Get khutar Pro Now', 'khutar')}
					<span className="components-visually-hidden">
						{__('(opens in a new tab)', 'khutar')}
					</span>
				</Button>
			</div>
		</div>
	);
};

export default Pro;
