<?php
/**
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      17/08/2018
 *
 * @package khutar\Customizer
 */

namespace khutar\Customizer;

use khutar\Core\Factory;

/**
 * Main customizer handler.
 *
 * @package khutar\Customizer
 */
class Loader {

	/**
	 * Customizer modules.
	 *
	 * @var array
	 */
	private $customizer_modules = array();

	/**
	 * Loader constructor.
	 */
	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'enqueue_customizer_preview' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'set_featured_image' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_controls' ) );
	}

	/**
	 * Initialize the customizer functionality
	 */
	public function init() {
		global $wp_customize;

		if ( ! isset( $wp_customize ) ) {
			return;
		}
		$this->define_modules();
		$this->load_modules();
	}

	/**
	 * Define the modules that will be loaded.
	 */
	private function define_modules() {
		$this->customizer_modules = apply_filters(
			'khutar_filter_customizer_modules',
			array(
				'Customizer\Options\Main',
				'Customizer\Options\Layout_Container',
				'Customizer\Options\Layout_Blog',
				'Customizer\Options\Layout_Single_Post',
				'Customizer\Options\Layout_Single_Product',
				'Customizer\Options\Layout_Sidebar',
				'Customizer\Options\Typography',
				'Customizer\Options\Colors_Background',
				'Customizer\Options\Buttons',
				'Customizer\Options\Form_Fields',
				'Customizer\Options\Rtl',
				'Customizer\Options\Upsells',
			)
		);
	}

	/**
	 * Enqueue customizer controls script.
	 */
	public function enqueue_customizer_controls() {
		wp_register_style( 'khutar-customizer-style', khutar_ASSETS_URL . 'css/customizer-style' . ( ( khutar_DEBUG ) ? '' : '.min' ) . '.css', array(), khutar_VERSION );
		wp_style_add_data( 'khutar-customizer-style', 'rtl', 'replace' );
		wp_style_add_data( 'khutar-customizer-style', 'suffix', '.min' );
		wp_enqueue_style( 'khutar-customizer-style' );

		wp_enqueue_script( 'khutar-customizer-controls', khutar_ASSETS_URL . 'js/build/all/customizer-controls.js', array( 'jquery', 'wp-color-picker' ), khutar_VERSION, true );

		$bundle_path  = get_template_directory_uri() . '/inc/customizer/controls/react/bundle/';
		$dependencies = ( include get_template_directory() . '/inc/customizer/controls/react/bundle/controls.asset.php' );
		wp_register_script( 'react-controls', $bundle_path . 'controls.js', $dependencies['dependencies'], $dependencies['version'], true );
		wp_localize_script(
			'react-controls',
			'khutarReactCustomize',
			apply_filters(
				'khutar_react_controls_localization',
				array(
					'headerControls'   => [ 'hfg_header_layout' ],
					'instructionalVid' => esc_url( get_template_directory_uri() . '/header-footer-grid/assets/images/customizer/hfg.mp4' ),
					'dynamicTags'      => array(
						'controls' => array(),
						'options'  => array(),
					),
					'fonts'            => array(
						'System' => khutar_get_standard_fonts(),
						'Google' => khutar_get_google_fonts(),
					),
				)
			)
		);
		wp_enqueue_script( 'react-controls' );

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'react-controls', 'khutar' );
		}

		wp_register_style( 'react-controls', $bundle_path . 'style-controls.css', [ 'wp-components' ], $dependencies['version'] );
		wp_style_add_data( 'react-controls', 'rtl', 'replace' );
		wp_enqueue_style( 'react-controls' );

		wp_enqueue_style(
			'khutar-fonts-control-google-fonts',
			'https://fonts.googleapis.com/css?family=' . join( '|', khutar_get_google_fonts() ) . '&text=Abc&display=swap"',
			[],
			khutar_VERSION
		);
	}

	/**
	 * Enqueue customizer preview script.
	 */
	public function enqueue_customizer_preview() {
		wp_enqueue_style(
			'khutar-customizer-preview-style',
			khutar_ASSETS_URL . 'css/customizer-preview' . ( ( khutar_DEBUG ) ? '' : '.min' ) . '.css',
			array(),
			khutar_VERSION
		);
		wp_register_script(
			'khutar-customizer-preview',
			khutar_ASSETS_URL . 'js/build/all/customizer-preview.js',
			array(),
			khutar_VERSION,
			true
		);
		global $post_id;
		wp_localize_script(
			'khutar-customizer-preview',
			'khutarCustomizePreview',
			apply_filters(
				'khutar_customize_preview_localization',
				array(
					'currentFeaturedImage' => '',
				)
			)
		);
		wp_enqueue_script( 'khutar-customizer-preview' );
	}

	/**
	 * Save featured image in previously localized object.
	 */
	public function set_featured_image() {
		if ( ! is_customize_preview() ) {
			return;
		}
		if ( ! is_singular() ) {
			return;
		}
		$thumbnail = get_the_post_thumbnail_url();
		if ( $thumbnail === false ) {
			return;
		}
		wp_add_inline_script( 'khutar-customizer-preview', 'khutarCustomizePreview.currentFeaturedImage = "' . esc_url( get_the_post_thumbnail_url() ) . '";' );
	}

	/**
	 * Load the customizer modules.
	 *
	 * @return void
	 */
	private function load_modules() {
		$factory = new Factory( $this->customizer_modules );
		$factory->load_modules();
	}
}
