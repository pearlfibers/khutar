<?php
/**
 * Button Component class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  Bogdan Preda <bogdan.preda@pearlfibers.com>
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use khutar\Core\Settings\Config;
use khutar\Core\Styles\Dynamic_Selector;

/**
 * Class Button
 *
 * @package HFG\Core\Components
 */
class Search extends Abstract_Component {

	const COMPONENT_ID        = 'header_search';
	const PLACEHOLDER_ID      = 'placeholder';
	const FIELD_HEIGHT        = 'field_height';
	const FIELD_FONT_SIZE     = 'field_text_size';
	const FIELD_BG            = 'field_background';
	const FIELD_TEXT_COLOR    = 'field_text_color';
	const FIELD_BORDER_WIDTH  = 'field_border_width';
	const FIELD_BORDER_RADIUS = 'field_border_radius';

	/**
	 * Button constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Search Form', 'khutar' ) );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'component_slug', 'hfg-search-form' );
		$this->set_property( 'width', 2 );
		$this->set_property( 'icon', 'code-standards' );
		$this->set_property( 'default_selector', '.builder-item--' . $this->get_id() . ' > .search-field form' );
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::PLACEHOLDER_ID,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => __( 'Search for...', 'khutar' ),
				'label'              => __( 'Placeholder', 'khutar' ),
				'type'               => 'text',
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);


		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_HEIGHT,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'section'               => $this->section,
				'label'                 => __( 'Height', 'khutar' ),
				'type'                  => '\khutar\Customizer\Controls\React\Responsive_Range',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'responsive' => true,
					'template'   =>
						'body ' . $this->default_selector . ' input[type=search] {
							height: {{value}}px;
						}',
				],
				'options'               => [
					'input_attrs' => [
						'step'       => 1,
						'min'        => 10,
						'max'        => 200,
						'defaultVal' => [
							'mobile'  => 40,
							'tablet'  => 40,
							'desktop' => 40,
						],
						'units'      => [ 'px' ],
					],
				],
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'default'               => [
					'mobile'  => 40,
					'tablet'  => 40,
					'desktop' => 40,
				],
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_FONT_SIZE,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'section'               => $this->section,
				'label'                 => __( 'Font Size', 'khutar' ),
				'type'                  => '\khutar\Customizer\Controls\React\Responsive_Range',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'responsive' => true,
					'template'   =>
						'body ' . $this->default_selector . ' input[type=search] {
							font-size: {{value}}px;
							padding-right: calc({{value}}px + 5px);
						}
						body ' . $this->default_selector . ' .nv-search-icon-wrap .nv-icon svg {
							width: {{value}}px;
							height: {{value}}px;
						}
						body ' . $this->default_selector . ' .search-form input[type=submit], body ' . $this->default_selector . ' .search-form .nv-search-icon-wrap {
							width: {{value}}px;
						}',
				],
				'options'               => [
					'input_attrs' => [
						'step'       => 1,
						'min'        => 10,
						'max'        => 200,
						'defaultVal' => [
							'mobile'  => 14,
							'tablet'  => 14,
							'desktop' => 14,
						],
						'units'      => [ 'px' ],
					],
				],
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'default'               => [
					'mobile'  => 14,
					'tablet'  => 14,
					'desktop' => 14,
				],
				'conditional_header'    => true,
			]
		);

		$default_border_width = [
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
			'desktop'      => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
			'tablet'       => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
			'mobile'       => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
		];

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_BORDER_WIDTH,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				'default'               => $default_border_width,
				'label'                 => __( 'Border Width', 'khutar' ),
				'type'                  => '\khutar\Customizer\Controls\React\Spacing',
				'options'               => [
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 20,
						'units' => [ 'px' ],
					),
					'default'     => $default_border_width,
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'responsive'  => true,
					'directional' => true,
					'template'    =>
						'body ' . $this->default_selector . ' input[type=search] {
							border-top-width: {{value.top}};
							border-right-width: {{value.right}};
							border-bottom-width: {{value.bottom}};
							border-left-width: {{value.left}};
						}',
				],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);
		$default_border_radius = [
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
			'desktop'      => [
				'top'    => 3,
				'right'  => 3,
				'bottom' => 3,
				'left'   => 3,
			],
			'tablet'       => [
				'top'    => 3,
				'right'  => 3,
				'bottom' => 3,
				'left'   => 3,
			],
			'mobile'       => [
				'top'    => 3,
				'right'  => 3,
				'bottom' => 3,
				'left'   => 3,
			],
		];
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_BORDER_RADIUS,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				'default'               => $default_border_width,
				'label'                 => __( 'Border Radius', 'khutar' ),
				'type'                  => '\khutar\Customizer\Controls\React\Spacing',
				'options'               => [
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100,
						'units' => [ 'px' ],
					),
					'default'     => $default_border_radius,
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'responsive'  => true,
					'directional' => true,
					'template'    =>
						'body ' . $this->default_selector . ' input[type=search] {
							border-top-left-radius: {{value.top}};
							border-top-right-radius: {{value.right}};
							border-bottom-right-radius: {{value.bottom}};
							border-bottom-left-radius: {{value.left}};
						}',
				],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_BG,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'khutar_sanitize_colors',
				'label'                 => __( 'Background Color', 'khutar' ),
				'type'                  => '\khutar\Customizer\Controls\React\Color',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'template' =>
						'body ' . $this->default_selector . ' input[type=search] {
							background-color: {{value}} !important;
						}',
					'fallback' => '#ffffff',
				],
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_TEXT_COLOR,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'khutar_sanitize_colors',
				'label'                 => __( 'Text and Border', 'khutar' ),
				'type'                  => 'khutar_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'template' =>
						'body ' . $this->default_selector . ' input[type=search], body ' . $this->default_selector . ' input::placeholder {
							color: {{value}};
						}
						body ' . $this->default_selector . ' input[type=search] {
							border-color: {{value}};
						}
						body ' . $this->default_selector . ' .nv-search-icon-wrap .nv-icon svg {
							fill: {{value}};
						}',
				],
				'conditional_header'    => true,
			]
		);
	}

	/**
	 * Method to add Component css styles.
	 *
	 * @param array $css_array An array containing css rules.
	 *
	 * @return array
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_style( array $css_array = array() ) {
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' input[type=submit],' . $this->default_selector . ' .nv-search-icon-wrap',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' input[type=search]',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_HEIGHT           => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_HEIGHT,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_HEIGHT ),
				],
				Config::CSS_PROP_FONT_SIZE        => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
				Config::CSS_PROP_PADDING_RIGHT    => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						$fs      = $value;
						$style   = '';
						$padding = $fs > 45 ? $fs : 45;
						if ( ! empty( $fs ) ) {
							$style = sprintf( 'padding-right:%spx;', $padding );
						}
						return $style;
					},
				],

				Config::CSS_PROP_BORDER_WIDTH     => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_BORDER_WIDTH,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BORDER_WIDTH ),
				],
				Config::CSS_PROP_BORDER_RADIUS    => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_BORDER_RADIUS,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BORDER_RADIUS ),
				],
				Config::CSS_PROP_BACKGROUND_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_BG,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BG ),
				],
				Config::CSS_PROP_BORDER_COLOR     => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' input[type=search],' . $this->default_selector . ' input::placeholder',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .nv-search-icon-wrap .nv-icon svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
				],
				Config::CSS_PROP_WIDTH      => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
				Config::CSS_PROP_HEIGHT     => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
			],
		];

		return parent::add_style( $css_array );
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		add_filter( 'get_search_form', [ $this, 'change_placeholder' ] );
		Main::get_instance()->load( 'components/component-search' );
		remove_filter( 'get_search_form', [ $this, 'change_placeholder' ] );
	}

	/**
	 * Change the form placeholder.
	 *
	 * @param string $form form markup.
	 *
	 * @return string
	 */
	public function change_placeholder( $form ) {
		$form        = '';
		$placeholder = get_theme_mod( $this->get_id() . '_placeholder', __( 'Search for...', 'khutar' ) );

		$form .= '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">';
		$form .= '<label>';
		$form .= '<span class="screen-reader-text">' . __( 'Search for...', 'khutar' ) . '</span>';
		$form .= '<input type="search" class="search-field" placeholder="' . esc_html( $placeholder ) . '" value="" name="s">';
		$form .= '</label>';
		$form .= '<input type="submit" class="search-submit" value="Search">';
		$form .= '</form>';

		return $form;
	}
}
