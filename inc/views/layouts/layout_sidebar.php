<?php
/**
 * Author:          Andrei Baicus <andrei@pearlfibers.com>
 * Created on:      27/08/2018
 *
 * @package khutar\Views\Layouts
 */

namespace khutar\Views\Layouts;

use khutar\Views\Base_View;

/**
 * Class Layout_Container
 *
 * @package khutar\Views\Layouts
 */
class Layout_Sidebar extends Base_View {
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'khutar_do_sidebar', array( $this, 'sidebar' ), 10, 2 );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
	}

	/**
	 * Render the sidebar.
	 *
	 * @param string $context  context passed into do_action.
	 * @param string $position position passed into do_action.
	 */
	public function sidebar( $context, $position ) {
		$sidebar_setup = $this->get_sidebar_setup( $context );
		$theme_mod     = $sidebar_setup['theme_mod'];
		$theme_mod     = apply_filters( 'khutar_sidebar_position', get_theme_mod( $theme_mod, 'right' ) );
		if ( $theme_mod !== $position ) {
			return;
		}
		if ( ! is_active_sidebar( $sidebar_setup['sidebar_slug'] ) ) {
			return;
		}

		$args = array(
			'wrap_classes' => 'nv-' . $position . ' ' . $sidebar_setup['sidebar_slug'],
			'data_attrs'   => apply_filters( 'khutar_sidebar_data_attrs', '', $sidebar_setup['sidebar_slug'] ),
			'close_button' => $this->get_sidebar_close( $sidebar_setup['sidebar_slug'] ),
			'slug'         => $sidebar_setup['sidebar_slug'],
		);

		$this->get_view( 'sidebar', $args );
	}

	/**
	 * Add classes to the main tag.
	 *
	 * @param array $classes the body classes.
	 *
	 * @return array
	 */
	public function add_body_class( $classes ) {
		$context = $this->get_context();

		$sidebar_setup = $this->get_sidebar_setup( $context );
		$theme_mod     = $sidebar_setup['theme_mod'];
		$theme_mod     = apply_filters( 'khutar_sidebar_position', get_theme_mod( $theme_mod, 'right' ) );

		$classes[] = 'nv-sidebar-' . $theme_mod;

		return $classes;
	}

	/**
	 * Get the sidebar setup. Returns array (`theme_mod`, `sidebar_slug`) based on context.
	 *
	 * @param string $context the provided context.
	 *
	 * @return array
	 */
	public function get_sidebar_setup( $context ) {
		$advanced_options = get_theme_mod( 'khutar_advanced_layout_options', false );
		$sidebar_setup    = array(
			'theme_mod'    => '',
			'sidebar_slug' => 'blog-sidebar',
		);

		if ( class_exists( 'WooCommerce', false ) && ( is_woocommerce() || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
			$sidebar_setup['sidebar_slug'] = 'shop-sidebar';
		}

		if ( $advanced_options === false ) {
			$sidebar_setup['theme_mod']   = 'khutar_default_sidebar_layout';
			$sidebar_setup['has_widgets'] = is_active_sidebar( $sidebar_setup['sidebar_slug'] );

			return $sidebar_setup;
		}

		switch ( $context ) {
			case 'blog-archive':
				$sidebar_setup['theme_mod'] = 'khutar_blog_archive_sidebar_layout';
				break;
			case 'single-post':
				$sidebar_setup['theme_mod'] = 'khutar_single_post_sidebar_layout';
				if ( class_exists( 'WooCommerce', false ) && is_product() ) {
					$sidebar_setup['theme_mod'] = 'khutar_single_product_sidebar_layout';
				}
				break;
			case 'single-page':
				$sidebar_setup['theme_mod'] = 'khutar_other_pages_sidebar_layout';
				break;
			case 'shop':
				if ( class_exists( 'WooCommerce', false ) ) {
					$sidebar_setup['sidebar_slug'] = 'shop-sidebar';
					if ( is_woocommerce() ) {
						$sidebar_setup['theme_mod'] = 'khutar_shop_archive_sidebar_layout';
					}
					if ( is_product() ) {
						$sidebar_setup['theme_mod'] = 'khutar_single_product_sidebar_layout';
					}
				}
				break;
			default:
				$sidebar_setup['theme_mod'] = 'khutar_other_pages_sidebar_layout';
		}

		$sidebar_setup['has_widgets'] = is_active_sidebar( $sidebar_setup['sidebar_slug'] );

		return $sidebar_setup;
	}

	/**
	 * Render sidebar toggle.
	 *
	 * @param string $slug sidebar slug.
	 *
	 * @return string
	 */
	private function get_sidebar_close( $slug ) {
		if ( $slug !== 'shop-sidebar' ) {
			return '';
		}
		$label        = apply_filters( 'khutar_filter_sidebar_close_button_text', __( 'Close', 'khutar' ), $slug );
		$button_attrs = apply_filters( 'khutar_filter_sidebar_close_button_data_attrs', '', $slug );

		return '<div class="sidebar-header"><span class="nv-sidebar-toggle in-sidebar button button-secondary secondary-default" ' . $button_attrs . '>' . esc_html( $label ) . '</span></div>';
	}

	/**
	 * Get current context.
	 *
	 * @return string
	 */
	private function get_context() {
		if ( class_exists( 'WooCommerce', false ) && ( is_woocommerce() || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
			return 'shop';
		}

		if ( is_page() ) {
			return 'single-page';
		}

		if ( is_single() ) {
			return 'single-post';
		}

		if ( is_archive() || is_home() ) {
			return 'blog-archive';
		}
	}
}
