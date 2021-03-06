<?php
/**
 * khutar Features Factory
 *
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      17/08/2018
 *
 * @package khutar\Core
 */

namespace khutar\Core;

use khutar\Core\Settings\Mods;

/**
 * The core entry class.
 *
 * @package khutar\Core
 */
class Core_Loader {
	/**
	 * Features that will be loaded.
	 *
	 * @access   protected
	 * @var array $features Features that will be loaded.
	 */
	protected $features = array();

	/**
	 * Define the core functionality of the theme.
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'after_switch_theme', [ $this, 'check_new_user' ] );
		add_action( 'pearlfibers_ob_after_xml_import', [ $this, 'update_content_import_flag' ] );
		$this->define_hooks();
		$this->define_modules();
		$this->load_modules();
	}

	/**
	 * Update content import flag.
	 */
	public function update_content_import_flag() {
		update_option( 'khutar_imported_demo', 'yes' );
	}

	/**
	 * Checks that the user is new.
	 *
	 * @return bool
	 */
	public function check_new_user() {
		$new = get_option( 'khutar_new_user' );
		if ( $new === 'yes' ) {
			return true;
		}

		$install_time = get_option( 'khutar_install' );
		$now          = get_option( 'khutar_user_check_time' );

		if ( empty( $now ) ) {
			$now = time();
			update_option( 'khutar_user_check_time', $now );
		}

		if ( empty( $install_time ) || empty( $now ) ) {
			return false;
		}

		if ( ( $now - $install_time ) <= 60 ) {
			update_option( 'khutar_new_user', 'yes' );
			return true;
		}

		update_option( 'khutar_new_user', 'no' );
		return false;
	}

	/**
	 * Define the features that will be loaded.
	 */
	private function define_modules() {
		$this->features = apply_filters(
			'khutar_filter_main_modules',
			array(
				'Customizer\Loader',
				'Views\Tweaks',
				'Views\Font_Manager',
				'Views\Top_Bar',
				'Views\Header',
				'Views\Template_Parts',
				'Views\Page_Header',
				'Views\Post_Layout',
				'Views\Page_Layout',
				'Views\Product_Layout',
				'Views\Content_None',
				'Views\Content_404',
				'Views\Breadcrumbs',

				'Views\Layouts\Layout_Container',
				'Views\Layouts\Layout_Sidebar',

				'Views\Partials\Post_Meta',
				'Views\Partials\Excerpt',
				'Views\Partials\Comments',

				'Views\Pluggable\Pagination',
				'Views\Pluggable\Masonry',
				'Views\Pluggable\Metabox_Settings',

				'Core\Dynamic_Css',

				'Compatibility\Generic',
				'Compatibility\WooCommerce',
				'Compatibility\Elementor',
				'Compatibility\Header_Footer_Elementor',
				'Compatibility\Amp',
				'Compatibility\Header_Footer_Beaver',
				'Compatibility\Beaver',
				'Compatibility\Lifter',
				'Compatibility\Patterns',
				'Compatibility\PWA',
				'Compatibility\Web_Stories',

				'Admin\Metabox\Manager',
			)
		);
	}

	/**
	 * Check Features and register them.
	 *
	 * @access  private
	 */
	private function load_modules() {
		$factory = new Factory( $this->features );
		$factory->load_modules();
	}

	/**
	 * Register all of the hooks related to the functionality
	 * of the theme setup.
	 *
	 * @access   private
	 */
	private function define_hooks() {
		// Avoid mods cache on customizer preview.
		if ( is_customize_preview() ) {
			Mods::$no_cache = true;
		}
		$admin = new Admin();
		add_action( 'init', array( $admin, 'load_site_import' ), 20 );
		add_action( 'ti-about-after-sidebar-content', array( $admin, 'render_logger_toggle' ) );

		$key_lite = str_replace( '-', '_', basename( get_template_directory() ) );
		add_filter(
			$key_lite . '_logger_data',
			function () {
				return [ 'mods' => array_filter( get_theme_mods() ) ];
			}
		);
		$front_end = new Front_End();
		add_action( 'wp_enqueue_scripts', array( $front_end, 'enqueue_scripts' ) );
		add_action( 'after_setup_theme', array( $front_end, 'setup_theme' ) );
		add_action( 'widgets_init', array( $front_end, 'register_sidebars' ) );
	}
}
