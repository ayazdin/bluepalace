<?php
/**
 * Blog Large Lead for Archive & Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

$attachments = get_children(
	array(
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_parent' => $post->ID
	)
);

$ct_author_img = isset( $ct_options['ct_author_img'] ) ? $ct_options['ct_author_img'] : '';
$ct_auto_slider = get_post_meta($post->ID, '_ct_post_slider', true); 

?>
        
<!-- Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('post row'); ?>>

	<?php do_action('before_post_header'); ?>

	<!-- Post Header -->
	<header>
		<?php if($ct_author_img == 'yes') { ?>
    	<figure class="author-avatar left">
    		<?php if(get_the_author_meta('ct_profile_url')) {				
				echo '<a href="';
					echo site_url() . '/?author=';
					echo the_author_meta('ID');
				echo '">';
					echo '<img class="authorimg" src="';
						echo aq_resize(the_author_meta('ct_profile_url'),80);
					echo '" />';
				echo '</a>';
			} else {
				echo '<a href="';
					echo site_url() . '/?author=';
					echo the_author_meta('ID');
				echo '">';
				echo get_avatar( get_the_author_meta('email'), '80' );
				echo '</a>';
			} ?>
        </figure>
        <?php } ?>
        <div class="left entry-title">
            <h2 class="marT0 marB5"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            <!--<p class="marB0">
				<span class="meta">
					<?php /*esc_html_e('By', 'contempo'); */?> <?php /*the_author_posts_link(); */?><?php /*if(!is_search()) { */?> <?php /*esc_html_e('in', 'contempo'); */?> <?php /*$cat = get_the_category(); if(isset($cat, $cat[0])) { $cat = $cat[0]; } */?><a href="<?php /*echo home_url(); */?>/?cat=<?php /*echo esc_html($cat->cat_ID); */?>"><?php /*echo esc_html($cat->cat_name); */?></a><?php /*} */?> <?php /*esc_html_e('with', 'contempo'); */?> <a href="<?php /*comments_link(); */?>"><?php /*comments_number('0 Comments','1 Comment','% Comments'); */?></a>
				</span>
			</p>-->
		</div>
			<div class="clear"></div>
    </header>
    <!-- //Post Header -->

    <?php do_action('before_post_lead_media'); ?>

    <?php
	// Post Lead Slider or Featured Image
	echo '<div class="post-thumb col span_12 first">';
		if(count($attachments) > 1 && $ct_auto_slider != 'No') {
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
	// End Post Lead Slider or Featured Image
	?>

	<?php do_action('before_post_excerpt'); ?>

    <!-- Post Excerpt -->
    <div class="excerpt marT20 col span_12 first">
        <?php the_excerpt('55'); ?>

		    <div class="clear"></div>

	    <!-- Read More -->
	    <p class="marT60 marB0">
	    	<a class="btn"  href="<?php the_permalink() ?>"><?php esc_html_e('Read More', 'contempo'); ?></a>
		</p>
		<!-- //Read More -->
    </div>
    <!-- //Post Excerpt -->

    <?php do_action('after_post_excerpt'); ?>

</article>
<!-- //Article -->    