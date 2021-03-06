<?php
/**
 * Starter content theme mods definition.
 *
 * @package khutar\Compatibility\Starter_Content
 */
return array(
	'logo_show_tagline'                           => 0,
	'nav-icon_button_appearance'                  =>
		array(
			'type'            => 'fill',
			'background'      => '',
			'backgroundHover' => '',
			'text'            => 'var(--nv-text-color)',
			'textHover'       => '',
			'borderRadius'    =>
				array(
					'top'    => '3',
					'right'  => '3',
					'bottom' => '3',
					'left'   => '3',
				),
			'borderWidth'     =>
				array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
		),
	'hfg_header_layout_main_background'           =>
		array(
			'type'              => 'color',
			'colorValue'        => 'var(--nv-site-bg)',
			'imageUrl'          => '',
			'focusPoint'        =>
				array(
					'x' => 0.5,
					'y' => 0.5,
				),
			'overlayColorValue' => '',
			'overlayOpacity'    => 50,
			'fixed'             => false,
			'useFeatured'       => false,
		),
	'hfg_header_layout_sidebar_background'        =>
		array(
			'type'              => 'color',
			'colorValue'        => 'var(--nv-site-bg)',
			'imageUrl'          => '',
			'focusPoint'        =>
				array(
					'x' => 0.5,
					'y' => 0.5,
				),
			'overlayColorValue' => '',
			'overlayOpacity'    => 50,
			'fixed'             => false,
			'useFeatured'       => false,
		),
	'khutar_blog_archive_layout'                    => 'default',
	'khutar_post_excerpt_length'                    => 45.0,
	'khutar_post_meta_ordering'                     => '["author","comments"]',
	'khutar_advanced_layout_options'                => true,
	'khutar_blog_archive_sidebar_layout'            => 'full-width',
	'khutar_blog_archive_content_width'             => 100,
	'khutar_body_font_family'                       => 'Poppins',
	'khutar_headings_font_family'                   => 'Poppins',
	'khutar_button_appearance'                      =>
		array(
			'type'            => 'fill',
			'background'      => 'var(--nv-secondary-accent)',
			'backgroundHover' => 'var(--nv-secondary-accent)',
			'text'            => 'var(--nv-text-color)',
			'textHover'       => 'var(--nv-text-color)',
			'borderRadius'    =>
				array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
			'borderWidth'     =>
				array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
		),
	'khutar_h1_typeface_general'                    =>
		array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'lineHeight'    =>
				array(
					'mobile'  => '1.2',
					'tablet'  => '1.3',
					'desktop' => '1.3',
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'fontSize'      =>
				array(
					'mobile'  => '39',
					'tablet'  => '55',
					'desktop' => 70,
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
				),
			'flag'          => true,
		),
	'khutar_container_width'                        => '{"mobile":748,"tablet":992,"desktop":1170}',
	'khutar_default_container_style'                => 'contained',
	'khutar_h2_typeface_general'                    =>
		array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'lineHeight'    =>
				array(
					'mobile'  => '1.3',
					'tablet'  => '1.3',
					'desktop' => '1.3',
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'fontSize'      =>
				array(
					'mobile'  => '30',
					'tablet'  => '35',
					'desktop' => 50,
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
				),
			'flag'          => false,
		),
	'khutar_h3_typeface_general'                    =>
		array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'lineHeight'    =>
				array(
					'mobile'  => '1.3',
					'tablet'  => '1.3',
					'desktop' => '1.3',
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'fontSize'      =>
				array(
					'mobile'  => '20',
					'tablet'  => '20',
					'desktop' => '24',
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
				),
			'flag'          => false,
		),
	'khutar_single_post_sidebar_layout'             => 'right',
	'khutar_other_pages_sidebar_layout'             => 'full-width',
	'khutar_single_post_content_width'              => 70,
	'khutar_other_pages_content_width'              => 100,
	'khutar_typeface_general'                       =>
		array(
			'fontSize'      =>
				array(
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
					'mobile'  => 15,
					'tablet'  => 16,
					'desktop' => 17,
				),
			'lineHeight'    =>
				array(
					'mobile'  => 1.6,
					'tablet'  => 1.6,
					'desktop' => 1.7,
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'fontWeight'    => '400',
			'textTransform' => 'none',
			'flag'          => false,
		),
	'primary-menu_color'                          => 'var(--nv-text-color)',
	'primary-menu_active_color'                   => 'var(--nv-text-color)',
	'primary-menu_hover_color'                    => 'var(--nv-secondary-accent)',
	'primary-menu_component_typeface'             =>
		array(
			'fontSize'      =>
				array(
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
					'mobile'  => 1,
					'tablet'  => 1,
					'desktop' => 0.8,
				),
			'lineHeight'    =>
				array(
					'mobile'  => 1.6,
					'tablet'  => 1.6,
					'desktop' => 1.6,
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'fontWeight'    => '600',
			'textTransform' => 'uppercase',
		),
	'khutar_grid_layout'                            => '{"desktop":3,"tablet":2,"mobile":1}',
	'khutar_secondary_button_appearance'            =>
		array(
			'type'            => 'fill',
			'background'      => 'var(--nv-primary-accent)',
			'backgroundHover' => 'var(--nv-primary-accent)',
			'text'            => 'var(--nv-text-dark-bg)',
			'textHover'       => 'var(--nv-text-dark-bg)',
			'borderRadius'    =>
				array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
			'borderWidth'     =>
				array(
					'top'    => '2',
					'right'  => '2',
					'bottom' => '2',
					'left'   => '2',
				),
		),
	'custom_logo'                                 => '{{featured-image-logo}}',
	'logo_max_width'                              => '{"mobile":32,"tablet":32,"desktop":32}',
	'khutar_button_padding'                         =>
		array(
			'mobile'       =>
				array(
					'top'    => '16',
					'right'  => '35',
					'bottom' => '16',
					'left'   => '35',
				),
			'tablet'       =>
				array(
					'top'    => '16',
					'right'  => '35',
					'bottom' => '16',
					'left'   => '35',
				),
			'desktop'      =>
				array(
					'top'    => '16',
					'right'  => '35',
					'bottom' => '16',
					'left'   => '35',
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'khutar_secondary_button_padding'               =>
		array(
			'mobile'       =>
				array(
					'top'    => '16',
					'right'  => '35',
					'bottom' => '16',
					'left'   => '35',
				),
			'tablet'       =>
				array(
					'top'    => '16',
					'right'  => '35',
					'bottom' => '16',
					'left'   => '35',
				),
			'desktop'      =>
				array(
					'top'    => '16',
					'right'  => '35',
					'bottom' => '16',
					'left'   => '35',
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'khutar_blog_list_alternative_layout'           => true,
	'khutar_h4_typeface_general'                    =>
		array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'lineHeight'    =>
				array(
					'mobile'  => '1.3',
					'tablet'  => '1.3',
					'desktop' => '1.3',
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'fontSize'      =>
				array(
					'mobile'  => '16',
					'tablet'  => '16',
					'desktop' => '20',
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
				),
			'flag'          => false,
		),
	'khutar_h5_typeface_general'                    =>
		array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'lineHeight'    =>
				array(
					'mobile'  => '1.3',
					'tablet'  => '1.3',
					'desktop' => '1.3',
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'fontSize'      =>
				array(
					'mobile'  => '14',
					'tablet'  => '14',
					'desktop' => '16',
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
				),
			'flag'          => false,
		),
	'khutar_h6_typeface_general'                    =>
		array(
			'fontWeight'    => '600',
			'textTransform' => 'none',
			'letterSpacing' =>
				array(
					'mobile'  => 0,
					'tablet'  => 0,
					'desktop' => 0,
				),
			'lineHeight'    =>
				array(
					'mobile'  => '1.3',
					'tablet'  => '1.3',
					'desktop' => '1.3',
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
				),
			'fontSize'      =>
				array(
					'mobile'  => '14',
					'tablet'  => '14',
					'desktop' => '16',
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
				),
			'flag'          => false,
		),
	'khutar_global_colors'                          =>
		array(
			'activePalette' => 'base',
			'palettes'      =>
				array(
					'base'     =>
						array(
							'name'          => 'Base',
							'allowDeletion' => false,
							'colors'        =>
								array(
									'nv-primary-accent'   => '#2b2b2b',
									'nv-secondary-accent' => '#fcaf3b',
									'nv-site-bg'          => '#ffffff',
									'nv-light-bg'         => '#ededed',
									'nv-dark-bg'          => '#14171c',
									'nv-text-color'       => '#14171c',
									'nv-text-dark-bg'     => '#ffffff',
									'nv-c-1'              => '#77b978',
									'nv-c-2'              => '#f37262',
								),
						),
					'darkMode' =>
						array(
							'name'          => 'Dark Mode',
							'allowDeletion' => false,
							'colors'        =>
								array(
									'nv-primary-accent'   => '#26bcdb',
									'nv-secondary-accent' => '#1f90a6',
									'nv-site-bg'          => '#121212',
									'nv-light-bg'         => '#1a1a1a',
									'nv-dark-bg'          => '#1a1a1a',
									'nv-text-color'       => '#ffffff',
									'nv-text-dark-bg'     => '#ffffff',
									'nv-c-1'              => '#77b978',
									'nv-c-2'              => '#f37262',
								),
						),
				),
		),
	'hfg_footer_layout_bottom_new_text_color'     => 'var(--nv-primary-accent)',
	'logo_display'                                => 'logoTitle',
	'khutar_button_typeface'                        =>
		array(
			'fontSize'   =>
				array(
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
					'mobile'  => '14',
					'tablet'  => '14',
					'desktop' => '16',
				),
			'flag'       => false,
			'lineHeight' =>
				array(
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
					'mobile'  => 1.6,
					'tablet'  => 1.6,
					'desktop' => 1.6,
				),
		),
	'khutar_secondary_button_typeface'              =>
		array(
			'fontSize'   =>
				array(
					'suffix'  =>
						array(
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						),
					'mobile'  => '14',
					'tablet'  => '14',
					'desktop' => '16',
				),
			'flag'       => false,
			'lineHeight' =>
				array(
					'suffix'  =>
						array(
							'mobile'  => 'em',
							'tablet'  => 'em',
							'desktop' => 'em',
						),
					'mobile'  => 1.6,
					'tablet'  => 1.6,
					'desktop' => 1.6,
				),
		),
	'header_search_responsive_component_align'    =>
		array(
			'desktop' => 'right',
			'tablet'  => 'left',
			'mobile'  => 'left',
		),
	'hfg_header_layout'                           => '{"desktop":{"top":[],"main":[{"x":0,"y":1,"width":3,"height":1,"id":"logo"},{"x":3,"y":1,"width":6,"height":1,"id":"primary-menu"},{"x":9,"y":1,"width":1,"height":1,"id":"header_search_responsive"},{"x":10,"y":1,"width":2,"height":1,"id":"button_base"}],"bottom":[]},"mobile":{"top":[],"main":[{"x":0,"y":1,"width":8,"height":1,"id":"logo"},{"x":8,"y":1,"width":4,"height":1,"id":"nav-icon"}],"bottom":[],"sidebar":[{"x":0,"y":1,"width":1,"height":1,"id":"header_search"},{"x":1,"y":1,"width":8,"height":1,"id":"primary-menu"},{"x":9,"y":1,"width":1,"height":1,"id":"button_base"}]}}',
	'button_base_component_padding'               =>
		array(
			'mobile'       =>
				array(
					'top'    => 8,
					'right'  => 12,
					'bottom' => 8,
					'left'   => 12,
				),
			'tablet'       =>
				array(
					'top'    => 8,
					'right'  => 12,
					'bottom' => 8,
					'left'   => 12,
				),
			'desktop'      =>
				array(
					'top'    => 8,
					'right'  => '16',
					'bottom' => 8,
					'left'   => '16',
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'nav-icon_menu_label'                         => 'Menu',
	'nav-icon_component_padding'                  =>
		array(
			'mobile'       =>
				array(
					'top'    => '10',
					'right'  => 15,
					'bottom' => 10,
					'left'   => 15,
				),
			'tablet'       =>
				array(
					'top'    => 10,
					'right'  => 15,
					'bottom' => 10,
					'left'   => 15,
				),
			'desktop'      =>
				array(
					'top'    => 10,
					'right'  => 15,
					'bottom' => 10,
					'left'   => 15,
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'button_base_text_setting'                    => 'Contact Now',
	'primary-menu_component_align'                =>
		array(
			'mobile'  => 'center',
			'tablet'  => 'left',
			'desktop' => 'right',
		),
	'button_base_component_align'                 =>
		array(
			'desktop' => 'right',
			'tablet'  => 'left',
			'mobile'  => 'center',
		),
	'header_search_field_height'                  => '{"mobile":45,"tablet":40,"desktop":40}',
	'header_search_field_border_width'            =>
		array(
			'mobile'       =>
				array(
					'top'    => '2',
					'right'  => '2',
					'bottom' => '2',
					'left'   => '2',
				),
			'tablet'       =>
				array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
			'desktop'      =>
				array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'header_search_field_text_color'              => 'var(--nv-primary-accent)',
	'header_search_responsive_color'              => 'var(--nv-primary-accent)',
	'header_search_responsive_hover_color'        => 'var(--nv-dark-bg)',
	'header_search_responsive_field_height'       => '{"mobile":40,"tablet":40,"desktop":58}',
	'header_search_responsive_field_text_size'    => '{"mobile":14,"tablet":14,"desktop":27}',
	'header_search_responsive_field_border_width' =>
		array(
			'mobile'       =>
				array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
			'tablet'       =>
				array(
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				),
			'desktop'      =>
				array(
					'top'    => '4',
					'right'  => '4',
					'bottom' => '4',
					'left'   => '4',
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'header_search_responsive_field_text_color'   => 'var(--nv-primary-accent)',
	'footer_copyright_color'                      => 'var(--nv-primary-accent)',
	'footer_copyright_component_vertical_align'   => 'middle',
	'hfg_footer_layout_bottom_height'             => '{"mobile":0,"tablet":0,"desktop":50}',
	'footer_copyright_component_margin'           =>
		array(
			'mobile'       =>
				array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
			'tablet'       =>
				array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
			'desktop'      =>
				array(
					'top'    => '-10',
					'right'  => '0',
					'bottom' => '20',
					'left'   => '0',
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'hfg_footer_layout'                           => '{"desktop":{"top":[],"bottom":[{"x":0,"y":1,"width":12,"height":1,"id":"footer_copyright"}]}}',
	'primary-menu_component_padding'              =>
		array(
			'mobile'       =>
				array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
			'tablet'       =>
				array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
			'desktop'      =>
				array(
					'top'    => 0,
					'right'  => '0',
					'bottom' => 0,
					'left'   => '0',
				),
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		),
	'button_base_link_setting'                    => '/?pagename=contact',

);
