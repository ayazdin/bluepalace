<?php
/**
 * Template Name: Full Width 2
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);
$bottom_page_margin = get_post_meta($post->ID, "_ct_bottom_page_margin", true);

get_header();

while ( have_posts() ) : the_post();


	// Custom Page Header Background Image
	echo'<style type="text/css">';
	echo '#single-header { background: url(';
	echo 'http://wp.contempographicdesign.com/wp-real-estate-7/multi-demo/wp-content/uploads/2015/07/114620_sandiego-ranchodreamestate-08.jpg';
	echo ') no-repeat center center; background-size: cover;}';
	echo '</style>';
	?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
				<h2 class="marT0 marB0">Choose a Stacked or Zillow Style Search Results Layout with a Click!</h2>
			</div>
		</div>
	</div>
	<!-- //Single Header -->


<div class="container <?php if($top_page_margin != "No") { echo 'marT60'; } ?> <?php if($top_page_margin != "No") { echo 'padB60'; } ?>">
    
        <article class="col span_12">
            
			<?php the_content(); ?>
            
            <?php //wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; ?>
            
                <div class="clear"></div>

        </article>

<?php 
	echo '<div class="clear"></div>';
echo '</div>';

get_footer(); ?>