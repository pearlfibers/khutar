<?php
/**
 * Range Control. Handles data passing from args to JS.
 *
 * @package khutar\Customizer\Controls\React
 */

namespace khutar\Customizer\Controls\React;

/**
 * Class Spacing
 *
 * @package khutar\Customizer\Controls\React
 */
class Range extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'khutar_range_control';
	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array
	 */
	public $input_attrs = [];

	/**
	 * Send to JS.
	 */
	public function to_json() {
		parent::to_json();
		$this->json['input_attrs'] = $this->input_attrs;
	}
}
