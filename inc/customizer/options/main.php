<?php
/**
 * Handles main customzier setup like root panels.
 *
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      20/08/2018
 *
 * @package khutar\Customizer\Options
 */

namespace khutar\Customizer\Options;

use khutar\Customizer\Base_Customizer;
use khutar\Customizer\Types\Control;
use khutar\Customizer\Types\Panel;
use khutar\Customizer\Types\Partial;
use khutar\Views\Header;

/**
 * Main customizer handler.
 */
class Main extends Base_Customizer {
	/**
	 * Add controls.
	 */
	public function add_controls() {
		$this->register_types();
		$this->add_main_panels();
		$this->add_ui();
		$this->change_controls();
	}

	/**
	 * Register customizer controls type.
	 */
	private function register_types() {
		$this->register_type( 'khutar\Customizer\Controls\Radio_Image', 'control' );
		$this->register_type( 'khutar\Customizer\Controls\Range', 'control' );
		$this->register_type( 'khutar\Customizer\Controls\Responsive_Number', 'control' );
		$this->register_type( 'khutar\Customizer\Controls\Tabs', 'control' );
		$this->register_type( 'khutar\Customizer\Controls\Heading', 'control' );
		$this->register_type( 'khutar\Customizer\Controls\Checkbox', 'control' );
		$this->register_type( 'khutar\Customizer\Controls\Upsell_Control', 'control' );
	}

	/**
	 * Add main panels.
	 */
	private function add_main_panels() {
		$panels = array(
			'khutar_layout'     => array(
				'priority' => 25,
				'title'    => __( 'Layout', 'khutar' ),
			),
			'khutar_typography' => array(
				'priority' => 35,
				'title'    => __( 'Typography', 'khutar' ),
			),
		);

		foreach ( $panels as $panel_id => $panel ) {
			$this->add_panel(
				new Panel(
					$panel_id,
					array(
						'priority' => $panel['priority'],
						'title'    => $panel['title'],
					)
				)
			);
		}
	}

	/**
	 * Adds UI control.
	 */
	private function add_ui() {
		$this->add_control(
			new Control(
				'khutar_ui_control',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'section' => 'static_front_page',
					'type'    => 'khutar_ui_control',
				]
			)
		);
	}

	/**
	 * Change controls
	 */
	protected function change_controls() {
		$this->change_customizer_object( 'section', 'static_front_page', 'panel', 'khutar_layout' );
	}

}
