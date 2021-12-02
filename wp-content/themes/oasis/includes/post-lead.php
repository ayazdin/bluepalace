<?php
/**
 * Post Lead Include
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$video = get_post_meta($post->ID, "_ct_video", true);
 
?>

<?php
	global $post;
	$attachments = get_children(
		array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_parent' => $post->ID
		));
	if(count($attachments) > 1) {
		echo '<div class="flexslider marB40">';
		echo	'<ul class="slides">';
					ct_slider_images();
		echo	'</ul>';
		echo '</div>';
	} elseif(has_post_thumbnail()) {
		echo '<figure class="marB40">';
		the_post_thumbnail(620,200);  
		echo '</figure>';
	}
?>