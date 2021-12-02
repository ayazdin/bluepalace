<?php
/**
 * Hybrid
 *
 * @package WP Bold
 * @subpackage Include
 */
 
global $ct_options;

$post_lead = get_post_meta($post->ID, "_ct_post_lead", true);
$post_title = get_post_meta($post->ID, "_ct_post_title", true);
$post_meta = get_post_meta($post->ID, "_ct_post_meta", true);
$post_social = get_post_meta($post->ID, "_ct_post_social", true);
		
	$attachments = get_children(
		array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_parent' => $post->ID
		)
	);
	
	if( $wp_query->current_post == 0 || $wp_query->current_post == 6 || $wp_query->current_post == 11 || $wp_query->current_post == 16 || $wp_query->current_post == 21 || $wp_query->current_post == 27 || $wp_query->current_post == 32 && !is_paged() ) {
		
		echo '<article class="col span_12">';
		
			if(get_post_meta($post->ID, "_ct_video", true) && $post_lead == 'No') {
				echo '<div class="post-thumb video col span_12 first marB30">';
				echo stripslashes(get_post_meta($post->ID, "_ct_video", true));
				echo '</div>'; 
			}
		
			if($post_lead == 'Yes' && has_post_thumbnail() || count($attachments) > 1) {
				echo '<div class="post-thumb col span_12 first marB30">';
					if(count($attachments) > 1) {
						echo '<div class="flexslider">';
						echo	'<ul class="slides">';
									ct_slider_images();
						echo	'</ul>';
						echo '</div>';
					} elseif(has_post_thumbnail()) {
						echo '<figure>';
						echo '<a class="thumb" href="';
							the_permalink();
						echo '">';
							the_post_thumbnail(620,200);  
						echo '</a>';
						echo '</figure>';
					}
				echo '</div>';
			} ?>
	
			<div class="content">
				<header class="marB20">
					<h1 class="entry-title marT0 marB5"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
					<?php get_template_part('includes/post-meta'); ?>
				</header>
				<div class="excerpt marT20">
					<?php the_excerpt(); ?>
				</div>
			</div>
				<div class="clear"></div>  
				
		</article>	
	
	<?php } else {
		
		echo '<article class="col span_6 first">';
	
			if(get_post_meta($post->ID, "_ct_video", true) && $post_lead == 'No') {
				echo '<div class="post-thumb video">';
				echo stripslashes(get_post_meta($post->ID, "_ct_video", true));
				echo '</div>'; 
			}
		
			if($post_lead == 'Yes' && has_post_thumbnail() || count($attachments) > 1) {
				echo '<div class="post-thumb">';
					if(count($attachments) > 1) {
						echo '<div class="flexslider">';
						echo	'<ul class="slides">';
									ct_slider_images();
						echo	'</ul>';
						echo '</div>';
					} elseif(has_post_thumbnail()) {
						echo '<figure>';
						echo '<a class="thumb" href="';
							the_permalink();
						echo '">';
							the_post_thumbnail(620,200);  
						echo '</a>';
						echo '</figure>';
					}
				echo '</div>';
			} ?>
		
			<div class="content">
				<header class="marB20">
					<h3 class="entry-title marT20 marB0"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
					<?php get_template_part('includes/post-meta'); ?>
				</header>
				<div class="excerpt marT20">
					<?php the_excerpt(); ?>
				</div>
			</div>
				<div class="clear"></div> 
                
        </article>   
        
<?php } ?>