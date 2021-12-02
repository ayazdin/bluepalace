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


        /*$wpdb->query("delete p,pm from rs_posts p join rs_postmeta pm on pm.post_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("delete t from rs_term_relationships t join rs_posts p on t.object_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("ALTER TABLE rs_posts AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_postmeta AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_term_relationships AUTO_INCREMENT = 1500");*/


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
                $title = trim($allDataInSheet[$i]["X"]) . ' ' . trim($allDataInSheet[$i]["A"]);
                $description = trim($allDataInSheet[$i]["W"]);
                $added_date = $allDataInSheet[$i]['Z'];
                $update_date = $allDataInSheet[$i]['AA'];
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
                if (!empty($allDataInSheet[$i]["V"])) {
                    $image_url = trim($allDataInSheet[$i]["V"]);
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


                if (!add_post_meta($lastid, '_ct_price', trim($allDataInSheet[$i]["K"]), true)) {
                    update_post_meta($lastid, '_ct_price', trim($allDataInSheet[$i]["K"]));
                }

                if (!add_post_meta($lastid, '_ct_reference', trim($allDataInSheet[$i]["A"]), true)) {
                    update_post_meta($lastid, '_ct_reference', trim($allDataInSheet[$i]["A"]));
                }
                if (!add_post_meta($lastid, '_ct_sqft', trim($allDataInSheet[$i]["L"]), true)) {
                    $sqft = floor(trim($allDataInSheet[$i]["L"]));
                    update_post_meta($lastid, '_ct_sqft', $sqft);
                }

                if (!add_post_meta($lastid, '_ct_building', trim($allDataInSheet[$i]["E"]), true)) {
                    update_post_meta($lastid, '_ct_building', trim($allDataInSheet[$i]["E"]));
                }
                if (!add_post_meta($lastid, '_ct_purpose', trim($allDataInSheet[$i]["B"]), true)) {
                    update_post_meta($lastid, '_ct_purpose', trim($allDataInSheet[$i]["B"]));
                }
                if (!add_post_meta($lastid, '_ct_view', trim($allDataInSheet[$i]["M"]), true)) {
                    update_post_meta($lastid, '_ct_view', trim($allDataInSheet[$i]["M"]));
                }
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["T"])), 'agents', true);
                /*if (!add_post_meta($lastid, '_ct_agent_name', trim($allDataInSheet[$i]["P"]), true)) {
                    update_post_meta($lastid, '_ct_agent_name', trim($allDataInSheet[$i]["P"]));
                }
                if (!add_post_meta($lastid, '_ct_agent_number', trim($allDataInSheet[$i]["Q"]) . ' - ' . trim($allDataInSheet[$i]["R"]), true)) {
                    update_post_meta($lastid, '_ct_agent_number', trim($allDataInSheet[$i]["Q"]) . ' - ' . trim($allDataInSheet[$i]["R"]));
                }
                if (!add_post_meta($lastid, '_ct_agent_email', trim($allDataInSheet[$i]["S"]), true)) {
                    update_post_meta($lastid, '_ct_agent_email', trim($allDataInSheet[$i]["S"]));
                }*/
                if (!add_post_meta($lastid, '_ct_landlord', trim($allDataInSheet[$i]["P"]), true)) {
                    update_post_meta($lastid, '_ct_landlord', trim($allDataInSheet[$i]["P"]));
                }

                if (!add_post_meta($lastid, '_ct_listing_alt_title', $title, true)) {
                    update_post_meta($lastid, '_ct_listing_alt_title', $title);
                }

                if (!add_post_meta($lastid, '_ct_city', array(trim($allDataInSheet[$i]["C"])), true)) {
                    update_post_meta($lastid, '_ct_city', array(trim($allDataInSheet[$i]["C"])));
                }

                if (!add_post_meta($lastid, '_ct_community', array(trim($allDataInSheet[$i]["D"])), true)) {
                    update_post_meta($lastid, '_ct_community', array(trim($allDataInSheet[$i]["D"])));
                }

                /*if (!add_post_meta($lastid, '_ct_sub_community', array(trim($allDataInSheet[$i]["C"])), true)) {
                    update_post_meta($lastid, '_ct_sub_community', array(trim($allDataInSheet[$i]["C"])));
                }*/

                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["F"])), 'property_type', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["G"])), 'beds', true);
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'baths',true);
                /*if($value5['featured'] == 1){
                    wp_set_post_terms($lastid,array('featured'),'ct_status',true);
                }*/
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["U"])), 'ct_status', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["C"])), 'city', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["C"])), 'state', false);
                // wp_set_post_terms($lastid,array($value5['subcommunity']),'zipcode',false);
                // wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'country',false);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["D"])), 'community', true);
                wp_set_post_terms($lastid, array(trim($allDataInSheet[$i]["Y"])), 'category', true);

            }//for loop

            echo 'success';
        }
    }

    if (isset($_POST['downloadbutt'])) {
        $allargs = array(
            'posts_per_page' => -1,
            'post_type' => 'listings'
        );

        $the_query = new WP_Query($allargs);
        if ($the_query->have_posts()) { //if loop
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);

            define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

            date_default_timezone_set('Europe/London');

            /** Include PHPExcel */
            require_once 'Classes/PHPExcel.php';

            /** PHPExcel_Writer_Excel2007 */
            //include 'PHPExcel/Writer/Excel2007.php';

            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Blue Palace Realestate")
                ->setLastModifiedBy("Blue Palace Realestate")
                ->setTitle("Blue Palace Realestate")
                ->setSubject("Blue Palace Realestate")
                ->setDescription("Blue Palace Realestate")
                ->setKeywords("Blue Palace Realestate")
                ->setCategory("Blue Palace Realestate");

            $objPHPExcel->getActiveSheet()->setCellValue('A1', "REF : NO");
            $objPHPExcel->getActiveSheet()->setCellValue('B1', "Purpose");
            $objPHPExcel->getActiveSheet()->setCellValue('C1', "Location");
            $objPHPExcel->getActiveSheet()->setCellValue('D1', "Community");
            $objPHPExcel->getActiveSheet()->setCellValue('E1', "Building");
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "Type");
            $objPHPExcel->getActiveSheet()->setCellValue('G1', "Bedroom");
            $objPHPExcel->getActiveSheet()->setCellValue('H1', "Unit");
            $objPHPExcel->getActiveSheet()->setCellValue('I1', "Street/Floor");
            $objPHPExcel->getActiveSheet()->setCellValue('J1', "Area");
            $objPHPExcel->getActiveSheet()->setCellValue('K1', "Net Price");
            $objPHPExcel->getActiveSheet()->setCellValue('L1', "NP/sqft");
            $objPHPExcel->getActiveSheet()->setCellValue('M1', "View");
            $objPHPExcel->getActiveSheet()->setCellValue('N1', "Commision/Transfer");
            $objPHPExcel->getActiveSheet()->setCellValue('O1', "Updated Date");
            $objPHPExcel->getActiveSheet()->setCellValue('P1', "Landlord");
            $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Landlord Mobile");
            $objPHPExcel->getActiveSheet()->setCellValue('R1', "Landlord Landline");
            $objPHPExcel->getActiveSheet()->setCellValue('S1', "Landlord Email");
            $objPHPExcel->getActiveSheet()->setCellValue('T1', "Agent");
            $objPHPExcel->getActiveSheet()->setCellValue('U1', "Status");
            $objPHPExcel->getActiveSheet()->setCellValue('V1', "Images");

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("20");

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");

            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");

            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("25");

            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth("40");

            //while loop start
            $i = 2 ;
            while ( $the_query->have_posts() ){
                $the_query->the_post();
                $post_id = get_the_ID();

                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A' . $i, get_post_meta($post_id, "_ct_reference", true))
                    ->setCellValue('B' . $i, get_post_meta($post_id, "_ct_purpose", true))
                    ->setCellValue('C' . $i, strip_tags( get_the_term_list( $post_id, 'state', '', ', ', '' ) ))
                    ->setCellValue('D' . $i, strip_tags( get_the_term_list( $post_id, 'community', '', ', ', '' ) ))
                    ->setCellValue('E' . $i, get_post_meta($post_id, "_ct_building", true))
                    ->setCellValue('F' . $i, strip_tags( get_the_term_list( $post_id, 'property_type', '', ', ', '' ) ))
                    ->setCellValue('G' . $i, strip_tags( get_the_term_list( $post_id, 'beds', '', ', ', '' ) ))
                    ->setCellValue('H' . $i, '')
                    ->setCellValue('I' . $i, get_post_meta($post_id, "_ct_floorimages", true))
                    ->setCellValue('J' . $i, get_post_meta($post_id, "_ct_sqft", true))
                    ->setCellValue('K' . $i, get_post_meta($post_id, "_ct_price", true))
                    ->setCellValue('L' . $i, '')
                    ->setCellValue('M' . $i, get_post_meta($post_id, "_ct_view", true))
                    ->setCellValue('N' . $i, '')
                    ->setCellValue('O' . $i, '')
                    ->setCellValue('P' . $i, get_post_meta($post_id, "_ct_landlord", true))
                    ->setCellValue('Q' . $i, '')
                    ->setCellValue('R' . $i, '')
                    ->setCellValue('S' . $i, '')
                    ->setCellValue('T' . $i, strip_tags( get_the_term_list( $post_id, 'agents', '', ', ', '' ) ))
                    ->setCellValue('U' . $i, strip_tags( get_the_term_list( $post_id, 'ct_status', '', ', ', '' ) ))
                    ->setCellValue('V' . $i, '');

                $i++;
            }

            //while loop end


            wp_reset_postdata();
            $objPHPExcel->setActiveSheetIndex(0);
            $up = wp_upload_dir();
            // Save Excel 95 file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save(str_replace(__FILE__,$up['basedir'].'/export/bluepalace_listings.xls',__FILE__));

            $objOutput = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
            ob_start();
            $objOutput->save('php://output');
            $excelOutput = ob_get_clean();

            exit();
            //$file = 'bluepalace_listings.xls';


        }//if loop

    }

    if(isset($_POST['cleardata'])){
        global $wpdb;

        $wpdb->query("delete p,pm from rs_posts p join rs_postmeta pm on pm.post_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("delete t from rs_term_relationships t join rs_posts p on t.object_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("ALTER TABLE rs_posts AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_postmeta AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_term_relationships AUTO_INCREMENT = 1500");
    }
    ?>
    <div class="excelforms">
        <form action="" enctype="multipart/form-data" method="post" name="excelImportForm">
            <lbael>
                Upload Excel File
            </lbael>
            <br>
            <input type="file" name="excelfile" value="">
            <br>

            <input type="submit" name="btnSubmit" value="Upload">
            <input type="submit" name="cleardata" value="Clear Data">
            <!--<input type="submit" name="downloadbutt" value="Download">-->
        </form>
    </div>
<?php }