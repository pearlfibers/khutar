<?php
/**
 * Radio Buttons Control. Handles data passing from args to JS.
 *
 * @package khutar\Customizer\Controls\React
 */

namespace khutar\Customizer\Controls\React;

/**
 * Class Spacing
 *
 * @package khutar\Customizer\Controls\React
 */
class Presets_Selector extends \WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'khutar_presets_selector';

	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array
	 */
	public $presets = [];

	/**
	 * Send to JS.
	 */
	public function to_json() {
		parent::to_json();
		$this->json['presets'] = $this->presets;
	}
}
