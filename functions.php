<?php
/**
 * khutar functions.php file
 *
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      17/08/2018
 *
 * @package khutar
 */

define( 'khutar_VERSION', '2.11.6' );
define( 'khutar_INC_DIR', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'khutar_ASSETS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/' );
define( 'khutar_MAIN_DIR', get_template_directory() . '/' );

if ( ! defined( 'khutar_DEBUG' ) ) {
	define( 'khutar_DEBUG', false );
}
define( 'khutar_NEW_DYNAMIC_STYLE', true );
/**
 * Buffer which holds errors during theme inititalization.
 *
 * @var WP_Error $_khutar_bootstrap_errors
 */
global $_khutar_bootstrap_errors;

$_khutar_bootstrap_errors = new WP_Error();

if ( version_compare( PHP_VERSION, '5.5' ) < 0 ) {
	$_khutar_bootstrap_errors->add(
		'minimum_php_version',
		sprintf(
		/* translators: %s message to upgrade PHP to the latest version */
			__( "Hey, we've noticed that you're running an outdated version of PHP which is no longer supported. Make sure your site is fast and secure, by %1\$s. khutar's minimal requirement is PHP%2\$s.", 'khutar' ),
			sprintf(
			/* translators: %s message to upgrade PHP to the latest version */
				'<a href="https://wordpress.org/support/upgrade-php/">%s</a>',
				__( 'upgrading PHP to the latest version', 'khutar' )
			),
			'5.5+'
		)
	);
}
/**
 * A list of files to check for existance before bootstraping.
 *
 * @var array Files to check for existance.
 */

$_files_to_check = defined( 'khutar_IGNORE_SOURCE_CHECK' ) ? [] : [
	khutar_MAIN_DIR . 'vendor/autoload.php',
	khutar_MAIN_DIR . 'style-main.css',
	khutar_MAIN_DIR . 'assets/js/build/modern/frontend.js',
	khutar_MAIN_DIR . 'dashboard/build/dashboard.js',
	khutar_MAIN_DIR . 'inc/customizer/controls/react/bundle/controls.js',
];
foreach ( $_files_to_check as $_file_to_check ) {
	if ( ! is_file( $_file_to_check ) ) {
		$_khutar_bootstrap_errors->add(
			'build_missing',
			sprintf(
			/* translators: %s: commands to run the theme */
				__( 'You appear to be running the khutar theme from source code. Please finish installation by running %s.', 'khutar' ), // phpcs:ignore WordPress.Security.EscapeOutput
				'<code>composer install &amp;&amp; yarn install --frozen-lockfile &amp;&amp; yarn run build</code>'
			)
		);
		break;
	}
}
/**
 * Adds notice bootstraping errors.
 *
 * @internal
 * @global WP_Error $_khutar_bootstrap_errors
 */
function _khutar_bootstrap_errors() {
	global $_khutar_bootstrap_errors;
	printf( '<div class="notice notice-error"><p>%1$s</p></div>', $_khutar_bootstrap_errors->get_error_message() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

if ( $_khutar_bootstrap_errors->has_errors() ) {
	/**
	 * Add notice for PHP upgrade.
	 */
	add_filter( 'template_include', '__return_null', 99 );
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	add_action( 'admin_notices', '_khutar_bootstrap_errors' );

	return;
}

/**
 * pearlfibers SDK filter.
 *
 * @param array $products products array.
 *
 * @return array
 */
function khutar_filter_sdk( $products ) {
	$products[] = get_template_directory() . '/style.css';

	return $products;
}

add_filter( 'pearlfibers_sdk_products', 'khutar_filter_sdk' );

require_once 'globals/migrations.php';
require_once 'globals/utilities.php';
require_once 'globals/hooks.php';
require_once 'globals/sanitize-functions.php';
require_once get_template_directory() . '/start.php';


require_once get_template_directory() . '/header-footer-grid/loader.php';
