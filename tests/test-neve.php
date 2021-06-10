<?php
/**
 * Class Testkhutar
 *
 * @package Hestia
 */

/**
 * Sample test case.
 */
class Testkhutar extends WP_UnitTestCase {
	/**
	 * Test Constants.
	 */
	public function testConstants() {
		$this->assertTrue( defined( 'khutar_VERSION' ) );
		$this->assertTrue( defined( 'khutar_INC_DIR' ) );
		$this->assertTrue( defined( 'khutar_ASSETS_URL' ) );
	}

	/**
	 * Make sure khutar_DEBUG is false.
	 */
	public function testDebugOff() {
		$this->assertFalse( khutar_DEBUG );
	}
}
