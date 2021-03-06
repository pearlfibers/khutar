<?php
/**
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      05/10/2018
 *
 * @package khutar
 */


/**
 * Class TestDynamicSelector
 */
class TestDynamicSelector extends WP_UnitTestCase {

	public function test_css_generation_with_empty_value() {
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_COLOR => 'test-mod'
			]
		] );
		$css        = '';
		$css        .= $subscriber;
		$this->assertEmpty( $css );
	}

	public function test_css_generation_with_color() {
		set_theme_mod( 'sample-color', '#ccc' );
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_COLOR => 'sample-color'
			]
		] );
		$css        = '';
		$css        .= $subscriber;
		$this->assertNotEmpty( $css );
		$this->assertContains( "#ccc", $css );
	}

	public function test_css_generation_with_invalid_rule() {
		set_theme_mod( 'sample-color', '#ccc' );
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				'invalid_rule' => 'sample-color'
			]
		] );
		$css        = '';
		$css        .= $subscriber;
		$this->assertEmpty( $css );
	}

	public function test_css_generation_with_key() {
		set_theme_mod( 'sample-color2', '#eee' );
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_COLOR => [
					'key' => 'sample-color2'
				]
			]
		] );
		$css        = '';
		$css        .= $subscriber;

		$this->assertNotEmpty( $css );
		$this->assertContains( "#eee", $css );
	}

	public function test_css_generation_with_suffix() {
		set_theme_mod( 'mod_max_size', '333' );
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'    => 'mod_max_size',
					'suffix' => 'em'
				]
			]
		] );
		$css        = '';
		$css        .= $subscriber;

		$this->assertNotEmpty( $css );
		$this->assertContains( "333em", $css );
	}

	public function test_css_generation_with_default() {
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'     => 'mod_max_size2',
					'default' => '929'
				]
			]
		] );
		$css        = '';
		$css        .= $subscriber;
		$this->assertNotEmpty( $css );
		$this->assertContains( "929", $css );
	}

	public function test_css_generation_with_filter() {

		set_theme_mod( 'mod_max_size9', '333' );
		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'    => 'mod_max_size9',
					'filter' => function ( $css_prop, $value, $meta, $device ) {
						return 'box-shadow: ' . $value . 'px;';
					}
				]
			]
		] );
		$css        = '';
		$css        .= $subscriber;
		$this->assertNotEmpty( $css );
		$this->assertContains( "box-shadow: 333px;", $css );
	}

	public function test_css_generation_on_breakpoints() {
		$subscriber  = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'     => 'mod_max_size22',
					'default' => '929'
				]
			]
		] );
		$mobile_css  = '' . $subscriber;
		$desktop_css = '' . $subscriber->for_desktop();
		$tablet_css  = '' . $subscriber->for_tablet();

		$this->assertNotEmpty( $mobile_css );
		$this->assertContains( "929", $mobile_css );
		$this->assertEmpty( $desktop_css );
		$this->assertEmpty( $tablet_css );
	}

	public function test_css_generation_with_responsive() {

		set_theme_mod( 'mod_max_size10', [
			'mobile'  => 10,
			'desktop' => 50,
			'tablet'  => 300
		] );
		$subscriber  = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'           => 'mod_max_size10',
					'is_responsive' => true
				]
			]
		] );
		$mobile_css  = '' . $subscriber;
		$desktop_css = '' . $subscriber->for_desktop();
		$tablet_css  = '' . $subscriber->for_tablet();
		$this->assertContains( "10px;", $mobile_css );
		$this->assertContains( "50px;", $desktop_css );
		$this->assertContains( "300px;", $tablet_css );
	}

	public function test_css_generation_with_responsiveness_encoded() {
		set_theme_mod( 'mod_max_size13', json_encode( [
			'mobile'  => 10,
			'desktop' => 50,
			'tablet'  => 300
		] ) );
		$subscriber  = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'           => 'mod_max_size13',
					'is_responsive' => true
				]
			]
		] );
		$mobile_css  = '' . $subscriber;
		$desktop_css = '' . $subscriber->for_desktop();
		$tablet_css  = '' . $subscriber->for_tablet();
		$this->assertContains( "10px;", $mobile_css );
		$this->assertContains( "50px;", $desktop_css );
		$this->assertContains( "300px;", $tablet_css );
	}

	public function test_css_generation_with_responsiveness_no_devices() {
		set_theme_mod( 'mod_max_size40', 200 );
		$subscriber  = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'           => 'mod_max_size40',
					'is_responsive' => true
				]
			]
		] );
		$mobile_css  = '' . $subscriber;
		$desktop_css = '' . $subscriber->for_desktop();
		$tablet_css  = '' . $subscriber->for_tablet();
		$this->assertContains( "200px;", $mobile_css );
		$this->assertContains( "200px;", $desktop_css );
		$this->assertContains( "200px;", $tablet_css );
	}

	public function test_css_generation_responsiveness_with_subkey() {
		set_theme_mod( 'mod_max_size1022', [
			'subkey' => [
				'mobile'  => 555,
				'desktop' => 666,
				'tablet'  => 777
			]
		] );
		$subscriber  = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_MAX_WIDTH => [
					'key'           => 'mod_max_size1022.subkey',
					'is_responsive' => true
				]
			]
		] );
		$mobile_css  = '' . $subscriber;
		$desktop_css = '' . $subscriber->for_desktop();
		$tablet_css  = '' . $subscriber->for_tablet();
		$this->assertContains( "555px;", $mobile_css );
		$this->assertContains( "666px;", $desktop_css );
		$this->assertContains( "777px;", $tablet_css );
	}

	public function test_css_generation_responsiveness_with_subkey_with_suffix() {
		set_theme_mod( 'mod_max_size1022222', [
			'subkey' => [
				'mobile'  => 555,
				'desktop' => 666,
				'tablet'  => 777,
				'suffix'  => [
					'mobile'  => 'em',
					'desktop' => '%',
					'tablet'  => 'px'
				]
			]
		] );
		$subscriber  = new \khutar\Core\Styles\Dynamic_Selector( [
			'.test-selector' => [
				\khutar\Core\Settings\Config::CSS_PROP_LINE_HEIGHT => [
					'key'           => 'mod_max_size1022222.subkey',
					'is_responsive' => true
				]
			]
		] );
		$mobile_css  = '' . $subscriber;
		$desktop_css = '' . $subscriber->for_desktop();
		$tablet_css  = '' . $subscriber->for_tablet();
		$this->assertContains( "555em;", $mobile_css );
		$this->assertContains( "666%;", $desktop_css );
		$this->assertContains( "777px;", $tablet_css );
	}

	public function test_css_generation_with_extra_selectors() {
		set_theme_mod( 'mod_color_one', '#fff' );
		add_filter( 'khutar_selectors_' . \khutar\Core\Settings\Config::CSS_SELECTOR_BTN_PRIMARY_HOVER, function ( $selectors ) {
			return $selectors . ',.one-test-selector';
		} );

		$subscriber = new \khutar\Core\Styles\Dynamic_Selector( [
			\khutar\Core\Settings\Config::CSS_SELECTOR_BTN_PRIMARY_HOVER => [
				\khutar\Core\Settings\Config::CSS_PROP_COLOR => [
					'key' => 'mod_color_one'
				]
			]
		] );
		$css        = '' . $subscriber;

		$this->assertContains( ",.one-test-selector", $css );
		$this->assertNotContains( \khutar\Core\Settings\Config::CSS_SELECTOR_BTN_PRIMARY_HOVER, $css );
		$this->assertContains( "color: #fff", $css );
	}
}
