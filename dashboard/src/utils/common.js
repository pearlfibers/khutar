/* global khutarDash */
import compareVersions from 'compare-versions';

import StarterSitesUnavailable from '../Components/Content/StarterSitesUnavailable';
import Start from '../Components/Content/Start';
import Pro from '../Components/Content/Pro';
import Plugins from '../Components/Content/Plugins';
import Help from '../Components/Content/Help';
import Changelog from '../Components/Content/Changelog';
import FreePro from '../Components/Content/FreePro';
import { __ } from '@wordpress/i18n';

const addUrlHash = (hash) => {
	window.location.hash = hash;
};

const getTabHash = () => {
	let hash = window.location.hash;

	if ('string' !== typeof window.location.hash) {
		return null;
	}

	hash = hash.substring(1);

	if (!Object.keys(tabs).includes(hash)) {
		return null;
	}

	return hash;
};

const tabs = {
	start: {
		label: __('Welcome', 'khutar'),
		render: (setTab) => <Start setTab={setTab} />,
	},
	'starter-sites': {
		label: __('Starter Sites', 'khutar'),
		render: () => <StarterSitesUnavailable />,
	},
	'free-pro': {
		label: __('Free vs Pro', 'khutar'),
		render: () => <FreePro />,
	},
	plugins: {
		label: __('Plugins', 'khutar'),
		render: () => <Plugins />,
	},
	help: {
		label: __('Help', 'khutar'),
		render: (setTab) => <Help setTab={setTab} />,
	},
	changelog: {
		label: __('Changelog', 'khutar'),
		render: () => <Changelog />,
	},
};

const { plugins } = khutarDash;
const activeTPC = plugins['templates-patterns-collection'].cta === 'deactivate';
const properTPC =
	compareVersions(
		plugins['templates-patterns-collection'].version,
		'1.0.10'
	) === 1;

if (activeTPC && properTPC) {
	delete tabs['starter-sites'];
}

if (khutarDash.pro || khutarDash.hasOldPro) {
	tabs.pro = {
		label: khutarDash.strings.proTabTitle,
		render: () => <Pro />,
	};
	delete tabs['free-pro'];
}

if (khutarDash.whiteLabel) {
	delete tabs.changelog;
	delete tabs.plugins;
	if (khutarDash.whiteLabel.hideStarterSites) {
		delete tabs['starter-sites'];
	}
}

if (khutarDash.hidePluginsTab) {
	delete tabs.plugins;
}

const untrailingSlashIt = (str) => str.replace(/\/$/, '');
const trailingSlashIt = (str) => untrailingSlashIt(str) + '/';

export { addUrlHash, getTabHash, trailingSlashIt, untrailingSlashIt, tabs };
