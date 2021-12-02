
<?php
/**
 * Single Template for floor plan
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
get_header();
// Header
echo '<header id="title-header"';
if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
echo '>';
echo '<div class="container">';
echo '<div class="left">';
echo '<h5 class="marT0 marB0">';
esc_html_e('News', 'contempo');
echo '</h5>';
echo '</div>';
echo ct_breadcrumbs();
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';

// Listing Tools
if($ct_listing_tools == 'yes') { ?>

<!-- Listing Tools -->
<div id="tools">
    <ul class="social marB0">
        <li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
        <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
        <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
        <li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>
        <li class="print"><a class="print" href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
    </ul>
    <span id="tools-toggle"><a href="#"><span id="text-toggle"><?php esc_html_e('Close', 'contempo'); ?></span></a></span>
</div>
<!-- //Listing Tools -->

<?php } ?>



<?php do_action('before_single_content'); ?>
<!-- Container -->
<div class="container <?php if($ct_post_header_meta == 'No') { echo 'padT60'; } ?> padB60">

	<?php
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	?>
	<h3><?php echo the_title()?></h3>
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
	/*------------meta box data-----------------*/
	$tempImgs = rwmb_meta( 'filesUpload', '', $post->ID );
	$tempImgs2 = rwmb_meta( 'filesUpload2', '', $post->ID );
	$tempImgs3 = rwmb_meta( 'filesUpload3', '', $post->ID );
	?>
	<h3><?php echo the_title();?> Floorplan</h3>
	<ul class="tab">
		<li><a href="javascript:void(0)" class="tablinks active" onclick="openCity(event, 'section1')" id="defaultOpen"><?php echo get_post_meta($post->ID, 'name', true);?></a></li>
		<li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'section2')"><?php echo get_post_meta($post->ID, 'name2', true);?></a></li>
		<li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'section3')"><?php echo get_post_meta($post->ID, 'name3', true);?></a></li>
	</ul>

	<?php 
	echo '<div id="section1" class="tabcontent">';
	foreach ($tempImgs as $key) {
		$attachmentId = "";
		$attachmentId = $key['ID'];
		$url = wp_get_attachment_thumb_url( $attachmentId );
		$attachment_title = get_the_title($attachmentId);
		echo "<div class='inlineImg99'><a class='fancybox' rel='section1' href='".$url."' title='".$attachment_title."'><img src='".$url."'><br>";
		echo "<h5>".$attachment_title."</h5></a></div>";
		
	}
	echo "</div>";
	echo '<div id="section2" class="tabcontent">';
	foreach ($tempImgs2 as $key) {
		$attachmentId = "";
		$attachmentId = $key['ID'];
		$url = wp_get_attachment_thumb_url( $attachmentId );
		$attachment_title = get_the_title($attachmentId);
		echo "<div class='inlineImg99'><a class='fancybox' rel='section2' href='".$url."' title='".$attachment_title."'><img src='".$url."'><br>";
		echo "<h5>".$attachment_title."</h5></a></div>";
		
	}
	echo "</div>";
	echo '<div id="section3" class="tabcontent">';
	foreach ($tempImgs3 as $key) {
		$attachmentId = "";
		$attachmentId = $key['ID'];
		$url = wp_get_attachment_thumb_url( $attachmentId );
		$attachment_title = get_the_title($attachmentId);
		echo "<div class='inlineImg99'><a class='fancybox' rel='section3' href='".$url."' title='".$attachment_title."'><img src='".$url."'><br>";
		echo "<h5>".$attachment_title."</h5></a></div>";
		
	}
	echo "</div>";
	

	/*------------meta box data-----------------*/
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
		     //    if($ct_author_info == 'yes') {
			    //     ct_author_info();
			    // }

		     //    // Related Posts
		     //    if($ct_related_posts== 'yes') {
			    //     ct_related_posts();
			    // }

			    // // Posts Nav
		     //    if($ct_post_nav == 'yes') {
			    //     ct_post_nav();
			    // }

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

	if($ct_post_layout != 'full-width') {
			// Sidebar
			// get_template_part('sidebar');
			// End Sidebar
	}

	echo '<div class="clear"></div>';

	do_action('after_single_sidebar');

	echo '</div>';
	// End Container

	get_footer(); ?>

	<script>
		function openCity(evt, cityName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}
		document.getElementById("defaultOpen").click();
		jQuery(document).ready(function() {
			$(".fancybox").fancybox();
		});
	</script>
	<style>
		.inlineImg99{ display: inline-block; padding: 5px; width: 20%; overflow: hidden;}
		ul.tab {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			/*border: 1px solid #ccc;
			background-color: #f1f1f1;*/
		}

		/* Float the list items side by side */
		ul.tab li {float: left;}

		/* Style the links inside the list items */
		ul.tab li a {
			display: inline-block;
			color: black;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			transition: 0.3s;
			font-size: 17px;
		}

		/* Change background color of links on hover */
		ul.tab li a:hover {
			background-color: #ddd;
		}

		/* Create an active/current tablink class */
		ul.tab li a:focus, .active {
			background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
			display: none;
			padding: 6px 12px;
			-webkit-animation: fadeEffect 1s;
			animation: fadeEffect 1s;
		}

		@-webkit-keyframes fadeEffect {
			from {opacity: 0;}
			to {opacity: 1;}
		}

		@keyframes fadeEffect {
			from {opacity: 0;}
			to {opacity: 1;}
		}
	</style>
	