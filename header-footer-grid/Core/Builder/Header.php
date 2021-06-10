<?php
/**
 * Header class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  Bogdan Preda <bogdan.preda@pearlfibers.com>
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Builder;

use HFG\Core\Customizer\Header_Presets;
use HFG\Main;
use khutar\Customizer\Controls\React\Presets_Selector;
use WP_Customize_Manager;

/**
 * Class Header
 *
 * @package HFG\Core\Builder
 */
class Header extends Abstract_Builder {

	/**
	 * Builder name.
	 */
	const BUILDER_NAME = 'header';

	/**
	 * Header init.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'title', __( 'Header', 'khutar' ) );
		$this->set_property(
			'description',
			apply_filters(
				'hfg_header_panel_description',
				sprintf(
				/* translators: %s link to documentation */
					esc_html__( 'Design your %1$s by dragging, dropping and resizing all the elements in real-time. %2$s.', 'khutar' ),
					/* translators: %s builder type */
					$this->get_property( 'title' ),
					/* translators: %s link text */
					sprintf(
						'<br/><a target="_blank" rel="external noopener noreferrer" href="https://docs.pearlfibers.com/article/946-khutar-doc#header"><span class="screen-reader-text">%s</span><svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="img" viewBox="0 0 512 512" width="12" height="12" style="margin-right: 5px;"><path fill="currentColor" d="M432 320H400a16 16 0 0 0-16 16V448H64V128H208a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16H48A48 48 0 0 0 0 112V464a48 48 0 0 0 48 48H400a48 48 0 0 0 48-48V336A16 16 0 0 0 432 320ZM488 0h-128c-21.4 0-32 25.9-17 41l35.7 35.7L135 320.4a24 24 0 0 0 0 34L157.7 377a24 24 0 0 0 34 0L435.3 133.3 471 169c15 15 41 4.5 41-17V24A24 24 0 0 0 488 0Z"/></svg>%s</a>',
						esc_html__( '(opens in a new tab)', 'khutar' ),
						esc_html__( 'Read full documentation', 'khutar' )
					)
				)
			)
		);
		$this->set_property(
			'instructions_array',
			array(
				'description' => __( 'Build your own header or choose from preset options.', 'khutar' ),
				'quickLinks'  => array(
					'custom_logo'                       => array(
						'label' => esc_html__( 'Change Logo', 'khutar' ),
						'icon'  => 'dashicons-editor-customchar',
					),
					'hfg_header_layout_main_background' => array(
						'label' => esc_html__( 'Change Header Color', 'khutar' ),
						'icon'  => 'dashicons-admin-appearance',
					),
					'primary-menu_shortcut'             => array(
						'label' => esc_html__( 'Change Menu', 'khutar' ),
						'icon'  => 'dashicons-menu',
					),
				),
			)
		);
	}

	/**
	 * Called to register component controls.
	 *
	 * @param WP_Customize_Manager $wp_customize The Customize Manager.
	 *
	 * @return WP_Customize_Manager
	 * @since   1.0.0
	 * @access  public
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_section(
			'khutar_header_presets',
			[
				'title'    => __( 'Header Presets', 'khutar' ),
				'priority' => 200,
				'panel'    => 'hfg_header',
			]
		);

		$wp_customize->add_setting(
			'hfg_khutar_header_presets',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => __( 'Header Presets', 'khutar' ),
			]
		);
		$wp_customize->add_control(
			new Presets_Selector(
				$wp_customize,
				'hfg_khutar_header_presets',
				[
					'section'   => 'khutar_header_presets',
					'transport' => 'postMessage',
					'priority'  => 30,
					'presets'   => $this->get_header_presets(),
				]
			)
		);


		return parent::customize_register( $wp_customize );
	}


	/**
	 * Method called via hook.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function load_template() {
		Main::get_instance()->load( 'header-wrapper' );
	}

	/**
	 * Get builder id.
	 *
	 * @return string Builder id.
	 */
	public function get_id() {
		return self::BUILDER_NAME;
	}

	/**
	 * Render builder row.
	 *
	 * @param string $device_id   The device id.
	 * @param string $row_id      The row id.
	 * @param array  $row_details Row data.
	 */
	public function render_row( $device_id, $row_id, $row_details ) {

		$name = $row_id;

		if ( $row_id === 'sidebar' && $device_id === 'mobile' ) {
			$name = 'mobile';
		}

		Main::get_instance()->load( 'row-wrapper', $name );
	}


	/**
	 * Return  the builder rows.
	 *
	 * @return array
	 * @since   1.0.0
	 * @updated 1.0.1
	 * @access  protected
	 */
	protected function get_rows() {
		return [
			'top'     => array(
				'title'       => esc_html__( 'Header Top', 'khutar' ),
				'description' => $this->get_property( 'description' ),
			),
			'main'    => array(
				'title'       => esc_html__( 'Header Main', 'khutar' ),
				'description' => $this->get_property( 'description' ),
			),
			'bottom'  => array(
				'title'       => esc_html__( 'Header Bottom', 'khutar' ),
				'description' => $this->get_property( 'description' ),
			),
			'sidebar' => array(
				'title'       => esc_html__( 'Mobile menu content', 'khutar' ),
				'description' => $this->get_property( 'description' ),
			),
		];
	}


	/**
	 * Get the header presets.
	 *
	 * @return array
	 */
	private function get_header_presets() {
		return apply_filters(
			'khutar_header_presets',
			[
				[
					'label' => 'Classic',
					'image' => khutar_ASSETS_URL . 'img/header-presets/Classic.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":4,\"height\":1,\"id\":\"logo\"},{\"x\":4,\"y\":1,\"width\":7,\"height\":1,\"id\":\"primary-menu\"},{\"x\":11,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_search_responsive\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}", "primary-menu_component_align":"right","logo_component_align":"left","header_search_responsive_icon_size":"15"}',
				],
				[
					'label' => 'Inverted',
					'image' => khutar_ASSETS_URL . 'img/header-presets/Inverted.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":6,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_search_responsive\"},{\"x\":0,\"y\":1,\"width\":6,\"height\":1,\"id\":\"primary-menu\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"logo\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","primary-menu_component_align":"left","logo_component_align":"right","header_search_responsive_icon_size":"15"}',
				],
				[
					'label' => 'Centered',
					'image' => khutar_ASSETS_URL . 'img/header-presets/Centered.jpg',
					'setup' => '{"hfg_header_layout": "{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":12,\"height\":1,\"id\":\"logo\"}],\"bottom\":[{\"x\":0,\"y\":1,\"width\":12,\"height\":1,\"id\":\"primary-menu\"}]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","primary-menu_component_align":"center","logo_component_align":"center","header_search_responsive_icon_size":"15"}',
				],
				[
					'label' => 'Spaced',
					'image' => khutar_ASSETS_URL . 'img/header-presets/Spaced.jpg',
					'setup' => '{"hfg_header_layout": "{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_search_responsive\"},{\"x\":4,\"y\":1,\"width\":4,\"height\":1,\"id\":\"logo\"},{\"x\":11,\"y\":1,\"width\":1,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","nav-icon_component_align": "right","logo_component_align": "center","header_search_responsive_icon_size":"25"}',
				],
				[
					'label' => 'Collapsed',
					'image' => khutar_ASSETS_URL . 'img/header-presets/ClassicCollapsed.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":4,\"height\":1,\"id\":\"logo\"},{\"x\":10,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_search_responsive\"},{\"x\":11,\"y\":1,\"width\":1,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":6,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":1,\"height\":1,\"id\":\"header_search_responsive\"},{\"x\":9,\"y\":1,\"width\":3,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","nav-icon_component_align":"right"}',
				],
				[
					'label' => 'Search Field',
					'image' => khutar_ASSETS_URL . 'img/header-presets/SearchField.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":3,\"height\":1,\"id\":\"logo\"},{\"x\":3,\"y\":1,\"width\":6,\"height\":1,\"id\":\"primary-menu\"},{\"x\":9,\"y\":1,\"width\":3,\"height\":1,\"id\":\"header_search\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}","primary-menu_component_align":"left"}',
				],
				[
					'label' => 'Button Item',
					'image' => khutar_ASSETS_URL . 'img/header-presets/ButtonItem.jpg',
					'setup' => '{"hfg_header_layout":"{\"desktop\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":4,\"height\":1,\"id\":\"logo\"},{\"x\":4,\"y\":1,\"width\":6,\"height\":1,\"id\":\"primary-menu\"},{\"x\":10,\"y\":1,\"width\":2,\"height\":1,\"id\":\"button_base\"}],\"bottom\":[]},\"mobile\":{\"top\":[],\"main\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"logo\"},{\"x\":8,\"y\":1,\"width\":4,\"height\":1,\"id\":\"nav-icon\"}],\"bottom\":[],\"sidebar\":[{\"x\":0,\"y\":1,\"width\":8,\"height\":1,\"id\":\"primary-menu\"}]}}", "primary-menu_component_align":"right"}',
				],
			]
		);
	}
}
