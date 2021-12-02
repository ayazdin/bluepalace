<?php
/**
 * Template Name: Testimonials
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

get_header();

while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
	// Custom Page Header Background Image
	if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
		echo'<style type="text/css">';
		echo '#single-header { background: url(';
		echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
		echo ') no-repeat center center; background-size: cover;}';
		echo '</style>';
	} ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
				<?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
					<h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- //Single Header -->
<?php } ?>

<?php echo '<div class="container marT60 padB60">'; ?>
    
        <article class="col span_12">
            
			<?php the_content(); ?>
            
            <?php //wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; ?>

            <?php
				echo '<ul class="testimonials marT0">';
				global $post;
				$args = array(
			        'post_type' => 'testimonial', 
			        'order' => 'DSC',
			        'posts_per_page' => -1
			    );
				$query = new WP_Query($args);

				$count = 0;
					
				if ( have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
				
					<li class="col span_6 <?php if($count % 2 == 0) { echo 'first'; } ?>">
						<div class="testimonial-inner">
							<?php if(has_post_thumbnail()) {
								echo '<figure>';
								the_post_thumbnail('medium');  
								echo '</figure>';
							} ?>
							<p><?php the_content(); ?></p>
							<h5 class="muted"><?php the_title(); ?></h5>	
						</div>			
					</li>

				<?php
				$count++;

				if($count % 2 == 0) {
					echo '<div class="clear"></div>';
				}
				?>

				<?php endwhile;	endif; wp_reset_postdata(); ?>

			<?php
				echo '</ul>';
					echo '<div class="clear"></div>';
			?>

        </article>

<?php 
	echo '<div class="clear"></div>';
echo '</div>';

get_footer(); ?>