<?php
/**
 * Testimonial columns pattern.
 *
 * @package khutar
 */

return array(
	'title'      => __( 'Testimonial columns', 'khutar' ),
	'content'    => '<!-- wp:group -->
<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:heading {"align":"center"} -->
<h2 class="has-text-align-center">Testimonials</h2>
<!-- /wp:heading -->

<!-- wp:separator {"color":"khutar-button-color","className":"is-style-default"} -->
<hr class="wp-block-separator has-text-color has-background has-khutar-button-color-background-color has-khutar-button-color-color is-style-default"/>
<!-- /wp:separator -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"align":"center","width":80,"height":80} -->
<div class="wp-block-image"><figure class="aligncenter is-resized"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/patterns/otter-blocks-img-03.png" alt="" width="80" height="80"/></figure></div>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>Jason Stobbard</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><em>"...Absolutely fantastic work, many thanks for the perfect collaboration so far, very much appreciated!..."</em></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"align":"center","width":80,"height":80} -->
<div class="wp-block-image"><figure class="aligncenter is-resized"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/patterns/otter-blocks-img-02.png" alt=""  width="80" height="80"/></figure></div>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>Jane Austin</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><em>"... I love this team! They did fantastic work, many thanks for the perfect collaboration so far, very much appreciated!..."</em></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"align":"center","width":80,"height":80} -->
<div class="wp-block-image"><figure class="aligncenter  is-resized"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/patterns/otter-blocks-img-03.png" alt="" width="80" height="80"/></figure></div>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><strong>Jason Stobbard</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><em>"...Absolutely fantastic work, many thanks for the perfect collaboration so far, very much appreciated!..."</em></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:group -->',
	'categories' => array( 'columns' ),
);
