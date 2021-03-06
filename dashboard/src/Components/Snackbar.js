import { Snackbar } from '@wordpress/components';
import { withDispatch, withSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';
import { compose } from '@wordpress/compose';
import { __ } from '@wordpress/i18n';
const GlobalSnackbar = ({ toast, setToast }) => {
	useEffect(() => {
		setTimeout(() => {
			setToast(null);
		}, 3000);
	}, []);

	const message = toast();
	const style = {
		opacity: null === message ? 0 : 1,
	};
	let renderToast = __('Option Updated', 'khutar');
	if (message === false) {
		renderToast = __('Could not Update Option. Please try again.', 'khutar');
	}
	if ('boolean' !== typeof message) {
		renderToast = toast();
	}

	return (
		<div style={style}>
			<Snackbar className="dash-notice">{renderToast}</Snackbar>
		</div>
	);
};

export default compose(
	withDispatch((dispatch) => {
		const { setToast } = dispatch('khutar-dashboard');
		return {
			setToast: (message) => setToast(message),
		};
	}),
	withSelect((select) => {
		const { getToast } = select('khutar-dashboard');
		return {
			toast: () => getToast(),
		};
	})
)(GlobalSnackbar);
