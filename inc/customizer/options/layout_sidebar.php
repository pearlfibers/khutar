<?php
/**
 * Sidebar layout section.
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
 * Class Layout_Sidebar
 *
 * @package khutar\Customizer\Options
 */
class Layout_Sidebar extends Base_Customizer {
	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->section_sidebar();
		$this->add_main_controls();
		$this->add_advanced_controls();
	}

	/**
	 * Add customize section
	 */
	private function section_sidebar() {
		$this->add_section(
			new Section(
				'khutar_sidebar',
				array(
					'priority' => 30,
					'title'    => esc_html__( 'Content / Sidebar', 'khutar' ),
					'panel'    => 'khutar_layout',
				)
			)
		);
	}

	/**
	 * Site-wide controls that will affect all pages.
	 */
	private function add_main_controls() {
		$this->add_control(
			new Control(
				'khutar_default_sidebar_layout',
				array(
					'sanitize_callback' => array( $this, 'sanitize_sidebar_layout' ),
					'default'           => 'right',
				),
				array(
					'label'           => __( 'Sitewide Sidebar Layout', 'khutar' ),
					'section'         => 'khutar_sidebar',
					'priority'        => 10,
					'choices'         => $this->sidebar_layout_choices( 'khutar_default_sidebar_layout' ),
					'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\khutar\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'khutar_sitewide_content_width',
				[
					'sanitize_callback' => 'absint',
					'transport'         => $this->selective_refresh,
					'default'           => 70,
				],
				[
					'label'           => esc_html__( 'Sitewide Content Width (%)', 'khutar' ),
					'section'         => 'khutar_sidebar',
					'type'            => 'khutar_range_control',
					'input_attrs'     => [
						'min'        => 50,
						'max'        => 100,
						'defaultVal' => 70,
					],
					'priority'        => 20,
					'active_callback' => [ $this, 'sidewide_options_active_callback' ],
				],
				'khutar\Customizer\Controls\React\Range'
			)
		);

		$this->add_control(
			new Control(
				'khutar_advanced_layout_options',
				array(
					'sanitize_callback' => 'khutar_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'label'    => esc_html__( 'Enable Advanced Options', 'khutar' ),
					'section'  => 'khutar_sidebar',
					'type'     => 'khutar_toggle_control',
					'priority' => 30,
				)
			)
		);
	}

	/**
	 * Get the sidebar layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function sidebar_layout_choices( $control_id ) {
		$options = apply_filters(
			'khutar_sidebar_layout_choices',
			array(
				'full-width' => array(
					'name' => __( 'Full Width', 'khutar' ),
					'url'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAQMAAABknzrDAAAABlBMVEX////V1dXUdjOkAAAAPUlEQVRIx2NgGAUkAcb////Y/+d/+P8AdcQoc8vhH/X/5P+j2kG+GA3CCgrwi43aMWrHqB2jdowEO4YpAACyKSE0IzIuBgAAAABJRU5ErkJggg==',
				),
				'left'       => array(
					'name' => __( 'Left', 'khutar' ),
					'url'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAWElEQVR42mNgGAXDE4RCQMDAKONaBQINWqtWrWBatQDIaxg8ygYqQIAOYwC6bwHUmYNH2eBPSMhgBQXKRr0w6oVRL4x6YdQLo14Y9cKoF0a9QCO3jYLhBADvmFlNY69qsQAAAABJRU5ErkJggg==',
				),
				'right'      => array(
					'name' => __( 'Right', 'khutar' ),
					'url'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAWUlEQVR42mNgGAUjB4iGgkEIzZStAoEVTECiQWsVkLdiECkboAABOmwBF9BtUGcOImUDEiCkJCQU0ECBslEvjHph1AujXhj1wqgXRr0w6oVRLwyEF0bBUAUAz/FTNXm+R/MAAAAASUVORK5CYII=',
				),
			),
			$control_id
		);

		foreach ( $options as $slug => $args ) {
			if ( ! isset( $args['name'] ) ) {
				$options[ $slug ]['name'] = ucwords( str_replace( '-', ' ', $slug ) );
			}
		}

		return $options;
	}

	/**
	 * Advanced controls.
	 */
	private function add_advanced_controls() {
		$this->accordion_heading();
		$this->control_sidebar_layout();
		$this->control_content_width();
	}

	/**
	 * Add headings for advanced controls.
	 */
	private function accordion_heading() {
		$headings = array(
			'khutar_blog_archive_heading' => __( 'Blog / Archive', 'khutar' ),
			'khutar_single_post_heading'  => __( 'Single Post', 'khutar' ),
		);

		if ( class_exists( 'WooCommerce', false ) ) {
			$headings = array_merge(
				$headings,
				array(
					'khutar_shop_archive_heading'   => __( 'Shop / Archive', 'khutar' ),
					'khutar_single_product_heading' => __( 'Single Product', 'khutar' ),
				)
			);
		}
		$headings['khutar_generic_heading'] = __( 'Others', 'khutar' );

		$priority = 40;
		foreach ( $headings as $control_id => $label ) {
			$this->add_control(
				new Control(
					$control_id,
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'transport'         => $this->selective_refresh,
					),
					array(
						'label'            => $label,
						'section'          => 'khutar_sidebar',
						'priority'         => $priority,
						'class'            => esc_attr( 'advanced-sidebar-accordion-' . $control_id ),
						'accordion'        => true,
						'controls_to_wrap' => 2,
						'expanded'         => ( $priority === 40 ), // true or false
						'active_callback'  => array( $this, 'advanced_options_active_callback' ),
					),
					'khutar\Customizer\Controls\Heading'
				)
			);
			$priority += 30;
		}
	}

	/**
	 * Add sidebar layout controls.
	 */
	private function control_sidebar_layout() {

		$priority                = 50;
		$sidebar_layout_controls = array(
			'khutar_blog_archive_sidebar_layout',
			'khutar_single_post_sidebar_layout',
		);

		if ( class_exists( 'WooCommerce', false ) ) {
			$sidebar_layout_controls = array_merge(
				$sidebar_layout_controls,
				array(
					'khutar_shop_archive_sidebar_layout',
					'khutar_single_product_sidebar_layout',
				)
			);
		}
		array_push( $sidebar_layout_controls, 'khutar_other_pages_sidebar_layout' );

		foreach ( $sidebar_layout_controls as $control_id ) {
			$this->add_control(
				new Control(
					$control_id,
					array(
						'sanitize_callback' => array( $this, 'sanitize_sidebar_layout' ),
						'default'           => $this->get_sidebar_control_default_value( $control_id ),
					),
					array(
						'label'           => __( 'Sidebar Layout', 'khutar' ),
						'description'     => $this->get_sidebar_control_description( $control_id ),
						'section'         => 'khutar_sidebar',
						'priority'        => $priority,
						'choices'         => $this->sidebar_layout_choices( $control_id ),
						'active_callback' => array( $this, 'advanced_options_active_callback' ),
					),
					'\khutar\Customizer\Controls\React\Radio_Image'
				)
			);
			$priority += 30;
		}
	}

	/**
	 * Get sidebar control default value.
	 *
	 * @param string $control_id Control id.
	 *
	 * @return string
	 */
	private function get_sidebar_control_default_value( $control_id ) {
		if ( $control_id === 'khutar_single_product_sidebar_layout' ) {
			return 'full-width';
		}

		return 'right';
	}

	/**
	 * Get the description for sidebar position.
	 *
	 * @param string $control_id Control id.
	 *
	 * @return string
	 */
	private function get_sidebar_control_description( $control_id ) {
		if ( $control_id !== 'khutar_shop_archive_sidebar_layout' ) {
			return '';
		}

		$shop_id = get_option( 'woocommerce_shop_page_id' );
		if ( empty( $shop_id ) ) {
			return '';
		}

		$meta = get_post_meta( $shop_id, 'khutar_meta_sidebar', true );
		if ( empty( $meta ) || $meta === 'default' ) {
			return '';
		}

		/* translators: %s is Notice text */
		$template = '<p class="notice notice-info">%s</p>';

		return sprintf(
			$template,
			sprintf(
			/* translators: %s is edit page link */
				esc_html__( 'Note: It seems that the shop page has an individual sidebar layout already set. To be able to control the layout from here, %s your page and set the sidebar to "Inherit".', 'khutar' ),
				sprintf(
				/* translators: %s is edit label */
					'<a target="_blank" href="' . get_edit_post_link( $shop_id ) . '">%s</a>',
					__( 'edit', 'khutar' )
				)
			)
		);

	}

	/**
	 * Add content width controls.
	 */
	private function control_content_width() {
		$priority                = 60;
		$sidebar_layout_controls = array(
			'khutar_blog_archive_content_width',
			'khutar_single_post_content_width',
		);

		if ( class_exists( 'WooCommerce', false ) ) {
			$sidebar_layout_controls = array_merge(
				$sidebar_layout_controls,
				array(
					'khutar_shop_archive_content_width',
					'khutar_single_product_content_width',
				)
			);
		}
		array_push( $sidebar_layout_controls, 'khutar_other_pages_content_width' );
		foreach ( $sidebar_layout_controls as $control_id ) {
			$this->add_control(
				new Control(
					$control_id,
					array(
						'sanitize_callback' => 'absint',
						'transport'         => $this->selective_refresh,
						'default'           => 70,
					),
					array(
						'label'           => esc_html__( 'Content Width (%)', 'khutar' ),
						'section'         => 'khutar_sidebar',
						'type'            => 'khutar_range_control',
						'input_attrs'     => [
							'min'        => 50,
							'max'        => 100,
							'defaultVal' => 70,
						],
						'priority'        => $priority,
						'active_callback' => array( $this, 'advanced_options_active_callback' ),
					),
					'khutar\Customizer\Controls\React\Range'
				)
			);
			$priority += 30;
		}
	}

	/**
	 * Sanitize the sidebar layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return bool
	 */
	public function sanitize_sidebar_layout( $value ) {
		$allowed_values = array( 'left', 'right', 'full-width', 'off-canvas' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'right';
		}

		return esc_html( $value );
	}

	/**
	 * Active callback function for site-wide options
	 */
	public function sidewide_options_active_callback() {
		return ! $this->advanced_options_active_callback();
	}

	/**
	 * Active callback function for advanced controls
	 */
	public function advanced_options_active_callback() {
		return get_theme_mod( 'khutar_advanced_layout_options', false );
	}

}
