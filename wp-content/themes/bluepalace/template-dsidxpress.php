<?php
/**
 * Template Name: dsIDXpress
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

?>

<?php
	echo '<!-- Page Title -->';
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
	echo '<!-- //Page Title -->';
?>

<div class="container marT60 padB60">

    <article class="col span_9 first">
           
		<?php the_content(); ?>
        
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
        
        <?php endwhile; endif; wp_reset_query(); ?>
        
            <div class="clear"></div>

    </article>

	<!-- Sidebar -->
	<?php get_template_part('sidebar'); ?>
	<!-- //Sidebar -->
		<div class="clear"></div>

</div>

<?php get_footer(); ?>