<?php
/**
 * Archive Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;

$ct_archive_layout = isset( $ct_options['ct_archive_layout'] ) ? $ct_options['ct_archive_layout'] : '';

$cat_desc = category_description(); 

get_header(); ?>

	<!-- Archive Header Image -->
	<?php 
		if(!is_home() || !is_front_page()) {
			echo ct_display_category_image();
		}
	?>

	<?php do_action('before_archive_header'); ?>

	<!-- Archive Header -->
	<div id="archive-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB5"><?php ct_archive_header(); ?></h1>
				<?php if($cat_desc != '') { ?>
					<h2 class="marT0 marB0"><?php echo category_description(); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- //Archive Header -->

	<?php do_action('before_archive_content'); ?>

	<!-- Main Content Container -->
	<div class="container archive marT60 padB60">

		<!-- Posts Loop -->
		<?php
			echo '<div class="col';
			if($ct_archive_layout == 'full-width') { echo ' span_12 first'; } else { echo ' span_9'; }
				echo '">';
			?>

			<!-- Archive Inner -->
			<div class="archive-inner">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				
			<?php endwhile; ?>
			
				<?php ct_numeric_pagination(); ?>
			
			<?php else : ?>
			
				<p class="nomatches"><strong><?php esc_html_e( 'No posts were found which match your search criteria', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Try broadening your search to find more results.', 'contempo' ); ?></p>
			
			<?php endif; ?>

			</div>
			<!-- //Archive Inner -->

		</div>
		<!-- //Posts Loop -->

		<?php do_action('before_archive_sidebar'); ?>
		
		<?php
		if($ct_archive_layout != 'full-width') {
			// Sidebar
			get_template_part('sidebar');
			// End Sidebar
		}
		
		// Clear
		echo '<div class="clear"></div>';

		do_action('after_archive_sidebar');
	        
	echo '</div>';
	//Main Content Container

get_footer(); ?>