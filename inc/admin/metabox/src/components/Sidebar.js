/* global metaSidebar */
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { __ } = wp.i18n;

import MetaFieldsManager from './MetaFieldsManager';
const { useShortcut } = wp.keyboardShortcuts;
const { useCallback } = wp.element;
const {compose} = wp.compose;
const {withDispatch, withSelect} = wp.data;

const Sidebar = compose(
	withDispatch((dispatch) => {
		dispatch( 'core/keyboard-shortcuts' ).registerShortcut( {
			name: 'khutar/open-meta-sidebar',
			category: 'block',
			description: __( 'Open khutar meta sidebar', 'khutar' ),
			keyCombination: {
				modifier: 'access',
				character: 's'
			}
		} );
	} ),
	withSelect((select) => {
		return {
			template: select('core/editor').getEditedPostAttribute('template')
		};
	} ) )( function( templateData ) {

	useShortcut(
		'khutar/open-meta-sidebar',
		useCallback(
			() => {
				const currentActiveSidebar = wp.data.select( 'core/edit-post' ).getActiveGeneralSidebarName();
				if ( currentActiveSidebar ) {
					wp.data.dispatch( 'core/edit-post' ).closeGeneralSidebar( currentActiveSidebar );
					if ( 'meta-sidebar/khutar-meta-sidebar' !== currentActiveSidebar ) {
						wp.data.dispatch( 'core/edit-post' ).openGeneralSidebar( 'meta-sidebar/khutar-meta-sidebar' );
					}
				} else {
					wp.data.dispatch( 'core/edit-post' ).openGeneralSidebar( 'meta-sidebar/khutar-meta-sidebar' );
				}
			},
			[]
		)
	);

	if ( 'elementor_canvas' === templateData.template ) {
		document.getElementById('khutar-page-settings-notice').style.display = 'none';
		return false;
	}
	document.getElementById('khutar-page-settings-notice').style.display = 'block';

	let sidebarLabel = __( 'khutar Options', 'khutar' );
	if ( metaSidebar.whiteLabeled ) {
		sidebarLabel = metaSidebar.whiteLabelThemeName ? metaSidebar.whiteLabelThemeName + ' ' + __( 'Options', 'khutar' ) : __( 'Options', 'khutar' );
	}

	return (
		<>
			<PluginSidebarMoreMenuItem
				target="khutar-meta-sidebar"
			>
				{ sidebarLabel }
			</PluginSidebarMoreMenuItem>
			<PluginSidebar
				name="khutar-meta-sidebar"
				title={ sidebarLabel }
			>
				<MetaFieldsManager/>
			</PluginSidebar>
		</>
	);
});
export default Sidebar;
