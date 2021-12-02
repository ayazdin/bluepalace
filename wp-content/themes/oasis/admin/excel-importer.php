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
        echo 'success';

        $wpdb->query("delete p,pm from rs_posts p join rs_postmeta pm on pm.post_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("delete t from rs_term_relationships t join rs_posts p on t.object_id = p.id where p.post_type = 'listings' and p.menu_order = '786'");
        $wpdb->query("ALTER TABLE rs_posts AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_postmeta AUTO_INCREMENT = 1500");
        $wpdb->query("ALTER TABLE rs_term_relationships AUTO_INCREMENT = 1500");


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
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            $arrayCount = count($allDataInSheet);

            for($i=2;$i<=$arrayCount;$i++){
                 $title = trim($allDataInSheet[$i]["E"]).' '.trim($allDataInSheet[$i]["A"]);
                $description = trim($allDataInSheet[$i]["E"]).'<br>'.trim($allDataInSheet[$i]["D"]).'<br>'.trim($allDataInSheet[$i]["C"]);

                $my_post = array();
                $my_post = array(
                    'post_title'    => wp_strip_all_tags( $title ),
                    'post_content'  => $description,
                    'post_status'   => 'publish',
                    'post_author'   => get_current_user_id(),
                    'menu_order'   => '786',
                    'post_type'   => 'listings'
                ); //$my_post array

                $lastid = wp_insert_post($my_post);

                if ( ! add_post_meta( $lastid, '_ct_price', trim($allDataInSheet[$i]["K"]), true ) ) {
                    update_post_meta ( $lastid, '_ct_price', trim($allDataInSheet[$i]["K"]) );
                }

                if ( ! add_post_meta( $lastid, '_ct_reference', trim($allDataInSheet[$i]["A"]), true ) ) {
                    update_post_meta ( $lastid, '_ct_reference', trim($allDataInSheet[$i]["A"]) );
                }
                if ( ! add_post_meta( $lastid, '_ct_sqft', trim($allDataInSheet[$i]["L"]), true ) ) {
                    $sqft = floor( trim($allDataInSheet[$i]["L"]) );
                    update_post_meta ( $lastid, '_ct_sqft', $sqft );
                }

                if ( ! add_post_meta( $lastid, '_ct_building', trim($allDataInSheet[$i]["E"]) , true ) ) {
                    update_post_meta ( $lastid, '_ct_building', trim($allDataInSheet[$i]["E"]) );
                }
                if ( ! add_post_meta( $lastid, '_ct_purpose', trim($allDataInSheet[$i]["B"]) , true ) ) {
                    update_post_meta ( $lastid, '_ct_purpose', trim($allDataInSheet[$i]["B"]) );
                }
                if ( ! add_post_meta( $lastid, '_ct_view', trim($allDataInSheet[$i]["M"]) , true ) ) {
                    update_post_meta ( $lastid, '_ct_view', trim($allDataInSheet[$i]["M"]) );
                }

                if ( ! add_post_meta( $lastid, '_ct_agent_name', trim($allDataInSheet[$i]["P"]) , true ) ) {
                    update_post_meta ( $lastid, '_ct_agent_name', trim($allDataInSheet[$i]["P"]) );
                }
                if ( ! add_post_meta( $lastid, '_ct_agent_number', trim($allDataInSheet[$i]["Q"]).' - '.trim($allDataInSheet[$i]["R"]) , true ) ) {
                    update_post_meta ( $lastid, '_ct_agent_number', trim($allDataInSheet[$i]["Q"]).' - '.trim($allDataInSheet[$i]["R"]) );
                }
                if ( ! add_post_meta( $lastid, '_ct_agent_email', trim($allDataInSheet[$i]["S"]) , true ) ) {
                    update_post_meta ( $lastid, '_ct_agent_email', trim($allDataInSheet[$i]["S"]) );
                }

                if ( ! add_post_meta( $lastid, '_ct_listing_alt_title', $title , true ) ) {
                    update_post_meta ( $lastid, '_ct_listing_alt_title', $title );
                }

                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["F"])),'property_type',true);
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["G"])),'beds',true);
               // wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'baths',true);
                /*if($value5['featured'] == 1){
                    wp_set_post_terms($lastid,array('featured'),'ct_status',true);
                }*/
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["U"])),'ct_status',true);
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'city',true);
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["C"])),'state',false);
                // wp_set_post_terms($lastid,array($value5['subcommunity']),'zipcode',false);
               // wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["S"])),'country',false);
                wp_set_post_terms($lastid,array(trim($allDataInSheet[$i]["D"])),'community',true);

            }//for loop
        }
    }
    ?>
    <div class="excelforms" >
        <form action="" enctype="multipart/form-data" method="post" name="excelImportForm">
            <lbael>
                Upload Excel File
            </lbael>
            <br>
            <input type="file" name="excelfile" value="">
            <br>

            <input type="submit" name="btnSubmit" value="Upload">
        </form>
    </div>
<?php }