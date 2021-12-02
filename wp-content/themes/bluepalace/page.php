<?php
/**
 * Page Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);

while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
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
		echo '</header>'; } ?>

	<?php do_action('before_page_content'); ?>

	<!-- Container -->
	<div class="container <?php if($top_page_margin != "No") { echo 'marT60'; } ?> <?php if($top_page_margin != "No") { echo 'marT60'; } ?> padB60">

		<!-- Page Content -->
		<div class="page-content col span_9">

			<!-- Inner Content -->
			<div class="inner-content">
				<?php the_content(); ?>
			</div>
			<!-- //Inner Content -->

			<!-- Comments -->
	        <?php if ( comments_open() || '0' != get_comments_number() ) :

		        echo '<div class="clear"></div>';

	        	// If comments are open or we have at least one comment, load up the comment template
				comments_template();
			
			endif; ?>
			<!-- End Comments -->
		</div>
		<!-- //Page Content -->

	<?php endwhile; ?>

		<?php do_action('before_page_sidebar'); ?>

		<!-- Sidebar -->
		<?php get_template_part('sidebar'); ?>
		<!-- //Sidebar -->
			<div class="clear"></div>

		<?php do_action('after_page_sidebar'); ?>
	</div>
	<!-- //Container -->

<?php get_footer(); ?>