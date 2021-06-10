<?php
/**
 * Start file handles bootstrap.
 *
 * @package khutar
 */

/**
 * Run theme functionality
 */
function khutar_run() {
	$vendor_file = trailingslashit( get_template_directory() ) . 'vendor/autoload.php';
	if ( is_readable( $vendor_file ) ) {
		require_once $vendor_file;
	}

	require_once 'autoloader.php';
	$autoloader = new \khutar\Autoloader();
	$autoloader->add_namespace( 'khutar', get_template_directory() . '/inc/' );

	if ( defined( 'khutar_PRO_SPL_ROOT' ) ) {
		$autoloader->add_namespace( 'khutar_Pro', khutar_PRO_SPL_ROOT );
	}

	$autoloader->register();

	if ( class_exists( '\\khutar\\Core\\Core_Loader' ) ) {
		new \khutar\Core\Core_Loader();
	}

	if ( class_exists( '\\khutar_Pro\\Core\\Loader' ) ) {
		/**
		 * Legacy code, compatibility with old pro version.
		 */
		if ( is_file( khutar_PRO_SPL_ROOT . 'modules/header_footer_grid/components/Yoast_Breadcrumbs.php' ) ) {
			require_once khutar_PRO_SPL_ROOT . 'modules/header_footer_grid/components/Yoast_Breadcrumbs.php';
		}
		if ( is_file( khutar_PRO_SPL_ROOT . 'modules/header_footer_grid/components/Language_Switcher.php' ) ) {
			require_once khutar_PRO_SPL_ROOT . 'modules/header_footer_grid/components/Language_Switcher.php';
		}
		\khutar_Pro\Core\Loader::instance();
	}
}

khutar_run();
