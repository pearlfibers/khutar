/* global khutarProReactCustomize */
import { ExternalLink } from '@wordpress/components';

const ControlWithLink = ({ link, children }) => {
	if (typeof khutarProReactCustomize !== 'undefined') {
		const { whiteLabel } = khutarProReactCustomize;

		if (whiteLabel) {
			return children;
		}
	}

	const handleFocus = () => {
		wp.customize[link.focus[0]](link.focus[1]).focus();
	};

	const Link = () => {
		if (link.focus) {
			return (
				<a href="#link-select" onClick={handleFocus}>
					{link.string}
				</a>
			);
		}

		if (link.new_tab) {
			return <ExternalLink href={link.url}>{link.string}</ExternalLink>;
		}

		return <a href={link.url}>{link.string}</a>;
	};

	return (
		<>
			{children}
			{link && (
				<p className="khutar-customizer-link">
					<Link />
				</p>
			)}
		</>
	);
};

export default ControlWithLink;
