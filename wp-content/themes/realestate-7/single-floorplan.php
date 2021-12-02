<style>
	.single-content{margin: 0px !important;}
</style>
<?php
/**
 * Single Template for floor plan
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
wp_enqueue_style( 'slider', get_template_directory_uri() . '/css/fancybox/jquery.fancybox.css',true,'1.1','all');
wp_enqueue_script( 'script', get_template_directory_uri() . '/css/fancybox/jquery.fancybox.js', array ( 'jquery' ), 1.1, true);
wp_enqueue_script( 'mediaScript', get_template_directory_uri() . '/css/fancybox/helpers/jquery.fancybox-media.js', array ( 'jquery' ), 1.1, true);
get_header();
// Header
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
		$bannerImg = rwmb_meta( 'bannerUpload', '', $post->ID);
	?>

	<!-- <h3><?=the_title()?></h3> -->
		<div class="single-content col span_12">
			<div class="flexslider">
				<ul class="slides">

	<!-- <h3><?php //the_title()?></h3> -->
	<?php
		foreach ($bannerImg as $key) {
			$attachmentId = "";
			$attachmentId = $key['ID'];
			$url = wp_get_attachment_url($attachmentId);
			$thumburl = wp_get_attachment_thumb_url($attachmentId);
			$attachment_title = get_the_title($attachmentId);?>
			<!--echo "<img src='" . $url . "'>";-->

						<li>
							<img src='<?php echo $url; ?>'>
						</li>
	<?php 	}
		echo '</ul>
			</div>
		</div>';


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
	//get_template_part( 'content');
				// End Post Content
	/*------------meta box data-----------------*/
	$bannerImg = rwmb_meta( 'bannerUpload', '', $post->ID);
	$tempImgs = rwmb_meta( 'filesUpload', '', $post->ID );
	$tempImgs2 = rwmb_meta( 'filesUpload2', '', $post->ID );
	$tempImgs3 = rwmb_meta( 'filesUpload3', '', $post->ID );
	?>
	<h3>Floorplan</h3>
		<?php
		 $section1 =get_post_meta($post->ID, 'name', true);
		 $section2 =get_post_meta($post->ID, 'name2', true);
		 $section3 =get_post_meta($post->ID, 'name3', true);
		?>
	<ul class="tab">
		<?php
			if(!empty($section1)){?>
				<li><a href="javascript:void(0)" class="tablinks active" onclick="openCity(event, 'section1')" id="defaultOpen"><?php echo get_post_meta($post->ID, 'name', true);?></a></li>
		<?php	}
		if(!empty($section2)&&(empty($section1))){?>
			<li><a href="javascript:void(0)" class="tablinks active" onclick="openCity(event, 'section2')"><?php echo get_post_meta($post->ID, 'name2', true);?></a></li>
		<?php }
		else if(!empty($section2)){?>
			<li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'section2')"><?php echo get_post_meta($post->ID, 'name2', true);?></a></li>
		<?php }
		if(!empty($section3)&&(empty($section2))&&(empty($section1))){?>
			<li><a href="javascript:void(0)" class="tablinks active" onclick="openCity(event, 'section3')"><?php echo get_post_meta($post->ID, 'name3', true);?></a></li>
		<?php }
		else if(!empty($section3)){?>
			<li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'section3')"><?php echo get_post_meta($post->ID, 'name3', true);?></a></li>
	<?php	}
		if(empty($section3)&&empty($section2)&&empty($section1)){
			echo '<li>No Data available</li>';
		}
		?>



	</ul>

	<?php 
	echo '<div id="section1" class="tabcontent">';
	if(empty($tempImgs)){echo '<div class="inlineImg99">No data availabe</div>';}
	else{
		foreach ($tempImgs as $key) {
			$attachmentId = "";
			$attachmentId = $key['ID'];
			$url = wp_get_attachment_url($attachmentId);
			$thumburl = wp_get_attachment_thumb_url($attachmentId);
			$attachment_title = get_the_title($attachmentId);

			echo "<div class='inlineImg99'><a class='fancybox' rel='section1' href='" . $url . "' title='" . $attachment_title . "'><img src='" . $thumburl . "'><br>";
			echo "<h5>" . $attachment_title . "</h5></a></div>";
		}
		}
	echo "</div>";
		if(!empty($section2)&&(empty($section1))){
			$style = 'style="display: block;"';
		}else{
			$style = '';
		}
	echo '<div id="section2" class="tabcontent" '.$style.'>';
	if(empty($tempImgs2)){echo '<div class="inlineImg99">No data availabe</div>';}
	else{
		foreach ($tempImgs2 as $key) {
			$attachmentId = "";
			$attachmentId = $key['ID'];
			$url = wp_get_attachment_url($attachmentId);
			$thumburl = wp_get_attachment_thumb_url($attachmentId);
			$attachment_title = get_the_title($attachmentId);
			echo "<div class='inlineImg99'><a class='fancybox' rel='section2' href='" . $url . "' title='" . $attachment_title . "'><img src='" . $thumburl . "'><br>";
			echo "<h5>" . $attachment_title . "</h5></a></div>";
		}
	}
	echo "</div>";
		if(!empty($section3)&&(empty($section2))&&(empty($section1))){
			$style = 'style="display: block;"';
		}else{
			$style = '';
		}
	echo '<div id="section3" class="tabcontent" '.$style.'>';
	if(empty($tempImgs3)){echo '<div class="inlineImg99">No data availabe</div>';}
	else{
		foreach ($tempImgs3 as $key) {
			$attachmentId = "";
			$attachmentId = $key['ID'];
			$url = wp_get_attachment_url($attachmentId);
			$thunburl = wp_get_attachment_thumb_url($attachmentId);
			$attachment_title = get_the_title($attachmentId);
			echo "<div class='inlineImg99'><a class='fancybox' rel='section3' href='" . $url . "' title='" . $attachment_title . "'><img src='" . $thunburl . "'><br>";
			echo "<h5>" . $attachment_title . "</h5></a></div>";
		}
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
	?>
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

		if (document.getElementById("defaultOpen")){
			document.getElementById("defaultOpen").click();
		}
		
		jQuery(document).ready(function() {
			jQuery(".fancybox").fancybox();
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
			color: #B9B1AB;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			transition: 0.3s;
			font-size: 17px;
			background-color: #003466;
		}

		/* Change background color of links on hover */
		ul.tab li a:hover {
			background-color: #3b4d5d;
		}

		/* Create an active/current tablink class */
		ul.tab li a:focus, .active {
			background-color: #003466;
			color: #fff !important;
			text-decoration: underline !important;
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
	<?php get_footer(); ?>

	
	