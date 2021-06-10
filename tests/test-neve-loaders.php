<?php
/**
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      05/10/2018
 *
 * @package khutar
 */


/**
 * Class TestkhutarLoaders
 */
class TestkhutarLoaders extends WP_UnitTestCase {

	/**
	 * Check if autoloader has prefix and abstract classes are being loaded.
	 */
	public function testAutoloader() {
		$this->assertClassHasAttribute( 'prefixes', '\khutar\Autoloader' );
		$this->assertTrue( class_exists( '\khutar\Customizer\Base_Customizer' ) );
		$this->assertTrue( class_exists( '\khutar\Views\Base_View' ) );
		$this->assertTrue( class_exists( '\khutar\Views\Inline\Base_Inline' ) );
	}

	/**
	 * Test factory with single module.
	 */
	public function testFactory() {
		$factory    = new \khutar\Core\Factory(
			array(
				'Views\Pluggable\Pagination',
			)
		);
		$test_class = $factory->build( 'Views\Pluggable\Pagination' );
		$this->assertInstanceOf( 'khutar\Views\Pluggable\Pagination', $test_class );
	}
}
