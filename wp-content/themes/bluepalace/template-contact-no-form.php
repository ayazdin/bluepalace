<?php
/**
 * Template Name: Contact No Form
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

$ct_contact_multiple_locations = isset( $ct_options['ct_contact_multiple_locations'] ) ? esc_attr( $ct_options['ct_contact_multiple_locations'] ) : ''; 

get_header(); ?>

<?php if($inside_page_title == "Yes") {
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
} ?>

<?php 
	if($ct_contact_multiple_locations == 'on') {
		ct_multi_contact_us_map();
	} else {
		ct_contact_us_map();
	}
?>

	<!-- Container -->
	<div class="container marT60 padB60" <?php if($ct_options['ct_contact_map'] == "no") { ?><?php } ?>>

		<!-- Page Content -->
   		<div class="content col span_9">
    
            <!-- Inner Content -->
            <div class="col span_11 first">
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>
				
				<?php endwhile; ?>

	        </div>
	        <!-- //Inner Content -->

        </div>
        <!-- //Page Content -->

        <!-- Sidebar -->
        <div id="sidebar" class="col span_3">
            <div id="sidebar-inner" class="contact-details">
	            <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar Contact Page') ) :else: endif; ?>
            </div>
        </div>
        <!-- //Sidebar -->

			<div class="clear"></div>
	</div>
	<!-- //Container -->

<?php get_footer(); ?>