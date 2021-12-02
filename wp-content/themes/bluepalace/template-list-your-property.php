<?php
    /**
     * Template Name: List Your Property
     *
     * @package    WP Pro Real Estate 7
     * @subpackage Template
     */

    // global $ct_options;

    // $ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
    // $ct_listing_single_content_layout = isset( $ct_options['ct_listing_single_content_layout'] ) ? esc_html( $ct_options['ct_listing_single_content_layout'] ) : '';
    // $ct_listing_tools = isset( $ct_options['ct_listing_tools'] ) ? esc_html( $ct_options['ct_listing_tools'] ) : '';
    // $ct_listing_propinfo = isset( $ct_options['ct_listing_propinfo'] ) ? esc_html( $ct_options['ct_listing_propinfo'] ) : '';
    // $ct_listing_agent_info = isset( $ct_options['ct_listing_agent_info'] ) ? esc_html( $ct_options['ct_listing_agent_info'] ) : '';
    // $ct_listing_section_nav = isset( $ct_options['ct_listing_section_nav'] ) ? esc_html( $ct_options['ct_listing_section_nav'] ) : '';
    // $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
    // $ct_multi_floorplan = isset( $ct_options['ct_multi_floorplan'] ) ? esc_html( $ct_options['ct_multi_floorplan'] ) : '';
    // $ct_enable_yelp_nearby = isset( $ct_options['ct_enable_yelp_nearby'] ) ? esc_html( $ct_options['ct_enable_yelp_nearby'] ) : '';
    // $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';
    // $ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? $ct_options['ct_listings_login_register'] : '';
    // $ct_disable_google_maps_listing = isset( $ct_options['ct_disable_google_maps_listing'] ) ? $ct_options['ct_disable_google_maps_listing'] : '';

    get_header();
    
    if (isset($_POST['submit'])) {
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
        }

        $secretKey = "6LfZ-icUAAAAABDifhce-yQnfaOqme5fLQdWqwwK";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
        $responseKeys = json_decode($response , TRUE);
        $errMsg;

        if(intval($responseKeys["success"]) !== 1) {
            $errMsg = '<h5 style="color:red;">Please fill the required field. Captcha is required</h5>';
        } else {
                $title = $_POST['title'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $phone_number = $_POST['phone_number'];
                $your_email = $_POST['your_email'];
                $look_to = $_POST['look_to'];
                $Property_Type = $_POST['Property_Type'];
                $city = $_POST['city'];
                $project = $_POST['project'];
                $sub_project = $_POST['sub-project'];
                $building = $_POST['building'];
                $unitno = $_POST['unitno'];
                $bedroom = $_POST['bedroom'];
                $furnish = $_POST['furnish'];
                $size = $_POST['size'];
                $sizem = $_POST['sizem'];
                $view = $_POST['view'];
                $bathroom = $_POST['bathroom'];
                $parking = $_POST['parking'];
                $Budget = $_POST['Budget'];
                $prmode = $_POST['prmode'];
                $ctyouremail=$_POST['ctyouremail'];
                // $tmp_name = $_FILES['filepc']['name'];
                //print_r($tmp_name);exit;
                if ((!empty($_FILES['filepc']['name']))) {
                    $mime_boundary = "==Multipart_Boundary_x" . md5(mt_rand()) . "x";
                    $mime_boundary1 = "==Multipart_Boundary_x" . md5(mt_rand()) . "x";
                    $tmp_name = $_FILES['filepc']['tmp_name'];
                    $tmp_name1 = $_FILES['filepc1']['tmp_name'];
                    $tmp_name2 = $_FILES['filepc2']['tmp_name'];
                    $tmp_name3 = $_FILES['filepc3']['tmp_name'];
                    $tmp_name4 = $_FILES['filepc4']['tmp_name'];
                    
                    $type = $_FILES['filepc']['type'];
                    $type1= $_FILES['filepc1']['type'];
                    $type2 = $_FILES['filepc']['type'];
                    $type3 = $_FILES['filepc']['type'];
                    $type4 = $_FILES['filepc']['type'];

                    $file_name = $_FILES['filepc']['name'];
                    $file_name1 = $_FILES['filepc1']['name'];
                    $file_name2 = $_FILES['filepc2']['name'];
                    $file_name3 = $_FILES['filepc3']['name'];
                    $file_name4 = $_FILES['filepc4']['name'];

                    $size = $_FILES['filepc']['size'];
                    $size1 = $_FILES['filepc1']['size'];
                    $size2 = $_FILES['filepc2']['size'];
                    $size3 = $_FILES['filepc3']['size'];
                    $size4 = $_FILES['filepc4']['size'];

                    // Check to make sure that it is an uploaded file and not a system file
                    if (is_uploaded_file($tmp_name)) {
                        // Now Open the file for a binary read
                        $file = fopen($tmp_name , 'rb');
                        // Now read the file content into a variable
                        $data = fread($file , filesize($tmp_name));
                        // close the file
                        fclose($file);
                        // Now we need to encode it and split it into acceptable length lines
                        $data = chunk_split(base64_encode($data));
                    }
                    if (is_uploaded_file($tmp_name1)) {
                        // Now Open the file for a binary read
                        $file1 = fopen($tmp_name1 , 'rb');
                        // Now read the file content into a variable
                        $data1 = fread($file1 , filesize($tmp_name1));
                        // close the file
                        fclose($file1);
                        // Now we need to encode it and split it into acceptable length lines
                        $data1 = chunk_split(base64_encode($data1));
                    }
                    if (is_uploaded_file($tmp_name2)) {
                        // Now Open the file for a binary read
                        $file2 = fopen($tmp_name2 , 'rb');
                        // Now read the file content into a variable
                        $data2 = fread($file2 , filesize($tmp_name2));
                        // close the file
                        fclose($file2);
                        // Now we need to encode it and split it into acceptable length lines
                        $data2 = chunk_split(base64_encode($data2));
                    }
                    if (is_uploaded_file($tmp_name3)) {
                        // Now Open the file for a binary read
                        $file3 = fopen($tmp_name3 , 'rb');
                        // Now read the file content into a variable
                        $data3 = fread($file3 , filesize($tmp_name3));
                        // close the file
                        fclose($file3);
                        // Now we need to encode it and split it into acceptable length lines
                        $data3 = chunk_split(base64_encode($data3));
                    }
                    if (is_uploaded_file($tmp_name44)) {
                        // Now Open the file for a binary read
                        $file4 = fopen($tmp_name4 , 'rb');
                        // Now read the file content into a variable
                        $data4 = fread($file4 , filesize($tmp_name4));
                        // close the file
                        fclose($file4);
                        // Now we need to encode it and split it into acceptable length lines
                        $data4 = chunk_split(base64_encode($data4));
                    }

                    $mybody = "This is a multi-part message in MIME format.\n\n" .
                        "--{$mime_boundary}\n" .
                        "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
                        "Content-Transfer-Encoding: 7bit\n\n" .
                        $mybody . "\n\n";

                    $headers = "From: $from\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed;\r\n" .
                        " boundary=\"{$mime_boundary}\"";

                    $mybody .=  "\n\n" .
                        "Title: $title" . "<br/>" .
                        "First name: $first_name" . "<br/>" .
                        "Last name: $last_name" . "<br/>" .
                        "Phone: $phone_number" . "<br/>" .
                        "Email: $your_email" . "<br/>" .
                        "Look to: $look_to" . "<br/>" .
                        "Property type: $Property_Type" . "<br/>" .
                        "City: $city" . "<br/>" .
                        "Project: $project" . "<br/>" .
                        "Sub project: $sub_project" . "<br/>" .
                        "Building: $building" . "<br/>" .
                        "Unit no.: $unitno" . "<br/>" .
                        "Bedroom: $bedroom" . "<br/>" .
                        "Furnish: $furnish" . "<br/>" .
                        "Size: $size" . "<br/>" .
                        "Sizem: $sizem" . "<br/>" .
                        "View: $view" . "<br/>" .
                        "Bathroom: $bathroom" . "<br/>" .
                        "Parking: $parking" . "<br/>" .
                        "Budget: $Budget" . "<br/>";
                    if((!empty($_FILES['filepc']['name']))) {
                        $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                            "Content-Type: {$type};\n" .
                            " name=\"{$file_name}\"\n" .
                            "Content-Transfer-Encoding: base64\n\n" .
                            $data . "\n\n";
                    }if((!empty($_FILES['filepc1']['name']))) {
                        $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                            "Content-Type: {$type1};\n" .
                            " name=\"{$file_name1}\"\n" .
                            "Content-Transfer-Encoding: base64\n\n" .
                            $data1 . "\n\n";
                    }if((!empty($_FILES['filepc2']['name']))) {
                        $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                            "Content-Type: {$type2};\n" .
                            " name=\"{$file_name2}\"\n" .
                            "Content-Transfer-Encoding: base64\n\n" .
                            $data2 . "\n\n";
                    }if((!empty($_FILES['filepc3']['name']))) {
                        $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                            "Content-Type: {$type3};\n" .
                            " name=\"{$file_name3}\"\n" .
                            "Content-Transfer-Encoding: base64\n\n" .
                            $data3 . "\n\n";
                    }if((!empty($_FILES['filepc4']['name']))) {
                        $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                            "Content-Type: {$type4};\n" .
                            " name=\"{$file_name4}\"\n" .
                            "Content-Transfer-Encoding: base64\n\n" .
                            $data4 . "\n\n";
                    }

                    $bodys .=   $mybody;

                    $subject = "Attachment";
                    $body =  $body . $bodys;
                    if(mail($adminemail , $subject , $body , $headers))
                        $successMsg = '<h5 style="color:green;">Sent successfully</h5>';
                } else {
                    $to = $ctyouremail;

                    //    $subject = $subject;
                    $subject = "from website";
                    $msg = "\n\n" .
                        "Title: $title" . "\n" .
                        "First name: $first_name" . "\n" .
                        "Last name: $last_name" . "\n" .
                        "Phone: $phone_number" . "\n" .
                        "Email: $your_email" . "\n" .
                        "Look to: $look_to" . "\n" .
                        "Property type: $Property_Type" . "\n" .
                        "City: $city" . "\n" .
                        "Project: $project" . "\n" .
                        "Sub project: $sub_project" . "\n" .
                        "Building: $building" . "\n" .
                        "Unit no.: $unitno" . "\n" .
                        "Bedroom: $bedroom" . "\n" .
                        "Furnish: $furnish" . "\n" .
                        "Size: $size" . "\n" .
                        "Sizem: $sizem" . "\n" .
                        "View: $view" . "\n" .
                        "Bathroom: $bathroom" . "\n" .
                        "Parking: $parking" . "\n" .
                        "Budget: $Budget" . "\n" .

                        "Prefered mode to contact: $prmode" . "\n";
                    $headers = "From:" . $your_email . " < " . $email . ">" . "\r\n";
                    $headers .= "Reply - To:" . $ct_email . "\r\n";
                    //$headers .= "Content-Disposition: attachment; filename=\"" . $attachments . "\"\r\n\r\n";
                    //$headers = "Bcc: someone@domain . com" . "\r\n";

                    mail($to , $subject , $msg ,$headers);
                    $successMsg = '<h5 style="color:green;">Sent successfully</h5>';
                    }
            }

    }
    if (!empty($_GET['search-listings'])) {
        get_template_part('search-listings');

        return;
    }

    $cat = get_the_category();

    do_action('before_single_listing_header');

    // Header
    echo '<header id="title-header"';
    if ($ct_listing_single_layout == 'listings-two') {
        echo 'class="marB0"';
    }
    echo '>';
    echo '<div class="container">';
//    echo '<div class="left">';
//    echo '<h5 class="marT0 marB0">';
//    esc_html_e('List Your Property' , 'contempo');
//    echo '</h5>';
//    echo '</div>';
    echo ct_breadcrumbs();
    echo '<div class="clear"></div>';
    echo '</div>';
    echo '</header>';
    echo '<h3 class=" pagetitle">';
            the_title();
    echo '</h3>';

    do_action('before_single_listing_content'); 


    if ($ct_listing_single_layout == 'listings-two') {

        $listingslides = get_post_meta($post->ID , "_ct_slider" , TRUE);

        if (!empty($listingslides)) {
            // Grab Slider custom field images
            $imgattachments = get_post_meta($post->ID , "_ct_slider" , TRUE);
        } else {
            // Grab images attached to post via Add Media
            /* $imgattachments = get_children(
                [
                    'post_type'      => 'attachment' ,
                    'post_mime_type' => 'image' ,
                    'post_parent'    => $post->ID
                ]); */
				
			$args = array(
					'post_type'      => 'attachment' ,
                    'post_mime_type' => 'image' ,
                    'post_parent'    => $post->ID
				);
			$imgattachments = get_children( $args );	
				
				
        }
        ?>

        <figure id="lead-carousel" <?php if (count($imgattachments) <= 1) { ?>class="single-image"<?php } ?>>
            <?php
                if (count($imgattachments) > 1) { ?>
                    <div id="lrg-carousel" class="owl-carousel">
                        <?php if (!empty($listingslides)) {
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

    if (have_posts()) : while (have_posts()) : the_post();
        $referenceIDOfProperty = get_post_meta($post->ID , "_ct_reference" , TRUE)
        ?>

        <article class="col <?php if ($ct_listing_single_content_layout == 'full-width') echo 'span_12'; else echo 'span_9'; ?> marB60">

            <?php if (!is_user_logged_in() && $ct_listings_login_register == 'yes') {

                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.' , 'contempo') . '</h4>';

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
                            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                            if (is_plugin_active('co-authors-plus/co-authors-plus.php')) {
                                if (2 == count(get_coauthors(get_the_id()))) { ?>
                                    <h6 class="snipe co-listing">
                                        <span><?php esc_html_e('Co-listing' , 'contempo'); ?></span></h6>
                                <?php }
                            } ?>
                        <?php ct_status(); ?>
                        <div class="clear"></div>
                    </div>
                    <?php if ($errMsg) {
                        echo $errMsg;
                    }
                        if ($successMsg) {
                            echo $successMsg;
                        }

                    ?>
                    <!-- <p class="location marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p> -->
                </header>
            <?php } ?>


            <?php get_template_part('list-your-property'); ?>
        </article>
    <?php endwhile; endif; ?>
<?php do_action('before_single_listing_sidebar'); ?>

<?php if ($ct_listing_single_content_layout != 'full-width') { ?>
    <div id="sidebar" class="col span_3">
        <?php if (is_active_sidebar('listings-single-right')) {
            dynamic_sidebar('listings-single-right');
        } ?>
    </div>
<?php } ?>

<?php do_action('after_single_listing_sidebar'); ?>
    </div>
    <!-- end of container -->
<?php get_footer(); ?>



