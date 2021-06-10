import './style.scss';
import App from './Components/App';
import { registerStore } from '@wordpress/data';
import { render } from '@wordpress/element';

import actions from './store/actions';
import reducer from './store/reducer';
import selectors from './store/selectors';

registerStore('khutar-dashboard', {
	reducer,
	actions,
	selectors,
});

const Root = () => <App />;
render(<Root />, document.getElementById('khutar-dashboard'));
