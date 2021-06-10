<?php
/**
 * Single post layout section.
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
 * Class Layout_Single_Post
 *
 * @package khutar\Customizer\Options
 */
class Layout_Single_Post extends Base_Customizer {
	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->section_single_post();
		$this->control_content_order();
	}

	/**
	 * Add customize section
	 */
	private function section_single_post() {
		$this->add_section(
			new Section(
				'khutar_single_post_layout',
				array(
					'priority' => 40,
					'title'    => esc_html__( 'Single Post', 'khutar' ),
					'panel'    => 'khutar_layout',
				)
			)
		);
	}

	/**
	 * Add content order control.
	 */
	private function control_content_order() {
		$order_default_components = apply_filters(
			'khutar_single_post_elements_default_order',
			array(
				'title-meta',
				'thumbnail',
				'content',
				'tags',
				'comments',
			)
		);

		$components = apply_filters(
			'khutar_single_post_elements',
			array(
				'title-meta'      => __( 'Title & Meta', 'khutar' ),
				'thumbnail'       => __( 'Thumbnail', 'khutar' ),
				'content'         => __( 'Content', 'khutar' ),
				'tags'            => __( 'Tags', 'khutar' ),
				'post-navigation' => __( 'Post navigation', 'khutar' ),
				'comments'        => __( 'Comments', 'khutar' ),
			)
		);

		$this->add_control(
			new Control(
				'khutar_layout_single_post_elements_order',
				array(
					'sanitize_callback' => array( $this, 'sanitize_post_elements_ordering' ),
					'default'           => wp_json_encode( $order_default_components ),
				),
				array(
					'label'      => esc_html__( 'Elements Order', 'khutar' ),
					'section'    => 'khutar_single_post_layout',
					'components' => $components,
					'priority'   => 10,
				),
				'khutar\Customizer\Controls\React\Ordering'
			)
		);
	}

	/**
	 * Sanitize content order control.
	 */
	public function sanitize_post_elements_ordering( $value ) {
		$allowed = array(
			'thumbnail',
			'title-meta',
			'content',
			'tags',
			'post-navigation',
			'comments',
			'author-biography',
			'related-posts',
			'sharing-icons',
		);

		if ( empty( $value ) ) {
			return $allowed;
		}

		$decoded = json_decode( $value, true );

		foreach ( $decoded as $val ) {
			if ( ! in_array( $val, $allowed, true ) ) {
				return $allowed;
			}
		}

		return $value;
	}
}
