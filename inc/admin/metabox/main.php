<?php
/**
 * Page settings metabox.
 *
 * @package khutar
 */

namespace khutar\Admin\Metabox;

/**
 * Class Metabox
 *
 * @package khutar\Admin\Metabox
 */
class Main extends Controls_Base {
	/**
	 * Add controls.
	 */
	public function add_controls() {
		$this->add_layout_controls();
		$this->add_control( new Controls\Separator( 'khutar_meta_separator', array( 'priority' => 20 ) ) );
		$this->add_content_toggles();
		$this->add_control( new Controls\Separator( 'khutar_meta_separator', array( 'priority' => 45 ) ) );
		$this->add_content_width();
	}

	/**
	 * Add layout controls.
	 */
	private function add_layout_controls() {
		$this->add_control(
			new Controls\Radio(
				'khutar_meta_container',
				array(
					'default' => 'default',
					'choices' => array(
						'default'    => __( 'Customizer Setting', 'khutar' ),
						'contained'  => __( 'Contained', 'khutar' ),
						'full-width' => __( 'Full Width', 'khutar' ),
					),
					'label'   => __( 'Container', 'khutar' ),
				)
			)
		);
		$this->add_control(
			new Controls\Radio(
				'khutar_meta_sidebar',
				array(
					'default'  => ( self::is_new_page() || self::is_checkout() ) ? 'full-width' : 'default',
					'choices'  => array(
						'default'    => __( 'Customizer Setting', 'khutar' ),
						'left'       => __( 'Left Sidebar', 'khutar' ),
						'right'      => __( 'Right Sidebar', 'khutar' ),
						'full-width' => __( 'No Sidebar', 'khutar' ),
					),
					'label'    => __( 'Sidebar', 'khutar' ),
					'priority' => 15,
				)
			)
		);
	}

	/**
	 * Add content toggles.
	 */
	private function add_content_toggles() {
		$content_controls = array(
			'khutar_meta_disable_header'         => array(
				'default'     => 'off',
				'label'       => __( 'Components', 'khutar' ),
				'input_label' => __( 'Disable Header', 'khutar' ),
				'priority'    => 25,
			),
			'khutar_meta_disable_title'          => array(
				'default'         => 'off',
				'input_label'     => __( 'Disable Title', 'khutar' ),
				'active_callback' => array( $this, 'hide_on_single_product' ),
				'priority'        => 30,
			),
			'khutar_meta_disable_featured_image' => array(
				'default'         => 'off',
				'input_label'     => __( 'Disable Featured Image', 'khutar' ),
				'active_callback' => array( $this, 'hide_on_single_page_and_product' ),
				'priority'        => 35,
			),
			'khutar_meta_disable_footer'         => array(
				'default'     => 'off',
				'input_label' => __( 'Disable Footer', 'khutar' ),
				'priority'    => 40,
			),
		);

		$default_control_args = array(
			'default'         => 'off',
			'label'           => '',
			'input_label'     => '',
			'active_callback' => '__return_true',
			'priority'        => 10,
		);

		foreach ( $content_controls as $control_id => $args ) {
			$args = wp_parse_args( $args, $default_control_args );

			$this->add_control(
				new Controls\Checkbox(
					$control_id,
					array(
						'default'         => $args['default'],
						'label'           => $args['label'],
						'input_label'     => $args['input_label'],
						'active_callback' => $args['active_callback'],
						'priority'        => $args['priority'],
					)
				)
			);
		}
	}

	/**
	 * Add content width control.
	 */
	private function add_content_width() {
		$this->add_control(
			new Controls\Checkbox(
				'khutar_meta_enable_content_width',
				array(
					'default'     => ( self::is_new_page() || self::is_checkout() ) ? 'on' : 'off',
					'label'       => __( 'Content Width', 'khutar' ) . ' (%)',
					'input_label' => __( 'Enable Individual Content Width', 'khutar' ),
					'priority'    => 50,
				)
			)
		);
		$this->add_control(
			new Controls\Range(
				'khutar_meta_content_width',
				array(
					'default'    => ( self::is_new_page() || self::is_checkout() ) ? 100 : 70,
					'min'        => 50,
					'max'        => 100,
					'hidden'     => self::hide_content_width(),
					'depends_on' => 'khutar_meta_enable_content_width',
					'priority'   => 55,
				)
			)
		);
	}

	/**
	 * Hide content width.
	 *
	 * @return bool
	 */
	public static function hide_content_width() {
		if ( self::is_new_page() ) {
			return false;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return true;
		}

		$meta = get_post_meta( (int) $_GET['post'], 'khutar_meta_enable_content_width', true );

		if ( empty( $meta ) && self::is_checkout() ) {
			return false;
		}

		if ( empty( $meta ) || $meta === 'off' ) {
			return true;
		}

		return false;
	}

	/**
	 * Callback to hide on single product edit page.
	 *
	 * @return bool
	 */
	public function hide_on_single_product() {
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
			return false;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return true;
		}

		$post_type = get_post_type( (int) $_GET['post'] );

		if ( $post_type !== 'product' ) {
			return true;
		}

		return false;
	}

	/**
	 * Callback to hide on single product/page edit page
	 *
	 * @return bool
	 */
	public function hide_on_single_page_and_product() {
		if ( isset( $_GET['post_type'] ) && ( $_GET['post_type'] === 'page' || $_GET['post_type'] === 'product' ) ) {
			return false;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return true;
		}

		$post_type = get_post_type( (int) $_GET['post'] );

		if ( $post_type !== 'page' && $post_type !== 'product' ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if we're adding a new post of type `page`.
	 *
	 * @return bool
	 */
	public static function is_new_page() {
		global $pagenow;

		if ( $pagenow !== 'post-new.php' ) {
			return false;
		}

		if ( ! isset( $_GET['post_type'] ) ) {
			return false;
		}
		if ( ( $_GET['post_type'] !== 'page' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Check if is checkout.
	 */
	public static function is_checkout() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return false;
		}
		if ( ! isset( $_GET['post'] ) ) {
			return false;
		}
		if ( $_GET['post'] === get_option( 'woocommerce_checkout_page_id' ) ) {
			return true;
		}

		return false;
	}
}
