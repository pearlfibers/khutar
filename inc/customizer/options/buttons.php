<?php
/**
 * Buttons section.
 *
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      20/08/2018
 *
 * @package khutar\Customizer\Options
 */

namespace khutar\Customizer\Options;

use khutar\Core\Settings\Config;
use khutar\Customizer\Base_Customizer;
use khutar\Customizer\Types\Control;
use khutar\Customizer\Types\Section;

/**
 * Class Buttons
 *
 * @package khutar\Customizer\Options
 */
class Buttons extends Base_Customizer {

	/**
	 * Customizer section slug.
	 *
	 * @var string
	 */
	private $section_id = 'khutar_buttons_section';

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->add_section(
			new Section(
				$this->section_id,
				array(
					'priority' => 40,
					'title'    => esc_html__( 'Buttons', 'khutar' ),
				)
			)
		);

		$this->add_control(
			new Control(
				'buttons_tabs',
				array(
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				),
				array(
					'priority' => - 100,
					'section'  => $this->section_id,
					'tabs'     => array(
						'button'           => array(
							'label' => esc_html__( 'Primary', 'khutar' ),
						),
						'secondary_button' => array(
							'label' => esc_html__( 'Secondary', 'khutar' ),
						),
					),
					'controls' => array(
						'button'           => array(
							'khutar_button_appearance' => array(),
							'khutar_button_padding'    => array(),
							'khutar_button_typeface'   => array(),
						),
						'secondary_button' => array(
							'khutar_secondary_button_appearance' => array(),
							'khutar_secondary_button_padding'    => array(),
							'khutar_secondary_button_typeface'   => array(),
						),
					),
				),
				'khutar\Customizer\Controls\Tabs'
			)
		);

		$buttons                = [ 'button', 'secondary_button' ];
		$live_refresh_selectors = [
			'button'           => apply_filters( 'khutar_selectors_' . Config::CSS_SELECTOR_BTN_PRIMARY_NORMAL, Config::$css_selectors_map[ Config::CSS_SELECTOR_BTN_PRIMARY_NORMAL ] ),
			'secondary_button' => apply_filters( 'khutar_selectors_' . Config::CSS_SELECTOR_BTN_SECONDARY_NORMAL, Config::$css_selectors_map[ Config::CSS_SELECTOR_BTN_SECONDARY_NORMAL ] ),
		];
		foreach ( $buttons as $button ) {
			$defaults = khutar_get_button_appearance_default( $button );
			$this->add_control(
				new Control(
					'khutar_' . $button . '_appearance',
					[
						'sanitize_callback' => 'khutar_sanitize_button_appearance',
						'default'           => $defaults,
					],
					[
						'defaultVals' => $defaults,
						'label'       => __( 'Button Appearance', 'khutar' ),
						'section'     => $this->section_id,
						'type'        => 'khutar_button_appearance',
					]
				)
			);
			$default_padding_values = array(
				'desktop'      => array(
					'top'    => 8,
					'right'  => 12,
					'bottom' => 8,
					'left'   => 12,
				),
				'tablet'       => array(
					'top'    => 8,
					'right'  => 12,
					'bottom' => 8,
					'left'   => 12,
				),
				'mobile'       => array(
					'top'    => 8,
					'right'  => 12,
					'bottom' => 8,
					'left'   => 12,
				),
				'desktop-unit' => 'px',
				'tablet-unit'  => 'px',
				'mobile-unit'  => 'px',
			);

			$this->add_control(
				new Control(
					'khutar_' . $button . '_padding',
					array(
						'default' => $default_padding_values,
					),
					array(
						'label'             => __( 'Padding', 'khutar' ),
						'sanitize_callback' => array( $this, 'sanitize_spacing_array' ),
						'section'           => $this->section_id,
						'input_attrs'       => [
							'units' => [ 'px' ],
						],
						'default'           => $default_padding_values,
					),
					'\khutar\Customizer\Controls\React\Spacing'
				)
			);
			$this->add_control(
				new Control(
					'khutar_' . $button . '_border_radius',
					array(
						'sanitize_callback' => 'absint',
						'default'           => 3,
					),
					array(
						'label'      => esc_html__( 'Border radius', 'khutar' ) . '(px)',
						'section'    => $this->section_id,
						'type'       => 'range-value',
						'step'       => 1,
						'input_attr' => array(
							'min'     => 0,
							'max'     => 50,
							'default' => 3,
						),
					),
					'khutar\Customizer\Controls\Range'
				)
			);

			$this->add_control(
				new Control(
					'khutar_' . $button . '_typeface',
					[
						'transport' => $this->selective_refresh,
					],
					[
						'label'                 => esc_html__( 'Button Text', 'khutar' ),
						'section'               => $this->section_id,
						'input_attrs'           => array(
							'size_units'             => [ 'px' ],
							'weight_default'         => 400,
							'size_default'           => array(
								'suffix'  => array(
									'mobile'  => 'px',
									'tablet'  => 'px',
									'desktop' => 'px',
								),
								'mobile'  => 15,
								'tablet'  => 16,
								'desktop' => 16,
							),
							'line_height_default'    => array(
								'mobile'  => 1.6,
								'tablet'  => 1.6,
								'desktop' => 1.6,
							),
							'letter_spacing_default' => array(
								'mobile'  => 0,
								'tablet'  => 0,
								'desktop' => 0,
							),
						),
						'type'                  => 'khutar_typeface_control',
						'live_refresh_selector' => $live_refresh_selectors[ $button ],
					],
					'\khutar\Customizer\Controls\React\Typography'
				)
			);
		}
	}
}
