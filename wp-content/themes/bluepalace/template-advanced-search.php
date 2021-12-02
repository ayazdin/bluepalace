<?php
/**
 * Template Name: Advanced Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

if (!empty($_GET['search-listings'])) {
	get_template_part('search-listings');
	return;
}

get_header();

global $ct_options;

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);
$ct_search_title = isset( $ct_options['ct_home_adv_search_title'] ) ? $ct_options['ct_home_adv_search_title'] : '';

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

	<?php do_action('before_page_header'); ?>

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

	<?php do_action('before_page_content'); ?>

	<!-- Container -->
	<div class="container <?php if($top_page_margin != "No") { echo 'marT60'; } ?> padB60">

		<!-- Page Content -->
		<div class="page-content col span_9">

			<!-- Inner Content -->
			<div class="inner-content">
				<?php the_content(); ?>

				<form id="advanced_search" name="search-listings" action="<?php echo home_url(); ?>">

				    <div class="form-loader"><i class="fa fa-circle-o-notch fa-spin"></i></div>
				    
			            <div class="col span_4 first">
			                <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
			                <?php ct_search_form_select('property_type'); ?>
			            </div>
				      
						<div class="col span_4">
							<label for="ct_city"><?php _e('City', 'contempo'); ?></label>
							<?php ct_search_form_select('city'); ?>
						</div>
				        
			            <div class="col span_4">
                            <?php
                            global $ct_options;
                            $ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';

                            if($ct_state_or_area == 'area') { ?>
                                <label for="ct_state"><?php _e('Area', 'contempo'); ?></label>
                            <?php } elseif($ct_state_or_area == 'suburb') { ?>
                                <label for="ct_state"><?php _e('Suburb', 'contempo'); ?></label>
                            <?php } else { ?>
                                <label for="ct_state"><?php _e('State', 'contempo'); ?></label>
                            <?php } ?>
                            <?php ct_search_form_select('state'); ?>
			            </div>
			        
			            <div class="col span_4 first">
			                <?php
			                global $ct_options;
			                $ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? $ct_options['ct_zip_or_post'] : '';

			                if($ct_zip_or_post == 'postcode') { ?>
			                    <label for="ct_zipcode"><?php _e('Postcode', 'contempo'); ?></label>
			                <?php } else { ?>
			                    <label for="ct_zipcode"><?php _e('Zipcode', 'contempo'); ?></label>
			                <?php } ?>
							<?php ct_search_form_select('zipcode'); ?>
			            </div>
			       
			            <div class="col span_4">
			                <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
			                <?php ct_search_form_select('country'); ?>
			            </div>
			        
			            <div class="col span_4">
			                <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
			                <?php ct_search_form_select('community'); ?>
			            </div>
			       
			            <div class="col span_4 first">
			                <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
							<?php ct_search_form_select('beds'); ?>
			            </div>
			        
			            <div class="col span_4">
			                <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
							<?php ct_search_form_select('baths'); ?>
			            </div>
			        
			            <div class="col span_4">
			                <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
							<?php ct_search_form_select('ct_status'); ?>
			            </div>

			            <div class="col span_4 first">
			                <?php
			                global $ct_options;
			                $ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

			                if($ct_community_neighborhood_or_district == 'neighborhood') { ?>
			                    <label for="ct_community"><?php _e('Neighborhood', 'contempo'); ?></label>
			                <?php } elseif($ct_community_neighborhood_or_district == 'district') { ?>
			                    <label for="ct_community"><?php _e('District', 'contempo'); ?></label>
			                <?php } else { ?>
			                    <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
			                <?php } ?>
			                <?php ct_search_form_select('community'); ?>
			            </div>
			        
			            <div class="col span_4">
			                <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
			                <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
			            </div>
			       
			            <div class="col span_4">
			                <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
			                <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
			            </div>
			       
			            <div class="col span_4 first">
			                <label for="ct_sqft_from"><?php _e('Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			       
			            <div class="col span_4">
			                <label for="ct_sqft_to"><?php _e('Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>

			            <div class="col span_4">
			                <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			       
			            <div class="col span_4 first">
			                <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			       
			            <div class="col span_4">
			                <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
			                <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
			            </div>
			        	
			        	<?php
			        	// Rental Information
				        $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
				        $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
				        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				        if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php') && $ct_submit_rental_info == 'yes') { ?>
			            <div class="col span_4">
			                <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
			                <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
			            </div>
			            <?php } ?>

			            <div class="left additional-features marT30">
			                <label for="ct_additional_features"><?php _e('Addtional Features', 'contempo'); ?></label>
							<?php ct_search_form_checkboxes('additional_features'); ?>
			            </div>
			       
			    		<input type="hidden" name="search-listings" value="true" />

					    <input id="submit" class="btn left marT30" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />
					    <div class="left makeloading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
					        <div class="clear"></div>
					</form>


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