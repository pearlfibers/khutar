<?php
/**
 * Colors / Background section.
 *
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      20/08/2018
 *
 * @package khutar\Customizer\Options
 */

namespace khutar\Customizer\Options;

use khutar\Customizer\Base_Customizer;
use khutar\Customizer\Types\Control;
use khutar\Customizer\Types\Section;

/**
 * Class Colors_Background
 *
 * @package khutar\Customizer\Options
 */
class Colors_Background extends Base_Customizer {
	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->wpc->remove_control( 'background_color' );
		$this->section_colors_background();
		$this->controls_colors();
	}

	/**
	 * Add customize section
	 */
	private function section_colors_background() {
		$this->add_section(
			new Section(
				'khutar_colors_background_section',
				array(
					'priority' => 27,
					'title'    => esc_html__( 'Colors & Background', 'khutar' ),
				)
			)
		);
	}

	/**
	 * Add colors controls.
	 */
	private function controls_colors() {
		$this->add_global_colors();
	}

	/**
	 * Change controls.
	 */
	public function change_controls() {
		$priority         = 30;
		$controls_to_move = array(
			'background_image',
			'background_preset',
			'background_position',
			'background_size',
			'background_repeat',
			'background_attachment',
		);

		foreach ( $controls_to_move as $control_slug ) {
			$control           = $this->get_customizer_object( 'control', $control_slug );
			$control->priority = $priority;
			$control->section  = 'khutar_colors_background_section';
			$priority         += 5;
		}
	}

	/**
	 * Add global colors.
	 */
	private function add_global_colors() {
		$this->add_control(
			new Control(
				'khutar_global_colors',
				[
					'sanitize_callback' => [ $this, 'sanitize_global_colors' ],
					'default'           => khutar_get_global_colors_default( true ),
					'transport'         => 'postMessage',
				],
				[
					'label'                 => __( 'Global Colors', 'khutar' ),
					'priority'              => 10,
					'section'               => 'khutar_colors_background_section',
					'type'                  => 'khutar_global_colors',
					'default_values'        => khutar_get_global_colors_default(),
					'input_attrs'           => [
						'link' => [
							'url'     => esc_url( 'https://docs.pearlfibers.com/article/1314-global-colors-in-khutar' ),
							'string'  => esc_html__( 'How the color system works', 'khutar' ),
							'new_tab' => true,
						],
					],
					'live_refresh_selector' => true,
				],
				'khutar\Customizer\Controls\React\Global_Colors'
			)
		);
	}

	/**
	 * Sanitize Global Colors Setting
	 *
	 * @param array $value recieved value.
	 * @return array
	 */
	public function sanitize_global_colors( $value ) {
		// `flag` key is used to trigger setting change on deep state changes inside the palettes.
		if ( isset( $value['flag'] ) ) {
			unset( $value['flag'] );
		}

		$default = khutar_get_global_colors_default();
		if ( ! isset( $value['activePalette'] ) || ! isset( $value['palettes'] ) ) {
			return $default;
		}

		foreach ( $value['palettes'] as $slug => $args ) {
			foreach ( $args['colors'] as $key => $color_val ) {
				$value['palettes'][ $slug ]['colors'][ $key ] = khutar_sanitize_colors( $color_val );
			}
		}

		return $value;
	}
}
