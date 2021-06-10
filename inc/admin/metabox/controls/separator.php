<?php
/**
 * Metabox separator.
 *
 * @package khutar\Admin\Metabox\Controls
 */

namespace khutar\Admin\Metabox\Controls;

/**
 * Class Separator
 *
 * @package khutar\Admin\Metabox\Controls
 */
class Separator extends Control_Base {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'separator';

	/**
	 * Render control.
	 *
	 * @return void
	 */
	public function render_content( $post_id ) {
		echo '<hr/>';
	}
}
