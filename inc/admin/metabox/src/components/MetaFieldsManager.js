/* global metaSidebar */
import SortableItems from './controls/SortableItems';
import {alignCenterIcon, alignLeftIcon, alignRightIcon} from '../helpers/icons.js';

const { compose } = wp.compose;
const { withDispatch, withSelect } = wp.data;
const { Component } = wp.element;
const { PanelBody, Button, BaseControl, RadioControl, ButtonGroup, ToggleControl, RangeControl } = wp.components;
const { __ } = wp.i18n;

class MetaFieldsManager extends Component {

	constructor(props) {
		super(props);

		this.defaultState = {
			'khutar_meta_sidebar': 'default',
			'khutar_meta_container': 'default',
			'khutar_meta_enable_content_width': 'off',
			'khutar_meta_content_width': 70,
			'khutar_meta_title_alignment': 'left',
			'khutar_meta_author_avatar': 'off',
			'khutar_meta_reading_time': 'off',
			'khutar_post_elements_order': JSON.stringify(
				[
					'title',
					'meta',
					'thumbnail',
					'content',
					'tags',
					'comments',
					'post-navigation'
				]
			),
			'khutar_meta_disable_header': 'off',
			'khutar_meta_disable_footer': 'off',
			'khutar_meta_disable_title': 'off'
		};

		this.defaultSortables = JSON.stringify(
			[
				'title',
				'meta',
				'thumbnail',
				'content',
				'tags',
				'comments',
				'post-navigation'
			]
		);

		this.updateValues = this.updateValues.bind( this );
		this.resetAll = this.resetAll.bind( this );
		this.updateBlockWidth = this.updateBlockWidth.bind( this );
	}

	componentDidUpdate() {
		const metaData = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'meta' );

		let omitEmpty = obj => {
			Object.keys(obj).filter(k => '' === obj[k] || 0 === obj[k] ).forEach(k => delete (obj[k]));
			return obj;
		};

		const result = { ...omitEmpty(this.defaultState), ...omitEmpty( metaData ) };

		// Do not use any keys that are not in the sidebar for meta.
		for ( let k in result ) {
			if ( ! Object.keys(this.defaultState).includes(k) ) {
				delete (result[k]);
			}
		}

		this.updateBlockWidth();
	}

	updateValues(id, value) {
		this.props.setMetaValue( id, value );
	}

	resetAll() {
		const allMeta = {...this.props.allMeta};
		const emptiedMeta = {};

		Object.keys( this.defaultState ).map( ( control ) => {
			let emptyValue = '';
			if ( 'khutar_meta_content_width' === control ) {
				emptyValue = 0;
			}
			emptiedMeta[control] = emptyValue;
		});

		// Don't send meta that wasn't there already.
		for ( let k in emptiedMeta ) {
			if ( ! Object.keys(allMeta).includes(k) ) {
				delete emptiedMeta[k];
			}
		}

		// Merge old meta with the empty meta.
		this.props.setAllMetas({
			...allMeta,
			...emptiedMeta
		} );
	}

	updateBlockWidth() {
		const isCustomContentWidth = this.props.metaValue('khutar_meta_enable_content_width');
		let containerType = this.props.metaValue('khutar_meta_container');
		if ( 'default' === containerType ) {
			containerType = metaSidebar.actions['khutar_meta_content_width'].container;
		}

		const contentWidth = this.props.metaValue('khutar_meta_content_width');
		let contentWidthDefault = metaSidebar.actions['khutar_meta_content_width'].content;
		let blockWidthDefault = contentWidthDefault + '%';
		let blocKWidth = contentWidth + '%';
		if ( 'contained' === containerType ) {
			blockWidthDefault = Math.round((contentWidthDefault / 100) * metaSidebar.actions['khutar_meta_content_width'].editor) + 'px';
			blocKWidth = Math.round( ( contentWidth / 100 ) * metaSidebar.actions['khutar_meta_content_width'].editor ) + 'px';
		}

		if (document.contains(document.getElementById('khutar-meta-editor-style'))) {
			document.getElementById('khutar-meta-editor-style').remove();
		}
		let css = '.wp-block:not([data-align="full"]) { max-width: ' + ('on' === isCustomContentWidth ? blocKWidth : blockWidthDefault) + '; }';

		const head = document.head;
		const style = document.createElement('style');
		style.setAttribute('id', 'khutar-meta-editor-style' );
		style.innerHTML = css;
		head.appendChild(style);
	}

	renderPageLayoutGroup() {
		const template = wp.data.select('core/editor').getEditedPostAttribute('template');
		if ( 'elementor_header_footer' === template ) {
			return false;
		}

		return (
			<div className="nv-option-category">
				<PanelBody
					title={__('Page Layout', 'khutar')}
					intialOpen={ true }
				>
					<BaseControl
						id="khutar_meta_sidebar"
						label={__('Sidebar', 'khutar')}
						className="khutar-meta-control khutar-meta-radio-image khutar_meta_sidebar"
					>
						<RadioControl
							selected={ this.props.metaValue('khutar_meta_sidebar') || 'default' }
							options={
								[
									{label: <><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAABXCAYAAAC9UeOHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAN6SURBVHgB7ZrfThpREMZn1SgUWiwkFi6gtol3mnjhi/QJmj5C36SP1gsvTGir0Rb/Baop20UL3fJtugaH3QXKzlLj90s2G5Rlc37MmTNnFqfreW/9weCDiLMujxjHkSPx/TdO13UPfV82hUDKxyXKuMf6kpB7UIiCQhQUoqAQBYUoKERBIQoKUVCIgkIUFKKgEAWFKChEQSEKClFQiIJCFBSioBAFhSgoREEhCgpRUIiCQhQrsgAGg4F0Om3peZ54wwOvwerqqiwvL8uzUkmKxafB66zJVEi325Xzs9PgHMXt7W1wvr6+Ds7lclleVGuZinF+dF1fjEEEQMTl5aX8C9VqNRBjDX4jYi4E3/rR4ZdgasxDsViUzVevgyllBYSYJlVExudPzbllAEwzfFaYb6wwFdL69vUuL6QBxGLqWWImBKtIp9OZ6Zq1tTVZWUnO88hDcUk5DcyEnJ+dyazs7OzI9vb2xPdZRonJsovoSJoqiIJCoTD2dyy3GxsbsrW1Jc1mM/Z6RAgOJNq0MRHyPWGq1Ot1aTQakgSkXFxc3NUjUUD6gxESt6ogR0BGu92W09PxsK/ValKpVOTk5CRRBnCN8kjqQkZLcU34jUJG1IARGZBxfHwsk8CUxH3SrktSF5JUJ4QluOu6kf8fzRvIMyjdIe7m5ib2XmkLyXS3iwFggP1+f+J7MVAk19JwoxdHmjVOSKabOyRKHCHhShMVMblcLjjHRQewKONTj5Bpd6aQgZoDURAFkivo9Xoy771mIfUICXsaSbkklBFWpXt7e2PvwYqEaIqLkHw+bxIhJlMGDZ6kWmQ0hyCnRMmDiKTVJjcUYoGJkHK5kigEg93f35fd3d0gSg4ODmRWqkb9ERMhqDdwJG3CkEixzE7azEXxfLgcW3XRzJbdaTpcyBGtVktmpWrYPTMTggixaPtZ91hNCzP0QlFtpgVk4DMtMa9U642XqURKFjJAJpUqBoIwR2Nn1nIb10GqxVY/ikweQ4yCtuI0YgpDAaXSejDlLDvto2TyGCIO7+9TO8/7eVeYYeD5/JMgGhbx1G6hQv5HzJ/LPEQoREEhCgpRUIiCQhQUoqAQBYUoKERBIQoKUVCIgkIUFKKgEAWFKChEQSEKClFQiIJCFBSioBAFhSgoREEhCgi5EhLg+3K15P/23/viHMkjBzL6v/x3fwDAqWHdPm8hRQAAAABJRU5ErkJggg=="/>
									<span className="option-label">{__( 'Inherit', 'khutar' )}</span></>, value: 'default' },
									{label: <><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEUAAABYCAYAAACjxTpsAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAFISURBVHgB7dWxSsNgGEbht6UEgnGpg3HrUGf1DrxTL0yFutXBToFAsK3WoYtnMIVgW84zZwiHl/8btW07i/bKslxMPtfrp2T0GP1ot9vZOPrFKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKGCSnpqmyevLc07JRVVlPr/98/cuBfReSvVd/e7+IefMpQCjAKMAowBPMnApwJMMXAowCjAKMArwJAOXAjzJwKUAowCjAKMATzJwKcCTDFwKMAowCuj9pnRdl9XqI0OYTq9SFEX+20FR3pfLDKGqLk8zyu6nr+s6QziGIDsHRanrm5wzH1pgFGAUYBRgFGAUYBRgFGAUYBRgFGAUYBRgFGAUYBRgFGAUYBRgFGAUYBRgFGAUYBRgFGAUYBQw2WzyNhpnEe19AbO4NutQ2DJ9AAAAAElFTkSuQmCC"/>
									<span className="option-label">{__( 'None', 'khutar' )}</span></>, value: 'full-width' },
									{label: <><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEUAAABXCAYAAABSk4i5AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAFDSURBVHgB7dUtT8NQFIfxM0ouYkWwUBLMMEMAiu/v+A6AQLH5+jVr9qL3iCZNTrPl+emrnuSe/+zrb7uPET6fd3FN7uv57CZ0xijAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjgNhL8/nzH1B6bJprmadDblChd18XU+r4f/DYlytv7R0ytqqrBb1OilFLiknhogVGAUYCTDJxk4CQDJxl4aIFRgFGAkwycZOAkAycZeGiBUYBRgJMMnGTgJAMnGXhogVFAyvdp2zbGOH2/uq4jS0qUzfo/xpgfg6xWr5ElJcrDYhFjlHIXmVKiLJcvcUk8tMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAowCjAKMAo4ABQ0jKnFSWXOgAAAABJRU5ErkJggg=="/>
									<span className="option-label">{__( 'Left', 'khutar' )}</span></>, value: 'left' },
									{label: <><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABXCAYAAAC5pDO6AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAFVSURBVHgB7dlBSsNQFEbhWyORSCDYFajYgboH9z9zDerAOrMYCQSCmo498MqjCW3PB9nAIbn/IIv489V+/8QReX4/jxxPq4vFWehfhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgHJ/zLbto2315eY2/XNbVRVFfu200/evu9jbsMwxBSSw9R1HfcPjzG3oihiCju9MWVZxqnw+ALDAMMA5xo418C5Bs418PgCwwDDAOcaONfAuQbONfD4AsMAwwDnGjjXwLkGzjXw+ALDgORPqeu67ZOjaZrJbkSu5DCbzWd8rNeRo7xbbY/4IUgOU1WXcbVcRo5DeVtGyWHGz2B8ToXHFxgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgGGAYYBhgG/AIdeUYQlOqQ4AAAAABJRU5ErkJggg=="/>
									<span className="option-label">{__( 'Right', 'khutar' )}</span></>, value: 'right' }
								]
							}
							onChange={(value) => {
								this.updateValues( 'khutar_meta_sidebar', value );
							} }
						/>
					</BaseControl>

					<BaseControl
						label={ __('Container', 'khutar' ) }
						id="khutar_meta_container"
						className="khutar-meta-control khutar-meta-button-group khutar_meta_container">
						<ButtonGroup>
							<Button
								isPrimary={ 'default' === ( this.props.metaValue('khutar_meta_container') || 'default' ) }
								isSecondary={ 'default' !== ( this.props.metaValue('khutar_meta_container') || 'default' ) }
								onClick={ () => {
									this.updateValues( 'khutar_meta_container', 'default' );
								} }
							> { __( 'Default', 'khutar' ) } </Button>
							<Button
								isPrimary={ 'contained' === this.props.metaValue('khutar_meta_container') }
								isSecondary={ 'contained' !== this.props.metaValue('khutar_meta_container') }
								onClick={ () => {
									this.updateValues( 'khutar_meta_container', 'contained' );
								} }
							> { __( 'Contained', 'khutar' ) } </Button>
							<Button
								isPrimary={ 'full-width' === this.props.metaValue('khutar_meta_container') }
								isSecondary={ 'full-width' !== this.props.metaValue('khutar_meta_container') }
								onClick={ () => {
									this.updateValues( 'khutar_meta_container', 'full-width' );
								} }
							> { __( 'Full Width', 'khutar' ) } </Button>
						</ButtonGroup>
					</BaseControl>

					<BaseControl
						id="khutar_meta_enable_content_width"
						className="khutar-meta-control khutar-meta-checkbox khutar_meta_enable_content_width" >
						<ToggleControl
							label={ __( 'Custom Content Width (%)', 'khutar' ) }
							checked={ ( 'on' === this.props.metaValue('khutar_meta_enable_content_width') ) }
							onChange={ (value) => {
								this.updateValues( 'khutar_meta_enable_content_width', ( value ? 'on' : 'off' ) );
								this.updateValues( 'khutar_meta_content_width', ( this.props.metaValue('khutar_meta_content_width') || 70 ) );
							} }
						/>
					</BaseControl>

					{
						'on' === this.props.metaValue('khutar_meta_enable_content_width') ?
							<BaseControl
								id="khutar_meta_content_width"
								className="khutar-meta-control khutar-meta-range khutar_meta_content_width" >
								<RangeControl
									value={ this.props.metaValue('khutar_meta_content_width') }
									onChange={ (value) => {
										this.updateValues( 'khutar_meta_content_width', value );
									} }
									min={0}
									max={100}
									step="1"
								/>
							</BaseControl> :
							''
					}
				</PanelBody>
			</div>
		);
	}

	renderPageTitleGroup() {
		const template = wp.data.select('core/editor').getEditedPostAttribute('template');
		if ( 'elementor_header_footer' === template ) {
			return false;
		}
		const showMetaElements = JSON.parse( this.props.metaValue('khutar_post_elements_order') || this.defaultSortables ).includes('meta');
		const postType = wp.data.select('core/editor').getCurrentPostType();
		return (
			<div className="nv-option-category">
				<PanelBody
					title={__('Page Title', 'khutar')}
					intialOpen={ true }
				>
					<BaseControl
						label={ __('Title alignment', 'khutar' ) }
						id="khutar_meta_title_alignment"
						className="khutar-meta-control khutar-meta-button-group khutar_meta_title_alignment">
						<ButtonGroup>
							<Button
								icon={alignLeftIcon}
								className="nv-align-left"
								isPrimary={ 'left' === ( this.props.metaValue('khutar_meta_title_alignment') || 'left' ) }
								isSecondary={ 'left' !== ( this.props.metaValue('khutar_meta_title_alignment') || 'left') }
								onClick={ () => {
									this.updateValues( 'khutar_meta_title_alignment', 'left' );
								} }
							/>
							<Button
								icon={alignCenterIcon}
								className="nv-align-center"
								isPrimary={ 'center' === this.props.metaValue('khutar_meta_title_alignment') }
								isSecondary={ 'center' !== this.props.metaValue('khutar_meta_title_alignment') }
								onClick={ () => {
									this.updateValues( 'khutar_meta_title_alignment', 'center' );
								} }
							/>
							<Button
								icon={alignRightIcon}
								className="nv-align-right"
								isPrimary={ 'right' === this.props.metaValue('khutar_meta_title_alignment') }
								isSecondary={ 'right' !== this.props.metaValue('khutar_meta_title_alignment') }
								onClick={ () => {
									this.updateValues( 'khutar_meta_title_alignment', 'right' );
								} }
							/>
						</ButtonGroup>
					</BaseControl>

					{
						showMetaElements && 'post' === postType ?
							<BaseControl
								id="khutar_meta_author_avatar"
								className="khutar-meta-control khutar-meta-checkbox khutar_meta_author_avatar" >
								<ToggleControl
									label={ __( 'Author Avatar', 'khutar' ) }
									checked={ ( 'on' === this.props.metaValue('khutar_meta_author_avatar') ) }
									onChange={ (value) => {
										this.updateValues( 'khutar_meta_author_avatar', ( value ? 'on' : 'off' ) );
									} }
								/>
							</BaseControl> :
							''
					}
					{
						metaSidebar.enable_pro && showMetaElements && 'post' === postType ?
							<BaseControl
								id="khutar_meta_reading_time"
								className="khutar-meta-control khutar-meta-checkbox khutar_meta_reading_time" >
								<ToggleControl
									label={ __( 'Reading Time', 'khutar' ) }
									checked={ ( 'on' === this.props.metaValue('khutar_meta_reading_time') ) }
									onChange={ (value) => {
										this.updateValues( 'khutar_meta_reading_time', ( value ? 'on' : 'off' ) );
									} }
								/>
							</BaseControl> :
							''
					}
				</PanelBody>
			</div>
		);
	}

	renderElementsGroup() {
		let settings = {
			elements: {
				'title': __( 'Post Title', 'khutar' ),
				'meta': __( 'Post Meta', 'khutar'),
				'thumbnail': __( 'Featured Image', 'khutar'),
				'content': __( 'Content', 'khutar'),
				'tags': __( 'Tags', 'khutar'),
				'comments': __('Comments', 'khutar' ),
				'post-navigation': __( 'Post Navigation', 'khutar')
			},
			default: metaSidebar.elementsDefaultOrder
		};

		if ( metaSidebar.enable_pro ) {
			settings.elements['author-biography'] = __( 'Author Biography', 'khutar' );
			settings.elements['related-posts']    = __( 'Related Posts', 'khutar' );
			settings.elements['sharing-icons']    = __( 'Sharing Icons', 'khutar' );
		}

		const template = wp.data.select('core/editor').getEditedPostAttribute('template');
		const postType = wp.data.select('core/editor').getCurrentPostType();
		return (
			<div className="nv-option-category">
				<PanelBody
					title={__('Elements', 'khutar')}
					intialOpen={ true }
				>
					{
						'elementor_header_footer' !== template && 'post' === postType ?
							<BaseControl
								id="khutar_post_elements_order"
								className="khutar-meta-control khutar-meta-sortable" >
								<SortableItems stateUpdate={this.updateValues} id="khutar_post_elements_order" data={settings}/>
							</BaseControl> :
							''
					}

					<BaseControl
						id="khutar_meta_disable_header"
						className="khutar-meta-control khutar-meta-checkbox khutar_meta_disable_header" >
						<ToggleControl
							label={ __( 'Disable Header', 'khutar' ) }
							checked={ ( 'on' === this.props.metaValue('khutar_meta_disable_header') ) }
							onChange={ (value) => {
								this.updateValues( 'khutar_meta_disable_header', ( value ? 'on' : 'off' ) );
							} }
						/>
					</BaseControl>

					<BaseControl
						id="khutar_meta_disable_footer"
						className="khutar-meta-control khutar-meta-checkbox khutar_meta_disable_footer" >
						<ToggleControl
							label={ __( 'Disable Footer', 'khutar' ) }
							checked={ ( 'on' === this.props.metaValue('khutar_meta_disable_footer') ) }
							onChange={ (value) => {
								this.updateValues( 'khutar_meta_disable_footer', ( value ? 'on' : 'off' ) );
							} }
						/>
					</BaseControl>

					{
						'elementor_header_footer' !== template &&  'page' === postType ?
							<BaseControl
								id="khutar_meta_disable_title"
								className="khutar-meta-control khutar-meta-checkbox khutar_meta_disable_title" >
								<ToggleControl
									label={ __( 'Disable Title', 'khutar' ) }
									checked={ ( 'on' === this.props.metaValue('khutar_meta_disable_title') ) }
									onChange={ (value) => {
										this.updateValues( 'khutar_meta_disable_title', ( value ? 'on' : 'off' ) );
									} }
								/>
							</BaseControl> :
							''
					}

				</PanelBody>
			</div>
		);
	}

	renderResetButton() {
		return (
			<BaseControl
				label={__('Reset all options to default', 'khutar')}
				id="khutar_reset_all"
				className="nv-reset-all components-panel__body is-opened" >
				<Button
					icon="image-rotate"
					className="nv-reset-meta"
					onClick={ () => {
						this.resetAll();
					} }
					label={ __( 'Return to customizer settings', 'khutar' ) }
					showTooltip={ true }
				/>
			</BaseControl>
		);
	}

	render() {
		return (
			<>
				{this.renderPageLayoutGroup()}
				{this.renderPageTitleGroup()}
				{this.renderElementsGroup()}
				{this.renderResetButton()}
			</>
		);
	}
}

export default compose([

	withDispatch(( dispatch ) => {
		return {
			setMetaValue: ( id, value ) => {
				dispatch('core/editor').editPost({meta: {[id]: value}});
			},
			setAllMetas: ( value ) => {
				dispatch('core/editor').editPost({meta: value});
			}
		};
	}),
	withSelect(( select ) => {
		return {
			metaValue: (id) => {
				return select('core/editor').getEditedPostAttribute('meta')[id];
			},
			allMeta: select('core/editor').getEditedPostAttribute('meta')
		};
	})

])( MetaFieldsManager );
