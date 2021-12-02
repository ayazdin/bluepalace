<?php
/**
 * Template Name: Edit Listing
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

$query = new WP_Query(array('post_type' => 'listings', 'posts_per_page' =>'-1', 'post_status' => array('publish', 'pending', 'draft', 'private', 'trash') ) );

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
    
    if(isset($_GET['listings'])) {
        
        if($_GET['listings'] == $post->ID) {
            $current_post = $post->ID;

            $title = get_the_title();
            $alt_title = get_post_meta($current_post, '_ct_listing_alt_title', true);
            $content = get_the_content();
            $featuredImage = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
            $galleryImages = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

            $ct_price = get_post_meta($current_post, '_ct_price', true);
            $ct_price_prefix = get_post_meta($current_post, '_ct_price_prefix', true);
            $ct_price_postfix = get_post_meta($current_post, '_ct_price_postfix', true);
            $ct_sqft = get_post_meta($current_post, '_ct_sqft', true);
            $ct_video_url = get_post_meta($current_post, '_ct_video', true);
            $ct_mls = get_post_meta($current_post, '_ct_mls', true);
            $ct_latlng = get_post_meta($current_post, '_ct_latlng', true);

            // Rental Information
            $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
            $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php') && $ct_submit_rental_info == 'yes') {
                $ct_rental_guests = get_post_meta($current_post, '_ct_rental_guests', true);
                $ct_rental_min_stay = get_post_meta($current_post, '_ct_rental_min_stay', true);
                $ct_rental_checkin = get_post_meta($current_post, '_ct_rental_checkin', true);
                $ct_rental_checkout = get_post_meta($current_post, '_ct_rental_checkout', true);
                $ct_rental_extra_people = get_post_meta($current_post, '_ct_rental_extra_people', true);
                $ct_rental_cleaning = get_post_meta($current_post, '_ct_rental_cleaning', true);
                $ct_rental_cancellation = get_post_meta($current_post, '_ct_rental_cancellation', true);
                $ct_rental_deposit = get_post_meta($current_post, '_ct_rental_deposit', true);
            }

            $ct_property_type = strip_tags( get_the_term_list( $current_post, 'property_type', '', ', ', '' ) );
            $ct_status = strip_tags( get_the_term_list( $current_post, 'ct_status', '', ', ', '' ) );
            $ct_city = strip_tags( get_the_term_list( $current_post, 'city', '', ', ', '' ) );
            $ct_state = strip_tags( get_the_term_list( $current_post, 'state', '', ', ', '' ) );
            $ct_zip = strip_tags( get_the_term_list( $current_post, 'zipcode', '', ', ', '' ) );
            $ct_country = strip_tags( get_the_term_list( $current_post, 'country', '', ', ', '' ) );
            $ct_community = strip_tags( get_the_term_list( $current_post, 'community', '', ', ', '' ) );
            $ct_beds = strip_tags( get_the_term_list( $current_post, 'beds', '', ', ', '' ) );
            $ct_baths = strip_tags( get_the_term_list( $current_post, 'baths', '', ', ', '' ) );
            $ct_features = strip_tags( get_the_term_list( $current_post, 'additional_features', '', ', ', '' ) );
        }
    }

endwhile; endif;
wp_reset_query();

global $current_post;

$postTitleError = '';

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
    
    global $ct_options;

    $view = $ct_options['ct_view'];
    $ct_auto_publish = $ct_options['ct_auto_publish'];

    if(trim($_POST['postTitle']) === '') {
        $postTitleError = 'Please enter an address.';
        $hasError = true;
    } else {
        $postTitle = trim($_POST['postTitle']);
    }

    $post_information = array(
        'ID' => $current_post,
        'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
        'post_content' => esc_attr(strip_tags($_POST['postContent'])),
        'post-type' => 'listings',
        'post_status' => $ct_auto_publish
    );
	
    $post_id = wp_update_post($post_information);

    /*if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            $newupload = ct_insert_attachment($file,$post_id);
        }
    }*/

    if($post_id) {
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
        wp_set_post_terms($post_id,array($_POST['ct_status']),'ct_status',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCity']),'city',false);
        wp_set_post_terms($post_id,array($_POST['customTaxState']),'state',false);
        wp_set_post_terms($post_id,array($_POST['customTaxZip']),'zipcode',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCountry']),'country',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCommunity']),'community',false);
        wp_set_post_terms($post_id, $_POST['customTaxFeat'],'additional_features',false);
		
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

<!-- Listing Map -->
<script>
function setMapAddress(address) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { address : address }, function( results, status ) {
        if( status == google.maps.GeocoderStatus.OK ) {
            <?php  if((get_post_meta(get_the_ID(), "_ct_latlng", true))) { ?>
            var location = new google.maps.LatLng(<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>);
            <?php } else { ?>
            var location = results[0].geometry.location;
            <?php } ?>
            var options = {
                zoom: 15,
                center: location,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.<?php echo esc_html(strtoupper($ct_options['ct_contact_map_type'])); ?>, 
                streetViewControl: true,
                styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
            };
            var mymap = new google.maps.Map( document.getElementById( 'map' ), options );   
            var marker = new google.maps.Marker({
                map: mymap, 
                animation: google.maps.Animation.DROP,
                draggable: false,
                flat: true,
                <?php if($ct_property_type == 'Commercial') { ?>
                    icon: '<?php echo get_template_directory_uri(); ?>/images/map-pin-com.png',
                <?php } elseif($ct_property_type == 'Land') { ?>
                    icon: '<?php echo get_template_directory_uri(); ?>/images/map-pin-land.png',
                <?php } else { ?>   
                    icon: '<?php echo get_template_directory_uri(); ?>/images/map-pin-res.png',
                <?php } ?>
                <?php  if((get_post_meta(get_the_ID(), "_ct_latlng", true))) { ?>  
                position: new google.maps.LatLng(<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>)
                <?php } else { ?>
                position: results[0].geometry.location
                <?php } ?>
            });     
        }
    });
}
setMapAddress( "<?php echo esc_html($title); ?> <?php echo esc_html($ct_city); ?> <?php echo esc_html($ct_state); ?> <?php echo esc_html($ct_zip); ?>" );
</script>
<!-- //Listing Map -->

<div class="container">

        <article class="listing col span_12 first marB60">

            <?php if(!is_user_logged_in()) {
                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
            } else { ?>
            
    			<form action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">

                    <?php if ( $postTitleError != '' ) { ?>
                        <span class="error"><?php echo esc_html($postTitleError); ?></span>
                        <div class="clearfix"></div>
                    <?php } ?>

                    <div class="col span_6 first">

                        <div class="input-full-width">
                            <label><?php esc_html_e('Address', 'contempo'); ?></label>
                            <input type="text" name="postTitle" id="postTitle" value="<?php echo esc_attr($title); ?>"/>
                        </div>

                        <div class="input-full-width">
                            <label><?php esc_html_e('Alternate Title', 'contempo'); ?></label>
                            <input type="text" name="customMetaAltTitle" id="customMetaAltTitle" value="<?php echo esc_html($alt_title); ?>" placeholder="<?php esc_html_e('(e.g. Downtown Penthouse)', 'contempo'); ?>" />
                        </div>

                        <div class="col span_4 first">
                            <label><?php esc_html_e('Type', 'contempo'); ?></label>
                            <?php 
                                $taxonomy_name = 'property_type';
                                $name = strip_tags( get_the_term_list( $current_post, 'property_type', '', ', ', '' ) );
                            ?>
                            <select id="ct_property_type" name="ct_property_type">
                                <option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
                                <?php foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
                                    <?php if ($ct_property_type == $t->name) { $selected = 'selected="selected" '; } else { $selected = ''; } ?>
                                    <option <?php echo esc_html($selected); ?>value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('Status', 'contempo'); ?></label>
                            <?php 
                                $taxonomy_name = 'ct_status';
                                $name = strip_tags( get_the_term_list( $current_post, 'ct_status', '', ', ', '' ) );
                            ?>
                            <select id="ct_status" name="ct_status">
                                <option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
                                <?php foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
                                    <?php if ($ct_status == $t->name) { $selected = 'selected="selected" '; } else { $selected = ''; } ?>
                                    <option <?php echo esc_html($selected); ?>value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('Price', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                            <input type="text" name="customMetaPrice" id="customMetaPrice" value="<?php echo esc_html($ct_price); ?>" />
                        </div>

                            <div class="clear"></div>

                        <div class="col span_6 first">
                            <label><?php esc_html_e('Price Prefix', 'contempo'); ?><span class="muted"><?php esc_html_e(' (e.g. From, Call for price)', 'contempo'); ?></span></label>
                            <input type="text" name="customMetaPricePrefix" id="customMetaPricePrefix" value="<?php echo esc_html($ct_price_prefix); ?>" />
                        </div>

                        <div class="col span_6">
                            <label><?php esc_html_e('Price Postfix Text', 'contempo'); ?><span class="muted"><?php esc_html_e(' (e.g. /month, /week)', 'contempo'); ?></span></label>
                            <input type="text" name="customMetaPricePostfix" id="customMetaPricePostfix" value="<?php echo esc_html($ct_price_postfix); ?>" />
                        </div>

                            <div class="clear"></div>

                        <label><?php esc_html_e('Listing Description', 'contempo'); ?></label>
                        <textarea name="postContent" id="postContent" rows="8" cols="30">
                            <?php echo esc_html($content); ?>
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
                                    <input type="text" name="customMetaMaxGuests" id="customMetaMaxGuests" value="<?php echo esc_html($ct_rental_guests); ?>" />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Minimum Stay', 'contempo'); ?></label>
                                    <input type="text" name="customMetaMinStay" id="customMetaMinStay" value="<?php echo esc_html($ct_rental_min_stay); ?>" />
                                </div>

                                    <div class="clear"></div>

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Check In Time', 'contempo'); ?></label>
                                    <input type="text" name="customMetaCheckIn" id="customMetaCheckIn" value="<?php echo esc_html($ct_rental_checkin); ?>" />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Check Out Time', 'contempo'); ?></label>
                                    <input type="text" name="customMetaCheckOut" id="customMetaCheckOut" value="<?php echo esc_html($ct_rental_checkout); ?>" />
                                </div>

                                    <div class="clear"></div>

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Extra Person Charge', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="text" name="customMetaExtraPerson" id="customMetaExtraPerson" value="<?php echo esc_html($ct_rental_extra_people); ?>" />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Cleaning Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="text" name="customMetaCleaningFee" id="customMetaCleaningFee" value="<?php echo esc_html($ct_rental_cleaning); ?>" />
                                </div>

                                    <div class="clear"></div>

                                <div class="col span_6 first">
                                    <label><?php esc_html_e('Cancellation Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="text" name="customMetaCancellationFee" id="customMetaCancellationFee" value="<?php echo esc_html($ct_rental_cancellation); ?>" />
                                </div>

                                <div class="col span_6">
                                    <label><?php esc_html_e('Security Deposit', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="text" name="customMetaSecurityDeposit" id="customMetaSecurityDeposit" value="<?php echo esc_html($ct_rental_deposit); ?>" />
                                </div>

                                    <div class="clear"></div>

                            </div>
                        
                        <?php } ?>

                        <div class="left" style="display: none;">
                            <figure class="col span_3 first">
                                <img src="<?php echo esc_url($featuredImage); ?>" />
                            </figure>
                            <div class="col span_9">
                                <label><?php esc_html_e('Listing Featured Image', 'contempo'); ?></label>
                                <input type="file" name="featuredImage" id="featuredImage" />
                            </div>
                        </div>

                        <div class="1-left"> <!-- class="left" not needed here --> 
                            <div class="col span_12 first">
                            	<input type="hidden" id="nonce_rem" value="<?php echo wp_create_nonce( 'ct_delete_attachment_edit_'.$post->ID ); ?>" />
                            	<input type="hidden" id="nonce_feature" value="<?php echo wp_create_nonce( 'ct_set_attachment_featured_'.$post->ID ); ?>" />
                               <label><?php esc_html_e('Listing Images', 'contempo'); ?></label>
                                <?php
                                $featured_id=get_post_thumbnail_id($_GET['listings']);
    							if(is_object($featured_id)) $featured_id=0;
    							echo '<input type="hidden" id="featured_id" name="featured_id" value="'.$featured_id.'" />';
                                echo '<ul id="sortable" class="marT15 listing-images">';
                                if ($galleryImages) {
                                        $i = 0;
    									$position=get_post_meta($current_post, '_ct_images_position', true);
    									if($position==""){
    										foreach ($galleryImages as $photo) { ?>
    	                                        <li id="file-<?php echo esc_html($photo->ID); ?>" class="col span_4 first"><?php
    	                                            echo '<figure class="gallery-thumb">';
    	                                                echo '<span class="featured-img">';
    	                                                	echo '<a class="setImageFeatured" name="' . esc_html($photo->ID) .'" href="#"><i class="fa '.( $photo->ID == $featured_id ? 'fa-star' : 'fa-star-o').'"></i></a>';
    	                                                echo '</span>';
    	                                                echo '<span class="delete-img">';
    	                                                    echo '<a class="remImage" name="' . esc_html($photo->ID) .'" href="#"><i class="fa fa-trash-o"></i></a>';
    	                                                echo '</span>';
    	                                                echo '<img src="' . wp_get_attachment_url($photo->ID) . '" />';
    	                                                echo '<input type="hidden" name="att_id[]" id="att_id" value="' . esc_html($photo->ID) . '" />';
    	                                            echo '</figure>';
    	                                        echo '</li>';
    	                                        $i++;
    	                                    }
    									} else {
    										$position=explode(',',$position);
    	                                    foreach ($position as $pos) {
                                        	 	if($pos!="" && isset($galleryImages[$pos])){ unset($galleryImages[$pos]); }

                                        	 	$photo=wp_get_attachment_url($pos);
    											if($photo!=false){
                                        	 	?>
    	                                        <li id="file-<?php echo esc_html($pos); ?>" class="col span_4 first"><?php
    	                                            echo '<figure class="gallery-thumb">';
    	                                                echo '<span class="featured-img">';
    	                                                	echo '<a class="setImageFeatured" name="' . esc_html($pos) .'" href="#"><i class="fa '.( $pos == $featured_id ? 'fa-star' : 'fa-star-o').'"></i></a>';
    	                                                echo '</span>';
    	                                                echo '<span class="delete-img">';
    	                                                    echo '<a class="remImage" name="' . esc_html($pos) .'" href="#"><i class="fa fa-trash-o"></i></a>';
    	                                                echo '</span>';

    	                                                echo '<img src="' . $photo . '" />';
    	                                                echo '<input type="hidden" name="att_id[]" id="att_id" value="' . esc_html($pos) . '" />';
    	                                            echo '</figure>';
    	                                        echo '</li>';
    	                                        }
    	                                    }
                        					foreach ($galleryImages as $pos) {
                        					$photo=wp_get_attachment_url($pos);
                        					if($photo!=false){
                        					?>
                                            <li id="file-<?php echo esc_html($pos); ?>" class="col span_4 first"><?php
                                                echo '<figure class="gallery-thumb">';
                                                    echo '<span class="featured-img">';
                                                    	echo '<a class="setImageFeatured" name="' . esc_html($pos) .'" href="#"><i class="fa '.( $pos == $featured_id ? 'fa-star' : 'fa-star-o').'"></i></a>';
                                                    echo '</span>';
                                                    echo '<span class="delete-img">';
                                                        echo '<a class="remImage" name="' . esc_html($pos) .'" href="#"><i class="fa fa-trash-o"></i></a>';
                                                    echo '</span>';
                                                    echo '<img src="' . $photo . '" />';
                                                    echo '<input type="hidden" name="att_id[]" id="att_id" value="' . esc_html($pos) . '" />';
                                                echo '</figure>';
                                            echo '</li>';
                                            }
                                        }
                    				}
                                    
                                }
                                    echo '</ul>';
                                    echo '<div class="clear"></div>';
                                ?>
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
    						</div><!-- RF -->	
                            </div>
                        </div>

                    </div>

                    <div class="col span_6">

                        <div class="col span_4 first">
                            <label><?php esc_html_e('City', 'contempo'); ?></label>
                            <input type="text" name="customTaxCity" id="customTaxCity" value="<?php echo esc_attr($ct_city); ?>"/>
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('State', 'contempo'); ?></label>
                            <input type="text" name="customTaxState" id="customTaxState" value="<?php echo esc_attr($ct_state); ?>"/>
                        </div>

                        <div class="col span_4">
                            <label><?php ct_zip_or_post(); ?></label>
                            <input type="text" name="customTaxZip" id="customTaxZip" value="<?php echo esc_attr($ct_zip); ?>"/>
                        </div>

                        <div class="col span_6 first">
                            <label><?php esc_html_e('Country', 'contempo'); ?></label>
                            <input type="text" name="customTaxCountry" id="customTaxCountry" value="<?php echo esc_attr($ct_country); ?>"/>
                        </div>

                        <div class="col span_6">
                            <label><?php ct_community_neighborhood_or_district(); ?></label>
                            <input type="text" name="customTaxCommunity" id="customTaxCommunity" value="<?php echo esc_attr($ct_community); ?>"/>
                        </div>

                        <div class="col span_4 first">
                            <label><?php esc_html_e('Beds', 'contempo'); ?></label>
                            <input type="text" name="customTaxBeds" id="customTaxBeds" value="<?php echo esc_attr($ct_beds); ?>" />
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('Baths', 'contempo'); ?></label>
                            <input type="text" name="customTaxBaths" id="customTaxBaths" value="<?php echo esc_attr($ct_baths); ?>" />
                        </div>

                        <div class="col span_4">
                            <label><?php strtoupper(ct_sqftsqm()); ?></label>
                            <input type="text" name="customMetaSqFt" id="customMetaSqFt" value="<?php echo esc_attr($ct_sqft); ?>" />
                        </div>

                         <div class="col span_6 first">
                            <label><?php esc_html_e('Property ID', 'contempo'); ?></label>
                            <input type="text" name="customMetaMLS" id="customMetaMLS" value="<?php echo esc_attr($ct_mls); ?>" />
                        </div>

                        <div class="col span_6">
                            <label><?php esc_html_e('Video URL', 'contempo'); ?></label>
                            <input type="text" name="customMetaVideoURL" id="customMetaVideoURL" value="<?php echo esc_attr($ct_video_url); ?>" />
                        </div>

                            <div class="clear"></div>

                        <label><?php esc_html_e('Additional Features (comma separated)', 'contempo'); ?></label>
                        <textarea name="customTaxFeat" id="customTaxFeat" rows="8" cols="30">
                            <?php echo esc_html($ct_features); ?>
                        </textarea>

                        <div class="col span_12 first">
                            <input type="text" name="customMetaLatLng" id="customMetaLatLng"  placeholder="<?php esc_html_e('Latitude & Longitude (optional)', 'contempo'); ?>" value="<?php echo esc_attr($ct_latlng); ?>" />
                        </div>

                        <div id="map"></div>
                    </div>

                    <div class="col span_12 first marT40 listing-submit">

                        <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
                        <input type="hidden" name="submitted" id="submitted" value="true" />
                        <input type="submit" value="<?php esc_html_e('Update Listing', 'contempo'); ?>" tabindex="5" id="submit" name="submit" class="btn" />
                    
                    </div>

                </form>

            <?php } ?>
            
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; endif; wp_reset_query(); ?>
            
                <div class="clear"></div>

        </article>
		
			<?php echo '<div class="clear"></div>';

echo '</div>';

get_footer(); ?>
