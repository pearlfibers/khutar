/* global khutarDash */
import { addUrlHash, getTabHash, tabs } from '../utils/common';
import classnames from 'classnames';

import { __ } from '@wordpress/i18n';
import { useEffect } from '@wordpress/element';

const Header = (props) => {
	useEffect(() => {
		const hash = getTabHash();
		if (null === hash) {
			return;
		}
		props.setTab(hash);
	}, []);

	const renderHead = () => {
		return (
			<div className="top">
				<h1 className="heading">{khutarDash.strings.header}</h1>
				<span className="version">{khutarDash.version}</span>
				{!khutarDash.whiteLabel && (
					<img
						src={khutarDash.assets + '/logo.svg'}
						alt={__('khutar Theme Logo', 'khutar')}
					/>
				)}
			</div>
		);
	};

	const renderNavigation = () => {
		const { currentTab, setTab } = props;
		return (
			<nav className="navigation">
				{Object.keys(tabs).map((item, index) => {
					return (
						<li key={index}>
							<a
								href={'#' + item}
								className={classnames([
									item,
									currentTab === item ? 'active' : '',
								])}
								onClick={(e) => {
									e.preventDefault();
									setTab(item);
									addUrlHash(item);
								}}
							>
								{tabs[item].label}
							</a>
						</li>
					);
				})}
			</nav>
		);
	};

	return (
		<header>
			<div className="container">
				{renderHead()}
				{renderNavigation(props)}
			</div>
		</header>
	);
};

export default Header;
