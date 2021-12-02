<?php
function excel_importer()
{
    add_menu_page('Excel Import', 'Excel Import', 'manage_options', 'excelImport', 'excelImport');
}

add_action('admin_menu', 'excel_importer');


function excelImport()
{
    echo '<h1>Import Excel</h1>';

    if (isset($_POST['btnSubmit'])) {

        global $wpdb;


        require_once 'Classes/PHPExcel.php';

        include 'Classes/PHPExcel/IOFactory.php';

        $file = $_FILES['excelfile']['tmp_name'];
        //echo $filename = $_FILES['excelfile']['name'];
        //$handle = fopen($file, "r");

        if ($file == NULL) {
            echo 'Please select a file to import';

        } else {
            try {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);

            for ($i = 2; $i <= $arrayCount; $i++) {
                $title = trim($allDataInSheet[$i]["A"]);
                $description = trim($allDataInSheet[$i]["C"]);
                $added_date = $allDataInSheet[$i]['U'];
                $update_date = $allDataInSheet[$i]['V'];
                if($update_date == '0000-00-00 00:00:00'){
                    $update_date = '2013-04-28 20:19:16';
                }
                if($added_date == '0000-00-00 00:00:00'){
                    $added_date = $update_date;
                }
                $my_post = array();
                $my_post = array(
                    'post_title' => wp_strip_all_tags($title),
                    'post_content' => $description,
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                    'menu_order' => '786',
                    'post_type' => 'listings',
                    'post_date' => $added_date,
                    'post_modified' => $update_date,
                ); //$my_post array

                $lastid = wp_insert_post($my_post);

                //feature image from external link
                if (!empty($allDataInSheet[$i]["D"])) {
                    $image_url = trim($allDataInSheet[$i]["D"]);
                    $end = end(explode('/', $image_url));
                    $image_name = $end;
                    $upload_dir = wp_upload_dir(); // Set upload folder
                    $image_data = file_get_contents($image_url); // Get image data
                    $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name); // Generate unique name
                    $filename = basename($unique_file_name); // Create image file name
                    // Check folder permission and define file location
                    if (wp_mkdir_p($upload_dir['path'])) {
                        $file = $upload_dir['path'] . '/' . $filename;
                    } else {
                        $file = $upload_dir['basedir'] . '/' . $filename;
                    }
                    // Create the image  file on the server
                    file_put_contents($file, $image_data);

                    // Check image file type
                    $wp_filetype = wp_check_filetype($filename, null);

                    // Set attachment data
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title' => sanitize_file_name($filename),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    // Create the attachment
                    $attach_id = wp_insert_attachment($attachment, $file, $lastid);

                    // Include image.php
                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                    // Define attachment metadata
                    $attach_data = wp_generate_attachment_metadata($attach_id, $file);

                    // Assign metadata to attachment
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    // And finally assign featured image to post
                    set_post_thumbnail($lastid, $attach_id);
                }

                //feature image from external link


                if (!add_post_meta($lastid, '_ct_price', trim($allDataInSheet[$i]["E"]), true)) {
                    update_post_meta($lastid, '_ct_price', trim($allDataInSheet[$i]["E"]));
                }

                if (!add_post_meta($lastid, '_ct_reference', trim($allDataInSheet[$i]["B"]), true)) {
                    update_post_meta($lastid, '_ct_reference', trim($allDataInSheet[$i]["B"]));
                }
                if (!add_post_meta($lastid, '_ct_sqft', trim($allDataInSheet[$i]["F"]), true)) {
                    $sqft = floor(trim($allDataInSheet[$i]["F"]));
                    update_post_meta($lastid, '_ct_sqft', $sqft);
                }

                if (!add_post_meta($lastid, '_ct_building', trim($allDataInSheet[$i]["L"]), true)) {
                    update_post_meta($lastid, '_ct_building', trim($allDataInSheet[$i]["L"]));
                }
                if (!add_post_meta($lastid, '_ct_purpose', trim($allDataInSheet[$i]["G"]), true)) {
                    update_post_meta($lastid, '_ct_purpose', trim($allDataInSheet[$i]["G"]));
                }
                if (!add_post_meta($lastid, '_ct_view', trim($allDataInSheet[$i]["M"]), true)) {
                    update_post_meta($lastid, '_ct_view', trim($allDataInSheet[$i]["M"]));
                }
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["P"])), 'agents', true);
                /*if (!add_post_meta($lastid, '_ct_agent_name', trim($allDataInSheet[$i]["P"]), true)) {
                    update_post_meta($lastid, '_ct_agent_name', trim($allDataInSheet[$i]["P"]));
                }
                if (!add_post_meta($lastid, '_ct_agent_number', trim($allDataInSheet[$i]["Q"]) . ' - ' . trim($allDataInSheet[$i]["R"]), true)) {
                    update_post_meta($lastid, '_ct_agent_number', trim($allDataInSheet[$i]["Q"]) . ' - ' . trim($allDataInSheet[$i]["R"]));
                }
                if (!add_post_meta($lastid, '_ct_agent_email', trim($allDataInSheet[$i]["S"]), true)) {
                    update_post_meta($lastid, '_ct_agent_email', trim($allDataInSheet[$i]["S"]));
                }*/
                if (!add_post_meta($lastid, '_ct_landlord', trim($allDataInSheet[$i]["O"]), true)) {
                    update_post_meta($lastid, '_ct_landlord', trim($allDataInSheet[$i]["O"]));
                }

                if (!add_post_meta($lastid, '_ct_listing_alt_title', $title, true)) {
                    update_post_meta($lastid, '_ct_listing_alt_title', $title);
                }

                if (!add_post_meta($lastid, '_ct_city', array(trim($allDataInSheet[$i]["I"])), true)) {
                    update_post_meta($lastid, '_ct_city', array(trim($allDataInSheet[$i]["I"])));
                }

                if (!add_post_meta($lastid, '_ct_community', array(trim($allDataInSheet[$i]["J"])), true)) {
                    update_post_meta($lastid, '_ct_community', array(trim($allDataInSheet[$i]["J"])));
                }

                if (!add_post_meta($lastid, '_ct_sub_community', array(trim($allDataInSheet[$i]["K"])), true)) {
                    update_post_meta($lastid, '_ct_sub_community', array(trim($allDataInSheet[$i]["K"])));
                }

                if (!add_post_meta($lastid, '_ct_featured', 0 , true)) {
                    update_post_meta($lastid, '_ct_featured', 0);
                }

                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["Q"])), 'property_type', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["R"])), 'beds', true);
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'baths',true);
                /*if($value5['featured'] == 1){
                    wp_set_post_terms($lastid,array('featured'),'ct_status',true);
                }*/
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["T"])), 'ct_status', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["I"])), 'city', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["I"])), 'state', false);
                // wp_set_post_terms($lastid,array($value5['subcommunity']),'zipcode',false);
                // wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'country',false);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["J"])), 'community', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["K"])), 'category', true);

            }//for loop

            echo 'success';
        }
    }

    if(isset($_POST['cleardata'])){
        global $wpdb;

        $wpdb->query("delete p,pm from rs_posts p join rs_postmeta pm on pm.post_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("delete t from rs_term_relationships t join rs_posts p on t.object_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("ALTER TABLE rs_posts AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_postmeta AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_term_relationships AUTO_INCREMENT = 1500");

        echo 'All Data Cleared';
    }



    if(isset($_POST['buildingsubmit'])){
        global $wpdb;


        require_once 'Classes/PHPExcel.php';

        include 'Classes/PHPExcel/IOFactory.php';

        $file1 = $_FILES['buildingfile']['tmp_name'];

        if ($file1 == NULL) {
            echo 'Please select a file to import';

        } else {
            try {
                $objPHPExcel = PHPExcel_IOFactory::load($file1);
            } catch (Exception $ef) {
                die('Error loading file "' . pathinfo($file1, PATHINFO_BASENAME) . '": ' . $ef->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);
            for ($b = 2; $b <= $arrayCount; $b++) {
                $refno = trim($allDataInSheet[$b]["A"]);
                $community = trim($allDataInSheet[$b]["B"]);
                $building= trim($allDataInSheet[$b]["C"]);

                $results = $wpdb->get_results( "select post_id from $wpdb->postmeta where meta_value = '$refno' and meta_key='_ct_reference' " );
                $postId = $results[0]->post_id;

                if(isset($postId)){

                        //update_post_meta($postId, '_ct_community', array($community));
                    update_post_meta($postId, '_ct_community', $community);
                    wp_set_post_terms($postId, array($community), 'community', true);
                       // update_post_meta($postId, '_ct_building', array($building));
                    update_post_meta($postId, '_ct_building', $building);
                }
            }

        }
        echo 'Building added successfully';
    }
    ?>
    <div class="excelforms">
        <form action="" enctype="multipart/form-data" method="post" name="excelImportForm">
            <label>
                Upload Excel File
            </label>
            <br>
            <input type="file" name="excelfile" value="">
            <br>

            <input type="submit" name="btnSubmit" value="Upload">
            <input type="submit" name="cleardata" value="Clear Data">
            <!--<input type="submit" name="downloadbutt" value="Download">-->
        </form>
    </div>


    <div class="buildingform" style="margin-top:30px">
        <form action="" enctype="multipart/form-data" method="post" name="buildingImportForm">
            <label for="">
                Upload Excel file for building
            </label>
            <br>
            <input type="file" name="buildingfile" value="">
            <br>
            <input type="submit" name="buildingsubmit" value="Upload Building">
        </form>
    </div>
<?php }