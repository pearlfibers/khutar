/* global metaSidebar */

/**
 * Internal dependencies
 */
const { registerPlugin } = wp.plugins;
const { Icon } = wp.components;

import Sidebar from './components/Sidebar';
import { khutarIcon } from './helpers/icons.js';

const icon = metaSidebar.whiteLabeled ? 'hammer' : khutarIcon;

registerPlugin( 'meta-sidebar', {
	icon: <Icon icon={ icon } />,
	render: Sidebar
} );
