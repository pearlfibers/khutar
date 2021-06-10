<?php
/**
 * The template for displaying comments.
 *
 * @package khutar
 */
if ( post_password_required() ) {
	return;
}

if ( ! comments_open() ) {
	return;
}

?>

<div id="comments" class="comments-area">
	<?php do_action( 'khutar_do_comment_area' ); ?>
</div>
