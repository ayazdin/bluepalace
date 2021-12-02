<?php
/**
 * Template Name: IDX
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

while ( have_posts() ) : the_post(); ?>

	<?php do_action('before_page_header'); ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<!-- //Single Header -->

	<?php do_action('before_page_content'); ?>

	<!-- Container -->
	<div class="container padB60">

		<!-- Page Content -->
		<div class="page-content col span_9">

			<!-- Inner Content -->
			<div class="inner-content">
				<?php the_content(); ?>
			</div>
			<!-- //Inner Content -->
			
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