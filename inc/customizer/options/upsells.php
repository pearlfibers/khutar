<?php
/**
 * Customizer upsells controls.
 *
 * @package khutar\Customizer\Options
 */

namespace khutar\Customizer\Options;

use khutar\Customizer\Base_Customizer;
use khutar\Customizer\Types\Section;
use khutar\Customizer\Types\Control;

/**
 * Class Upsells
 *
 * @package khutar\Customizer\Options
 */
class Upsells extends Base_Customizer {

	/**
	 * Init function
	 *
	 * @return bool|void
	 */
	public function init() {
		if ( defined( 'khutar_PRO_VERSION' ) ) {
			return false;
		}

		parent::init();
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'localize_upsell' ) );
	}

	/**
	 * Localize upsell script and send strings.
	 */
	public function localize_upsell() {
		wp_localize_script(
			'khutar-customizer-controls',
			'upsellConfig',
			array(
				'button_url'    => esc_url( apply_filters( 'khutar_upgrade_link_from_child_theme_filter', 'https://pearlfibers.com/themes/khutar/upgrade/?utm_medium=customizer&utm_source=getpro&utm_campaign=khutar' ) ),
				'button_text'   => esc_html__( 'Get the PRO version!', 'khutar' ),
				'text'          => esc_html__( 'Extend your header with more components and settings, build sticky/transparent headers or display them conditionally.', 'khutar' ),
				'screen_reader' => esc_html__( '(opens in a new tab)', 'khutar' ),
			)
		);
	}

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->wpc->register_section_type( '\khutar\Customizer\Controls\Simple_Upsell_Section' );
		$this->section_upsells();
		$this->control_upsells();
	}

	/**
	 * Add upsells section
	 */
	private function section_upsells() {
		$this->add_section(
			new Section(
				'khutar_upsells_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'View PRO Features', 'khutar' ),
				)
			)
		);
	}

	/**
	 * Add upsells controls
	 */
	private function control_upsells() {
		$this->add_control(
			new Control(
				'khutar_upsell_main_control',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'section'            => 'khutar_upsells_section',
					'priority'           => 100,
					'options'            => array(
						esc_html__( 'Header Booster', 'khutar' ),
						esc_html__( 'Blog Booster', 'khutar' ),
						esc_html__( 'WooCommerce Booster', 'khutar' ),
						esc_html__( 'Custom Layouts', 'khutar' ),
						esc_html__( 'White Label module', 'khutar' ),
						esc_html__( 'Scroll to Top module', 'khutar' ),
						esc_html__( 'Elementor Booster', 'khutar' ),
					),
					'explained_features' => array(
						esc_html__( 'Extend your header with more components and settings, build sticky/transparent headers or display them conditionally.', 'khutar' ),
						esc_html__( 'Easily create custom headers and footers as well as adding your own custom code or content in any of the hooks locations.', 'khutar' ),
						esc_html__( 'Leverage the true flexibility of Elementor with powerful addons and templates that you can import with just one click.', 'khutar' ),
					),
					'button_url'         => esc_url( apply_filters( 'khutar_upgrade_link_from_child_theme_filter', 'https://pearlfibers.com/themes/khutar/upgrade/?utm_medium=customizer&utm_source=getpro&utm_campaign=khutar' ) ),
					'button_text'        => esc_html__( 'Get the PRO version!', 'khutar' ),
					'screen_reader'      => esc_html__( '(opens in new tab)', 'khutar' ),
				),
				'khutar\Customizer\Controls\Upsell_Control'
			)
		);

		$upsells = [
			'blog_archive' => [
				'text'        => __( 'More blog layout customization options available in PRO', 'khutar' ),
				'button_text' => __( 'Learn More', 'khutar' ),
				'section'     => 'khutar_blog_archive_layout',
			],
			'single_post'  => [
				'text'        => __( 'More single post components available in PRO', 'khutar' ),
				'button_text' => __( 'Learn More', 'khutar' ),
				'section'     => 'khutar_single_post_layout',
			],
		];


		if ( class_exists( 'WooCommerce', false ) ) {
			$upsells['product_catalog']       = [
				'text'        => __( 'More product catalog options available in PRO', 'khutar' ),
				'button_text' => __( 'Learn More', 'khutar' ),
				'section'     => 'woocommerce_product_catalog',
			];
			$upsells['woocommerce_checkout']  = [
				'text'        => __( 'More checkout options available in PRO', 'khutar' ),
				'button_text' => __( 'Learn More', 'khutar' ),
				'section'     => 'woocommerce_checkout',
			];
			$upsells['single_product_layout'] = [
				'text'        => __( 'More single product options available in PRO', 'khutar' ),
				'button_text' => __( 'Learn More', 'khutar' ),
				'section'     => 'khutar_single_product_layout',
			];
			$upsells['typography']            = [
				'text'        => __( 'WooCommerce typography options available in PRO', 'khutar' ),
				'button_text' => __( 'Learn More', 'khutar' ),
				'panel'       => 'khutar_typography',
				'type'        => 'section',
			];
		}

		foreach ( $upsells as $id => $args ) {
			if ( isset( $args['type'] ) && $args['type'] === 'section' ) {
				$this->add_section(
					new Section(
						'khutar_' . $id . '_upsell_section',
						array_merge(
							$args,
							[
								'type'     => 'nv_simple_upsell_section',
								'priority' => 10000,
								'link'     => add_query_arg( 'utm_source', $args['panel'], 'https://pearlfibers.com/themes/khutar/upgrade/?utm_medium=customizer&utm_campaign=khutar' ),
							]
						),
						'\khutar\Customizer\Controls\Simple_Upsell_Section'
					)
				);

				return false;
			}
			$this->add_control(
				new Control(
					'khutar_' . $id . '_upsell',
					[ 'sanitize_callback' => 'sanitize_text_field' ],
					array_merge(
						$args,
						[
							'priority' => 10000,
							'link'     => add_query_arg( 'utm_source', $args['section'], 'https://pearlfibers.com/themes/khutar/upgrade/?utm_medium=customizer&utm_campaign=khutar' ),
						]
					),
					'khutar\Customizer\Controls\Simple_Upsell'
				)
			);
		}
	}
}
