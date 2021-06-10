<?php
/**
 * Two columns with centered content pattern.
 *
 * @package khutar
 */

return array(
	'title'      => __( 'Two columns with centered content', 'khutar' ),
	'content'    => '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {} -->
<figure class="wp-block-image"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/patterns/khutar-patterns-16.jpg" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:heading {"align":"center","level":3} -->
<h3 class="has-text-align-center">Heading three</h3>
<!-- /wp:heading -->

<!-- wp:separator {"color":"khutar-button-color","className":"is-style-default"} -->
<hr class="wp-block-separator has-text-color has-background has-khutar-button-color-background-color has-khutar-button-color-color is-style-default"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. </p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {} -->
<figure class="wp-block-image"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/patterns/khutar-patterns-15.jpg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:heading {"align":"center","level":3} -->
<h3 class="has-text-align-center">Heading three</h3>
<!-- /wp:heading -->

<!-- wp:separator {"color":"khutar-button-color","className":"is-style-default"} -->
<hr class="wp-block-separator has-text-color has-background has-khutar-button-color-background-color has-khutar-button-color-color is-style-default"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
	'categories' => array( 'columns' ),
);
