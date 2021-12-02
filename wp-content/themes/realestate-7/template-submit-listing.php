<?php
/**
 * Template Name: Submit Listing
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$ct_auto_publish = $ct_options['ct_auto_publish'];
$ct_listing_expiration = $ct_options['ct_listing_expiration'];
$postTitleError = isset( $_POST['postTitle'] ) ? $_POST['postTitle'] : '';

global $ct_options;
$view = $ct_options['ct_view'];

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Please enter an address.';
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}

	$post_information = array(
	    'post_title' => wp_strip_all_tags( $_POST['postTitle'] ),
	    'post_content' => $_POST['postContent'],
	    'post_type' => 'listings',
	    'post_status' => $ct_auto_publish
	);

	$post_id = wp_insert_post($post_information);

	/*if ($_FILES) {
		foreach ($_FILES as $file => $array) {
			$newupload = ct_insert_attachment($file,$post_id);
		}
	}*/

    $_POST['att_id'] = isset( $_POST['att_id'] ) ? $_POST['att_id'] : '';

	if($post_id) {
		foreach($_POST['att_id'] as $img){
			wp_update_post( array( 'ID' => $img,  'post_parent' => $post_id ) );
		}
		
		$positions=implode(',',$_POST['att_id']);
		update_post_meta($post_id, '_ct_images_position', $positions);

        $ct_price = str_replace(array('.', ','), '' , $_POST['customMetaPrice']);
		
		// Update Custom Meta
		update_post_meta($post_id, '_ct_listing_alt_title', esc_attr(strip_tags($_POST['customMetaAltTitle'])));
        update_post_meta($post_id, '_ct_price', esc_attr(strip_tags($ct_price)));
		update_post_meta($post_id, '_ct_price_prefix', esc_attr(strip_tags($_POST['customMetaPricePrefix'])));
		update_post_meta($post_id, '_ct_price_postfix', esc_attr(strip_tags($_POST['customMetaPricePostfix'])));
		update_post_meta($post_id, '_ct_sqft', esc_attr(strip_tags($_POST['customMetaSqFt'])));
        update_post_meta($post_id, '_ct_video', esc_attr(strip_tags($_POST['customMetaVideoURL'])));
        update_post_meta($post_id, '_ct_mls', esc_attr(strip_tags($_POST['customMetaMLS'])));
        update_post_meta($post_id, '_ct_latlng', esc_attr(strip_tags($_POST['customMetaLatLng'])));
        update_post_meta($post_id, '_ct_listing_expire', esc_attr(strip_tags($_POST['customMetaExpireListing'])));

        // Rental Information
        $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
        $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php') && $ct_submit_rental_info == 'yes') {
            update_post_meta($post_id, '_ct_rental_guests', esc_attr(strip_tags($_POST['customMetaMaxGuests'])));
            update_post_meta($post_id, '_ct_rental_min_stay', esc_attr(strip_tags($_POST['customMetaMinStay'])));
            update_post_meta($post_id, '_ct_rental_checkin', esc_attr(strip_tags($_POST['customMetaCheckIn'])));
            update_post_meta($post_id, '_ct_rental_checkout', esc_attr(strip_tags($_POST['customMetaCheckOut'])));
            update_post_meta($post_id, '_ct_rental_extra_people', esc_attr(strip_tags($_POST['customMetaExtraPerson'])));
            update_post_meta($post_id, '_ct_rental_cleaning', esc_attr(strip_tags($_POST['customMetaCleaningFee'])));
            update_post_meta($post_id, '_ct_rental_cancellation', esc_attr(strip_tags($_POST['customMetaCancellationFee'])));
            update_post_meta($post_id, '_ct_rental_deposit', esc_attr(strip_tags($_POST['customMetaSecurityDeposit'])));
        }

		//Update Custom Taxonomies
		wp_set_post_terms($post_id,array($_POST['ct_property_type']),'property_type',false);
		wp_set_post_terms($post_id,array($_POST['customTaxBeds']),'beds',false);
		wp_set_post_terms($post_id,array($_POST['customTaxBaths']),'baths',false);
		wp_set_post_terms($post_id,array($_POST['ct_ct_status']),'ct_status',false);
		wp_set_post_terms($post_id,array($_POST['customTaxCity']),'city',false);
		wp_set_post_terms($post_id,array($_POST['customTaxState']),'state',false);
		wp_set_post_terms($post_id,array($_POST['customTaxZip']),'zipcode',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCountry']),'country',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCommunity']),'community',false);
		wp_set_post_terms($post_id,$_POST['customTaxFeat'],'additional_features',false);
		
		//SET FEATURED
		if($_POST['featured_id']!="") set_post_thumbnail($post_id, $_POST['featured_id']);
		else set_post_thumbnail($post_id, $_POST['att_id'][0]);

		// Redirect
		wp_redirect( home_url() . '/?page_id=' . $view ); exit;
	}
}

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

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

<div class="container">

        <article class="listing col span_12 first marB60">

        <script>
        jQuery("form input").on("keypress", function(e) {
            return e.keyCode != 13;
        });
        </script>

            <?php if(!is_user_logged_in()) {
                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
            } else { 

                $item_count = $wpdb->get_var( "SELECT count(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'listings' AND post_author = $userdata->ID" );
                if( $item_count >= 1000 ) {
                
                    echo '<h4>' . __( 'Listings Limit Reached', 'contempo' ) . '</h4>';
                    echo '<p>' . __('You\'ve reached the listings limit for your membership package.', 'contempo') . ' <a href="#">' . __('Upgrade Today!', 'contempo') . '</a></p>';
                
                } else { ?>
            
        			<form action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">

                        <?php if ( $postTitleError != '' ) { ?>
                            <span class="error"><?php echo esc_html($postTitleError); ?></span>
                            <div class="clearfix"></div>
                        <?php } ?>

                        <div class="col span_6 first">

                            <div class="input-full-width">
                                <label><?php esc_html_e('Address', 'contempo'); ?></label>
                                <input type="text" name="postTitle" id="postTitle" value="<?php if ( isset( $_POST['postTitle'] ) ) echo esc_attr($_POST['postTitle']); ?>" placeholder="1234 Somewhere St." required />
                            </div>

                            <div class="input-full-width">
                                <label><?php esc_html_e('Alternate Title', 'contempo'); ?></label>
                                <input type="text" name="customMetaAltTitle" id="customMetaAltTitle" value="<?php if ( isset( $_POST['customMetaAltTitle'] ) ) echo esc_attr($_POST['customMetaAltTitle']); ?>" placeholder="<?php esc_html_e('(e.g. Downtown Penthouse)', 'contempo'); ?>" />
                            </div>

                            <div class="col span_4 first">
                                <label><?php esc_html_e('Type', 'contempo'); ?></label>
                                <?php ct_submit_listing_form_select('property_type'); ?>
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('Status', 'contempo'); ?></label>
                                <?php ct_submit_listing_form_select('ct_status'); ?>
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('Price', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" name="customMetaPrice" id="customMetaPrice" value="<?php if(isset($_POST['customMetaPrice'])) echo esc_attr($_POST['customMetaPrice']);?>" />
                            </div>

                                <div class="clear"></div>

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Price Prefix', 'contempo'); ?></label>
                                <input type="text" name="customMetaPricePrefix" id="customMetaPricePrefix" placeholder="<?php esc_html_e(' (e.g. From, Call for price)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaPricePrefix'])) echo esc_attr($_POST['customMetaPricePrefix']);?>" />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Price Postfix Text', 'contempo'); ?></label>
                                <input type="text" name="customMetaPricePostfix" id="customMetaPricePostfix" placeholder="<?php esc_html_e(' (e.g. /month, /week)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaPricePostfix'])) echo esc_attr($_POST['customMetaPricePostfix']);?>" />
                            </div>

                                <div class="clear"></div>

                            <label><?php esc_html_e('Listing Description', 'contempo'); ?></label>
                            <textarea name="postContent" id="postContent" rows="8" cols="30">
                                <?php
                                    if ( isset( $_POST['postContent'] ) ) {
                                        if ( function_exists( 'stripslashes' ) ) {
                                            echo stripslashes( $_POST['postContent'] );
                                        } else {
                                            echo esc_attr($_POST['postContent']);
                                        }
                                    }
                                ?>
                            </textarea>

                            <?php
                            $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
                            $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
                            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php') && $ct_submit_rental_info == 'yes') { ?>

                                <script>
                                    jQuery(function($) {
                                        $("#rental-info-toggle").click(function(){
                                            $("i.fa-plus-square-o").toggleClass("fa-minus-square-o");
                                            $("#submit-rental-info").toggle();
                                        });
                                    });
                                </script>

                                <div id="rental-info-toggle">
                                    <?php _e('Optional Rental Information', 'contempo'); ?><i class="fa fa-plus-square-o"></i>
                                </div>

                                <div id="submit-rental-info">

                                    <div class="col span_6 first">
                                        <label><?php esc_html_e('Max-number of Guests', 'contempo'); ?></label>
                                        <input type="text" name="customMetaMaxGuests" id="customMetaMaxGuests" placeholder="<?php esc_html_e(' (e.g. 2)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaMaxGuests'])) echo esc_attr($_POST['customMetaMaxGuests']);?>" />
                                    </div>

                                    <div class="col span_6">
                                        <label><?php esc_html_e('Minimum Stay', 'contempo'); ?></label>
                                        <input type="text" name="customMetaMinStay" id="customMetaMinStay" placeholder="<?php esc_html_e(' (e.g. 1 night)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaMinStay'])) echo esc_attr($_POST['customMetaMinStay']);?>" />
                                    </div>

                                        <div class="clear"></div>

                                    <div class="col span_6 first">
                                        <label><?php esc_html_e('Check In Time', 'contempo'); ?></label>
                                        <input type="text" name="customMetaCheckIn" id="customMetaCheckIn" placeholder="<?php esc_html_e(' (e.g. 3:00 PM)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCheckIn'])) echo esc_attr($_POST['customMetaCheckIn']);?>" />
                                    </div>

                                    <div class="col span_6">
                                        <label><?php esc_html_e('Check Out Time', 'contempo'); ?></label>
                                        <input type="text" name="customMetaCheckOut" id="customMetaCheckOut" placeholder="<?php esc_html_e(' (e.g. 11:00 AM)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCheckOut'])) echo esc_attr($_POST['customMetaCheckOut']);?>" />
                                    </div>

                                        <div class="clear"></div>

                                    <div class="col span_6 first">
                                        <label><?php esc_html_e('Extra Person Charge', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                        <input type="text" name="customMetaExtraPerson" id="customMetaExtraPerson" placeholder="<?php esc_html_e(' (e.g. 50)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaExtraPerson'])) echo esc_attr($_POST['customMetaExtraPerson']);?>" />
                                    </div>

                                    <div class="col span_6">
                                        <label><?php esc_html_e('Cleaning Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                        <input type="text" name="customMetaCleaningFee" id="customMetaCleaningFee" placeholder="<?php esc_html_e(' (e.g. 150)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCleaningFee'])) echo esc_attr($_POST['customMetaCleaningFee']);?>" />
                                    </div>

                                        <div class="clear"></div>

                                    <div class="col span_6 first">
                                        <label><?php esc_html_e('Cancellation Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                        <input type="text" name="customMetaCancellationFee" id="customMetaCancellationFee" placeholder="<?php esc_html_e(' (e.g. 275)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaCancellationFee'])) echo esc_attr($_POST['customMetaCancellationFee']);?>" />
                                    </div>

                                    <div class="col span_6">
                                        <label><?php esc_html_e('Security Deposit', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                        <input type="text" name="customMetaSecurityDeposit" id="customMetaSecurityDeposit" placeholder="<?php esc_html_e(' (e.g. 895)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaSecurityDeposit'])) echo esc_attr($_POST['customMetaSecurityDeposit']);?>" />
                                    </div>

                                        <div class="clear"></div>

                                </div>
                            
                            <?php } ?>

                            <div style="display: none;">
                                <div class="left">
                                    <label><?php esc_html_e('Listing Featured Image', 'contempo'); ?></label>
                                    <input type="file" name="featuredImage" id="featuredImage" />
                                </div>

                                <div class="left">
                                    <label><?php esc_html_e('Gallery Images (select as many as you like)', 'contempo'); ?></label>
                                    <input type="file" name="galleryImages" id="galleryImages" multiple="" />
                                </div>
                            </div>

                            <div class="1-left">
                                <div class="col span_12 first">
                                    <label><?php esc_html_e('Listing Images', 'contempo'); ?></label>
                                    <input type="hidden" id="featured_id" name="featured_id" value="" />
                                    <ul class="marT15 listing-images ui-sortable" id="sortable">
                                    	
                                    </ul>
        							<div id="plupload-upload-ui" class="hide-if-no-js drag-drop"> <!-- RF --> 							
                                    <div class="drag-drop col span_12 first row">
                                        <div id="drag-drop-area" class="drag-drop-area">
                                            <div class="drag-drop-msg">
                                                <i class="fa fa-cloud-upload"></i><br />
                                                <strong><?php esc_html_e('Drag & Drop Images Here', 'contempo'); ?></strong>
                                            </div>
                                            <div class="drag-drop-or">
                                                <?php esc_html_e('or', 'contempo'); ?>
                                            </div>
                                            <div class="drag-drop-btn">
                                                <a id="select-images" class="btn" href="javascript:;"><?php esc_html_e('Select Images', 'contempo'); ?></a>
                                            </div>
                                        </div>
                                        <input style="display: none;" type="file" name="galleryImages" id="galleryImages" multiple="" />
                                        <p class="muted marT10 marB0"><?php esc_html_e('*At least one image is required for valid submission, minimum width of 817px.', 'contempo'); ?></p>
                                        <p class="muted marB0"><?php esc_html_e('*You can mark an image as featured by clicking the star icon, Otherwise first image will be considered featured image.', 'contempo'); ?></p>
                                        <div id="plupload-container"></div>
                                        <div id="errors-log"></div>
                                    </div>
        							</div> <!-- RF --> 
                                </div>
                            </div>

                        </div>

                        <div class="col span_6">

                            <div class="col span_4 first">
                                <label><?php esc_html_e('City', 'contempo'); ?></label>
                                <input type="text" name="customTaxCity" id="customTaxCity" value="<?php if ( isset( $_POST['customTaxCity'] ) ) echo esc_attr($_POST['customTaxCity']); ?>"/>
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('State', 'contempo'); ?></label>
                                <input type="text" name="customTaxState" id="customTaxState" value="<?php if ( isset( $_POST['customTaxState'] ) ) echo esc_attr($_POST['customTaxState']); ?>"/>
                            </div>

                            <div class="col span_4">
                                <label><?php ct_zip_or_post(); ?></label>
                                <input type="text" name="customTaxZip" id="customTaxZip" value="<?php if ( isset( $_POST['customTaxZip'] ) ) echo esc_attr($_POST['customTaxZip']); ?>"/>
                            </div>

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Country', 'contempo'); ?></label>
                                <input type="text" name="customTaxCountry" id="customTaxCountry" value="<?php if ( isset( $_POST['customTaxCountry'] ) ) echo esc_attr($_POST['customTaxCountry']); ?>"/>
                            </div>

                            <div class="col span_6">
                                <label><?php ct_community_neighborhood_or_district(); ?></label>
                                <input type="text" name="customTaxCommunity" id="customTaxCommunity" value="<?php if ( isset( $_POST['customTaxCommunity'] ) ) echo esc_attr($_POST['customTaxCommunity']); ?>"/>
                            </div>

                            <div class="col span_4 first">
                                <label><?php esc_html_e('Beds', 'contempo'); ?></label>
                                <input type="text" name="customTaxBeds" id="customTaxBeds" value="<?php if(isset($_POST['customTaxBeds'])) echo esc_attr($_POST['customTaxBeds']);?>" />
                            </div>

                            <div class="col span_4">
                                <label><?php esc_html_e('Baths', 'contempo'); ?></label>
                                <input type="text" name="customTaxBaths" id="customTaxBaths" value="<?php if(isset($_POST['customTaxBaths'])) echo esc_attr($_POST['customTaxBaths']);?>" />
                            </div>

                            <div class="col span_4">
                                <label><?php strtoupper(ct_sqftsqm()); ?></label>
                                <input type="text" name="customMetaSqFt" id="customMetaSqFt" value="<?php if(isset($_POST['customMetaSqFt'])) echo esc_attr($_POST['customMetaSqFt']);?>" />
                            </div>

                             <div class="col span_6 first">
                                <label><?php esc_html_e('Property ID', 'contempo'); ?></label>
                                <input type="text" name="customMetaMLS" id="customMetaMLS" value="<?php if(isset($_POST['customMetaMLS'])) echo esc_attr($_POST['customMetaMLS']);?>" />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Video URL', 'contempo'); ?></label>
                                <input type="text" name="customMetaVideoURL" id="customMetaVideoURL" value="<?php if(isset($_POST['customMetaVideoURL'])) echo esc_attr($_POST['customMetaVideoURL']);?>" />
                            </div>

                                <div class="clear"></div>

                            <label><?php esc_html_e('Additional Features (comma separated)', 'contempo'); ?></label>
                            <textarea name="customTaxFeat" id="customTaxFeat" rows="8" cols="30" placeholder="Pool, Spa, Gated Community">
                                <?php
                                    if ( isset( $_POST['customTaxFeat'] ) ) {
                                        if ( function_exists( 'stripslashes' ) ) {
                                            echo stripslashes( $_POST['customTaxFeat'] );
                                        } else {
                                            echo esc_html($_POST['customTaxFeat']);
                                        }
                                    }
                                ?>
                            </textarea>

                            <div class="col span_12 first">
                                <input type="text" name="customMetaLatLng" id="customMetaLatLng" placeholder="<?php esc_html_e('Latitude & Longitude (optional)', 'contempo'); ?>" value="<?php if(isset($_POST['customMetaLatLng'])) echo esc_attr($_POST['customMetaLatLng']);?>" />
                            </div>

                            <div class="col span_12 first">
                                <input id="pac-input" class="controls" type="text"
                                    placeholder="Enter listing address">
                                <div id="type-selector" class="controls">
                                  <input type="radio" name="type" id="changetype-all" checked="checked">
                                  <label for="changetype-all">All</label>

                                  <input type="radio" name="type" id="changetype-establishment">
                                  <label for="changetype-establishment">Establishments</label>

                                  <input type="radio" name="type" id="changetype-address">
                                  <label for="changetype-address">Addresses</label>

                                  <input type="radio" name="type" id="changetype-geocode">
                                  <label for="changetype-geocode">Geocodes</label>
                                </div>
                                <div id="map-canvas"></div>
                            </div>
                        </div>

                        <div class="col span_12 first marT40 listing-submit">

                            <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
                            
                            <?php if($ct_listing_expiration != '') { ?>
                            <input type="hidden" name="customMetaExpireListing" id="customMetaExpireListing" value="<?php echo esc_attr($ct_listing_expiration); ?>" />
                            <?php } ?>

                            <input type="hidden" name="submitted" id="submitted" value="true" />
                            <input type="submit" value="<?php esc_html_e('Submit Listing', 'contempo'); ?>" tabindex="5" id="submit" name="submit" class="btn" />
                        
                        </div>

                    </form>

                <?php } ?>

            <?php } ?>
            
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; endif; wp_reset_query(); ?>
            
                <div class="clear"></div>

        </article>
		
			<?php echo '<div class="clear"></div>';

echo '</div>';

get_footer(); ?>
