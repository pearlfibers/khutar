<?php
/**
 * The template for 500 page in PWA.
 *
 * @package khutar
 * @since   2.4.3
 */
pwa_get_header( 'pwa' );

do_action( 'khutar_do_server_error' );

pwa_get_footer( 'pwa' );
