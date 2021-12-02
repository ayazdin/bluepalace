<?php
/**
 * Single Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;

$ct_post_header_meta = get_post_meta($post->ID, '_ct_post_header', true);
$ct_post_layout = isset( $ct_options['ct_post_layout'] ) ? $ct_options['ct_post_layout'] : '';
$ct_author_img = isset( $ct_options['ct_author_img'] ) ? $ct_options['ct_author_img'] : '';
$ct_post_meta = isset( $ct_options['ct_post_meta'] ) ? $ct_options['ct_post_meta'] : '';
$ct_post_social = isset( $ct_options['ct_post_social'] ) ? $ct_options['ct_post_social'] : '';
$ct_post_tags = isset( $ct_options['ct_post_tags'] ) ? $ct_options['ct_post_tags'] : '';
$ct_author_info = isset( $ct_options['ct_author_info'] ) ? $ct_options['ct_author_info'] : '';
$ct_related_posts = isset( $ct_options['ct_related_posts'] ) ? $ct_options['ct_related_posts'] : '';
$ct_post_nav = isset( $ct_options['ct_post_nav'] ) ? $ct_options['ct_post_nav'] : '';
$ct_post_comments = isset( $ct_options['ct_post_comments'] ) ? $ct_options['ct_post_comments'] : '';

get_header();
echo '<header id="title-header"';
if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
echo '>';
echo '<div class="container">';
echo '<div class="left">';
echo '<h5 class="marT0 marB0">';
if ( have_posts() ) : while ( have_posts() ) : the_post(); 
esc_html_e(the_title(), 'contempo');
endwhile; endif;
echo '</h5>';
echo '</div>';
// echo ct_breadcrumbs();
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';
if ( have_posts() ) : while ( have_posts() ) : the_post();

	// Custom Post Header Background Image
?>
	<div class="container">
	<?php if ( has_post_thumbnail() ) {?>
	<figure class="singleImage">

			<?php 
			
				the_post_thumbnail();
			
			?>
			
		</figure>
		<?php } ?>
</div>
    <?php do_action('before_single_header'); ?>

    <?php if($ct_post_header_meta != 'No') { ?>
	<!-- Single Header -->
	
	<!-- //Single Header -->
	<?php } ?>

	<?php do_action('before_single_content'); ?>

	<!-- Container -->
	<div class="container <?php if($ct_post_header_meta == 'No') { echo 'padT60'; } ?> padB60">

	<?php
		echo '<!-- Content -->';
		echo '<div class="single-content col';
			if($ct_post_layout == 'full-width') { echo ' span_12 first'; } else { echo ' span_12'; }
				echo '">';

				// Video
				$video_url = get_post_meta($post->ID, "_ct_video", true);
                $ct_embed_code = wp_oembed_get( $video_url, $args );
                if($video_url) {
                	echo '<div class="video marB30">';
						echo $ct_embed_code;
					echo '</div>';
				}
				// End Video
	            
	            // Post Content
				get_template_part( 'content');
				// End Post Content

				// Post Social
				if($ct_post_social == 'yes') {
			        ct_post_social();
			    }

			    // Post Tags
				if($ct_post_tags == 'yes') {
			        ct_post_tags();
			    }
	            
	        endwhile; endif;

	        	// Link Pages
		        wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) );

		        // Author Info
		        if($ct_author_info == 'yes') {
			        // ct_author_info();
			    }

		        // Related Posts
		        if($ct_related_posts== 'yes') {
			        ct_related_posts();
			    }

			    // Posts Nav
		        if($ct_post_nav == 'yes') {
			        // ct_post_nav();
			    }

				// Comments
				// if($ct_post_comments == 'yes') {
			 //        if (comments_open() || '0' != get_comments_number()) :

			 //        	// If comments are open or we have at least one comment, load up the comment template
				// 		comments_template();
					
				// 	endif;
				// }
				// End Comments

			echo '</article>';
			// End Single Inner

		echo '</div>';
		echo '<!-- //Content -->';

		do_action('before_single_sidebar');

		// if($ct_post_layout != 'full-width') {
		// 	// Sidebar
		// 	get_template_part('sidebar');
		// 	// End Sidebar
		// }

			echo '<div class="clear"></div>';

			do_action('after_single_sidebar');

	echo '</div>';
	// End Container

get_footer(); ?>