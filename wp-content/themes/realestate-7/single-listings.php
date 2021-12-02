<?php
/**
 * Single Listings Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;
$first_name = '';
$last_name = '';
$author_id = '';
$tagline = '';
$mobile = '';
$office = '';
$fax = '';
$email = '';
$ct_user_url = '';
$twitterhandle = '';
$facebookurl = '';
$linkedinurl = '';
$gplus = '';
$agentImage = '';

$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
$ct_listing_single_content_layout = isset( $ct_options['ct_listing_single_content_layout'] ) ? esc_html( $ct_options['ct_listing_single_content_layout'] ) : '';
$ct_listing_tools = isset( $ct_options['ct_listing_tools'] ) ? esc_html( $ct_options['ct_listing_tools'] ) : '';
$ct_listing_propinfo = isset( $ct_options['ct_listing_propinfo'] ) ? esc_html( $ct_options['ct_listing_propinfo'] ) : '';
$ct_listing_agent_info = isset( $ct_options['ct_listing_agent_info'] ) ? esc_html( $ct_options['ct_listing_agent_info'] ) : '';
$ct_listing_section_nav = isset( $ct_options['ct_listing_section_nav'] ) ? esc_html( $ct_options['ct_listing_section_nav'] ) : '';
$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
$ct_multi_floorplan = isset( $ct_options['ct_multi_floorplan'] ) ? esc_html( $ct_options['ct_multi_floorplan'] ) : '';
$ct_enable_yelp_nearby = isset( $ct_options['ct_enable_yelp_nearby'] ) ? esc_html( $ct_options['ct_enable_yelp_nearby'] ) : '';
$ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';
$ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? $ct_options['ct_listings_login_register'] : '';
$ct_disable_google_maps_listing = isset( $ct_options['ct_disable_google_maps_listing'] ) ? $ct_options['ct_disable_google_maps_listing'] : '';
$ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : ''; 
get_header();

if (!empty($_GET['search-listings'])) {
	get_template_part('search-listings');
	return;
}

$cat = get_the_category();

do_action('before_single_listing_header');

// Header
echo '<header id="title-header"';
if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
echo '>';
echo '<div class="container">';
echo '<div class="left">';
echo '<h5 class="marT0 marB0">';
esc_html_e('Listings', 'contempo');
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

<?php } 

do_action('before_single_listing_content'); ?>

<!-- Lead Carousel -->
<?php

if($ct_listing_single_layout == 'listings-two') {

    $listingslides = get_post_meta($post->ID, "_ct_slider", true);

    if(!empty($listingslides)) {
        // Grab Slider custom field images
        $imgattachments = get_post_meta($post->ID, "_ct_slider", true);
    } else {
        // Grab images attached to post via Add Media
        $imgattachments = get_children(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_parent' => $post->ID
                ));
    }
    //print_r($imgattachments);
    ?>

    <figure id="lead-carousel" <?php if(count($imgattachments) <= 1) { ?>class="single-image"<?php } ?>>
        <?php
        if(count($imgattachments) > 1) { ?>
        <div id="lrg-carousel" class="owl-carousel">
            <?php if(!empty($listingslides)) {
                ct_slider_field_images();
            } else {
                ct_slider_images();
            } ?>
        </div>
        <?php } else { ?>
        <?php ct_property_type_icon(); ?>
        <?php ct_fav_listing(); ?>
        <?php ct_first_image_lrg(); ?>
        <?php } ?>
    </figure>
    <!-- //Lead Carousel -->
    <?php } ?>

    <?php
    $referenceIDOfProperty = "";
    echo '<div class="container">';

    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $referenceIDOfProperty = get_post_meta($post->ID, "_ct_reference", true);
    /*----------------------------agent detail------------------------------*/
    $first_name = get_post_meta( $post->ID, '_ct_agent_name', 1 );
    $mobile = get_post_meta( $post->ID, '_ct_agent_number', 1 );
    $email = get_post_meta( $post->ID, '_ct_agent_email', 1 );
    $agentImage = get_post_meta( $post->ID, '_ct_agent_image', 1 );
    /*----------------------------agent detail------------------------------*/
    ?>

    <article class="col <?php if($ct_listing_single_content_layout == 'full-width') { echo 'span_12'; } else { echo 'span_9'; } ?> marB60">

        <?php if(!is_user_logged_in() && $ct_listings_login_register == 'yes') {

            echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';

        } else { ?>

        <!-- FPO Site name -->
        <h4 id="sitename-for-print-only">
           <?php bloginfo('name'); ?>
       </h4>

       <?php do_action('before_single_listing_location'); ?>

       <!-- Location -->
       <header class="listing-location">
        <div class="snipe-wrap">
            <?php
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if(is_plugin_active('co-authors-plus/co-authors-plus.php')) {
                if ( 2 == count( get_coauthors( get_the_id() ) ) ) { ?>
                <h6 class="snipe co-listing"><span><?php esc_html_e('Co-listing', 'contempo'); ?></span></h6>
                <?php }
            } ?>
            <?php ct_status(); ?>
            <div class="clear"></div>
        </div>
        <h2 class="marT5 marB0"><?php ct_listing_title(); ?></h2>
        <p class="location marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p>
    </header>

    <?php do_action('before_single_ct_listing_price'); ?>

    <!-- Price -->
    <h4 class="price marT0 marB0"> <?php ct_listing_price(); ?><span class="right">REF#: <?php echo $referenceIDOfProperty?></span></h4>

    <?php do_action('before_single_listing_propinfo'); ?>

    <?php if(empty($ct_listing_propinfo) || $ct_listing_propinfo == 'above') { ?>
    <!-- Listing Info -->
     
    <?php } ?>

    <!-- FPO First Image -->
    <figure id="first-image-for-print-only">
        <?php ct_first_image_lrg(); ?>
    </figure>

    <?php do_action('before_single_listing_lead_media'); ?>

    <!-- Lead Media -->
    <?php

            // if($ct_listing_single_layout != 'listings-two') {

    $listingslides = get_post_meta($post->ID, "_ct_slider", true);

    if(!empty($listingslides)) {
                    // Grab Slider custom field images
        $imgattachmen = get_post_meta($post->ID, "_ct_slider", true);
        $imgattachments = unserialize($imgattachmen);
                    // var_dump($imgattachments);
                    // die();
    } else {
                    // Grab images attached to post via Add Media
        $imgattachments = get_children(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_parent' => $post->ID
                ));
    }
    //print_r($imgattachments);
    ?>
    <figure id="lead-media" <?php if(count($imgattachments) <= 1) { ?>class="single-image"<?php } ?>>
        <?php

        if(count($imgattachments) > 1) { ?>
        <div id="slider" class="flexslider">
            <?php ct_property_type_icon(); ?>
            <?php ct_fav_listing(); ?>
            <ul class="slides">
                <?php if(!empty($listingslides)) {
                    ct_slider_field_images();
                } else {
                    ct_slider_images();
                } ?>
            </ul>
        </div>
        <div id="carousel" class="flexslider">
            <ul class="slides">
                <?php if(!empty($listingslides)) {
                    ct_slider_field_carousel_images();
                } else {
                    ct_slider_carousel_images();
                } ?>
            </ul>
        </div>
        <?php } else { ?>
        <?php ct_property_type_icon(); ?>
        <?php ct_fav_listing(); ?>
        <?php ct_first_image_lrg(); ?>
        <?php } ?>
    </figure>
    <ul class="propinfo marB0">
        <?php ct_propinfo(); ?>
        <?php if(get_post_meta($post->ID, "_ct_mls", true)) {
            echo '<li class="row propid">';
            echo '<span class="muted left">';
            _e('Property ID', 'contempo');
            echo '</span>';
            echo '<span class="right">';
            echo '#' . get_post_meta($post->ID, "_ct_mls", true);
            echo '</span>';
            echo '</li>';
        } ?>
    </ul> 
    <!-- //Listing Info --> 
    <!-- //Lead Media -->
    <?php //} ?>

    <?php if($ct_listing_propinfo == 'below') { ?>
    <!-- Listing Info -->
    <ul class="propinfo marB0">
        <?php ct_propinfo(); ?>
        <?php if(get_post_meta($post->ID, "_ct_mls", true)) {
            echo '<li class="row propid">';
            echo '<span class="muted left">';
            _e('Property ID', 'contempo');
            echo '</span>';
            echo '<span class="right">';
            echo '#' . get_post_meta($post->ID, "_ct_mls", true);
            echo '</span>';
            echo '</li>';
        } ?>
    </ul> 
    <!-- //Listing Info -->  
    <?php } ?>

    <?php if($ct_listing_section_nav != 'no') { ?>
    <nav id="listing-sections">
        <ul>
            <li class="listing-nav-icon"><i class="fa fa-navicon"></i></li>
            <?php
            $ct_additional_features = get_the_terms($post->ID, 'additional_features');
            if($ct_additional_features) { ?>
            <li><a href="#listing-features"><?php _e('Listing Features', 'contempo'); ?></a></li>
            <?php } ?>
            <?php
            $ct_floor_entries = get_post_meta( get_the_ID(), '_ct_multiplan', true );
            if($ct_multi_floorplan == 'yes' && $ct_floor_entries != '') { ?>
            <li><a href="#listing-plans"><?php _e('Floor Plans', 'contempo'); ?></a></li>
            <?php } ?>
            <?php
            $book_cal_shortcode = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
            if(!empty($book_cal_shortcode)) { ?>
            <li><a href="#listing-booking-form"><?php _e('Booking Form', 'contempo'); ?></a></li>
            <?php } ?>
            <?php
            $fileattachments = get_post_meta( get_the_ID(), '_ct_files', 1 );
            if(!empty($fileattachments)) { ?>
            <li><a href="#listing-attachments"><?php _e('Attachments', 'contempo'); ?></a></li>
            <?php } ?>
            <?php 
            $ct_video_url = get_post_meta($post->ID, "_ct_video", true);
            if(!empty($ct_video_url)) { ?>
            <li><a href="#listing-video"><?php _e('Video', 'contempo'); ?></a></li>
            <?php } ?>
            <?php 
            $ct_virtual_tour = get_post_meta($post->ID, "_ct_virtual_tour", true);
            if(!empty($ct_virtual_tour)) { ?>
            <li><a href="#listing-virtual-tour"><?php _e('Tour', 'contempo'); ?></a></li>
            <?php } ?>
            <!-- <li><a href="#location"><?php //_e('Location', 'contempo'); ?></a></li> -->
            <?php if($ct_enable_yelp_nearby == 'yes') { ?>
            <!-- <li><a href="#listing-nearby"><?php //_e('Nearby', 'contempo'); ?></a></li> -->
            <?php } ?>
            <?php
            if($ct_listing_reviews == 'yes') { ?>
            <li><a href="#listing-reviews"><?php _e('Reviews', 'contempo'); ?></a></li>
            <?php } ?>
            <?php if($ct_listing_agent_info != 'no') { ?>
            <li><a href="#listing-contact"><?php _e('Contact', 'contempo'); ?></a></li>
            <?php } ?>
        </ul>
    </nav>
    <?php } ?>

    <?php do_action('before_single_listing_content'); ?>

    <div class="post-content">

        <!-- Content -->
        <?php the_content(); ?>

        <?php
                /**$broker = new WP_Query(array(
                    'post_type' => 'brokerage',
                    'p' => get_post_meta( get_the_ID(), '_ct_brokerage', true ),
                    'nopaging' => true
                ));

                if ( $broker->have_posts() ) : while ( $broker->have_posts() ) : $broker->the_post(); ?>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php endwhile; endif; wp_reset_postdata(); **/?>

                <?php

                $ct_floor_entries = get_post_meta( get_the_ID(), '_ct_multiplan', true );

                if($ct_multi_floorplan == 'yes' && $ct_floor_entries != '') {

                    echo '<h4 id="listing-plans" class="border-bottom marB20">' . __('Floor Plans & Pricing', 'contempo') . '</h4>';

                    echo '<table>';

                    echo '<thead>';
                    echo '<th>';
                    echo __('Name', 'contempo');
                    echo '</th>';
                    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
                               // Dont display beds/baths
                    } else {
                       echo '<th>';
                       echo __('Beds', 'contempo');
                       echo '</th>';
                       echo '<th>';
                       echo __('Baths', 'contempo');
                       echo '</th>';
                   }
                   echo '<th>';
                   echo __('Size', 'contempo');
                   echo '</th>';
                   echo '<th>';
                   echo __('Price', 'contempo');
                   echo '</th>';
                   echo '<th>';
                   echo __('Availability', 'contempo');
                   echo '</th>';
                   echo '<th>';
                   echo __('', 'contempo');
                   echo '</th>';
                   echo '</thead>';

                   foreach ( (array) $ct_floor_entries as $key => $entry ) {

                    $ct_plan_img = $ct_plan_title = $ct_plan_beds = $ct_plan_baths = $ct_plan_size = $ct_plan_price = $ct_plan_desc = '';

                    if ( isset( $entry['_ct_plan_title'] ) )
                        $ct_plan_title = esc_html( $entry['_ct_plan_title'] );

                    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
                               // Dont display beds/baths
                    } else {
                        if ( isset( $entry['_ct_plan_beds'] ) )
                            $ct_plan_beds = esc_html( $entry['_ct_plan_beds'] );

                        if ( isset( $entry['_ct_plan_baths'] ) )
                            $ct_plan_baths = esc_html( $entry['_ct_plan_baths'] );
                    }

                    if ( isset( $entry['_ct_plan_size'] ) )
                        $ct_plan_size = esc_html( $entry['_ct_plan_size'] );

                    if ( isset( $entry['_ct_plan_price'] ) )
                        $ct_plan_price = esc_html( $entry['_ct_plan_price'] );
                    $ct_plan_price= preg_replace('/[\$,]/', '', $ct_plan_price);

                    if ( isset( $entry['_ct_plan_availability'] ) )
                        $ct_plan_availability = $entry['_ct_plan_availability'];

                    if ( isset( $entry['_ct_plan_image'] ) ) {
                        $ct_plan_image = $entry['_ct_plan_image'];
                    }

                    echo '<tr>';
                    echo '<td>';
                    if($ct_plan_image != '') {
                        echo '<a class="gallery-item" href="' . $ct_plan_image . '">';
                        echo $ct_plan_title;
                        echo '</a>';
                    } else {
                        echo $ct_plan_title;
                    }
                    echo '</td>';
                    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
                                   // Dont display beds/baths
                    } else {
                        echo '<td>';
                        echo $ct_plan_beds;
                        echo '</td>';
                        echo '<td>';
                        echo $ct_plan_baths;
                        echo '</td>';
                    }
                    echo '<td>';
                    echo $ct_plan_size;
                    echo '</td>';
                    echo '<td>';
                    ct_currency();
                    echo $ct_plan_price;
                    echo '</td>';
                    echo '<td>';
                    echo $ct_plan_availability;
                    echo '</td>';
                    if($ct_plan_image != '') {
                        echo '<td>';
                        echo '<a class="btn gallery-item" href="' . $ct_plan_image . '">';
                        echo __('View', 'contempo');
                        echo '</a>';
                        echo '</td>';
                    }
                    echo '</tr>';
                }

                echo '</table>';

            } ?>

            <?php 

            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if($ct_rentals_booking == 'yes') {

                $checkin = get_post_meta($post->ID, "_ct_rental_checkin", true);
                $checkout = get_post_meta($post->ID, "_ct_rental_checkout", true);

                if( !empty($checkin) || !empty($checkout) ) { ?>
                <!-- Info -->
                <ul class="propinfo marB0 pad0">
                    <?php ct_rental_info(); ?>
                </ul>
                <!-- //Info -->
                <?php } ?>

                <?php

                $extra_people = get_post_meta($post->ID, "_ct_rental_extra_people", true);
                $cleaning = get_post_meta($post->ID, "_ct_rental_cleaning", true);
                $cancellation = get_post_meta($post->ID, "_ct_rental_cancellation", true);
                $deposit = get_post_meta($post->ID, "_ct_rental_deposit", true);

                if( !empty($extra_people) || !empty($cleaning) || !empty($cancellation) || !empty($deposit) ) { ?>
                <!-- Costs & Fees -->
                <h5 class="marT20"><?php esc_html_e('Prices', 'contempo'); ?></h5>
                <ul class="propinfo marB0 pad0">
                    <?php ct_rental_costs(); ?>
                </ul>
                <!-- //Costs & Fees -->
                <?php }

            } ?>

            <?php do_action('before_single_listing_featlist'); ?>

            <!-- Feature List -->
            <?php
            $ct_additional_features = get_the_terms($post->ID, 'additional_features');
            if($ct_additional_features) { ?>
            <div id="listing-features">
                <?php addfeatlist(); ?>
            </div>
            <?php } ?>
            <!-- //Feature List -->

            <!-- Booking Calendar -->
            <?php 
            $book_cal_shortcode = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
            if(!empty($book_cal_shortcode)) {
                echo '<div id="listing-booking-form" class="booking-form-calendar">';
                echo '<h4 class="border-bottom marB18">' . __('Book this listing', 'contempo') . '</h4>';
                echo do_shortcode($book_cal_shortcode);
                echo '<div class="clear"></div>';
                echo '</div>';
            }
            ?>
            <!-- //Booking Calendar -->

            <?php do_action('before_single_listing_attachments'); ?>

            <!-- Listing Attachments -->
            <?php
            $fileattachments = get_post_meta( get_the_ID(), '_ct_files', 1 );

            if ($fileattachments) {
                echo '<div id="listing-attachments">';
                echo '<h4 class="border-bottom marB20">' .  __('Attachments', 'contempo') . '</h4>';
                echo '<ul class="attachments col span_4">';
                $count = 0;

                foreach ($fileattachments as $attachment_id => $attachment_url) {
                    $attachment_title =  get_the_title($attachment_id);
                    echo '<li>';
                    echo '<a href="' . $attachment_url . '" target="_blank">';
                    echo '<i class="fa fa-file-' . ct_get_mime_for_attachment($attachment_id) . '-o"></i>';
                    echo $attachment_title;
                    echo '</a>';
                    echo '</li>';
                    $count++;
                    if ($count == 3) {
                        echo '</ul><ul class="attachments col span_4">';
                        $count = 0;
                    }
                }
                echo '</ul>';
                echo '<div class="clear"></div>';
                echo '</div>';
            }
            ?>
            <!-- //Listing Attachments -->

            <?php do_action('before_single_listing_video'); ?>

            <!-- Video -->
            <?php
            $ct_video_url = get_post_meta($post->ID, "_ct_video", true);
            $ct_embed_code = wp_oembed_get( $ct_video_url, $args );
            if($ct_video_url) { ?>
            <div id="listing-video" class="videoplayer marB20">
                <h4 class="border-bottom marB20"><?php esc_html_e('Video', 'contempo'); ?></h4>
                <?php echo $ct_embed_code; ?>
            </div>       
            <?php } ?>
            <!-- //Video -->

            <!-- Virtual Tour -->
            <?php 
            $ct_virtual_tour = get_post_meta($post->ID, "_ct_virtual_tour", true);
            if(!empty($ct_virtual_tour)) { ?>
            <div id="listing-virtual-tour" class="marB20">
                <h4 class="border-bottom marB20"><?php esc_html_e('Virtual Tour', 'contempo'); ?></h4>
                <?php echo $ct_virtual_tour; ?>
            </div>
            <?php } ?>
            <!-- //Virtual Tour -->

            <?php do_action('before_single_listing_map'); ?>

            <!-- Map -->
            <?php if($ct_disable_google_maps_listing == 'no') { ?>
                <!-- <div id="location">
                    <h4 class="border-bottom marB18"><?php esc_html_e('Location', 'contempo'); ?></h4>
                    <?php ct_listing_map(); ?>
                </div>  --> 
                <?php } ?>
                <!-- //Map -->

                <!-- Nearby -->
                <?php

                if($ct_enable_yelp_nearby == 'yes') {

                    $ct_yelp_amenities = isset( $ct_options['ct_yelp_amenities']['enabled'] ) ? $ct_options['ct_yelp_amenities']['enabled'] : '';

                    echo '<div class="listing-nearby" id="listing-nearby">';
                    echo '<div class="right yelp-powered-by"><small class="muted left">' . __('powered by ', 'contempo') . '</small><img class="right yelp-logo" src="' . ct_theme_directory_uri() . '/images/yelp-logo-medium@2x.png" width="44" height="24" /></div>';
                    echo '<h4 class="border-bottom marB20">' . __('What\'s Nearby?', 'contempo') . '</h4>';

                    $ct_listing_street_address = get_the_title();
                    $ct_listing_city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
                    $ct_listing_state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
                    $ct_listing_zip = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );

                    $ct_listing_address = $ct_listing_street_address . ', ' . $ct_listing_city . ', ' . $ct_listing_state . ', ' . $ct_listing_zip;

                    if ($ct_yelp_amenities) :

                        foreach ($ct_yelp_amenities as $field=>$value) {

                            switch($field) {

                                    // Restaurant            
                                case 'restaurant' :

                                ct_query_yelp_api('restaurant', $ct_listing_address, 'fa-cutlery');

                                break;

                                    // Coffee Shops            
                                case 'coffee_shops' :

                                ct_query_yelp_api('coffee shop', $ct_listing_address, 'fa-coffee');

                                break;

                                    // Coffee Shops            
                                case 'grocery' :

                                ct_query_yelp_api('grocery', $ct_listing_address, 'fa-shopping-basket');

                                break;

                                    // Schools           
                                case 'schools' :

                                ct_query_yelp_api('schools', $ct_listing_address, 'fa-mortar-board');

                                break;

                                    // Banks           
                                case 'banks' :

                                ct_query_yelp_api('banks', $ct_listing_address, 'fa-bank');

                                break;

                                    // Bars           
                                case 'bars' :

                                ct_query_yelp_api('bars', $ct_listing_address, 'fa-beer');

                                break;

                                    // Bars           
                                case 'hospitals' :

                                ct_query_yelp_api('hospitals', $ct_listing_address, 'fa-hospital-o');

                                break;

                                    // Bars           
                                case 'gas_station' :

                                ct_query_yelp_api('gas stations', $ct_listing_address, 'fa-car');

                                break;

                            }

                        } endif;

                        echo '</div>';
                    }
                    ?>
                    <!-- // Nearby -->

                    <!-- Reviews -->
                    <?php

                    if($ct_listing_reviews == 'yes') {
                        echo '<div id="listing-reviews">';
                        echo '<h4 class="border-bottom marB18">';
                        comments_number( __('No Reviews', 'contempo'), __('1 Review', 'contempo'), __( '% Reviews', 'contempo') );
                        echo '</h4>';

                        comments_template();
                        echo '</div>';
                    } ?>
                    <!-- //Reviews -->
                </div>       

                <?php do_action('before_single_listing_agent'); ?>

                <?php if($ct_listing_agent_info != 'no') { ?>
                <!-- Agent Contact -->
                <div id="listing-contact" class="marb20 listing-agent-contact">
                    <div class="main-agent">
                       <?php 
                		/*$first_name = get_the_author_meta('first_name');
    					$last_name = get_the_author_meta('last_name');
    					$author_id = get_the_author_meta('ID');
    					$tagline = get_the_author_meta('tagline');
    					$mobile = get_the_author_meta('mobile');
    					$office = get_the_author_meta('office');
    					$fax = get_the_author_meta('fax');
    					$email = get_the_author_meta('email');
                        $ct_user_url = get_the_author_meta('user_url');
                        $twitterhandle = get_the_author_meta('twitterhandle');
                        $facebookurl = get_the_author_meta('facebookurl');
                        $linkedinurl = get_the_author_meta('linkedinurl');
                        $gplus = get_the_author_meta('gplus');*/
                        ?>
                        <h4 class="border-bottom marB20"><?php esc_html_e('Request More Information', 'contempo'); ?></h4>
                        <?php do_action('before_single_listing_agent_img'); ?>

                        <div class="col span_4 first agent-info">
                            <?php
                            echo '<figure class="col span_12 first row">';
                            // echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($author_id) . '">';
                            // var_dump(file_exists($agentImage));
                            echo '<a href="#">';
                            $file = $agentImage;
                            $file_headers = @get_headers($file);
                            if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
                              echo '<img class="authorimg" src="'.$agentImage.'" />';
                          } else {
                            echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                        }
                        echo '</a>';
                        echo '</figure>';
                        ?>

                        <?php do_action('before_single_listing_agent_details'); ?>

                        <div class="details col span_12 first row">	        
                         <ul class="marB0">
                         <li class="marT3 marB0 row"><span class="left">Name</span><span class="right"><?php echo esc_html($first_name); ?></span></li>
                         <li class="marT3 marB0 row"><span class="left">Phone</span><span class="right"><?php echo esc_html($mobile); ?></span></li>
                         <li class="marT3 marB0 row"><span class="left">Email</span><span class="right"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></span></li>
                         <!-- 
                             <?php if($mobile) { ?>
                             <li class="marT3 marB0 row"><span class="left"><i class="fa fa-phone"></i></span><span class="right"><?php echo esc_html($mobile); ?></span></li>
                             <?php } ?>
                             <?php if($office) { ?>
                             <li class="marT3 marB0 row"><span class="left"><i class="fa fa-building"></i></span><span class="right"><?php echo esc_html($office); ?></span></li>
                             <?php } ?>
                             <?php if($fax) { ?>
                             <li class="marT3 marB0 row"><span class="left"><i class="fa fa-print"></i></span><span class="right"><?php echo esc_html($fax); ?></span></li>
                             <?php } ?>
                             <?php if($email) { ?>
                             <li class="marT3 marB0 row"><span class="left"><i class="fa fa-envelope"></i></span><span class="right"><a href="mailto:<?php echo $email ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
                             <?php } ?>
                             <?php if($ct_user_url) {
                                $ct_user_url = trim($ct_user_url, '/');
                                    // If scheme not included, prepend it
                                if (!preg_match('#^http(s)?://#', $ct_user_url)) {
                                    $ct_user_url = 'http://' . $ct_user_url;
                                }

                                $ct_urlParts = parse_url($ct_user_url);

                                    // remove www
                                $ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
                                ?>
                                <li class="row"><span class="left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($curauth->user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
                                <?php } ?> -->
                            </ul>
                            <ul class="social marT15 marL0">
                                <?php if ($twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                    <?php if ($facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                    <?php if ($linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                    <?php if ($gplus) { ?><li class="google"><a href="<?php echo esc_url($gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                </ul>
                            </div>
                        </div>

                        <?php do_action('before_single_listing_agent_contact'); ?>

                        <div class="col span_8 agent-contact">
                           
                           <form id="listingscontact" class="formular" method="post">
                               <fieldset class="col span_12">
                                  <select id="ctsubject" name="ctsubject">
                                     <option><?php esc_html_e('Tell me more about this property', 'contempo'); ?></option>
                                     <option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
                                 </select>
                                 <div class="clear"></div>
                                 <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

                                 <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

                                 <input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

                                 <textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="6" cols="10"></textarea>

                                 <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($ct_email); ?>" />
                                 <input type="hidden" id="reference" name="reference" value="<?php echo $referenceIDOfProperty; ?>" />
                                 <input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
                                 <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

                                 <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
                             </fieldset>
                         </form>
                     </div>
                 </div>
                 <div class="clear"></div>

                 <?php
                 include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                 if(is_plugin_active('co-authors-plus/co-authors-plus.php')) {
                    if (count( get_coauthors(get_the_id())) >= 2) { ?>
                    <!-- Co Agent -->
                    <div class="co-list-agent col span_12 first marB20">
                        <h5 class="border-bottom marB20"><?php esc_html_e('Co-listing Agent', 'contempo'); ?></h5>
                        <?php

                        $coauthors = get_coauthors();

                            // Remove the first author/agent
                        array_shift($coauthors);

                        echo '<ul id="co-agent" class="marB0">';
                        foreach($coauthors as $coauthor) {
                            echo '<li class="agent">';
                            echo '<figure class="col span_3 first">';
                            echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($coauthor->ID) . '" title="' . esc_html($coauthor->display_name) .'">';
                            if($coauthor->ct_profile_url) {
                                echo '<img class="author-img" src="' . esc_html($coauthor->ct_profile_url) . '" />';
                            } else {
                               echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                           }
                           echo '</a>';
                           echo '</figure>';
                           echo '<div class="agent-info col span_9">';
                           echo '<h4 class="marT0 marB0">' . esc_html($coauthor->display_name) . '</h4>';
                           if ($coauthor->title) { 
                            echo '<h5 class="muted marB10">' . esc_html($coauthor->title) . '</h5>';
                        } ?>
                        <div class="agent-bio col span_8 first">
                         <?php if($coauthor->tagline) { ?>
                         <p class="tagline"><strong><?php echo esc_html($coauthor->tagline); ?></strong></p>
                         <?php } ?>
                         <ul class="col span_8 marT15 first">
                            <?php if($coauthor->mobile) { ?>
                            <li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($coauthor->mobile); ?></span></span></li>
                            <?php } ?>
                            <?php if($coauthor->office) { ?>
                            <li class="row"><span class="muted left"><i class="fa fa-building"></i></span> <span class="right"><?php echo esc_html($coauthor->office); ?></span></li>
                            <?php } ?>
                            <?php if($coauthor->fax) { ?>
                            <li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($coauthor->fax); ?></span></li>
                            <?php } ?>
                            <?php if($coauthor->user_email) { $email = $coauthor->user_email; ?>
                            <li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a href="mailto:<?php echo antispambot($email,1 ) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
                            <?php } ?>
                            <?php if($coauthor->user_url) {
                                $ct_coauthor_url = $coauthor->user_url;
                                $ct_coauthor_url = trim($ct_coauthor_url, '/');
                                                        // If scheme not included, prepend it
                                if (!preg_match('#^http(s)?://#', $ct_coauthor_url)) {
                                    $ct_coauthor_url = 'http://' . $ct_coauthor_url;
                                }

                                $ct_coauthor_urlParts = parse_url($ct_coauthor_url);

                                                        // remove www
                                $ct_coauthor_domain = preg_replace('/^www\./', '', $ct_coauthor_urlParts['host']);
                                ?>
                                <li class="row"><span class="left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($coauthor->user_url); ?>"><?php echo esc_html($ct_coauthor_domain); ?></a></span></li>
                                <?php } ?>
                                <?php if($coauthor->brokername) { ?><p class="marB3"><strong><?php echo esc_html($coauthor->brokername); ?></strong></p><?php } ?>
                                <?php if($coauthor->brokernum) { ?><p class="marB3"><?php echo esc_html($coauthor->brokernum); ?></p><?php } ?>
                            </ul>

                        </div>
                        <ul class="social">
                            <?php if ($coauthor->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_url($coauthor->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                <?php if ($coauthor->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($coauthor->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                <?php if ($coauthor->linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($coauthor->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                <?php if ($coauthor->gplus) { ?><li class="google"><a href="<?php echo esc_url($coauthor->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                            </ul>
                        </div>
                        <?php  echo '</li>';
                    }
                    echo '</ul>';
                    ?>
                </div>
                <div class="clear"></div>
                <!-- //Co Agent -->
                <?php }
            } ?>

        </div>
        <!-- //Agent Contact -->
        <?php } ?>

        <?php do_action('before_single_listing_brokerage'); ?>

        <!-- Brokerage -->
        <div id="listing-brokerage">
            <?php ct_brokered_by(); ?>
        </div>
        <!-- //Brokerage -->

        <?php do_action('before_single_listing_community'); ?>

        <?php
        $terms = $terms = get_the_terms( $post->id, 'community' );
        if ($terms) { ?>
        <!-- Sub Listings -->
        <div class="marb20 sub-listings">
           <h4 class="border-bottom marB20"><?php esc_html_e('Other Listings in Community', 'contempo'); ?></h4>
           <?php get_template_part('includes/sub-listings'); ?>
       </div>
       <!-- //Sub Listings -->
       <?php } ?>

       <?php } ?>

   <?php endwhile; endif; ?>

   <div class="clear"></div>

</article>

<?php do_action('before_single_listing_sidebar'); ?>

<?php if($ct_listing_single_content_layout != 'full-width') { ?>
<div id="sidebar" class="col span_3">
    <?php if (is_active_sidebar('listings-single-right')) {
        dynamic_sidebar('listings-single-right');
    } ?>
</div>
<?php } ?>

<?php do_action('after_single_listing_sidebar'); ?>

</div>

<?php get_footer(); ?>