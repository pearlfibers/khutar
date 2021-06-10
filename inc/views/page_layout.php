<?php
/**
 * Single page layout.
 *
 * @package khutar\Views
 */

namespace khutar\Views;

/**
 * Class Page_Layout
 *
 * @package khutar\Views
 */
class Page_Layout extends Base_View {

	/**
	 * Init function
	 */
	public function init() {
		add_action( 'khutar_do_single_page', array( $this, 'render_page' ) );
	}

	/**
	 * Render single page.
	 */
	public function render_page() {
		echo '<div class="nv-content-wrap entry-content">';
		the_content();

		do_action( 'khutar_before_page_comments' );
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

		echo '</div>';
		do_action( 'khutar_do_pagination', 'single' );
	}
}
