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

$ct_listing_single_layout = isset($ct_options['ct_listing_single_layout']) ? esc_html($ct_options['ct_listing_single_layout']) : '';
$ct_listing_single_content_layout = isset($ct_options['ct_listing_single_content_layout']) ? esc_html($ct_options['ct_listing_single_content_layout']) : '';
$ct_listing_tools = isset($ct_options['ct_listing_tools']) ? esc_html($ct_options['ct_listing_tools']) : '';
$ct_listing_propinfo = isset($ct_options['ct_listing_propinfo']) ? esc_html($ct_options['ct_listing_propinfo']) : '';
$ct_listing_agent_info = isset($ct_options['ct_listing_agent_info']) ? esc_html($ct_options['ct_listing_agent_info']) : '';
$ct_listing_section_nav = isset($ct_options['ct_listing_section_nav']) ? esc_html($ct_options['ct_listing_section_nav']) : '';
$ct_rentals_booking = isset($ct_options['ct_rentals_booking']) ? esc_html($ct_options['ct_rentals_booking']) : '';
$ct_multi_floorplan = isset($ct_options['ct_multi_floorplan']) ? esc_html($ct_options['ct_multi_floorplan']) : '';
$ct_enable_yelp_nearby = isset($ct_options['ct_enable_yelp_nearby']) ? esc_html($ct_options['ct_enable_yelp_nearby']) : '';
$ct_listing_reviews = isset($ct_options['ct_listing_reviews']) ? esc_html($ct_options['ct_listing_reviews']) : '';
$ct_listings_login_register = isset($ct_options['ct_listings_login_register']) ? $ct_options['ct_listings_login_register'] : '';
$ct_disable_google_maps_listing = isset($ct_options['ct_disable_google_maps_listing']) ? $ct_options['ct_disable_google_maps_listing'] : '';
$ct_email = isset($ct_options['ct_contact_email']) ? esc_attr($ct_options['ct_contact_email']) : '';


if (!empty($_GET['search-listings'])) {
    get_template_part('search-listings');
    return;
}

$cat = get_the_category();
global $ct_options;
$ct_email = isset($ct_options['ct_contact_email']) ? esc_attr($ct_options['ct_contact_email']) : '';
get_header();
do_action('before_single_listing_header'); ?>
<script>
    jQuery(window).load(function () {
        jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 210,
            itemMargin: 5,
            asNavFor: '#slider'
        });
        jQuery('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        });
    });
</script>
<?php // Header
echo '<header id="title-header">';
echo '<div class="container">';
/*echo '<div class="left">';
echo '<h5 class="marT0 marB0">';
esc_html_e('Projects', 'contempo');
echo '</h5>';
echo '</div>';*/
echo ct_breadcrumbs();
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';
do_action('before_single_listing_content'); ?>
<div class="container">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
        /*----------------------------agent detail------------------------------*/
        $projectPrice = get_post_meta($post->ID, 'contact_post_pricefrom_class', 1);
        $first_name = get_post_meta($post->ID, '_ct_agent_name', 1);
        $mobile = get_post_meta($post->ID, '_ct_agent_number', 1);
        $email = get_post_meta($post->ID, '_ct_agent_email', 1);
        $agentImage = get_post_meta($post->ID, '_ct_agent_image', 1);
        $agentDetails = get_post_meta($post->ID, 'agent_description', 1);
        /*----------------------------agent detail------------------------------*/
        ?>
        <article class="col <?php if ($ct_listing_single_content_layout == 'full-width') {
            echo 'span_12';
        } else {
            echo 'span_12';
        } ?> marB60">
            <?php
            if (!is_user_logged_in() && $ct_listings_login_register == 'yes') {

                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';

            }// if user logged in
            else { ?>
                <!-- FPO Site name -->
                <h4 id="sitename-for-print-only">
                    <?php bloginfo('name'); ?>
                </h4>
                <?php do_action('before_single_listing_location'); ?>

                <?php
                $listingslides = rwmb_meta('gallery', '', $post->ID);
                $featured_img = get_the_post_thumbnail_url($post->ID, 'full');
                $lis = '<li data-thumb="' . $featured_img . '">
                        <a href="' . $featured_img . '" class="gallery-item">
                            <img src="' . esc_url($featured_img) . '" title="' . get_the_title() . '" />
                        </a>
                    </li>';
                $lic = '<li data-thumb="' . $featured_img . '">
                <img src="' . esc_url($featured_img) . '" title="' . get_the_title() . '" />
            </li>';
                foreach ($listingslides as $ls) {
                    $imgattachments[] = $ls['url'];
                    $lis .= '<li data-thumb="' . $ls['url'] . '">
                    <a href="' . $ls['url'] . '" class="gallery-item">
                        <img src="' . esc_url($ls['url']) . '" title="' . get_the_title() . '" />
                    </a>
                </li>';
                    $lic .= '<li data-thumb="' . $ls['url'] . '" >
                    <img src="' . esc_url($ls['url']) . '" title="' . get_the_title() . '" />
                </li>';
                }
                ?>
                <figure id="lead-media" <?php if (count($imgattachments) <= 1) { ?>class="single-image"<?php } ?>>
                    <?php

                    if (count($imgattachments) > 1) { ?>
                        <div id="slider" class="flexslider">

                            <ul class="slides">
                                <?php echo $lis; ?>
                            </ul>

                        </div>
                    <?php } else { ?>
                        <?php //ct_property_type_icon(); ?>
                        <?php ct_fav_listing(); ?>
                        <?php ct_first_image_lrg(); ?>
                    <?php } ?>
                </figure>
                <?php do_action('before_single_listing_location'); ?>

                <!-- Location -->
                <header class="listing-location">
                    <div class="snipe-wrap">
                        <?php
                        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                        if (is_plugin_active('co-authors-plus/co-authors-plus.php')) {
                            if (2 == count(get_coauthors(get_the_id()))) { ?>
                                <h6 class="snipe co-listing"><span><?php esc_html_e('Co-listing', 'contempo'); ?></span>
                                </h6>
                            <?php }
                        } ?>
                        <?php ct_status(); ?>
                        <div class="clear"></div>
                    </div>
                    <h2 class="marT5 marB0"><?php ct_listing_title(); ?></h2>

                    <p class="location marB0"><?php echo get_post_meta($post->ID, 'contact_post_location_class', true); ?></p>
                </header>

                <?php do_action('before_single_ct_listing_price'); ?>

                <!-- Price -->
                <h4 class="price marT0 marB0"><span
                        class="listing-price">Price starts from: <?php echo $projectPrice; ?></span></h4>
                <style>
                    /*floor tab*/
                    ul.floorplan_tab {
                        list-style-type: none;
                        margin: 0;
                        padding: 0;
                        overflow: hidden;
                        border: 1px solid #ccc;
                        background-color: #f1f1f1;
                    }

                    /* Float the list items side by side */
                    /*ul.floorplan_tab li {float: left;}*/

                    /* Style the links inside the list items */
                    ul.floorplan_tab li a {
                        display: inline-block;
                        color: black;
                        text-align: center;
                        padding: 14px 16px;
                        text-decoration: none;
                        transition: 0.3s;
                        font-size: 17px;
                    }

                    /* Change background color of links on hover */
                    ul.floorplan_tab li a:hover, ul.floorplan_tab li a.active {
                        background-color: #8E9EAB;
                        width: 100%;
                    }

                    /* Create an active/current tablink class */

                    /* Style the tab content */
                    .floor_tabcontent {
                        display: none;
                        padding: 6px 12px;
                        border: 1px solid #ccc;
                        border-top: none;
                    }

                    .floorPlan .floortab {
                        width: 20%;
                        float: left;
                    }

                    .floorPlan .floorimg {
                        width: 80%;
                        float: right
                    }

                    /*easypayment styling*/
                    .easypayment ul {
                        padding: 10px 38px;
                    }

                    .easypayment ul li {
                        margin-bottom: 10px;
                        list-style-image: url('<?php echo get_template_directory_uri(); ?>/images/greentick.png');
                    }

                    /*easypayment styling*/
                </style>
                <?php
                $brochure = get_post_meta($post->ID, 'pdfDesc', true);
                $ct_additional_features = get_post_meta($post->ID, 'projects_floorplan');
                $brochurePDF = get_post_meta($post->ID, 'wp_custom_attachment', true);
                $masterPlan = get_post_meta($post->ID, 'wp_masterplan_image', true);
                $easypayment = get_post_meta($post->ID, 'easy_payment_plan', true);
//                $filesUpload = get_post_meta($post->ID,'filesUpload',true);
//                print_r($filesUpload);
                $agent_name = get_post_meta($post->ID, 'agent_name', true);
                $agent_email = get_post_meta($post->ID, 'agent_email', true);
                $agent_phone = get_post_meta($post->ID, 'agent_phone', true);
                $contact_location = get_post_meta($post->ID, 'contact_post_location_class', true);
                $floorplan1 = get_post_meta($post->ID, 'name', true);
                $floorplan2 = get_post_meta($post->ID, 'name2', true);
                $floorplan3 = get_post_meta($post->ID, 'name3', true);
                $floorplan4 = get_post_meta($post->ID, 'name4', true);
                $floorplan5 = get_post_meta($post->ID, 'name5', true);

                if (isset($_POST['submitbrocher'])) {
                    $title = $_POST['ctlistingtitle'];
                    $to = $_POST['youremail'];
                    $fromsite = get_bloginfo();
                    $from = $_POST['ctyouremail'];
                    $file = $brochurePDF['url'];
                    $msg = '<p>Here is your copy of brochure of "' . $title . '". <a href="' . $file . '">Click Here</a> to download.</p><br><p>If above link is not working, copy the url ' . $file . '</p>';

                    $headers = "From: $fromsite <$from>" . "\r\n" .
                        "Reply-To: $from" . "\r\n" .
                        "MIME-Version: 1.0" . "\r\n" .
                        "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                        "X-Mailer: PHP/" . phpversion();


                    if (mail($to, $subject, $msg, $headers)) {
                        $successMessage = "Mail successfuly send. Please check your email to get copy of your brochure. If you dont get any email, please check your spam.";
                    }
                    //$successMessage = "Mail successfuly send. Please check your email to get copy of your brochure";

                }
                ?>

                <?php do_action('before_single_listing_content'); ?>

                <div class="post-content">
                    <div id="project-content" class="tabcontent" style="display: block;">
                        <?php the_content(); ?>
                    </div>

                    <?php if (!empty($brochure)) { ?>
                        <div id="project-broucher" class="tabcontent">
                            <h4 class="border-bottom marB20">Brochure</h4>
                            <?php echo $brochure;
                            if (!empty($brochurePDF)) {
                                //echo '<a href="'.$brochurePDF['url'].'" class="btn">Download Brochure</a>';
                                echo '<div class="dwnbrocher"><a href="javascript:void(0)" onclick="showformbrocher()" class="btn ">Download Brochure</a></div>';
                                if (isset($successMessage)) {
                                    echo '<p>' . $successMessage . '</p>';
                                }
                                ?>
                                <div class="formbrocher hide">
                                    <form method="post" id="brocherform" class="formular">
                                        <input type="email" name="youremail" value="" placeholder="Email Address"
                                               required>
                                        <input type="hidden" id="ctyouremail" name="ctyouremail"
                                               value="<?php echo esc_attr($ct_email); ?>"/>
                                        <input type="hidden" id="ctlistingtitle" name="ctlistingtitle"
                                               value="<?php echo esc_attr(ct_listing_title()); ?>"/>
                                        <input type="submit" name="submitbrocher" value="Send" class="btn">
                                    </form>
                                </div>
                            <?php }

                            ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($floorplan1) || !empty($floorplan2) || !empty($floorplan3) || !empty($floorplan4) || !empty($floorplan5)) { ?>
                        <div id="project-floorplan" class="tabcontent">
                            <h4 class="border-bottom marB20">Floor Plan</h4>

                            <div class="floorPlan">
                                <div class="floortab">
                                    <ul class="floorplan_tab">
                                        <?php if (!empty($floorplan1)) { ?>
                                            <li><a href="javascript:void(0)" class="floor_tablinks active"
                                                   onclick="openfloor(event, 'floorplan1')"><?php echo $floorplan1; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($floorplan2)) { ?>
                                            <li><a href="javascript:void(0)" class="floor_tablinks "
                                                   onclick="openfloor(event, 'floorplan2')"><?php echo $floorplan2; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($floorplan3)) { ?>
                                            <li><a href="javascript:void(0)" class="floor_tablinks "
                                                   onclick="openfloor(event, 'floorplan3')"><?php echo $floorplan3; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($floorplan4)) { ?>
                                            <li><a href="javascript:void(0)" class="floor_tablinks "
                                                   onclick="openfloor(event, 'floorplan4')"><?php echo $floorplan4; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($floorplan5)) { ?>
                                            <li><a href="javascript:void(0)" class="floor_tablinks "
                                                   onclick="openfloor(event, 'floorplan5')"><?php echo $floorplan5; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="floorimg">

                                    <div id="floorplan1" class="floor_tabcontent" style="display: block;">
                                        <h3><?php echo $floorplan1; ?></h3>
                                        <figure id="floor_plan_1">
                                            <div id="floorplanslider" class="flexslider">
                                                <ul class="slides">
                                                    <?php
                                                    $filesUpload = rwmb_meta('filesUpload', '', $post->ID);
                                                    foreach ($filesUpload as $Filles) {
                                                        echo '<li data-thumb="' . $Filles['url'] . '">
                                                        <a href="' . $Filles['url'] . '" class="gallery-item floorplan-media" data-fancybox-group="filesUpload">
                                                            <img src="' . esc_url($Filles['url']) . '" title="' . get_the_title() . '" />
                                                        </a>
                                                    </li>';
                                                        // echo '<img src="'.esc_url($Filles['url']).'" title="'.get_the_title().'" />';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </figure>

                                    </div>
                                    <div id="floorplan2" class="floor_tabcontent">
                                        <h3><?php echo $floorplan2; ?></h3>
                                        <figure id="floor_plan_2">
                                            <div id="slider" class="flexslider">
                                                <ul class="slides">
                                                    <?php
                                                    $filesUpload2 = rwmb_meta('filesUpload2', '', $post->ID);
                                                    foreach ($filesUpload2 as $Filles2) {
                                                        echo '<li data-thumb="' . $Filles2['url'] . '">
                                                        <a href="' . $Filles2['url'] . '" class="gallery-item floorplan-media" data-fancybox-group="filesUpload2">
                                                            <img src="' . esc_url($Filles2['url']) . '" title="' . get_the_title() . '" />
                                                        </a>
                                                    </li>';
                                                        // echo '<img src="'.esc_url($Filles['url']).'" title="'.get_the_title().'" />';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </figure>
                                        <!--                          --><?php
                                        //                          $filesUpload2 = rwmb_meta( 'filesUpload2', '', $post->ID );
                                        //                            foreach($filesUpload2 as $Filles2){
                                        //                                echo '<img src="'.esc_url($Filles2['url']).'" title="'.get_the_title().'" />';
                                        //                            }
                                        //                          ?>
                                    </div>
                                    <div id="floorplan3" class="floor_tabcontent">
                                        <h3><?php echo $floorplan3; ?></h3>
                                        <figure id="floor_plan_3">
                                            <div id="slider" class="flexslider">
                                                <ul class="slides">
                                                    <?php
                                                    $filesUpload3 = rwmb_meta('filesUpload3', '', $post->ID);
                                                    foreach ($filesUpload3 as $Filles3) {
                                                        echo '<li data-thumb="' . $Filles3['url'] . '">
                                                        <a  href="' . $Filles3['url'] . '" class="gallery-item floorplan-media" data-fancybox-group="filesUpload3">
                                                            <img src="' . esc_url($Filles3['url']) . '" title="' . get_the_title() . '" />
                                                        </a>
                                                    </li>';
                                                        // echo '<img src="'.esc_url($Filles['url']).'" title="'.get_the_title().'" />';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </figure>

                                    </div>
                                    <div id="floorplan4" class="floor_tabcontent">
                                        <h3><?php echo $floorplan4; ?></h3>
                                        <figure id="floor_plan_4">
                                            <div id="slider" class="flexslider">
                                                <ul class="slides">
                                                    <?php
                                                    $filesUpload4 = rwmb_meta('filesUpload4', '', $post->ID);
                                                    foreach ($filesUpload4 as $Filles4) {
                                                        echo '<li data-thumb="' . $Filles4['url'] . '">
                                                        <a href="' . $Filles4['url'] . '" class="gallery-item floorplan-media" data-fancybox-group="filesUpload4">
                                                            <img src="' . esc_url($Filles4['url']) . '" title="' . get_the_title() . '" />
                                                        </a>
                                                    </li>';
                                                        // echo '<img src="'.esc_url($Filles['url']).'" title="'.get_the_title().'" />';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </figure>
                                    </div>
                                    <div id="floorplan5" class="floor_tabcontent">
                                        <h3><?php echo $floorplan5; ?></h3>
                                        <figure id="floor_plan_5">
                                            <div id="slider" class="flexslider">
                                                <ul class="slides">
                                                    <?php
                                                    $filesUpload5 = rwmb_meta('filesUpload5', '', $post->ID);
                                                    foreach ($filesUpload5 as $Filles5) {
                                                        echo '<li data-thumb="' . $Filles5['url'] . '">
                                                        <a href="' . $Filles5['url'] . '" class="gallery-item floorplan-media" data-fancybox-group="filesUpload5">
                                                            <img src="' . esc_url($Filles5['url']) . '" title="' . get_the_title() . '" />
                                                        </a>
                                                    </li>';
                                                        // echo '<img src="'.esc_url($Filles['url']).'" title="'.get_the_title().'" />';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </figure>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($masterPlan)) { ?>
                        <div id="project-masterplan" class="tabcontent">
                            <h4 class="border-bottom marB20">Master Plan</h4>

                            <div class="masterplan">
                                <a class="fancybox-media" href="<?php echo $masterPlan['url'] ?>"
                                   data-fancybox-group="gallery" title="Master Plan"><img
                                        src="<?php echo $masterPlan['url'] ?>" alt=""></a>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($easypayment)) { ?>
                        <div id="project-easypayment" class="tabcontent">
                            <h4 class="border-bottom marB20">Payment Plan</h4>

                            <div class="easypayment">
                                <ul>
                                    <?php //print_r($easypayment);
                                    foreach ($easypayment as $easy) {
                                        echo '<li>' . $easy['name'] . ' (' . $easy['easy_plan'] . ')</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php
                $terms = $terms = get_the_terms( $post->id, 'community' );
                if ($terms) { ?>
                    <!-- Sub Listings -->
                    <div class="marb20 sub-listings">
                        <h4 class="border-bottom marB20"><?php esc_html_e('Other Projects in Community', 'contempo'); ?></h4>
                        <?php get_template_part('includes/sub-projects'); ?>
                    </div>
                    <!-- //Sub Listings -->
                <?php } ?>

            <?php }//else user logged in
            ?>
            <div class="clear"></div>
        </article>
        <?php
    endwhile;
    endif;
    ?>
</div>
<script>
    function showformbrocher() {
        jQuery('.formbrocher').fadeIn(3000).removeClass('hide');
        jQuery('.dwnbrocher').fadeOut(3000).addClass('hide');

    }
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
    function openfloor(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("floor_tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("floor_tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script>
    jQuery(window).load(function () {
        var address = "<?php echo $contact_location;?>";
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({address: address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
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
                    <?php
                    $ct_gmap_style = isset( $ct_options['ct_google_maps_style'] ) ? $ct_options['ct_google_maps_style']: '';
                    if($ct_gmap_style != "default") { ?>
                    styles: [{
                        "featureType": "water",
                        "stylers": [{"visibility": "on"}, {"color": "#acbcc9"}]
                    }, {"featureType": "landscape", "stylers": [{"color": "#f2e5d4"}]}, {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{"color": "#c5c6c6"}]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [{"color": "#e4d7c6"}]
                    }, {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [{"color": "#fbfaf7"}]
                    }, {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [{"color": "#c5dac6"}]
                    }, {
                        "featureType": "administrative",
                        "stylers": [{"visibility": "on"}, {"lightness": 33}]
                    }, {"featureType": "road"}, {
                        "featureType": "poi.park",
                        "elementType": "labels",
                        "stylers": [{"visibility": "on"}, {"lightness": 20}]
                    }, {}, {"featureType": "road", "stylers": [{"lightness": 20}]}]
                    <?php } ?>
                };
                var mymap = new google.maps.Map(document.getElementById('map'), options);
                var marker = new google.maps.Marker({
                    map: mymap,
                    animation: google.maps.Animation.DROP,
                    draggable: false,
                    flat: true,
                    <?php if(ct_has_type('commercial')) { ?>
                    icon: '<?php echo ct_theme_directory_uri(); ?>/images/map-pin-com.png',
                    <?php } elseif(ct_has_type('land')) { ?>
                    icon: '<?php echo ct_theme_directory_uri(); ?>/images/map-pin-land.png',
                    <?php } else { ?>
                    icon: '<?php echo ct_theme_directory_uri(); ?>/images/map-pin-res.png',
                    <?php } ?>
                    <?php  if((get_post_meta(get_the_ID(), "_ct_latlng", true))) { ?>
                    position: new google.maps.LatLng(<?php echo get_post_meta(get_the_ID(), "_ct_latlng", true); ?>)
                    <?php } else { ?>
                    position: results[0].geometry.location
                    <?php } ?>
                });
            }
        });
    });


</script>
<?php get_footer(); ?>
