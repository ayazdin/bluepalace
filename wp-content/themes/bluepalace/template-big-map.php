<?php
/**
 * Template Name: Big Map
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

if($inside_page_title == "yes") {
	echo '<header id="title-header" class="marB0">';
		echo '<div class="container">';
			echo '<div class="left">';
				echo '<h5 class="marT0 marB0">';
					the_title();
				echo '</h5>';
			echo '</div>';
			echo ct_breadcrumbs();
			echo '<div class="clear"></div>';
		echo '</div>';
	echo '</header>';
}

		echo '<!-- Content -->';
        echo '<article class="col span_12 first marB0">';

	        ct_multi_marker_map();
            
        endwhile; endif;

        echo '</article>';
        echo '<!-- //Content -->';
		
		echo '<div class="clear"></div>';

get_footer(); ?>