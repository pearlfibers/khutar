<?php
/**
 * Customizer typography controls.
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
 * Class Typography
 *
 * @package khutar\Customizer\Options
 */
class Typography extends Base_Customizer {
	/**
	 * Headings default font sizes.
	 *
	 * @var array
	 */
	private $headings_default_sizes = [
		'h1' => [
			'mobile'  => '1.5',
			'tablet'  => '1.5',
			'desktop' => '2',
			'suffix'  => [
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			],
		],
		'h2' => [
			'mobile'  => '1.3',
			'tablet'  => '1.3',
			'desktop' => '1.75',
			'suffix'  => [
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			],
		],
		'h3' => [
			'mobile'  => '1.1',
			'tablet'  => '1.1',
			'desktop' => '1.5',
			'suffix'  => [
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			],
		],
		'h4' => [
			'mobile'  => '1',
			'tablet'  => '1',
			'desktop' => '1.25',
			'suffix'  => [
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			],
		],
		'h5' => [
			'mobile'  => '0.75',
			'tablet'  => '0.75',
			'desktop' => '1',
			'suffix'  => [
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			],
		],
		'h6' => [
			'mobile'  => '0.75',
			'tablet'  => '0.75',
			'desktop' => '1',
			'suffix'  => [
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			],
		],
	];

	/**
	 * Add controls
	 */
	public function add_controls() {
		$this->sections_typography();
		$this->controls_typography_general();
		$this->controls_typography_headings();
		$this->controls_typography_blog();
	}

	/**
	 * Add the customizer section.
	 */
	private function sections_typography() {
		$typography_sections = array(
			'khutar_typography_general'  => array(
				'title'    => __( 'General', 'khutar' ),
				'priority' => 25,
			),
			'khutar_typography_headings' => array(
				'title'    => __( 'Headings', 'khutar' ),
				'priority' => 35,
			),
			'khutar_typography_blog'     => array(
				'title'    => __( 'Blog', 'khutar' ),
				'priority' => 45,
			),
		);

		foreach ( $typography_sections as $section_id => $section_data ) {
			$this->add_section(
				new Section(
					$section_id,
					array(
						'title'    => $section_data['title'],
						'panel'    => 'khutar_typography',
						'priority' => $section_data['priority'],
					)
				)
			);
		}
	}

	/**
	 * Add general typography controls
	 */
	private function controls_typography_general() {
		/**
		 * Body font family
		 */

		$this->add_control(
			new Control(
				'khutar_body_font_family',
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'                 => esc_html__( 'Body', 'khutar' ),
					'section'               => 'khutar_typography_general',
					'priority'              => 10,
					'type'                  => 'khutar_font_family_control',
					'live_refresh_selector' => apply_filters( 'khutar_body_font_family_selectors', 'body, .site-title' ),
				],
				'\khutar\Customizer\Controls\React\Font_Family'
			)
		);

		$this->add_control(
			new Control(
				'khutar_typeface_general',
				[
					'transport' => $this->selective_refresh,
					'default'   => $this->get_body_typography_defaults(),
				],
				[
					'priority'              => 11,
					'section'               => 'khutar_typography_general',
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
					'live_refresh_selector' => 'body, .site-title',
				],
				'\khutar\Customizer\Controls\React\Typography'
			)
		);

		/**
		 * Fallback Font Family.
		 */
		$this->add_control(
			new Control(
				'khutar_fallback_font_family',
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'Arial, Helvetica, sans-serif',
				],
				[
					'label'       => esc_html__( 'Fallback Font', 'khutar' ),
					'section'     => 'khutar_typography_general',
					'priority'    => 12,
					'type'        => 'khutar_font_family_control',
					'input_attrs' => [
						'system' => true,
						'link'   => [
							'string'  => __( 'Learn more about fallback fonts', 'khutar' ),
							'url'     => esc_url( 'https://docs.pearlfibers.com/article/1319-fallback-fonts' ),
							'new_tab' => true,
						],
					],
				],
				'\khutar\Customizer\Controls\React\Font_Family'
			)
		);

	}

	/**
	 * Add controls for typography headings.
	 */
	private function controls_typography_headings() {
		/**
		 * Headings font family
		 */
		$this->add_control(
			new Control(
				'khutar_headings_font_family',
				array(
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'section'               => 'khutar_typography_headings',
					'priority'              => 10,
					'type'                  => 'khutar_font_family_control',
					'live_refresh_selector' => apply_filters( 'khutar_headings_font_family_selectors', 'h1:not(.site-title), .single h1.entry-title, h2, h3, .woocommerce-checkout h3, h4, h5, h6' ),
					'input_attrs'           => [
						'default_is_inherit' => true,
					],
				),
				'\khutar\Customizer\Controls\React\Font_Family'
			)
		);

		$selectors = khutar_get_headings_selectors();
		$priority  = 20;
		foreach ( $this->headings_default_sizes as $heading_id => $default_values ) {
			$this->add_control(
				new Control(
					'khutar_' . $heading_id . '_accordion_wrap',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'transport'         => $this->selective_refresh,
					),
					array(
						'label'            => $heading_id,
						'section'          => 'khutar_typography_headings',
						'priority'         => $priority += 1,
						'class'            => esc_attr( 'advanced-sidebar-accordion-' . $heading_id ),
						'accordion'        => true,
						'controls_to_wrap' => 1,
						'expanded'         => false,
					),
					'khutar\Customizer\Controls\Heading'
				)
			);

			$this->add_control(
				new Control(
					'khutar_' . $heading_id . '_typeface_general',
					[
						'transport' => $this->selective_refresh,
						'default'   => $this->get_headings_typography_defaults( $heading_id ),
					],
					[
						'priority'              => $priority += 1,
						'section'               => 'khutar_typography_headings',
						'input_attrs'           => array(
							'size_units'             => [ 'em', 'px' ],
							'weight_default'         => 600,
							'size_default'           => $this->headings_default_sizes[ $heading_id ],
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
						'live_refresh_selector' => $selectors[ $heading_id ],
					],
					'\khutar\Customizer\Controls\React\Typography'
				)
			);
		}
	}

	/**
	 * Add controls for blog typography.
	 */
	private function controls_typography_blog() {
		$controls = array(
			'khutar_archive_typography_post_title'         => array(
				'label'                 => __( 'Post title', 'khutar' ),
				'category_label'        => __( 'Blog Archive', 'khutar' ),
				'priority'              => 10,
				'live_refresh_selector' => '.blog .blog-entry-title, .archive .blog-entry-title',
			),
			'khutar_archive_typography_post_excerpt'       => array(
				'label'                 => __( 'Post excerpt', 'khutar' ),
				'priority'              => 20,
				'live_refresh_selector' => '.blog .entry-summary, .archive .entry-summary, .blog .post-pages-links',
			),
			'khutar_archive_typography_post_meta'          => array(
				'label'                 => __( 'Post meta', 'khutar' ),
				'priority'              => 30,
				'live_refresh_selector' => '.blog .nv-meta-list li, .archive .nv-meta-list li',
			),
			'khutar_single_post_typography_post_title'     => array(
				'label'                 => __( 'Post title', 'khutar' ),
				'category_label'        => __( 'Single Post', 'khutar' ),
				'priority'              => 40,
				'live_refresh_selector' => '.single h1.entry-title',
			),
			'khutar_single_post_typography_post_meta'      => array(
				'label'                 => __( 'Post meta', 'khutar' ),
				'priority'              => 50,
				'live_refresh_selector' => '.single .nv-meta-list li',
			),
			'khutar_single_post_typography_comments_title' => array(
				'label'                 => __( 'Comments reply title', 'khutar' ),
				'priority'              => 60,
				'live_refresh_selector' => '.single .comment-reply-title',
			),
		);

		foreach ( $controls as $control_id => $control_settings ) {
			$settings = array(
				'label'            => $control_settings['label'],
				'section'          => 'khutar_typography_blog',
				'priority'         => $control_settings['priority'],
				'class'            => esc_attr( 'typography-blog-' . $control_id ),
				'accordion'        => true,
				'controls_to_wrap' => 1,
				'expanded'         => false,
			);
			if ( array_key_exists( 'category_label', $control_settings ) ) {
				$settings['category_label'] = $control_settings['category_label'];
			}

			$this->add_control(
				new Control(
					$control_id . '_accordion_wrap',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'transport'         => $this->selective_refresh,
					),
					$settings,
					'khutar\Customizer\Controls\Heading'
				)
			);

			$this->add_control(
				new Control(
					$control_id,
					[
						'transport' => $this->selective_refresh,
					],
					[
						'priority'              => $control_settings['priority'] += 1,
						'section'               => 'khutar_typography_blog',
						'type'                  => 'khutar_typeface_control',
						'live_refresh_selector' => $control_settings['live_refresh_selector'],
						'refresh_on_reset'      => true,
						'input_attrs'           => array(
							'default_is_empty'       => true,
							'size_units'             => [ 'em', 'px' ],
							'weight_default'         => 'none',
							'size_default'           => array(
								'suffix'  => array(
									'mobile'  => 'px',
									'tablet'  => 'px',
									'desktop' => 'px',
								),
								'mobile'  => '',
								'tablet'  => '',
								'desktop' => '',
							),
							'line_height_default'    => array(
								'mobile'  => '',
								'tablet'  => '',
								'desktop' => '',
							),
							'letter_spacing_default' => array(
								'mobile'  => '',
								'tablet'  => '',
								'desktop' => '',
							),
						),
					],
					'\khutar\Customizer\Controls\React\Typography'
				)
			);
		}
	}

	/**
	 * Get the body typography defaults.
	 *
	 * @return array
	 */
	private function get_body_typography_defaults() {
		$default = array(
			'fontSize'      => array(
				'suffix'  => array(
					'mobile'  => 'px',
					'tablet'  => 'px',
					'desktop' => 'px',
				),
				'mobile'  => 15,
				'tablet'  => 16,
				'desktop' => 16,
			),
			'lineHeight'    => array(
				'mobile'  => 1.6,
				'tablet'  => 1.6,
				'desktop' => 1.6,
			),
			'letterSpacing' => array(
				'mobile'  => 0,
				'tablet'  => 0,
				'desktop' => 0,
			),
			'fontWeight'    => '400',
			'textTransform' => 'none',
		);

		$font_size      = get_theme_mod( 'khutar_body_font_size' );
		$line_height    = get_theme_mod( 'khutar_body_line_height' );
		$spacing        = get_theme_mod( 'khutar_body_letter_spacing' );
		$text_transform = get_theme_mod( 'khutar_body_text_transform' );
		$font_weight    = get_theme_mod( 'khutar_body_font_weight' );

		if ( ! empty( $font_size ) ) {
			$default['fontSize'] = array_merge( json_decode( $font_size, true ), $default['fontSize'] );
		}
		if ( ! empty( $line_height ) ) {
			$default['lineHeight'] = json_decode( $line_height, true );
		}
		if ( ! empty( $spacing ) ) {
			$default['letterSpacing'] = array(
				'mobile'  => $spacing,
				'tablet'  => $spacing,
				'desktop' => $spacing,
			);
		}
		if ( ! empty( $text_transform ) ) {
			$default['textTransform'] = $text_transform;
		}
		if ( ! empty( $font_weight ) ) {
			$default['fontWeight'] = $font_weight;
		}

		return $default;
	}

	/**
	 * Get default value for headings typography.
	 *
	 * @param string $heading_type the heading type [h1,h2,...h6].
	 *
	 * @return array
	 */
	private function get_headings_typography_defaults( $heading_type ) {
		$default_value = array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' => array(
				'mobile'  => 0,
				'tablet'  => 0,
				'desktop' => 0,
			),
			'lineHeight'    => array(
				'mobile'  => 1.6,
				'tablet'  => 1.6,
				'desktop' => 1.6,
			),
			'fontSize'      => array(),
		);

		$old_weight     = get_theme_mod( 'khutar_headings_font_weight' );
		$text_transform = get_theme_mod( 'khutar_headings_text_transform' );
		$old_spacing    = get_theme_mod( 'khutar_headings_letter_spacing' );

		if ( ! empty( $old_weight ) ) {
			$default_value['fontWeight'] = $old_weight;
		}

		if ( ! empty( $text_transform ) ) {
			$default_value['textTransform'] = $text_transform;
		}

		if ( ! empty( $old_spacing ) ) {
			$default_value['letterSpacing'] = array(
				'mobile'  => $old_spacing,
				'tablet'  => $old_spacing,
				'desktop' => $old_spacing,
			);
		}

		// V1 of control.
		$old_line_height = get_theme_mod( 'khutar_headings_line_height' );
		// V2 of control.
		$multiple_line_height = get_theme_mod( 'khutar_' . $heading_type . '_line_height' );
		// Decide between V2 vs. V1.
		$default_line_height = $multiple_line_height ? $multiple_line_height : $old_line_height;
		if ( ! empty( $default_line_height ) ) {
			$default_value['lineHeight'] = json_decode( $default_line_height, true );
		}

		// Old font size dynamically picked from old theme mod, or from default sizes array above.
		$old_font_size             = get_theme_mod( 'khutar_' . $heading_type . '_font_size' );
		$default_value['fontSize'] = ! empty( $old_font_size ) ? json_decode( $old_font_size, true ) : $this->headings_default_sizes[ $heading_type ];

		return $default_value;
	}
}
